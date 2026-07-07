<?php
// app/Http/Controllers/WargaDashboardController.php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Warga;
use App\Models\Balita;
use App\Models\KegiatanPosyandu;
use App\Models\HasilPelayanan;
use App\Models\Artikel;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class WargaDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Pastikan user memiliki relasi warga
        $warga = $user->warga;

        // Jika warga belum memiliki data, redirect ke form lengkapi data
        if (!$warga) {
            return redirect()->route('warga.warga.create')
                ->with('warning', 'Silakan lengkapi data profil Anda terlebih dahulu.');
        }

        // Data Balita
        $balita = Balita::with(['pelayanan' => function ($query) {
            $query->latest()->take(1);
        }])->where('warga_id', $warga->id)->get();

        // Statistik
        $stats = $this->getStats($warga);

        // Jadwal Posyandu
        $jadwal = KegiatanPosyandu::with(['kehadiran' => function ($query) use ($user) {
            $query->where('user_id', $user->id);
        }])
        ->where('status', '!=', 'selesai')
        ->where('status', '!=', 'dibatalkan')
        ->whereDate('tanggal', '>=', now())
        ->orderBy('tanggal')
        ->orderBy('jam_mulai')
        ->limit(5)
        ->get();

        // Riwayat Pelayanan
        $riwayat = HasilPelayanan::with(['balita', 'kegiatan'])
            ->whereHas('balita', function ($query) use ($warga) {
                $query->where('warga_id', $warga->id);
            })
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Data untuk grafik
        $chartData = $this->getChartData($warga);

        // Pengumuman
        $pengumuman = Pengumuman::where('status', 'published')
            ->where(function ($query) {
                $query->whereNull('publish_at')
                      ->orWhere('publish_at', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('expire_at')
                      ->orWhere('expire_at', '>=', now());
            })
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        // Artikel
        $artikel = Artikel::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        // Notifikasi
        $notifikasi = $this->getNotifications($warga);

        // Statistik untuk card di dashboard
        $dashboardStats = [
            'total_balita' => $balita->count(),
            'total_pelayanan' => HasilPelayanan::whereHas('balita', function ($query) use ($warga) {
                $query->where('warga_id', $warga->id);
            })->count(),
            'jadwal_terdekat' => $jadwal->first(),
            'status_verifikasi' => $warga->status_verifikasi ?? 'pending',
        ];

        return view('warga.dashboard', compact(
            'warga',
            'balita',
            'stats',
            'jadwal',
            'riwayat',
            'chartData',
            'pengumuman',
            'artikel',
            'notifikasi',
            'dashboardStats'
        ));
    }

    private function getStats($warga)
    {
        return Cache::remember('warga_stats_' . $warga->id, 300, function () use ($warga) {
            $jumlahBalita = $warga->balita()->count();

            $jadwalBerikutnya = KegiatanPosyandu::where('status', '!=', 'selesai')
                ->where('status', '!=', 'dibatalkan')
                ->whereDate('tanggal', '>=', now())
                ->orderBy('tanggal')
                ->orderBy('jam_mulai')
                ->first();

            $pelayananTerakhir = HasilPelayanan::whereHas('balita', function ($query) use ($warga) {
                $query->where('warga_id', $warga->id);
            })->latest()->first();

            $statusGizi = $pelayananTerakhir ? $pelayananTerakhir->status_gizi : null;

            $imunisasiTerakhir = HasilPelayanan::whereHas('balita', function ($query) use ($warga) {
                $query->where('warga_id', $warga->id);
            })->whereNotNull('imunisasi')->latest()->first();

            $vitaminTerakhir = HasilPelayanan::whereHas('balita', function ($query) use ($warga) {
                $query->where('warga_id', $warga->id);
            })->whereNotNull('vitamin')->latest()->first();

            return [
                'jumlah_balita' => $jumlahBalita,
                'jadwal_berikutnya' => $jadwalBerikutnya,
                'pelayanan_terakhir' => $pelayananTerakhir,
                'status_gizi' => $statusGizi,
                'imunisasi_terakhir' => $imunisasiTerakhir,
                'vitamin_terakhir' => $vitaminTerakhir,
            ];
        });
    }

    private function getChartData($warga)
    {
        $balitaIds = $warga->balita()->pluck('id')->toArray();

        if (empty($balitaIds)) {
            return [
                'dates' => [],
                'berat_badan' => [],
                'tinggi_badan' => [],
                'lingkar_kepala' => [],
            ];
        }

        $pelayanan = HasilPelayanan::whereIn('balita_id', $balitaIds)
            ->orderBy('created_at')
            ->get();

        return [
            'dates' => $pelayanan->pluck('created_at')->map(function ($date) {
                return $date->format('d M Y');
            })->toArray(),
            'berat_badan' => $pelayanan->pluck('berat_badan')->toArray(),
            'tinggi_badan' => $pelayanan->pluck('tinggi_badan')->toArray(),
            'lingkar_kepala' => $pelayanan->pluck('lingkar_kepala')->toArray(),
        ];
    }

    private function getNotifications($warga)
    {
        $notifications = [];

        // Cek jadwal besok
        $besok = now()->addDay()->format('Y-m-d');
        $jadwalBesok = KegiatanPosyandu::whereDate('tanggal', $besok)
            ->where('status', '!=', 'selesai')
            ->where('status', '!=', 'dibatalkan')
            ->count();

        if ($jadwalBesok > 0) {
            $notifications[] = [
                'type' => 'info',
                'title' => 'Jadwal Posyandu Besok',
                'message' => "Ada {$jadwalBesok} kegiatan Posyandu besok. Jangan lupa datang!",
                'icon' => 'calendar',
            ];
        }

        // Cek imunisasi akan datang (dalam 7 hari)
        $imunisasiAkanDatang = HasilPelayanan::whereHas('balita', function ($query) use ($warga) {
            $query->where('warga_id', $warga->id);
        })->whereNotNull('imunisasi')
        ->where('created_at', '>=', now()->subDays(30))
        ->latest()
        ->first();

        if ($imunisasiAkanDatang) {
            $notifications[] = [
                'type' => 'warning',
                'title' => 'Imunisasi Mendatang',
                'message' => 'Jadwal imunisasi berikutnya sudah dekat. Periksa di menu Imunisasi.',
                'icon' => 'shield-check',
            ];
        }

        // Cek pengumuman baru (7 hari terakhir)
        $pengumumanBaru = Pengumuman::where('status', 'published')
            ->where('created_at', '>=', now()->subDays(7))
            ->count();

        if ($pengumumanBaru > 0) {
            $notifications[] = [
                'type' => 'info',
                'title' => 'Pengumuman Baru',
                'message' => "Ada {$pengumumanBaru} pengumuman baru. Cek halaman Pengumuman.",
                'icon' => 'bell',
            ];
        }

        // Cek status verifikasi jika pending
        if ($warga->status_verifikasi === 'pending') {
            $notifications[] = [
                'type' => 'warning',
                'title' => 'Verifikasi Akun',
                'message' => 'Data Anda sedang diverifikasi oleh kader. Proses ini memakan waktu 1-2 hari.',
                'icon' => 'clock',
            ];
        }

        return $notifications;
    }
}