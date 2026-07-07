{{-- resources/views/warga/reproduksi/show.blade.php --}}

@extends('layouts.public')

@section('title', 'Detail Profil WUS/PUS - Sistem Informasi Posyandu')

@section('page-title', '🩺 Profil Kesehatan Reproduksi')
@section('page-subtitle', 'Menampilkan rincian data Wanita Usia Subur (WUS) & Pasangan Usia Subur (PUS) terdaftar.')

@section('content')
<div class="container mx-auto px-4 max-w-4xl py-6 animate-fade-in-up">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Detail Profil</h2>
            <p class="mt-1 text-gray-500 dark:text-gray-400">Seluruh data kesehatan Anda tersimpan aman dan terintegrasi.</p>
        </div>
        <a href="{{ route('warga.reproduksi.index') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
    </div>

    <!-- Data WUS Section -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-800/80">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white tracking-wide">Data WUS (Wanita Usia Subur)</h3>
            <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full 
                @if($wus->is_verified) bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400
                @else bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 @endif shadow-sm">
                {{ $wus->status_verifikasi_label }}
            </span>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="col-span-1 flex flex-col items-center justify-center p-4">
                <div class="relative group">
                    <img src="{{ $wus->foto_url }}" alt="Foto {{ $wus->nama }}" class="w-40 h-40 object-cover rounded-full shadow-lg border-4 border-teal-100 dark:border-teal-900 group-hover:scale-105 transition-transform duration-300">
                </div>
            </div>
            
            <div class="col-span-1 md:col-span-2 grid grid-cols-2 gap-4">
                <div class="bg-gray-50 dark:bg-gray-700/30 p-3 rounded-lg border border-gray-100 dark:border-gray-600">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Nama Lengkap</p>
                    <p class="font-bold text-gray-900 dark:text-white">{{ $wus->nama }}</p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700/30 p-3 rounded-lg border border-gray-100 dark:border-gray-600">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">NIK</p>
                    <p class="font-bold text-gray-900 dark:text-white">{{ $wus->nik }}</p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700/30 p-3 rounded-lg border border-gray-100 dark:border-gray-600">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Tanggal Lahir / Umur</p>
                    <p class="font-bold text-gray-900 dark:text-white">{{ $wus->tanggal_lahir->format('d M Y') }} <span class="text-teal-600 dark:text-teal-400">({{ $wus->umur }} thn)</span></p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700/30 p-3 rounded-lg border border-gray-100 dark:border-gray-600">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Status Pernikahan</p>
                    <p class="font-bold text-gray-900 dark:text-white">{{ $wus->status_pernikahan ?? '-' }}</p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700/30 p-3 rounded-lg border border-gray-100 dark:border-gray-600">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Golongan Darah</p>
                    <p class="font-bold text-gray-900 dark:text-white flex items-center">
                        <svg class="w-4 h-4 text-red-500 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                        {{ $wus->golongan_darah ?? '-' }}
                    </p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700/30 p-3 rounded-lg border border-gray-100 dark:border-gray-600">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Nomor HP</p>
                    <p class="font-bold text-gray-900 dark:text-white">{{ $wus->no_hp ?? '-' }}</p>
                </div>
                <div class="col-span-2 bg-gray-50 dark:bg-gray-700/30 p-3 rounded-lg border border-gray-100 dark:border-gray-600">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Alamat</p>
                    <p class="font-medium text-gray-900 dark:text-white">{{ $wus->alamat ?? '-' }}</p>
                </div>
                <div class="col-span-2 bg-gray-50 dark:bg-gray-700/30 p-3 rounded-lg border border-gray-100 dark:border-gray-600">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Riwayat Penyakit</p>
                    <p class="font-medium text-gray-900 dark:text-white">{{ $wus->riwayat_penyakit ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Data PUS Section -->
    @if($pus)
    <div class="bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-2xl shadow-sm border border-indigo-100 dark:border-indigo-800/50 overflow-hidden">
        <div class="px-6 py-4 border-b border-indigo-100 dark:border-indigo-800/50 flex justify-between items-center bg-white/50 dark:bg-gray-800/50">
            <h3 class="text-lg font-semibold text-indigo-900 dark:text-indigo-100 tracking-wide flex items-center">
                <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                Data PUS (Pasangan Usia Subur)
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white/80 dark:bg-gray-800/80 p-4 rounded-xl border border-indigo-50 dark:border-indigo-800/30 shadow-sm transition-transform hover:-translate-y-1">
                    <p class="text-xs text-indigo-500 dark:text-indigo-400 uppercase tracking-wider mb-1">Nama Pasangan</p>
                    <p class="font-bold text-gray-900 dark:text-white">{{ $pus->nama_pasangan }}</p>
                </div>
                <div class="bg-white/80 dark:bg-gray-800/80 p-4 rounded-xl border border-indigo-50 dark:border-indigo-800/30 shadow-sm transition-transform hover:-translate-y-1">
                    <p class="text-xs text-indigo-500 dark:text-indigo-400 uppercase tracking-wider mb-1">Jumlah Anak</p>
                    <p class="font-bold text-gray-900 dark:text-white text-2xl flex items-center text-teal-600">
                        {{ $pus->jumlah_anak }}
                        <svg class="w-5 h-5 ml-1 text-teal-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>    
                    </p>
                </div>
                <div class="bg-white/80 dark:bg-gray-800/80 p-4 rounded-xl border border-indigo-50 dark:border-indigo-800/30 shadow-sm transition-transform hover:-translate-y-1">
                    <p class="text-xs text-indigo-500 dark:text-indigo-400 uppercase tracking-wider mb-1">Status KB</p>
                    <p class="font-bold text-gray-900 dark:text-white flex items-center">
                        <span class="w-2 h-2 rounded-full @if($pus->status_kb === 'aktif') bg-green-500 @else bg-gray-400 @endif mr-2"></span>
                        {{ $pus->status_kb_label }}
                    </p>
                </div>
                <div class="bg-white/80 dark:bg-gray-800/80 p-4 rounded-xl border border-indigo-50 dark:border-indigo-800/30 shadow-sm transition-transform hover:-translate-y-1">
                    <p class="text-xs text-indigo-500 dark:text-indigo-400 uppercase tracking-wider mb-1">Jenis Kontrasepsi</p>
                    <p class="font-bold text-gray-900 dark:text-white">{{ $pus->jenis_kontrasepsi ?? 'Tidak/Belum Menggunakan' }}</p>
                </div>
                <div class="col-span-2 bg-white/80 dark:bg-gray-800/80 p-4 rounded-xl border border-indigo-50 dark:border-indigo-800/30 shadow-sm transition-transform hover:-translate-y-1">
                    <p class="text-xs text-indigo-500 dark:text-indigo-400 uppercase tracking-wider mb-1">Tanggal Mulai KB</p>
                    <p class="font-bold text-gray-900 dark:text-white">{{ $pus->tanggal_mulai_kb ? $pus->tanggal_mulai_kb->format('d F Y') : '-' }}</p>
                </div>
                <div class="col-span-2 bg-white/80 dark:bg-gray-800/80 p-4 rounded-xl border border-indigo-50 dark:border-indigo-800/30 shadow-sm transition-transform hover:-translate-y-1">
                    <p class="text-xs text-indigo-500 dark:text-indigo-400 uppercase tracking-wider mb-1">Jadwal Kontrol PUS</p>
                    <p class="font-bold text-gray-900 dark:text-white">{{ $pus->jadwal_kontrol ? $pus->jadwal_kontrol->format('d F Y') : '-' }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
