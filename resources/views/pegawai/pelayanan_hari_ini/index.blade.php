{{-- resources/views/pegawai/pelayanan_hari_ini/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Daftar Pelayanan Hari Ini - Sistem Informasi Posyandu')

@section('page-title', 'Pelayanan Hari Ini')
@section('page-subtitle', 'Daftar peserta yang hadir dan siap untuk diberikan pelayanan.')

@section('content')
<div class="space-y-6">

    {{-- Info Card --}}
    <div class="bg-blue-50 dark:bg-blue-900/30 border-l-4 border-blue-500 p-4 rounded-r shadow-sm">
        <div class="flex items-center">
            <svg class="h-6 w-6 text-blue-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-blue-700 dark:text-blue-300">
                Pilih peserta di bawah ini untuk memulai pelayanan kesehatan (Mis: Pemeriksaan, Imunisasi, ANC). <br>Peserta yang tampil di sini adalah mereka yang sudah tercatat <strong>Hadir</strong> pada hari yang dipilih.
            </p>
        </div>
    </div>

    {{-- Filter Date & Category --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
        <form method="GET" action="{{ route('pegawai.pelayanan-hari-ini.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <input type="date" name="tanggal" value="{{ $filters['tanggal'] ?? request('tanggal', date('Y-m-d')) }}"
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-blue-500">
            </div>

            <div>
                <select name="kategori" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-blue-500">
                    <option value="">Semua Kategori</option>
                    @foreach(['Balita', 'Kehamilan', 'Menyusui', 'WUS/PUS', 'Remaja', 'Lansia'] as $kat)
                        <option value="{{ $kat }}" {{ ($filters['kategori'] ?? request('kategori')) == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2">
                <input type="text" name="search" placeholder="Cari Nama..." value="{{ $filters['search'] ?? request('search') }}"
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-blue-500">
                <button type="submit" class="px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg shadow-sm transition">
                    Filter
                </button>
            </div>
        </form>
    </div>

    {{-- List of Peserta Menunggu Layanan --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
        @forelse($pesertaHadir as $item)
            @php
                $peserta = $item->peserta;
                // Category coloring mapping for visual differentiation
                $catColors = [
                    'Balita' => 'bg-pink-100 text-pink-800 dark:bg-pink-900/50 dark:text-pink-300',
                    'Kehamilan' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-300',
                    'Lansia' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/50 dark:text-orange-300',
                    'Remaja' => 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300',
                ];
                $color = $catColors[$item->kategori] ?? 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300';
            @endphp
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border hover:border-blue-300 dark:border-gray-700 dark:hover:border-blue-500 transition-all flex flex-col pt-5 px-5 h-full relative overflow-hidden group">
                
                {{-- Kategori Badge --}}
                <div class="absolute top-0 right-0 px-3 py-1 text-xs font-bold rounded-bl-xl shadow-sm {{ $color }}">
                    {{ $item->kategori ?? 'Umum' }}
                </div>

                <div class="flex items-center gap-4 mb-4 mt-2">
                    <img src="{{ $peserta ? $peserta->foto_url : 'https://ui-avatars.com/api/?name=NN' }}" alt="" class="h-16 w-16 rounded-full object-cover shadow border border-gray-200 dark:border-gray-600">
                    <div>
                        <h4 class="font-bold text-gray-900 dark:text-white text-lg leading-tight">{{ $peserta ? $peserta->nama : 'Tidak diketahui' }}</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5"><span class="font-medium text-gray-600 dark:text-gray-300">NIK:</span> {{ $peserta ? $peserta->nik : '-' }}</p>
                    </div>
                </div>

                <div class="space-y-1 mb-5 flex-grow">

                    <div class="flex justify-between items-center text-sm text-gray-600 dark:text-gray-300">
                        <div class="flex items-center">
                           <svg class="h-4 w-4 mr-2 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" /></svg>
                           Menunggu...
                        </div>
                    </div>
                </div>

                <div class="mt-auto border-t dark:border-gray-700 py-3 mt-4">
                    <a href="{{ $item->layani_url }}" class="w-full flex justify-center items-center px-4 py-2 bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 hover:bg-[#036672] hover:text-white dark:hover:bg-[#036672] dark:hover:text-white rounded-lg font-semibold transition group-hover:shadow-md">
                        Mulai Pemeriksaan
                        <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white dark:bg-gray-800 p-8 rounded-xl shadow-md text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Tidak ada data peserta hadir!</h3>
                <p class="text-gray-500">Belum ada peserta terdaftar yang hadir pada kegiatan ini atau semua peserta sudah dilayani.</p>
                <a href="{{ route('pegawai.kehadiran.index') }}" class="mt-4 inline-block px-5 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg font-medium">Buka Registrasi Kehadiran</a>
            </div>
        @endforelse
    </div>

</div>
@endsection
