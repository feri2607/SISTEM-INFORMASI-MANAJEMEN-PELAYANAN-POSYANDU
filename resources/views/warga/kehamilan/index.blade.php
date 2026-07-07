{{-- resources/views/warga/kehamilan/index.blade.php --}}
@extends('layouts.public')

@section('hide-footer', true)

@section('title', 'Posyandu Kehamilan')
@section('page-title', 'Kehamilan 🤰')
@section('page-subtitle', 'Pantau kehamilan, jadwal ANC, dan riwayat kesehatan.')

@section('content')
<div class="space-y-6">

    @if(!$kehamilan)
        {{-- Empty State --}}
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm text-center py-16 px-6 border border-gray-100 dark:border-gray-700">
            <div class="w-24 h-24 bg-pink-100 dark:bg-pink-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Belum Terdapat Data Kehamilan</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">Silakan tambahkan data profil ibu hamil untuk mulai memantau perkembangan kehamilan dan melihat info gizi.</p>
            <a href="{{ route('warga.kehamilan.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-[#036672] hover:bg-[#036672] text-white rounded-xl font-medium shadow-sm transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Data Kehamilan
            </a>
        </div>
    @else
        {{-- Ringkasan Kehamilan Card --}}
        <div class="bg-gradient-to-br from-[#E8EFFF] to-[#C3D4FF] rounded-3xl shadow-md overflow-hidden p-1 relative">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/40 rounded-full blur-3xl -translate-y-12 translate-x-12"></div>
            
            <div class="bg-white/30 backdrop-blur-md rounded-[22px] p-6 text-slate-800 h-full relative z-10 border border-white/50 flex flex-col md:flex-row items-center gap-6">
                <img src="{{ $kehamilan->foto_url }}" alt="Foto" class="w-24 h-24 rounded-full object-cover ring-4 ring-white/60 shrink-0">
                
                <div class="flex-1 text-center md:text-left">
                    <div class="flex flex-wrap justify-center md:justify-start items-center gap-3 mb-1">
                        <h2 class="text-2xl font-bold">{{ $kehamilan->nama }}</h2>
                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-white/50 backdrop-blur text-blue-800">{{ $kehamilan->status_verifikasi_label }}</span>
                    </div>
                    <p class="text-slate-600 text-sm mb-4">Kehamilan Ke-{{ $kehamilan->kehamilan_ke }} • NIK: {{ $kehamilan->nik }}</p>
                    
                    <div class="flex flex-wrap justify-center md:justify-start gap-4 text-sm font-medium">
                        <div class="bg-white/50 rounded-xl px-4 py-2 border border-white/30">
                            <span class="block text-slate-500 text-xs uppercase tracking-wide">Usia Kehamilan</span>
                            <span class="text-slate-800">{{ $kehamilan->usia_kehamilan_in_minggu ?? '0' }} Minggu</span>
                        </div>
                        <div class="bg-white/50 rounded-xl px-4 py-2 border border-white/30">
                            <span class="block text-slate-500 text-xs uppercase tracking-wide">HPL (Perkiraan Lahir)</span>
                            <span class="text-slate-800">{{ $kehamilan->hpl_formatted }}</span>
                        </div>
                    </div>
                </div>

                <div class="shrink-0 flex md:flex-col gap-2">
                    <a href="{{ route('warga.kehamilan.show', $kehamilan) }}" class="px-5 py-2.5 bg-[#036672] text-white hover:bg-[#024f5a] rounded-xl text-sm font-semibold transition text-center shadow-sm">
                        Riwayat Medis
                    </a>
                    @if(!$kehamilan->is_verified)
                        <a href="{{ route('warga.kehamilan.edit', $kehamilan) }}" class="px-5 py-2.5 bg-white hover:bg-slate-50 text-[#036672] border border-[#036672]/20 rounded-xl text-sm font-semibold transition text-center">
                            Edit Profil
                        </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- Metrics Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border borde    r-gray-100 dark:border-gray-700">
                <div class="flex items-center gap-3 mb-2">
                    <div class="p-2 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Pemeriksaan ANC Terakhir</span>
                </div>
                <p class="text-xl font-bold text-gray-900 dark:text-white">
                    {{ $kehamilan->anc_terakhir ? $kehamilan->anc_terakhir->tanggal->format('d M Y') : 'Belum Pernah' }}
                </p>
                <p class="text-sm text-gray-500 mt-1">Total: {{ $anc_list->count() }} kali periksa</p>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="flex items-center gap-3 mb-2">
                    <div class="p-2 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    </div>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Konsumsi TTD (Masa Kehamilan)</span>
                </div>
                <div class="flex items-end justify-between">
                    <p class="text-xl font-bold text-gray-900 dark:text-white">
                        {{ $ttd ? $ttd->jumlah_diminum : 0 }} <span class="text-sm font-normal text-gray-500">/ {{ $ttd ? $ttd->jumlah_target : 90 }} Butir</span>
                    </p>
                    <span class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-green-100 text-green-700">{{ $ttd ? $ttd->persentase : 0 }}%</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5 mt-3">
                    <div class="bg-green-500 h-1.5 rounded-full" style="width: {{ $ttd ? $ttd->persentase : 0 }}%"></div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                 <div class="flex items-center gap-3 mb-2">
                    <div class="p-2 bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Status Risiko</span>
                </div>
                <div class="mt-1">
                    <span class="px-3 py-1.5 rounded-xl text-sm font-bold {{ $kehamilan->status_risiko_badge }}">
                        {{ $kehamilan->status_risiko_label }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Artikel Edukasi --}}
        <div class="mt-8">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Artikel Edukasi Kehamilan</h3>
                <a href="{{ route('public.articles') }}" class="text-sm font-medium text-pink-600 hover:text-pink-700">Lihat Semua →</a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                @php
                    $articles = [
                        ['title' => 'Gizi Seimbang Ibu Hamil', 'icon' => '🥗'],
                        ['title' => 'Tanda Bahaya Kehamilan', 'icon' => '⚠️'],
                        ['title' => 'Pentingnya Tablet Tambah Darah', 'icon' => '💊'],
                        ['title' => 'Persiapan Persalinan', 'icon' => '🏥'],
                    ];
                @endphp
                @foreach($articles as $art)
                    <a href="#" class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 hover:border-pink-300 dark:hover:border-pink-600 hover:shadow-md transition group">
                        <div class="text-3xl mb-3">{{ $art['icon'] }}</div>
                        <h4 class="font-bold text-gray-900 dark:text-white group-hover:text-pink-600 leading-tight">{{ $art['title'] }}</h4>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection

