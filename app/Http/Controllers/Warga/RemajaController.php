<?php
// app/Http/Controllers/Warga/RemajaController.php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Remaja;
use App\Models\PemeriksaanRemaja;
use App\Models\KonselingRemaja;
use App\Models\TabletTambahDarah;
use App\Models\Artikel;
use App\Models\KegiatanPosyandu;
use App\Http\Requests\RemajaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RemajaController extends Controller
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

        $remaja = Remaja::where('warga_id', $warga->id)->get();
        $stats = [];

        if ($remaja->isNotEmpty()) {
            $first = $remaja->first();
            $stats = [
                'berat_badan' => $first->berat_badan_terakhir ?? '-',
                'tinggi_badan' => $first->tinggi_badan_terakhir ?? '-',
                'bmi' => $first->bmi_terakhir ?? '-',
                'status_gizi' => $first->status_gizi,
                'status_hb' => $first->pemeriksaan()->first()?->status_hb ?? '-',
                'pemeriksaan_terakhir' => $first->pemeriksaan()->first()?->tanggal?->format('d M Y') ?? '-',
            ];
        } else {
            $stats = [
                'berat_badan' => '-',
                'tinggi_badan' => '-',
                'bmi' => '-',
                'status_gizi' => 'Belum ada data',
                'status_hb' => '-',
                'pemeriksaan_terakhir' => '-',
            ];
        }

        // Artikel edukasi
        $artikel = Artikel::where('status', 'published')
            ->whereIn('category_id', function ($query) {
                $query->select('id')
                    ->from('article_categories')
                    ->whereIn('name', ['Kesehatan Remaja', 'Gizi', 'Kesehatan Mental', 'Kesehatan']);
            })
            ->orderBy('published_at', 'desc')
            ->limit(4)
            ->get();

        // Jadwal Posyandu
        $jadwal = KegiatanPosyandu::where('status', '!=', 'selesai')
            ->where('status', '!=', 'dibatalkan')
            ->whereDate('tanggal', '>=', now())
            ->orderBy('tanggal')
            ->limit(3)
            ->get();

        // Notifikasi
        $notifications = $this->getNotifications($remaja);

        return view('warga.remaja.index', compact(
            'remaja',
            'stats',
            'artikel',
            'jadwal',
            'notifications'
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

        if (Remaja::where('warga_id', $warga->id)->exists()) {
            return redirect()->route('warga.remaja.index')
                ->with('warning', 'Data remaja sudah ada.');
        }

        return view('warga.remaja.create');
    }

    public function store(RemajaRequest $request)
    {
        $user = Auth::user();
        $warga = $user->warga;

        if (!$warga) {
            return back()->with('error', 'Data warga tidak ditemukan.');
        }

        $data = $request->validated();
        $data['warga_id'] = $warga->id;
        $data['is_verified'] = false;

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('remaja', $filename, 'public');
            $data['foto'] = $filename;
        }

        Remaja::create($data);

        return redirect()->route('warga.remaja.index')
            ->with('success', 'Data remaja berhasil ditambahkan dan menunggu verifikasi pegawai.');
    }

    public function show(Remaja $remaja)
    {
        $this->authorize('view', $remaja);

        $remaja->load([
            'pemeriksaan.user',
            'konseling.user',
            'tabletTambahDarah',
            'warga'
        ]);

        // Growth data for charts
        $growthData = $this->getGrowthData($remaja);

        // Tablet Tambah Darah
        $ttd = $remaja->tabletTambahDarah;

        return view('warga.remaja.show', compact('remaja', 'growthData', 'ttd'));
    }

    public function edit(Remaja $remaja)
    {
        $this->authorize('update', $remaja);

        if ($remaja->is_verified) {
            return redirect()->route('warga.remaja.index')
                ->with('warning', 'Data sudah diverifikasi. Tidak dapat diubah.');
        }

        return view('warga.remaja.edit', compact('remaja'));
    }

    public function update(RemajaRequest $request, Remaja $remaja)
    {
        $this->authorize('update', $remaja);

        if ($remaja->is_verified) {
            return redirect()->route('warga.remaja.index')
                ->with('warning', 'Data sudah diverifikasi. Tidak dapat diubah.');
        }

        $data = $request->validated();

        if ($request->hasFile('foto')) {
            if ($remaja->foto && Storage::disk('public')->exists('remaja/' . $remaja->foto)) {
                Storage::disk('public')->delete('remaja/' . $remaja->foto);
            }
            $file = $request->file('foto');
            $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('remaja', $filename, 'public');
            $data['foto'] = $filename;
        }

        $remaja->update($data);

        return redirect()->route('warga.remaja.index')
            ->with('success', 'Data remaja berhasil diperbarui.');
    }

    public function destroy(Remaja $remaja)
    {
        $this->authorize('delete', $remaja);

        if ($remaja->is_verified) {
            return redirect()->route('warga.remaja.index')
                ->with('warning', 'Data sudah diverifikasi. Tidak dapat dihapus.');
        }

        if ($remaja->foto && Storage::disk('public')->exists('remaja/' . $remaja->foto)) {
            Storage::disk('public')->delete('remaja/' . $remaja->foto);
        }

        $remaja->pemeriksaan()->delete();
        $remaja->konseling()->delete();
        if ($remaja->tabletTambahDarah) {
            $remaja->tabletTambahDarah->delete();
        }
        $remaja->delete();

        return redirect()->route('warga.remaja.index')
            ->with('success', 'Data remaja berhasil dihapus.');
    }

    public function showPemeriksaan(PemeriksaanRemaja $pemeriksaan)
    {
        $this->authorize('view', $pemeriksaan->remaja);
        return view('warga.remaja.pemeriksaan-detail', compact('pemeriksaan'));
    }

    private function getGrowthData($remaja)
    {
        $pemeriksaan = $remaja->pemeriksaan()->orderBy('tanggal')->get();

        return [
            'berat' => [
                'labels' => $pemeriksaan->pluck('tanggal')->map(fn($d) => $d->format('d M Y'))->toArray(),
                'data' => $pemeriksaan->pluck('berat_badan')->toArray(),
            ],
            'tinggi' => [
                'labels' => $pemeriksaan->pluck('tanggal')->map(fn($d) => $d->format('d M Y'))->toArray(),
                'data' => $pemeriksaan->pluck('tinggi_badan')->toArray(),
            ],
            'bmi' => [
                'labels' => $pemeriksaan->pluck('tanggal')->map(fn($d) => $d->format('d M Y'))->toArray(),
                'data' => $pemeriksaan->pluck('bmi')->toArray(),
            ],
        ];
    }

    private function getNotifications($remaja)
    {
        $notifications = [];

        // Jadwal Posyandu
        $posyandu = KegiatanPosyandu::whereDate('tanggal', '>=', now())
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