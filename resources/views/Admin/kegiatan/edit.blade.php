{{-- resources/views/Admin/kegiatan/edit.blade.php --}}

@extends('layouts.app')

@section('title', 'Edit Kegiatan Posyandu')
@section('page-title', 'Edit Kegiatan')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
    <form action="{{ route('admin.kegiatan.update', $kegiatan->id) }}" method="POST" class="p-6 md:p-8 space-y-8">
        @csrf
        @method('PUT')

        {{-- Form elements exactly identical to Create, but filled with existing data --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Kegiatan *</label>
                <input type="text" name="nama_kegiatan" value="{{ old('nama_kegiatan', $kegiatan->nama_kegiatan) }}" required
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 bg-white dark:bg-gray-900 border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-yellow-500">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Posyandu</label>
                <input type="text" name="posyandu" value="{{ old('posyandu', $kegiatan->posyandu) }}"
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:bg-gray-900 dark:border-gray-600 focus:ring-2 focus:ring-yellow-500">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal *</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', $kegiatan->tanggal->format('Y-m-d')) }}" required
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 bg-white dark:bg-gray-900 dark:border-gray-600 focus:ring-2 focus:ring-yellow-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jam Mulai *</label>
                <input type="time" name="jam_mulai" value="{{ old('jam_mulai', $kegiatan->jam_mulai->format('H:i')) }}" required
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:bg-gray-900 dark:border-gray-600 focus:ring-2 focus:ring-yellow-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jam Selesai *</label>
                <input type="time" name="jam_selesai" value="{{ old('jam_selesai', $kegiatan->jam_selesai->format('H:i')) }}" required
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:bg-gray-900 dark:border-gray-600 focus:ring-2 focus:ring-yellow-500">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Lokasi Terperinci *</label>
            <input type="text" name="lokasi" value="{{ old('lokasi', $kegiatan->lokasi) }}" required
                   class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:bg-gray-900 dark:border-gray-600 focus:ring-2 focus:ring-yellow-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Deskripsi Kegiatan</label>
            <textarea name="deskripsi" rows="3"
                      class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:bg-gray-900 dark:border-gray-600 focus:ring-2 focus:ring-yellow-500">{{ old('deskripsi', $kegiatan->deskripsi) }}</textarea>
        </div>

        <div class="bg-gray-50/50 dark:bg-gray-800/50 p-5 rounded-xl border border-gray-200 dark:border-gray-700">
            <label class="block text-base font-semibold text-gray-800 dark:text-gray-200 mb-4">Jenis Pelayanan *</label>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @php
                    $pelayananOptions = ['Balita', 'Kehamilan', 'Menyusui', 'WUS/PUS', 'Remaja', 'Lansia'];
                    $currentPelayanan = is_array($kegiatan->jenis_pelayanan) ? $kegiatan->jenis_pelayanan : [];
                @endphp
                @foreach($pelayananOptions as $opt)
                <label class="relative flex items-center p-3 cursor-pointer rounded-lg hover:bg-white dark:hover:bg-gray-700 border border-transparent hover:border-gray-200">
                    <input type="checkbox" name="jenis_pelayanan[]" value="{{ $opt }}" {{ in_array($opt, $currentPelayanan) ? 'checked' : '' }} class="w-5 h-5 text-yellow-600 border-gray-300 rounded focus:ring-yellow-500 cursor-pointer">
                    <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">{{ $opt }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Target Peserta</label>
                <input type="text" name="target_peserta" value="{{ old('target_peserta', $kegiatan->target_peserta) }}"
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:bg-gray-900 dark:border-gray-600 focus:ring-2 focus:ring-yellow-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status Kegiatan</label>
                <select name="status" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:bg-gray-900 dark:border-gray-600 focus:ring-2 focus:ring-yellow-500">
                    @foreach(['Draft', 'Terjadwal', 'Berlangsung', 'Selesai', 'Dibatalkan'] as $st)
                        <option value="{{ $st }}" {{ $kegiatan->status === $st ? 'selected' : '' }}>{{ $st }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200 dark:border-gray-700 mt-8">
            <a href="{{ route('admin.kegiatan.index') }}" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 transition">Batal</a>
            <button type="submit" class="px-6 py-2.5 bg-[#036672] hover:bg-[#036672] text-white rounded-lg shadow-lg font-medium transition">Update Kegiatan</button>
        </div>
    </form>
</div>
@endsection
