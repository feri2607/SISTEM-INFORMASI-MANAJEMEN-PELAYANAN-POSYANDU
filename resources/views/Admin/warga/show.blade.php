{{-- resources/views/Admin/warga/show.blade.php --}}

@extends('layouts.app')

@section('title', 'Detail Warga - Sistem Informasi Posyandu')

@section('page-title', '')
@section('page-subtitle', '')

@section('content')
<div class="max-w-7xl mx-auto space-y-6" x-data="wargaShowForm()">

    {{-- Breadcrumb & Actions --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div class="flex items-center text-sm text-gray-500 font-medium">
            <a href="{{ route($routePrefix . 'index') }}" class="hover:text-[#036672] flex items-center gap-1 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
            <span class="mx-2 text-gray-300">/</span>
            <a href="{{ route($routePrefix . 'index') }}" class="hover:text-gray-700">Daftar Warga</a>
            <span class="mx-2 text-gray-300">/</span>
            <span class="text-[#036672] font-semibold">Detail {{ $warga->nama }}</span>
        </div>

        <div class="flex flex-wrap gap-2">
            <a href="{{ route($routePrefix . 'edit', $warga) }}"
                class="px-4 py-2 border border-blue-600 text-blue-600 hover:bg-blue-50 text-sm font-semibold rounded-lg transition duration-150 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                </svg>
                Edit Data
            </a>

            <button type="button" @click="showResetModal = true"
                class="px-4 py-2 border border-gray-300 text-gray-700 hover:bg-gray-50 text-sm font-semibold rounded-lg transition duration-150 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Reset Password
            </button>

            @if(in_array($warga->verification_status, ['pending', null, '', 'belum_lengkap']))
                <form action="{{ route($routePrefix . 'verify', $warga->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin memverifikasi profil warga ini?')">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                        class="px-4 py-2 bg-[#0a358c] hover:bg-blue-800 text-white text-sm font-semibold rounded-lg shadow-sm transition duration-150 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Verifikasi Data
                    </button>
                </form>
            @endif
        </div>
    </div>

    {{-- Main Profile Card --}}
    <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 p-6 flex flex-col md:flex-row items-center gap-6">
        <div class="relative flex-shrink-0">
            <div class="w-24 h-24 rounded-full overflow-hidden border-2 border-gray-100 p-1">
                <img src="{{ $warga->foto_url ?? 'https://ui-avatars.com/api/?name='.urlencode($warga->nama).'&color=0a358c&background=f0f4f8' }}" alt="{{ $warga->nama }}" class="w-full h-full rounded-full object-cover">
            </div>
            @if(in_array($warga->verification_status, ['verified']))
                <div class="absolute bottom-1 right-1 bg-emerald-500 rounded-full border-2 border-white text-white p-0.5" title="Terverifikasi">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                </div>
            @endif
        </div>
        
        <div class="flex-1 text-center md:text-left">
            <div class="flex flex-col md:flex-row md:items-center gap-3">
                <h2 class="text-2xl font-bold text-gray-900">{{ $warga->nama }}</h2>
                @if(in_array($warga->verification_status, ['verified']))
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        TERVERIFIKASI
                    </span>
                @elseif(in_array($warga->verification_status, ['rejected']))
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">
                        DATA DITOLAK
                    </span>
                @elseif(in_array($warga->verification_status, ['pending']))
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700">
                        MENUNGGU VERIFIKASI
                    </span>
                @else
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700">
                        DATA TIDAK LENGKAP
                    </span>
                @endif
            </div>
            <div class="mt-2 flex items-center justify-center md:justify-start gap-2 text-sm text-gray-500">
                <svg class="w-4 h-4 text-[#0a358c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                NIK: <strong>{{ $warga->nik }}</strong>
            </div>
        </div>
    </div>

    @php
        $countAnak = $warga->anak()->count();
        $countKehamilan = \App\Models\Kehamilan::where('warga_id', $warga->id)->count();
        $countRemaja = \App\Models\Remaja::where('warga_id', $warga->id)->count();
        $countLansia = \App\Models\Lansia::where('warga_id', $warga->id)->count();
    @endphp

    {{-- Stats Row --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 p-5 text-center">
            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1">Total Anak</p>
            <p class="text-3xl font-black text-[#0a358c]">{{ $countAnak }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 p-5 text-center">
            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1">Jumlah Ibu Hamil</p>
            <p class="text-3xl font-black text-[#0a358c]">{{ $countKehamilan }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 p-5 text-center">
            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1">Jumlah Remaja</p>
            <p class="text-3xl font-black text-[#0a358c]">{{ $countRemaja }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 p-5 text-center">
            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1">Jumlah Lansia</p>
            <p class="text-3xl font-black text-[#0a358c]">{{ $countLansia }}</p>
        </div>
    </div>

    {{-- Main Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Left Column --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- Informasi Pribadi --}}
            <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 overflow-hidden">
                <div class="p-5 border-b border-gray-50 bg-gray-50/50 flex items-center space-x-2">
                    <svg class="w-5 h-5 text-[#0a358c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <h3 class="font-bold text-gray-900">Informasi Pribadi</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-8">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Nama Lengkap</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $warga->nama }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">NIK</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $warga->nik }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Jenis Kelamin</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $warga->jenis_kelamin_label }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Tempat Lahir</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $warga->tempat_lahir ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Tanggal Lahir</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $warga->tanggal_lahir ? $warga->tanggal_lahir->format('d-m-Y') : '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Umur</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $warga->umur ?? '-' }} Tahun</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Agama</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $warga->agama ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Status Perkawinan</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $warga->status_pernikahan ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Pekerjaan</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $warga->pekerjaan ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Alamat --}}
                <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 overflow-hidden relative">
                    <div class="p-5 border-b border-gray-50 bg-gray-50/50 flex items-center space-x-2">
                        <svg class="w-5 h-5 text-[#0a358c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <h3 class="font-bold text-gray-900">Alamat</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <p class="text-[10px] uppercase text-gray-500 mb-0.5">Alamat Lengkap</p>
                            <p class="text-sm font-semibold text-gray-900 leading-relaxed">{{ $warga->alamat ?? '-' }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-[10px] uppercase text-gray-500 mb-0.5">RT</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $warga->rt ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase text-gray-500 mb-0.5">RW</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $warga->rw ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase text-gray-500 mb-0.5">Kelurahan/Desa</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $warga->desa ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase text-gray-500 mb-0.5">Kecamatan</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $warga->kecamatan ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase text-gray-500 mb-0.5">Kabupaten/Kota</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $warga->kabupaten ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase text-gray-500 mb-0.5">Provinsi</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $warga->provinsi ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase text-gray-500 mb-0.5">Kode Pos</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $warga->kode_pos ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Data Kesehatan --}}
                <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 overflow-hidden relative col-span-1 md:col-span-2">
                    <div class="p-5 border-b border-gray-50 bg-gray-50/50 flex items-center justify-between space-x-2">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            <h3 class="font-bold text-gray-900">Data Kesehatan & Kategori</h3>
                        </div>
                        <a href="{{ route($routePrefix . 'edit', $warga) }}#data-kesehatan" class="text-xs font-semibold text-blue-600 hover:text-blue-800 flex items-center transition-colors">
                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            Ubah Status
                        </a>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-[10px] uppercase text-gray-500 mb-0.5">Status Kehamilan</p>
                                @if($warga->isHamil())
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-pink-100 text-pink-700 uppercase">Hamil</span>
                                @else
                                    <span class="text-sm font-semibold text-gray-900">Tidak</span>
                                @endif
                            </div>
                            <div>
                                <p class="text-[10px] uppercase text-gray-500 mb-0.5">Status Menyusui</p>
                                @if($warga->isMenyusui())
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-purple-100 text-purple-700 uppercase">Ya</span>
                                @else
                                    <span class="text-sm font-semibold text-gray-900">Tidak</span>
                                @endif
                            </div>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase text-gray-500 mb-0.5">Catatan Kesehatan</p>
                            <p class="text-sm font-semibold text-gray-900 leading-relaxed">{{ $warga->catatan_kesehatan ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase text-gray-500 mb-0.5">Kategori Pelayanan Tersedia</p>
                            <div class="flex flex-wrap gap-2 mt-1">
                                @php
                                    $categoryService = app(\App\Services\CitizenCategoryService::class);
                                    $categories = collect($categoryService->getCategories($warga))->where('is_active', true);
                                @endphp
                                @forelse($categories as $key => $cat)
                                    <span class="inline-flex items-center px-2 py-1 bg-blue-50 text-blue-700 text-[10px] font-bold rounded-md uppercase border border-blue-100">
                                        {{ $cat['label'] }}
                                    </span>
                                @empty
                                    <span class="text-xs text-gray-400">Tidak ada kategori pelayanan khusus.</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            
            {{-- Data Anak --}}
            <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 overflow-hidden">
                <div class="p-5 border-b border-gray-50 bg-gray-50/50 flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <h3 class="font-bold text-gray-900">Data Anak Keluarga</h3>
                    </div>
                    <a href="{{ route(Auth::user()->role . '.balita.create', ['warga_id' => $warga->id]) }}" class="text-[10px] uppercase font-bold tracking-wider px-3 py-1.5 text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg flex items-center transition-colors shadow-sm">
                        <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Anak
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white text-gray-500 text-[10px] uppercase font-bold tracking-widest border-b border-gray-200">
                                <th class="py-3 px-6">Nama Anak</th>
                                <th class="py-3 px-6">NIK</th>
                                <th class="py-3 px-6">Usia</th>
                                <th class="py-3 px-6">Jenis Kelamin</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($warga->anak as $anak)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-4 px-6 text-sm text-gray-800 font-medium">{{ $anak->nama }}</td>
                                    <td class="py-4 px-6 text-sm text-gray-800 font-mono">{{ $anak->nik ?? '-' }}</td>
                                    <td class="py-4 px-6 text-sm text-gray-800">{{ $anak->umur_bulan }} Bulan</td>
                                    <td class="py-4 px-6 text-sm text-gray-800">{{ $anak->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-sm text-gray-400 bg-gray-50/30">Belum ada data anak yang ditambahkan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        {{-- Right Column --}}
        <div class="space-y-6">
            
            {{-- Informasi Akun --}}
            <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 overflow-hidden">
                <div class="p-5 border-b border-gray-50 bg-gray-50/50 flex items-center space-x-2">
                    <svg class="w-5 h-5 text-[#0a358c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    <h3 class="font-bold text-gray-900">Informasi Akun Login</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center pb-3 border-b border-gray-50">
                        <span class="text-xs text-gray-500">Username</span>
                        <span class="text-sm font-bold text-[#0a358c] max-w-[150px] truncate text-right">{{ $warga->user?->email ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center pb-3 border-b border-gray-50">
                        <span class="text-xs text-gray-500">Role</span>
                        <span class="text-[10px] font-bold text-white bg-blue-500 px-2 py-0.5 rounded uppercase">{{ $warga->user?->role ?? 'WARGA' }}</span>
                    </div>
                    <div class="flex justify-between items-center pb-3 border-b border-gray-50">
                        <span class="text-xs text-gray-500">Status Akun</span>
                        <span class="text-[10px] font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded uppercase">
                            AKTIF
                        </span>
                    </div>
                    <div class="flex justify-between items-center pb-3 border-b border-gray-50">
                        <span class="text-xs text-gray-500">Email Verified</span>
                        @if($warga->user?->email_verified_at)
                            <span class="text-[10px] font-bold text-white bg-[#0a358c] px-2 py-0.5 rounded uppercase">YES</span>
                        @else
                            <span class="text-[10px] font-bold text-gray-600 bg-gray-200 px-2 py-0.5 rounded uppercase">NO</span>
                        @endif
                    </div>
                    <div class="pb-3 border-b border-gray-50">
                        <p class="text-xs text-gray-500 mb-1">Login Terakhir</p>
                        @php
                            $lastLogin = \App\Models\LoginActivity::where('user_id', $warga->user_id)->orderBy('login_at', 'desc')->first();
                        @endphp
                        <p class="text-sm font-semibold text-gray-900">{{ $lastLogin ? \Carbon\Carbon::parse($lastLogin->login_at)->format('d M Y, H:i').' WIB' : '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Tanggal Registrasi</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $warga->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>

            {{-- Dokumen Pendukung --}}
            <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 overflow-hidden">
                <div class="p-5 border-b border-gray-50 bg-gray-50/50 flex items-center space-x-2">
                    <svg class="w-5 h-5 text-[#0a358c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                    <h3 class="font-bold text-gray-900">Dokumen Pendukung</h3>
                </div>
                <div class="p-6 space-y-4">
                    
                    {{-- KTP --}}
                    <div class="border border-gray-100 rounded-lg p-4 bg-gray-50/50">
                        <div class="flex items-start mb-4">
                            <div class="p-2 bg-blue-100 text-blue-600 rounded-lg mr-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-gray-900 leading-tight mb-1">Kartu Tanda Penduduk<br>(KTP)</h4>
                                @if($warga->ktp_path)
                                    <span class="text-[9px] font-bold bg-emerald-100 text-emerald-700 px-1.5 py-0.5 rounded">Sudah Upload</span>
                                @else
                                    <span class="text-[9px] font-bold bg-gray-200 text-gray-600 px-1.5 py-0.5 rounded">Belum Upload</span>
                                @endif
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            @if($warga->ktp_path)
                                <a href="{{ $warga->foto_ktp_url }}" target="_blank" class="py-1.5 text-center border border-gray-200 rounded text-xs font-semibold text-[#0a358c] hover:bg-gray-50 flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    Lihat
                                </a>
                                <a href="{{ $warga->foto_ktp_url }}" download class="py-1.5 text-center border border-gray-200 rounded text-xs font-semibold text-gray-700 hover:bg-gray-50 flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    Download
                                </a>
                            @else
                                <span class="col-span-2 py-1.5 text-center border border-gray-200 rounded text-xs text-gray-400 bg-gray-50">Data tidak tersedia</span>
                            @endif
                        </div>
                    </div>

                    {{-- KK --}}
                    <div class="border border-gray-100 rounded-lg p-4 bg-gray-50/50">
                        <div class="flex items-start mb-4">
                            <div class="p-2 bg-blue-100 text-blue-600 rounded-lg mr-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-gray-900 leading-tight mb-1">Kartu Keluarga (KK)</h4>
                                @if($warga->kk_path)
                                    <span class="text-[9px] font-bold bg-emerald-100 text-emerald-700 px-1.5 py-0.5 rounded">Sudah Upload</span>
                                @else
                                    <span class="text-[9px] font-bold bg-gray-200 text-gray-600 px-1.5 py-0.5 rounded">Belum Upload</span>
                                @endif
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            @if($warga->kk_path)
                                <a href="{{ $warga->foto_kk_url }}" target="_blank" class="py-1.5 text-center border border-gray-200 rounded text-xs font-semibold text-[#0a358c] hover:bg-gray-50 flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    Lihat
                                </a>
                                <a href="{{ $warga->foto_kk_url }}" download class="py-1.5 text-center border border-gray-200 rounded text-xs font-semibold text-gray-700 hover:bg-gray-50 flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    Download
                                </a>
                            @else
                                <span class="col-span-2 py-1.5 text-center border border-gray-200 rounded text-xs text-gray-400 bg-gray-50">Data tidak tersedia</span>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
            
        </div>
        
    </div>

    {{-- Riwayat Pelayanan --}}
    <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 overflow-hidden mb-6">
        <div class="p-5 border-b border-gray-50 bg-gray-50/50 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-[#0a358c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <h3 class="font-bold text-gray-900">Riwayat Pelayanan Posyandu</h3>
            </div>
        </div>
        
        @php
            $riwayat = collect([]);
            if($warga->balita) {
                // Collect Riwayat Balita
                $riwayat = $warga->balita->flatMap(function ($balita) {
                    return $balita->pelayanan;
                })->sortByDesc('created_at')->take(5);
            }
            // You can add logic to aggregate riwayat kehamilan, remaja, lansia here in the future
        @endphp

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white text-gray-500 text-[10px] uppercase font-bold tracking-widest border-b border-gray-200">
                        <th class="py-3 px-6">Tanggal</th>
                        <th class="py-3 px-6">Jenis Pelayanan</th>
                        <th class="py-3 px-6">Nama Kegiatan</th>
                        <th class="py-3 px-6">Petugas</th>
                        <th class="py-3 px-6">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($riwayat as $p)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="py-4 px-6 text-sm text-gray-800">{{ $p->created_at->format('d M Y') }}</td>
                            <td class="py-4 px-6 text-sm text-gray-800 font-medium">Balita</td>
                            <td class="py-4 px-6 text-sm text-gray-800">{{ $p->kegiatan->nama_kegiatan ?? '-' }}</td>
                            <td class="py-4 px-6 text-sm text-gray-800">{{ $p->user->name ?? $p->kader->name ?? 'Kader/Bidan' }}</td>
                            <td class="py-4 px-6">
                                <span class="text-[10px] font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded uppercase">SELESAI</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-10 text-center text-sm text-gray-400 bg-gray-50/30">Belum ada riwayat pelayanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{-- MODAL RESET PASSWORD --}}
    <div x-show="showResetModal" class="fixed inset-0 z-[100] overflow-y-auto" style="display: none;" x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="showResetModal" x-transition.opacity class="fixed inset-0 bg-gray-900 bg-opacity-75 backdrop-blur-sm" @click="showResetModal = false"></div>
            
            <div x-show="showResetModal" 
                 x-transition:enter="ease-out duration-300" 
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave="ease-in duration-200" 
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm w-full border border-gray-100">
                
                <form method="POST" action="{{ route($routePrefix . 'update', $warga) }}" id="formResetPassword" @submit="isResetting = true">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="action_reset_password" value="1">
                    
                    <div class="bg-white px-5 pt-6 pb-5 text-center">
                        <div class="mx-auto flex items-center justify-center h-14 w-14 rounded-full bg-red-50 mb-4">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <h3 class="text-lg leading-6 font-bold text-gray-900 mb-2">Reset Password Warga</h3>
                        <div class="text-sm text-gray-500">
                            <p>Sistem akan membuat password sementara baru.</p>
                            <p class="mt-1 font-semibold text-gray-700">Password lama tidak dapat digunakan lagi setelah proses ini.</p>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-5 py-4 flex gap-3">
                        <button type="button" @click="showResetModal = false" class="flex-1 justify-center rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 focus:outline-none transition-colors">Batal</button>
                        <button type="submit" id="btnReset" class="flex-1 justify-center rounded-xl border border-transparent bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors flex items-center gap-2">
                            Reset Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL SUKSES (KREDENSIAL LOGIN) --}}
    @if(session('warga_created'))
    <div x-data="{ showModal: true }" x-show="showModal" class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" x-cloak>
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            
            <div x-show="showModal" x-transition.opacity class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm" aria-hidden="true" @click="showModal = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
    
            <div x-show="showModal" 
                 x-transition:enter="ease-out duration-300" 
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave="ease-in duration-200" 
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full border border-gray-100">
                
                <div class="bg-white px-5 pt-6 pb-5 sm:p-7 sm:pb-5 text-center">
                    <div class="mx-auto flex items-center justify-center h-14 w-14 rounded-full bg-emerald-50 mb-5 relative">
                        <svg class="h-7 w-7 text-emerald-500 relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <div class="absolute inset-0 rounded-full border-2 border-emerald-100 scale-110"></div>
                    </div>
                    
                    <h3 class="text-xl leading-6 font-bold text-gray-900 mb-2" id="modal-title">
                        Reset Password Berhasil
                    </h3>
                    
                    <div class="text-sm text-gray-500 mb-6">
                        <p class="mb-1">Password baru telah dibuat secara otomatis.</p>
                        <p>Silakan salin kredensial berikut dan berikan kepada warga terkait.</p>
                    </div>

                    <div class="bg-[#F8FAFC] border border-blue-100 rounded-xl p-5 text-left shadow-inner" id="print-credentials">
                        <div class="space-y-4">
                            <div>
                                <span class="block text-[10px] font-bold uppercase tracking-wider text-blue-600 mb-1">Nama Lengkap</span>
                                <span class="block text-sm font-semibold text-gray-900">{{ session('warga_created')['nama'] }}</span>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <span class="block text-[10px] font-bold uppercase tracking-wider text-blue-600 mb-1">Username (NIK)</span>
                                    <span class="block text-sm font-bold text-gray-900 font-mono tracking-tight" id="copy-nik">{{ session('warga_created')['nik'] }}</span>
                                </div>
                                <div>
                                    <span class="block text-[10px] font-bold uppercase tracking-wider text-blue-600 mb-1.5">Role</span>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-blue-600 text-white tracking-widest uppercase">WARGA</span>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <span class="block text-[10px] font-bold uppercase tracking-wider text-blue-600 mb-1">Password Baru</span>
                                    <span class="block text-sm font-bold text-gray-900 font-mono bg-white px-2 py-1 rounded border border-gray-200 w-fit" id="copy-password">{{ session('warga_created')['password_sementara'] }}</span>
                                </div>
                                <div>
                                    <span class="block text-[10px] font-bold uppercase tracking-wider text-blue-600 mb-1.5">Status</span>
                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[10px] font-bold bg-green-50 text-green-600 tracking-wider uppercase border border-green-200/50">
                                        <div class="w-1.5 h-1.5 rounded-full bg-green-500"></div>    
                                        Password Direset
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50/50 px-5 py-4 flex flex-col sm:flex-row-reverse gap-3 border-t border-gray-100">
                    <button type="button" @click="showModal = false" class="w-full inline-flex justify-center items-center rounded-xl border border-gray-200 shadow-sm px-4 py-2.5 bg-white text-sm font-semibold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:w-auto transition-all active:scale-[0.98]">
                        Tutup
                    </button>
                    
                    <button type="button" onclick="salinKredensial()" class="w-full inline-flex justify-center items-center gap-2 rounded-xl border border-transparent shadow-sm px-4 py-2.5 bg-blue-600 text-sm font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:w-auto transition-all shadow-blue-500/30 active:scale-[0.98]">
                        <svg class="w-4 h-4 text-blue-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        Salin Data
                    </button>
                    
                    <button type="button" onclick="cetakKredensial()" class="w-full inline-flex justify-center items-center gap-2 rounded-xl border border-gray-200 shadow-sm px-4 py-2.5 bg-white text-sm font-semibold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:w-auto transition-all active:scale-[0.98]">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Cetak
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
    @if(session('warga_created'))
    function salinKredensial() {
        const nik = document.getElementById('copy-nik').innerText;
        const pwd = document.getElementById('copy-password').innerText;
        const text = `Informasi Login Warga\nUsername (NIK): ${nik}\nPassword: ${pwd}\nHarap segera mengganti password saat login pertama kali.`;
        
        navigator.clipboard.writeText(text).then(() => {
            if(window.Swal) {
                Swal.fire({
                    icon: 'success',
                    title: 'Tersalin!',
                    text: 'Kredensial berhasil disalin ke clipboard.',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            } else {
                alert('Tersalin!');
            }
        });
    }

    function cetakKredensial() {
        const content = document.getElementById('print-credentials').innerHTML;
        const printWindow = window.open('', '', 'width=600,height=400');
        printWindow.document.write(`
            <html>
                <head>
                    <title>Informasi Login Warga - Posyandu</title>
                    <style>
                        body { font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; padding: 20px; color: #333; }
                        h2 { text-align: center; color: #2563EB; margin-bottom: 25px; border-bottom: 1px solid #e2e8f0; padding-bottom: 15px; }
                        .card { border: 1px dashed #ccc; border-radius: 8px; padding: 25px; max-width: 450px; margin: 0 auto; background: #fff; line-height: 1.6; }
                        .grid { display: flex; flex-wrap: wrap; margin-top: 15px; }
                        .col-6 { width: 50%; margin-bottom: 15px; }
                        .col-12 { width: 100%; margin-bottom: 15px; }
                        .label { font-size: 10px; text-transform: uppercase; font-weight: bold; color: #2563eb; display: block; letter-spacing: 1px; }
                        .val { font-size: 15px; font-weight: bold; color: #0f172a; margin-top: 2px; }
                        .val-mono { font-family: monospace; letter-spacing: 1px; font-size: 15px; }
                        .badge { display: inline-block; padding: 3px 8px; border-radius: 4px; font-size: 10px; font-weight: bold; background: #2563EB; color: white; letter-spacing: 1px; margin-top: 4px; }
                        .badge-warning { background: #fef08a; color: #854d0e; border: 1px solid #fde047; }
                        .footer { text-align: center; margin-top: 30px; font-size: 11px; color: #64748b; font-style: italic; }
                        @media print { 
                            .card { border: 2px dashed #999; -webkit-print-color-adjust: exact; print-color-adjust: exact; } 
                        }
                    </style>
                </head>
                <body>
                    <h2>KREDENSIAL LOGIN POSYANDU</h2>
                    <div class="card">${content.replace(/class="[^"]*"/g, '').replace('Nama Lengkap', '<div class="col-12"><span class="label">Nama Lengkap</span>').replace('Username (NIK)', '</div><div class="grid"><div class="col-6"><span class="label">Username (NIK)</span>').replace('Role', '</div><div class="col-6"><span class="label">Role</span>').replace('Password Baru', '</div></div><div class="grid"><div class="col-6"><span class="label">Password</span>').replace('Status', '</div><div class="col-6"><span class="label">Status</span>').replace('WARGA', '<span class="badge">WARGA</span>').replace('Password Direset', '<span class="badge badge-warning">Password Direset</span>')}</div></div>
                    <p class="footer"><strong>PERHATIAN:</strong><br/>Dokumen ini rahasia. Wajib mengubah password segera setelah login berhasil.</p>
                    <script>
                        setTimeout(() => {
                            window.print();
                            setTimeout(() => window.close(), 500);
                        }, 250);
                    <\/script>
                </body>
            </html>
        `);
        printWindow.document.close();
    }
    @endif

    function wargaShowForm() {
        return {
            showResetModal: false,
            isResetting: false,
        }
    }
</script>
@endpush
@endsection