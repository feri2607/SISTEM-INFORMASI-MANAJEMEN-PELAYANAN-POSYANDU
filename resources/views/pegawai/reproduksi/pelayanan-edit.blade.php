{{-- resources/views/pegawai/reproduksi/pelayanan-edit.blade.php --}}

@extends('layouts.app')

@section('title', 'Edit Pelayanan Reproduksi - Pegawai')

@section('page-title', '🩺 Edit Pelayanan WUS')
@section('page-subtitle', 'Ubah data pelayanan ' . $pelayanan->wus->nama)

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6">
        <form action="{{ route('pegawai.reproduksi.pelayanan.update', $pelayanan) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="wus_id" value="{{ $pelayanan->wus_id }}">

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Pelayanan *</label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', $pelayanan->tanggal->format('Y-m-d')) }}" required
                           class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jenis Pelayanan *</label>
                    <select name="jenis_pelayanan" required class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600">
                        <option value="konsultasi" {{ $pelayanan->jenis_pelayanan=='konsultasi'?'selected':'' }}>Konsultasi KB</option>
                        <option value="pemasangan_kb" {{ $pelayanan->jenis_pelayanan=='pemasangan_kb'?'selected':'' }}>Pemasangan/Suntik KB</option>
                        <option value="kontrol" {{ $pelayanan->jenis_pelayanan=='kontrol'?'selected':'' }}>Kontrol Rutin</option>
                        <option value="skrining" {{ $pelayanan->jenis_pelayanan=='skrining'?'selected':'' }}>Skrining Kesehatan</option>
                        <option value="konseling" {{ $pelayanan->jenis_pelayanan=='konseling'?'selected':'' }}>Konseling</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jenis Kontrasepsi (Opsional)</label>
                    <select name="jenis_kontrasepsi" class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600">
                        <option value="">Tidak Ada / Belum Pilih</option>
                        @foreach(['pil','suntik','iud','implan','kondom','mow','mop'] as $kb)
                            <option value="{{ $kb }}" {{ $pelayanan->jenis_kontrasepsi == $kb ? 'selected' : '' }}>{{ ucfirst($kb) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Hasil Pemeriksaan</label>
                    <textarea name="hasil_pemeriksaan" rows="3" class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600">{{ old('hasil_pemeriksaan', $pelayanan->hasil_pemeriksaan) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catatan / Keluhan</label>
                    <textarea name="catatan" rows="2" class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600">{{ old('catatan', $pelayanan->catatan) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jadwal Kontrol Berikutnya</label>
                    <input type="date" name="jadwal_kontrol_berikutnya" value="{{ old('jadwal_kontrol_berikutnya', $pelayanan->jadwal_kontrol_berikutnya?->format('Y-m-d')) }}"
                           class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600">
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('pegawai.reproduksi.wus.show', $pelayanan->wus_id) }}" class="px-6 py-2 border rounded-lg">Batal</a>
                <button type="submit" class="px-6 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
