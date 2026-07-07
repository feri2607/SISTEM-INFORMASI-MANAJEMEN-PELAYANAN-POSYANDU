{{-- resources/views/warga/reproduksi/index.blade.php --}}

@extends('layouts.public')

@section('title', 'Kesehatan Reproduksi - Sistem Informasi Posyandu')
@section('hide-footer', true)

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 animate-fade-in-up">
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">🩺 Kesehatan Reproduksi</h1>
        <p class="mt-2 text-lg text-gray-600 dark:text-gray-400">Pantau kesehatan reproduksi, keluarga berencana, dan riwayat pelayanan Posyandu Anda secara berkala.</p>
    </div>

    <div class="space-y-6">
        {{-- Stats Cards --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/40 dark:to-blue-800/20 rounded-2xl shadow-sm border border-blue-100 dark:border-blue-800/50 p-5 transition-transform hover:scale-[1.02]">
                <p class="text-sm font-medium text-blue-600 dark:text-blue-400">Status KB</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['status_kb'] }}</p>
            </div>
            <div class="bg-gradient-to-br from-teal-50 to-teal-100 dark:from-teal-900/40 dark:to-teal-800/20 rounded-2xl shadow-sm border border-teal-100 dark:border-teal-800/50 p-5 transition-transform hover:scale-[1.02]">
                <p class="text-sm font-medium text-teal-600 dark:text-teal-400">Jenis Kontrasepsi</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white mt-1 truncate" title="{{ $stats['jenis_kontrasepsi'] }}">{{ $stats['jenis_kontrasepsi'] }}</p>
            </div>
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/40 dark:to-purple-800/20 rounded-2xl shadow-sm border border-purple-100 dark:border-purple-800/50 p-5 transition-transform hover:scale-[1.02]">
                <p class="text-sm font-medium text-purple-600 dark:text-purple-400">Jadwal Kontrol</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['jadwal_kontrol'] }}</p>
            </div>
            <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 dark:from-indigo-900/40 dark:to-indigo-800/20 rounded-2xl shadow-sm border border-indigo-100 dark:border-indigo-800/50 p-5 transition-transform hover:scale-[1.02]">
                <p class="text-sm font-medium text-indigo-600 dark:text-indigo-400">Riwayat Pelayanan</p>
                <p class="text-2xl font-black text-gray-900 dark:text-white mt-1">{{ $stats['riwayat_pelayanan'] }}</p>
            </div>
            <div class="bg-gradient-to-br from-pink-50 to-pink-100 dark:from-pink-900/40 dark:to-pink-800/20 rounded-2xl shadow-sm border border-pink-100 dark:border-pink-800/50 p-5 transition-transform hover:scale-[1.02]">
                <p class="text-sm font-medium text-pink-600 dark:text-pink-400">Konseling Terakhir</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['konseling_terakhir'] }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 flex flex-col justify-center items-start transition-transform hover:scale-[1.02]">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Status Verifikasi</p>
                <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full 
                    @if($stats['status_verifikasi'] === 'Terverifikasi') bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400
                    @elseif($stats['status_verifikasi'] === 'Menunggu Verifikasi') bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400
                    @else bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 @endif shadow-sm">
                    @if($stats['status_verifikasi'] === 'Terverifikasi')
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    @elseif($stats['status_verifikasi'] === 'Menunggu Verifikasi')
                        <svg class="w-3.5 h-3.5 mr-1 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    @endif
                    {{ $stats['status_verifikasi'] }}
                </span>
            </div>
        </div>

    {{-- Action Buttons --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-4">
        <div class="flex flex-wrap gap-2">
            @if(!$wus)
                <a href="{{ route('warga.reproduksi.create') }}" 
                   class="px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg transition duration-150 flex items-center">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Data WUS
                </a>
            @else
                @if(!$wus->is_verified)
                    <a href="{{ route('warga.reproduksi.edit', $wus) }}" 
                       class="px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg transition duration-150 flex items-center">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Data
                    </a>
                    <form action="{{ route('warga.reproduksi.destroy', $wus) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg transition duration-150 flex items-center"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus
                        </button>
                    </form>
                @else
                    <span class="px-4 py-2 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-lg">
                        ✅ Data Terverifikasi
                    </span>
                @endif
            @endif
        </div>
    </div>

    {{-- Data WUS --}}
    @if($wus)
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Data WUS</h3>
            <a href="{{ route('warga.reproduksi.show', $wus) }}" 
               class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                Lihat Detail →
            </a>
        </div>
        <div class="p-6">
            <div class="flex items-center space-x-4 mb-4">
                <div class="flex-shrink-0">
                    <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-gray-200 dark:border-gray-700">
                        <img src="{{ $wus->foto_url }}" alt="{{ $wus->nama }}" class="w-full h-full object-cover">
                    </div>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 dark:text-white">{{ $wus->nama }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">NIK: {{ $wus->nik }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Umur: {{ $wus->umur }} tahun</p>
                </div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                <div>
                    <p class="text-gray-500 dark:text-gray-400">Status Pernikahan</p>
                    <p class="font-medium text-gray-900 dark:text-white">{{ $wus->status_pernikahan ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400">Golongan Darah</p>
                    <p class="font-medium text-gray-900 dark:text-white">{{ $wus->golongan_darah ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400">Status Anemia</p>
                    <p class="font-medium text-gray-900 dark:text-white">{{ $wus->status_anemia ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400">Verifikasi</p>
                    @if($wus->is_verified)
                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400">✅ Terverifikasi</span>
                    @else
                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400">⏳ Pending</span>
                    @endif
                </div>
            </div>
            @if($wus->riwayat_penyakit)
                <div class="mt-4">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Riwayat Penyakit</p>
                    <p class="text-gray-700 dark:text-gray-300">{{ $wus->riwayat_penyakit }}</p>
                </div>
            @endif
        </div>
    </div>
    @endif

    {{-- Data PUS --}}
    @if($pus)
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Data PUS</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Nama Pasangan</p>
                    <p class="font-semibold text-gray-900 dark:text-white">{{ $pus->nama_pasangan }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Jumlah Anak</p>
                    <p class="font-semibold text-gray-900 dark:text-white">{{ $pus->jumlah_anak }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Status KB</p>
                    <p class="font-semibold text-gray-900 dark:text-white">{{ $pus->status_kb_label }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Jenis Kontrasepsi</p>
                    <p class="font-semibold text-gray-900 dark:text-white">{{ $pus->jenis_kontrasepsi ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Tanggal Mulai KB</p>
                    <p class="font-semibold text-gray-900 dark:text-white">{{ $pus->tanggal_mulai_kb ? $pus->tanggal_mulai_kb->format('d M Y') : '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Jadwal Kontrol</p>
                    <p class="font-semibold text-gray-900 dark:text-white">{{ $pus->jadwal_kontrol ? $pus->jadwal_kontrol->format('d M Y') : '-' }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Riwayat Pelayanan --}}
    @if($pelayanan->count() > 0)
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Riwayat Pelayanan</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Data hasil pelayanan Posyandu (Read Only)</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jenis Pelayanan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kontrasepsi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pegawai</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($pelayanan as $item)
                        <tr>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $item->tanggal->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $item->jenis_pelayanan_label }}</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $item->jenis_kontrasepsi ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $item->user->name }}</td>
                            <td class="px-6 py-4">
                                @if($item->jadwal_kontrol_berikutnya)
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400">
                                        Jadwal Kontrol
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                        Selesai
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('warga.reproduksi.pelayanan.show', $item) }}" 
                                   class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 text-sm">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- Riwayat Konseling --}}
    @if($konseling->count() > 0)
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Riwayat Konseling</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Topik</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Catatan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pegawai</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($konseling as $item)
                        <tr>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $item->tanggal->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $item->topik }}</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $item->catatan ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $item->user->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- Notifikasi --}}
    @if(count($notifications) > 0)
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                Notifikasi
            </h3>
        </div>
        <div class="p-4 space-y-2">
            @foreach($notifications as $notif)
                <div class="flex items-start p-3 rounded-lg bg-gray-50 dark:bg-gray-700/50">
                    <div class="flex-shrink-0 mr-3">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $notif['title'] }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $notif['message'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Artikel Edukasi --}}
    @if($artikel->count() > 0)
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Artikel Edukasi</h3>
        </div>
        <div class="p-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($artikel as $item)
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 hover:shadow-md transition duration-150">
                        <div class="w-full h-32 rounded-lg overflow-hidden mb-3">
                            <img src="{{ $item->thumbnail_url }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                        </div>
                        <h4 class="font-semibold text-gray-900 dark:text-white line-clamp-2">{{ $item->title }}</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2 mt-1">{{ $item->excerpt }}</p>
                        <a href="{{ route('public.article-detail', $item->slug) }}" 
                           class="inline-flex items-center text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 mt-2">
                            Baca Selengkapnya →
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
    </div>
</div>
@endsection