@extends('layouts.app')

@section('title', 'Input Vitamin Balita')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Input Pemberian Vitamin</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Balita: {{ $balita->nama }}</p>
        </div>
        
        <form action="{{ route(Auth::user()->role . '.balita.medis.vitamin.store', $balita->id) }}" method="POST" class="p-6 space-y-4">
            @csrf
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Pemberian *</label>
                <input type="date" name="tanggal" required value="{{ date('Y-m-d') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:border-yellow-500 focus:ring-yellow-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Vitamin *</label>
                <select name="jenis_vitamin" required 
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:border-yellow-500 focus:ring-yellow-500">
                    <option value="">-- Pilih Vitamin --</option>
                    <option value="Vitamin A Biru">Vitamin A Biru (6-11 Bulan)</option>
                    <option value="Vitamin A Merah">Vitamin A Merah (12-59 Bulan)</option>
                    <option value="Obat Cacing">Obat Cacing</option>
                    <option value="Zink">Zink</option>
                    <option value="Besi">Sirup Besi (Fe)</option>
                    <option value="Lainnya">Lainnya...</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Keterangan Khusus</label>
                <textarea name="keterangan" rows="3" 
                          class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:border-yellow-500 focus:ring-yellow-500"></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route(Auth::user()->role . '.balita.show', $balita->id) }}" 
                   class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 text-gray-700 dark:text-gray-300 rounded-lg">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg">
                    Simpan Vitamin
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
