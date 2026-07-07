{{-- resources/views/pegawai/reproduksi/kontrol-edit.blade.php --}}

@extends('layouts.app')

@section('title', 'Edit Jadwal Kontrol - Pegawai')

@section('page-title', '🗓️ Edit Jadwal Kontrol')
@section('page-subtitle', 'Ubah jadwal kontrol kesehatan ' . $kontrol->wus->nama)

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6">
        <form action="{{ route('pegawai.reproduksi.kontrol.update', $kontrol) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="wus_id" value="{{ $kontrol->wus_id }}">

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Kontrol *</label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', $kontrol->tanggal->format('Y-m-d')) }}" required
                           class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jam *</label>
                    <input type="time" name="jam" value="{{ old('jam', date('H:i', strtotime($kontrol->jam))) }}" required
                           class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Lokasi *</label>
                    <input type="text" name="lokasi" value="{{ old('lokasi', $kontrol->lokasi) }}" required
                           class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Keterangan / Tujuan</label>
                    <textarea name="keterangan" rows="3"
                              class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('keterangan', $kontrol->keterangan) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status Kehadiran</label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-teal-500 focus:border-teal-500 dark:bg-gray-700 dark:text-white">
                        <option value="terjadwal" {{ $kontrol->status == 'terjadwal' ? 'selected' : '' }}>Terjadwal</option>
                        <option value="selesai" {{ $kontrol->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="terlewat" {{ $kontrol->status == 'terlewat' ? 'selected' : '' }}>Terlewat / Tidak Hadir</option>
                    </select>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('pegawai.reproduksi.kontrol.index') }}" class="px-6 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">Batal</a>
                <button type="submit" class="px-6 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg shadow-sm transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
