{{-- resources/views/pegawai/lansia/jadwal-senam/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Jadwal Senam - Sistem Informasi Posyandu')
@section('page-title', 'Tamba Jadwal Senam')
@section('page-subtitle', 'Buat jadwal senam baru untuk lansia')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <form action="{{ route('pegawai.lansia.jadwal.store') }}" method="POST">
            @csrf
            
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Tanggal --}}
                    <div>
                        <label for="tanggal" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal') }}" required
                               class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-teal-500 focus:border-teal-500 text-gray-900 dark:text-white">
                        @error('tanggal')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    {{-- Jam --}}
                    <div>
                        <label for="jam" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jam (WIB) <span class="text-red-500">*</span></label>
                        <input type="time" name="jam" id="jam" value="{{ old('jam') }}" required
                               class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-teal-500 focus:border-teal-500 text-gray-900 dark:text-white">
                        @error('jam')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Lokasi --}}
                <div>
                    <label for="lokasi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Lokasi Senam <span class="text-red-500">*</span></label>
                    <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi') }}" required placeholder="Contoh: Balai Desa Sukamaju"
                           class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-teal-500 focus:border-teal-500 text-gray-900 dark:text-white">
                    @error('lokasi')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Instruktur --}}
                    <div>
                        <label for="instruktur" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Instruktur</label>
                        <input type="text" name="instruktur" id="instruktur" value="{{ old('instruktur') }}" placeholder="Opsional"
                               class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-teal-500 focus:border-teal-500 text-gray-900 dark:text-white">
                        @error('instruktur')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    {{-- Kuota --}}
                    <div>
                        <label for="kuota" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kuota Peserta <span class="text-red-500">*</span></label>
                        <input type="number" name="kuota" id="kuota" value="{{ old('kuota', 50) }}" required min="1"
                               class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-teal-500 focus:border-teal-500 text-gray-900 dark:text-white">
                        @error('kuota')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Status --}}
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status Kegiatan</label>
                    <select name="status" id="status" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-teal-500 focus:border-teal-500 text-gray-900 dark:text-white">
                        <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="batal" {{ old('status') == 'batal' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
            </div>
            
            <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 flex items-center justify-end gap-3 border-t border-gray-200 dark:border-gray-700 rounded-b-xl">
                <a href="{{ route('pegawai.lansia.jadwal.index') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 bg-[#036672] text-white rounded-lg text-sm font-medium hover:bg-[#036672]">
                    Simpan Jadwal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
