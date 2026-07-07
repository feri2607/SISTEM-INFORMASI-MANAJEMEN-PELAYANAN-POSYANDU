{{-- resources/views/kegiatan/create.blade.php --}}

@extends('layouts.app')

@section('title', 'Tambah Kegiatan - Sistem Informasi Posyandu')

@section('page-title', 'Tambah Kegiatan')
@section('page-subtitle', 'Buat kegiatan Posyandu baru')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <form method="POST" action="{{ route(auth()->user()->role . '.kegiatan.store') }}" id="kegiatanForm" x-data="kegiatanForm()" x-ref="form"
                    @submit.prevent="submitForm">
                    @csrf

                    <!-- Nama Kegiatan -->
                    <div class="mb-6">
                        <label for="nama_kegiatan"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Nama Kegiatan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_kegiatan" id="nama_kegiatan" x-model="form.nama_kegiatan"
                            maxlength="255"
                            class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white"
                            placeholder="Masukkan nama kegiatan" value="{{ old('nama_kegiatan') }}">
                        <div class="mt-1 flex justify-between text-xs text-gray-500 dark:text-gray-400">
                            <span x-text="characterCount + ' / 255 karakter'"></span>
                        </div>
                        @error('nama_kegiatan')
                            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal dan Waktu -->
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Tanggal & Waktu</h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Tanggal -->
                            <div>
                                <label for="tanggal"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                    Tanggal <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal" id="tanggal"
                                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white"
                                    value="{{ old('tanggal', date('Y-m-d')) }}">
                                @error('tanggal')
                                    <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Jam Mulai -->
                            <div>
                                <label for="jam_mulai"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                    Jam Mulai <span class="text-red-500">*</span>
                                </label>
                                <input type="time" name="jam_mulai" id="jam_mulai"
                                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white"
                                    value="{{ old('jam_mulai', '08:00') }}">
                                @error('jam_mulai')
                                    <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Jam Selesai -->
                            <div>
                                <label for="jam_selesai"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                    Jam Selesai
                                </label>
                                <input type="time" name="jam_selesai" id="jam_selesai"
                                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white"
                                    value="{{ old('jam_selesai', '12:00') }}">
                                @error('jam_selesai')
                                    <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Lokasi dan Status -->
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Lokasi & Status</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Lokasi -->
                            <div>
                                <label for="lokasi"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                    Lokasi <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="lokasi" id="lokasi"
                                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white"
                                    placeholder="Masukkan lokasi kegiatan" value="{{ old('lokasi') }}">
                                @error('lokasi')
                                    <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <select name="status" id="status"
                                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white">
                                    <option value="terjadwal" {{ old('status') == 'terjadwal' ? 'selected' : '' }}>Terjadwal
                                    </option>
                                    <option value="berlangsung" {{ old('status') == 'berlangsung' ? 'selected' : '' }}>
                                        Berlangsung</option>
                                    <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai
                                    </option>
                                    <option value="dibatalkan" {{ old('status') == 'dibatalkan' ? 'selected' : '' }}>
                                        Dibatalkan</option>
                                </select>
                                @error('status')
                                    <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Deskripsi</h3>

                        <div>
                            <label for="deskripsi"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Deskripsi Kegiatan
                            </label>
                            <textarea name="deskripsi" id="deskripsi" rows="5" x-model="form.deskripsi"
                                class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white"
                                placeholder="Deskripsi kegiatan...">{{ old('deskripsi') }}</textarea>
                            <div class="mt-1 text-xs text-gray-500 dark:text-gray-400 text-right">
                                <span x-text="deskripsiCount"></span> karakter
                            </div>
                            @error('deskripsi')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route(auth()->user()->role . '.kegiatan.index') }}"
                                class="px-6 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition duration-150">
                                Kembali
                            </a>
                            <button type="reset"
                                class="px-6 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition duration-150">
                                Reset
                            </button>
                        </div>
                        <button type="submit" id="submitButton" x-show="!loading"
                            class="px-8 py-2.5 bg-[#036672] hover:bg-[#036672] text-white font-medium rounded-lg transition duration-150 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                            </svg>
                            Simpan
                        </button>
                        <button type="button" x-show="loading" disabled
                            class="px-8 py-2.5 bg-blue-400 cursor-not-allowed text-white font-medium rounded-lg flex items-center">
                            <svg class="animate-spin h-5 w-5 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
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
            function kegiatanForm() {
                return {
                    loading: false,
                    form: {
                        nama_kegiatan: '{{ old('nama_kegiatan') }}',
                        deskripsi: '{{ old('deskripsi') }}'
                    },
                    get characterCount() {
                        return this.form.nama_kegiatan ? this.form.nama_kegiatan.length : 0;
                    },
                    get deskripsiCount() {
                        return this.form.deskripsi ? this.form.deskripsi.length : 0;
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