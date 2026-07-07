{{-- resources/views/pegawai/remaja/pemeriksaan-edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Pemeriksaan - ' . $pemeriksaan->remaja->nama)
@section('page-title', '✏️ Edit Pemeriksaan')
@section('page-subtitle', $pemeriksaan->remaja->nama . ' — ' . $pemeriksaan->tanggal->format('d M Y'))

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow overflow-hidden">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-5">
            <div class="flex items-center gap-4">
                <img src="{{ $pemeriksaan->remaja->foto_url }}" alt="{{ $pemeriksaan->remaja->nama }}"
                     class="w-14 h-14 rounded-full object-cover ring-3 ring-white/30">
                <div>
                    <h3 class="text-lg font-bold text-white">{{ $pemeriksaan->remaja->nama }}</h3>
                    <p class="text-blue-200 text-sm">Edit data pemeriksaan tanggal {{ $pemeriksaan->tanggal->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        {{-- Form --}}
        <form method="POST" action="{{ route('pegawai.remaja.pemeriksaan.update', $pemeriksaan) }}"
              x-data="pemeriksaanForm({{ $pemeriksaan->berat_badan }}, {{ $pemeriksaan->tinggi_badan }})">
            @csrf @method('PUT')
            <input type="hidden" name="remaja_id" value="{{ $pemeriksaan->remaja_id }}">

            <div class="p-6 space-y-5">
                @if($errors->any())
                    <div class="p-4 bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 rounded-lg">
                        <ul class="text-sm text-red-700 dark:text-red-400 space-y-1">
                            @foreach($errors->all() as $err)
                                <li>• {{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Tanggal Pemeriksaan <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', $pemeriksaan->tanggal->format('Y-m-d')) }}"
                           required max="{{ date('Y-m-d') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Berat Badan (kg)</label>
                        <input type="number" name="berat_badan" step="0.1" min="1" max="300"
                               value="{{ old('berat_badan', $pemeriksaan->berat_badan) }}"
                               x-model="bb" @input="calcBMI" placeholder="Contoh: 55.5"
                               class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Tinggi Badan (cm)</label>
                        <input type="number" name="tinggi_badan" step="0.1" min="50" max="250"
                               value="{{ old('tinggi_badan', $pemeriksaan->tinggi_badan) }}"
                               x-model="tb" @input="calcBMI" placeholder="Contoh: 160"
                               class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>

                <div x-show="bmi" x-transition class="p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-xl">
                    <p class="text-sm text-blue-700 dark:text-blue-300">
                        🧮 <strong>BMI Otomatis:</strong>
                        <span x-text="bmi" class="text-lg font-bold ml-1"></span>
                        — Status: <span x-text="statusGizi" class="font-semibold"></span>
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Tekanan Darah</label>
                    <input type="text" name="tekanan_darah" value="{{ old('tekanan_darah', $pemeriksaan->tekanan_darah) }}"
                           placeholder="120/80"
                           class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Status HB</label>
                    <select name="status_hb"
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih --</option>
                        @foreach(['Normal','Ringan','Sedang','Berat'] as $s)
                            <option value="{{ $s }}" {{ old('status_hb', $pemeriksaan->status_hb) === $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Catatan</label>
                    <textarea name="catatan" rows="3"
                              class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none">{{ old('catatan', $pemeriksaan->catatan) }}</textarea>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <a href="{{ route('pegawai.remaja.show', $pemeriksaan->remaja) }}"
                   class="px-5 py-2.5 bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-300 rounded-xl text-sm font-medium transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-[#036672] hover:bg-[#036672] text-white rounded-xl text-sm font-semibold transition">
                    💾 Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function pemeriksaanForm(bb = '', tb = '') {
    return {
        bb: bb || '',
        tb: tb || '',
        bmi: null,
        statusGizi: '',
        init() { this.calcBMI(); },
        calcBMI() {
            if (this.bb && this.tb) {
                const tbM = parseFloat(this.tb) / 100;
                const bmiVal = parseFloat(this.bb) / (tbM * tbM);
                this.bmi = isNaN(bmiVal) ? null : bmiVal.toFixed(2);
                this.statusGizi = this.getStatusGizi(parseFloat(this.bmi));
            } else {
                this.bmi = null;
            }
        },
        getStatusGizi(bmi) {
            if (bmi < 17) return 'Kurus';
            if (bmi < 18.5) return 'Berisiko Kurus';
            if (bmi < 25) return 'Normal';
            if (bmi < 27) return 'Berisiko Gemuk';
            return 'Gemuk';
        }
    };
}
</script>
@endpush
