<?php
// app/Http/Controllers/Warga/DashboardController.php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Warga;
use App\Models\Balita;
use App\Models\KegiatanPosyandu;
use App\Models\HasilPelayanan;
use App\Models\PemeriksaanBalita;
use App\Models\Artikel;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $warga = $user->warga;

        if (!$warga) {
            return redirect()->route('warga.warga.create')
                ->with('warning', 'Silakan lengkapi data warga Anda terlebih dahulu.');
        }

        // Statistik
        $stats = $this->getStats($warga);

        // Ringkasan Kesehatan Keluarga
        $familySummary = $this->getFamilySummary($warga);

        // Data untuk grafik
        $chartData = $this->getChartData($warga);

        // Jadwal terdekat
        $upcomingSchedule = KegiatanPosyandu::where('status', '!=', 'selesai')
            ->where('status', '!=', 'dibatalkan')
            ->whereDate('tanggal', '>=', now())
            ->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->limit(5)
            ->get();

        // Notifikasi
        $notifications = $this->getNotifications($warga);

        // Quick Actions
        $quickActions = $this->getQuickActions();

        // Health Cards Data
        $healthCards = $this->getHealthCards($warga);

        return view('warga.dashboard', compact(
            'warga',
            'stats',
            'familySummary',
            'chartData',
            'upcomingSchedule',
            'notifications',
            'quickActions',
            'healthCards'
        ));
    }

    private function getStats($warga)
    {
        return Cache::remember('warga_stats_' . $warga->id, 300, function () use ($warga) {
            $balitaCount = $warga->balita()->count();
            $keluargaCount = $warga->balita()->count() + 1; // +1 untuk ibu/kepala keluarga

            $jadwalBulanIni = KegiatanPosyandu::whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->count();

            $pelayananBulanIni = PemeriksaanBalita::whereHas('balita', function ($query) use ($warga) {
                $query->where('warga_id', $warga->id);
            })->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count();

            $notifikasiBaru = Pengumuman::where('status', 'published')
                ->where('created_at', '>=', now()->subDays(7))
                ->count();

            $artikelBaru = Artikel::where('status', 'published')
                ->where('created_at', '>=', now()->subDays(7))
                ->count();

            return [
                'keluarga' => $keluargaCount,
                'balita' => $balitaCount,
                'jadwal' => $jadwalBulanIni,
                'pelayanan' => $pelayananBulanIni,
                'notifikasi' => $notifikasiBaru,
                'artikel' => $artikelBaru,
            ];
        });
    }

    private function getFamilySummary($warga)
    {
        $anggotaKeluarga = collect([]); // Hubungan anggotaKeluarga belum diimplementasikan di struktur ini
        $balita = $warga->balita()->get();

        // Hitung jumlah berdasarkan kategori
        $totalBalita = $balita->count();
        $totalAnggota = $totalBalita + 1; // Warga + Balita
        $totalLansia = $anggotaKeluarga->where('kategori', 'lansia')->count();
        $totalRemaja = $anggotaKeluarga->where('kategori', 'remaja')->count();
        $totalIbuHamil = $anggotaKeluarga->where('kategori', 'ibu_hamil')->count();
        $totalIbuMenyusui = $anggotaKeluarga->where('kategori', 'ibu_menyusui')->count();

        $totalPelayanan = PemeriksaanBalita::whereHas('balita', function ($query) use ($warga) {
            $query->where('warga_id', $warga->id);
        })->count();

        // Progress kelengkapan data
        $totalFields = 10;
        $filledFields = 0;

        if ($warga->nik) $filledFields++;
        if ($warga->nomor_kk) $filledFields++;
        if ($warga->tanggal_lahir) $filledFields++;
        if ($warga->jenis_kelamin) $filledFields++;
        if ($warga->alamat) $filledFields++;
        if ($warga->telepon) $filledFields++;
        if ($warga->ktp_path) $filledFields++;
        if ($warga->kk_path) $filledFields++;
        if ($warga->verification_status === 'verified') $filledFields++;
        if ($warga->email) $filledFields++;

        $progress = round(($filledFields / $totalFields) * 100);

        return [
            'kepala_keluarga' => $warga->nama,
            'total_anggota' => $totalAnggota,
            'total_balita' => $totalBalita,
            'total_lansia' => $totalLansia,
            'total_remaja' => $totalRemaja,
            'total_ibu_hamil' => $totalIbuHamil,
            'total_ibu_menyusui' => $totalIbuMenyusui,
            'total_pelayanan' => $totalPelayanan,
            'progress' => $progress,
            'updated_at' => $warga->updated_at->format('d M Y H:i'),
            'verification_status' => $warga->verification_status,
            'is_complete' => $progress >= 80,
        ];
    }

    private function getChartData($warga)
    {
        $balitaIds = $warga->balita()->pluck('id')->toArray();

        if (empty($balitaIds)) {
            return [
                'berat' => ['labels' => [], 'data' => []],
                'tinggi' => ['labels' => [], 'data' => []],
                'status_gizi' => ['labels' => [], 'data' => []],
            ];
        }

        $pelayanan = PemeriksaanBalita::whereIn('balita_id', $balitaIds)
            ->orderBy('tanggal_pemeriksaan')
            ->get();

        return [
            'berat' => [
                'labels' => $pelayanan->pluck('tanggal_pemeriksaan')->map(fn($d) => $d->format('d M Y'))->toArray(),
                'data' => $pelayanan->pluck('berat_badan')->toArray(),
            ],
            'tinggi' => [
                'labels' => $pelayanan->pluck('tanggal_pemeriksaan')->map(fn($d) => $d->format('d M Y'))->toArray(),
                'data' => $pelayanan->pluck('tinggi_badan')->toArray(),
            ],
            'status_gizi' => [
                'labels' => ['Normal', 'Kurang', 'Buruk', 'Lebih'],
                'data' => [
                    $pelayanan->where('status_gizi', 'normal')->count(),
                    $pelayanan->where('status_gizi', 'kurang')->count(),
                    $pelayanan->where('status_gizi', 'buruk')->count(),
                    $pelayanan->where('status_gizi', 'lebih')->count(),
                ],
            ],
        ];
    }

    private function getNotifications($warga)
    {
        $notifications = [];

        // Jadwal besok
        $besok = now()->addDay()->format('Y-m-d');
        $jadwalBesok = KegiatanPosyandu::whereDate('tanggal', $besok)
            ->where('status', '!=', 'selesai')
            ->where('status', '!=', 'dibatalkan')
            ->count();

        if ($jadwalBesok > 0) {
            $notifications[] = [
                'type' => 'info',
                'title' => 'Jadwal Posyandu Besok',
                'message' => "Ada {$jadwalBesok} kegiatan Posyandu besok.",
                'icon' => 'calendar',
            ];
        }

        // Status verifikasi
        if ($warga->verification_status === 'pending') {
            $notifications[] = [
                'type' => 'warning',
                'title' => 'Verifikasi Data',
                'message' => 'Data Anda sedang diverifikasi oleh pegawai.',
                'icon' => 'clock',
            ];
        }

        // Pengumuman baru
        $pengumumanBaru = Pengumuman::where('status', 'published')
            ->where('created_at', '>=', now()->subDays(3))
            ->count();

        if ($pengumumanBaru > 0) {
            $notifications[] = [
                'type' => 'info',
                'title' => 'Pengumuman Baru',
                'message' => "Ada {$pengumumanBaru} pengumuman baru.",
                'icon' => 'bell',
            ];
        }

        return $notifications;
    }

    private function getQuickActions()
    {
        return [
            [
                'icon' => 'calendar',
                'title' => 'Jadwal Posyandu',
                'route' => route('public.schedule'),
                'color' => 'blue'
            ],
            [
                'icon' => 'megaphone',
                'title' => 'Pengumuman',
                'route' => route('public.announcements'),
                'color' => 'yellow'
            ],
            [
                'icon' => 'book-open',
                'title' => 'Artikel Edukasi',
                'route' => route('public.articles'),
                'color' => 'green'
            ],
            [
                'icon' => 'map-pin',
                'title' => 'Lokasi Posyandu',
                'route' => '#',
                'color' => 'red'
            ],
            [
                'icon' => 'phone',
                'title' => 'Hubungi Posyandu',
                'route' => route('contact'),
                'color' => 'purple'
            ],
            [
                'icon' => 'chat-bubble-left-right',
                'title' => 'Konsultasi',
                'route' => '#',
                'color' => 'pink'
            ],
        ];
    }

    private function getHealthCards($warga)
    {
        $balita = $warga->balita()->with(['pemeriksaanTerakhir', 'imunisasi', 'vitamin'])->get();
        $firstBalita = $balita->first();

        return [
            'balita' => [
                'total' => $balita->count(),
                'status_gizi' => $firstBalita?->pemeriksaanTerakhir?->status_gizi ?? 'Belum ada data',
                'imunisasi_berikutnya' => $firstBalita?->imunisasi->first()?->jenis_imunisasi ?? 'Belum ada data',
                'vitamin_berikutnya' => $firstBalita?->vitamin->first()?->jenis_vitamin ?? 'Belum ada data',
            ],
            'kehamilan' => [
                'usia_kehamilan' => 'Belum ada data',
                'perkiraan_persalinan' => 'Belum ada data',
                'anc_berikutnya' => 'Belum ada data',
                'konsumsi_ttd' => 'Belum ada data',
            ],
            'menyusui' => [
                'usia_bayi' => 'Belum ada data',
                'asi_eksklusif' => 'Belum ada data',
                'konseling' => 'Belum ada data',
                'artikel' => 'Belum ada data',
            ],
            'wus' => [
                'status_kb' => 'Belum ada data',
                'kontrol_berikutnya' => 'Belum ada data',
                'skrining' => 'Belum ada data',
                'artikel' => 'Belum ada data',
            ],
            'remaja' => [
                'bmi' => 'Belum ada data',
                'anemia' => 'Belum ada data',
                'kesehatan_mental' => 'Belum ada data',
                'artikel' => 'Belum ada data',
            ],
            'lansia' => [
                'tekanan_darah' => 'Belum ada data',
                'gula_darah' => 'Belum ada data',
                'kolesterol' => 'Belum ada data',
                'senam_lansia' => 'Belum ada data',
            ],
        ];
    }
}