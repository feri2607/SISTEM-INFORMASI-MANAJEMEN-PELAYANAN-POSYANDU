{{-- resources/views/Dashboard/adminDashboard.blade.php --}}

@extends('layouts.app')

@section('title', 'Dashboard Admin - Sistem Informasi Posyandu')

@section('page-title', 'Dashboard Admin')
@section('page-subtitle', 'Selamat datang, ' . Auth::user()->name . ' — Ringkasan sistem posyandu')

@section('content')
    <div class="space-y-6">

        {{-- Notifications --}}
        @if(count($notifications) > 0)
            <div class="space-y-2">
                @foreach($notifications as $notif)
                    <div class="flex items-start gap-3 p-4 rounded-lg border
                                    @if($notif['type'] === 'danger') bg-red-50 border-red-200 dark:bg-red-900/20 dark:border-red-800
                                    @elseif($notif['type'] === 'warning') bg-yellow-50 border-yellow-200 dark:bg-yellow-900/20 dark:border-yellow-800
                                    @else bg-blue-50 border-blue-200 dark:bg-blue-900/20 dark:border-blue-800 @endif">
                        <svg class="w-5 h-5 mt-0.5 flex-shrink-0
                                        @if($notif['type'] === 'danger') text-red-500
                                        @elseif($notif['type'] === 'warning') text-yellow-500
                                        @else text-blue-500 @endif" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                        </svg>
                        <div>
                            <p class="font-semibold text-sm text-gray-900 dark:text-white">{{ $notif['title'] }}</p>
                            <p class="text-xs text-gray-600 dark:text-gray-300">{{ $notif['message'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <x-dashboard-stat title="Total Warga" value="{{ number_format($stats['total_warga']) }}" icon="user-group"
                color="blue" subtitle="Terdaftar di sistem" />

            <x-dashboard-stat title="Total Balita" value="{{ number_format($stats['total_balita']) }}" icon="baby"
                color="green" subtitle="Balita terdaftar" />

            <x-dashboard-stat title="Kegiatan Bulan Ini" value="{{ number_format($stats['total_kegiatan_bulan_ini']) }}"
                icon="calendar" color="purple" subtitle="{{ now()->format('F Y') }}" />

            <x-dashboard-stat title="Gizi Kurang/Buruk" value="{{ number_format($stats['balita_gizi_kurang_buruk']) }}"
                icon="exclamation-circle" color="red" subtitle="Perlu perhatian" />
        </div>

        {{-- Charts Row --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Monthly Activities Chart --}}
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Kegiatan per Bulan</h3>
                <div class="h-64">
                    <canvas id="activityChart"></canvas>
                </div>
            </div>

            {{-- Nutrition Distribution Chart --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Distribusi Status Gizi</h3>
                <div class="h-64">
                    <canvas id="nutritionChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Tables Row --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Upcoming Activities --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Kegiatan Mendatang</h3>
                </div>
                <div class="space-y-3">
                    @forelse($upcomingActivities as $activity)
                        <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50 dark:bg-gray-700/50">
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $activity->nama_kegiatan }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ \Carbon\Carbon::parse($activity->tanggal)->format('d M Y') }}
                                    @if($activity->lokasi) • {{ $activity->lokasi }} @endif
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p>Tidak ada kegiatan mendatang</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Recent Users --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Pengguna Terbaru</h3>
                    <a href="{{ route('admin.users.index') }}"
                        class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                        Lihat Semua
                    </a>
                </div>
                <div class="space-y-3">
                    @forelse($recentUsers as $user)
                        <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50 dark:bg-gray-700/50">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-8 h-8 rounded-full bg-[#036672] flex items-center justify-center text-white text-xs font-bold">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white text-sm">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                                </div>
                            </div>
                            @foreach($user->roles as $role)
                                <span class="px-2 py-1 text-xs font-medium rounded-full
                                                @if($role->name === 'admin') bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400
                                                @else bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 @endif">
                                    {{ ucfirst($role->name) }}
                                </span>
                            @endforeach
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                            <p>Belum ada pengguna</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // Monthly Activities Bar Chart
            const activityCtx = document.getElementById('activityChart').getContext('2d');
            new Chart(activityCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($monthlyActivities['labels']) !!},
                    datasets: [{
                        label: 'Jumlah Kegiatan',
                        data: {!! json_encode($monthlyActivities['data']) !!},
                        backgroundColor: 'rgba(99, 102, 241, 0.7)',
                        borderColor: 'rgba(99, 102, 241, 1)',
                        borderWidth: 1,
                        borderRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 },
                            grid: { color: 'rgba(0,0,0,0.05)' }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });

            // Nutrition Doughnut Chart
            const nutritionCtx = document.getElementById('nutritionChart').getContext('2d');
            const nutritionData = {!! json_encode($nutritionData) !!};

            const labelMap = {
                'normal': 'Normal',
                'kurang': 'Kurang',
                'buruk': 'Buruk',
                'lebih': 'Lebih'
            };
            const colorMap = {
                'normal': '#10B981',
                'kurang': '#F59E0B',
                'buruk': '#EF4444',
                'lebih': '#F97316'
            };

            const keys = Object.keys(nutritionData);
            new Chart(nutritionCtx, {
                type: 'doughnut',
                data: {
                    labels: keys.map(k => labelMap[k] || k),
                    datasets: [{
                        data: Object.values(nutritionData),
                        backgroundColor: keys.map(k => colorMap[k] || '#6B7280'),
                        borderWidth: 2,
                        borderColor: '#FFFFFF',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { padding: 16, usePointStyle: true, pointStyle: 'circle' }
                        }
                    },
                    cutout: '60%'
                }
            });
        });
    </script>
@endpush