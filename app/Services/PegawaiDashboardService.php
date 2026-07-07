<?php

namespace App\Services;

use App\Repositories\PegawaiDashboardRepository;
use Illuminate\Support\Facades\Cache;

class PegawaiDashboardService
{
    protected PegawaiDashboardRepository $repository;

    public function __construct(PegawaiDashboardRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getDashboardData(): array
    {
        // Cache basic stats to reduce DB load (cached for 5 mins)
        $stats = Cache::remember('pegawai_dashboard_stats', 300, function () {
            return $this->repository->getCardStatistics();
        });

        // Kegiatan Hari ini dan Antrian (don't cache too long or at all because of realtime tracking)
        $kegiatanHariIni = $this->repository->getTodayActivities();
        $antrian = $this->repository->getTodayQueue();
        
        $ringkasanPelayanan = $this->repository->getAttendanceSummaryToday();

        // Jadwal Terdekat
        $jadwalTerdekat = $this->repository->getUpcomingActivities();

        // Chart Data (Cache for 1 hr)
        $grafik7Hari = Cache::remember('pegawai_grafik_7hari', 3600, function () {
            return $this->repository->getServiceChart7Days();
        });

        $grafikBulanan = Cache::remember('pegawai_grafik_bulanan', 3600, function () {
            return $this->repository->getServiceChartMonthly();
        });

        $grafikKategori = Cache::remember('pegawai_grafik_kategori', 3600, function () {
            return $this->repository->getServiceByCategoryChart();
        });

        $statusGizi = Cache::remember('pegawai_status_gizi', 3600, function () {
            return $this->repository->getNutritionDistribution();
        });
        
        // Ringkasan Data Kesehatan dan Aktivitas
        $ringkasanKesehatan = Cache::remember('pegawai_ringkasan_kesehatan', 3600, function () {
            return $this->repository->getHealthDataSummary();
        });

        $aktivitasPegawai = $this->repository->getRecentActivities();
        
        $infoCepat = Cache::remember('pegawai_info_cepat', 1800, function () {
            return $this->repository->getQuickInformation();
        });

        return [
            'stats' => $stats,
            'kegiatanHariIni' => $kegiatanHariIni,
            'antrian' => $antrian,
            'ringkasanPelayanan' => $ringkasanPelayanan,
            'jadwalTerdekat' => $jadwalTerdekat,
            'grafik7Hari' => $grafik7Hari,
            'grafikBulanan' => $grafikBulanan,
            'grafikKategori' => $grafikKategori,
            'statusGizi' => $statusGizi,
            'ringkasanKesehatan' => $ringkasanKesehatan,
            'aktivitasPegawai' => $aktivitasPegawai,
            'infoCepat' => $infoCepat,
        ];
    }
}
