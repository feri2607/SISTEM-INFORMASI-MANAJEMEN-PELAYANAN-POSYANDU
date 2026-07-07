<?php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Warga;
use App\Models\Balita;
use App\Models\KegiatanPosyandu;
use App\Models\HasilPelayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'user') {
            return redirect()->route('warga.dashboard');
        }

        return redirect()->route('pegawai.dashboard');
    }

    public function pegawai(\App\Services\PegawaiDashboardService $dashboardService)
    {
        $dashboardData = $dashboardService->getDashboardData();

        return view('Dashboard.userDashboard', $dashboardData);
    }

    public function admin()
    {
        // Cache statistics for 5 minutes
        $stats = Cache::remember('admin_dashboard_stats', 300, function () {
            return [
                'total_warga' => Warga::count(),
                'total_balita' => Balita::count(),
                'total_kegiatan_bulan_ini' => KegiatanPosyandu::whereMonth('tanggal', now()->month)
                    ->whereYear('tanggal', now()->year)
                    ->count(),
                'balita_gizi_kurang_buruk' => HasilPelayanan::whereIn('status_gizi', ['kurang', 'buruk'])
                    ->distinct('balita_id')
                    ->count('balita_id'),
            ];
        });

        // Chart data for monthly activities
        $monthlyActivities = $this->getMonthlyActivities();

        // Nutrition distribution data
        $nutritionData = $this->getNutritionDistribution();

        // Recent users
        $recentUsers = User::with('roles')
            ->latest()
            ->take(5)
            ->get();

        // Upcoming activities
        $upcomingActivities = KegiatanPosyandu::with('user')
            ->whereDate('tanggal', '>=', now())
            ->orderBy('tanggal')
            ->take(5)
            ->get();

        // Notifications
        $notifications = $this->getNotifications();

        return view('Dashboard.adminDashboard', compact(
            'stats',
            'monthlyActivities',
            'nutritionData',
            'recentUsers',
            'upcomingActivities',
            'notifications'
        ));
    }

    private function getMonthlyActivities()
    {
        $months = [];
        $counts = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $months[] = $month->format('M');
            $counts[] = KegiatanPosyandu::whereMonth('tanggal', $month->month)
                ->whereYear('tanggal', $month->year)
                ->count();
        }

        return [
            'labels' => $months,
            'data' => $counts,
        ];
    }

    private function getNutritionDistribution()
    {
        return HasilPelayanan::select('status_gizi', DB::raw('count(*) as total'))
            ->groupBy('status_gizi')
            ->get()
            ->pluck('total', 'status_gizi')
            ->toArray();
    }

    private function getNotifications()
    {
        $notifications = [];

        // Balita with malnutrition
        $malnutritionCount = HasilPelayanan::whereIn('status_gizi', ['kurang', 'buruk'])
            ->distinct('balita_id')
            ->count('balita_id');

        if ($malnutritionCount > 0) {
            $notifications[] = [
                'type' => 'danger',
                'title' => 'Balita Gizi Buruk/Kurang',
                'message' => "Terdapat {$malnutritionCount} balita dengan status gizi kurang/buruk.",
                'icon' => 'exclamation-circle',
            ];
        }

        // Today's activities
        $todayActivities = KegiatanPosyandu::whereDate('tanggal', now()->toDateString())->count();
        if ($todayActivities > 0) {
            $notifications[] = [
                'type' => 'info',
                'title' => 'Kegiatan Hari Ini',
                'message' => "Terdapat {$todayActivities} kegiatan hari ini.",
                'icon' => 'calendar',
            ];
        }

        // Balita belum hadir (no service in last 3 months)
        $balitaNoService = Balita::whereDoesntHave('pelayanan', function ($query) {
            $query->where('created_at', '>=', now()->subMonths(3));
        })->count();

        if ($balitaNoService > 0) {
            $notifications[] = [
                'type' => 'warning',
                'title' => 'Balita Belum Hadir',
                'message' => "{$balitaNoService} balita belum hadir dalam 3 bulan terakhir.",
                'icon' => 'user-group',
            ];
        }

        return $notifications;
    }
}