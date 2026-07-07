{{-- resources/views/pegawai/reproduksi/pus-show.blade.php --}}

@extends('layouts.app')

@section('title', 'Detail PUS - Pegawai')

@section('page-title', '👫 Detail Pasangan Usia Subur')
@section('page-subtitle', 'Rincian informasi PUS (Pasangan Usia Subur) dan riwayat kesehatannya.')

@section('content')
<div class="space-y-6">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Data PUS</h3>
            <a href="{{ route('pegawai.reproduksi.pus.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-300 rounded-lg">Kembali</a>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Nama Pasangan (Suami)</p>
                    <p class="font-bold text-gray-900 dark:text-white text-lg">{{ $pus->nama_pasangan }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Nama Istri (WUS)</p>
                    <p class="font-bold text-blue-600 dark:text-blue-400 text-lg">
                        <a href="{{ route('pegawai.reproduksi.wus.show', $pus->wus_id) }}">{{ $pus->wus->nama }}</a>
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Jumlah Anak</p>
                    <p class="font-medium text-gray-900 dark:text-white text-lg">{{ $pus->jumlah_anak }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Status KB</p>
                    <p class="font-medium text-gray-900 dark:text-white">
                        <span class="px-3 py-1 rounded-full text-sm font-semibold @if($pus->status_kb==='aktif') bg-green-100 text-green-700 @else bg-gray-100 text-gray-700 @endif">
                            {{ $pus->status_kb_label }}
                        </span>
                    </p>
                </div>
                <div class="col-span-2">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Jenis Kontrasepsi Saat Ini</p>
                    <p class="font-medium text-gray-900 dark:text-white">{{ $pus->jenis_kontrasepsi ?? 'Belum/Tidak Menggunakan' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Tanggal Mulai KB</p>
                    <p class="font-medium text-gray-900 dark:text-white">{{ $pus->tanggal_mulai_kb ? $pus->tanggal_mulai_kb->format('d M Y') : '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Jadwal Kontrol Berikutnya</p>
                    <p class="font-medium text-gray-900 dark:text-white">{{ $pus->jadwal_kontrol ? $pus->jadwal_kontrol->format('d M Y') : '-' }}</p>
                </div>
            </div>
            
            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('pegawai.reproduksi.pelayanan.create', $pus->wus_id) }}" class="px-6 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg transition shadow-sm">
                    + Tambah Pelayanan
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
