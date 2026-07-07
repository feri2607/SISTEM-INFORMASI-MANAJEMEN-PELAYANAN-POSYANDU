{{-- resources/views/pegawai/reproduksi/konseling/edit.blade.php --}}

@extends('layouts.app')

@section('title', 'Edit Konseling - Pegawai')

@section('page-title', '🗨️ Edit Konseling WUS')
@section('page-subtitle', 'Ubah data riwayat konseling ' . $konseling->wus->nama)

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6">
        <form action="{{ route('pegawai.reproduksi.konseling.update', $konseling) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="wus_id" value="{{ $konseling->wus_id }}">

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Konseling *</label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', $konseling->tanggal->format('Y-m-d')) }}" required
                           class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Topik Konseling *</label>
                    <input type="text" name="topik" value="{{ old('topik', $konseling->topik) }}" required
                           class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catatan</label>
                    <textarea name="catatan" rows="4"
                              class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('catatan', $konseling->catatan) }}</textarea>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('pegawai.reproduksi.wus.show', $konseling->wus_id) }}" class="px-6 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">Batal</a>
                <button type="submit" class="px-6 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg shadow-sm transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
