{{-- resources/views/Admin/kegiatan/create.blade.php --}}

@extends('layouts.app')

@section('title', 'Tambah Kegiatan Posyandu')
@section('page-title', 'Tambah Kegiatan')
@section('page-subtitle', 'Jadwalkan kegiatan Posyandu baru')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden" x-data="kegiatanForm()">
    <form action="{{ route('admin.kegiatan.store') }}" method="POST" class="p-6 md:p-8 space-y-8">
        @csrf

        {{-- Row 1 --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Kegiatan *</label>
                <input type="text" name="nama_kegiatan" value="{{ old('nama_kegiatan') }}" required
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 bg-gray-50 dark:bg-gray-900/50 dark:border-gray-600 dark:text-white transition-all shadow-sm">
                @error('nama_kegiatan') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Posyandu</label>
                <input type="text" name="posyandu" value="{{ old('posyandu') }}"
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-500 bg-gray-50 dark:bg-gray-900/50 dark:border-gray-600 dark:text-white transition-all shadow-sm">
            </div>
        </div>

        {{-- Row 2 --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal *</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-500 bg-gray-50 dark:bg-gray-900/50 dark:border-gray-600 dark:text-white shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jam Mulai *</label>
                <input type="time" name="jam_mulai" value="{{ old('jam_mulai', '08:00') }}" required
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-500 bg-gray-50 dark:bg-gray-900/50 dark:border-gray-600 dark:text-white shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jam Selesai *</label>
                <input type="time" name="jam_selesai" value="{{ old('jam_selesai', '12:00') }}" required
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-500 bg-gray-50 dark:bg-gray-900/50 dark:border-gray-600 dark:text-white shadow-sm">
            </div>
        </div>

        {{-- Row 3 --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Lokasi Terperinci *</label>
            <input type="text" name="lokasi" value="{{ old('lokasi') }}" required placeholder="Contoh: Balai Desa Mekar Jaya"
                   class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-500 bg-gray-50 dark:bg-gray-900/50 dark:border-gray-600 dark:text-white shadow-sm">
        </div>

        {{-- Deskripsi --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Deskripsi Kegiatan</label>
            <textarea name="deskripsi" rows="3"
                      class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-500 bg-gray-50 dark:bg-gray-900/50 dark:border-gray-600 dark:text-white shadow-sm">{{ old('deskripsi') }}</textarea>
        </div>

        {{-- Jenis Pelayanan Checkbox Options --}}
        <div class="bg-gray-50/50 dark:bg-gray-800/50 p-5 rounded-xl border border-gray-200 dark:border-gray-700">
            <label class="block text-base font-semibold text-gray-800 dark:text-gray-200 mb-4">Jenis Pelayanan *</label>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @php
                    $pelayananOptions = ['Balita', 'Kehamilan', 'Menyusui', 'WUS/PUS', 'Remaja', 'Lansia'];
                @endphp
                @foreach($pelayananOptions as $opt)
                <label class="relative flex items-center p-3 cursor-pointer rounded-lg hover:bg-white dark:hover:bg-gray-700 border border-transparent hover:border-gray-200 dark:hover:border-gray-600 transition-all shadow-sm">
                    <input type="checkbox" name="jenis_pelayanan[]" value="{{ $opt }}" class="w-5 h-5 text-yellow-600 border-gray-300 rounded focus:ring-yellow-500 cursor-pointer">
                    <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">{{ $opt }}</span>
                </label>
                @endforeach
            </div>
            @error('jenis_pelayanan') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror
        </div>

        {{-- Advanced --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Target Peserta</label>
                <input type="text" name="target_peserta" value="{{ old('target_peserta') }}" placeholder="Contoh: Balita 0-5 Tahun & Bumil Resti"
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-500 bg-gray-50 dark:bg-gray-900/50 dark:border-gray-600 shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status Awal</label>
                <select name="status" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-500 bg-gray-50 dark:bg-gray-900/50 dark:border-gray-600 dark:text-white shadow-sm">
                    <option value="Draft">Draft</option>
                    <option value="Terjadwal">Terjadwal</option>
                </select>
            </div>
        </div>

        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200 dark:border-gray-700 mt-8">
            <a href="{{ route('admin.kegiatan.index') }}" class="px-6 py-2.5 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg font-medium transition-colors">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 text-white bg-[#036672] hover:bg-[#036672] rounded-lg font-medium shadow-md shadow-yellow-500/20 transition-all flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                Simpan Kegiatan
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('kegiatanForm', () => ({
            // form interactions can be added here
        }));
    });
</script>
@endpush
@endsection
