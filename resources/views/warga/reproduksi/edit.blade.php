{{-- resources/views/warga/reproduksi/edit.blade.php --}}

@extends('layouts.public')

@section('title', 'Edit Data WUS - Sistem Informasi Posyandu')

@section('page-title', '🩺 Edit Data WUS')
@section('page-subtitle', 'Perbarui data Wanita Usia Subur (WUS).')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden">
        <div class="p-6">
            <form method="POST" action="{{ route('warga.reproduksi.update', $wus) }}" 
                  enctype="multipart/form-data"
                  x-data="wusForm()"
                  x-ref="form"
                  @submit.prevent="submitForm">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    {{-- Nama --}}
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Nama <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama" id="nama" 
                               class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-gray-900 dark:text-white"
                               value="{{ old('nama', $wus->nama) }}" required>
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
                               class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-gray-900 dark:text-white"
                               value="{{ old('nik', $wus->nik) }}" required>
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
                               class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-gray-900 dark:text-white"
                               value="{{ old('tanggal_lahir', $wus->tanggal_lahir?->format('Y-m-d')) }}" required>
                        @error('tanggal_lahir')
                            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Status Pernikahan --}}
                    <div>
                        <label for="status_pernikahan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Status Pernikahan
                        </label>
                        <select name="status_pernikahan" id="status_pernikahan" 
                                x-model="statusPernikahan"
                                class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-gray-900 dark:text-white">
                            <option value="">Pilih...</option>
                            @foreach($statusPernikahan as $status)
                                <option value="{{ $status }}" {{ old('status_pernikahan', $wus->status_pernikahan) == $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Data Pasangan (Kondisional) --}}
                    <div x-show="statusPernikahan === 'Kawin'" x-transition class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600 space-y-4">
                        <h4 class="font-medium text-gray-900 dark:text-white mb-2">Informasi Pasangan (PUS)</h4>
                        
                        <div>
                            <label for="nama_pasangan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Nama Pasangan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_pasangan" id="nama_pasangan" 
                                   :required="statusPernikahan === 'Kawin'"
                                   class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-gray-900 dark:text-white"
                                   value="{{ old('nama_pasangan', $wus->pus->nama_pasangan ?? '') }}">
                            @error('nama_pasangan')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="jumlah_anak" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Jumlah Anak
                            </label>
                            <input type="number" name="jumlah_anak" id="jumlah_anak" min="0" value="{{ old('jumlah_anak', $wus->pus->jumlah_anak ?? 0) }}"
                                   class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-gray-900 dark:text-white">
                            @error('jumlah_anak')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Alamat --}}
                    <div>
                        <label for="alamat" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Alamat
                        </label>
                        <textarea name="alamat" id="alamat" rows="3" 
                                  class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-gray-900 dark:text-white">{{ old('alamat', $wus->alamat) }}</textarea>
                    </div>

                    {{-- No HP --}}
                    <div>
                        <label for="no_hp" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Nomor HP
                        </label>
                        <input type="text" name="no_hp" id="no_hp" 
                               class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-gray-900 dark:text-white"
                               value="{{ old('no_hp', $wus->no_hp) }}">
                    </div>

                    {{-- Golongan Darah --}}
                    <div>
                        <label for="golongan_darah" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Golongan Darah
                        </label>
                        <select name="golongan_darah" id="golongan_darah" 
                                class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-gray-900 dark:text-white">
                            <option value="">Pilih...</option>
                            @foreach($golonganDarah as $gol)
                                <option value="{{ $gol }}" {{ old('golongan_darah', $wus->golongan_darah) == $gol ? 'selected' : '' }}>
                                    {{ $gol }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Riwayat Penyakit --}}
                    <div>
                        <label for="riwayat_penyakit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Riwayat Penyakit
                        </label>
                        <textarea name="riwayat_penyakit" id="riwayat_penyakit" rows="3" 
                                  class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-gray-900 dark:text-white">{{ old('riwayat_penyakit', $wus->riwayat_penyakit) }}</textarea>
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
                                         src="{{ $wus->foto_url }}" 
                                         alt="Preview" 
                                         class="w-full h-full object-cover">
                                </div>
                            </div>
                            <div class="flex-1">
                                <input type="file" name="foto" id="foto" 
                                       accept="image/jpeg,image/png,image/jpg"
                                       @change="previewFoto($event)"
                                       class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-gray-900 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 dark:file:bg-teal-900/30 dark:file:text-teal-400">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Biarkan kosong jika tidak ingin mengubah foto. Format: JPG, JPEG, PNG (Maks. 2MB)</p>
                            </div>
                        </div>
                        @error('foto')
                            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                {{-- Buttons --}}
                <div class="flex flex-wrap items-center justify-between gap-3 mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('warga.reproduksi.index') }}" 
                       class="px-6 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition duration-150">
                        Kembali
                    </a>
                    <button type="submit" 
                            id="submitButton"
                            x-show="!loading"
                            class="px-8 py-2.5 bg-[#036672] hover:bg-[#036672] text-white font-medium rounded-lg transition duration-150 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Simpan Perubahan
                    </button>
                    <button type="button" 
                            x-show="loading"
                            disabled
                            class="px-8 py-2.5 bg-yellow-400 cursor-not-allowed text-white font-medium rounded-lg flex items-center">
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
    function wusForm() {
        return {
            loading: false,
            statusPernikahan: '{{ old('status_pernikahan', $wus->status_pernikahan) }}',
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
