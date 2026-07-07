{{-- resources/views/warga/balita/create.blade.php --}}

@extends('layouts.public')

@section('hide-footer', true)
@section('title', 'Tambah Balita - Sistem Informasi Posyandu')

@section('page-title', '👶 Tambah Balita')
@section('page-subtitle', 'Isi data identitas balita Anda')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden">
        <div class="p-6">
            <form method="POST" action="{{ route('warga.balita.store') }}" 
                  x-data="balitaForm()" enctype="multipart/form-data">
                @csrf

                <div class="space-y-4">
                    {{-- Nama --}}
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Nama Balita <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama" id="nama" 
                               x-model="form.nama"
                               class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-gray-900 dark:text-white"
                               value="{{ old('nama') }}" required>
                        @error('nama')
                            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- NIK --}}
                    <div>
                        <label for="nik" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            NIK Balita
                        </label>
                        <input type="text" name="nik" id="nik" 
                               class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-gray-900 dark:text-white"
                               value="{{ old('nik') }}" maxlength="16">
                        @error('nik')
                            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nomor KK --}}
                    <div>
                        <label for="nomor_kk" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Nomor KK
                        </label>
                        <input type="text" name="nomor_kk" id="nomor_kk" 
                               class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-gray-900 dark:text-white"
                               value="{{ old('nomor_kk') }}" maxlength="16">
                        @error('nomor_kk')
                            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tanggal Lahir --}}
                    <div>
                        <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Tanggal Lahir <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" 
                               x-model="form.tanggal_lahir"
                               @change="calculateAge()"
                               class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-gray-900 dark:text-white"
                               value="{{ old('tanggal_lahir') }}" required>
                        <p x-show="age !== null" class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Usia: <span x-text="age"></span>
                        </p>
                        @error('tanggal_lahir')
                            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div>
                        <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Jenis Kelamin <span class="text-red-500">*</span>
                        </label>
                        <select name="jenis_kelamin" id="jenis_kelamin" 
                                class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-gray-900 dark:text-white">
                            <option value="">Pilih...</option>
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tempat Lahir --}}
                    <div>
                        <label for="tempat_lahir" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Tempat Lahir
                        </label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" 
                               class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-gray-900 dark:text-white"
                               value="{{ old('tempat_lahir') }}">
                        @error('tempat_lahir')
                            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nama Ayah --}}
                    <div>
                        <label for="nama_ayah" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Nama Ayah
                        </label>
                        <input type="text" name="nama_ayah" id="nama_ayah" 
                               class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-gray-900 dark:text-white"
                               value="{{ old('nama_ayah') }}">
                        @error('nama_ayah')
                            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nama Ibu --}}
                    <div>
                        <label for="nama_ibu" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Nama Ibu
                        </label>
                        <input type="text" name="nama_ibu" id="nama_ibu" 
                               class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-gray-900 dark:text-white"
                               value="{{ old('nama_ibu') }}">
                        @error('nama_ibu')
                            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Alamat --}}
                    <div>
                        <label for="alamat" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Alamat Lengkap
                        </label>
                        <textarea name="alamat" id="alamat" rows="2"
                                  class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-gray-900 dark:text-white">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Golongan Darah --}}
                    <div>
                        <label for="golongan_darah" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Golongan Darah
                        </label>
                        <select name="golongan_darah" id="golongan_darah" 
                                class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-gray-900 dark:text-white">
                            <option value="">Pilih...</option>
                            <option value="A" {{ old('golongan_darah') == 'A' ? 'selected' : '' }}>A</option>
                            <option value="B" {{ old('golongan_darah') == 'B' ? 'selected' : '' }}>B</option>
                            <option value="AB" {{ old('golongan_darah') == 'AB' ? 'selected' : '' }}>AB</option>
                            <option value="O" {{ old('golongan_darah') == 'O' ? 'selected' : '' }}>O</option>
                        </select>
                        @error('golongan_darah')
                            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- No HP Orang Tua --}}
                    <div>
                        <label for="no_hp_orang_tua" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Nomor HP Orang Tua
                        </label>
                        <input type="text" name="no_hp_orang_tua" id="no_hp_orang_tua" 
                               class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-gray-900 dark:text-white"
                               value="{{ old('no_hp_orang_tua') }}">
                        @error('no_hp_orang_tua')
                            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Upload Foto --}}
                    <div>
                        <label for="foto" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Upload Foto
                        </label>
                        <input type="file" name="foto" id="foto" accept="image/*"
                               class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-gray-900 dark:text-white">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Format: JPG, PNG. Maksimal 2MB.</p>
                        @error('foto')
                            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Informasi --}}
                    <div class="p-4 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                        <p class="text-sm text-blue-700 dark:text-blue-300">
                            <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Data balita akan diverifikasi oleh pegawai Posyandu. 
                            Data kesehatan (berat badan, tinggi badan, dll) akan diisi oleh pegawai saat pelayanan.
                        </p>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="flex flex-wrap items-center justify-between gap-3 mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('warga.balita.index') }}" 
                       class="px-6 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition duration-150">
                        Kembali
                    </a>
                    <button type="submit" 
                            class="px-8 py-2.5 bg-[#036672] hover:bg-[#036672] text-white font-medium rounded-lg transition duration-150 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function balitaForm() {
        return {
            form: {
                nama: '{{ old('nama') }}',
                tanggal_lahir: '{{ old('tanggal_lahir') }}'
            },
            age: null,
            calculateAge() {
                if (this.form.tanggal_lahir) {
                    const birthDate = new Date(this.form.tanggal_lahir);
                    const today = new Date();
                    let years = today.getFullYear() - birthDate.getFullYear();
                    let months = today.getMonth() - birthDate.getMonth();
                    let days = today.getDate() - birthDate.getDate();
                    
                    if (days < 0) {
                        months--;
                        const prevMonth = new Date(today.getFullYear(), today.getMonth(), 0);
                        days += prevMonth.getDate();
                    }
                    if (months < 0) {
                        years--;
                        months += 12;
                    }
                    
                    if (years > 0) {
                        this.age = `${years} tahun ${months} bulan`;
                    } else if (months > 0) {
                        this.age = `${months} bulan ${days} hari`;
                    } else {
                        this.age = `${days} hari`;
                    }
                } else {
                    this.age = null;
                }
            }
        }
    }
</script>
@endpush
@endsection