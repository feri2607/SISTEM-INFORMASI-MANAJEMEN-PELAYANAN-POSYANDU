{{-- resources/views/Admin/warga/edit.blade.php --}}

@extends('layouts.app')

@section('title', 'Edit Warga - Sistem Informasi Posyandu')

@section('page-title', 'Edit Data Warga')
@section('page-subtitle', 'Perbarui informasi warga yang telah terdaftar.')

@section('content')
<div x-data="wargaEditForm()" x-init="initData()" x-ref="rootForm">

    {{-- HEADER AND STATUS BADGE --}}
    <div class="mb-6 flex items-center gap-3">
        @if($warga->verification_status === 'verified')
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-100 text-green-700 text-sm font-semibold rounded-full border border-green-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Terverifikasi
            </span>
        @elseif($warga->verification_status === 'pending')
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-100 text-amber-700 text-sm font-semibold rounded-full border border-amber-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Menunggu Verifikasi
            </span>
        @else
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gray-100 text-gray-700 text-sm font-semibold rounded-full border border-gray-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                Data Tidak Lengkap
            </span>
        @endif
    </div>

    {{-- MAIN FORM --}}
    <form method="POST" action="{{ route($routePrefix . 'update', $warga) }}" enctype="multipart/form-data" id="wargaForm" x-ref="form" @submit.prevent="submitForm">
        @csrf
        @method('PUT')

        {{-- TWO-COLUMN GRID --}}
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            {{-- ========== LEFT COLUMN (wider) ========== --}}
            <div class="xl:col-span-2 space-y-6">

                {{-- Admin: User PJ --}}
                @if(Auth::user()->role === 'admin')
                <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-blue-50 p-6">
                    <div class="flex items-center gap-2 mb-5">
                        <div class="w-7 h-7 rounded-lg bg-indigo-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-700">Penanggung Jawab</h3>
                    </div>
                    <div>
                        <label for="user_id" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Kader / Pegawai Penangung Jawab</label>
                        <select name="user_id" id="user_id" class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800 transition-all">
                            <option value="">Pilih Kader...</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id', $warga->user_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>
                @endif

                {{-- ===== CARD: IDENTITAS ===== --}}
                <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-blue-50 p-6">
                    <div class="flex items-center gap-2 mb-5">
                        <div class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-700">Informasi Pribadi</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Nama Lengkap --}}
                        <div class="md:col-span-2">
                            <label for="nama" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="nama" id="nama" class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800 transition-all" value="{{ old('nama', $warga->nama) }}" required>
                            @error('nama') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- NIK (Readonly) --}}
                        <div>
                            <label for="nik" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">NIK <span class="text-gray-400 normal-case font-normal">(Read-only)</span> <span class="text-red-500">*</span></label>
                            <input type="text" name="nik" id="nik" class="w-full px-3 py-2.5 text-sm bg-gray-100 border border-gray-200 rounded-lg text-gray-500 font-mono cursor-not-allowed" value="{{ old('nik', $warga->nik) }}" readonly>
                        </div>

                        {{-- Nomor KK --}}
                        <div>
                            <label for="nomor_kk" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Nomor KK <span class="text-red-500">*</span></label>
                            <input type="text" name="nomor_kk" id="nomor_kk" class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 text-gray-800 transition-all font-mono" value="{{ old('nomor_kk', $warga->nomor_kk) }}" required>
                            @error('nomor_kk') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Jenis Kelamin --}}
                        <div>
                            <label for="jenis_kelamin" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Jenis Kelamin <span class="text-red-500">*</span></label>
                            <select name="jenis_kelamin" id="jenis_kelamin" class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 text-gray-800" required>
                                <option value="L" {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        {{-- Tempat Lahir --}}
                        <div>
                            <label for="tempat_lahir" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Tempat Lahir <span class="text-red-500">*</span></label>
                            <input type="text" name="tempat_lahir" id="tempat_lahir" class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 text-gray-800" value="{{ old('tempat_lahir', $warga->tempat_lahir) }}" required>
                        </div>

                        {{-- Tanggal Lahir --}}
                        <div>
                            <label for="tanggal_lahir" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Tanggal Lahir <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 text-gray-800" value="{{ old('tanggal_lahir', optional($warga->tanggal_lahir)->format('Y-m-d')) }}" required>
                        </div>

                        {{-- Agama --}}
                        <div>
                            <label for="agama" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Agama</label>
                            <select name="agama" id="agama" class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 text-gray-800">
                                @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agm)
                                    <option value="{{ $agm }}" {{ old('agama', $warga->agama) == $agm ? 'selected' : '' }}>{{ $agm }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Status Perkawinan --}}
                        <div>
                            <label for="status_perkawinan" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Status Perkawinan</label>
                            <select name="status_perkawinan" id="status_perkawinan" class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 text-gray-800">
                                <option value="">Pilih Status</option>
                                @foreach($statusPerkawinan as $key => $label)
                                    <option value="{{ $key }}" {{ old('status_perkawinan', $warga->status_perkawinan) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Pekerjaan --}}
                        <div class="md:col-span-2">
                            <label for="pekerjaan" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Pekerjaan</label>
                            <input type="text" name="pekerjaan" id="pekerjaan" class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 text-gray-800" value="{{ old('pekerjaan', $warga->pekerjaan) }}">
                        </div>
                    </div>
                </div>

                {{-- ===== CARD: ALAMAT ===== --}}
                <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-blue-50 p-6">
                    <div class="flex items-center gap-2 mb-5">
                        <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-700">Alamat</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Alamat Lengkap --}}
                        <div class="md:col-span-2">
                            <label for="alamat" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Alamat Lengkap <span class="text-red-500">*</span></label>
                            <textarea name="alamat" id="alamat" rows="2" class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 text-gray-800 resize-none">{{ old('alamat', $warga->alamat) }}</textarea>
                        </div>

                        {{-- RT --}}
                        <div>
                            <label for="rt" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">RT</label>
                            <input type="text" name="rt" id="rt" class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 text-gray-800" value="{{ old('rt', $warga->rt) }}">
                        </div>

                        {{-- RW --}}
                        <div>
                            <label for="rw" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">RW</label>
                            <input type="text" name="rw" id="rw" class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 text-gray-800" value="{{ old('rw', $warga->rw) }}">
                        </div>

                        {{-- Provinsi --}}
                        <div>
                            <label for="provinsi_id" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Provinsi</label>
                            <select name="provinsi" id="provinsi_id" @change="getWilayah($event.target.value, 'kabupaten', 'kabupaten_id')" class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 text-gray-800">
                                <option value="">Pilih Provinsi...</option>
                                @foreach($provinsi as $p)
                                    <option value="{{ $p->id }}" {{ old('provinsi', $warga->provinsi) == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Kabupaten/Kota --}}
                        <div>
                            <label for="kabupaten_id" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Kabupaten/Kota</label>
                            <select name="kabupaten" id="kabupaten_id" data-selected="{{ old('kabupaten', $warga->kabupaten) }}" @change="getWilayah($event.target.value, 'kecamatan', 'kecamatan_id')" class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 text-gray-800">
                                <option value="">Pilih Kabupaten...</option>
                            </select>
                        </div>

                        {{-- Kecamatan --}}
                        <div>
                            <label for="kecamatan_id" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Kecamatan</label>
                            <select name="kecamatan" id="kecamatan_id" data-selected="{{ old('kecamatan', $warga->kecamatan) }}" @change="getWilayah($event.target.value, 'kelurahan', 'kelurahan_id')" class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 text-gray-800">
                                <option value="">Pilih Kecamatan...</option>
                            </select>
                        </div>

                        {{-- Kelurahan/Desa --}}
                        <div>
                            <label for="kelurahan_id" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Kelurahan/Desa</label>
                            <select name="desa" id="kelurahan_id" data-selected="{{ old('desa', $warga->desa) }}" class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 text-gray-800">
                                <option value="">Pilih Kelurahan...</option>
                            </select>
                        </div>
                        
                        {{-- Kode Pos --}}
                        <div class="md:col-start-2">
                            <label for="kode_pos" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Kode Pos</label>
                            <input type="text" name="kode_pos" id="kode_pos" class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 text-gray-800" value="{{ old('kode_pos', $warga->kode_pos) }}">
                        </div>
                    </div>
                </div>

            </div>{{-- end left col --}}


            {{-- ========== RIGHT COLUMN ========== --}}
            <div class="xl:col-span-1 space-y-6">

                {{-- ===== CARD: FOTO PROFIL ===== --}}
                <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-blue-50 p-6 flex flex-col items-center">
                    <div class="w-28 h-28 rounded-full border-4 border-blue-50 overflow-hidden bg-gray-100 flex items-center justify-center relative group shadow-sm mb-4">
                        <img id="fotoPreview" src="{{ $warga->foto_url ?? 'https://ui-avatars.com/api/?name='.urlencode($warga->nama).'&color=2563EB&background=EFF6FF&size=128' }}" alt="Foto Profil" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/40 hidden group-hover:flex items-center justify-center pointer-events-none transition-all">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                    </div>
                    <div class="text-center w-full">
                        <h3 class="text-sm font-semibold text-gray-800">Foto Profil</h3>
                        <p class="text-[11px] text-gray-400 mt-0.5 mb-3">Format JPG/PNG, Maks 2MB</p>
                        
                        <div class="relative w-full">
                            <input type="file" name="foto" id="foto" accept="image/jpeg,image/png,image/jpg" @change="previewMedia($event, 'fotoPreview')" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            <button type="button" class="w-full border border-blue-200 bg-blue-50/50 hover:bg-blue-100/50 text-blue-600 text-xs font-semibold py-2 px-4 rounded-lg transition-colors">
                                Upload Foto Baru
                            </button>
                        </div>
                        @error('foto') <p class="mt-2 text-xs text-red-500 text-left">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- ===== CARD: INFORMASI KONTAK ===== --}}
                <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-blue-50 p-6">
                    <div class="flex items-center gap-2 mb-5">
                        <div class="w-7 h-7 rounded-lg bg-sky-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-700">Informasi Kontak</h3>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="telepon" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Nomor HP <span class="text-red-500">*</span></label>
                            <div class="flex">
                                <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-200 bg-gray-50 text-gray-500 text-sm font-medium">+62</span>
                                <input type="text" name="telepon" id="telepon" class="flex-1 min-w-0 block w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-none rounded-r-lg focus:ring-2 focus:ring-blue-500 text-gray-800" value="{{ old('telepon', preg_replace('/^(0|\+?62)/', '', $warga->telepon)) }}">
                            </div>
                            @error('telepon') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="email" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Email</label>
                            <input type="email" name="email" id="email" class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 text-gray-800" value="{{ old('email', optional($warga->user)->email ?? $warga->email) }}">
                            @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- ===== CARD: STATUS ADMINISTRASI ===== --}}
                <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-blue-50 p-6">
                    <div class="flex items-center gap-2 mb-5">
                        <div class="w-7 h-7 rounded-lg bg-slate-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-700">Status Administrasi</h3>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label for="status_kependudukan" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Status Kependudukan</label>
                            <select name="status_kependudukan" id="status_kependudukan" class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 text-gray-800">
                                <option value="tetap" {{ old('status_kependudukan', $warga->status_kependudukan) == 'tetap' ? 'selected' : '' }}>Warga Tetap</option>
                                <option value="pendatang" {{ old('status_kependudukan', $warga->status_kependudukan) == 'pendatang' ? 'selected' : '' }}>Pendatang</option>
                            </select>
                        </div>
                        <div>
                            <label for="status_keaktifan" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Status Akun</label>
                            <select name="status_keaktifan" id="status_keaktifan" class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 text-gray-800">
                                <option value="aktif" {{ old('status_keaktifan', $warga->status_keaktifan) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="tidak_aktif" {{ old('status_keaktifan', $warga->status_keaktifan) == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- ===== CARD: DOKUMEN PENDUKUNG ===== --}}
                <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-blue-50 p-6">
                    <div class="flex items-center gap-2 mb-5">
                        <div class="w-7 h-7 rounded-lg bg-cyan-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-700">Dokumen Pendukung</h3>
                    </div>

                    <div class="space-y-5">
                        {{-- KTP --}}
                        <div class="bg-blue-50/50 rounded-lg p-3 border border-blue-100/50">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-[11px] font-bold uppercase tracking-wider text-blue-800">Kartu Tanda Penduduk (KTP)</span>
                                <div class="relative overflow-hidden">
                                    <input type="file" name="ktp_path" accept="image/jpeg,image/png,image/jpg" @change="previewMedia($event, 'ktpPreview')" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                    <span class="text-[11px] font-bold text-blue-600 cursor-pointer pointer-events-none hover:underline">Upload Ulang</span>
                                </div>
                            </div>
                            <div class="w-full h-32 bg-gray-200 rounded-md overflow-hidden flex flex-col items-center justify-center">
                                @if($warga->foto_ktp_url)
                                    <img id="ktpPreview" src="{{ $warga->foto_ktp_url }}" class="w-full h-full object-contain bg-white">
                                @else
                                    <img id="ktpPreview" src="" class="w-full h-full object-contain bg-white hidden">
                                    <span class="text-xs text-gray-400 p-2 text-center ktp-empty">KTP Belum Diupload</span>
                                @endif
                            </div>
                        </div>

                        {{-- KK --}}
                        <div class="bg-blue-50/50 rounded-lg p-3 border border-blue-100/50">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-[11px] font-bold uppercase tracking-wider text-blue-800">Kartu Keluarga (KK)</span>
                                <div class="relative overflow-hidden">
                                    <input type="file" name="kk_path" accept="image/jpeg,image/png,image/jpg" @change="previewMedia($event, 'kkPreview')" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                    <span class="text-[11px] font-bold text-blue-600 cursor-pointer pointer-events-none hover:underline">Upload Ulang</span>
                                </div>
                            </div>
                            <div class="w-full h-32 bg-gray-200 rounded-md overflow-hidden flex flex-col items-center justify-center">
                                @if($warga->foto_kk_url)
                                    <img id="kkPreview" src="{{ $warga->foto_kk_url }}" class="w-full h-full object-contain bg-white">
                                @else
                                    <img id="kkPreview" src="" class="w-full h-full object-contain bg-white hidden">
                                    <span class="text-xs text-gray-400 p-2 text-center kk-empty">KK Belum Diupload</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ===== CARD: AKUN LOGIN ===== --}}
                <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-blue-50 p-6 relative">
                    <div class="flex items-center gap-2 mb-5">
                        <div class="w-7 h-7 rounded-lg bg-indigo-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-700">Akun Login</h3>
                    </div>

                    <div class="space-y-3 mb-5">
                        <div class="flex justify-between items-center py-2 border-b border-gray-50">
                            <span class="text-xs font-semibold text-gray-500 uppercase">Username</span>
                            <span class="text-sm font-bold text-gray-900 font-mono">{{ $warga->user?->email ?? $warga->nik }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-50">
                            <span class="text-xs font-semibold text-gray-500 uppercase">Role</span>
                            <span class="inline-flex px-2 py-0.5 bg-blue-100 text-blue-700 text-[10px] font-bold rounded uppercase tracking-wider">WARGA</span>
                        </div>
                        
                        <div class="mt-3 p-3 bg-blue-50/70 border border-blue-100 rounded-lg">
                            <p class="text-[11px] text-blue-600 italic leading-relaxed text-center">
                                *Password tidak dapat dilihat. Admin hanya dapat melakukan reset password.*
                            </p>
                        </div>

                        <button type="button" @click="showResetModal = true" class="w-full mt-3 flex items-center justify-center gap-2 border border-blue-200 bg-blue-50 text-blue-700 text-xs font-bold uppercase tracking-wider py-2.5 rounded-lg hover:bg-blue-100 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            Reset Password
                        </button>
                    </div>
                </div>

            </div>{{-- end right col --}}

        </div>{{-- end grid --}}

        {{-- ===== CARD: DATA KESEHATAN ===== --}}
        <div class="mt-6 bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-blue-50 p-6">
            <div class="flex items-center gap-2 mb-5">
                <div class="w-7 h-7 rounded-lg bg-red-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-700">Data Kesehatan</h3>
                    <p class="text-[11px] text-gray-400">Sistem akan menentukan kategori layanan otomatis berdasarkan data ini.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- Status Kehamilan --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">
                        Status Kehamilan
                    </label>
                    <div class="flex items-center gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status_kehamilan" value="ya"
                                {{ old('status_kehamilan', $warga->status_kehamilan) == 'ya' ? 'checked' : '' }}
                                class="w-4 h-4 text-pink-500 border-gray-300 focus:ring-pink-500">
                            <span class="text-sm text-gray-700">Ya</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status_kehamilan" value="tidak"
                                {{ old('status_kehamilan', $warga->status_kehamilan) == 'tidak' || $warga->status_kehamilan == null ? 'checked' : '' }}
                                class="w-4 h-4 text-gray-400 border-gray-300 focus:ring-gray-300">
                            <span class="text-sm text-gray-700">Tidak</span>
                        </label>
                    </div>
                </div>

                {{-- Status Menyusui --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">
                        Status Menyusui
                    </label>
                    <div class="flex items-center gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status_menyusui" value="ya"
                                {{ old('status_menyusui', $warga->status_menyusui) == 'ya' ? 'checked' : '' }}
                                class="w-4 h-4 text-purple-500 border-gray-300 focus:ring-purple-500">
                            <span class="text-sm text-gray-700">Ya</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status_menyusui" value="tidak"
                                {{ old('status_menyusui', $warga->status_menyusui) == 'tidak' || $warga->status_menyusui == null ? 'checked' : '' }}
                                class="w-4 h-4 text-gray-400 border-gray-300 focus:ring-gray-300">
                            <span class="text-sm text-gray-700">Tidak</span>
                        </label>
                    </div>
                </div>

                {{-- Catatan Kesehatan --}}
                <div>
                    <label for="catatan_kesehatan" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                        Catatan Kesehatan <span class="text-gray-400 font-normal normal-case">(Opsional)</span>
                    </label>
                    <textarea name="catatan_kesehatan" id="catatan_kesehatan" rows="2"
                        class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800 placeholder-gray-400 transition-all resize-none"
                        placeholder="Riwayat penyakit, alergi, atau kondisi khusus...">{{ old('catatan_kesehatan', $warga->catatan_kesehatan) }}</textarea>
                    @error('catatan_kesehatan')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>

        {{-- ===== BOTTOM BUTTONS ===== --}}
        <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-100 px-6 py-4 flex flex-wrap items-center justify-between gap-4">
            <a href="{{ route($routePrefix . 'index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-gray-700 transition-colors">
                Kembali
            </a>
            
            <div class="flex items-center gap-3 w-full sm:w-auto">
                {{-- To closely match image: just "Reset Form" (using standard reset) and "Simpan Perubahan" --}}
                <button type="button" @click="window.location.reload()" class="hidden sm:inline-flex px-5 py-2.5 text-sm font-semibold text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Reset Form
                </button>
                <button type="submit" x-show="!loading" class="flex-1 sm:flex-none justify-center px-6 py-2.5 bg-[#033E8C] hover:bg-blue-900 text-white text-sm font-bold rounded-lg shadow-md transition-colors flex items-center gap-2">
                    Simpan Perubahan
                </button>
                <button type="button" x-show="loading" disabled class="flex-1 sm:flex-none justify-center px-6 py-2.5 bg-blue-400 text-white text-sm font-bold rounded-lg flex items-center gap-2 shadow-md cursor-not-allowed">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                    Menyimpan...
                </button>
            </div>
        </div>
    </form>

    {{-- MODAL RESET PASSWORD --}}
    <div x-show="showResetModal" class="fixed inset-0 z-[100] overflow-y-auto" style="display: none;">
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
                    {{-- Hidden flag to determine it's a reset action (Needs backend logic to catch this!) --}}
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
            Swal.fire({
                icon: 'success',
                title: 'Tersalin!',
                text: 'Kredensial berhasil disalin ke clipboard.',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
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

    function wargaEditForm() {
        return {
            loading: false,
            showResetModal: false,
            isResetting: false,
            
            initData() {
                // To fetch initial dependent dropdowns if IDs exists
                setTimeout(() => {
                    const provId = document.getElementById('provinsi_id').value;
                    const kabId = document.getElementById('kabupaten_id').getAttribute('data-selected');
                    const kecId = document.getElementById('kecamatan_id').getAttribute('data-selected');
                    const desaId = document.getElementById('kelurahan_id').getAttribute('data-selected');
                    
                    if(provId) this.getWilayah(provId, 'kabupaten', 'kabupaten_id', kabId).then(() => {
                        if(kabId) this.getWilayah(kabId, 'kecamatan', 'kecamatan_id', kecId).then(() => {
                            if(kecId) this.getWilayah(kecId, 'kelurahan', 'kelurahan_id', desaId);
                        });
                    });
                }, 100);
            },
            
            getWilayah(parentId, tingkat, targetId, selectedValue = null) {
                return new Promise((resolve) => {
                    if (!parentId) {
                        document.getElementById(targetId).innerHTML = `<option value="">Pilih ${tingkat}...</option>`;
                        resolve(); return;
                    }
                    
                    fetch(`/api/wilayah?parent_id=${parentId}&tingkat=${tingkat}`)
                        .then(res => res.json())
                        .then(data => {
                            const select = document.getElementById(targetId);
                            select.innerHTML = `<option value="">Pilih ${tingkat}...</option>`;
                            data.forEach(item => {
                                const option = document.createElement('option');
                                option.value = item.id;
                                option.textContent = item.nama;
                                if(selectedValue && item.id == selectedValue) option.selected = true;
                                select.appendChild(option);
                            });
                            resolve();
                        });
                });
            },
            
            previewMedia(event, imgId) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.getElementById(imgId);
                        img.src = e.target.result;
                        img.classList.remove('hidden');
                        
                        // Hide empty placeholder if it exists (for KTP/KK)
                        const emptySlot = img.nextElementSibling;
                        if(emptySlot && emptySlot.tagName === 'SPAN') {
                            emptySlot.classList.add('hidden');
                        }
                    };
                    reader.readAsDataURL(file);
                }
            },
            
            submitForm() {
                this.loading = true;
                this.$refs.form.submit();
            }
        }
    }
</script>
@endpush
@endsection