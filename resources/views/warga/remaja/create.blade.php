{{-- resources/views/warga/remaja/create.blade.php --}}

@extends('layouts.public')

@section('hide-footer', true)
@section('title', 'Posyandu Remaja - Sistem Informasi Posyandu')

@section('page-title', '🧑 Tambah Data Remaja')
@section('page-subtitle', 'Isi data identitas remaja untuk layanan Posyandu Remaja.')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden">
        <div class="p-6">
            <form method="POST" action="{{ route('warga.remaja.store') }}" 
                  enctype="multipart/form-data"
                  x-data="remajaForm()"
                  x-ref="form"
                  @submit.prevent="submitForm">
                @csrf

                <div class="space-y-4">
                    {{-- Nama --}}
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Nama Lengkap <span class="text-red-500">*</span>
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
                            NIK <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nik" id="nik" 
                               maxlength="16"
                               x-model="form.nik"
                               @input="validateNIK()"
                               class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-gray-900 dark:text-white"
                               value="{{ old('nik') }}" required>
                        <p x-show="nikError" class="mt-1 text-sm text-red-600 dark:text-red-400" x-text="nikError"></p>
                        @error('nik')
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

                    {{-- Alamat --}}
                    <div>
                        <label for="alamat" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Alamat
                        </label>
                        <textarea name="alamat" id="alamat" rows="3" 
                                  class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-gray-900 dark:text-white">{{ old('alamat') }}</textarea>
                    </div>

                    {{-- Sekolah --}}
                    <div>
                        <label for="sekolah" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Sekolah
                        </label>
                        <input type="text" name="sekolah" id="sekolah" 
                               class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-gray-900 dark:text-white"
                               value="{{ old('sekolah') }}">
                        @error('sekolah')
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

                    {{-- Nomor HP --}}
                    <div>
                        <label for="no_hp" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Nomor HP
                        </label>
                        <input type="text" name="no_hp" id="no_hp" 
                               class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-gray-900 dark:text-white"
                               value="{{ old('no_hp') }}">
                        @error('no_hp')
                            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Foto --}}
                    <div>
                        <label for="foto" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Foto
                        </label>
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-20 h-20 rounded-full overflow-hidden bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600">
                                    <img id="fotoPreview" 
                                         src="https://ui-avatars.com/api/?name=User&color=7F9CF5&background=EBF4FF&size=100" 
                                         alt="Preview" 
                                         class="w-full h-full object-cover">
                                </div>
                            </div>
                            <div class="flex-1">
                                <input type="file" name="foto" id="foto" 
                                       accept="image/jpeg,image/png,image/jpg"
                                       @change="previewFoto($event)"
                                       class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-gray-900 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 dark:file:bg-teal-900/30 dark:file:text-teal-400">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Format: JPG, JPEG, PNG (Maks. 2MB)</p>
                            </div>
                        </div>
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
                            Data remaja akan diverifikasi oleh pegawai Posyandu. 
                            Data kesehatan (berat badan, tinggi badan, dll) akan diisi oleh pegawai saat pelayanan.
                        </p>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="flex flex-wrap items-center justify-between gap-3 mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('warga.remaja.index') }}" 
                       class="px-6 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition duration-150">
                        Kembali
                    </a>
                    <button type="submit" 
                            id="submitButton"
                            x-show="!loading"
                            class="px-8 py-2.5 bg-[#036672] hover:bg-[#036672] text-white font-medium rounded-lg transition duration-150 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        Simpan
                    </button>
                    <button type="button" 
                            x-show="loading"
                            disabled
                            class="px-8 py-2.5 bg-teal-400 cursor-not-allowed text-white font-medium rounded-lg flex items-center">
                        <svg class="animate-spin h-5 w-5 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Menyimpan...
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function remajaForm() {
        return {
            loading: false,
            form: {
                nama: '{{ old('nama') }}',
                nik: '{{ old('nik') }}',
                tanggal_lahir: '{{ old('tanggal_lahir') }}'
            },
            nikError: null,
            age: null,
            
            validateNIK() {
                const nik = this.form.nik;
                if (nik.length === 0) {
                    this.nikError = null;
                    return;
                }
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
            },
            
            previewFoto(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('fotoPreview').src = e.target.result;
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