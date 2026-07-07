{{-- resources/views/balita/show.blade.php --}}

@extends('layouts.app')

@section('title', 'Detail Balita - Sistem Informasi Posyandu')

@section('page-title', 'Detail Balita')
@section('page-subtitle', 'Informasi lengkap data balita')

@section('content')
<div class="space-y-6">
    <!-- Profile Header -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <div class="flex flex-col md:flex-row items-center gap-6">
                <!-- Foto -->
                <div class="flex-shrink-0">
                    <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-blue-100 dark:border-blue-900/30">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($balita->nama) }}&color=7F9CF5&background=EBF4FF&size=128" 
                             alt="{{ $balita->nama }}" class="w-full h-full object-cover">
                    </div>
                </div>
                
                <!-- Info -->
                <div class="flex-1 text-center md:text-left">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $balita->nama }}</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Anak dari {{ $balita->warga->nama ?? 'Data Tidak Ditemukan' }}
                    </p>
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 mt-2">
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
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route($routePrefix . 'edit', $balita) }}" 
                       class="px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white text-sm font-medium rounded-lg transition duration-150 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit
                    </a>
                    <a href="{{ route(Auth::user()->role . '.pelayanan.create', ['balita_id' => $balita->id]) }}" 
                       class="px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white text-sm font-medium rounded-lg transition duration-150 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                        Input Pelayanan
                    </a>
                    @if($balita->warga)
                        <a href="{{ route(Auth::user()->role . '.warga.show', $balita->warga) }}" 
                           class="px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white text-sm font-medium rounded-lg transition duration-150 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Lihat Orang Tua
                        </a>
                    @endif
                    <a href="{{ route($routePrefix . 'index') }}" 
                       class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg transition duration-150 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Data Balita -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Data Balita</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Nama</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $balita->nama }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Jenis Kelamin</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $balita->jenis_kelamin_label }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Tanggal Lahir</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $balita->tanggal_lahir->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Usia</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $balita->umur }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Orang Tua</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $balita->warga->nama ?? 'Data Tidak Ditemukan' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Anak Ke</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $balita->anak_ke ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Berat Lahir</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $balita->berat_lahir ? $balita->berat_lahir . ' kg' : '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Panjang Lahir</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $balita->panjang_lahir ? $balita->panjang_lahir . ' cm' : '-' }}</p>
                        </div>
                        @if($balita->keterangan)
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Keterangan</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $balita->keterangan }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Grafik Pertumbuhan -->
            @if(count($growthData['dates']) > 0)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Grafik Pertumbuhan</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Berat Badan</h4>
                            <div class="h-48">
                                <canvas id="weightChart"></canvas>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tinggi Badan</h4>
                            <div class="h-48">
                                <canvas id="heightChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Riwayat Pelayanan -->
            <div x-data="{ tab: 'pemeriksaan' }" class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Riwayat Medis</h3>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route(Auth::user()->role . '.balita.medis.pemeriksaan.create', $balita->id) }}" 
                           class="px-3 py-1.5 bg-[#036672] hover:bg-[#036672] text-white text-xs rounded-lg transition duration-150">
                            + Pemeriksaan
                        </a>
                        <a href="{{ route(Auth::user()->role . '.balita.medis.imunisasi.create', $balita->id) }}" 
                           class="px-3 py-1.5 bg-[#036672] hover:bg-[#036672] text-white text-xs rounded-lg transition duration-150">
                            + Imunisasi
                        </a>
                        <a href="{{ route(Auth::user()->role . '.balita.medis.vitamin.create', $balita->id) }}" 
                           class="px-3 py-1.5 bg-[#036672] hover:bg-[#036672] text-white text-xs rounded-lg transition duration-150">
                            + Vitamin
                        </a>
                        <a href="{{ route(Auth::user()->role . '.balita.medis.perkembangan.create', $balita->id) }}" 
                           class="px-3 py-1.5 bg-[#036672] hover:bg-[#036672] text-white text-xs rounded-lg transition duration-150">
                            + Perkembangan
                        </a>
                    </div>
                </div>
                
                <div class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                    <nav class="flex -mb-px px-4 gap-4 overflow-x-auto" aria-label="Tabs">
                        <button @click="tab = 'pemeriksaan'" :class="{'border-blue-500 text-blue-600': tab === 'pemeriksaan', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'pemeriksaan'}" class="whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm">
                            Pemeriksaan
                        </button>
                        <button @click="tab = 'imunisasi'" :class="{'border-blue-500 text-blue-600': tab === 'imunisasi', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'imunisasi'}" class="whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm">
                            Imunisasi
                        </button>
                        <button @click="tab = 'vitamin'" :class="{'border-blue-500 text-blue-600': tab === 'vitamin', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'vitamin'}" class="whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm">
                            Vitamin
                        </button>
                        <button @click="tab = 'perkembangan'" :class="{'border-blue-500 text-blue-600': tab === 'perkembangan', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'perkembangan'}" class="whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm">
                            Perkembangan
                        </button>
                    </nav>
                </div>
                
                <div class="p-0">
                    <!-- Tab Pemeriksaan -->
                    <div x-show="tab === 'pemeriksaan'" class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                                <tr>
                                    <th class="px-6 py-3">Tanggal</th>
                                    <th class="px-6 py-3">Berat (kg)</th>
                                    <th class="px-6 py-3">Tinggi (cm)</th>
                                    <th class="px-6 py-3">Lingkar Kepala</th>
                                    <th class="px-6 py-3">Status Gizi</th>
                                    <th class="px-6 py-3">Oleh</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($balita->pemeriksaan as $p)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <td class="px-6 py-4">{{ $p->tanggal_pemeriksaan->format('d M Y') }}</td>
                                    <td class="px-6 py-4">{{ $p->berat_badan }}</td>
                                    <td class="px-6 py-4">{{ $p->tinggi_badan }}</td>
                                    <td class="px-6 py-4">{{ $p->lingkar_kepala ?? '-' }} cm</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-xs font-medium rounded-full 
                                            @if($p->status_gizi === 'normal') bg-green-100 text-green-700 
                                            @elseif($p->status_gizi === 'kurang') bg-yellow-100 text-yellow-700
                                            @elseif($p->status_gizi === 'buruk') bg-red-100 text-red-700
                                            @else bg-orange-100 text-orange-700 @endif">
                                            {{ ucfirst($p->status_gizi) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">{{ $p->pegawai->name ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada riwayat pemeriksaan</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Tab Imunisasi -->
                    <div x-show="tab === 'imunisasi'" style="display: none;" class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                                <tr>
                                    <th class="px-6 py-3">Tanggal</th>
                                    <th class="px-6 py-3">Jenis Imunisasi</th>
                                    <th class="px-6 py-3">Catatan</th>
                                    <th class="px-6 py-3">Oleh</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($balita->imunisasi as $p)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <td class="px-6 py-4">{{ $p->tanggal->format('d M Y') }}</td>
                                    <td class="px-6 py-4 font-medium">{{ $p->jenis_imunisasi }}</td>
                                    <td class="px-6 py-4">{{ $p->keterangan ?? '-' }}</td>
                                    <td class="px-6 py-4">{{ $p->pegawai->name ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada riwayat imunisasi</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Tab Vitamin -->
                    <div x-show="tab === 'vitamin'" style="display: none;" class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                                <tr>
                                    <th class="px-6 py-3">Tanggal</th>
                                    <th class="px-6 py-3">Jenis Vitamin</th>
                                    <th class="px-6 py-3">Catatan</th>
                                    <th class="px-6 py-3">Oleh</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($balita->vitamin as $p)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <td class="px-6 py-4">{{ $p->tanggal->format('d M Y') }}</td>
                                    <td class="px-6 py-4 font-medium grid gap-1">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $p->jenis_vitamin }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">{{ $p->keterangan ?? '-' }}</td>
                                    <td class="px-6 py-4">{{ $p->pegawai->name ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada riwayat vitamin</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Tab Perkembangan -->
                    <div x-show="tab === 'perkembangan'" style="display: none;" class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                                <tr>
                                    <th class="px-6 py-3">Tanggal</th>
                                    <th class="px-6 py-3">Motorik</th>
                                    <th class="px-6 py-3">Bahasa</th>
                                    <th class="px-6 py-3">Sosial</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($balita->perkembangan as $p)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <td class="px-6 py-4">{{ $p->tanggal->format('d M Y') }}</td>
                                    <td class="px-6 py-4">{{ $p->motorik_kasar ?? '-' }}<br/><span class="text-xs text-gray-500">{{ $p->motorik_halus ?? '' }}</span></td>
                                    <td class="px-6 py-4">{{ $p->bahasa ?? '-' }}</td>
                                    <td class="px-6 py-4">{{ $p->sosial ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada riwayat perkembangan</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Kanan -->
        <div class="space-y-6">
            <!-- Ringkasan -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Ringkasan</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Pelayanan</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $balita->pelayanan->count() }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Status Gizi</p>
                        @if($balita->pemeriksaanTerakhir)
                            <p class="font-medium text-gray-900 dark:text-white">{{ ucfirst($balita->pemeriksaanTerakhir->status_gizi) }}</p>
                        @else
                            <p class="text-gray-500 dark:text-gray-400">Belum ada data</p>
                        @endif
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Pemeriksaan Terakhir</p>
                        @if($balita->pemeriksaan->first())
                            <p class="font-medium text-gray-900 dark:text-white">
                                {{ $balita->pemeriksaan->first()->tanggal_pemeriksaan->format('d M Y') }}
                            </p>
                        @else
                            <p class="text-gray-500 dark:text-gray-400">Belum ada</p>
                        @endif
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Orang Tua</p>
                        <p class="font-medium text-gray-900 dark:text-white">{{ $balita->warga->nama ?? 'Data Tidak Ditemukan' }}</p>
                        @if($balita->warga)
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-mono">{{ $balita->warga->nik }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Rekomendasi -->
            @if($balita->pemeriksaanTerakhir && $balita->pemeriksaanTerakhir->status_gizi !== 'normal')
            <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <div>
                        <h4 class="text-sm font-semibold text-yellow-800 dark:text-yellow-300">Perhatian!</h4>
                        <p class="text-sm text-yellow-700 dark:text-yellow-400 mt-1">
                            Status gizi {{ ucfirst($balita->pemeriksaanTerakhir->status_gizi) }}. 
                            Perlu pemantauan dan penanganan lebih lanjut.
                        </p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@if(count($growthData['dates']) > 0)
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Weight Chart
        const weightCtx = document.getElementById('weightChart').getContext('2d');
        new Chart(weightCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($growthData['dates']) !!},
                datasets: [{
                    label: 'Berat Badan (kg)',
                    data: {!! json_encode($growthData['berat_badan']) !!},
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
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Height Chart
        const heightCtx = document.getElementById('heightChart').getContext('2d');
        new Chart(heightCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($growthData['dates']) !!},
                datasets: [{
                    label: 'Tinggi Badan (cm)',
                    data: {!! json_encode($growthData['tinggi_badan']) !!},
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
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
@endif
@endsection