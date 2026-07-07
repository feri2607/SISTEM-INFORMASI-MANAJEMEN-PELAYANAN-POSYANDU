{{-- resources/views/pegawai/lansia/dashboard.blade.php --}}

@extends('layouts.app')

@section('title', 'Dashboard Posyandu Lansia - Sistem Informasi Posyandu')
@section('page-title', 'Dashboard Posyandu Lansia')
@section('page-subtitle', 'Ringkasan data pelayanan Posyandu Lansia')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Total Lansia --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Lansia Terdaftar</h3>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($stats['total_lansia']) }}</p>
                </div>
                <div class="p-3 bg-blue-50 dark:bg-blue-900/50 rounded-lg">
                    <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>
            <a href="{{ route('pegawai.lansia.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline mt-4">Lihat Detail →</a>
        </div>

        {{-- Hadir Hari Ini --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Lansia Hadir Hari Ini</h3>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($stats['lansia_hadir_today']) }}</p>
                </div>
                <div class="p-3 bg-green-50 dark:bg-green-900/50 rounded-lg">
                    <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-4">{{ now()->format('d M Y') }}</p>
        </div>

        {{-- Belum Dilayani --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Belum Dilayani Hari Ini</h3>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($stats['belum_dilayani']) }}</p>
                </div>
                <div class="p-3 bg-yellow-50 dark:bg-yellow-900/50 rounded-lg">
                    <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-4">Dari total lansia terdaftar</p>
        </div>

        {{-- Pemeriksaan Bulan Ini --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Pemeriksaan Bulan Ini</h3>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($stats['pemeriksaan_bulan_ini']) }}</p>
                </div>
                <div class="p-3 bg-purple-50 dark:bg-purple-900/50 rounded-lg">
                    <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
            </div>
            <a href="{{ route('pegawai.lansia.laporan') }}" class="text-sm text-purple-600 dark:text-purple-400 hover:underline mt-4">Lihat Laporan →</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Riwayat Pemeriksaan Terakhir --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Pemeriksaan Terakhir</h3>
                <a href="{{ route('pegawai.lansia.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Lihat Semua Lansia</a>
            </div>
            <div class="p-0 overflow-x-auto">
                @if($recentPemeriksaan->count() > 0)
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Lansia</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tgl / Pegawai</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">IMT</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($recentPemeriksaan as $p)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ $p->lansia->foto_url }}" alt="{{ $p->lansia->nama }}">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            <a href="{{ route('pegawai.lansia.show', $p->lansia) }}" class="hover:underline">{{ $p->lansia->nama }}</a>
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $p->lansia->umur ?? '-' }} tahun</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">{{ $p->tanggal->format('d M Y') }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $p->user->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($p->imt)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                        {{ number_format($p->imt, 1) }}
                                    </span>
                                @else
                                    <span class="text-gray-500">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                    Belum ada data pemeriksaan terakhir.
                </div>
            @endif
            </div>
        </div>

        {{-- Jadwal Senam Mendatang --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <span class="text-xl">🏃‍♂️</span> Jadwal Senam Mendatang
                </h3>
                <a href="{{ route('pegawai.lansia.jadwal.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Kelola Jadwal</a>
            </div>
            <div class="p-0 overflow-x-auto">
                @if($jadwalMendatang->count() > 0)
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal & Waktu</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Lokasi / Instruktur</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($jadwalMendatang as $jadwal)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $jadwal->tanggal->format('d M Y') }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::parse($jadwal->jam)->format('H:i') }} WIB</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $jadwal->lokasi }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $jadwal->instruktur ?? '-' }} (Kuota: {{ $jadwal->kuota }})</div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                    Belum ada jadwal senam mendatamg.
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
