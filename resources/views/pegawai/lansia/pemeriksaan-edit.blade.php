{{-- resources/views/pegawai/lansia/pemeriksaan-edit.blade.php --}}

@extends('layouts.app')

@section('title', 'Edit Pemeriksaan Lansia - Sistem Informasi Posyandu')
@section('page-title', '✏️ Edit Pemeriksaan Lansia')
@section('page-subtitle', 'Perbarui data hasil pemeriksaan kesehatan lansia.')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div class="flex items-center gap-3">
        <a href="{{ route('pegawai.lansia.show', $pemeriksaan->lansia) }}" 
           class="inline-flex items-center gap-2 p-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-teal-600 dark:hover:text-teal-400 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        </a>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Edit Pemeriksaan: {{ $pemeriksaan->lansia->nama }}</h2>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6">
            <form action="{{ route('pegawai.lansia.pemeriksaan.update', $pemeriksaan) }}" method="POST" x-data="pemeriksaanLansiaEditForm()">
                @csrf
                @method('PUT')
                <input type="hidden" name="lansia_id" value="{{ $pemeriksaan->lansia_id }}">

                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 rounded-lg">
                        <ul class="text-sm text-red-700 dark:text-red-400 space-y-1">
                            @foreach($errors->all() as $err) <li>• {{ $err }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    {{-- Tanggal --}}
                    <div>
                        <label for="tanggal" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Tanggal Pemeriksaan <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal" id="tanggal" 
                               value="{{ old('tanggal', $pemeriksaan->tanggal->format('Y-m-d')) }}" max="{{ now()->format('Y-m-d') }}"
                               class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-teal-500 focus:border-teal-500 text-gray-900 dark:text-white" required>
                        @error('tanggal') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Keluhan --}}
                    <div>
                        <label for="keluhan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Keluhan Utama</label>
                        <input type="text" name="keluhan" id="keluhan" value="{{ old('keluhan', $pemeriksaan->keluhan) }}"
                               class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-teal-500 focus:border-teal-500 text-gray-900 dark:text-white" 
                               placeholder="Contoh: Pusing, Nyeri sendi">
                    </div>
                </div>

                <hr class="border-gray-200 dark:border-gray-700 mb-6">

                <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-4">Pengukuran Antropometri</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    {{-- Tinggi Badan --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Tinggi Badan <span class="text-red-500">*</span></label>
                        <div class="flex rounded-md shadow-sm">
                            <input type="number" name="tinggi_badan" step="0.1" min="0" max="250" x-model.number="tb" @input="hitungIMT"
                                   class="flex-1 rounded-l-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-teal-500 focus:border-teal-500 text-gray-900 dark:text-white" required>
                            <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-600 text-gray-500 dark:text-gray-300 sm:text-sm">cm</span>
                        </div>
                    </div>
                    
                    {{-- Berat Badan --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Berat Badan <span class="text-red-500">*</span></label>
                        <div class="flex rounded-md shadow-sm">
                            <input type="number" name="berat_badan" step="0.1" min="0" max="300" x-model.number="bb" @input="hitungIMT"
                                   class="flex-1 rounded-l-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-teal-500 focus:border-teal-500 text-gray-900 dark:text-white" required>
                            <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-600 text-gray-500 dark:text-gray-300 sm:text-sm">kg</span>
                        </div>
                    </div>

                    {{-- Lingkar Perut --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Lingkar Perut</label>
                        <div class="flex rounded-md shadow-sm">
                            <input type="number" name="lingkar_perut" step="0.1" min="0" value="{{ old('lingkar_perut', $pemeriksaan->lingkar_perut) }}"
                                   class="flex-1 rounded-l-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-teal-500 focus:border-teal-500 text-gray-900 dark:text-white">
                            <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-600 text-gray-500 dark:text-gray-300 sm:text-sm">cm</span>
                        </div>
                    </div>
                </div>

                {{-- Preview IMT --}}
                <div x-show="imt !== null" class="mb-6 p-4 rounded-xl bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-blue-700 dark:text-blue-300 font-medium">Indeks Massa Tubuh (IMT)</p>
                        <p class="text-2xl font-bold text-blue-900 dark:text-blue-100" x-text="imt + ' (' + statusImt + ')'"></p>
                        <input type="hidden" name="imt" :value="imt">
                        <input type="hidden" name="status_imt" :value="statusImt">
                    </div>
                </div>

                <hr class="border-gray-200 dark:border-gray-700 mb-6">

                <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-4">Pemeriksaan Medis (Opsional)</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    {{-- Tekanan Darah --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Tekanan Darah</label>
                        <div class="flex rounded-md shadow-sm">
                            <input type="text" name="tekanan_darah" value="{{ old('tekanan_darah', $pemeriksaan->tekanan_darah) }}" placeholder="120/80"
                                   class="flex-1 rounded-l-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-teal-500 focus:border-teal-500 text-gray-900 dark:text-white">
                            <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-600 text-gray-500 dark:text-gray-300 sm:text-sm">mmHg</span>
                        </div>
                    </div>
                    
                    {{-- Gula Darah --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Gula Darah</label>
                        <div class="flex rounded-md shadow-sm">
                            <input type="number" name="gula_darah" step="0.1" min="0" value="{{ old('gula_darah', $pemeriksaan->gula_darah) }}"
                                   class="flex-1 rounded-l-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-teal-500 focus:border-teal-500 text-gray-900 dark:text-white">
                            <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-600 text-gray-500 dark:text-gray-300 sm:text-sm">mg/dL</span>
                        </div>
                    </div>

                    {{-- Kolesterol --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Kolesterol</label>
                        <div class="flex rounded-md shadow-sm">
                            <input type="number" name="kolesterol" step="0.1" min="0" value="{{ old('kolesterol', $pemeriksaan->kolesterol) }}"
                                   class="flex-1 rounded-l-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-teal-500 focus:border-teal-500 text-gray-900 dark:text-white">
                            <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-600 text-gray-500 dark:text-gray-300 sm:text-sm">mg/dL</span>
                        </div>
                    </div>

                    {{-- Asam Urat --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Asam Urat</label>
                        <div class="flex rounded-md shadow-sm">
                            <input type="number" name="asam_urat" step="0.1" min="0" value="{{ old('asam_urat', $pemeriksaan->asam_urat) }}"
                                   class="flex-1 rounded-l-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-teal-500 focus:border-teal-500 text-gray-900 dark:text-white">
                            <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-600 text-gray-500 dark:text-gray-300 sm:text-sm">mg/dL</span>
                        </div>
                    </div>
                </div>

                {{-- Catatan & Tindakan --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="catatan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Catatan Pemeriksaan</label>
                        <textarea name="catatan" id="catatan" rows="3" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-teal-500 focus:border-teal-500 text-gray-900 dark:text-white">{{ old('catatan', $pemeriksaan->catatan) }}</textarea>
                    </div>
                    <div>
                        <label for="tindakan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Tindakan / Edukasi</label>
                        <textarea name="tindakan" id="tindakan" rows="3" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-teal-500 focus:border-teal-500 text-gray-900 dark:text-white">{{ old('tindakan', $pemeriksaan->tindakan) }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('pegawai.lansia.show', $pemeriksaan->lansia) }}" class="px-5 py-2.5 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">Batal</a>
                    <button type="submit" class="px-5 py-2.5 bg-[#036672] text-white rounded-lg hover:bg-[#036672] transition font-medium">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function pemeriksaanLansiaEditForm() {
        return {
            tb: {{ old('tinggi_badan', $pemeriksaan->tinggi_badan) ?? 'null' }},
            bb: {{ old('berat_badan', $pemeriksaan->berat_badan) ?? 'null' }},
            imt: {{ old('imt', $pemeriksaan->imt) ?? 'null' }},
            statusImt: '{{ old('status_imt', $pemeriksaan->status_imt) ?? '' }}',
            
            init() {
                if (this.tb && this.bb) this.hitungIMT();
            },
            
            hitungIMT() {
                if (this.tb > 0 && this.bb > 0) {
                    const tbMeter = this.tb / 100;
                    this.imt = (this.bb / (tbMeter * tbMeter)).toFixed(2);
                    
                    if (this.imt < 18.5) {
                        this.statusImt = 'Kurus';
                    } else if (this.imt >= 18.5 && this.imt <= 24.9) {
                        this.statusImt = 'Normal';
                    } else if (this.imt >= 25 && this.imt <= 29.9) {
                        this.statusImt = 'Gemuk';
                    } else {
                        this.statusImt = 'Obesitas';
                    }
                } else {
                    this.imt = null;
                    this.statusImt = '';
                }
            }
        }
    }
</script>
@endpush
@endsection
