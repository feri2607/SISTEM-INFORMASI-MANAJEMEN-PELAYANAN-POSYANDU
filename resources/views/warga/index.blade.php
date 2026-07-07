{{-- resources/views/warga/index.blade.php --}}
@extends('layouts.public')

@section('hide-footer', true)

@section('title', 'Detail Identitas Warga - Sistem Informasi Posyandu')

@push('styles')
<style>
    .card-shadow { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03); }
    .glassmorphism { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); }
    .dark .glassmorphism { background: rgba(31, 41, 55, 0.95); }
    .bg-gradient-header { background: linear-gradient(135deg, #f0f7ff 0%, #ffffff 100%); }
    .dark .bg-gradient-header { background: linear-gradient(135deg, #1f2937 0%, #111827 100%); }
</style>
@endpush

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    {{-- Header Content --}}
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-2">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
            Detail Identitas Warga
        </h2>
    </div>

    {{-- Top Profile Card --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 md:p-8 card-shadow border border-gray-100 dark:border-gray-700 bg-gradient-header relative overflow-hidden">
        {{-- Background Ornament --}}
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-blue-50 dark:bg-blue-900/20 blur-3xl opacity-50"></div>
        
        <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
                {{-- Avatar --}}
                <div class="relative">
                    <div class="w-28 h-28 rounded-xl overflow-hidden shadow-lg border-4 border-white dark:border-gray-700 bg-gray-200">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($warga->nama) }}&background=0D8ABC&color=fff&size=256&font-size=0.33" alt="{{ $warga->nama }}" class="w-full h-full object-cover">
                    </div>
                    <div class="absolute -bottom-2 -right-2 bg-[#036672] text-white p-1.5 rounded-lg shadow-md border-2 border-white dark:border-gray-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                </div>

                {{-- User Details --}}
                <div class="text-center sm:text-left mt-2">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-3 mb-2">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white leading-tight">
                            {{ $warga->nama }}
                        </h3>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-400 border border-green-200 dark:border-green-800">
                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ ucfirst($warga->verification_status ?? 'Terverifikasi') }}
                        </span>
                    </div>
                    <div class="text-gray-500 dark:text-gray-400 text-sm mb-3">
                        NIK: <span class="font-medium text-gray-700 dark:text-gray-300">{{ $warga->nik ?: '-' }}</span>
                    </div>
                    <div class="flex flex-wrap justify-center sm:justify-start gap-4 text-sm text-gray-600 dark:text-gray-400">
                        @if(isset($warga->email) || (isset($warga->user) && $warga->user->email))
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            {{ $warga->email ?? ($warga->user->email ?? '-') }}
                        </div>
                        @endif
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            {{ $warga->telepon ?: '-' }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Last Updated --}}
            <div class="hidden md:flex flex-col items-end text-sm">
                <span class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">Terakhir Diperbarui</span>
                <span class="font-bold text-gray-800 dark:text-gray-200">{{ $warga->updated_at ? $warga->updated_at->isoFormat('D MMMM YYYY') : '-' }}</span>
            </div>
        </div>
    </div>

    {{-- Main Body Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Middle Left: Informasi Pribadi --}}
        <div class="col-span-1 lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-100 dark:border-gray-700">
            <div class="flex items-center mb-6">
                <div class="p-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg mr-3 text-blue-600 dark:text-blue-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informasi Pribadi</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                <div>
                    <span class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Nomor Induk Kependudukan (NIK)</span>
                    <span class="block text-sm font-semibold text-gray-900 dark:text-white">{{ $warga->nik ?: '-' }}</span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Nomor Kartu Keluarga (KK)</span>
                    <span class="block text-sm font-semibold text-gray-900 dark:text-white">{{ $warga->nomor_kk ?: '-' }}</span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Tempat, Tanggal Lahir</span>
                    <span class="block text-sm font-semibold text-gray-900 dark:text-white">
                        {{ $warga->tempat_lahir ?: '-' }}, {{ $warga->tanggal_lahir ? $warga->tanggal_lahir->format('d M Y') : '-' }}
                    </span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Jenis Kelamin</span>
                    <span class="block text-sm font-semibold text-gray-900 dark:text-white">
                        @if($warga->jenis_kelamin == 'L') Laki-laki @elseif($warga->jenis_kelamin == 'P') Perempuan @else - @endif
                    </span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Golongan Darah</span>
                    @if($warga->golongan_darah)
                        <span class="inline-flex px-2 py-0.5 rounded bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 text-sm font-bold border border-blue-100 dark:border-blue-800">
                            {{ $warga->golongan_darah }}
                        </span>
                    @else
                        <span class="block text-sm font-semibold text-gray-900 dark:text-white">-</span>
                    @endif
                </div>
                <div>
                    <span class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Agama</span>
                    <span class="block text-sm font-semibold text-gray-900 dark:text-white">{{ $warga->agama ?: '-' }}</span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Pendidikan Terakhir</span>
                    <span class="block text-sm font-semibold text-gray-900 dark:text-white">{{ $warga->pendidikan ?: '-' }}</span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Pekerjaan</span>
                    <span class="block text-sm font-semibold text-gray-900 dark:text-white">{{ $warga->pekerjaan ?: '-' }}</span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Status Pernikahan</span>
                    <span class="block text-sm font-semibold text-gray-900 dark:text-white">{{ $warga->status_pernikahan ?: '-' }}</span>
                </div>
            </div>
        </div>

        {{-- Middle Right: Kontak & Alamat --}}
        <div class="col-span-1 lg:col-span-1 bg-white dark:bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-100 dark:border-gray-700 flex flex-col">
            <div class="flex items-center mb-6">
                <div class="p-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg mr-3 text-blue-600 dark:text-blue-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Kontak & Alamat</h3>
            </div>

            <div class="space-y-4 flex-grow mb-6">
                <div>
                    <span class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Alamat Lengkap</span>
                    <span class="block text-sm font-medium text-gray-900 dark:text-white leading-relaxed">
                        {{ $warga->alamat ?: '-' }}<br>
                        @if($warga->rt || $warga->rw)
                            RT {{ $warga->rt ?: '-' }} / RW {{ $warga->rw ?: '-' }},
                        @endif
                        @if($warga->dusun) Dusun {{ $warga->dusun }}, @endif
                        @if($warga->desa) Desa/Kel. {{ $warga->desa }} @endif
                    </span>
                </div>
                
                <div class="grid grid-cols-2 gap-4 pt-2">
                    <div>
                        <span class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Kecamatan</span>
                        <span class="block text-sm font-semibold text-gray-900 dark:text-white">{{ $warga->kecamatan ?: '-' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Kabupaten/Kota</span>
                        <span class="block text-sm font-semibold text-gray-900 dark:text-white">{{ $warga->kabupaten ?: '-' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Provinsi</span>
                        <span class="block text-sm font-semibold text-gray-900 dark:text-white">{{ $warga->provinsi ?: '-' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Kode Pos</span>
                        <span class="block text-sm font-semibold text-gray-900 dark:text-white">{{ $warga->kode_pos ?: '-' }}</span>
                    </div>
                </div>
            </div>

            {{-- Map/Location Box --}}
            <div class="w-full h-36 bg-gray-100 dark:bg-gray-700 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-600 relative">
                <img src="https://placehold.co/400x200/e2e8f0/64748b?text=Lokasi+Posyandu" alt="Map View" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/60 to-transparent flex items-end">
                    <span class="text-white text-xs p-3 font-medium flex items-center shadow-sm">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>
                        Tampilkan Peta (Ilustrasi)
                    </span>
                </div>
            </div>
        </div>

        {{-- Bottom Left: Dokumen Administrasi --}}
        <div class="col-span-1 lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl p-6 card-shadow border border-gray-100 dark:border-gray-700">
            <div class="flex items-center mb-6">
                <div class="p-2 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg mr-3 text-indigo-600 dark:text-indigo-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Dokumen Administrasi</h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                {{-- KTP View --}}
                <div class="relative bg-indigo-50/50 dark:bg-indigo-900/10 rounded-xl p-4 border border-indigo-100 dark:border-indigo-800/50 flex flex-col h-full">
                    <div class="flex items-center text-indigo-800 dark:text-indigo-300 font-semibold text-sm mb-3">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                        </svg>
                        KARTU TANDA PENDUDUK
                    </div>
                    <div class="flex-grow bg-white dark:bg-gray-800 rounded-lg p-2 shadow-sm border border-gray-200 dark:border-gray-700 flex items-center justify-center min-h-[140px] overflow-hidden group">
                        @if($warga->ktp_path)
                            <img src="{{ Storage::url($warga->ktp_path) }}" alt="KTP" class="max-w-full max-h-full object-contain rounded transition duration-300 group-hover:scale-105">
                        @else
                            <div class="text-gray-400 dark:text-gray-500 text-xs text-center flex flex-col items-center">
                                <svg class="w-8 h-8 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Tidak Ada KTP
                            </div>
                        @endif
                    </div>
                </div>

                {{-- KK View --}}
                <div class="relative bg-indigo-50/50 dark:bg-indigo-900/10 rounded-xl p-4 border border-indigo-100 dark:border-indigo-800/50 flex flex-col h-full">
                    <div class="flex items-center text-indigo-800 dark:text-indigo-300 font-semibold text-sm mb-3">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        KARTU KELUARGA
                    </div>
                    <div class="flex-grow bg-white dark:bg-gray-800 rounded-lg p-2 shadow-sm border border-gray-200 dark:border-gray-700 flex items-center justify-center min-h-[140px] overflow-hidden group">
                        @if($warga->kk_path)
                            <img src="{{ Storage::url($warga->kk_path) }}" alt="KK" class="max-w-full max-h-full object-contain rounded transition duration-300 group-hover:scale-105">
                        @else
                            <div class="text-gray-400 dark:text-gray-500 text-xs text-center flex flex-col items-center">
                                <svg class="w-8 h-8 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Tidak Ada KK
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3 border border-gray-200 dark:border-gray-600">
                    <span class="block text-xs font-medium text-gray-500 dark:text-gray-400">Nomor BPJS Kesehatan</span>
                    <span class="block mt-1 text-sm font-bold text-gray-900 dark:text-white tracking-widest text-indigo-700 dark:text-indigo-400">{{ $warga->bpjs_number ?: '-' }}</span>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3 border border-gray-200 dark:border-gray-600">
                    <span class="block text-xs font-medium text-gray-500 dark:text-gray-400">Nomor JKN / KIS</span>
                    <span class="block mt-1 text-sm font-bold text-gray-900 dark:text-white tracking-widest text-indigo-700 dark:text-indigo-400">{{ $warga->kis_number ?: ($warga->jkn_number ?: '-') }}</span>
                </div>
            </div>
        </div>

        {{-- Bottom Right: Riwayat Verifikasi --}}
        <div class="col-span-1 lg:col-span-1 border border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-2xl p-6 card-shadow flex flex-col justify-between">
            
            <div>
                <div class="flex items-center mb-6">
                    <div class="p-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg mr-3 text-blue-600 dark:text-blue-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Riwayat Verifikasi</h3>
                </div>

                <div class="relative pl-6 ml-2 space-y-6 before:absolute before:inset-0 before:ml-2 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-gray-200 before:to-transparent dark:before:from-gray-700">
                    
                    {{-- Verified Event --}}
                    @if(in_array($warga->verification_status, ['verified', 'approved']))
                    <div class="relative">
                        <div class="absolute left-[-24px] bg-green-500 rounded-full w-4 h-4 shadow ring-4 ring-white dark:ring-gray-800 flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div class="flex justify-between items-start mb-1">
                            <h4 class="text-xs font-bold text-gray-900 dark:text-white">Data Terverifikasi</h4>
                            <span class="text-[10px] sm:text-xs text-gray-500 font-medium">{{ $warga->updated_at ? $warga->updated_at->format('d M Y, H:i') : '-' }}</span>
                        </div>
                        <p class="text-xs text-gray-600 dark:text-gray-400 mb-2">Diverifikasi oleh: Admin/Kader</p>
                        <div class="p-3 bg-green-50 text-green-800 dark:bg-green-900/30 dark:text-green-300 rounded-lg text-xs font-medium border border-green-100 dark:border-green-800/50">
                            "Semua dokumen lengkap dan sesuai dengan data kependudukan pusat."
                        </div>
                    </div>
                    @endif

                    {{-- Pending Event --}}
                    @if($warga->verification_status == 'pending')
                    <div class="relative">
                        <div class="absolute left-[-24px] bg-yellow-400 rounded-full w-4 h-4 shadow ring-4 ring-white dark:ring-gray-800"></div>
                        <div class="flex justify-between items-start mb-1">
                            <h4 class="text-xs font-bold text-gray-900 dark:text-white">Menunggu Verifikasi</h4>
                            <span class="text-[10px] sm:text-xs text-gray-500 font-medium">{{ $warga->updated_at ? $warga->updated_at->format('d M Y, H:i') : '-' }}</span>
                        </div>
                        <p class="text-xs text-gray-600 dark:text-gray-400 mb-2">Pembaruan data sedang diproses kader</p>
                        <div class="p-3 bg-yellow-50 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300 rounded-lg text-xs font-medium border border-yellow-100 dark:border-yellow-800/50">
                            "Mohon tunggu hingga 1x24 jam untuk proses validasi data."
                        </div>
                    </div>
                    @endif

                    {{-- Created Event --}}
                    <div class="relative">
                        <div class="absolute left-[-24px] bg-blue-500 rounded-full w-4 h-4 shadow ring-4 ring-white dark:ring-gray-800 flex items-center justify-center">
                            <div class="w-1.5 h-1.5 bg-white rounded-full"></div>
                        </div>
                        <div class="flex justify-between items-start mb-1">
                            <h4 class="text-xs font-bold text-gray-900 dark:text-white">Pendaftaran Selesai</h4>
                            <span class="text-[10px] sm:text-xs text-gray-500 font-medium">{{ $warga->created_at ? $warga->created_at->format('d M Y, H:i') : '-' }}</span>
                        </div>
                        <p class="text-xs text-gray-600 dark:text-gray-400">Data diinput oleh: Diri Sendiri</p>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-4">
                <a href="#" class="w-full inline-flex justify-between items-center px-4 py-3 bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/20 dark:hover:bg-blue-900/40 text-blue-700 dark:text-blue-400 rounded-xl transition duration-150 border border-blue-100 dark:border-blue-800/50 group">
                    <div class="flex flex-col text-left">
                        <span class="text-xs font-bold tracking-wider mb-0.5">CETAK KARTU WARGA</span>
                        <span class="text-[10px] text-blue-600/70 dark:text-blue-400/70 leading-tight">Unduh profil dalam format PDF</span>
                    </div>
                    <svg class="w-5 h-5 opacity-70 group-hover:opacity-100 group-hover:translate-y-1 transition duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                </a>
            </div>

        </div>

    </div>

</div>
@endsection

