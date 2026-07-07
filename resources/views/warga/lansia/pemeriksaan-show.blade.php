{{-- resources/views/warga/lansia/pemeriksaan-show.blade.php --}}

@extends('layouts.public')

@section('hide-footer', true)
@section('title', 'Detail Pemeriksaan - Sistem Informasi Posyandu')
@section('page-title', '🩺 Detail Pemeriksaan')
@section('page-subtitle', 'Detail hasil pemeriksaan kesehatan lansia.')

@section('content')
<div class="max-w-2xl mx-auto space-y-4">

    <a href="{{ route('warga.lansia.show', $pemeriksaan->lansia) }}"
       class="inline-flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 hover:text-teal-600 dark:hover:text-teal-400 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali
    </a>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden border border-gray-100 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-teal-50 to-cyan-50 dark:from-teal-900/20 dark:to-cyan-900/20">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $pemeriksaan->lansia->nama }}</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Pemeriksaan: {{ $pemeriksaan->tanggal->format('d M Y') }}</p>
                </div>
                <div class="text-3xl">🩺</div>
            </div>
        </div>

        <div class="p-6 space-y-4">

            {{-- Grid Data Pemeriksaan --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                @php
                    $items = [
                        ['label' => 'Tekanan Darah', 'value' => $pemeriksaan->tekanan_darah ? $pemeriksaan->tekanan_darah . ' mmHg' : '-', 'icon' => '🩺', 'color' => 'red'],
                        ['label' => 'Gula Darah',    'value' => $pemeriksaan->gula_darah ? number_format($pemeriksaan->gula_darah, 1) . ' mg/dL' : '-', 'icon' => '🩸', 'color' => 'orange'],
                        ['label' => 'Kolesterol',    'value' => $pemeriksaan->kolesterol ? number_format($pemeriksaan->kolesterol, 1) . ' mg/dL' : '-', 'icon' => '💊', 'color' => 'yellow'],
                        ['label' => 'Berat Badan',   'value' => $pemeriksaan->berat_badan ? $pemeriksaan->berat_badan . ' kg' : '-', 'icon' => '⚖️', 'color' => 'blue'],
                        ['label' => 'Tinggi Badan',  'value' => $pemeriksaan->tinggi_badan ? $pemeriksaan->tinggi_badan . ' cm' : '-', 'icon' => '📏', 'color' => 'purple'],
                        ['label' => 'IMT',           'value' => $pemeriksaan->imt ? number_format($pemeriksaan->imt, 2) . ' (' . $pemeriksaan->status_imt . ')' : '-', 'icon' => '📈', 'color' => 'green'],
                    ];
                    $colorMap = [
                        'red'=>'bg-red-50 dark:bg-red-900/20 border-red-100 dark:border-red-900',
                        'orange'=>'bg-orange-50 dark:bg-orange-900/20 border-orange-100 dark:border-orange-900',
                        'yellow'=>'bg-yellow-50 dark:bg-yellow-900/20 border-yellow-100 dark:border-yellow-900',
                        'blue'=>'bg-blue-50 dark:bg-blue-900/20 border-blue-100 dark:border-blue-900',
                        'purple'=>'bg-purple-50 dark:bg-purple-900/20 border-purple-100 dark:border-purple-900',
                        'green'=>'bg-green-50 dark:bg-green-900/20 border-green-100 dark:border-green-900',
                    ];
                @endphp
                @foreach($items as $item)
                    <div class="{{ $colorMap[$item['color']] }} rounded-xl border p-4">
                        <div class="text-xl mb-1">{{ $item['icon'] }}</div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">{{ $item['label'] }}</p>
                        <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $item['value'] }}</p>
                    </div>
                @endforeach
            </div>

            {{-- Lingkar Perut (optional) --}}
            @if($pemeriksaan->lingkar_perut)
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Lingkar Perut</p>
                    <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $pemeriksaan->lingkar_perut }} cm</p>
                </div>
            @endif

            {{-- Catatan Pegawai --}}
            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-4 border border-blue-100 dark:border-blue-900">
                <p class="text-xs font-medium text-blue-600 dark:text-blue-400 mb-2">💬 Catatan Pegawai</p>
                <p class="text-sm text-gray-800 dark:text-gray-200">{{ $pemeriksaan->catatan ?: 'Tidak ada catatan.' }}</p>
            </div>

            {{-- Metadata --}}
            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 pt-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span>Pegawai: <strong class="text-gray-800 dark:text-gray-200">{{ $pemeriksaan->user->name ?? '-' }}</strong></span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>{{ $pemeriksaan->tanggal->format('d M Y') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
