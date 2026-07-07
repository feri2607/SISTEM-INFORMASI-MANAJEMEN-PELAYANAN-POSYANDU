{{-- resources/views/kegiatan/show.blade.php --}}

@extends('layouts.app')

@section('title', 'Detail Kegiatan - ' . $kegiatan->nama_kegiatan)

@section('page-title', 'Detail Kegiatan')
@section('page-subtitle', 'Informasi lengkap kegiatan Posyandu')

@section('content')
@php $routePrefix = Auth::user()->role . '.pelayanan.'; @endphp
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-3">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $kegiatan->nama_kegiatan }}</h2>
                        <span class="px-3 py-1 text-xs font-medium rounded-full {{ $kegiatan->status_badge }}">
                            {{ $kegiatan->status_label }}
                        </span>
                    </div>
                    <div class="flex flex-wrap gap-4 mt-2 text-sm text-gray-600 dark:text-gray-400">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ $kegiatan->tanggal_full }}
                        </span>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $kegiatan->rentang_waktu }}
                        </span>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ $kegiatan->lokasi }}
                        </span>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Penanggung Jawab: {{ $kegiatan->user->name }}
                        </span>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route($routePrefix . 'create', ['kegiatan_id' => $kegiatan->id]) }}" 
                       class="px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white text-sm font-medium rounded-lg transition duration-150 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                        Input Pelayanan
                    </a>
                    @can('update', $kegiatan)
                    <a href="{{ route(auth()->user()->role . '.kegiatan.edit', $kegiatan) }}" 
                       class="px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white text-sm font-medium rounded-lg transition duration-150 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit
                    </a>
                    @endcan
                    <button onclick="window.print()" 
                            class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition duration-150 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                        Cetak
                    </button>
                    <a href="{{ route(auth()->user()->role . '.kegiatan.index') }}" 
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
            <!-- Deskripsi -->
            @if($kegiatan->deskripsi)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Deskripsi</h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-700 dark:text-gray-300">{{ $kegiatan->deskripsi }}</p>
                </div>
            </div>
            @endif

            <!-- Daftar Peserta -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Daftar Peserta</h3>
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        Total: {{ $summary['total_balita'] }} balita
                    </span>
                </div>
                <div class="p-6">
                    @if($peserta->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="text-left border-b border-gray-200 dark:border-gray-700">
                                        <th class="pb-2 font-medium text-gray-500 dark:text-gray-400">Balita</th>
                                        <th class="pb-2 font-medium text-gray-500 dark:text-gray-400">Orang Tua</th>
                                        <th class="pb-2 font-medium text-gray-500 dark:text-gray-400 text-center">Kehadiran</th>
                                        <th class="pb-2 font-medium text-gray-500 dark:text-gray-400 text-center">Status Pelayanan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($peserta as $data)
                                        <tr class="border-b border-gray-100 dark:border-gray-700">
                                            <td class="py-2">
                                                <div class="flex items-center space-x-2">
                                                    <div class="flex-shrink-0">
                                                        <div class="w-8 h-8 rounded-full overflow-hidden bg-gray-100 dark:bg-gray-700">
                                                            <img src="{{ $data['balita']->foto_url }}" 
                                                                 alt="{{ $data['balita']->nama }}" 
                                                                 class="w-full h-full object-cover">
                                                        </div>
                                                    </div>
                                                    <span class="font-medium text-gray-900 dark:text-white">{{ $data['balita']->nama }}</span>
                                                </div>
                                            </td>
                                            <td class="py-2 text-gray-600 dark:text-gray-400">
                                                {{ optional($data['balita']->warga)->nama ?? 'Tidak tersedia' }}
                                            </td>
                                            <td class="py-2 text-center">
                                                @if($data['hadir'])
                                                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                        </svg>
                                                        Hadir
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                        </svg>
                                                        Tidak Hadir
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="py-2 text-center">
                                                @if($data['pelayanan'])
                                                    <span class="px-2 py-1 text-xs font-medium rounded-full 
                                                        @if($data['pelayanan']->status_gizi === 'normal') bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400
                                                        @elseif($data['pelayanan']->status_gizi === 'kurang') bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400
                                                        @elseif($data['pelayanan']->status_gizi === 'buruk') bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400
                                                        @else bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400 @endif">
                                                        {{ $data['pelayanan']->status_gizi_label }}
                                                    </span>
                                                @else
                                                    <span class="text-xs text-gray-400">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500 dark:text-gray-400">Belum ada peserta</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Timeline -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Timeline</h3>
                </div>
                <div class="p-6">
                    <div class="relative">
                        @foreach($timeline as $item)
                            <div class="flex items-start mb-4 last:mb-0">
                                <div class="flex-shrink-0 mr-3">
                                    <div class="w-8 h-8 rounded-full 
                                        @if($item['color'] === 'blue') bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400
                                        @elseif($item['color'] === 'green') bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400
                                        @elseif($item['color'] === 'purple') bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400
                                        @elseif($item['color'] === 'red') bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400
                                        @else bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 @endif
                                        flex items-center justify-center">
                                        @if($item['icon'] === 'plus')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                        @elseif($item['icon'] === 'play')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        @elseif($item['icon'] === 'clipboard')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                            </svg>
                                        @elseif($item['icon'] === 'check')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        @elseif($item['icon'] === 'x')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $item['title'] }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $item['description'] }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $item['tanggal']->format('d M Y H:i') }}</p>
                                </div>
                            </div>
                        @endforeach
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
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Balita Terdaftar</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $summary['total_balita'] }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Jumlah Hadir</p>
                        <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $summary['hadir'] }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Jumlah Tidak Hadir</p>
                        <p class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $summary['tidak_hadir'] }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Pelayanan Selesai</p>
                        <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $summary['pelayanan_selesai'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Hasil Pelayanan -->
            @if($kegiatan->pelayanan->count() > 0)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Hasil Pelayanan</h3>
                </div>
                <div class="p-6 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Gizi Baik</span>
                        <span class="px-2 py-1 text-sm font-medium bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded">
                            {{ $nutritionSummary['normal'] }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Gizi Kurang</span>
                        <span class="px-2 py-1 text-sm font-medium bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 rounded">
                            {{ $nutritionSummary['kurang'] }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Gizi Buruk</span>
                        <span class="px-2 py-1 text-sm font-medium bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 rounded">
                            {{ $nutritionSummary['buruk'] }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Gizi Lebih</span>
                        <span class="px-2 py-1 text-sm font-medium bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400 rounded">
                            {{ $nutritionSummary['lebih'] }}
                        </span>
                    </div>
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-3 mt-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Vitamin</span>
                            <span class="px-2 py-1 text-sm font-medium bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400 rounded">
                                {{ $nutritionSummary['vitamin'] }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between mt-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Imunisasi</span>
                            <span class="px-2 py-1 text-sm font-medium bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400 rounded">
                                {{ $nutritionSummary['imunisasi'] }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection