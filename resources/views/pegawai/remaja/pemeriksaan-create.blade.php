{{-- resources/views/pegawai/remaja/pemeriksaan-create.blade.php --}}
@extends('layouts.app')

@section('title', 'Form Pemeriksaan - ' . $remaja->nama)
@section('page-title', '📋 Input Pemeriksaan')
@section('page-subtitle', $remaja->nama)

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow overflow-hidden">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-5">
            <div class="flex items-center gap-4">
                <img src="{{ $remaja->foto_url }}" alt="{{ $remaja->nama }}"
                     class="w-14 h-14 rounded-full object-cover ring-3 ring-white/30">
                <div>
                    <h3 class="text-lg font-bold text-white">{{ $remaja->nama }}</h3>
                    <p class="text-green-200 text-sm">{{ $remaja->umur }} tahun • {{ $remaja->jenis_kelamin_label }} • NIK: {{ $remaja->nik }}</p>
                </div>
            </div>
        </div>

        {{-- Form --}}
        <form method="POST" action="{{ route('pegawai.remaja.pemeriksaan.store') }}"
              x-data="pemeriksaanForm()" @submit="handleSubmit">
            @csrf
            <input type="hidden" name="remaja_id" value="{{ $remaja->id }}">

            <div class="p-6 space-y-5">

                {{-- Errors --}}
                @if($errors->any())
                    <div class="p-4 bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 rounded-lg">
                        <ul class="text-sm text-red-700 dark:text-red-400 space-y-1">
                            @foreach($errors->all() as $err)
                                <li>• {{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Tanggal --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Tanggal Pemeriksaan <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}"
                           required max="{{ date('Y-m-d') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>

                {{-- BB & TB --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Berat Badan (kg)
                        </label>
                        <input type="number" name="berat_badan" step="0.1" min="1" max="300"
                               value="{{ old('berat_badan') }}"
                               x-model="bb"
                               @input="calcBMI"
                               placeholder="Contoh: 55.5"
                               class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Tinggi Badan (cm)
                        </label>
                        <input type="number" name="tinggi_badan" step="0.1" min="50" max="250"
                               value="{{ old('tinggi_badan') }}"
                               x-model="tb"
                               @input="calcBMI"
                               placeholder="Contoh: 160"
                               class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>
                </div>

                {{-- BMI Preview --}}
                <div x-show="bmi" x-transition
                     class="p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-xl">
                    <p class="text-sm text-green-700 dark:text-green-300">
                        🧮 <strong>BMI Otomatis:</strong>
                        <span x-text="bmi" class="text-lg font-bold ml-1"></span>
                        — Status:
                        <span x-text="statusGizi" class="font-semibold"></span>
                    </p>
                </div>

                {{-- Tekanan Darah --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Tekanan Darah (contoh: 120/80)
                    </label>
                    <input type="text" name="tekanan_darah" value="{{ old('tekanan_darah') }}"
                           placeholder="120/80"
                           class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>

                {{-- Status HB --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Status HB (Hemoglobin)
                    </label>
                    <select name="status_hb"
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-green-500">
                        <option value="">-- Pilih Status HB --</option>
                        <option value="Normal" {{ old('status_hb') === 'Normal' ? 'selected' : '' }}>Normal (≥12 g/dL)</option>
                        <option value="Ringan" {{ old('status_hb') === 'Ringan' ? 'selected' : '' }}>Anemia Ringan (10–11.9 g/dL)</option>
                        <option value="Sedang" {{ old('status_hb') === 'Sedang' ? 'selected' : '' }}>Anemia Sedang (7–9.9 g/dL)</option>
                        <option value="Berat" {{ old('status_hb') === 'Berat' ? 'selected' : '' }}>Anemia Berat (&lt;7 g/dL)</option>
                    </select>
                </div>

                {{-- Catatan --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Catatan
                    </label>
                    <textarea name="catatan" rows="3" placeholder="Catatan tambahan dari pegawai..."
                              class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent resize-none">{{ old('catatan') }}</textarea>
                </div>

                {{-- Pegawai --}}
                <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl flex items-center gap-3">
                    <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Pegawai yang Memeriksa</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ Auth::user()->name }}</p>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <a href="{{ route('pegawai.remaja.show', $remaja) }}"
                   class="px-5 py-2.5 bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-300 rounded-xl text-sm font-medium transition">
                    Batal
                </a>
                <button type="submit" :disabled="loading"
                        class="px-6 py-2.5 bg-[#036672] hover:bg-[#036672] disabled:opacity-50 text-white rounded-xl text-sm font-semibold transition flex items-center gap-2">
                    <svg x-show="loading" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                    </svg>
                    <span x-text="loading ? 'Menyimpan...' : '💾 Simpan Pemeriksaan'"></span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function pemeriksaanForm() {
    return {
        bb: '',
        tb: '',
        bmi: null,
        statusGizi: '',
        loading: false,
        calcBMI() {
            if (this.bb && this.tb) {
                const tbM = parseFloat(this.tb) / 100;
                const bmiVal = parseFloat(this.bb) / (tbM * tbM);
                this.bmi = isNaN(bmiVal) ? null : bmiVal.toFixed(2);
                this.statusGizi = this.getStatusGizi(parseFloat(this.bmi));
            } else {
                this.bmi = null;
                this.statusGizi = '';
            }
        },
        getStatusGizi(bmi) {
            if (bmi < 17) return 'Kurus';
            if (bmi < 18.5) return 'Berisiko Kurus';
            if (bmi < 25) return 'Normal';
            if (bmi < 27) return 'Berisiko Gemuk';
            return 'Gemuk';
        },
        handleSubmit(e) {
            this.loading = true;
            e.target.submit();
        }
    };
}
</script>
@endpush
