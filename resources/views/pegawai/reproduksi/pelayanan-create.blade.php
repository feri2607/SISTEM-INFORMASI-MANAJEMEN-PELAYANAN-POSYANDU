{{-- resources/views/pegawai/reproduksi/pelayanan-create.blade.php --}}

@extends('layouts.app')

@section('title', 'Tambah Pelayanan KB')

@section('page-title', '🩺 Tambah Pelayanan KB')
@section('page-subtitle', 'Input pelayanan kesehatan reproduksi untuk ' . $wus->nama)

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden">
        <div class="p-6">
            <form method="POST" action="{{ route('pegawai.reproduksi.pelayanan.store') }}" 
                  x-data="pelayananForm()"
                  @submit.prevent="submitForm">
                @csrf

                <input type="hidden" name="wus_id" value="{{ $wus->id }}">

                <div class="space-y-4">
                    {{-- Tanggal --}}
                    <div>
                        <label for="tanggal" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Tanggal Pelayanan <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal" id="tanggal" 
                               class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white"
                               value="{{ old('tanggal', date('Y-m-d')) }}" required>
                        @error('tanggal')
                            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jenis Pelayanan --}}
                    <div>
                        <label for="jenis_pelayanan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Jenis Pelayanan <span class="text-red-500">*</span>
                        </label>
                        <select name="jenis_pelayanan" id="jenis_pelayanan" 
                                x-model="jenisPelayanan"
                                class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white">
                            <option value="">Pilih...</option>
                            <option value="konsultasi" {{ old('jenis_pelayanan') == 'konsultasi' ? 'selected' : '' }}>Konsultasi KB</option>
                            <option value="pemasangan_kb" {{ old('jenis_pelayanan') == 'pemasangan_kb' ? 'selected' : '' }}>Pemasangan KB</option>
                            <option value="kontrol" {{ old('jenis_pelayanan') == 'kontrol' ? 'selected' : '' }}>Kontrol KB</option>
                            <option value="skrining" {{ old('jenis_pelayanan') == 'skrining' ? 'selected' : '' }}>Skrining</option>
                            <option value="konseling" {{ old('jenis_pelayanan') == 'konseling' ? 'selected' : '' }}>Konseling</option>
                        </select>
                        @error('jenis_pelayanan')
                            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jenis Kontrasepsi (tampil jika pemasangan_kb) --}}
                    <div x-show="jenisPelayanan === 'pemasangan_kb'" x-transition>
                        <label for="jenis_kontrasepsi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Jenis Kontrasepsi
                        </label>
                        <select name="jenis_kontrasepsi" id="jenis_kontrasepsi" 
                                class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white">
                            <option value="">Pilih...</option>
                            <option value="pil" {{ old('jenis_kontrasepsi') == 'pil' ? 'selected' : '' }}>Pil</option>
                            <option value="suntik" {{ old('jenis_kontrasepsi') == 'suntik' ? 'selected' : '' }}>Suntik</option>
                            <option value="iud" {{ old('jenis_kontrasepsi') == 'iud' ? 'selected' : '' }}>IUD</option>
                            <option value="implan" {{ old('jenis_kontrasepsi') == 'implan' ? 'selected' : '' }}>Implan</option>
                            <option value="kondom" {{ old('jenis_kontrasepsi') == 'kondom' ? 'selected' : '' }}>Kondom</option>
                            <option value="mow" {{ old('jenis_kontrasepsi') == 'mow' ? 'selected' : '' }}>MOW</option>
                            <option value="mop" {{ old('jenis_kontrasepsi') == 'mop' ? 'selected' : '' }}>MOP</option>
                        </select>
                        @error('jenis_kontrasepsi')
                            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Hasil Pemeriksaan --}}
                    <div>
                        <label for="hasil_pemeriksaan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Hasil Pemeriksaan
                        </label>
                        <textarea name="hasil_pemeriksaan" id="hasil_pemeriksaan" rows="3" 
                                  class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white">{{ old('hasil_pemeriksaan') }}</textarea>
                    </div>

                    {{-- Catatan --}}
                    <div>
                        <label for="catatan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Catatan
                        </label>
                        <textarea name="catatan" id="catatan" rows="3" 
                                  class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white">{{ old('catatan') }}</textarea>
                    </div>

                    {{-- Jadwal Kontrol Berikutnya --}}
                    <div>
                        <label for="jadwal_kontrol_berikutnya" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Jadwal Kontrol Berikutnya
                        </label>
                        <input type="date" name="jadwal_kontrol_berikutnya" id="jadwal_kontrol_berikutnya" 
                               class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white"
                               value="{{ old('jadwal_kontrol_berikutnya') }}">
                        @error('jadwal_kontrol_berikutnya')
                            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jam & Lokasi Kontrol --}}
                    <div x-show="document.getElementById('jadwal_kontrol_berikutnya').value" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="jam_kontrol" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Jam Kontrol
                            </label>
                            <input type="time" name="jam_kontrol" id="jam_kontrol" 
                                   class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white"
                                   value="{{ old('jam_kontrol', '08:00') }}">
                        </div>
                        <div>
                            <label for="lokasi_kontrol" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Lokasi Kontrol
                            </label>
                            <input type="text" name="lokasi_kontrol" id="lokasi_kontrol" 
                                   class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white"
                                   value="{{ old('lokasi_kontrol', 'Posyandu') }}">
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap items-center justify-between gap-3 mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('pegawai.reproduksi.wus.show', $wus) }}" 
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
    function pelayananForm() {
        return {
            loading: false,
            jenisPelayanan: '{{ old('jenis_pelayanan') }}',
            submitForm() {
                this.loading = true;
                this.$refs.form.submit();
            }
        }
    }
</script>
@endpush
@endsection