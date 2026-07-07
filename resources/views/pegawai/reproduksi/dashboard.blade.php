{{-- resources/views/pegawai/reproduksi/dashboard.blade.php --}}

@extends('layouts.app')

@section('title', 'Dashboard Reproduksi - Pegawai')

@section('page-title', '🩺 Dashboard Kesehatan Reproduksi')
@section('page-subtitle', 'Ringkasan data dan layanan WUS & PUS.')

@section('content')
<div class="space-y-6">
    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-4">
            <p class="text-sm text-gray-500 dark:text-gray-400">Total WUS</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_wus'] }}</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-4">
            <p class="text-sm text-gray-500 dark:text-gray-400">Pelayanan Hari Ini</p>
            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $stats['pelayanan_hari_ini'] }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-4">
            <p class="text-sm text-gray-500 dark:text-gray-400">Jadwal Kontrol Hari Ini</p>
            <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $stats['jadwal_kontrol_hari_ini'] }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-4">
            <p class="text-sm text-gray-500 dark:text-gray-400">Konseling Hari Ini</p>
            <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $stats['konseling_hari_ini'] }}</p>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Aksi Cepat</h3>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('pegawai.reproduksi.wus.index') }}" 
               class="px-4 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 dark:bg-blue-900/30 dark:hover:bg-blue-900/50 dark:text-blue-400 rounded-lg transition duration-150 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                Kelola Data WUS
            </a>

            <a href="{{ route('pegawai.reproduksi.kontrol.index') }}" 
               class="px-4 py-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 dark:bg-yellow-900/30 dark:hover:bg-yellow-900/50 dark:text-yellow-400 rounded-lg transition duration-150 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Jadwal Kontrol
            </a>
        </div>
    </div>

    {{-- Recent Pelayanan --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Pelayanan Terbaru</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama WUS</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jenis Pelayanan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kontrasepsi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pegawai</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($recentPelayanan as $item)
                        <tr>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $item->tanggal->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('pegawai.reproduksi.wus.show', $item->wus) }}" class="font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                    {{ $item->wus->nama }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $item->jenis_pelayanan_label }}</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $item->jenis_kontrasepsi ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $item->user->name }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                Belum ada data pelayanan terbaru
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
