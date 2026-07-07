{{-- resources/views/balita/create.blade.php --}}

@extends('layouts.app')

@section('title', 'Tambah Balita - Sistem Informasi Posyandu')

@section('page-title', 'Tambah Balita')
@section('page-subtitle', 'Silakan isi data balita dengan lengkap')

@section('content')
    <div class="max-w-5xl mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <form method="POST" action="{{ route($routePrefix . 'store') }}" id="balitaForm" x-data="balitaForm()"
                    @submit.prevent="submitForm">
                    @csrf

                    <!-- Data Balita -->
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Data Balita</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Orang Tua / Warga -->
                            <div class="md:col-span-2">
                                <label for="warga_id"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                    Orang Tua (Warga) <span class="text-red-500">*</span>
                                </label>
                                <select name="warga_id" id="warga_id" required
                                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white">
                                    <option value="">Pilih Orang Tua...</option>
                                    @foreach($wargaList as $warga)
                                        <option value="{{ $warga->id }}" {{ (old('warga_id') ?? ($selectedWarga->id ?? '')) == $warga->id ? 'selected' : '' }}>
                                            {{ $warga->nama }} (NIK: {{ $warga->nik }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('warga_id')
                                    <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nama Balita -->
                            <div>
                                <label for="nama" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama" id="nama" required
                                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white"
                                    placeholder="Nama lengkap balita" value="{{ old('nama') }}">
                                @error('nama')
                                    <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Jenis Kelamin -->
                            <div>
                                <label for="jenis_kelamin"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                    Jenis Kelamin <span class="text-red-500">*</span>
                                </label>
                                <select name="jenis_kelamin" id="jenis_kelamin" required
                                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white">
                                    <option value="">Pilih...</option>
                                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tanggal Lahir -->
                            <div>
                                <label for="tanggal_lahir"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                    Tanggal Lahir <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir" required
                                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white"
                                    value="{{ old('tanggal_lahir') }}">
                                @error('tanggal_lahir')
                                    <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Anak Ke -->
                            <div>
                                <label for="anak_ke"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                    Anak Ke
                                </label>
                                <input type="number" name="anak_ke" id="anak_ke"
                                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white"
                                    placeholder="Contoh: 1" value="{{ old('anak_ke') }}">
                                @error('anak_ke')
                                    <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Berat Lahir -->
                            <div>
                                <label for="berat_lahir"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                    Berat Lahir (kg)
                                </label>
                                <input type="number" step="0.01" name="berat_lahir" id="berat_lahir"
                                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white"
                                    placeholder="Contoh: 3.2" value="{{ old('berat_lahir') }}">
                                @error('berat_lahir')
                                    <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Panjang Lahir -->
                            <div>
                                <label for="panjang_lahir"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                    Panjang Lahir (cm)
                                </label>
                                <input type="number" step="0.1" name="panjang_lahir" id="panjang_lahir"
                                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white"
                                    placeholder="Contoh: 50" value="{{ old('panjang_lahir') }}">
                                @error('panjang_lahir')
                                    <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Keterangan -->
                            <div class="md:col-span-2">
                                <label for="keterangan"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                    Keterangan
                                </label>
                                <textarea name="keterangan" id="keterangan" rows="3"
                                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white"
                                    placeholder="Catatan tambahan tentang balita (opsional)">{{ old('keterangan') }}</textarea>
                                @error('keterangan')
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
                        </div>
                        <button type="submit" x-show="!loading"
                            class="px-8 py-2.5 bg-[#036672] hover:bg-[#036672] text-white font-medium rounded-lg transition duration-150 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Simpan Data Balita
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
            function balitaForm() {
                return {
                    loading: false,
                    submitForm() {
                        this.loading = true;
                        document.getElementById('balitaForm').submit();
                    }
                }
            }
        </script>
    @endpush
@endsection