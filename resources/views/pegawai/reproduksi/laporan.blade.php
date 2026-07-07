{{-- resources/views/pegawai/reproduksi/laporan.blade.php --}}

@extends('layouts.app')

@section('title', 'Laporan Kesehatan Reproduksi')
@section('page-title', '📊 Laporan WUS & PUS')
@section('page-subtitle', 'Ekspor rekam medis, status KB, dan demografi.')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 animate-fade-in-up">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
        <h3 class="text-lg font-bold mb-4 text-gray-900 dark:text-gray-100">Filter Laporan</h3>
        
        <form method="GET" action="{{ route('pegawai.reproduksi.laporan') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter Waktu</label>
                <select name="waktu" class="w-full border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="hari_ini">Hari Ini</option>
                    <option value="bulan_ini" selected>Bulan Ini</option>
                    <option value="tahun_ini">Tahun Ini</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jenis Kontrasepsi</label>
                <select name="jenis_kontrasepsi" class="w-full border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">Semua</option>
                    <option value="pil">Pil</option>
                    <option value="suntik">Suntik</option>
                    <option value="iud">IUD</option>
                    <option value="implan">Implan</option>
                </select>
            </div>
            
            <div class="flex items-end gap-2">
                <button type="button" class="w-full py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg flex justify-center items-center">
                    Terapkan
                </button>
            </div>
        </form>
    </div>

    <!-- Export Actions Dummy (We didn't define export routes yet but UI needed) -->
    <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/40 dark:to-green-800/20 rounded-2xl shadow-sm border border-green-200 dark:border-green-800/50 p-6 flex flex-col justify-center items-center text-center">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Unduh Rekapitulasi</h3>
        <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-lg">Cetak dokumen Excel atau PDF berdasarkan filter yang diterapkan di atas.</p>
        
        <div class="flex gap-4">
            <button class="px-6 py-3 bg-[#036672] hover:bg-[#036672] text-white font-medium rounded-lg flex items-center transition" onclick="alert('Demo: Ekspor PDF')">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Export PDF
            </button>
            <button class="px-6 py-3 bg-[#036672] hover:bg-[#036672] text-white font-medium rounded-lg flex items-center transition" onclick="alert('Demo: Ekspor Excel')">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Export Excel
            </button>
        </div>
    </div>
</div>
@endsection
