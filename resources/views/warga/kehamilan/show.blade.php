{{-- resources/views/warga/kehamilan/show.blade.php --}}
@extends('layouts.public')

@section('hide-footer', true)

@section('title', 'Detail Riwayat Kehamilan')
@section('page-title', 'Detail Kehamilan 📋')
@section('page-subtitle', 'Riwayat medis dan pemeriksaan ANC.')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    {{-- Alert --}}
    <div class="bg-blue-50 dark:bg-blue-900/30 p-4 rounded-xl border border-blue-200 dark:border-blue-800 flex items-start gap-4 mt-2">
        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <div>
            <h4 class="font-semibold text-blue-800 dark:text-blue-300">Data Rekam Medis (Read-Only)</h4>
            <p class="text-sm text-blue-700 dark:text-blue-400 mt-1">Seluruh data riwayat pemeriksaan (ANC) di halaman ini hanya dapat diinput atau diubah oleh petugas medis/pegawai Posyandu.</p>
        </div>
    </div>

    {{-- Tabs --}}
    <div x-data="{ tab: 'riwayat' }" class="bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 rounded-3xl overflow-hidden">
        
        <div class="flex border-b border-gray-200 dark:border-gray-700 overflow-x-auto">
            <button @click="tab = 'riwayat'" :class="{'text-pink-600 border-pink-600 bg-pink-50 dark:bg-pink-900/10': tab === 'riwayat', 'text-gray-500 border-transparent hover:text-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700': tab !== 'riwayat'}" class="px-6 py-4 flex-1 font-semibold text-sm border-b-2 transition">
                🩺 Riwayat Pemeriksaan ANC
            </button>
            <button @click="tab = 'grafik'" :class="{'text-pink-600 border-pink-600 bg-pink-50 dark:bg-pink-900/10': tab === 'grafik', 'text-gray-500 border-transparent hover:text-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700': tab !== 'grafik'}" class="px-6 py-4 flex-1 font-semibold text-sm border-b-2 transition">
                📈 Grafik Pertumbuhan
            </button>
            <button @click="tab = 'identitas'" :class="{'text-pink-600 border-pink-600 bg-pink-50 dark:bg-pink-900/10': tab === 'identitas', 'text-gray-500 border-transparent hover:text-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700': tab !== 'identitas'}" class="px-6 py-4 flex-1 font-semibold text-sm border-b-2 transition">
                👤 Data Identitas Ibu
            </button>
        </div>

        <div class="p-6">
            {{-- Tab: Riwayat ANC --}}
            <div x-show="tab === 'riwayat'" x-transition>
                @if($kehamilan->anc->isEmpty())
                    <div class="text-center py-12">
                        <div class="text-4xl mb-3">🩺</div>
                        <h4 class="font-bold text-gray-900 dark:text-white">Belum Ada Pemeriksaan</h4>
                        <p class="text-sm text-gray-500 mt-1">Data kunjungan posyandu kehamilan (ANC) akan muncul di sini.</p>
                    </div>
                @else
                    <div class="space-y-4 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-gray-200 dark:before:via-gray-700 before:to-transparent">
                        @foreach($kehamilan->anc as $anc)
                            <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                                {{-- Line icon --}}
                                <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white dark:border-gray-800 bg-[#036672] text-white shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                
                                {{-- Card --}}
                                <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition">
                                    <div class="flex items-center justify-between mb-3 border-b border-gray-100 dark:border-gray-700 pb-3">
                                        <div>
                                            <span class="text-xs font-bold text-pink-600 bg-pink-100/50 dark:bg-pink-900/30 px-2 py-1 rounded">Minggu ke-{{ $anc->minggu_ke }}</span>
                                            <div class="text-sm font-semibold text-gray-900 dark:text-white mt-2">{{ $anc->tanggal->format('d F Y') }}</div>
                                        </div>
                                        <span class="text-xs font-semibold px-2 py-1 border rounded-lg {{ $anc->status_risiko_badge }}">{{ $anc->status_risiko }}</span>
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-3 mb-4 text-sm text-gray-600 dark:text-gray-300">
                                        <div><span class="block text-xs text-gray-400">Tekanan Darah</span> <strong class="text-gray-900 dark:text-white">{{ $anc->tekanan_darah ?? '-' }}</strong> mmHg</div>
                                        <div><span class="block text-xs text-gray-400">Berat Badan</span> <strong class="text-gray-900 dark:text-white">{{ $anc->berat_badan ?? '-' }}</strong> kg</div>
                                        <div><span class="block text-xs text-gray-400">Tinggi Fundus</span> {{ $anc->tinggi_fundus ?? '-' }} cm</div>
                                        <div><span class="block text-xs text-gray-400">Detak Jantung</span> {{ $anc->detak_jantung ?? '-' }} bpm</div>
                                    </div>
                                    
                                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3 text-sm">
                                        <div class="mb-2"><span class="font-semibold block mb-1">Catatan/Keluhan:</span> {{ $anc->keluhan ?? 'Tidak ada keluhan' }}</div>
                                        <div class="text-xs text-gray-500 mt-2 flex justify-between items-end">
                                            <span>Oleh: {{ $anc->user->name ?? '-' }}</span>
                                            @if($anc->pemberian_ttd)<span class="text-green-600 font-semibold">+ TTD</span>@endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Tab: Grafik --}}
            <div x-show="tab === 'grafik'" x-transition style="display: none;">
                @if($kehamilan->anc->isEmpty())
                     <div class="text-center py-12 text-gray-500">Belum ada data pertumbuhan untuk ditampilkan.</div>
                @else
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="border rounded-2xl p-4">
                            <h4 class="font-bold text-center mb-4">Grafik Berat Badan Ibu (kg)</h4>
                            <canvas id="chartBB"></canvas>
                        </div>
                        <div class="border rounded-2xl p-4">
                            <h4 class="font-bold text-center mb-4">Tinggi Fundus Uteri (cm)</h4>
                            <canvas id="chartFundus"></canvas>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Tab: Identitas --}}
            <div x-show="tab === 'identitas'" x-transition style="display: none;">
                <div class="max-w-2xl mx-auto">
                    <div class="flex items-center gap-6 mb-8 border-b pb-6">
                         <img src="{{ $kehamilan->foto_url }}" class="w-24 h-24 rounded-full object-cover shadow border">
                         <div>
                             <h4 class="text-2xl font-bold">{{ $kehamilan->nama }}</h4>
                             <p class="text-gray-500">{{ $kehamilan->nik }}</p>
                         </div>
                    </div>
                    
                    <dl class="space-y-4 text-sm divide-y divide-gray-100 dark:divide-gray-700">
                        <div class="py-2 grid grid-cols-3 gap-4">
                            <dt class="font-medium text-gray-500">TTL / Umur</dt>
                            <dd class="col-span-2 font-semibold">{{ $kehamilan->tanggal_lahir?->format('d M Y') }} ({{ $kehamilan->umur }} thn)</dd>
                        </div>
                        <div class="py-2 grid grid-cols-3 gap-4">
                            <dt class="font-medium text-gray-500">Golongan Darah</dt>
                            <dd class="col-span-2 font-semibold">{{ $kehamilan->golongan_darah ?? '-' }}</dd>
                        </div>
                        <div class="py-2 grid grid-cols-3 gap-4">
                            <dt class="font-medium text-gray-500">No HP</dt>
                            <dd class="col-span-2 font-semibold">{{ $kehamilan->no_hp ?? '-' }}</dd>
                        </div>
                        <div class="py-2 grid grid-cols-3 gap-4">
                            <dt class="font-medium text-gray-500">Riwayat Penyakit</dt>
                            <dd class="col-span-2 font-semibold">{{ $kehamilan->riwayat_penyakit ?? 'Tidak ada' }}</dd>
                        </div>
                        <div class="py-2 grid grid-cols-3 gap-4">
                            <dt class="font-medium text-gray-500">Riwayat Alergi</dt>
                            <dd class="col-span-2 font-semibold">{{ $kehamilan->riwayat_alergi ?? 'Tidak ada' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

@if($kehamilan->anc->isNotEmpty())
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chartData = @json($chartData);
    
    // Chart BB
    new Chart(document.getElementById('chartBB'), {
        type: 'line',
        data: {
            labels: chartData.labels,
            datasets: [{
                label: 'Berat Badan (kg)',
                data: chartData.berat_badan,
                borderColor: '#db2777', // pink-600
                backgroundColor: 'rgba(219, 39, 119, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.3
            }]
        }
    });

    // Chart Fundus
    new Chart(document.getElementById('chartFundus'), {
        type: 'line',
        data: {
            labels: chartData.labels,
            datasets: [{
                label: 'Tinggi Fundus (cm)',
                data: chartData.tinggi_fundus,
                borderColor: '#7c3aed', // violet-600
                backgroundColor: 'rgba(124, 58, 237, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.3
            }]
        }
    });
});
</script>
@endif
@endsection

