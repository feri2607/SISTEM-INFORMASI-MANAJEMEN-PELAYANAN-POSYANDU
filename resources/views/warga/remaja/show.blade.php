{{-- resources/views/warga/remaja/show.blade.php --}}

@extends('layouts.public')

@section('hide-footer', true)
@section('title', 'Posyandu Remaja - Sistem Informasi Posyandu')

@section('page-title', '🧑 Detail Remaja')
@section('page-subtitle', 'Informasi lengkap kesehatan remaja')

@section('content')
<div class="space-y-6">
    {{-- Profile Card --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden">
        <div class="p-6">
            <div class="flex flex-col md:flex-row items-center gap-6">
                <div class="flex-shrink-0">
                    <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-teal-100 dark:border-teal-900/30">
                        <img src="{{ $remaja->foto_url }}" alt="{{ $remaja->nama }}" class="w-full h-full object-cover">
                    </div>
                </div>
                <div class="flex-1 text-center md:text-left">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $remaja->nama }}</h2>
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-2 mt-2">
                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                            {{ $remaja->nik }}
                        </span>
                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400">
                            {{ $remaja->umur }} tahun
                        </span>
                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400">
                            {{ $remaja->jenis_kelamin_label }}
                        </span>
                        @if($remaja->is_verified)
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400">✅ Terverifikasi</span>
                        @else
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400">⏳ Pending</span>
                        @endif
                    </div>
                </div>
                <div class="flex flex-wrap gap-2">
                    @if(!$remaja->is_verified)
                        <a href="{{ route('warga.remaja.edit', $remaja) }}" 
                           class="px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg transition duration-150 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit
                        </a>
                    @endif
                    <a href="{{ route('warga.remaja.index') }}" 
                       class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition duration-150">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Health Info Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-4 text-center">
            <p class="text-sm text-gray-500 dark:text-gray-400">Berat Badan</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $remaja->berat_badan_terakhir ?? '-' }} kg</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-4 text-center">
            <p class="text-sm text-gray-500 dark:text-gray-400">Tinggi Badan</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $remaja->tinggi_badan_terakhir ?? '-' }} cm</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-4 text-center">
            <p class="text-sm text-gray-500 dark:text-gray-400">BMI</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $remaja->bmi_terakhir ?? '-' }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-4 text-center">
            <p class="text-sm text-gray-500 dark:text-gray-400">Status Gizi</p>
            <span class="inline-block mt-1 px-3 py-1 text-xs font-medium rounded-full 
                @if($remaja->status_gizi === 'Normal') bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400
                @elseif($remaja->status_gizi === 'Kurus' || $remaja->status_gizi === 'Berisiko Kurus') bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400
                @elseif($remaja->status_gizi === 'Gemuk' || $remaja->status_gizi === 'Berisiko Gemuk') bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400
                @else bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 @endif">
                {{ $remaja->status_gizi }}
            </span>
        </div>
    </div>

    {{-- Charts --}}
    @if(count($growthData['berat']['data']) > 0)
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Perkembangan Berat Badan</h3>
            <div class="h-64">
                <canvas id="weightChart"></canvas>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Perkembangan Tinggi Badan</h3>
            <div class="h-64">
                <canvas id="heightChart"></canvas>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Perkembangan BMI</h3>
            <div class="h-64">
                <canvas id="bmiChart"></canvas>
            </div>
        </div>
    </div>
    @endif

    {{-- Riwayat Pemeriksaan --}}
    @if($remaja->pemeriksaan->count() > 0)
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Riwayat Pemeriksaan</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Data hasil pemeriksaan Posyandu (Read Only)</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">BB</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">TB</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">BMI</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status Gizi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">HB</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Petugas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($remaja->pemeriksaan as $item)
                        <tr>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $item->tanggal->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $item->berat_badan ?? '-' }} kg</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $item->tinggi_badan ?? '-' }} cm</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $item->bmi ?? '-' }}</td>
                            <td class="px-6 py-4">
                                @if($item->status_gizi)
                                    <span class="px-2 py-1 text-xs font-medium rounded-full 
                                        @if($item->status_gizi === 'Normal') bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400
                                        @elseif($item->status_gizi === 'Kurus' || $item->status_gizi === 'Berisiko Kurus') bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400
                                        @elseif($item->status_gizi === 'Gemuk' || $item->status_gizi === 'Berisiko Gemuk') bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400
                                        @else bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 @endif">
                                        {{ $item->status_gizi }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $item->status_hb ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $item->user->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- Tablet Tambah Darah (TTD) --}}
    @if($ttd)
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">💊 Tablet Tambah Darah (TTD)</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Target</p>
                    <p class="font-semibold text-gray-900 dark:text-white">{{ $ttd->target }} tablet</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Dikonsumsi</p>
                    <p class="font-semibold text-gray-900 dark:text-white">{{ $ttd->dikonsumsi }} tablet</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Tanggal Mulai</p>
                    <p class="font-semibold text-gray-900 dark:text-white">{{ $ttd->tanggal_mulai ? $ttd->tanggal_mulai->format('d M Y') : '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Progress</p>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5 mt-2">
                        @php
                            $progress = $ttd->target > 0 ? round(($ttd->dikonsumsi / $ttd->target) * 100) : 0;
                        @endphp
                        <div class="bg-teal-600 h-2.5 rounded-full" style="width: {{ min($progress, 100) }}%"></div>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $progress }}%</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Riwayat Konseling --}}
    @if($remaja->konseling->count() > 0)
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Riwayat Konseling</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Topik</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Catatan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Petugas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($remaja->konseling as $item)
                        <tr>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $item->tanggal->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $item->topik }}</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $item->catatan ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $item->user->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(count($growthData['berat']['data']) > 0)
            // Weight Chart
            new Chart(document.getElementById('weightChart'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($growthData['berat']['labels']) !!},
                    datasets: [{
                        label: 'Berat Badan (kg)',
                        data: {!! json_encode($growthData['berat']['data']) !!},
                        borderColor: 'rgba(16, 185, 129, 1)',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: 'rgba(16, 185, 129, 1)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
                        x: { grid: { display: false } }
                    }
                }
            });

            // Height Chart
            new Chart(document.getElementById('heightChart'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($growthData['tinggi']['labels']) !!},
                    datasets: [{
                        label: 'Tinggi Badan (cm)',
                        data: {!! json_encode($growthData['tinggi']['data']) !!},
                        borderColor: 'rgba(59, 130, 246, 1)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
                        x: { grid: { display: false } }
                    }
                }
            });

            // BMI Chart
            new Chart(document.getElementById('bmiChart'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($growthData['bmi']['labels']) !!},
                    datasets: [{
                        label: 'BMI (kg/m²)',
                        data: {!! json_encode($growthData['bmi']['data']) !!},
                        borderColor: 'rgba(139, 92, 246, 1)',
                        backgroundColor: 'rgba(139, 92, 246, 0.1)',
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: 'rgba(139, 92, 246, 1)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
                        x: { grid: { display: false } }
                    }
                }
            });
        @endif
    });
</script>
@endpush
@endsection