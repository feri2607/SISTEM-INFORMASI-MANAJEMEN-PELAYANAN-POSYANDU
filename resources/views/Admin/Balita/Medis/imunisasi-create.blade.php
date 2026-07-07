@extends('layouts.app')

@section('title', 'Input Imunisasi Balita')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Input Data Imunisasi</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Balita: {{ $balita->nama }}</p>
        </div>
        
        <form action="{{ route(Auth::user()->role . '.balita.medis.imunisasi.store', $balita->id) }}" method="POST" class="p-6 space-y-4">
            @csrf
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal *</label>
                <input type="date" name="tanggal" required value="{{ date('Y-m-d') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:border-pink-500 focus:ring-pink-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Imunisasi *</label>
                <select name="jenis_imunisasi" required 
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:border-pink-500 focus:ring-pink-500">
                    <option value="">-- Pilih Imunisasi --</option>
                    <option value="Hepatitis B0">Hepatitis B0 (Lahir)</option>
                    <option value="BCG">BCG (1 Bulan)</option>
                    <option value="Polio 1">Polio 1 (1 Bulan)</option>
                    <option value="DPT-HB-Hib 1">DPT-HB-Hib 1 (2 Bulan)</option>
                    <option value="Polio 2">Polio 2 (2 Bulan)</option>
                    <option value="DPT-HB-Hib 2">DPT-HB-Hib 2 (3 Bulan)</option>
                    <option value="Polio 3">Polio 3 (3 Bulan)</option>
                    <option value="DPT-HB-Hib 3">DPT-HB-Hib 3 (4 Bulan)</option>
                    <option value="Polio 4">Polio 4 (4 Bulan)</option>
                    <option value="Campak">Campak (9 Bulan)</option>
                    <option value="Lainnya">Lainnya...</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Keterangan / Catatan Khusus</label>
                <textarea name="keterangan" rows="3" 
                          class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:border-pink-500 focus:ring-pink-500"></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route(Auth::user()->role . '.balita.show', $balita->id) }}" 
                   class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 text-gray-700 dark:text-gray-300 rounded-lg">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg">
                    Simpan Imunisasi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
