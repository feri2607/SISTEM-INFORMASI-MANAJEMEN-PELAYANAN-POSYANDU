<?php
// app/Http/Controllers/Warga/WusController.php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Wus;
use App\Models\Pus;
use App\Models\PelayananReproduksi;
use App\Models\KonselingReproduksi;
use App\Models\Artikel;
use App\Http\Requests\WusRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class WusController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $user = Auth::user();
        $warga = $user->warga;

        if (!$warga) {
            return redirect()->route('warga.warga.create')
                ->with('warning', 'Silakan lengkapi data warga Anda terlebih dahulu.');
        }

        $wus = Wus::where('warga_id', $warga->id)->first();
        $pus = Pus::where('warga_id', $warga->id)->first();

        $stats = [
            'status_kb' => $pus ? $pus->status_kb_label : 'Belum ada data',
            'jenis_kontrasepsi' => $pus ? $pus->jenis_kontrasepsi : '-',
            'jadwal_kontrol' => $pus && $pus->jadwal_kontrol ? $pus->jadwal_kontrol->format('d M Y') : '-',
            'riwayat_pelayanan' => $wus ? $wus->pelayanan()->count() : 0,
            'konseling_terakhir' => $wus ? $wus->konseling()->first()?->tanggal?->format('d M Y') : '-',
            'status_verifikasi' => $wus ? $wus->status_verifikasi_label : 'Belum ada data',
        ];

        $pelayanan = $wus ? $wus->pelayanan()->with('user')->get() : collect();
        $konseling = $wus ? $wus->konseling()->with('user')->get() : collect();

        // Artikel edukasi
        $artikel = Artikel::where('status', 'published')
            ->whereIn('category_id', function ($query) {
                $query->select('id')
                    ->from('article_categories')
                    ->whereIn('name', ['Kesehatan Reproduksi', 'Gizi', 'Kesehatan']);
            })
            ->orderBy('published_at', 'desc')
            ->limit(4)
            ->get();

        // Notifikasi
        $notifications = $this->getNotifications($wus, $pus);

        // Data untuk form tambah/edit
        $statusPernikahan = ['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'];
        $golonganDarah = ['A', 'B', 'AB', 'O'];

        return view('warga.reproduksi.index', compact(
            'wus',
            'pus',
            'stats',
            'pelayanan',
            'konseling',
            'artikel',
            'notifications',
            'statusPernikahan',
            'golonganDarah'
        ));
    }

    public function create()
    {
        $user = Auth::user();
        $warga = $user->warga;

        if (!$warga) {
            return redirect()->route('warga.warga.create')
                ->with('warning', 'Silakan lengkapi data warga Anda terlebih dahulu.');
        }

        if (Wus::where('warga_id', $warga->id)->exists()) {
            return redirect()->route('warga.reproduksi.index')
                ->with('warning', 'Data WUS sudah ada.');
        }

        $statusPernikahan = ['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'];
        $golonganDarah = ['A', 'B', 'AB', 'O'];

        return view('warga.reproduksi.create', compact('statusPernikahan', 'golonganDarah'));
    }

    public function store(WusRequest $request)
    {
        $user = Auth::user();
        $warga = $user->warga;

        if (!$warga) {
            return back()->with('error', 'Data warga tidak ditemukan.');
        }

        $data = $request->validated();
        $data['warga_id'] = $warga->id;
        $data['is_verified'] = false;

        // Upload foto
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('wus', $filename, 'public');
            $data['foto'] = $filename;
        }

        $wus = Wus::create($data);

        // Jika status pernikahan kawin, buat data PUS
        if ($data['status_pernikahan'] === 'Kawin' && isset($data['nama_pasangan'])) {
            Pus::create([
                'warga_id' => $warga->id,
                'nama_pasangan' => $data['nama_pasangan'],
                'jumlah_anak' => $data['jumlah_anak'] ?? 0,
            ]);
        }

        return redirect()->route('warga.reproduksi.index')
            ->with('success', 'Data WUS & PUS berhasil ditambahkan dan menunggu verifikasi.');
    }

    public function show(Wus $wus)
    {
        $this->authorize('view', $wus);

        $wus->load(['pelayanan.user', 'konseling.user', 'pus']);
        $pus = $wus->pus;

        return view('warga.reproduksi.show', compact('wus', 'pus'));
    }

    public function edit(Wus $wus)
    {
        $this->authorize('update', $wus);

        if ($wus->is_verified) {
            return redirect()->route('warga.reproduksi.index')
                ->with('warning', 'Data sudah diverifikasi. Tidak dapat diubah.');
        }

        $statusPernikahan = ['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'];
        $golonganDarah = ['A', 'B', 'AB', 'O'];

        return view('warga.reproduksi.edit', compact('wus', 'statusPernikahan', 'golonganDarah'));
    }

    public function update(WusRequest $request, Wus $wus)
    {
        $this->authorize('update', $wus);

        if ($wus->is_verified) {
            return redirect()->route('warga.reproduksi.index')
                ->with('warning', 'Data sudah diverifikasi. Tidak dapat diubah.');
        }

        $data = $request->validated();

        // Upload foto
        if ($request->hasFile('foto')) {
            if ($wus->foto && Storage::disk('public')->exists('wus/' . $wus->foto)) {
                Storage::disk('public')->delete('wus/' . $wus->foto);
            }
            $file = $request->file('foto');
            $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('wus', $filename, 'public');
            $data['foto'] = $filename;
        }

        $wus->update($data);

        // Update atau Create PUS
        if ($data['status_pernikahan'] === 'Kawin' && isset($data['nama_pasangan'])) {
            Pus::updateOrCreate(
                ['warga_id' => $wus->warga_id],
                [
                    'nama_pasangan' => $data['nama_pasangan'],
                    'jumlah_anak' => $data['jumlah_anak'] ?? 0,
                ]
            );
        }

        return redirect()->route('warga.reproduksi.index')
            ->with('success', 'Data WUS & PUS berhasil diperbarui.');
    }

    public function destroy(Wus $wus)
    {
        $this->authorize('delete', $wus);

        if ($wus->is_verified) {
            return redirect()->route('warga.reproduksi.index')
                ->with('warning', 'Data sudah diverifikasi. Tidak dapat dihapus.');
        }

        if ($wus->foto && Storage::disk('public')->exists('wus/' . $wus->foto)) {
            Storage::disk('public')->delete('wus/' . $wus->foto);
        }

        // Hapus data terkait
        $wus->pelayanan()->delete();
        $wus->konseling()->delete();
        $wus->jadwalKontrol()->delete();
        if ($wus->pus) {
            $wus->pus->delete();
        }
        $wus->delete();

        return redirect()->route('warga.reproduksi.index')
            ->with('success', 'Data WUS berhasil dihapus.');
    }

    public function showPelayanan(PelayananReproduksi $pelayanan)
    {
        $this->authorize('view', $pelayanan->wus);
        return view('warga.reproduksi.pelayanan-detail', compact('pelayanan'));
    }

    private function getNotifications($wus, $pus)
    {
        $notifications = [];

        // Jadwal kontrol KB
        if ($pus && $pus->jadwal_kontrol) {
            $hariIni = now()->startOfDay();
            $kontrol = $pus->jadwal_kontrol->startOfDay();

            if ($kontrol->diffInDays($hariIni) <= 7 && $kontrol->isFuture()) {
                $notifications[] = [
                    'type' => 'info',
                    'title' => 'Jadwal Kontrol KB',
                    'message' => 'Jadwal kontrol KB Anda dalam ' . $kontrol->diffInDays($hariIni) . ' hari lagi.',
                    'icon' => 'calendar',
                ];
            }
        }

        // Jadwal Posyandu
        $posyandu = \App\Models\KegiatanPosyandu::whereDate('tanggal', '>=', now())
            ->where('status', 'terjadwal')
            ->orderBy('tanggal')
            ->first();

        if ($posyandu) {
            $notifications[] = [
                'type' => 'info',
                'title' => 'Jadwal Posyandu',
                'message' => 'Kegiatan Posyandu: ' . $posyandu->nama_kegiatan . ' pada ' . $posyandu->tanggal->format('d M Y'),
                'icon' => 'calendar',
            ];
        }

        return $notifications;
    }
}