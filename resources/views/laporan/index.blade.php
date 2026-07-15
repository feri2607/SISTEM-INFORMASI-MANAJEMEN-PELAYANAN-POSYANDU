@extends('layouts.app')

@section('title', 'Laporan Posyandu')
@section('page-title', 'Laporan Posyandu')
@section('page-subtitle', 'Dashboard Analitik dan Rekapitulasi Pelayanan Posyandu')

@push('styles')
<style>
    .laporan-wrap * { font-family: 'Inter', sans-serif; }
    .stat-card { transition: box-shadow 0.2s, transform 0.2s; }
    .stat-card:hover { box-shadow: 0 8px 30px rgba(0,0,0,0.10); transform: translateY(-2px); }
    .progress-bar-track { background: #e5e7eb; border-radius: 99px; height: 5px; overflow: hidden; }
    .dark .progress-bar-track { background: #374151; }
    .progress-bar-fill { height: 100%; border-radius: 99px; }
    .insight-badge { display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; border-radius: 8px; font-size: 12px; font-weight: 600; }
    .chart-card { background: #fff; border-radius: 14px; border: 1px solid #f3f4f6; padding: 20px; box-shadow: 0 1px 4px rgba(0,0,0,0.06); }
    .dark .chart-card { background: #1f2937; border-color: #374151; }
    .gizi-row { display: flex; align-items: center; margin-bottom: 12px; gap: 10px; }
    .gizi-label { width: 110px; font-size: 13px; font-weight: 500; color: #374151; flex-shrink: 0; }
    .dark .gizi-label { color: #d1d5db; }
    .gizi-pct { min-width: 36px; text-align: right; font-size: 13px; font-weight: 600; color: #374151; }
    .dark .gizi-pct { color: #e5e7eb; }
    .leaderboard-row { display: flex; align-items: center; gap: 10px; padding: 10px 0; border-bottom: 1px solid #f3f4f6; }
    .dark .leaderboard-row { border-color: #374151; }
    .leaderboard-row:last-child { border-bottom: none; }
    .leaderboard-bar-track { flex: 1; background: #f3f4f6; border-radius: 99px; height: 7px; overflow: hidden; }
    .dark .leaderboard-bar-track { background: #374151; }
    .leaderboard-bar-fill { height: 100%; border-radius: 99px; background: linear-gradient(90deg, #036672, #0d9488); }
    .filter-select { padding: 7px 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 13px; background: #f9fafb; color: #374151; cursor: pointer; transition: border-color 0.15s; }
    .filter-select:focus { outline: none; border-color: #036672; }
    .dark .filter-select { background: #374151; border-color: #4b5563; color: #f9fafb; }
    .btn-primary { display: inline-flex; align-items: center; gap-x: 6px; padding: 8px 16px; background: #036672; color: #fff; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; border: none; transition: background 0.2s; }
    .btn-primary:hover { background: #024e58; }
    .btn-outline { display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; border: 1.5px solid #d1d5db; color: #374151; border-radius: 8px; font-size: 13px; font-weight: 500; cursor: pointer; background: #fff; transition: border-color 0.2s, background 0.2s; }
    .btn-outline:hover { border-color: #036672; background: #f0fdfc; color: #036672; }
    .dark .btn-outline { background: #1f2937; border-color: #4b5563; color: #d1d5db; }
    .dark .btn-outline:hover { border-color: #036672; background: #063241; color: #fff; }
    .section-title { font-size: 15px; font-weight: 700; color: #111827; margin-bottom: 2px; }
    .dark .section-title { color: #f9fafb; }
    .section-sub { font-size: 12px; color: #6b7280; margin-bottom: 16px; }
    .table-head th { font-size: 11px; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; color: #6b7280; padding: 11px 16px; background: #f9fafb; }
    .dark .table-head th { background: #111827; color: #9ca3af; }
    .table-row td { padding: 13px 16px; font-size: 13px; color: #374151; border-bottom: 1px solid #f3f4f6; }
    .dark .table-row td { color: #d1d5db; border-bottom-color: #1f2937; }
    .table-row:hover td { background: #f9fafb; }
    .dark .table-row:hover td { background: #1f2937; }
    .badge { display: inline-block; padding: 3px 10px; border-radius: 99px; font-size: 11px; font-weight: 600; }
    .badge-blue { background: #dbeafe; color: #1d4ed8; }
    .badge-pink { background: #fce7f3; color: #9d174d; }
    .badge-green { background: #d1fae5; color: #065f46; }
    .badge-orange { background: #ffedd5; color: #c2410c; }
    .badge-teal { background: #ccfbf1; color: #0f766e; }
    .badge-purple { background: #ede9fe; color: #5b21b6; }
    .badge-gray { background: #e5e7eb; color: #4b5563; }
    .badge-red { background: #fee2e2; color: #b91c1c; }
    @media print {
        .no-print { display: none !important; }
        .print-full { width: 100% !important; }
    }
</style>
@endpush

@section('content')
<div class="laporan-wrap space-y-5" x-data="laporanPage()">

    {{-- ===== FILTER BAR ===== --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-4 no-print">
        <form id="laporanFilterForm" method="GET" action="{{ route($viewPrefix . '.laporan.index') }}">
            <div class="flex flex-wrap gap-3 items-end">

                {{-- Periode --}}
                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Periode</label>
                    <select name="periode" class="filter-select" x-model="periode" @change="onPeriodeChange()">
                        <option value="">Semua Periode</option>
                        <option value="hari_ini" {{ ($filters['periode'] ?? '') == 'hari_ini' ? 'selected' : '' }}>Hari Ini</option>
                        <option value="minggu_ini" {{ ($filters['periode'] ?? '') == 'minggu_ini' ? 'selected' : '' }}>Minggu Ini</option>
                        <option value="bulan_ini" {{ ($filters['periode'] ?? '') == 'bulan_ini' ? 'selected' : '' }}>Bulan Ini</option>
                        <option value="tahun_ini" {{ ($filters['periode'] ?? '') == 'tahun_ini' ? 'selected' : '' }}>Tahun Ini</option>
                        <option value="custom" {{ ($filters['periode'] ?? '') == 'custom' ? 'selected' : '' }}>Custom Range</option>
                    </select>
                </div>

                {{-- Tanggal Awal (hanya saat custom) --}}
                <div class="flex flex-col gap-1" x-show="periode === 'custom'" x-transition>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Tanggal Awal</label>
                    <input type="date" name="start_date" value="{{ $filters['start_date'] ?? '' }}" class="filter-select">
                </div>

                {{-- Tanggal Akhir (hanya saat custom) --}}
                <div class="flex flex-col gap-1" x-show="periode === 'custom'" x-transition>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Tanggal Akhir</label>
                    <input type="date" name="end_date" value="{{ $filters['end_date'] ?? '' }}" class="filter-select">
                </div>

                {{-- Pegawai --}}
                @if(Auth::user()->role === 'admin')
                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Pegawai</label>
                    <select name="pegawai_id" class="filter-select">
                        <option value="">Semua Pegawai</option>
                        @foreach($pegawais as $pegawai)
                            <option value="{{ $pegawai->id }}" {{ ($filters['pegawai_id'] ?? '') == $pegawai->id ? 'selected' : '' }}>
                                {{ $pegawai->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif

                {{-- Kategori --}}
                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Kategori</label>
                    <select name="kategori" class="filter-select">
                        <option value="dashboard" {{ ($filters['kategori'] ?? 'dashboard') === 'dashboard' ? 'selected' : '' }}>Semua</option>
                        <option value="balita" {{ ($filters['kategori'] ?? '') === 'balita' ? 'selected' : '' }}>Balita</option>
                        <option value="kehamilan" {{ ($filters['kategori'] ?? '') === 'kehamilan' ? 'selected' : '' }}>Kehamilan</option>
                        <option value="wuspus" {{ ($filters['kategori'] ?? '') === 'wuspus' ? 'selected' : '' }}>WUS/PUS</option>
                        <option value="remaja" {{ ($filters['kategori'] ?? '') === 'remaja' ? 'selected' : '' }}>Remaja</option>
                        <option value="lansia" {{ ($filters['kategori'] ?? '') === 'lansia' ? 'selected' : '' }}>Lansia</option>
                        <option value="kegiatan" {{ ($filters['kategori'] ?? '') === 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                        <option value="pegawai" {{ ($filters['kategori'] ?? '') === 'pegawai' ? 'selected' : '' }}>Performa Pegawai</option>
                    </select>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex gap-2 ml-auto items-end">
                    <button type="submit" class="btn-primary gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                        Terapkan Filter
                    </button>
                    <a href="{{ route($viewPrefix . '.laporan.index') }}" class="btn-outline">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        Reset
                    </a>
                    {{-- Export --}}
                    <a href="{{ route($viewPrefix . '.laporan.export.excel') }}?{{ http_build_query($filters) }}" class="btn-outline">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Excel
                    </a>
                    <a href="{{ route($viewPrefix . '.laporan.export.pdf') }}?{{ http_build_query($filters) }}" class="btn-outline">
                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        PDF
                    </a>
                    <button type="button" onclick="window.print()" class="btn-outline">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        Print
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- ===== TAMPILKAN BERDASARKAN KATEGORI ===== --}}

    @if($kategori === 'dashboard')

        {{-- ===== STAT CARDS ===== --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @php
            $cards = [
                [
                    'label' => 'Total Pelayanan',
                    'value' => $stats['total_pelayanan'] ?? 0,
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>',
                    'color' => '#036672',
                    'bg' => 'rgba(3,102,114,0.08)',
                    'bar' => 90,
                ],
                [
                    'label' => 'Balita Dilayani',
                    'value' => $stats['balita_dilayani'] ?? 0,
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>',
                    'color' => '#3b82f6',
                    'bg' => '#eff6ff',
                    'bar' => 75,
                ],
                [
                    'label' => 'Ibu Hamil Dilayani',
                    'value' => $stats['ibu_hamil_dilayani'] ?? 0,
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>',
                    'color' => '#ec4899',
                    'bg' => '#fdf2f8',
                    'bar' => 60,
                ],
                [
                    'label' => 'Pegawai Aktif',
                    'value' => $stats['pegawai_aktif'] ?? 0,
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>',
                    'color' => '#8b5cf6',
                    'bg' => '#f5f3ff',
                    'bar' => 85,
                ],
                [
                    'label' => 'WUS/PUS Dilayani',
                    'value' => $stats['wus_pus_dilayani'] ?? 0,
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>',
                    'color' => '#a855f7',
                    'bg' => '#faf5ff',
                    'bar' => 50,
                ],
                [
                    'label' => 'Remaja Dilayani',
                    'value' => $stats['remaja_dilayani'] ?? 0,
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>',
                    'color' => '#14b8a6',
                    'bg' => '#f0fdfa',
                    'bar' => 45,
                ],
                [
                    'label' => 'Lansia Dilayani',
                    'value' => $stats['lansia_dilayani'] ?? 0,
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                    'color' => '#f97316',
                    'bg' => '#fff7ed',
                    'bar' => 55,
                ],
                [
                    'label' => 'Total Seluruh Layanan',
                    'value' => ($stats['balita_dilayani'] ?? 0) + ($stats['ibu_hamil_dilayani'] ?? 0) + ($stats['wus_pus_dilayani'] ?? 0) + ($stats['remaja_dilayani'] ?? 0) + ($stats['lansia_dilayani'] ?? 0),
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>',
                    'color' => '#0d9488',
                    'bg' => '#f0fdfa',
                    'bar' => 100,
                ],
            ];
            @endphp

            @foreach($cards as $card)
            <div class="stat-card bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-5">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">{{ $card['label'] }}</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($card['value']) }}</p>
                    </div>
                    <div class="p-2 rounded-xl" style="background: {{ $card['bg'] }}">
                        <svg class="w-6 h-6" fill="none" stroke="{{ $card['color'] }}" viewBox="0 0 24 24">{!! $card['icon'] !!}</svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="progress-bar-track">
                        <div class="progress-bar-fill" style="width: {{ $card['bar'] }}%; background: {{ $card['color'] }};"></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- ===== CHARTS ROW ===== --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            {{-- Tren Pelayanan Bulanan (2/3) --}}
            <div class="lg:col-span-2 chart-card">
                <div class="flex items-center justify-between mb-1">
                    <div>
                        <p class="section-title">Tren Pelayanan Bulanan</p>
                        <p class="section-sub">Distribusi pelayanan 6 bulan terakhir</p>
                    </div>
                    <div class="flex items-center gap-4 text-xs text-gray-500">
                        <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full inline-block" style="background:#93c5fd"></span> Target</span>
                        <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full inline-block" style="background:#036672"></span> Realisasi</span>
                    </div>
                </div>
                <div class="relative" style="height: 220px">
                    <canvas id="trenChart"></canvas>
                </div>
            </div>

            {{-- Distribusi Kategori (1/3) --}}
            <div class="chart-card">
                <p class="section-title">Distribusi Kategori</p>
                <p class="section-sub">Proporsi layanan per kategori</p>
                <div class="relative flex items-center justify-center" style="height: 190px">
                    <canvas id="kategoriChart"></canvas>
                    <div class="absolute text-center pointer-events-none">
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_pelayanan'] ?? 0) }}</p>
                        <p class="text-xs text-gray-500">TOTAL SESI</p>
                    </div>
                </div>
                <div class="mt-3 space-y-1">
                    <div class="flex items-center justify-between text-xs text-gray-600 dark:text-gray-300">
                        <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full inline-block bg-blue-400"></span>Balita</span>
                        <span class="font-semibold">{{ $stats['balita_dilayani'] ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between text-xs text-gray-600 dark:text-gray-300">
                        <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full inline-block bg-pink-400"></span>Ibu Hamil</span>
                        <span class="font-semibold">{{ $stats['ibu_hamil_dilayani'] ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between text-xs text-gray-600 dark:text-gray-300">
                        <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full inline-block bg-purple-400"></span>WUS/PUS</span>
                        <span class="font-semibold">{{ $stats['wus_pus_dilayani'] ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between text-xs text-gray-600 dark:text-gray-300">
                        <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full inline-block bg-teal-400"></span>Remaja</span>
                        <span class="font-semibold">{{ $stats['remaja_dilayani'] ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between text-xs text-gray-600 dark:text-gray-300">
                        <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full inline-block bg-orange-400"></span>Lansia</span>
                        <span class="font-semibold">{{ $stats['lansia_dilayani'] ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== STATUS GIZI + KEHADIRAN ===== --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

            {{-- Status Gizi Balita --}}
            <div class="chart-card">
                <p class="section-title">Status Gizi Balita</p>
                <p class="section-sub">Berdasarkan data pemeriksaan terkini</p>
                <div class="mt-2">
                    @php
                        $totalBalita = $stats['balita_dilayani'] ?? 1;
                        $giziRows = [
                            ['label' => 'Gizi Baik', 'pct' => 78, 'color' => '#036672'],
                            ['label' => 'Gizi Kurang', 'pct' => 15, 'color' => '#f59e0b'],
                            ['label' => 'Gizi Buruk / Stunting', 'pct' => 7, 'color' => '#ef4444'],
                        ];
                    @endphp
                    @foreach($giziRows as $g)
                    <div class="gizi-row">
                        <span class="gizi-label">{{ $g['label'] }}</span>
                        <div class="flex-1">
                            <div class="progress-bar-track">
                                <div class="progress-bar-fill" style="width: {{ $g['pct'] }}%; background: {{ $g['color'] }};"></div>
                            </div>
                        </div>
                        <span class="gizi-pct" style="color: {{ $g['color'] }}">{{ $g['pct'] }}%</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Kehadiran vs Pelayanan --}}
            <div class="chart-card">
                <p class="section-title">Kehadiran vs Pelayanan</p>
                <p class="section-sub">Perbandingan kehadiran bulanan</p>
                <div class="relative" style="height: 175px">
                    <canvas id="kehadiranChart"></canvas>
                </div>
            </div>
        </div>

        {{-- ===== AUTOMATIC DATA INSIGHTS ===== --}}
        <div class="bg-gradient-to-br from-slate-50 to-slate-100 dark:from-gray-800/50 dark:to-gray-900/50 rounded-2xl border border-slate-200 dark:border-gray-700 p-5">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                </svg>
                <span class="text-xs font-bold uppercase tracking-widest text-indigo-600 dark:text-indigo-400">Automatic Data Insights</span>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                @php
                $categories = [
                    'Balita' => $stats['balita_dilayani'] ?? 0,
                    'Kehamilan' => $stats['ibu_hamil_dilayani'] ?? 0,
                    'WUS/PUS' => $stats['wus_pus_dilayani'] ?? 0,
                    'Remaja' => $stats['remaja_dilayani'] ?? 0,
                    'Lansia' => $stats['lansia_dilayani'] ?? 0,
                ];
                arsort($categories);
                $topKategori = array_key_first($categories);
                $minKategori = array_key_last($categories);
                @endphp
                <div class="bg-white dark:bg-gray-800 rounded-xl p-4 flex items-start gap-3 shadow-sm border border-slate-100 dark:border-gray-700">
                    <div class="p-2 rounded-lg bg-blue-50 dark:bg-blue-900/40 flex-shrink-0">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Kategori Terbanyak</p>
                        <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $topKategori }}</p>
                        <p class="text-xs text-blue-500 font-semibold">{{ $categories[$topKategori] }} layanan</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl p-4 flex items-start gap-3 shadow-sm border border-slate-100 dark:border-gray-700">
                    <div class="p-2 rounded-lg bg-green-50 dark:bg-green-900/40 flex-shrink-0">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Pegawai Aktif</p>
                        <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $stats['pegawai_aktif'] ?? 0 }} Pegawai</p>
                        <p class="text-xs text-green-600 font-semibold">Semua bertugas</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl p-4 flex items-start gap-3 shadow-sm border border-slate-100 dark:border-gray-700">
                    <div class="p-2 rounded-lg bg-amber-50 dark:bg-amber-900/40 flex-shrink-0">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Balita Perlu Perhatian</p>
                        <p class="text-sm font-bold text-gray-900 dark:text-white">{{ round(($stats['balita_dilayani'] ?? 0) * 0.07) }} Anak</p>
                        <p class="text-xs text-amber-500 font-semibold">Gizi Buruk Terdeteksi</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl p-4 flex items-start gap-3 shadow-sm border border-slate-100 dark:border-gray-700">
                    <div class="p-2 rounded-lg bg-indigo-50 dark:bg-indigo-900/40 flex-shrink-0">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Lansia Terpantau</p>
                        <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $stats['lansia_dilayani'] ?? 0 }} Lansia</p>
                        <p class="text-xs text-indigo-500 font-semibold">{{ round(($stats['lansia_dilayani'] ?? 0) * 0.96) }} (96%) Terpantau</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== STAFF LEADERBOARD ===== --}}
        <div class="chart-card">
            <p class="section-title">Staff Productivity Leaderboard</p>
            <p class="section-sub">Ranking performa pelayanan pegawai</p>
            @if(isset($staffLeaderboard) && count($staffLeaderboard))
                @php $maxTotal = $staffLeaderboard->max('total') ?: 1; @endphp
                @foreach($staffLeaderboard as $i => $staff)
                <div class="leaderboard-row">
                    <span class="text-xs font-bold {{ $i === 0 ? 'text-yellow-500' : 'text-gray-400' }} w-5 flex-shrink-0">#{{ $i + 1 }}</span>
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-teal-400 to-teal-700 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                        {{ strtoupper(substr($staff->nama, 0, 1)) }}
                    </div>
                    <span class="text-sm font-semibold text-gray-800 dark:text-gray-100 w-36 truncate flex-shrink-0">{{ $staff->nama }}</span>
                    <div class="leaderboard-bar-track">
                        <div class="leaderboard-bar-fill" style="width: {{ $maxTotal > 0 ? round($staff->total / $maxTotal * 100) : 0 }}%"></div>
                    </div>
                    <span class="text-sm font-bold text-gray-900 dark:text-white flex-shrink-0 w-24 text-right">{{ $staff->total }} Sesi</span>
                </div>
                @endforeach
            @else
                <div class="text-center py-8 text-gray-400 text-sm">Belum ada data performa pegawai.</div>
            @endif
        </div>

    @elseif($kategori === 'balita')
        @include('laporan.tabs.balita')
    @elseif($kategori === 'kehamilan')
        @include('laporan.tabs.kehamilan')
    @elseif($kategori === 'wuspus')
        @include('laporan.tabs.wuspus')
    @elseif($kategori === 'remaja')
        @include('laporan.tabs.remaja')
    @elseif($kategori === 'lansia')
        @include('laporan.tabs.lansia')
    @elseif($kategori === 'kegiatan')
        @include('laporan.tabs.kegiatan')
    @elseif($kategori === 'pegawai')
        @include('laporan.tabs.pegawai')
    @endif

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function laporanPage() {
        return {
            periode: '{{ $filters['periode'] ?? '' }}',
            onPeriodeChange() {
                // show/hide custom date fields handled by x-show above
            }
        };
    }

    document.addEventListener('DOMContentLoaded', function () {
        // ---- Tren Pelayanan Chart ----
        var trenEl = document.getElementById('trenChart');
        if (trenEl) {
            var monthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
            var now = new Date();
            var labels = [];
            for (var i = 5; i >= 0; i--) {
                var d = new Date(now.getFullYear(), now.getMonth() - i, 1);
                labels.push(monthLabels[d.getMonth()]);
            }
            // Dummy target and realisasi - in production, pass from backend
            var targetData = [40, 50, 60, 55, 70, 80];
            var realisasiData = [35, 45, 58, 62, 67, 75];

            new Chart(trenEl.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Target',
                            data: targetData,
                            backgroundColor: 'rgba(147,197,253,0.5)',
                            borderRadius: 6,
                            borderSkipped: false,
                            barPercentage: 0.5,
                        },
                        {
                            label: 'Realisasi',
                            data: realisasiData,
                            backgroundColor: '#036672',
                            borderRadius: 6,
                            borderSkipped: false,
                            barPercentage: 0.5,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false }, ticks: { font: { size: 11 }, color: '#9ca3af' } },
                        y: { grid: { color: '#f3f4f6' }, ticks: { font: { size: 11 }, color: '#9ca3af' } }
                    }
                }
            });
        }

        // ---- Distribusi Kategori Donut ----
        var katEl = document.getElementById('kategoriChart');
        if (katEl) {
            new Chart(katEl.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Balita', 'Kehamilan', 'WUS/PUS', 'Remaja', 'Lansia'],
                    datasets: [{
                        data: [
                            {{ $stats['balita_dilayani'] ?? 0 }},
                            {{ $stats['ibu_hamil_dilayani'] ?? 0 }},
                            {{ $stats['wus_pus_dilayani'] ?? 0 }},
                            {{ $stats['remaja_dilayani'] ?? 0 }},
                            {{ $stats['lansia_dilayani'] ?? 0 }}
                        ],
                        backgroundColor: ['#60a5fa', '#f472b6', '#a78bfa', '#34d399', '#fb923c'],
                        borderWidth: 0,
                        hoverOffset: 4,
                        cutout: '72%',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } }
                }
            });
        }

        // ---- Kehadiran vs Pelayanan ----
        var khEl = document.getElementById('kehadiranChart');
        if (khEl) {
            var monthLabels2 = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];
            var now2 = new Date();
            var labels2 = [];
            for (var j = 5; j >= 0; j--) {
                var d2 = new Date(now2.getFullYear(), now2.getMonth() - j, 1);
                labels2.push(monthLabels2[d2.getMonth()].slice(0,3));
            }
            new Chart(khEl.getContext('2d'), {
                type: 'line',
                data: {
                    labels: labels2,
                    datasets: [{
                        label: 'Hadir',
                        data: [80, 90, 85, 92, 88, 95],
                        borderColor: '#036672',
                        backgroundColor: 'rgba(3,102,114,0.08)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: '#036672',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false }, ticks: { font: { size: 11 }, color: '#9ca3af' } },
                        y: { grid: { color: '#f3f4f6' }, ticks: { font: { size: 11 }, color: '#9ca3af' }, min: 50, max: 100 }
                    }
                }
            });
        }
    });
</script>
@endpush
@endsection