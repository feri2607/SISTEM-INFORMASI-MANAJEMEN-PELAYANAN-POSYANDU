{{-- resources/views/warga/balita/index.blade.php --}}

@extends('layouts.public')

@section('hide-footer', true)
@section('title', 'Balita Saya - Sistem Informasi Posyandu')

@section('page-title', '👶 Balita Saya')
@section('page-subtitle', 'Pantau pertumbuhan dan perkembangan balita Anda.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<div class="space-y-6">
    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-4">
            <p class="text-sm text-gray-500 dark:text-gray-400">Jumlah Balita</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-4">
            <p class="text-sm text-gray-500 dark:text-gray-400">Status Gizi</p>
            <span class="inline-block mt-1 px-2 py-1 text-xs font-medium rounded-full 
                @if($stats['status_gizi'] === 'normal') bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400
                @elseif($stats['status_gizi'] === 'kurang') bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400
                @elseif($stats['status_gizi'] === 'buruk') bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400
                @else bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 @endif">
                {{ ucfirst($stats['status_gizi']) }}
            </span>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-4">
            <p class="text-sm text-gray-500 dark:text-gray-400">Imunisasi Bulan Ini</p>
            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $stats['imunisasi_bulan_ini'] }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-4">
            <p class="text-sm text-gray-500 dark:text-gray-400">Vitamin Bulan Ini</p>
            <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $stats['vitamin_bulan_ini'] }}</p>
        </div>
    </div>

    {{-- Tombol Tambah Balita --}}
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-4">
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('warga.balita.create') }}" 
           class="px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg transition duration-150 flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Balita
        </a>
    </div>
</div>

    {{-- Table --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Balita</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Umur</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">JK</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status Gizi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Verifikasi</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($balita as $item)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full overflow-hidden bg-gray-100 dark:bg-gray-700">
                                        <img src="{{ $item->foto_url }}" alt="{{ $item->nama }}" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $item->nama }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $item->tanggal_lahir->format('d M Y') }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                                {{ $item->umur }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-medium rounded-full 
                                    @if($item->jenis_kelamin === 'L') bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400
                                    @else bg-pink-100 dark:bg-pink-900/30 text-pink-700 dark:text-pink-400 @endif">
                                    {{ $item->jenis_kelamin_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($item->pemeriksaanTerakhir)
                                    <span class="px-2 py-1 text-xs font-medium rounded-full 
                                        @if($item->pemeriksaanTerakhir->status_gizi === 'normal') bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400
                                        @elseif($item->pemeriksaanTerakhir->status_gizi === 'kurang') bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400
                                        @elseif($item->pemeriksaanTerakhir->status_gizi === 'buruk') bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400
                                        @else bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400 @endif">
                                        {{ ucfirst($item->pemeriksaanTerakhir->status_gizi) }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($item->is_verified)
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400">
                                        ✅ Terverifikasi
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400">
                                        ⏳ Pending
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('warga.balita.show', $item) }}" 
                                       class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300"
                                       title="Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    @if(!$item->is_verified)
                                        <a href="{{ route('warga.balita.edit', $item) }}" 
                                           class="text-yellow-600 hover:text-yellow-700 dark:text-yellow-400 dark:hover:text-yellow-300"
                                           title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <form action="{{ route('warga.balita.destroy', $item) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300"
                                                    title="Hapus"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data balita ini?')">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p class="text-gray-500 dark:text-gray-400">Belum ada data balita</p>
                                    <a href="{{ route('warga.balita.create') }}" class="mt-3 px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg transition duration-150">
                                        Tambah Balita Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $balita->withQueryString()->links() }}
        </div>
    </div>
</div>
</div>
@endsection