{{-- resources/views/pelayanan/edit.blade.php --}}

@extends('layouts.app')

@section('title', 'Edit Pelayanan - Sistem Informasi Posyandu')

@section('page-title', 'Edit Hasil Pelayanan')
@section('page-subtitle', 'Perbarui data pemeriksaan balita')

@section('content')
    @php $routePrefix = Auth::user()->role . '.pelayanan.'; @endphp
    <div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <form method="POST" action="{{ route($routePrefix . 'update', $pelayanan) }}" 
                  id="pelayananForm"
                  x-data="pelayananForm()"
                  @submit.prevent="submitForm">
                @csrf
                @method('PUT')

                <!-- Pilih Kegiatan -->
                <div class="mb-6">
                    <label for="kegiatan_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Kegiatan <span class="text-red-500">*</span>
                    </label>
                    <select name="kegiatan_id" id="kegiatan_id" 
                            class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white">
                        @foreach($kegiatanList as $kegiatan)
                            <option value="{{ $kegiatan->id }}" {{ old('kegiatan_id', $pelayanan->kegiatan_id) == $kegiatan->id ? 'selected' : '' }}>
                                {{ $kegiatan->nama_kegiatan }} - {{ $kegiatan->tanggal_formatted }}
                            </option>
                        @endforeach
                    </select>
                    @error('kegiatan_id')
                        <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pilih Balita -->
                <div class="mb-6">
                    <label for="balita_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Balita <span class="text-red-500">*</span>
                    </label>
                    <select name="balita_id" id="balita_id" 
                            class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white">
                        <option value="">Pilih Balita...</option>
                        @foreach($balitaList ?? [] as $balita)
                            <option value="{{ $balita->id }}" {{ old('balita_id', $pelayanan->balita_id) == $balita->id ? 'selected' : '' }}>
                                {{ $balita->nama }} ({{ $balita->warga->nama }})
                            </option>
                        @endforeach
                    </select>
                    @error('balita_id')
                        <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Data Pemeriksaan -->
                <div class="border-b border-gray-200 dark:border-gray-700 pb-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Data Pemeriksaan</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Berat Badan -->
                        <div>
                            <label for="berat_badan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Berat Badan (kg) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="berat_badan" id="berat_badan" 
                                   step="0.01"
                                   x-model="form.berat_badan"
                                   @input="calculateStatus()"
                                   class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white"
                                   placeholder="0.00"
                                   value="{{ old('berat_badan', $pelayanan->berat_badan) }}">
                            @error('berat_badan')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tinggi Badan -->
                        <div>
                            <label for="tinggi_badan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Tinggi Badan (cm) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="tinggi_badan" id="tinggi_badan" 
                                   step="0.1"
                                   x-model="form.tinggi_badan"
                                   @input="calculateStatus()"
                                   class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white"
                                   placeholder="0.0"
                                   value="{{ old('tinggi_badan', $pelayanan->tinggi_badan) }}">
                            @error('tinggi_badan')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Lingkar Kepala -->
                        <div>
                            <label for="lingkar_kepala" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Lingkar Kepala (cm) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="lingkar_kepala" id="lingkar_kepala" 
                                   step="0.1"
                                   class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white"
                                   placeholder="0.0"
                                   value="{{ old('lingkar_kepala', $pelayanan->lingkar_kepala) }}">
                            @error('lingkar_kepala')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Lingkar Lengan -->
                        <div>
                            <label for="lingkar_lengan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Lingkar Lengan Atas (cm)
                            </label>
                            <input type="number" name="lingkar_lengan" id="lingkar_lengan" 
                                   step="0.1"
                                   class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white"
                                   placeholder="0.0"
                                   value="{{ old('lingkar_lengan', $pelayanan->lingkar_lengan) }}">
                            @error('lingkar_lengan')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Suhu Tubuh -->
                        <div>
                            <label for="suhu_tubuh" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Suhu Tubuh (°C)
                            </label>
                            <input type="number" name="suhu_tubuh" id="suhu_tubuh" 
                                   step="0.1"
                                   class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white"
                                   placeholder="36.5"
                                   value="{{ old('suhu_tubuh', $pelayanan->suhu_tubuh) }}">
                            @error('suhu_tubuh')
                                <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status Gizi -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Status Gizi
                            </label>
                            <div id="statusGiziDisplay" class="p-3 bg-gray-100 dark:bg-gray-700 rounded-lg text-center">
                                <span class="px-3 py-1 rounded-full text-sm font-medium {{ $pelayanan->status_gizi_badge }}">
                                    {{ $pelayanan->status_gizi_label }}
                                </span>
                            </div>
                            <input type="hidden" name="status_gizi" x-model="statusGizi" value="{{ $pelayanan->status_gizi }}">
                        </div>
                    </div>
                </div>

                <!-- Imunisasi -->
                <div class="border-b border-gray-200 dark:border-gray-700 pb-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Imunisasi</h3>
                    
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @php
                            $imunisasiList = $pelayanan->imunisasi_list ?? [];
                        @endphp
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="imunisasi[]" value="BCG" 
                                   {{ in_array('BCG', $imunisasiList) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="text-sm text-gray-700 dark:text-gray-300">BCG</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="imunisasi[]" value="Polio" 
                                   {{ in_array('Polio', $imunisasiList) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Polio</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="imunisasi[]" value="DPT" 
                                   {{ in_array('DPT', $imunisasiList) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="text-sm text-gray-700 dark:text-gray-300">DPT</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="imunisasi[]" value="Campak" 
                                   {{ in_array('Campak', $imunisasiList) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Campak</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="imunisasi[]" value="Hepatitis" 
                                   {{ in_array('Hepatitis', $imunisasiList) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Hepatitis</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="imunisasi[]" value="Lainnya" 
                                   {{ in_array('Lainnya', $imunisasiList) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Lainnya</span>
                        </label>
                    </div>
                </div>

                <!-- Vitamin -->
                <div class="border-b border-gray-200 dark:border-gray-700 pb-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Vitamin</h3>
                    
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @php
                            $vitaminList = $pelayanan->vitamin_list ?? [];
                        @endphp
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="vitamin[]" value="Vitamin A" 
                                   {{ in_array('Vitamin A', $vitaminList) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Vitamin A</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="vitamin[]" value="Obat Cacing" 
                                   {{ in_array('Obat Cacing', $vitaminList) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Obat Cacing</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="vitamin[]" value="PMT" 
                                   {{ in_array('PMT', $vitaminList) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="text-sm text-gray-700 dark:text-gray-300">PMT</span>
                        </label>
                    </div>
                </div>

                <!-- Catatan & Rekomendasi -->
                <div class="border-b border-gray-200 dark:border-gray-700 pb-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Catatan & Rekomendasi</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="catatan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Catatan Kesehatan
                            </label>
                            <textarea name="catatan" id="catatan" rows="3" 
                                      class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white"
                                      placeholder="Catatan hasil pemeriksaan...">{{ old('catatan', $pelayanan->catatan) }}</textarea>
                        </div>

                        <div>
                            <label for="rekomendasi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Rekomendasi
                            </label>
                            <textarea name="rekomendasi" id="rekomendasi" rows="3" 
                                      class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white"
                                      placeholder="Rekomendasi untuk balita...">{{ old('rekomendasi', $pelayanan->rekomendasi) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route($routePrefix . 'index') }}" 
                           class="px-6 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition duration-150">
                            Kembali
                        </a>
                        <a href="{{ route($routePrefix . 'show', $pelayanan) }}" 
                           class="px-6 py-2.5 text-sm font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/30 hover:bg-blue-100 dark:hover:bg-blue-900/50 rounded-lg transition duration-150">
                            Lihat Detail
                        </a>
                    </div>
                    <button type="submit" 
                            id="submitButton"
                            x-show="!loading"
                            class="px-8 py-2.5 bg-[#036672] hover:bg-[#036672] text-white font-medium rounded-lg transition duration-150 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        Perbarui
                    </button>
                    <button type="button" 
                            x-show="loading"
                            disabled
                            class="px-8 py-2.5 bg-blue-400 cursor-not-allowed text-white font-medium rounded-lg flex items-center">
                        <svg class="animate-spin h-5 w-5 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Menyimpan...
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function pelayananForm() {
        return {
            loading: false,
            form: {
                berat_badan: '{{ old('berat_badan', $pelayanan->berat_badan) }}',
                tinggi_badan: '{{ old('tinggi_badan', $pelayanan->tinggi_badan) }}'
            },
            statusGizi: '{{ $pelayanan->status_gizi }}',
            
            calculateStatus() {
                const bb = parseFloat(this.form.berat_badan);
                const tb = parseFloat(this.form.tinggi_badan);
                
                if (!bb || !tb) {
                    document.getElementById('statusGiziDisplay').innerHTML = '<span class="text-gray-500 dark:text-gray-400">-</span>';
                    return;
                }
                
                const bmi = bb / ((tb / 100) * (tb / 100));
                let status = '';
                const labels = {
                    'normal': 'Gizi Baik',
                    'kurang': 'Gizi Kurang',
                    'buruk': 'Gizi Buruk',
                    'lebih': 'Gizi Lebih'
                };
                const colors = {
                    'normal': 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                    'kurang': 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400',
                    'buruk': 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                    'lebih': 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400'
                };
                
                if (bmi < 13) {
                    status = 'buruk';
                } else if (bmi < 14) {
                    status = 'kurang';
                } else if (bmi > 18) {
                    status = 'lebih';
                } else {
                    status = 'normal';
                }
                
                this.statusGizi = status;
                document.getElementById('statusGiziDisplay').innerHTML = `
                    <span class="px-3 py-1 rounded-full text-sm font-medium ${colors[status]}">
                        ${labels[status]}
                    </span>
                `;
            },
            
            submitForm() {
                this.loading = true;
                this.$refs.form.submit();
            }
        }
    }
</script>
@endpush
@endsection