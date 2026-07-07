{{-- resources/views/pegawai/kehamilan/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Kehamilan - ' . $kehamilan->nama)
@section('page-title', 'Detail Kehamilan 📋')
@section('page-subtitle', 'Kelola riwayat ANC, grafik kesehatan, dan profil ibu hamil.')

@section('content')
<div class="space-y-6">

    {{-- Actions & Verifikasi Bar --}}
    <div class="flex flex-wrap items-center justify-between gap-4 bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
        <div class="flex items-center gap-3">
            <a href="{{ route('pegawai.kehamilan.index') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-300 rounded-xl text-sm font-medium transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
            <a href="{{ route('pegawai.kehamilan.anc.create', $kehamilan) }}" class="flex items-center gap-2 px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-xl text-sm font-medium transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Pemeriksaan ANC
            </a>
        </div>
        
        <div>
            @if(!$kehamilan->is_verified)
                <form method="POST" action="{{ route('pegawai.kehamilan.verify', $kehamilan) }}" x-data @submit.prevent="Swal.fire({title: 'Verifikasi Profil?', text: 'Warga tidak akan bisa mengubah data lagi setelah diverifikasi.', icon: 'question', showCancelButton: true, confirmButtonColor: '#10b981', confirmButtonText: 'Ya, Verifikasi'}).then(res => { if(res.isConfirmed) $el.submit(); })">
                    @csrf @method('PATCH')
                    <button type="submit" class="flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-bold transition">
                        ✅ Verifikasi Data
                    </button>
                </form>
            @else
                <form method="POST" action="{{ route('pegawai.kehamilan.reject', $kehamilan) }}" x-data @submit.prevent="Swal.fire({title: 'Batalkan Verifikasi?', text: 'Warga akan bisa mengubah data identitas kembali.', icon: 'warning', showCancelButton: true, confirmButtonColor: '#ef4444', confirmButtonText: 'Batalkan'}).then(res => { if(res.isConfirmed) $el.submit(); })">
                    @csrf @method('PATCH')
                    <button type="submit" class="flex items-center gap-2 px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-xl text-sm font-bold transition">
                        ❌ Batalkan Verifikasi
                    </button>
                </form>
            @endif
        </div>
    </div>

    {{-- Profil Header --}}
    <div class="bg-gradient-to-r from-pink-500 to-rose-500 rounded-3xl p-6 md:p-8 text-white flex flex-col md:flex-row items-center gap-6 shadow-sm">
        <img src="{{ $kehamilan->foto_url }}" class="w-28 h-28 object-cover rounded-full ring-4 ring-white/30 shrink-0">
        <div class="flex-1 text-center md:text-left">
            <h2 class="text-3xl font-bold mb-1">{{ $kehamilan->nama }}</h2>
            <p class="text-pink-100 mb-3">{{ $kehamilan->nik }} • {{ $kehamilan->umur }} Tahun</p>
            
            <div class="flex flex-wrap items-center justify-center md:justify-start gap-4">
                <div class="bg-black/20 rounded-xl px-4 py-2 text-sm">
                    Kehamilan Ke- <strong>{{ $kehamilan->kehamilan_ke }}</strong>
                </div>
                <div class="bg-black/20 rounded-xl px-4 py-2 text-sm">
                    Usia Kandungan <strong>{{ $kehamilan->usia_kehamilan_in_minggu ?? '0' }} Mgg</strong>
                </div>
                <div class="bg-black/20 rounded-xl px-4 py-2 text-sm">
                    HPL <strong>{{ $kehamilan->hpl_formatted }}</strong>
                </div>
                <div>
                     <span class="px-3 py-1.5 rounded-full text-xs font-bold bg-white/20">
                         {{ $kehamilan->status_verifikasi_label }}
                     </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabs --}}
    <div x-data="{ tab: 'anc' }" class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        
        <div class="flex border-b border-gray-100 dark:border-gray-700 overflow-x-auto">
            <button @click="tab = 'anc'" :class="{'text-pink-600 border-pink-500 bg-pink-50': tab === 'anc', 'text-gray-500 hover:text-gray-700': tab !== 'anc'}" class="px-6 py-4 font-semibold text-sm border-b-2 border-transparent transition whitespace-nowrap">
                🩺 Riwayat Pemeriksaan ANC
            </button>
            <button @click="tab = 'grafik'" :class="{'text-pink-600 border-pink-500 bg-pink-50': tab === 'grafik', 'text-gray-500 hover:text-gray-700': tab !== 'grafik'}" class="px-6 py-4 font-semibold text-sm border-b-2 border-transparent transition whitespace-nowrap">
                📈 Grafik Pemanatauan
            </button>
            <button @click="tab = 'identitas'" :class="{'text-pink-600 border-pink-500 bg-pink-50': tab === 'identitas', 'text-gray-500 hover:text-gray-700': tab !== 'identitas'}" class="px-6 py-4 font-semibold text-sm border-b-2 border-transparent transition whitespace-nowrap">
                👤 Data & Indentitas
            </button>
        </div>

        <div class="p-6">
            {{-- Tab: ANC --}}
            <div x-show="tab === 'anc'">
                @if($kehamilan->anc->isEmpty())
                    <div class="text-center py-12">
                        <div class="text-5xl mb-4">⚕️</div>
                        <h4 class="text-lg font-bold">Belum Ada Pemeriksaan</h4>
                        <p class="text-gray-500 mb-6">Tambahkan data ANC pertama untuk ibu hamil ini.</p>
                        <a href="{{ route('pegawai.kehamilan.anc.create', $kehamilan) }}" class="inline-block px-6 py-2.5 bg-[#036672] hover:bg-[#036672] text-white rounded-xl font-medium">Buat Pemeriksaan</a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm whitespace-nowrap">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th class="px-4 py-3 border-b">Tanggal / Mgg</th>
                                    <th class="px-4 py-3 border-b">Tensi / BB / Fundus</th>
                                    <th class="px-4 py-3 border-b">Diagnosis & Keluhan</th>
                                    <th class="px-4 py-3 border-b">Pegawai</th>
                                    <th class="px-4 py-3 border-b text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @foreach($kehamilan->anc as $anc)
                                    <tr>
                                        <td class="px-4 py-3">
                                            <div class="font-bold">{{ $anc->tanggal->format('d M Y') }}</div>
                                            <div class="text-pink-600 text-xs">Mgg ke-{{ $anc->minggu_ke }}</div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="font-semibold">{{ $anc->tekanan_darah ?? '-' }}</span> mmHg <br>
                                            <span class="text-xs text-gray-500">{{ $anc->berat_badan ?? '-' }} kg / TFU: {{ $anc->tinggi_fundus ?? '-' }} cm</span>
                                        </td>
                                        <td class="px-4 py-3 max-w-[250px] whitespace-normal">
                                            <div class="font-semibold">{{ $anc->diagnosis ?? 'Tidak ada diagnosis' }}</div>
                                            <div class="text-xs text-gray-500 line-clamp-1 truncate">{{ $anc->keluhan ?? '-' }}</div>
                                            <div class="mt-1 flex gap-1">
                                                @if($anc->status_risiko != 'Normal') <span class="px-1.5 py-0.5 rounded text-[10px] font-bold border {{ $anc->status_risiko_badge }}">{{ $anc->status_risiko }}</span> @endif
                                                @if($anc->pemberian_ttd) <span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-green-100 text-green-700 border">TTD Diberikan</span> @endif
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            {{ $anc->user->name ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('pegawai.kehamilan.anc.edit', $anc) }}" class="p-2 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg" title="Edit">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                                </a>
                                                <form action="{{ route('pegawai.kehamilan.anc.destroy', $anc) }}" method="POST" class="inline" x-data @submit.prevent="Swal.fire({title: 'Hapus Pemeriksaan?', text: 'Data tidak dapat dikembalikan!', icon: 'warning', showCancelButton: true, confirmButtonColor: '#ef4444', confirmButtonText: 'Hapus'}).then(r => { if(r.isConfirmed) $el.submit(); })">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="p-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg" title="Hapus">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            {{-- Tab: Grafik --}}
            <div x-show="tab === 'grafik'" style="display: none;">
                @if($kehamilan->anc->isEmpty())
                    <p class="text-center text-gray-500 py-12">Belum ada data pertumbuhan.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div><canvas id="chartBB"></canvas></div>
                        <div><canvas id="chartFundus"></canvas></div>
                        <div class="md:col-span-2 max-w-4xl mx-auto w-full"><canvas id="chartTensi"></canvas></div>
                    </div>
                @endif
            </div>

            {{-- Tab: Identitas --}}
            <div x-show="tab === 'identitas'" style="display: none;">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                    <div class="space-y-4">
                        <div>
                            <span class="block text-gray-500 text-xs font-semibold uppercase tracking-wider mb-1">HPHT</span>
                            <div class="font-medium bg-gray-50 dark:bg-gray-700/50 p-2.5 rounded-lg">{{ $kehamilan->hpht_formatted }}</div>
                        </div>
                        <div>
                            <span class="block text-gray-500 text-xs font-semibold uppercase tracking-wider mb-1">Riwayat Penyakit</span>
                            <div class="font-medium bg-gray-50 dark:bg-gray-700/50 p-2.5 rounded-lg min-h-16">{{ $kehamilan->riwayat_penyakit ?? 'Tidak ada riwayat' }}</div>
                        </div>
                        <div>
                            <span class="block text-gray-500 text-xs font-semibold uppercase tracking-wider mb-1">Riwayat Alergi</span>
                            <div class="font-medium bg-gray-50 dark:bg-gray-700/50 p-2.5 rounded-lg min-h-16">{{ $kehamilan->riwayat_alergi ?? 'Tidak ada riwayat' }}</div>
                        </div>
                    </div>
                    <div class="space-y-4">
                         <div>
                            <span class="block text-gray-500 text-xs font-semibold uppercase tracking-wider mb-1">Golongan Darah</span>
                            <div class="font-medium bg-gray-50 dark:bg-gray-700/50 p-2.5 rounded-lg">{{ $kehamilan->golongan_darah ?? '-' }}</div>
                        </div>
                         <div>
                            <span class="block text-gray-500 text-xs font-semibold uppercase tracking-wider mb-1">No. HP Warga</span>
                            <div class="font-medium bg-gray-50 dark:bg-gray-700/50 p-2.5 rounded-lg">{{ $kehamilan->no_hp ?? '-' }}</div>
                        </div>
                         <div>
                            <span class="block text-gray-500 text-xs font-semibold uppercase tracking-wider mb-1">Alamat</span>
                            <div class="font-medium bg-gray-50 dark:bg-gray-700/50 p-2.5 rounded-lg min-h-16">{{ $kehamilan->alamat ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($kehamilan->anc->isNotEmpty())
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const data = @json($chartData);
    
    new Chart(document.getElementById('chartBB'), { type: 'line', data: { labels: data.labels, datasets: [{ label: 'Berat Badan Ibu', data: data.berat_badan, borderColor: '#db2777', backgroundColor: 'rgba(219,39,119,0.1)', fill: true, tension: 0.3 }] }});
    new Chart(document.getElementById('chartFundus'), { type: 'line', data: { labels: data.labels, datasets: [{ label: 'Tinggi Fundus Uteri', data: data.tinggi_fundus, borderColor: '#9333ea', backgroundColor: 'rgba(147,51,234,0.1)', fill: true, tension: 0.3 }] }});
    new Chart(document.getElementById('chartTensi'), { type: 'line', data: { labels: data.labels, datasets: [{ label: 'Tekanan Darah (Sistol)', data: data.tekanan_sistol, borderColor: '#059669', backgroundColor: 'rgba(5,150,105,0.1)', fill: true, tension: 0.3 }] }});
});
</script>
@endif
@endsection
