{{-- resources/views/warga/edit.blade.php --}}

@extends('layouts.app')

@section('title', 'Edit Warga - Sistem Informasi Posyandu')

@section('page-title', 'Edit Warga')
@section('page-subtitle', 'Perbarui data warga')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <form method="POST" action="{{ route($routePrefix . 'update', $warga) }}" 
                  enctype="multipart/form-data" 
                  id="wargaForm"
                  x-data="wargaForm()"
                  x-ref="form"
                  @submit.prevent="submitForm">
                @csrf
                @method('PUT')

                <!-- User ID (Admin only) -->
                @if(Auth::user()->role === 'admin')
                <div class="mb-6">
                    <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Kader Penanggung Jawab
                    </label>
                    <select name="user_id" id="user_id" 
                            class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white">
                        <option value="">Pilih Kader...</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id', $warga->user_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                @endif

                <!-- Data Identitas (same as create) -->
                <div class="border-b border-gray-200 dark:border-gray-700 pb-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Data Identitas</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- NIK -->
                        <div>
                            <label for="nik" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                NIK <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nik" id="nik" 
                                   x-model="form.nik"
                                   @input="validateNIK()"
                                   maxlength="16"
                                   class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white"
                                   placeholder="16 digit angka"
                                   value="{{ old('nik', $warga->nik) }}">
                            <p x-show="nikError" class="mt-1.5 text-sm text-red-600 dark:text-red-400" x-text="nikError"></p>
                            @error('nik')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nama Lengkap -->
                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama" id="nama" 
                                   x-model="form.nama"
                                   class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white"
                                   placeholder="Nama lengkap"
                                   value="{{ old('nama', $warga->nama) }}">
                            @error('nama')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tempat Lahir -->
                        <div>
                            <label for="tempat_lahir" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Tempat Lahir <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="tempat_lahir" id="tempat_lahir" 
                                   class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white"
                                   placeholder="Kota/Kabupaten lahir"
                                   value="{{ old('tempat_lahir', $warga->tempat_lahir) }}">
                            @error('tempat_lahir')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Lahir -->
                        <div>
                            <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Tanggal Lahir <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" 
                                   x-model="form.tanggal_lahir"
                                   @change="calculateAge()"
                                   class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white"
                                   value="{{ old('tanggal_lahir', $warga->tanggal_lahir->format('Y-m-d')) }}">
                            <p x-show="age !== null" class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Usia: <span x-text="age + ' tahun'"></span>
                            </p>
                            @error('tanggal_lahir')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jenis Kelamin -->
                        <div>
                            <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Jenis Kelamin <span class="text-red-500">*</span>
                            </label>
                            <select name="jenis_kelamin" id="jenis_kelamin" 
                                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white">
                                <option value="">Pilih...</option>
                                <option value="L" {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Agama -->
                        <div>
                            <label for="agama" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Agama
                            </label>
                            <select name="agama" id="agama" 
                                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white">
                                <option value="">Pilih...</option>
                                <option value="Islam" {{ old('agama', $warga->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value="Kristen" {{ old('agama', $warga->agama) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                <option value="Katolik" {{ old('agama', $warga->agama) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                <option value="Hindu" {{ old('agama', $warga->agama) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="Buddha" {{ old('agama', $warga->agama) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                <option value="Konghucu" {{ old('agama', $warga->agama) == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                            </select>
                        </div>

                        <!-- Status Perkawinan -->
                        <div>
                            <label for="status_perkawinan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Status Perkawinan
                            </label>
                            <select name="status_perkawinan" id="status_perkawinan" 
                                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white">
                                <option value="">Pilih...</option>
                                @foreach($statusPerkawinan as $key => $label)
                                    <option value="{{ $key }}" {{ old('status_perkawinan', $warga->status_perkawinan) == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Pekerjaan -->
                        <div>
                            <label for="pekerjaan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Pekerjaan
                            </label>
                            <input type="text" name="pekerjaan" id="pekerjaan" 
                                   class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white"
                                   placeholder="Pekerjaan"
                                   value="{{ old('pekerjaan', $warga->pekerjaan) }}">
                        </div>
                    </div>
                </div>

                <!-- Data Alamat dan Kontak (same as create with old values) -->
                <!-- ... (same as create view with $warga values) ... -->

                <!-- Foto Upload dengan Preview -->
                <div class="border-b border-gray-200 dark:border-gray-700 pb-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Foto</h3>
                    
                    <div class="flex flex-col md:flex-row items-center gap-6">
                        <div class="flex-shrink-0">
                            <div class="w-32 h-32 rounded-full overflow-hidden bg-gray-100 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600">
                                <img id="fotoPreview" 
                                     src="{{ $warga->foto_url }}" 
                                     alt="Preview" 
                                     class="w-full h-full object-cover">
                            </div>
                        </div>
                        <div class="flex-1">
                            <label for="foto" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Upload Foto Baru
                            </label>
                            <input type="file" name="foto" id="foto" 
                                   accept="image/jpeg,image/png,image/jpg"
                                   @change="previewFoto($event)"
                                   class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900/30 dark:file:text-blue-400">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Format: JPG, JPEG, PNG (Maks. 2MB)</p>
                            @error('foto')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route($routePrefix . 'index') }}" 
                           class="px-6 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition duration-150">
                            Kembali
                        </a>
                        <button type="reset" 
                                class="px-6 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition duration-150">
                            Reset
                        </button>
                    </div>
                    <button type="submit" 
                            id="submitButton"
                            x-show="!loading"
                            class="px-8 py-2.5 bg-[#036672] hover:bg-[#036672] text-white font-medium rounded-lg transition duration-150 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        Perbarui
                    </button>
                    <button type="button" 
                            x-show="loading"
                            disabled
                            class="px-8 py-2.5 bg-blue-400 cursor-not-allowed text-white font-medium rounded-lg flex items-center">
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
    // Same JavaScript as create view
    function wargaForm() {
        return {
            loading: false,
            form: {
                nik: '{{ old('nik', $warga->nik) }}',
                nama: '{{ old('nama', $warga->nama) }}',
                tanggal_lahir: '{{ old('tanggal_lahir', $warga->tanggal_lahir->format('Y-m-d')) }}'
            },
            nikError: null,
            age: {{ $warga->umur }},
            
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
                    let age = today.getFullYear() - birthDate.getFullYear();
                    const monthDiff = today.getMonth() - birthDate.getMonth();
                    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                        age--;
                    }
                    this.age = age >= 0 ? age : null;
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
            
            getWilayah(parentId, tingkat, targetId) {
                // Same as create view
                if (!parentId) {
                    document.getElementById(targetId).innerHTML = `<option value="">Pilih ${tingkat}...</option>`;
                    return;
                }
                
                fetch(`/api/wilayah?parent_id=${parentId}&tingkat=${tingkat}`)
                    .then(response => response.json())
                    .then(data => {
                        const select = document.getElementById(targetId);
                        select.innerHTML = `<option value="">Pilih ${tingkat}...</option>`;
                        data.forEach(item => {
                            const option = document.createElement('option');
                            option.value = item.id;
                            option.textContent = item.nama;
                            select.appendChild(option);
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