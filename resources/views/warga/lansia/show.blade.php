{{-- resources/views/warga/lansia/show.blade.php --}}

@extends('layouts.public')

@section('hide-footer', true)
@section('title', 'Detail Lansia - Sistem Informasi Posyandu')
@section('page-title', '👴 Detail Lansia')
@section('page-subtitle', 'Profil dan riwayat kesehatan lengkap lansia.')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Back Button --}}
    <a href="{{ route('warga.lansia.index') }}"
       class="inline-flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 hover:text-teal-600 dark:hover:text-teal-400 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali ke Posyandu Lansia
    </a>

    {{-- Profile Card --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden border border-gray-100 dark:border-gray-700">
        <div class="p-6 flex flex-col md:flex-row gap-6">
            <div class="flex-shrink-0">
                <img src="{{ $lansia->foto_url }}" alt="{{ $lansia->nama }}"
                     class="w-32 h-32 rounded-2xl object-cover shadow-md border-2 border-teal-200 dark:border-teal-700">
                <div class="mt-3 text-center">
                    @if($lansia->is_verified)
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400">✅ Terverifikasi</span>
                    @else
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400">⏳ Menunggu</span>
                    @endif
                </div>
            </div>
            <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-4">
                @php
                    $info = [
                        ['label' => 'Nama Lengkap',    'value' => $lansia->nama],
                        ['label' => 'NIK',             'value' => $lansia->nik ?? '-'],
                        ['label' => 'Tanggal Lahir',   'value' => $lansia->tanggal_lahir?->format('d M Y') ?? '-'],
                        ['label' => 'Umur',            'value' => $lansia->umur ? $lansia->umur . ' tahun' : '-'],
                        ['label' => 'Jenis Kelamin',   'value' => $lansia->jenis_kelamin_label],
                        ['label' => 'Golongan Darah',  'value' => $lansia->golongan_darah ?? '-'],
                        ['label' => 'Alamat',          'value' => $lansia->alamat ?? '-'],
                        ['label' => 'No. Telepon',     'value' => $lansia->no_hp ?? '-'],
                        ['label' => 'Riwayat Penyakit','value' => $lansia->riwayat_penyakit ?? '-'],
                    ];
                @endphp
                @foreach($info as $item)
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-0.5">{{ $item['label'] }}</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $item['value'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Riwayat Pemeriksaan --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden border border-gray-100 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                📋 Riwayat Pemeriksaan <span class="text-xs font-normal text-gray-400">(Read Only)</span>
            </h3>
        </div>
        @if($lansia->pemeriksaan->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700/50">
                        <tr>
                            @foreach(['Tanggal','Tekanan Darah','Gula Darah','Kolesterol','BB','TB','IMT','Pegawai','Aksi'] as $h)
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase whitespace-nowrap">{{ $h }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($lansia->pemeriksaan as $p)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                                <td class="px-4 py-3 font-medium text-gray-900 dark:text-white whitespace-nowrap">{{ $p->tanggal->format('d M Y') }}</td>
                                <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $p->tekanan_darah ?? '-' }}</td>
                                <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $p->gula_darah ? $p->gula_darah . ' mg/dL' : '-' }}</td>
                                <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $p->kolesterol ? $p->kolesterol . ' mg/dL' : '-' }}</td>
                                <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $p->berat_badan ? $p->berat_badan . ' kg' : '-' }}</td>
                                <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $p->tinggi_badan ? $p->tinggi_badan . ' cm' : '-' }}</td>
                                <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $p->imt ? number_format($p->imt, 1) : '-' }}</td>
                                <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $p->user->name ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('warga.lansia.pemeriksaan.show', $p) }}"
                                       class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-teal-700 dark:text-teal-400 bg-teal-50 dark:bg-teal-900/30 hover:bg-teal-100 dark:hover:bg-teal-900/50 rounded-lg transition">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="py-10 text-center text-gray-400 dark:text-gray-500">
                <p class="text-sm">Belum ada riwayat pemeriksaan.</p>
            </div>
        @endif
    </div>

    {{-- Grafik Kesehatan --}}
    @if(count($chartData['tekanan']['labels']) > 0)
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden border border-gray-100 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">📈 Grafik Kesehatan</h3>
        </div>
        <div class="p-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4"><h4 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Tekanan Darah (mmHg)</h4><canvas id="cTekanan" height="160"></canvas></div>
            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4"><h4 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Gula Darah (mg/dL)</h4><canvas id="cGula" height="160"></canvas></div>
            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4"><h4 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Kolesterol (mg/dL)</h4><canvas id="cKolesterol" height="160"></canvas></div>
            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4"><h4 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Berat Badan (kg)</h4><canvas id="cBerat" height="160"></canvas></div>
            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 lg:col-span-2"><h4 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">IMT</h4><canvas id="cImt" height="80"></canvas></div>
        </div>
    </div>
    @endif

</div>

@if(count($chartData['tekanan']['labels']) > 0)
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const tc='#6b7280', gc='rgba(0,0,0,0.07)';
const opt={ responsive:true, plugins:{legend:{labels:{color:tc}}}, scales:{x:{ticks:{color:tc},grid:{color:gc}},y:{ticks:{color:tc},grid:{color:gc}}}};
new Chart(document.getElementById('cTekanan'),{type:'line',data:{labels:@json($chartData['tekanan']['labels']),datasets:[{label:'Sistolik',data:@json($chartData['tekanan']['sistolik']),borderColor:'#ef4444',tension:.4,fill:false},{label:'Diastolik',data:@json($chartData['tekanan']['diastolik']),borderColor:'#f97316',tension:.4,fill:false}]},options:opt});
new Chart(document.getElementById('cGula'),{type:'line',data:{labels:@json($chartData['gula_darah']['labels']),datasets:[{label:'Gula Darah',data:@json($chartData['gula_darah']['data']),borderColor:'#f59e0b',backgroundColor:'rgba(245,158,11,.1)',tension:.4,fill:true}]},options:opt});
new Chart(document.getElementById('cKolesterol'),{type:'line',data:{labels:@json($chartData['kolesterol']['labels']),datasets:[{label:'Kolesterol',data:@json($chartData['kolesterol']['data']),borderColor:'#8b5cf6',backgroundColor:'rgba(139,92,246,.1)',tension:.4,fill:true}]},options:opt});
new Chart(document.getElementById('cBerat'),{type:'bar',data:{labels:@json($chartData['berat']['labels']),datasets:[{label:'Berat (kg)',data:@json($chartData['berat']['data']),backgroundColor:'rgba(59,130,246,.7)',borderRadius:6}]},options:opt});
new Chart(document.getElementById('cImt'),{type:'line',data:{labels:@json($chartData['imt']['labels']),datasets:[{label:'IMT',data:@json($chartData['imt']['data']),borderColor:'#10b981',backgroundColor:'rgba(16,185,129,.1)',tension:.4,fill:true,pointRadius:5}]},options:opt});
</script>
@endpush
@endif
@endsection
