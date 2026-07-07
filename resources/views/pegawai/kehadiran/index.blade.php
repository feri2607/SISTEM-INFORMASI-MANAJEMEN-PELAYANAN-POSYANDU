{{-- resources/views/pegawai/kehadiran/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Registrasi Kehadiran - Sistem Informasi Posyandu')

@section('page-title', 'Registrasi Kehadiran')
@section('page-subtitle', 'Catat peserta yang hadir pada kegiatan Posyandu hari ini.')

@section('content')
<div class="space-y-6">

    {{-- Filter Form --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
        <form method="GET" action="{{ route('pegawai.kehadiran.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            
            <div class="lg:col-span-2">
                <select name="kegiatan_id" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">-- Pilih Kegiatan --</option>
                    @foreach($kegiatanList as $kg)
                        <option value="{{ $kg->id }}" {{ ($filters['kegiatan_id'] ?? request('kegiatan_id')) == $kg->id ? 'selected' : '' }}>
                            {{ $kg->tanggal->format('d M') }} - {{ $kg->nama_kegiatan }} 
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <input type="date" name="tanggal" value="{{ $filters['tanggal'] ?? request('tanggal', date('Y-m-d')) }}" 
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div>
                <select name="kategori" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Kategori</option>
                    @foreach(['Balita', 'Kehamilan', 'WUS/PUS', 'Remaja', 'Lansia'] as $kat)
                        <option value="{{ $kat }}" {{ ($filters['kategori'] ?? request('kategori')) == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2">
                <input type="text" name="search" placeholder="Cari Nama..." value="{{ $filters['search'] ?? request('search') }}"
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <button type="submit" class="px-3 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg transition duration-150">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </button>
            </div>
            
        </form>
    </div>

    {{-- Statistics --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 flex flex-col items-center justify-center border-b-4 border-indigo-500">
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Peserta</h3>
            <p class="mt-2 text-4xl font-bold text-gray-900 dark:text-white">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 flex flex-col items-center justify-center border-b-4 border-green-500">
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Sudah Hadir</h3>
            <p class="mt-2 text-4xl font-bold text-green-600 dark:text-green-400">{{ $stats['hadir'] }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 flex flex-col items-center justify-center border-b-4 border-gray-400">
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Belum Hadir</h3>
            <p class="mt-2 text-4xl font-bold text-gray-600 dark:text-gray-400">{{ $stats['belum_hadir'] }}</p>
        </div>
    </div>

    {{-- Notification --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Berhasil!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Table Header and Actions --}}
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Daftar Kehadiran</h3>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Foto & Nama</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Identitas (NIK & KK)</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status Kehadiran</th>

                        <th class="px-6 py-3 text-right font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($kehadiran as $item)
                        @php
                            $peserta = $item->peserta;
                            $warga = $peserta ? $peserta->warga : null;
                        @endphp
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full object-cover" 
                                             src="{{ $peserta ? $peserta->foto_url : 'https://ui-avatars.com/api/?name=NN' }}" 
                                             alt="">
                                    </div>
                                    <div class="ml-4">
                                        <div class="font-bold text-gray-900 dark:text-white">
                                            {{ $peserta ? $peserta->nama : 'Tidak diketahui' }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $warga ? 'Verifikasi: '. ($warga->is_verified ? 'Terverifikasi' : 'Menunggu') : '-' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300 rounded-full text-xs font-semibold">
                                    {{ $item->kategori ?: 'Peserta' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300 text-xs">
                                <div><span class="font-medium">NIK:</span> {{ $peserta ? $peserta->nik : '-' }}</div>
                                <div><span class="font-medium">KK:</span> {{ $peserta ? $peserta->nomor_kk : '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if(in_array($item->status_kehadiran, ['Hadir', 'Sudah Dilayani']))
                                    <span class="px-2 py-1 bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300 rounded-full text-xs font-semibold flex items-center w-fit">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        {{ $item->status_kehadiran }}
                                    </span>
                                @else
                                    <span class="px-2 py-1 bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-full text-xs font-semibold">
                                        Belum Hadir
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-right">
                                @if(in_array($item->status_kehadiran, ['Hadir', 'Sudah Dilayani']))
                                    <span class="text-sm font-medium text-gray-500">
                                        {{ $item->status_kehadiran === 'Sudah Dilayani' ? 'Telah Dilayani' : 'Masuk Antrean' }}
                                    </span>
                                @else
                                    <form action="{{ route('pegawai.kehadiran.hadir', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg transition text-sm font-medium flex items-center justify-center w-full md:w-auto ml-auto shadow-sm">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            Registrasi Hadir
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                Belum ada peserta yang sesuai dengan filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $kehadiran->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
