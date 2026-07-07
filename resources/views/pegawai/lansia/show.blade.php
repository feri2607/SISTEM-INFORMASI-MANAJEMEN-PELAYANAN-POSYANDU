{{-- resources/views/pegawai/lansia/show.blade.php --}}

@extends('layouts.app')

@section('title', 'Detail Lansia - Sistem Informasi Posyandu')
@section('page-title', 'Detail Lansia')
@section('page-subtitle', 'Profil, status verifikasi, dan riwayat kesehatan lansia')

@section('content')
<div class="space-y-6">

    <div class="flex items-center gap-3">
        <a href="{{ route('pegawai.lansia.index') }}" 
           class="inline-flex items-center gap-2 p-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-teal-600 dark:hover:text-teal-400 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        </a>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $lansia->nama }}</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Kolom Kiri: Profil & Verifikasi --}}
        <div class="space-y-6">
            {{-- Card Profil --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-6">
                    <div class="text-center">
                        <img class="w-32 h-32 rounded-full mx-auto object-cover border-4 border-gray-100 dark:border-gray-700" 
                             src="{{ $lansia->foto_url }}" alt="{{ $lansia->nama }}">
                        <h3 class="mt-4 text-lg font-bold text-gray-900 dark:text-white">{{ $lansia->nama }}</h3>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mt-1">{{ $lansia->nik ?? 'NIK tdk diisi' }}</p>
                        
                        <div class="mt-3">
                            @if($lansia->is_verified)
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300">
                                    ✅ Terverifikasi
                                </span>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300">
                                    ⏳ Menunggu Verifikasi
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="mt-6 border-t border-gray-100 dark:border-gray-700 pt-6 space-y-4">
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Umur / Jenis Kelamin</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $lansia->umur ? $lansia->umur . ' tahun' : '-' }} / {{ $lansia->jenis_kelamin_label }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Golongan Darah</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $lansia->golongan_darah ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Kontak Warga</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $lansia->no_hp ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Alamat</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $lansia->alamat ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Riwayat Penyakit</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $lansia->riwayat_penyakit ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card Verifikasi Aksi --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h4 class="font-semibold text-gray-900 dark:text-white">Status Verifikasi</h4>
                </div>
                <div class="p-6 text-center space-y-4">
                    @if($lansia->is_verified)
                        <div class="p-3 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 rounded-lg text-sm">
                            <p class="font-medium mb-1">Data valid dan terverifikasi.</p>
                            <p class="text-xs">Oleh: {{ $lansia->verifiedBy->name ?? 'Pegawai' }} ({{ $lansia->verified_at->format('d M Y H:i') }})</p>
                        </div>
                        <form action="{{ route('pegawai.lansia.reject', $lansia) }}" method="POST" onsubmit="return confirm('Batalkan verifikasi data ini? Warga dapat mengedit kembali datanya.')">
                            @csrf @method('PATCH')
                            <button type="submit" class="w-full justify-center inline-flex items-center px-4 py-2 bg-yellow-100 hover:bg-yellow-200 dark:bg-yellow-900/40 dark:hover:bg-yellow-900/60 text-yellow-800 dark:text-yellow-300 text-sm font-medium rounded-lg transition">
                                Batalkan Verifikasi
                            </button>
                        </form>
                    @else
                        <div class="p-3 bg-yellow-50 dark:bg-yellow-900/20 text-yellow-700 dark:text-yellow-400 rounded-lg text-sm mb-4 text-left">
                            Cek kesesuaian data dengan identitas (KTP/KK) warga.
                        </div>
                        <form action="{{ route('pegawai.lansia.verify', $lansia) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="w-full justify-center inline-flex items-center gap-2 px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white text-sm font-medium rounded-lg transition shadow-sm hover:shadow">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Verifikasi Data
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Riwayat Pemeriksaan & Grafik --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- Riwayat Pemeriksaan --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 flex items-center justify-between border-b border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <span class="text-xl">🩺</span> Riwayat Pemeriksaan
                    </h3>
                    <a href="{{ route('pegawai.lansia.pemeriksaan.create', $lansia) }}" 
                       class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white text-sm font-medium rounded-lg shadow-sm transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Input Pelayanan
                    </a>
                </div>
                
                <div class="overflow-x-auto">
                    @if($lansia->pemeriksaan->count() > 0)
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                            <thead class="bg-gray-100/50 dark:bg-gray-700/50">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-500 dark:text-gray-400">Tanggal</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-500 dark:text-gray-400">Fisik (TB/BB)</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-500 dark:text-gray-400">Tensi/Gula/Kol.</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-500 dark:text-gray-400">IMT</th>
                                    <th class="px-4 py-3 text-right font-semibold text-gray-500 dark:text-gray-400">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($lansia->pemeriksaan as $p)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                                        <td class="px-4 py-3 whitespace-nowrap text-gray-900 dark:text-white font-medium">
                                            {{ $p->tanggal->format('d M Y') }}
                                        </td>
                                        <td class="px-4 py-3 text-gray-700 dark:text-gray-300">
                                            {{ $p->tinggi_badan ?? '-' }}cm / {{ $p->berat_badan ?? '-' }}kg
                                        </td>
                                        <td class="px-4 py-3 text-gray-700 dark:text-gray-300">
                                            {!! $p->tekanan_darah ? $p->tekanan_darah . ' mmHg<br>' : '' !!}
                                            {!! $p->gula_darah ? $p->gula_darah . ' mg/dL<br>' : '' !!}
                                            {!! $p->kolesterol ? $p->kolesterol . ' mg/dL' : '' !!}
                                        </td>
                                        <td class="px-4 py-3">
                                            @if($p->imt)
                                                <span class="inline-flex items-center gap-1 font-semibold text-blue-600 dark:text-blue-400">
                                                    {{ number_format($p->imt, 1) }}
                                                    <span class="text-xs font-normal text-gray-500">({{ $p->status_imt }})</span>
                                                </span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-right">
                                            <div class="flex items-center justify-end space-x-2">
                                                <a href="{{ route('pegawai.lansia.pemeriksaan.edit', $p) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300" title="Edit">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                </a>
                                                <form action="{{ route('pegawai.lansia.pemeriksaan.destroy', $p) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data pemeriksaan ini?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300" title="Hapus">
                                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="py-12 text-center">
                            <div class="mx-auto w-16 h-16 bg-gray-100 dark:bg-gray-700/50 rounded-full flex items-center justify-center mb-3">
                                <span class="text-2xl">📋</span>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400 font-medium">Belum ada riwayat pemeriksaan</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Grafik Kesehatan --}}
            @if(count($chartData['tekanan']['labels']) > 0)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                            <span class="text-xl">📈</span> Grafik Perkembangan
                        </h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 dark:bg-gray-700/30 rounded-xl p-4 border border-gray-100 dark:border-gray-700">
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tekanan Darah (mmHg)</h4>
                            <canvas id="cTekanan" height="150"></canvas>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/30 rounded-xl p-4 border border-gray-100 dark:border-gray-700">
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Gula / Kolesterol (mg/dL)</h4>
                            <canvas id="cMetab" height="150"></canvas>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/30 rounded-xl p-4 border border-gray-100 dark:border-gray-700 md:col-span-2">
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Berat Badan (kg) & IMT</h4>
                            <canvas id="cBmi" height="80"></canvas>
                        </div>
                    </div>
                </div>

                @push('scripts')
                <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
                <script>
                    const isDark = document.documentElement.classList.contains('dark');
                    const tCol = isDark ? '#9ca3af' : '#6b7280', gCol = isDark ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)';
                    const opt = { responsive:true, plugins:{legend:{labels:{color:tCol}}}, scales:{x:{ticks:{color:tCol},grid:{color:gCol}},y:{ticks:{color:tCol},grid:{color:gCol}}} };

                    // Tekanan Darah
                    new Chart(document.getElementById('cTekanan'), {
                        type:'line',
                        data:{ labels:@json($chartData['tekanan']['labels']), datasets:[ {label:'Sistole',data:@json($chartData['tekanan']['sistolik']),borderColor:'#ef4444',tension:.4, fill:false}, {label:'Diastole',data:@json($chartData['tekanan']['diastolik']),borderColor:'#f97316',tension:.4, fill:false} ]},
                        options:opt
                    });

                    // Gula & Kolesterol (Combined for space)
                    new Chart(document.getElementById('cMetab'), {
                        type:'bar',
                        data:{ labels:@json($chartData['gula_darah']['labels']), datasets:[ {label:'Gula',data:@json($chartData['gula_darah']['data']),backgroundColor:'#f59e0b', borderRadius:4}, {label:'Kolesterol',data:@json($chartData['kolesterol']['data']),backgroundColor:'#8b5cf6', borderRadius:4} ]},
                        options:opt
                    });

                    // Berat & IMT (Mixed)
                    new Chart(document.getElementById('cBmi'), {
                        type:'line',
                        data:{ labels:@json($chartData['berat']['labels']), datasets:[ {type:'bar', label:'Berat (kg)',data:@json($chartData['berat']['data']),backgroundColor:'rgba(59,130,246,0.5)', yAxisID:'y'}, {type:'line', label:'IMT',data:@json($chartData['imt']['data']),borderColor:'#10b981',tension:0.4, yAxisID:'y1'} ]},
                        options:{ ...opt, scales:{ x:{ticks:{color:tCol},grid:{color:gCol}}, y:{type:'linear',display:true,position:'left',ticks:{color:tCol},grid:{color:gCol}}, y1:{type:'linear',display:true,position:'right',ticks:{color:tCol},grid:{drawOnChartArea:false}} } }
                    });
                </script>
                @endpush
            @endif
        </div>
    </div>
</div>
@endsection
