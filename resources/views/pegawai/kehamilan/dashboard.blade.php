{{-- resources/views/pegawai/kehamilan/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Posyandu Kehamilan')
@section('page-title', 'Dashboard Posyandu Kehamilan 🤰')
@section('page-subtitle', 'Pantau pelayanan Antenatal Care dan tumbuh kembang janin.')

@section('content')
<div class="space-y-6">

    {{-- Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-gradient-to-br from-pink-500 to-rose-600 rounded-3xl p-5 text-white shadow relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 text-white/20 group-hover:scale-110 transition-transform"><svg class="w-28 h-28" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg></div>
            <div class="relative">
                <p class="text-pink-100 font-medium mb-1">Total Ibu Hamil Aktif</p>
                <h3 class="text-4xl font-bold">{{ $stats['total_ibu_hamil'] }}</h3>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-3xl p-5 border border-gray-100 dark:border-gray-700 shadow-sm relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 text-gray-100 dark:text-gray-700 group-hover:scale-110 transition-transform"><svg class="w-28 h-28" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
            <div class="relative">
                <p class="text-gray-500 font-medium mb-1">Pemeriksaan Hari Ini</p>
                <div class="flex items-center gap-3">
                    <h3 class="text-4xl font-bold text-gray-900 dark:text-white">{{ $stats['anc_hari_ini'] }}</h3>
                    <span class="text-xs font-semibold px-2 py-1 bg-green-100 text-green-700 rounded-lg">ANC</span>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-3xl p-5 border border-gray-100 dark:border-gray-700 shadow-sm relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 text-gray-100 dark:text-gray-700 group-hover:scale-110 transition-transform"><svg class="w-28 h-28" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg></div>
            <div class="relative">
                <p class="text-gray-500 font-medium mb-1">Kehamilan Risiko Tinggi</p>
                <div class="flex items-center gap-3">
                    <h3 class="text-4xl font-bold text-gray-900 dark:text-white">{{ $stats['risiko_tinggi'] }}</h3>
                    @if($stats['risiko_tinggi'] > 0)
                        <span class="text-xs font-semibold px-2 py-1 bg-red-100 text-red-700 rounded-lg animate-pulse">Perlu Perhatian</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-3xl p-5 border border-gray-100 dark:border-gray-700 shadow-sm relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 text-gray-100 dark:text-gray-700 group-hover:scale-110 transition-transform"><svg class="w-28 h-28" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg></div>
            <div class="relative">
                <p class="text-gray-500 font-medium mb-1">Menunggu Verifikasi</p>
                <div class="flex items-center gap-3">
                    <h3 class="text-4xl font-bold text-gray-900 dark:text-white">{{ $stats['pending_verifikasi'] }}</h3>
                    @if($stats['pending_verifikasi'] > 0)
                        <span class="text-xs font-semibold px-2 py-1 bg-yellow-100 text-yellow-700 rounded-lg">Warga Baru</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Activity Table --}}
    <div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 rounded-2xl overflow-hidden">
        <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <span class="text-pink-600 border border-pink-200 bg-pink-50 p-1.5 rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></span>
                Pemeriksaan ANC Terbaru
            </h3>
            <a href="{{ route('pegawai.kehamilan.index') }}" class="text-pink-600 hover:text-pink-700 text-sm font-medium transition">
                Lihat Semua Data →
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-gray-50/50 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Ibu Hamil</th>
                        <th class="px-6 py-4 font-semibold">Tanggal</th>
                        <th class="px-6 py-4 font-semibold">Usia Kandungan</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($recentAnc as $anc)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $anc->kehamilan->foto_url }}" class="w-10 h-10 rounded-full object-cover shadow-sm bg-gray-100">
                                    <div>
                                        <div class="font-bold text-gray-900 dark:text-white">{{ $anc->kehamilan->nama }}</div>
                                        <div class="text-xs text-gray-500">{{ $anc->kehamilan->nik }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                {{ $anc->tanggal->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-pink-50 text-pink-700 dark:bg-pink-900/30 dark:text-pink-300 px-2 py-1 rounded text-xs font-semibold border border-pink-100 dark:border-pink-800">
                                    Mgg ke-{{ $anc->minggu_ke }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-semibold rounded-lg border {{ $anc->status_risiko_badge }}">
                                    {{ $anc->status_risiko }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('pegawai.kehamilan.show', $anc->kehamilan_id) }}" 
                                   class="inline-flex py-1.5 px-3 rounded-lg text-xs font-medium bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 transition">
                                    Cek Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                Belum ada riwayat pemeriksaan ANC.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
