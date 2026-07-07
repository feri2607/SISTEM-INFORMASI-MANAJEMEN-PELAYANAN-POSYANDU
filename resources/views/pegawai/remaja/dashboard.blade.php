{{-- resources/views/pegawai/remaja/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Posyandu Remaja - Pegawai')
@section('page-title', '🧑‍🤝‍🧑 Posyandu Remaja')
@section('page-subtitle', 'Dashboard manajemen pelayanan remaja')

@section('content')
<div class="space-y-6">

    {{-- Stat Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Total Remaja --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-5 flex items-center gap-4 border-l-4 border-purple-500">
            <div class="p-3 bg-purple-100 dark:bg-purple-900/40 rounded-xl">
                <svg class="w-7 h-7 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Total Remaja</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_remaja']) }}</p>
            </div>
        </div>

        {{-- Dilayani Hari Ini --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-5 flex items-center gap-4 border-l-4 border-green-500">
            <div class="p-3 bg-green-100 dark:bg-green-900/40 rounded-xl">
                <svg class="w-7 h-7 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Dilayani Hari Ini</p>
                <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ number_format($stats['dilayani_hari_ini']) }}</p>
            </div>
        </div>

        {{-- Belum Dilayani --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-5 flex items-center gap-4 border-l-4 border-yellow-500">
            <div class="p-3 bg-yellow-100 dark:bg-yellow-900/40 rounded-xl">
                <svg class="w-7 h-7 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Belum Dilayani</p>
                <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">{{ number_format($stats['belum_dilayani']) }}</p>
            </div>
        </div>

        {{-- Pemeriksaan Bulan Ini --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-5 flex items-center gap-4 border-l-4 border-blue-500">
            <div class="p-3 bg-blue-100 dark:bg-blue-900/40 rounded-xl">
                <svg class="w-7 h-7 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Pemeriksaan Bulan Ini</p>
                <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ number_format($stats['pemeriksaan_bulan_ini']) }}</p>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">⚡ Aksi Cepat</h3>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 p-6 border-b border-gray-200 dark:border-gray-700">
            <a href="{{ route('pegawai.remaja.index') }}?filter=verified"
               class="flex flex-col items-center p-4 bg-teal-50 dark:bg-teal-900/20 rounded-xl hover:bg-teal-100 dark:hover:bg-teal-900/40 transition group">
                <svg class="w-8 h-8 text-teal-600 dark:teal-400 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-sm font-medium text-teal-700 dark:text-teal-300 mt-2 text-center">Verifikasi Data</span>
            </a>
        </div>
    </div>

    {{-- Recent Pemeriksaan --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">📋 Pemeriksaan Terbaru</h3>
            <a href="{{ route('pegawai.remaja.index') }}" class="text-sm text-purple-600 hover:text-purple-700 dark:text-purple-400">Lihat Semua →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Remaja</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">BB / TB</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">BMI</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Status Gizi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Pegawai</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($recentPemeriksaan as $p)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $p->remaja?->foto_url }}" alt="{{ $p->remaja?->nama }}"
                                         class="w-9 h-9 rounded-full object-cover ring-2 ring-purple-200">
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $p->remaja?->nama }}</p>
                                        <p class="text-xs text-gray-500">{{ $p->remaja?->umur }} tahun</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $p->tanggal->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                                {{ $p->berat_badan ? $p->berat_badan . ' kg' : '-' }} /
                                {{ $p->tinggi_badan ? $p->tinggi_badan . ' cm' : '-' }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">{{ $p->bmi ?? '-' }}</td>
                            <td class="px-6 py-4">
                                @if($p->status_gizi)
                                    @php
                                        $colors = ['Normal' => 'green', 'Kurus' => 'yellow', 'Berisiko Kurus' => 'yellow', 'Gemuk' => 'orange', 'Berisiko Gemuk' => 'orange'];
                                        $c = $colors[$p->status_gizi] ?? 'gray';
                                    @endphp
                                    <span class="px-2 py-1 text-xs font-medium rounded-full
                                        bg-{{ $c }}-100 dark:bg-{{ $c }}-900/30 text-{{ $c }}-700 dark:text-{{ $c }}-400">
                                        {{ $p->status_gizi }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $p->user?->name ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                Belum ada pemeriksaan tercatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
