{{-- resources/views/pegawai/kehamilan/anc-create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Pemeriksaan ANC - ' . $kehamilan->nama)
@section('page-title', 'Form Pemeriksaan ANC 🩺')
@section('page-subtitle', 'Input data pemeriksaan untuk Ibu ' . $kehamilan->nama)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        
        <div class="bg-gradient-to-r from-pink-500 to-rose-500 px-6 py-5 flex items-center gap-4">
            <img src="{{ $kehamilan->foto_url }}" class="w-14 h-14 rounded-full object-cover ring-2 ring-white/50 bg-white">
            <div>
                <h3 class="text-white font-bold text-lg">{{ $kehamilan->nama }}</h3>
                <p class="text-pink-100 text-sm">Kehamilan Ke-{{ $kehamilan->kehamilan_ke }} • HPHT: {{ $kehamilan->hpht_formatted }}</p>
            </div>
        </div>

        <form action="{{ route('pegawai.kehamilan.anc.store') }}" method="POST" class="p-6 md:p-8">
            @csrf
            <input type="hidden" name="kehamilan_id" value="{{ $kehamilan->id }}">
            
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Tanggal Pemeriksaan <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required max="{{ date('Y-m-d') }}"
                       class="w-full md:w-1/3 rounded-xl border-gray-300 focus:border-pink-500 focus:ring-pink-500 dark:bg-gray-700 dark:border-gray-600">
                @error('tanggal') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                {{-- Vital Signs --}}
                <div class="md:col-span-3 pb-3 border-b border-gray-100 dark:border-gray-700"><h4 class="font-bold text-gray-800 dark:text-gray-200">Vital Sign & Antropometri</h4></div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tekanan Darah (mmHg)</label>
                    <input type="text" name="tekanan_darah" value="{{ old('tekanan_darah') }}" placeholder="120/80"
                           class="w-full rounded-xl border-gray-300 focus:border-pink-500 focus:ring-pink-500 dark:bg-gray-700 dark:border-gray-600">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Berat Badan (kg)</label>
                    <input type="number" step="0.1" name="berat_badan" value="{{ old('berat_badan') }}" placeholder="60.5"
                           class="w-full rounded-xl border-gray-300 focus:border-pink-500 focus:ring-pink-500 dark:bg-gray-700 dark:border-gray-600">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">LILA (cm)</label>
                    <input type="number" step="0.1" name="lila" value="{{ old('lila') }}" placeholder="25"
                           class="w-full rounded-xl border-gray-300 focus:border-pink-500 focus:ring-pink-500 dark:bg-gray-700 dark:border-gray-600">
                </div>
                
                {{-- Janin --}}
                <div class="md:col-span-3 pb-3 border-b border-gray-100 dark:border-gray-700 mt-2"><h4 class="font-bold text-gray-800 dark:text-gray-200">Pemeriksaan Kehamilan</h4></div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tinggi Fundus Uteri (cm)</label>
                    <input type="number" step="0.1" name="tinggi_fundus" value="{{ old('tinggi_fundus') }}" placeholder="20"
                           class="w-full rounded-xl border-gray-300 focus:border-pink-500 focus:ring-pink-500 dark:bg-gray-700 dark:border-gray-600">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Detak Jantung Janin (bpm)</label>
                    <input type="number" name="detak_jantung" value="{{ old('detak_jantung') }}" placeholder="140"
                           class="w-full rounded-xl border-gray-300 focus:border-pink-500 focus:ring-pink-500 dark:bg-gray-700 dark:border-gray-600">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Posisi Janin</label>
                    <select name="posisi_janin" class="w-full rounded-xl border-gray-300 focus:border-pink-500 focus:ring-pink-500 dark:bg-gray-700 dark:border-gray-600">
                        <option value="">Pilih</option>
                        <option value="Normal">Kepala di bawah</option>
                        <option value="Sungsang">Sungsang</option>
                        <option value="Melintang">Melintang</option>
                    </select>
                </div>
                
                {{-- Medis --}}
                <div class="md:col-span-3 pb-3 border-b border-gray-100 dark:border-gray-700 mt-2"><h4 class="font-bold text-gray-800 dark:text-gray-200">Analisa & Tindakan</h4></div>
                
                <div class="md:col-span-3 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Keluhan Pasien</label>
                        <textarea name="keluhan" rows="2" class="w-full rounded-xl border-gray-300 focus:border-pink-500 focus:ring-pink-500 dark:bg-gray-700 dark:border-gray-600"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Diagnosis Kebidanan</label>
                        <textarea name="diagnosis" rows="2" class="w-full rounded-xl border-gray-300 focus:border-pink-500 focus:ring-pink-500 dark:bg-gray-700 dark:border-gray-600"></textarea>
                    </div>
                </div>
                
                <div class="md:col-span-3 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <label class="flex items-center gap-3 p-4 border rounded-xl cursor-pointer hover:bg-gray-50 border-gray-200 dark:border-gray-600">
                        <input type="checkbox" name="pemberian_ttd" value="1" class="w-5 h-5 text-pink-600 rounded">
                        <div>
                            <div class="font-bold">Berikan Tablet Tambah Darah</div>
                            <div class="text-xs text-gray-500">Target otomatis bertambah +30 jika dicentang.</div>
                        </div>
                    </label>
                    
                    <label class="flex items-center gap-3 p-4 border rounded-xl cursor-pointer hover:bg-red-50 border-red-200 bg-red-50/50">
                        <input type="checkbox" name="rujukan" value="1" class="w-5 h-5 text-red-600 rounded">
                        <div>
                            <div class="font-bold text-red-700">Rujuk ke Faskes (Puskesmas/RS)</div>
                            <div class="text-xs text-red-500">Centang jika ibu hamil terindikasi risiko bahaya.</div>
                        </div>
                    </label>
                </div>
                
                <div class="md:col-span-3">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catatan Tambahan untuk Pasien</label>
                    <textarea name="catatan" rows="3" class="w-full rounded-xl border-gray-300 focus:border-pink-500 focus:ring-pink-500 dark:bg-gray-700 dark:border-gray-600"></textarea>
                </div>
            </div>

            <div class="border-t border-gray-200 dark:border-gray-700 pt-5 flex items-center justify-end gap-3">
                <a href="{{ route('pegawai.kehamilan.show', $kehamilan) }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-medium transition">Batal</a>
                <button type="submit" class="px-8 py-2.5 bg-[#036672] hover:bg-[#036672] text-white rounded-xl font-bold shadow-sm transition">Simpan Pemeriksaan</button>
            </div>
        </form>
    </div>
</div>
@endsection
