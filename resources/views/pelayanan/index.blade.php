{{-- resources/views/pelayanan/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Riwayat Pelayanan - Sistem Informasi Posyandu')
@section('page-title', 'Riwayat Pelayanan Posyandu')
@section('page-subtitle', 'Lihat daftar pelayanan yang telah diberikan kepada peserta Posyandu.')

@section('content')
<div class="space-y-6">

    {{-- Statistics --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-5 shadow-sm border-l-4 border-blue-500">
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Pelayanan</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg p-5 shadow-sm border-l-4 border-green-500">
            <p class="text-sm text-gray-500 dark:text-gray-400">Bulan Ini</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['bulan_ini'] }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg p-5 shadow-sm border-l-4 border-teal-500">
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Gizi Baik/Normal</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['gizi_baik'] }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg p-5 shadow-sm border-l-4 border-red-500">
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Gizi Buruk</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['gizi_buruk'] }}</p>
        </div>
    </div>

    {{-- Filter and Export --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 flex flex-col md:flex-row justify-between items-center gap-4">
        <form method="GET" action="{{ route(auth()->user()->role === 'admin' ? 'admin.pelayanan.index' : 'pegawai.pelayanan.index') }}" class="flex-1 flex flex-wrap gap-2 w-full">
            <input type="text" name="search" placeholder="Cari Nama/Kegiatan..." value="{{ request('search') }}"
                   class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-sm focus:ring-blue-500 flex-grow md:max-w-xs">
            
            <select name="bulan" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-sm focus:ring-blue-500">
                <option value="">-- Semua Bulan --</option>
                @foreach($months as $num => $name)
                    <option value="{{ sprintf('%02d', $num) }}" {{ request('bulan') == sprintf('%02d', $num) ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>

            <select name="tahun" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-sm focus:ring-blue-500">
                <option value="">-- Semua Tahun --</option>
                @foreach($years as $y)
                    <option value="{{ $y->year }}" {{ request('tahun') == $y->year ? 'selected' : '' }}>{{ $y->year }}</option>
                @endforeach
            </select>
            
            <button type="submit" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-white rounded-lg text-sm font-medium transition">
                Filter
            </button>
        </form>


    </div>

    {{-- Data Table --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal & Kegiatan</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama & Kategori</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Metrik Status Gizi</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Layanan</th>
                        <th class="px-6 py-3 text-right font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($pelayanan as $item)
                        @php
                            $balita = $item->balita; // assuming relation loaded
                            // Using a more generalized variable since we might expand beyond balita in logic, but controller queries for balita currently.
                        @endphp
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900 dark:text-white">{{ $item->created_at->format('d M Y') }}</div>
                                <div class="text-xs text-gray-500 mt-0.5">{{ $item->kegiatan ? $item->kegiatan->nama_kegiatan : '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 h-8 w-8">
                                        <img class="h-8 w-8 rounded-full object-cover" 
                                             src="{{ $balita ? $balita->foto_url : 'https://ui-avatars.com/api/?name=NN' }}" alt="">
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900 dark:text-white flex items-center gap-2">
                                            {{ $balita ? $balita->nama : 'Tidak diketahui' }}
                                        </div>
                                        <div class="text-xs text-gray-500 mt-0.5">Balita</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $giziColors = [
                                        'normal' => 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300',
                                        'kurang' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300',
                                        'buruk' => 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300',
                                        'lebih' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/50 dark:text-orange-300',
                                    ];
                                    $sgColor = $giziColors[$item->status_gizi] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-2 py-1 rounded text-xs font-semibold {{ $sgColor }}">
                                    {{ ucfirst($item->status_gizi) }}
                                </span>
                                <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    BB: {{ $item->berat_badan }} kg / TB: {{ $item->tinggi_badan }} cm
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    @if($item->imunisasi && $item->imunisasi !== 'null' && $item->imunisasi !== '[]')
                                        <span class="px-2 py-0.5 bg-indigo-100 text-indigo-800 rounded text-xs">Imunisasi</span>
                                    @endif
                                    @if($item->vitamin && $item->vitamin !== 'null' && $item->vitamin !== '[]')
                                        <span class="px-2 py-0.5 bg-yellow-100 text-yellow-800 rounded text-xs">Vitamin</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route(auth()->user()->role === 'admin' ? 'admin.pelayanan.show' : 'pegawai.pelayanan.show', $item->id) }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 text-sm font-medium">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">Tida ada riwayat pelayanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $pelayanan->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection