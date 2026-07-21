{{-- resources/views/Admin/warga/create.blade.php --}}

@extends('layouts.app')

@section('title', 'Tambah Warga - Sistem Informasi Posyandu')

@section('page-title', 'Tambah Warga')
@section('page-subtitle', 'Tambahkan data warga baru sekaligus membuat akun login secara otomatis.')

@section('content')
<div x-data="wargaForm()" x-ref="rootForm">

    {{-- ===== INFO ALERT ===== --}}
    <div class="mb-6 flex items-start gap-3 bg-blue-600 text-white rounded-xl px-5 py-4 shadow-sm">
        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p class="text-sm leading-relaxed">
            Setelah data warga disimpan, sistem akan secara otomatis membuat akun login untuk warga dengan role
            <strong>Warga</strong>. Password sementara akan dibuat secara otomatis dan wajib diganti saat login pertama.
        </p>
    </div>

    <form method="POST" action="{{ route($routePrefix . 'store') }}" enctype="multipart/form-data"
          id="wargaForm" x-ref="form" @submit.prevent="submitForm">
        @csrf

        {{-- ===== TWO-COLUMN GRID ===== --}}
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            {{-- ========== LEFT COLUMN (wider) ========== --}}
            <div class="xl:col-span-2 space-y-6">

                {{-- Admin: User PJ --}}
                @if(Auth::user()->role === 'admin')
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center gap-2 mb-5">
                        <div class="w-7 h-7 rounded-lg bg-purple-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-700">Penanggung Jawab</h3>
                    </div>
                    <div>
                        <label for="user_id" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                            Kader / Pegawai Penanggung Jawab
                        </label>
                        <select name="user_id" id="user_id"
                            class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800 transition-all">
                            <option value="">Pilih Kader...</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                @endif

                {{-- ===== CARD: IDENTITAS ===== --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">

                    <div class="flex items-center gap-2 mb-5">
                        <div class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-700">Identitas</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- Nama Lengkap --}}
                        <div class="md:col-span-2">
                            <label for="nama" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama" id="nama" x-model="form.nama"
                                class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800 placeholder-gray-400 transition-all"
                                placeholder="Masukkan nama sesuai KTP" value="{{ old('nama') }}">
                            @error('nama')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- NIK --}}
                        <div>
                            <label for="nik" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                                NIK (16 Digit) <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nik" id="nik" x-model="form.nik" @input="validateNIK()"
                                maxlength="16"
                                class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800 placeholder-gray-400 transition-all font-mono"
                                placeholder="3201xxxxxxxxxxxxxxx" value="{{ old('nik') }}">
                            <p x-show="nikError" class="mt-1 text-xs text-red-500" x-text="nikError"></p>
                            @error('nik')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Nomor KK --}}
                        <div>
                            <label for="nomor_kk" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                                Nomor KK <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nomor_kk" id="nomor_kk" maxlength="16"
                                class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800 placeholder-gray-400 transition-all font-mono"
                                placeholder="16 digit angka" value="{{ old('nomor_kk') }}">
                            @error('nomor_kk')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Jenis Kelamin --}}
                        <div>
                            <label for="jenis_kelamin" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                                Jenis Kelamin <span class="text-red-500">*</span>
                            </label>
                            <select name="jenis_kelamin" id="jenis_kelamin"
                                class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800 transition-all">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tempat Lahir --}}
                        <div>
                            <label for="tempat_lahir" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                                Tempat Lahir <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="tempat_lahir" id="tempat_lahir"
                                class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800 placeholder-gray-400 transition-all"
                                placeholder="Contoh: Jakarta" value="{{ old('tempat_lahir') }}">
                            @error('tempat_lahir')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tanggal Lahir --}}
                        <div>
                            <label for="tanggal_lahir" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                                Tanggal Lahir <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                x-model="form.tanggal_lahir" @change="calculateAge()"
                                class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800 transition-all"
                                value="{{ old('tanggal_lahir') }}">
                            <p x-show="age !== null" class="mt-1 text-xs text-gray-400">
                                Usia: <span class="font-medium text-gray-600" x-text="age + ' tahun'"></span>
                            </p>
                            @error('tanggal_lahir')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Nomor HP --}}
                        <div>
                            <label for="telepon" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                                Nomor HP <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="telepon" id="telepon"
                                class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800 placeholder-gray-400 transition-all"
                                placeholder="081xxxxxxxxx" value="{{ old('telepon') }}">
                            @error('telepon')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label for="email" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                                Email <span class="text-gray-400 font-normal normal-case">(Opsional)</span>
                            </label>
                            <input type="email" name="email" id="email"
                                class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800 placeholder-gray-400 transition-all"
                                placeholder="example@email.com" value="{{ old('email') }}">
                            @error('email')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Agama --}}
                        <div>
                            <label for="agama" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                                Agama
                            </label>
                            <select name="agama" id="agama"
                                class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800 transition-all">
                                <option value="">Pilih Agama</option>
                                <option value="Islam"    {{ old('agama') == 'Islam'    ? 'selected' : '' }}>Islam</option>
                                <option value="Kristen"  {{ old('agama') == 'Kristen'  ? 'selected' : '' }}>Kristen</option>
                                <option value="Katolik"  {{ old('agama') == 'Katolik'  ? 'selected' : '' }}>Katolik</option>
                                <option value="Hindu"    {{ old('agama') == 'Hindu'    ? 'selected' : '' }}>Hindu</option>
                                <option value="Buddha"   {{ old('agama') == 'Buddha'   ? 'selected' : '' }}>Buddha</option>
                                <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                            </select>
                        </div>

                        {{-- Status Perkawinan --}}
                        <div>
                            <label for="status_perkawinan" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                                Status Perkawinan
                            </label>
                            <select name="status_perkawinan" id="status_perkawinan"
                                class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800 transition-all">
                                <option value="">Pilih Status</option>
                                @foreach($statusPerkawinan as $key => $label)
                                    <option value="{{ $key }}" {{ old('status_perkawinan') == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Pekerjaan --}}
                        <div class="md:col-span-2">
                            <label for="pekerjaan" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                                Pekerjaan
                            </label>
                            <input type="text" name="pekerjaan" id="pekerjaan"
                                class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800 placeholder-gray-400 transition-all"
                                placeholder="Contoh: Pegawai Swasta" value="{{ old('pekerjaan') }}">
                        </div>

                    </div>
                </div>

                {{-- ===== CARD: ALAMAT ===== --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">

                    <div class="flex items-center gap-2 mb-5">
                        <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-700">Alamat</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- Alamat Lengkap --}}
                        <div class="md:col-span-2">
                            <label for="alamat" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                                Alamat Lengkap <span class="text-red-500">*</span>
                            </label>
                            <textarea name="alamat" id="alamat" rows="3"
                                class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800 placeholder-gray-400 transition-all resize-none"
                                placeholder="Nama Jalan, Blok, No Rumah...">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- RT --}}
                        <div>
                            <label for="rt" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">RT</label>
                            <input type="text" name="rt" id="rt"
                                class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800 placeholder-gray-400 transition-all"
                                placeholder="001" value="{{ old('rt') }}">
                        </div>

                        {{-- RW --}}
                        <div>
                            <label for="rw" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">RW</label>
                            <input type="text" name="rw" id="rw"
                                class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800 placeholder-gray-400 transition-all"
                                placeholder="001" value="{{ old('rw') }}">
                        </div>

                        {{-- Provinsi --}}
                        <div>
                            <label for="provinsi_id" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                                Provinsi
                            </label>
                            <select name="provinsi" id="provinsi_id"
                                @change="getWilayah($event.target.value, 'kabupaten', 'kabupaten_id')"
                                class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800 transition-all">
                                <option value="">Pilih Provinsi...</option>
                                @foreach($provinsi as $p)
                                    <option value="{{ $p->id }}" {{ old('provinsi') == $p->id ? 'selected' : '' }}>
                                        {{ $p->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Kabupaten/Kota --}}
                        <div>
                            <label for="kabupaten_id" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                                Kabupaten / Kota
                            </label>
                            <select name="kabupaten" id="kabupaten_id"
                                @change="getWilayah($event.target.value, 'kecamatan', 'kecamatan_id')"
                                class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800 transition-all">
                                <option value="">Pilih Kabupaten/Kota...</option>
                            </select>
                        </div>

                        {{-- Kecamatan --}}
                        <div>
                            <label for="kecamatan_id" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                                Kecamatan
                            </label>
                            <select name="kecamatan" id="kecamatan_id"
                                @change="getWilayah($event.target.value, 'kelurahan', 'kelurahan_id')"
                                class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800 transition-all">
                                <option value="">Pilih Kecamatan...</option>
                            </select>
                        </div>

                        {{-- Kelurahan/Desa --}}
                        <div>
                            <label for="kelurahan_id" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                                Kelurahan / Desa
                            </label>
                            <select name="desa" id="kelurahan_id"
                                class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800 transition-all">
                                <option value="">Pilih Kelurahan/Desa...</option>
                            </select>
                        </div>

                    </div>
                </div>

            </div>{{-- end left col --}}

            {{-- ========== RIGHT COLUMN ========== --}}
            <div class="xl:col-span-1 space-y-6">

                {{-- ===== CARD: FOTO PROFIL ===== --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center gap-2 mb-5">
                        <div class="w-7 h-7 rounded-lg bg-amber-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-700">Foto Profil</h3>
                    </div>

                    {{-- Preview --}}
                    <div class="flex flex-col items-center gap-4">
                        <div class="w-28 h-28 rounded-full bg-gray-100 border-2 border-dashed border-gray-300 overflow-hidden flex items-center justify-center">
                            <img id="fotoPreview"
                                src="https://ui-avatars.com/api/?name=Warga&color=2563EB&background=EFF6FF&size=128"
                                alt="Preview" class="w-full h-full object-cover">
                        </div>
                        <div class="w-full">
                            <label for="foto" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                                Upload Foto <span class="text-gray-400 font-normal normal-case">(Opsional)</span>
                            </label>
                            <input type="file" name="foto" id="foto" accept="image/jpeg,image/png,image/jpg"
                                @change="previewFoto($event)"
                                class="w-full text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 transition-all cursor-pointer">
                            <p class="mt-1.5 text-xs text-gray-400">Format JPG, PNG · Maks. 2MB</p>
                            @error('foto')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- ===== CARD: STATUS ===== --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center gap-2 mb-5">
                        <div class="w-7 h-7 rounded-lg bg-slate-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-700">Status</h3>
                    </div>

                    <div class="space-y-4">
                        {{-- Status Kependudukan --}}
                        <div>
                            <label for="status_kependudukan" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                                Status Kependudukan <span class="text-red-500">*</span>
                            </label>
                            <select name="status_kependudukan" id="status_kependudukan"
                                class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800 transition-all">
                                <option value="tetap"     {{ old('status_kependudukan', 'tetap') == 'tetap'      ? 'selected' : '' }}>Warga Tetap</option>
                                <option value="pendatang" {{ old('status_kependudukan') == 'pendatang' ? 'selected' : '' }}>Pendatang</option>
                            </select>
                            @error('status_kependudukan')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Status Keaktifan --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">
                                Status Keaktifan <span class="text-red-500">*</span>
                            </label>
                            <div class="flex items-center gap-6">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="status_keaktifan" value="aktif"
                                        {{ old('status_keaktifan', 'aktif') == 'aktif' ? 'checked' : '' }}
                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <span class="text-sm text-gray-700">Aktif</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="status_keaktifan" value="tidak_aktif"
                                        {{ old('status_keaktifan') == 'tidak_aktif' ? 'checked' : '' }}
                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <span class="text-sm text-gray-700">Tidak Aktif</span>
                                </label>
                            </div>
                            @error('status_keaktifan')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- ===== CARD: AKUN LOGIN WARGA (info only) ===== --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center gap-2 mb-5">
                        <div class="w-7 h-7 rounded-lg bg-indigo-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                            </svg>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-700">Akun Login Warga</h3>
                    </div>

                    <div class="space-y-3 text-sm">
                        <div class="flex items-center justify-between py-2 border-b border-gray-50">
                            <span class="text-gray-500 text-xs">Role</span>
                            <span class="px-2 py-0.5 bg-blue-600 text-white text-xs font-semibold rounded">WARGA</span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-50">
                            <span class="text-gray-500 text-xs">Username</span>
                            <span class="text-gray-600 text-xs text-right">NIK (16 Digit)</span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-50">
                            <span class="text-gray-500 text-xs">Password</span>
                            <span class="text-gray-600 text-xs italic">Dibuat Otomatis</span>
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <span class="text-gray-500 text-xs">Status Akun</span>
                            <span class="px-2 py-0.5 bg-amber-50 text-amber-600 text-xs font-semibold rounded border border-amber-200">MENUNGGU LOGIN</span>
                        </div>
                    </div>

                    <div class="mt-4 p-3 bg-blue-50 rounded-lg border border-blue-100">
                        <p class="text-xs text-blue-600 leading-relaxed">
                            Setelah data berhasil disimpan, sistem akan menghasilkan password sementara. Pegawai dapat mencetak atau membagikan informasi login kepada warga.
                        </p>
                    </div>
                </div>

            </div>{{-- end right col --}}

        </div>{{-- end grid --}}

        {{-- ===== CARD: DATA KESEHATAN ===== --}}
        <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center gap-2 mb-5">
                <div class="w-7 h-7 rounded-lg bg-red-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-700">Data Kesehatan</h3>
                    <p class="text-xs text-gray-400">Sistem akan menentukan kategori layanan otomatis berdasarkan data ini.</p>
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
                                {{ old('status_kehamilan') == 'ya' ? 'checked' : '' }}
                                class="w-4 h-4 text-pink-500 border-gray-300 focus:ring-pink-500">
                            <span class="text-sm text-gray-700">Ya</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status_kehamilan" value="tidak"
                                {{ old('status_kehamilan', 'tidak') == 'tidak' ? 'checked' : '' }}
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
                                {{ old('status_menyusui') == 'ya' ? 'checked' : '' }}
                                class="w-4 h-4 text-purple-500 border-gray-300 focus:ring-purple-500">
                            <span class="text-sm text-gray-700">Ya</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status_menyusui" value="tidak"
                                {{ old('status_menyusui', 'tidak') == 'tidak' ? 'checked' : '' }}
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
                    <textarea name="catatan_kesehatan" id="catatan_kesehatan" rows="3"
                        class="w-full px-3 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800 placeholder-gray-400 transition-all resize-none"
                        placeholder="Riwayat penyakit, alergi, atau kondisi khusus...">{{ old('catatan_kesehatan') }}</textarea>
                    @error('catatan_kesehatan')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div class="mt-4 p-3 bg-blue-50 rounded-lg border border-blue-100">
                <p class="text-xs text-blue-600 leading-relaxed">
                    <strong>Catatan:</strong> Sistem akan secara otomatis menentukan kategori layanan (Balita, Remaja, Lansia, WUS/PUS, Kehamilan, Menyusui) berdasarkan data usia warga dan status di atas — tanpa perlu input manual.
                </p>
            </div>
        </div>

        {{-- ===== BUTTONS ===== --}}
        <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-100 px-6 py-4 flex flex-wrap items-center justify-between gap-3">
            <a href="{{ route($routePrefix . 'index') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors duration-150">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>

            <div class="flex items-center gap-3">
                <button type="reset"
                    class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-gray-600 border border-gray-200 hover:bg-gray-50 rounded-lg transition-colors duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Reset Form
                </button>

                <button type="submit" x-show="!loading"
                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                    </svg>
                    Simpan Data
                </button>

                <button type="button" x-show="loading" disabled
                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-blue-400 cursor-not-allowed text-white text-sm font-medium rounded-lg">
                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                    </svg>
                    Menyimpan...
                </button>
            </div>
        </div>

    </form>
</div>

@push('scripts')
<script>
    function wargaForm() {
        return {
            loading: false,
            form: {
                nik: '{{ old('nik') }}',
                nama: '{{ old('nama') }}',
                tanggal_lahir: '{{ old('tanggal_lahir') }}'
            },
            nikError: null,
            age: null,

            validateNIK() {
                const nik = this.form.nik;
                if (nik.length === 0) { this.nikError = null; return; }
                if (!/^\d+$/.test(nik)) {
                    this.nikError = 'NIK hanya boleh berupa angka';
                } else if (nik.length !== 16) {
                    this.nikError = 'NIK harus 16 digit';
                } else {
                    this.nikError = null;
                }
            },

            calculateAge() {
                if (this.form.tanggal_lahir) {
                    const birthDate = new Date(this.form.tanggal_lahir);
                    const today = new Date();
                    let age = today.getFullYear() - birthDate.getFullYear();
                    const monthDiff = today.getMonth() - birthDate.getMonth();
                    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) age--;
                    this.age = age >= 0 ? age : null;
                } else {
                    this.age = null;
                }
            },

            previewFoto(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = e => { document.getElementById('fotoPreview').src = e.target.result; };
                    reader.readAsDataURL(file);
                }
            },

            getWilayah(parentId, tingkat, targetId) {
                if (!parentId) {
                    document.getElementById(targetId).innerHTML = `<option value="">Pilih ${tingkat}...</option>`;
                    return;
                }
                fetch(`/api/wilayah?parent_id=${parentId}&tingkat=${tingkat}`)
                    .then(r => r.json())
                    .then(data => {
                        const select = document.getElementById(targetId);
                        select.innerHTML = `<option value="">Pilih ${tingkat}...</option>`;
                        data.forEach(item => {
                            const opt = document.createElement('option');
                            opt.value = item.id;
                            opt.textContent = item.nama;
                            select.appendChild(opt);
                        });
                    });
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