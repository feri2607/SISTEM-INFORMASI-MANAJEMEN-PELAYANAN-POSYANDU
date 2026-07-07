{{-- resources/views/warga/balita/show.blade.php --}}

@extends('layouts.public')

@section('hide-footer', true)
@section('title', 'Detail Balita - Sistem Informasi Posyandu')

@section('page-title', '👶 Detail Balita')
@section('page-subtitle', 'Informasi lengkap pertumbuhan dan perkembangan balita.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<div class="space-y-6">
    {{-- Profile Header --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden">
        <div class="p-6">
            <div class="flex flex-col md:flex-row items-center gap-6">
                <div class="flex-shrink-0">
                    <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-teal-100 dark:border-teal-900/30">
                        <img src="{{ $balita->foto_url }}" alt="{{ $balita->nama }}" class="w-full h-full object-cover">
                    </div>
                </div>
                <div class="flex-1 text-center md:text-left">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $balita->nama }}</h2>
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-2 mt-2">
                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400">
                            {{ $balita->jenis_kelamin_label }}
                        </span>
                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400">
                            {{ $balita->umur }}
                        </span>
                        @if($balita->pemeriksaanTerakhir)
                            <span class="px-3 py-1 text-xs font-medium rounded-full 
                                @if($balita->pemeriksaanTerakhir->status_gizi === 'normal') bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400
                                @elseif($balita->pemeriksaanTerakhir->status_gizi === 'kurang') bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400
                                @elseif($balita->pemeriksaanTerakhir->status_gizi === 'buruk') bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400
                                @else bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400 @endif">
                                Gizi: {{ ucfirst($balita->pemeriksaanTerakhir->status_gizi) }}
                            </span>
                        @endif
                        @if($balita->is_verified)
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400">
                                ✅ Terverifikasi
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400">
                                ⏳ Menunggu Verifikasi
                            </span>
                        @endif
                    </div>
                    <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        <p>Orang Tua: {{ $balita->warga->nama }}</p>
                        @if($balita->golongan_darah)
                            <p>Golongan Darah: {{ $balita->golongan_darah }}</p>
                        @endif
                        @if($balita->berat_lahir)
                            <p>Berat Lahir: {{ $balita->berat_lahir }} kg</p>
                        @endif
                        @if($balita->panjang_lahir)
                            <p>Panjang Lahir: {{ $balita->panjang_lahir }} cm</p>
                        @endif
                    </div>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('warga.balita.index') }}" 
                       class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition duration-150 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali
                    </a>
                    @if(!$balita->is_verified)
                        <a href="{{ route('warga.balita.edit', $balita) }}" 
                           class="px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg transition duration-150 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Info Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-4 text-center">
            <p class="text-sm text-gray-500 dark:text-gray-400">Berat Badan Terakhir</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ $balita->pemeriksaanTerakhir?->berat_badan ?? '-' }} kg
            </p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-4 text-center">
            <p class="text-sm text-gray-500 dark:text-gray-400">Tinggi Badan Terakhir</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ $balita->pemeriksaanTerakhir?->tinggi_badan ?? '-' }} cm
            </p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-4 text-center">
            <p class="text-sm text-gray-500 dark:text-gray-400">Lingkar Kepala Terakhir</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ $balita->pemeriksaanTerakhir?->lingkar_kepala ?? '-' }} cm
            </p>
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
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Perkembangan Lingkar Kepala</h3>
            <div class="h-64">
                <canvas id="headChart"></canvas>
            </div>
        </div>
    </div>
    @endif

    {{-- Multi Tables --}}
    <div x-data="{ tab: 'pemeriksaan' }" class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden">
        <div class="border-b border-gray-200 dark:border-gray-700">
            <nav class="flex -mb-px px-4" aria-label="Tabs">
                <button @click="tab = 'pemeriksaan'" :class="{'border-teal-500 text-teal-600': tab === 'pemeriksaan', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'pemeriksaan'}" class="w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm">
                    Pemeriksaan
                </button>
                <button @click="tab = 'imunisasi'" :class="{'border-teal-500 text-teal-600': tab === 'imunisasi', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'imunisasi'}" class="w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm">
                    Imunisasi
                </button>
                <button @click="tab = 'vitamin'" :class="{'border-teal-500 text-teal-600': tab === 'vitamin', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'vitamin'}" class="w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm">
                    Vitamin
                </button>
                <button @click="tab = 'perkembangan'" :class="{'border-teal-500 text-teal-600': tab === 'perkembangan', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'perkembangan'}" class="w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm">
                    Perkembangan
                </button>
            </nav>
        </div>

        <div class="p-0">
            <div x-show="tab === 'pemeriksaan'" class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left">Tanggal</th>
                            <th class="px-6 py-3 text-left">BB (kg)</th>
                            <th class="px-6 py-3 text-left">TB (cm)</th>
                            <th class="px-6 py-3 text-left">LK (cm)</th>
                            <th class="px-6 py-3 text-left">Status Gizi</th>
                            <th class="px-6 py-3 text-left">Pegawai</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($balita->pemeriksaan as $item)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4">{{ $item->tanggal_pemeriksaan->format('d M Y') }}</td>
                            <td class="px-6 py-4">{{ $item->berat_badan }}</td>
                            <td class="px-6 py-4">{{ $item->tinggi_badan }}</td>
                            <td class="px-6 py-4">{{ $item->lingkar_kepala ?? '-' }}</td>
                            <td class="px-6 py-4">{{ ucfirst($item->status_gizi) }}</td>
                            <td class="px-6 py-4">{{ $item->pegawai->name ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada data pemeriksaan</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div x-show="tab === 'imunisasi'" style="display: none;" class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left">Bulan Ke</th>
                            <th class="px-6 py-3 text-left">Jenis Imunisasi</th>
                            <th class="px-6 py-3 text-left">Tanggal</th>
                            <th class="px-6 py-3 text-left">Status</th>
                            <th class="px-6 py-3 text-left">Pegawai</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($balita->imunisasi as $item)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4">-</td>
                            <td class="px-6 py-4">{{ $item->jenis_imunisasi }}</td>
                            <td class="px-6 py-4">{{ $item->tanggal->format('d M Y') }}</td>
                            <td class="px-6 py-4">{{ $item->status }}</td>
                            <td class="px-6 py-4">{{ $item->pegawai->name ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada data imunisasi</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div x-show="tab === 'vitamin'" style="display: none;" class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left">Jenis Vitamin</th>
                            <th class="px-6 py-3 text-left">Dosis</th>
                            <th class="px-6 py-3 text-left">Tanggal</th>
                            <th class="px-6 py-3 text-left">Pegawai</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($balita->vitamin as $item)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4">{{ $item->jenis_vitamin }}</td>
                            <td class="px-6 py-4">{{ $item->dosis }}</td>
                            <td class="px-6 py-4">{{ $item->tanggal->format('d M Y') }}</td>
                            <td class="px-6 py-4">{{ $item->pegawai->name ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada data vitamin</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div x-show="tab === 'perkembangan'" style="display: none;" class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left">Tanggal</th>
                            <th class="px-6 py-3 text-left">Motorik Kasar</th>
                            <th class="px-6 py-3 text-left">Motorik Halus</th>
                            <th class="px-6 py-3 text-left">Bahasa</th>
                            <th class="px-6 py-3 text-left">Sosial</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($balita->perkembangan as $item)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4">{{ $item->tanggal->format('d M Y') }}</td>
                            <td class="px-6 py-4">{{ $item->motorik_kasar ?: '-' }}</td>
                            <td class="px-6 py-4">{{ $item->motorik_halus ?: '-' }}</td>
                            <td class="px-6 py-4">{{ $item->bahasa ?: '-' }}</td>
                            <td class="px-6 py-4">{{ $item->sosial ?: '-' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada data perkembangan</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(count($growthData['berat']['data']) > 0)
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

            new Chart(document.getElementById('headChart'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($growthData['lingkar_kepala']['labels']) !!},
                    datasets: [{
                        label: 'Lingkar Kepala (cm)',
                        data: {!! json_encode($growthData['lingkar_kepala']['data']) !!},
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