<?php
// app/Http/Controllers/Warga/BalitaController.php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Balita;
use App\Models\Warga;
use App\Models\PemeriksaanBalita;
use App\Models\ImunisasiBalita;
use App\Models\VitaminBalita;
use App\Models\PerkembanganBalita;
use App\Http\Requests\BalitaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BalitaController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the balita.
     * Warga hanya bisa melihat balita miliknya sendiri.
     */
    public function index()
    {
        $user = Auth::user();
        $warga = $user->warga;

        if (!$warga) {
            return redirect()->route('warga.warga.create')
                ->with('warning', 'Silakan lengkapi data warga Anda terlebih dahulu.');
        }

        $balita = Balita::with(['pemeriksaanTerakhir'])
            ->where('warga_id', $warga->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Statistik untuk dashboard balita
        $stats = [
            'total' => $warga->balita()->count(),
            'status_gizi' => $this->getStatusGiziTerakhir($warga),
            'imunisasi_bulan_ini' => ImunisasiBalita::whereHas('balita', function($q) use ($warga) {
                $q->where('warga_id', $warga->id);
            })->whereMonth('tanggal', now()->month)
              ->whereYear('tanggal', now()->year)->count(),
            'vitamin_bulan_ini' => VitaminBalita::whereHas('balita', function($q) use ($warga) {
                $q->where('warga_id', $warga->id);
            })->whereMonth('tanggal', now()->month)
              ->whereYear('tanggal', now()->year)->count(),
            'pemeriksaan_terakhir' => PemeriksaanBalita::whereHas('balita', function ($q) use ($warga) {
                $q->where('warga_id', $warga->id);
            })->latest()->first(),
        ];

        return view('warga.balita.index', compact('balita', 'stats'));
    }

    /**
     * Show the form for creating a new balita.
     * Warga bisa menambah balita.
     */
    public function create()
    {
        $user = Auth::user();
        $warga = $user->warga;

        if (!$warga) {
            return redirect()->route('warga.warga.create')
                ->with('warning', 'Silakan lengkapi data warga Anda terlebih dahulu.');
        }

        return view('warga.balita.create', compact('warga'));
    }

    /**
     * Store a newly created balita.
     * Warga bisa menyimpan balita baru.
     */
    public function store(BalitaRequest $request)
    {
        $user = Auth::user();
        $warga = $user->warga;

        if (!$warga) {
            return back()->with('error', 'Data warga tidak ditemukan.');
        }

        $data = $request->validated();
        $data['warga_id'] = $warga->id;
        $data['is_verified'] = false; // Data balita baru belum diverifikasi

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('foto-balita', 'public');
            $data['foto_path'] = $path;
        }

        Balita::create($data);

        return redirect()->route('warga.balita.index')
            ->with('success', 'Data balita berhasil ditambahkan dan menunggu verifikasi pegawai.');
    }

    /**
     * Display the specified balita.
     * Warga hanya bisa melihat detail balita miliknya sendiri (Policy).
     * Semua data kesehatan bersifat READ ONLY.
     */
    public function show(Balita $balita)
    {
        $this->authorize('view', $balita);

        $balita->load([
            'warga',
            'pemeriksaan' => function ($query) {
                $query->with(['pegawai'])->take(10);
            },
            'pemeriksaanTerakhir',
            'imunisasi' => function ($q) { $q->with('pegawai'); },
            'vitamin' => function ($q) { $q->with('pegawai'); },
            'perkembangan' => function ($q) { $q->with('pegawai'); },
        ]);

        // Growth data for charts
        $growthData = $this->getGrowthData($balita);

        return view('warga.balita.show', compact('balita', 'growthData'));
    }

    /**
     * Show the form for editing the balita.
     * Warga hanya bisa edit data identitas balita yang belum diverifikasi.
     */
    public function edit(Balita $balita)
    {
        $this->authorize('update', $balita);
        
        // Jika balita sudah diverifikasi, warga tidak bisa mengubah
        if ($balita->is_verified) {
            return redirect()->route('warga.balita.index')
                ->with('warning', 'Data balita sudah diverifikasi. Tidak dapat diubah.');
        }

        return view('warga.balita.edit', compact('balita'));
    }

    /**
     * Update the specified balita.
     * Warga hanya bisa update data identitas (nama, tgl lahir, dll) 
     * dan hanya jika belum diverifikasi.
     * Warga TIDAK BISA update data kesehatan (berat badan, tinggi badan, dll).
     */
    public function update(BalitaRequest $request, Balita $balita)
    {
        $this->authorize('update', $balita);

        // Jika balita sudah diverifikasi, warga tidak bisa mengubah
        if ($balita->is_verified) {
            return redirect()->route('warga.balita.index')
                ->with('warning', 'Data balita sudah diverifikasi. Tidak dapat diubah.');
        }

        // Hanya field identitas yang boleh diupdate oleh warga
        // Field kesehatan (berat_badan, tinggi_badan, dll) TIDAK ADA di sini
        $data = $request->only([
            'nama',
            'nik',
            'nomor_kk',
            'tanggal_lahir',
            'jenis_kelamin',
            'tempat_lahir',
            'nama_ayah',
            'nama_ibu',
            'alamat',
            'golongan_darah',
            'no_hp_orang_tua'
        ]);

        if ($request->hasFile('foto')) {
            if ($balita->foto_path && Storage::disk('public')->exists($balita->foto_path)) {
                Storage::disk('public')->delete($balita->foto_path);
            }
            $path = $request->file('foto')->store('foto-balita', 'public');
            $data['foto_path'] = $path;
        }

        $balita->update($data);

        return redirect()->route('warga.balita.index')
            ->with('success', 'Data balita berhasil diperbarui.');
    }

    /**
     * Remove the specified balita.
     * Warga hanya bisa hapus balita miliknya sendiri yang belum diverifikasi.
     */
    public function destroy(Balita $balita)
    {
        $this->authorize('delete', $balita);

        // Jika balita sudah diverifikasi, warga tidak bisa menghapus
        if ($balita->is_verified) {
            return redirect()->route('warga.balita.index')
                ->with('warning', 'Data balita sudah diverifikasi. Tidak dapat dihapus.');
        }

        DB::beginTransaction();
        try {
            // Hapus data terkait
            $balita->pemeriksaan()->delete();
            $balita->imunisasi()->delete();
            $balita->vitamin()->delete();
            $balita->perkembangan()->delete();
            $balita->delete();
            DB::commit();

            return redirect()->route('warga.balita.index')
                ->with('success', 'Data balita berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus data balita.');
        }
    }

    /**
     * Get growth data for charts
     * Data kesehatan bersifat READ ONLY untuk warga.
     */
    private function getGrowthData($balita)
    {
        $pemeriksaan = $balita->pemeriksaan()->orderBy('tanggal_pemeriksaan')->get();

        return [
            'berat' => [
                'labels' => $pemeriksaan->pluck('tanggal_pemeriksaan')->map(fn($d) => $d->format('d M Y'))->toArray(),
                'data' => $pemeriksaan->pluck('berat_badan')->toArray(),
            ],
            'tinggi' => [
                'labels' => $pemeriksaan->pluck('tanggal_pemeriksaan')->map(fn($d) => $d->format('d M Y'))->toArray(),
                'data' => $pemeriksaan->pluck('tinggi_badan')->toArray(),
            ],
            'lingkar_kepala' => [
                'labels' => $pemeriksaan->pluck('tanggal_pemeriksaan')->map(fn($d) => $d->format('d M Y'))->toArray(),
                'data' => $pemeriksaan->pluck('lingkar_kepala')->toArray(),
            ],
        ];
    }

    /**
     * Get latest nutrition status
     */
    private function getStatusGiziTerakhir($warga)
    {
        $pemeriksaan = PemeriksaanBalita::whereHas('balita', function ($q) use ($warga) {
            $q->where('warga_id', $warga->id);
        })->latest('tanggal_pemeriksaan')->first();

        return $pemeriksaan ? $pemeriksaan->status_gizi : 'Belum ada data';
    }
}