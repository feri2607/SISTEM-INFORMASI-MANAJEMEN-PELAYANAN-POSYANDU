@extends('layouts.app')

@section('title', 'Input Pemeriksaan Balita')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Input Pemeriksaan Bulanan</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Balita: {{ $balita->nama }}</p>
        </div>
        
        <form action="{{ route(Auth::user()->role . '.balita.medis.pemeriksaan.store', $balita->id) }}" method="POST" class="p-6 space-y-4">
            @csrf
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Pemeriksaan *</label>
                <input type="date" name="tanggal_pemeriksaan" required value="{{ date('Y-m-d') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Berat Badan (kg) *</label>
                    <input type="number" step="0.01" name="berat_badan" required 
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tinggi Badan (cm) *</label>
                    <input type="number" step="0.1" name="tinggi_badan" required 
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lingkar Kepala (cm)</label>
                    <input type="number" step="0.1" name="lingkar_kepala" 
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status Gizi (WHO)</label>
                    <input type="text" disabled value="Kalkulasi Otomatis (Z-Score)"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400 cursor-not-allowed">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Keterangan / Catatan</label>
                <textarea name="keterangan" rows="3" 
                          class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500"></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route(Auth::user()->role . '.balita.show', $balita->id) }}" 
                   class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 text-gray-700 dark:text-gray-300 rounded-lg">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg">
                    Simpan Pemeriksaan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
