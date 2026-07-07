@extends('layouts.app')

@section('title', 'Input Perkembangan Balita')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Input Evaluasi Perkembangan</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Balita: {{ $balita->nama }}</p>
        </div>
        
        <form action="{{ route(Auth::user()->role . '.balita.medis.perkembangan.store', $balita->id) }}" method="POST" class="p-6 space-y-4">
            @csrf
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Evaluasi *</label>
                <input type="date" name="tanggal" required value="{{ date('Y-m-d') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:border-green-500 focus:ring-green-500">
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Motorik Kasar (Kestabilan, Berjalan)</label>
                    <textarea name="motorik_kasar" rows="2" placeholder="Catatan motorik kasar anak..."
                              class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:border-green-500 focus:ring-green-500"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Motorik Halus (Berhitung jari, benda kecil)</label>
                    <textarea name="motorik_halus" rows="2" placeholder="Catatan motorik halus anak..."
                              class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:border-green-500 focus:ring-green-500"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bahasa dan Komunikasi (Kosa kata, bicara)</label>
                    <textarea name="bahasa" rows="2" placeholder="Catatan bahasa..."
                              class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:border-green-500 focus:ring-green-500"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sosial / Kemandirian</label>
                    <textarea name="sosial" rows="2" placeholder="Catatan kemandirian anak..."
                              class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:border-green-500 focus:ring-green-500"></textarea>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route(Auth::user()->role . '.balita.show', $balita->id) }}" 
                   class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 text-gray-700 dark:text-gray-300 rounded-lg">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg">
                    Simpan Evaluasi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
