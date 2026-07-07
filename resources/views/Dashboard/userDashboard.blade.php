@extends('layouts.app')
@section('title', 'Dashboard Pegawai - SI Posyandu')

@section('content')
<div x-data="dashboardData()" class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto space-y-8 bg-gray-50/50 dark:bg-gray-900/50 min-h-screen">
    
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
        <div>
            <p class="text-sm font-medium text-teal-600 dark:text-teal-400 tracking-wider uppercase mb-1">Selamat Pagi,</p>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                Halo, {{ auth()->user()->name }}
            </h1>
            <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">
                @if($kegiatanHariIni->count() > 0)
                    Anda memiliki <span class="font-semibold text-teal-600 dark:text-teal-400">{{ $kegiatanHariIni->count() }} agenda pelayanan aktif</span> hari ini.
                @else
                    Belum ada agenda pelayanan aktif hari ini.
                @endif
            </p>
        </div>
        <div class="mt-4 sm:mt-0 flex items-center bg-gray-50 dark:bg-gray-700/50 rounded-xl px-4 py-3 border border-gray-100 dark:border-gray-600">
            <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <div>
                <p class="text-sm font-semibold text-gray-700 dark:text-gray-200" x-text="currentDate"></p>
                <p class="text-xs text-gray-500 dark:text-gray-400" x-text="currentTime"></p>
            </div>
        </div>
    </div>

    {{-- Stats Grid 8 Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 lg:gap-6">
        @php
            $cards = [
                ['title' => 'Total Warga', 'value' => $stats['total_warga'], 'icon' => 'user-group', 'color' => 'blue'],
                ['title' => 'Total Balita', 'value' => $stats['total_balita'], 'icon' => 'face-smile', 'color' => 'green'],
                ['title' => 'Total Ibu Hamil', 'value' => $stats['total_ibu_hamil'], 'icon' => 'user', 'color' => 'purple'],
                ['title' => 'Total Remaja', 'value' => $stats['total_remaja'], 'icon' => 'academic-cap', 'color' => 'indigo'],
                ['title' => 'Total Lansia', 'value' => $stats['total_lansia'], 'icon' => 'users', 'color' => 'orange'],
                ['title' => 'Total WUS/PUS', 'value' => $stats['total_wus_pus'], 'icon' => 'heart', 'color' => 'pink'],
                ['title' => 'Kegiatan Hari Ini', 'value' => $stats['kegiatan_hari_ini'], 'icon' => 'calendar', 'color' => 'teal', 'highlight' => true],
                ['title' => 'Pelayanan Hari Ini', 'value' => $stats['pelayanan_hari_ini'], 'icon' => 'clipboard-document-check', 'color' => 'cyan'],
            ];
        @endphp

        @foreach($cards as $card)
            <div class="relative overflow-hidden bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 {{ isset($card['highlight']) ? 'ring-2 ring-teal-500 bg-teal-50/30' : 'hover:shadow-md transition-shadow' }}">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 rounded-xl bg-{{ $card['color'] }}-100 dark:bg-{{ $card['color'] }}-900/30 flex items-center justify-center text-{{ $card['color'] }}-600 dark:text-{{ $card['color'] }}-400">
                        @if($card['icon'] == 'user-group') <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg> 
                        @elseif($card['icon'] == 'face-smile') <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @elseif($card['icon'] == 'user') <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        @elseif($card['icon'] == 'academic-cap') <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                        @elseif($card['icon'] == 'users') <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        @elseif($card['icon'] == 'heart') <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        @elseif($card['icon'] == 'calendar') <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        @elseif($card['icon'] == 'clipboard-document-check') <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        @endif
                    </div>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1 {{ isset($card['highlight']) ? 'text-teal-700/80 dark:text-teal-300' : '' }}">{{ $card['title'] }}</h3>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white {{ isset($card['highlight']) ? 'text-teal-700 dark:text-teal-400' : '' }}">{{ number_format($card['value']) }}</div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Main Two Columns --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 lg:gap-8">
        
        {{-- Left Area: Kegiatan & Antrian (Col Span 2) --}}
        <div class="xl:col-span-2 space-y-6 lg:space-y-8">
            
            {{-- Kegiatan Hari Ini (Hero Card) --}}
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden flex flex-col md:flex-row">
                <div class="p-8 md:w-2/3 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-2 mb-4">
                            <span class="flex w-2.5 h-2.5 rounded-full bg-red-500 animate-pulse"></span>
                            <span class="text-xs font-bold tracking-wider text-red-500 uppercase">Sedang Berlangsung</span>
                        </div>
                        @if($kegiatanHariIni->count() > 0)
                            @php $kegiatan = $kegiatanHariIni->first(); @endphp
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $kegiatan->nama_kegiatan }}</h2>
                            <div class="flex border-b border-gray-100 dark:border-gray-700 pb-4 flex-col gap-3 mt-4">
                                <div class="flex items-center text-sm text-gray-600 dark:text-gray-300">
                                    <svg class="w-5 h-5 mr-3 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    {{ $kegiatan->lokasi ?? 'Lokasi Posyandu' }}
                                </div>
                                <div class="flex items-center text-sm text-gray-600 dark:text-gray-300">
                                    <svg class="w-5 h-5 mr-3 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ \Carbon\Carbon::parse($kegiatan->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($kegiatan->waktu_selesai)->format('H:i') }} WIB
                                </div>
                            </div>
                            <div class="mt-6 flex flex-wrap gap-3">
                                <a href="{{ route('pegawai.kehadiran.index', ['kegiatan_id' => $kegiatan->id]) }}" class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-semibold text-white bg-[#036672] hover:bg-[#024d56] rounded-xl transition shadow-md">
                                    Buka Pelayanan Sekarang
                                </a>
                                <a href="{{ route('pegawai.kegiatan.show', $kegiatan->id) }}" class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-semibold text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-xl transition">
                                    Lihat Detail Agenda
                                </a>
                            </div>
                        @else
                            <div class="py-12 flex flex-col items-center justify-center text-center">
                                <img src="https://www.svgrepo.com/show/327465/empty-calendar.svg" alt="Empty" class="w-24 h-24 opacity-50 mb-4">
                                <p class="text-gray-500 dark:text-gray-400 font-medium">Belum ada kegiatan hari ini.</p>
                            </div>
                        @endif
                    </div>
                </div>
                {{-- Ringkasan Side Panel --}}
                <div class="md:w-1/3 bg-gray-50 dark:bg-gray-700/30 p-6 md:p-8 flex flex-col justify-center border-t md:border-t-0 md:border-l border-gray-100 dark:border-gray-700">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-6 uppercase tracking-wider">Ringkasan Pelayanan</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center text-sm">
                            <span class="flex items-center text-gray-700 dark:text-gray-300">
                                <span class="w-2 h-2 rounded-full bg-blue-500 mr-2"></span> Terdaftar
                            </span>
                            <span class="font-bold text-gray-900 dark:text-white">{{ $ringkasanPelayanan['terdaftar'] }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="flex items-center text-gray-700 dark:text-gray-300">
                                <span class="w-2 h-2 rounded-full bg-teal-500 mr-2"></span> Hadir
                            </span>
                            <span class="font-bold text-gray-900 dark:text-white">{{ $ringkasanPelayanan['hadir'] }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="flex items-center text-gray-700 dark:text-gray-300">
                                <span class="w-2 h-2 rounded-full bg-red-400 mr-2"></span> Belum Hadir
                            </span>
                            <span class="font-bold text-gray-900 dark:text-white">{{ $ringkasanPelayanan['belum_hadir'] }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm pt-4 border-t border-gray-200 dark:border-gray-600">
                            <span class="flex items-center text-gray-700 dark:text-gray-300">
                                <span class="w-2 h-2 rounded-full bg-yellow-500 mr-2"></span> Menunggu
                            </span>
                            <span class="font-bold text-gray-900 dark:text-white">{{ $ringkasanPelayanan['menunggu'] }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Antrian Pelayanan --}}
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Antrian Pelayanan</h3>
                        <p class="text-xs text-gray-500 mt-1">Urutan berdasarkan waktu kedatangan</p>
                    </div>
                    <div class="flex gap-2">
                        <button class="p-2 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                        </button>
                        <button class="p-2 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        </button>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left whitespace-nowrap">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-semibold">Pasien</th>
                                <th scope="col" class="px-6 py-4 font-semibold text-center">Kategori</th>
                                <th scope="col" class="px-6 py-4 font-semibold text-center">Waktu</th>
                                <th scope="col" class="px-6 py-4 font-semibold text-center">Status</th>
                                <th scope="col" class="px-6 py-4 font-semibold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($antrian as $item)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden flex-shrink-0">
                                                @if($item->peserta?->warga?->foto ?? null)
                                                    <img src="{{ Storage::url($item->peserta->warga->foto) }}" class="w-full h-full object-cover">
                                                @else
                                                    <span class="font-bold text-gray-500">{{ substr($item->peserta?->nama ?? '?', 0, 1) }}</span>
                                                @endif
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-900 dark:text-white text-base">{{ $item->peserta?->nama ?? 'Peserta Tidak Valid' }}</p>
                                                <p class="text-xs text-gray-500">NIK: {{ $item->peserta?->warga?->nik ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700">{{ $item->kategori }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center font-medium text-gray-700 dark:text-gray-300">
                                        {{ $item->jam_datang ? \Carbon\Carbon::parse($item->jam_datang)->format('H:i') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($item->status_kehadiran == 'Hadir')
                                            <span class="inline-flex items-center text-xs font-semibold text-orange-500"><span class="w-2 h-2 bg-orange-500 rounded-full mr-2"></span>MENUNGGU</span>
                                        @elseif($item->status_kehadiran == 'Sudah Dilayani')
                                            <span class="inline-flex items-center text-xs font-semibold text-teal-600"><span class="w-2 h-2 bg-teal-600 rounded-full mr-2"></span>SELESAI</span>
                                        @else
                                            <span class="inline-flex items-center text-xs font-semibold text-gray-500"><span class="w-2 h-2 bg-gray-400 rounded-full mr-2"></span>BELUM HADIR</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="#" class="text-blue-600 hover:text-blue-800 font-semibold px-3 py-1 rounded hover:bg-blue-50 transition">
                                            @if($item->status_kehadiran == 'Hadir') Layani 
                                            @else Detail @endif
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <img src="https://www.svgrepo.com/show/382098/empty-ghost.svg" alt="Empty" class="w-16 h-16 opacity-40 mb-3">
                                            <p class="text-gray-500 font-medium">Belum ada peserta dalam antrian</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-gray-100 dark:border-gray-700 text-center">
                    <a href="#" class="text-sm font-semibold text-blue-700 hover:text-blue-800">Lihat Semua Antrian &rarr;</a>
                </div>
            </div>

            {{-- Tren Pelayanan Chart --}}
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 lg:p-8">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Tren Pelayanan 7 Hari Terakhir</h3>
                        <p class="text-sm text-gray-500 mt-1">Volume kunjungan harian per kategori peserta</p>
                    </div>
                </div>
                <div class="h-64 md:h-72 w-full mt-4">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>
            
        </div>

        {{-- Right Sidebar --}}
        <div class="space-y-6 lg:space-y-8">
            
            {{-- Status Gizi Doughnut --}}
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 lg:p-8">
                <h3 class="text-sm font-bold text-gray-500 dark:text-gray-400 tracking-wider uppercase mb-6 text-center">Status Gizi Balita</h3>
                <div class="relative h-48 flex justify-center mb-6">
                    <canvas id="nutritionChart"></canvas>
                </div>
                <div class="grid grid-cols-2 gap-y-3 gap-x-2 text-xs">
                    @php
                        $giziColors = ['Gizi Baik' => 'bg-blue-700', 'Gizi Kurang' => 'bg-blue-400', 'Risiko Stunting' => 'bg-red-500', 'Gizi Buruk' => 'bg-red-700'];
                        $totalGizi = array_sum($statusGizi['data']);
                    @endphp
                    @foreach($statusGizi['labels'] as $index => $label)
                        @php 
                            $pct = $totalGizi > 0 ? round(($statusGizi['data'][$index] / $totalGizi) * 100) : 0; 
                            $bg = $giziColors[$label] ?? 'bg-gray-400';
                        @endphp
                        <div class="flex items-center">
                            <span class="w-2.5 h-2.5 rounded-full {{ $bg }} mr-2"></span>
                            <span class="text-gray-600 dark:text-gray-300 font-medium">{{ $label }} ({{ $pct }}%)</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Jadwal Terdekat --}}
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="text-xs font-bold text-gray-500 dark:text-gray-400 tracking-wider uppercase mb-4">Jadwal Kegiatan Terdekat</h3>
                <div class="space-y-4">
                    @forelse($jadwalTerdekat as $jadwal)
                        <div class="flex items-start gap-4">
                            <div class="bg-gray-50 border border-gray-100 rounded-xl px-3 py-2 text-center min-w-[3.5rem]">
                                <span class="block text-xs font-bold text-gray-400 uppercase">{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('M') }}</span>
                                <span class="block text-lg font-black text-gray-800">{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d') }}</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm text-gray-800">{{ $jadwal->nama_kegiatan }}</h4>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $jadwal->lokasi }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-center text-gray-500">Tidak ada jadwal bulan ini</p>
                    @endforelse
                </div>
            </div>

            {{-- Timeline Aktivitas --}}
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="text-xs font-bold text-gray-500 dark:text-gray-400 tracking-wider uppercase mb-6">Aktivitas Terkini</h3>
                <div class="space-y-6 relative before:absolute before:inset-0 before:ml-2 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-gray-200 before:to-transparent">
                    @forelse($aktivitasPegawai as $aktivitas)
                        <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                            <div class="flex items-center justify-center w-4 h-4 rounded-full bg-blue-600 border-4 border-blue-100 shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 shadow absolute left-0 md:left-1/2 transform -translate-x-1/2"></div>
                            <div class="w-[calc(100%-2rem)] md:w-[calc(50%-1.5rem)] ml-6 md:ml-0 p-3 rounded-lg bg-gray-50 border border-gray-100 shadow-sm">
                                <p class="font-semibold text-gray-800 text-sm">{{ $aktivitas['deskripsi'] }}</p>
                                <p class="text-xs text-gray-500 mt-1">Oleh {{ explode(' ', trim($aktivitas['user']))[0] }} • {{ $aktivitas['waktu'] }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-center text-gray-500">Belum ada aktivitas tercatat</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('dashboardData', () => ({
            currentDate: '',
            currentTime: '',
            init() {
                this.updateTime();
                setInterval(() => this.updateTime(), 1000);
            },
            updateTime() {
                const now = new Date();
                this.currentDate = now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
                this.currentTime = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) + ' WIB';
            }
        }))
    });

    document.addEventListener('DOMContentLoaded', function () {
        // Doughnut Chart setup
        const ctxNut = document.getElementById('nutritionChart').getContext('2d');
        const nutData = {!! json_encode($statusGizi['data']) !!};
        const nutLabels = {!! json_encode($statusGizi['labels']) !!};
        
        new Chart(ctxNut, {
            type: 'doughnut',
            data: {
                labels: nutLabels,
                datasets: [{
                    data: nutData,
                    backgroundColor: ['#1d4ed8', '#60a5fa', '#ef4444', '#b91c1c'], // matched to giziColors blue shades
                    borderWidth: 2,
                    borderColor: '#ffffff',
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) label += ': ';
                                label += context.parsed;
                                return label;
                            }
                        }
                    }
                }
            }
        });

        // Area Line Trend Chart setup
        const ctxTrend = document.getElementById('trendChart').getContext('2d');
        const trendData = {!! json_encode($grafik7Hari['data']) !!};
        const trendLabels = {!! json_encode($grafik7Hari['labels']) !!};
        
        new Chart(ctxTrend, {
            type: 'line',
            data: {
                labels: trendLabels,
                datasets: [{
                    label: 'Pelayanan Harian',
                    data: trendData,
                    borderColor: '#1d4ed8',
                    backgroundColor: 'rgba(29, 78, 216, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#1d4ed8',
                    pointBorderWidth: 2,
                    pointRadius: 4,
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
                        grid: { borderDash: [2, 4], color: '#f3f4f6', drawBorder: false },
                        ticks: { stepSize: 5, color: '#9ca3af', font: { size: 10 } }
                    },
                    x: {
                        grid: { display: false, drawBorder: false },
                        ticks: { color: '#9ca3af', font: { size: 10 } }
                    }
                }
            }
        });
    });
</script>
@endpush