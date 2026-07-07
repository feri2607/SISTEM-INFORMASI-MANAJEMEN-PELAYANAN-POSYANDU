<?php

namespace App\Repositories;

use App\Models\Warga;
use App\Models\Balita;
use App\Models\Kehamilan;
use App\Models\Remaja;
use App\Models\Lansia;
use App\Models\Wus;
use App\Models\KegiatanPosyandu;
use App\Models\HasilPelayanan;
use App\Models\KehadiranKegiatan;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PegawaiDashboardRepository
{
    public function getCardStatistics(): array
    {
        return [
            'total_warga' => Warga::count(),
            'total_balita' => Balita::count(),
            'total_ibu_hamil' => Kehamilan::count(),
            'total_remaja' => Remaja::count(),
            'total_lansia' => Lansia::count(),
            'total_wus_pus' => Wus::count(),
            'kegiatan_hari_ini' => KegiatanPosyandu::whereDate('tanggal', Carbon::today())->count(),
            'pelayanan_hari_ini' => HasilPelayanan::whereDate('tanggal_pelayanan', Carbon::today())->count(),
        ];
    }

    public function getTodayActivities()
    {
        return KegiatanPosyandu::whereDate('tanggal', Carbon::today())
            ->orderBy('waktu_mulai', 'asc')
            ->get();
    }

    public function getUpcomingActivities()
    {
        return KegiatanPosyandu::whereDate('tanggal', '>', Carbon::today())
            ->orderBy('tanggal', 'asc')
            ->take(5)
            ->get();
    }

    public function getAttendanceSummaryToday(): array
    {
        // Mendapatkan data registrasi atau attendance hari ini
        $today = Carbon::today();
        
        $attendances = collect();
        $activitiesToday = KegiatanPosyandu::whereDate('tanggal', $today)->pluck('id');
        
        if ($activitiesToday->isNotEmpty()) {
            $attendances = KehadiranKegiatan::whereIn('kegiatan_id', $activitiesToday)->get();
        }

        $totalTerdaftar = $attendances->count();
        $hadir = $attendances->where('status_kehadiran', 'Hadir')->count();
        $belumHadir = $attendances->where('status_kehadiran', 'Belum Hadir')->count();
        $sudahDilayani = $attendances->where('status_kehadiran', 'Sudah Dilayani')->count();

        // Menunggu Pelayanan = Hadir tapi belum dilayani 
        // (Status Hadir berarti sudah check-in namun belum diselesaikan statusnya ke "Sudah Dilayani")
        $menunggu = $hadir;

        return [
            'terdaftar' => $totalTerdaftar,
            'hadir' => $hadir + $sudahDilayani,
            'belum_hadir' => $belumHadir,
            'menunggu' => $menunggu,
            'dilayani' => $sudahDilayani,
        ];
    }

    public function getTodayQueue()
    {
        $today = Carbon::today();
        $activitiesToday = KegiatanPosyandu::whereDate('tanggal', $today)->pluck('id');
        
        if ($activitiesToday->isEmpty()) {
            return collect();
        }

        return KehadiranKegiatan::has('peserta')->with(['peserta.warga'])
            ->whereIn('kegiatan_id', $activitiesToday)
            ->orderByRaw("CASE 
                WHEN status_kehadiran = 'Hadir' THEN 1
                WHEN status_kehadiran = 'Sudah Dilayani' THEN 2
                WHEN status_kehadiran = 'Belum Hadir' THEN 3
                ELSE 4 END")
            ->orderBy('jam_datang', 'asc')
            ->get();
    }

    public function getServiceChart7Days(): array
    {
        $days = [];
        $data = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $days[] = $date->format('d M');
            $data[] = HasilPelayanan::whereDate('tanggal_pelayanan', $date)->count();
        }

        return [
            'labels' => $days,
            'data' => $data,
        ];
    }

    public function getServiceChartMonthly(): array
    {
        $months = [];
        $data = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::today()->startOfMonth()->subMonths($i);
            $months[] = $month->format('M Y');
            $data[] = HasilPelayanan::whereMonth('tanggal_pelayanan', $month->month)
                ->whereYear('tanggal_pelayanan', $month->year)
                ->count();
        }

        return [
            'labels' => $months,
            'data' => $data,
        ];
    }

    public function getServiceByCategoryChart(): array
    {
        $labels = ['Balita', 'Kehamilan', 'WUS/PUS', 'Remaja', 'Lansia'];
        
        // Asumsi HasilPelayanan memiliki relasi atau kategori, jika tidak ada, 
        // fallback ke jumlah entitas (contoh mock based on HasilPelayanan jenis, atau polimorfisme)
        
        // Kita menghitung berdasarkan tipe polimorfik 'pelayananable_type' atau sejenisnya
        // atau kita hitung saja dari Model-model kesehatannya jika tidak ada
        $data = [
            HasilPelayanan::where('jenis_pelayanan', 'LIKE', '%Balita%')->count() ?: Balita::count(),
            HasilPelayanan::where('jenis_pelayanan', 'LIKE', '%Kehamilan%')->count() ?: Kehamilan::count(),
            HasilPelayanan::where('jenis_pelayanan', 'LIKE', '%WUS%')->orWhere('jenis_pelayanan', 'LIKE', '%PUS%')->count() ?: Wus::count(),
            HasilPelayanan::where('jenis_pelayanan', 'LIKE', '%Remaja%')->count() ?: Remaja::count(),
            HasilPelayanan::where('jenis_pelayanan', 'LIKE', '%Lansia%')->count() ?: Lansia::count(),
        ];

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }

    public function getNutritionDistribution(): array
    {
        $nutritionRaw = HasilPelayanan::whereNotNull('status_gizi')
            ->select('status_gizi', DB::raw('count(*) as total'))
            ->groupBy('status_gizi')
            ->get();
            
        $distribution = [
            'Gizi Baik' => 0,
            'Gizi Kurang' => 0,
            'Gizi Buruk' => 0,
            'Risiko Stunting' => 0,
        ];

        foreach ($nutritionRaw as $row) {
            $status = strtolower($row->status_gizi);
            if (str_contains($status, 'baik') || str_contains($status, 'normal')) {
                $distribution['Gizi Baik'] += $row->total;
            } elseif (str_contains($status, 'kurang')) {
                $distribution['Gizi Kurang'] += $row->total;
            } elseif (str_contains($status, 'buruk')) {
                $distribution['Gizi Buruk'] += $row->total;
            } elseif (str_contains($status, 'stunting')) {
                $distribution['Risiko Stunting'] += $row->total;
            } else {
                // Default fallback
                $distribution['Gizi Baik'] += $row->total;
            }
        }

        return [
            'labels' => array_keys($distribution),
            'data' => array_values($distribution),
        ];
    }
    
    public function getHealthDataSummary(): array
    {
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;
        
        return [
            'anc' => HasilPelayanan::whereMonth('tanggal_pelayanan', $bulanIni)->whereYear('tanggal_pelayanan', $tahunIni)->where('jenis_pelayanan', 'LIKE', '%ANC%')->count(),
            'imunisasi' => HasilPelayanan::whereMonth('tanggal_pelayanan', $bulanIni)->whereYear('tanggal_pelayanan', $tahunIni)->where('jenis_pelayanan', 'LIKE', '%Imunisasi%')->count(),
            'vitamin' => HasilPelayanan::whereMonth('tanggal_pelayanan', $bulanIni)->whereYear('tanggal_pelayanan', $tahunIni)->where('jenis_pelayanan', 'LIKE', '%Vitamin%')->count(),
            'konseling' => HasilPelayanan::whereMonth('tanggal_pelayanan', $bulanIni)->whereYear('tanggal_pelayanan', $tahunIni)->where('jenis_pelayanan', 'LIKE', '%Konseling%')->count(),
            'pemeriksaan_lansia' => HasilPelayanan::whereMonth('tanggal_pelayanan', $bulanIni)->whereYear('tanggal_pelayanan', $tahunIni)->where('jenis_pelayanan', 'LIKE', '%Lansia%')->count(),
            'pemeriksaan_remaja' => HasilPelayanan::whereMonth('tanggal_pelayanan', $bulanIni)->whereYear('tanggal_pelayanan', $tahunIni)->where('jenis_pelayanan', 'LIKE', '%Remaja%')->count(),
        ];
    }

    public function getRecentActivities()
    {
        // Mock aktivitas timeline menggunakan HasilPelayanan terkini 
        return HasilPelayanan::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'deskripsi' => 'Melakukan ' . ($item->jenis_pelayanan ?? 'Pelayanan'),
                    'waktu' => $item->created_at->diffForHumans(),
                    'user' => $item->user->name ?? 'Pegawai',
                    'tipe' => 'pelayanan'
                ];
            });
    }

    public function getQuickInformation(): array
    {
        $mingguIni = [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()];
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        return [
            'pelayanan_minggu_ini' => HasilPelayanan::whereBetween('tanggal_pelayanan', $mingguIni)->count(),
            'pelayanan_bulan_ini' => HasilPelayanan::whereMonth('tanggal_pelayanan', $bulanIni)->whereYear('tanggal_pelayanan', $tahunIni)->count(),
            'pegawai_login_hari_ini' => User::where('role', 'pegawai')->whereDate('last_login_at', Carbon::today())->count(),
            'kegiatan_bulan_ini' => KegiatanPosyandu::whereMonth('tanggal', $bulanIni)->whereYear('tanggal', $tahunIni)->count(),
        ];
    }
}
