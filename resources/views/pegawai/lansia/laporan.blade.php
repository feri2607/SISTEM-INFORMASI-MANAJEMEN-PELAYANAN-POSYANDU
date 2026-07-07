{{-- resources/views/pegawai/lansia/laporan.blade.php --}}

@extends('layouts.app')

@section('title', 'Laporan Posyandu Lansia - Sistem Informasi Posyandu')
@section('page-title', 'Laporan Posyandu Lansia')
@section('page-subtitle', 'Rekap data pelayanan dan rekam medis lansia')

@section('content')
<div class="space-y-6">

    {{-- Cards Summary Laporan --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Lansia Terdaftar</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalLansia }}</p>
            </div>
            <div class="p-3 bg-blue-50 dark:bg-blue-900/50 rounded-lg text-blue-600 dark:text-blue-400">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pemeriksaan Bulan Ini</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalPemeriksaanBulan }}</p>
            </div>
            <div class="p-3 bg-green-50 dark:bg-green-900/50 rounded-lg text-green-600 dark:text-green-400">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>

    {{-- Filter Data --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <span class="text-xl">📊</span> Filter Laporan
            </h3>
            <button onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 print:hidden transition">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                Cetak Laporan
            </button>
        </div>
        <div class="p-6 print:hidden">
            <form action="{{ route('pegawai.lansia.laporan') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bulan</label>
                    <select name="bulan" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                        <option value="">Semua Bulan</option>
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tahun</label>
                    <select name="tahun" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                        <option value="">Semua Tahun</option>
                        @foreach(range(date('Y'), date('Y') - 5) as $y)
                            <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Dari Tanggal</label>
                    <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}"
                           class="block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sampai Tanggal</label>
                    <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}"
                           class="block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                </div>
                <div class="md:col-span-4 flex justify-end gap-2 mt-2">
                    @if(request()->anyFilled(['bulan', 'tahun', 'tanggal_dari', 'tanggal_sampai']))
                        <a href="{{ route('pegawai.lansia.laporan') }}" class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 focus:outline-none">
                            Reset
                        </a>
                    @endif
                    <button type="submit" class="inline-flex justify-center items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-[#036672] hover:bg-[#036672] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                        Buat Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Laporan Table --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden print-container">
        
        <div class="hidden print:block p-8 text-center border-b-2 border-gray-800 mb-6">
            <h2 class="text-2xl font-bold uppercase">Laporan Pelayanan Posyandu Lansia</h2>
            <p class="text-lg mt-2">
                @if(request('bulan') && request('tahun'))
                    Periode: {{ DateTime::createFromFormat('!m', request('bulan'))->format('F') }} {{ request('tahun') }}
                @elseif(request('tanggal_dari') && request('tanggal_sampai'))
                    Periode: {{ \Carbon\Carbon::parse(request('tanggal_dari'))->format('d M Y') }} - {{ \Carbon\Carbon::parse(request('tanggal_sampai'))->format('d M Y') }}
                @else
                    Seluruh Data
                @endif
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold text-gray-500 dark:text-gray-400 uppercase">Tgl Periksa</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-500 dark:text-gray-400 uppercase">Nama Lansia</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-500 dark:text-gray-400 uppercase">Umur / L/P</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-500 dark:text-gray-400 uppercase">TB / BB / IMT</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-500 dark:text-gray-400 uppercase">Tensi/Gula/Kol.</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-500 dark:text-gray-400 uppercase">Keluhan</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-500 dark:text-gray-400 uppercase print:hidden">Pegawai</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                    @forelse($pemeriksaan as $p)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-white">{{ $p->tanggal->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-gray-900 dark:text-white font-medium">{{ $p->lansia->nama }}</td>
                            <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $p->lansia->umur ?? '-' }} th / {{ $p->lansia->jenis_kelamin }}</td>
                            <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                {{ $p->tinggi_badan ?? '-' }} cm<br>
                                {{ $p->berat_badan ?? '-' }} kg<br>
                                <span class="text-xs font-semibold {{ $p->imt ? 'text-teal-600 dark:text-teal-400' : '' }}">{{ $p->imt ? number_format($p->imt, 1) . ' ('.$p->status_imt.')' : '-' }}</span>
                            </td>
                            <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                T: {{ $p->tekanan_darah ?? '-' }}<br>
                                G: {{ $p->gula_darah ?? '-' }}<br>
                                K: {{ $p->kolesterol ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-gray-700 dark:text-gray-300 max-w-[200px] truncate" title="{{ $p->keluhan }}">{{ $p->keluhan ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700 dark:text-gray-300 print:hidden">{{ $p->user->name }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                Tidak ada data pemeriksaan pada periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pemeriksaan->hasPages() && !request()->has('print'))
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 print:hidden">
                {{ $pemeriksaan->links() }}
            </div>
        @endif
        
        <div class="hidden print:block mt-12 w-full">
            <div class="w-1/3 ml-auto text-center border-t border-gray-400 pt-10 mt-10">
                <p>Mengetahui,</p>
                <p class="font-bold mt-16">{{ Auth::user()->name }}</p>
                <p>Petugas Posyandu</p>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        body * { visibility: hidden; }
        .print-container, .print-container * { visibility: visible; }
        .print-container { position: absolute; left: 0; top: 0; width: 100%; border: none !important; box-shadow: none !important; }
        ::-webkit-scrollbar { display: none; }
    }
</style>
@endsection
