<?php
// app/Http/Controllers/Warga/AnakController.php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnakRequest;
use App\Models\Anak;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnakController extends Controller
{
    /**
     * Pastikan warga milik user yang login.
     */
    private function getWarga(): Warga
    {
        $warga = Auth::user()->warga;

        if (!$warga) {
            abort(404, 'Data warga tidak ditemukan.');
        }

        return $warga;
    }

    /**
     * Tampilkan daftar anak milik warga.
     * Diakses dari halaman Profil → Data Anak.
     */
    public function index()
    {
        $warga = $this->getWarga();
        $anak  = $warga->anak()->orderBy('tanggal_lahir', 'asc')->get();

        return view('warga.anak.index', compact('warga', 'anak'));
    }

    /**
     * Form tambah anak baru.
     */
    public function create()
    {
        $warga = $this->getWarga();

        return view('warga.anak.create', compact('warga'));
    }

    /**
     * Simpan anak baru ke database.
     */
    public function store(AnakRequest $request)
    {
        $warga = $this->getWarga();
        $anak = $warga->anak()->create($request->validated());

        // Auto-sync ke tabel Balita jika masuk kategori balita
        if ($anak->is_balita) {
            \App\Models\Balita::firstOrCreate([
                'warga_id'      => $warga->id,
                'nama'          => $anak->nama,
            ], [
                'nik'           => $anak->nik,
                'tanggal_lahir' => $anak->tanggal_lahir,
                'jenis_kelamin' => $anak->jenis_kelamin,
                'is_verified'   => false,
            ]);
        }

        return redirect()
            ->route('profile.index')
            ->with('success', 'Data anak berhasil ditambahkan.');
    }

    /**
     * Form edit data anak.
     */
    public function edit(Anak $anak)
    {
        $warga = $this->getWarga();

        // Pastikan anak milik warga yang login
        abort_if($anak->warga_id !== $warga->id, 403, 'Akses ditolak.');

        return view('warga.anak.edit', compact('warga', 'anak'));
    }

    /**
     * Update data anak.
     */
    public function update(AnakRequest $request, Anak $anak)
    {
        $warga = $this->getWarga();
        abort_if($anak->warga_id !== $warga->id, 403, 'Akses ditolak.');

        $oldNama = $anak->getOriginal('nama');
        $anak->update($request->validated());

        // Auto-sync update ke tabel Balita
        $balita = \App\Models\Balita::where('warga_id', $warga->id)->where('nama', $oldNama)->first();
        if ($balita) {
            $balita->update([
                'nama'          => $anak->nama,
                'nik'           => $anak->nik ?? $balita->nik,
                'tanggal_lahir' => $anak->tanggal_lahir,
                'jenis_kelamin' => $anak->jenis_kelamin,
            ]);
        } elseif ($anak->is_balita) {
            // Jika sebelumnya belum balita tapi sekarang balita (misal salah input tanggal)
            \App\Models\Balita::create([
                'warga_id'      => $warga->id,
                'nama'          => $anak->nama,
                'nik'           => $anak->nik,
                'tanggal_lahir' => $anak->tanggal_lahir,
                'jenis_kelamin' => $anak->jenis_kelamin,
                'is_verified'   => false,
            ]);
        }

        return redirect()
            ->route('profile.index')
            ->with('success', 'Data anak berhasil diperbarui.');
    }

    /**
     * Hapus data anak.
     */
    public function destroy(Anak $anak)
    {
        $warga = $this->getWarga();
        abort_if($anak->warga_id !== $warga->id, 403, 'Akses ditolak.');

        $anak->delete();

        return redirect()
            ->route('profile.index')
            ->with('success', 'Data anak berhasil dihapus.');
    }
}
