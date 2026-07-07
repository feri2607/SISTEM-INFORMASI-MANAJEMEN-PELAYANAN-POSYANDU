{{-- resources/views/warga/reproduksi/pelayanan-detail.blade.php --}}

@extends('layouts.public')

@section('title', 'Detail Pelayanan Reproduksi - Sistem Informasi Posyandu')

@section('page-title', '🩺 Detail Pelayanan')
@section('page-subtitle', 'Rincian pelayanan kesehatan reproduksi (Read Only).')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">Informasi Umum</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Tanggal Pelayanan</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $pelayanan->tanggal->format('d M Y') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Jenis Pelayanan</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $pelayanan->jenis_pelayanan_label }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Pegawai (Pemeriksa)</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $pelayanan->user->name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Jenis Kontrasepsi</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $pelayanan->jenis_kontrasepsi ?? 'Tidak Ada' }}</p>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/40 dark:to-blue-800/20 rounded-2xl shadow-sm border border-blue-100 dark:border-blue-800/50 p-6">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Hasil Pemeriksaan & Catatan</h3>
        <div class="space-y-4">
            <div>
                <p class="text-sm font-medium text-blue-700 dark:text-blue-300">Hasil Pemeriksaan</p>
                <div class="mt-1 p-3 bg-white dark:bg-gray-800 rounded-lg text-gray-800 dark:text-gray-200">
                    {{ $pelayanan->hasil_pemeriksaan ?? 'Tidak ada data hasil pemeriksaan' }}
                </div>
            </div>
            <div>
                <p class="text-sm font-medium text-blue-700 dark:text-blue-300">Catatan/Keluhan</p>
                <div class="mt-1 p-3 bg-white dark:bg-gray-800 rounded-lg text-gray-800 dark:text-gray-200">
                    {{ $pelayanan->catatan ?? 'Tidak ada catatan atau keluhan' }}
                </div>
            </div>
        </div>
    </div>

    @if($pelayanan->jadwal_kontrol_berikutnya)
    <div class="bg-gradient-to-br from-teal-50 to-teal-100 dark:from-teal-900/40 dark:to-teal-800/20 rounded-2xl shadow-sm border border-teal-100 dark:border-teal-800/50 p-6 flex items-center justify-between">
        <div>
            <h3 class="text-lg font-bold text-teal-900 dark:text-white">Jadwal Kontrol Berikutnya</h3>
            <p class="text-teal-700 dark:text-teal-300 mt-1">{{ $pelayanan->jadwal_kontrol_berikutnya->format('d M Y') }}</p>
        </div>
        <div class="p-3 bg-white/50 dark:bg-gray-800/50 rounded-full">
            <svg class="w-8 h-8 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
        </div>
    </div>
    @endif

    <div class="flex justify-end pt-4">
        <a href="{{ route('warga.reproduksi.index') }}" 
           class="px-6 py-2.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
            Kembali
        </a>
    </div>
</div>
@endsection
