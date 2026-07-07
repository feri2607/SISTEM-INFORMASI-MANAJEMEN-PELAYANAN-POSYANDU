<?php
// app/Http/Controllers/User/UserDashboardController.php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Warga;
use App\Models\Balita;
use App\Models\KegiatanPosyandu;
use App\Models\HasilPelayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get user's warga (kader's assigned area)
        $wargaIds = $user->warga->pluck('id');

        // Statistics
        $stats = Cache::remember('user_dashboard_stats_' . $user->id, 300, function () use ($user) {
            // Get first upcoming activity
            $kegiatanTerjadwal = KegiatanPosyandu::where('user_id', $user->id)
                ->whereIn('status', ['terjadwal', 'berlangsung'])
                ->whereDate('tanggal', '>=', now())
                ->orderBy('tanggal')
                ->first();

            return [
                'total_warga' => Warga::where('user_id', $user->id)->count(),
                'total_balita' => Balita::whereHas('warga', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })->count(),
                'kegiatan_terjadwal' => $kegiatanTerjadwal,
                'balita_belum_hadir' => Balita::whereHas('warga', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })->whereDoesntHave('pelayanan', function ($query) {
                    $query->where('created_at', '>=', now()->subMonths(3));
                })->count(),
            ];
        });

        // Weight progress chart (ambil data balita pertama)
        $weightData = $this->getWeightProgress($user);

        // Height progress chart
        $heightData = $this->getHeightProgress($user);

        // Nutrition distribution
        $nutritionData = $this->getNutritionDistribution($user);

        // Upcoming activities
        $upcomingActivities = KegiatanPosyandu::with('user')
            ->where('user_id', $user->id)
            ->whereDate('tanggal', '>=', now())
            ->orderBy('tanggal')
            ->take(5)
            ->get();

        // Balita to monitor (with recent services)
        $balitaMonitor = Balita::with([
            'warga',
            'pelayanan' => function ($query) {
                $query->latest()->take(1);
            }
        ])
            ->whereHas('warga', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->whereDoesntHave('pelayanan', function ($query) {
                $query->where('created_at', '>=', now()->subMonths(2));
            })
            ->take(5)
            ->get();

        // Recent services
        $recentServices = HasilPelayanan::with(['balita.warga', 'kegiatan'])
            ->whereHas('balita.warga', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.user', compact(
            'stats',
            'weightData',
            'heightData',
            'nutritionData',
            'upcomingActivities',
            'balitaMonitor',
            'recentServices'
        ));
    }

    private function getWeightProgress($user)
    {
        $balita = Balita::whereHas('warga', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->first();

        if (!$balita) {
            return ['labels' => [], 'data' => []];
        }

        $services = HasilPelayanan::where('balita_id', $balita->id)
            ->orderBy('created_at')
            ->take(6)
            ->get();

        return [
            'labels' => $services->pluck('created_at')->map(function ($date) {
                return $date->format('d M');
            })->toArray(),
            'data' => $services->pluck('berat_badan')->toArray(),
        ];
    }

    private function getHeightProgress($user)
    {
        $balita = Balita::whereHas('warga', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->first();

        if (!$balita) {
            return ['labels' => [], 'data' => []];
        }

        $services = HasilPelayanan::where('balita_id', $balita->id)
            ->orderBy('created_at')
            ->take(6)
            ->get();

        return [
            'labels' => $services->pluck('created_at')->map(function ($date) {
                return $date->format('d M');
            })->toArray(),
            'data' => $services->pluck('tinggi_badan')->toArray(),
        ];
    }

    private function getNutritionDistribution($user)
    {
        $data = HasilPelayanan::select('status_gizi', DB::raw('count(*) as total'))
            ->whereHas('balita.warga', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->groupBy('status_gizi')
            ->get()
            ->pluck('total', 'status_gizi')
            ->toArray();

        // Ensure all statuses exist
        $defaults = ['normal' => 0, 'kurang' => 0, 'buruk' => 0, 'lebih' => 0];
        return array_merge($defaults, $data);
    }
}