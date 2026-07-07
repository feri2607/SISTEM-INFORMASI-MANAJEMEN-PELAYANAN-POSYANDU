{{-- resources/views/pelayanan/show.blade.php --}}

@extends('layouts.app')

@section('title', 'Detail Riwayat Pelayanan - Sistem Informasi Posyandu')
@section('page-title', 'Detail Riwayat Pelayanan')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route(auth()->user()->role === 'admin' ? 'admin.pelayanan.index' : 'pegawai.pelayanan.index') }}" class="flex items-center text-gray-600 dark:text-gray-400 hover:text-blue-600 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar
        </a>
        <a href="{{ route('admin.pelayanan.print', $pelayanan->id) }}" target="_blank" class="px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg transition text-sm flex items-center shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Cetak Detail
        </a>
    </div>

    {{-- Main Content --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Kolom Data Utama --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Kartu Info Peserta & Kegiatan --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border-t-4 border-blue-500">
                <div class="flex items-start gap-4 mb-6">
                    <img src="{{ $pelayanan->balita ? $pelayanan->balita->foto_url : 'https://ui-avatars.com/api/?name=NN' }}" alt="" class="h-20 w-20 rounded-xl object-cover shadow-sm border border-gray-100">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $pelayanan->balita ? $pelayanan->balita->nama : 'Umum' }}</h3>
                        <p class="text-gray-500 text-sm mt-1">NIK: {{ $pelayanan->balita ? $pelayanan->balita->nik : '-' }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm mt-4">
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <span class="block text-gray-500 dark:text-gray-400 mb-1">Kegiatan Ref</span>
                        <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $pelayanan->kegiatan ? $pelayanan->kegiatan->nama_kegiatan : '-' }}</span>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <span class="block text-gray-500 dark:text-gray-400 mb-1">Tanggal & Waktu</span>
                        <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $pelayanan->created_at->format('d F Y, H:i') }}</span>
                    </div>
                </div>
            </div>

            {{-- Kartu Hasil Medis --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
                <h4 class="font-bold text-gray-900 dark:text-white text-lg mb-4 flex items-center border-b pb-2">
                    <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    Data Medis (Antropometri)
                </h4>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg shadow-sm border border-gray-100 dark:border-gray-600">
                        <span class="block text-xs font-medium text-gray-500 mb-1">Berat Badan</span>
                        <span class="text-xl font-bold text-gray-900 dark:text-white">{{ $pelayanan->berat_badan }} <span class="text-xs font-normal">kg</span></span>
                    </div>
                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg shadow-sm border border-gray-100 dark:border-gray-600">
                        <span class="block text-xs font-medium text-gray-500 mb-1">Tinggi Badan</span>
                        <span class="text-xl font-bold text-gray-900 dark:text-white">{{ $pelayanan->tinggi_badan }} <span class="text-xs font-normal">cm</span></span>
                    </div>
                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg shadow-sm border border-gray-100 dark:border-gray-600">
                        <span class="block text-xs font-medium text-gray-500 mb-1">L. Kepala</span>
                        <span class="text-xl font-bold text-gray-900 dark:text-white">{{ $pelayanan->lingkar_kepala }} <span class="text-xs font-normal">cm</span></span>
                    </div>
                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg shadow-sm border border-gray-100 dark:border-gray-600">
                        <span class="block text-xs font-medium text-gray-500 mb-1">Status Gizi</span>
                        <span class="text-sm font-bold {{ $pelayanan->status_gizi === 'normal' ? 'text-green-600' : 'text-yellow-600' }}">{{ strtoupper($pelayanan->status_gizi) }}</span>
                    </div>
                </div>
            </div>
            
            {{-- Intervensi --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
                <h4 class="font-bold text-gray-900 dark:text-white text-lg mb-4 flex items-center border-b pb-2">
                    <svg class="w-5 h-5 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                    Intervensi Tambahan
                </h4>
                
                <div class="space-y-4">
                    <div>
                        <span class="font-semibold text-gray-700 dark:text-gray-300">Imunisasi Diberikan:</span>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">
                            @if(is_array(json_decode($pelayanan->imunisasi)))
                                {{ implode(', ', json_decode($pelayanan->imunisasi)) }}
                            @else
                                {{ $pelayanan->imunisasi ?: 'Tidak ada.' }}
                            @endif
                        </p>
                    </div>
                    <div>
                        <span class="font-semibold text-gray-700 dark:text-gray-300">Vitamin Diberikan:</span>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">
                            @if(is_array(json_decode($pelayanan->vitamin)))
                                {{ implode(', ', json_decode($pelayanan->vitamin)) }}
                            @else
                                {{ $pelayanan->vitamin ?: 'Tidak ada.' }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            
            {{-- Catatan --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
                <h4 class="font-bold text-gray-900 dark:text-white text-lg mb-4 flex items-center border-b pb-2">Catatan Pemeriksaan</h4>
                <div class="bg-blue-50 dark:bg-gray-700 p-4 rounded-lg text-gray-700 dark:text-gray-300">
                    {{ $pelayanan->catatan ?: 'Tidak ada catatan khusus yang ditambahkan oleh petugas pemeriksa.' }}
                </div>
            </div>

        </div>

        {{-- Kolom Sidebar --}}
        <div class="lg:col-span-1 space-y-6">
            {{-- Petugas --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
                <h4 class="font-bold text-gray-900 dark:text-white text-md mb-4 border-b pb-2">Informasi Petugas</h4>
                <div class="flex items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($pelayanan->user ? $pelayanan->user->name : 'Ad') }}&background=EBF4FF&color=4299E1" alt="" class="h-10 w-10 rounded-full">
                    <div>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $pelayanan->user ? $pelayanan->user->name : 'Admin System' }}</p>
                        <p class="text-xs text-gray-500">Pemeriksa / Kader</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection