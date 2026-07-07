{{-- resources/views/balita/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Data Balita - Sistem Informasi Posyandu')

@section('page-title', 'Data Balita')
@section('page-subtitle', 'Kelola seluruh data balita')

@section('content')
<div class="space-y-6">
    <!-- Stats -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">Total Balita</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total']) }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">Laki-laki</p>
            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ number_format($stats['laki_laki']) }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">Perempuan</p>
            <p class="text-2xl font-bold text-pink-600 dark:text-pink-400">{{ number_format($stats['perempuan']) }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">Gizi Baik</p>
            <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ number_format($stats['gizi_baik']) }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">Gizi Kurang</p>
            <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ number_format($stats['gizi_kurang']) }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">Gizi Buruk</p>
            <p class="text-2xl font-bold text-red-600 dark:text-red-400">{{ number_format($stats['gizi_buruk']) }}</p>
        </div>
    </div>

    <!-- Actions -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route($routePrefix . 'create') }}" 
                   class="px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg transition duration-150 flex items-center">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Balita
                </a>
            </div>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
        <form method="GET" action="{{ route($routePrefix . 'index') }}" class="flex flex-wrap gap-3">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" placeholder="Cari nama balita, orang tua, atau NIK..." 
                       value="{{ request('search') }}"
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div>
                <select name="gender" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua JK</option>
                    <option value="L" {{ request('gender') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ request('gender') === 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <div>
                <select name="gizi" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Gizi</option>
                    <option value="normal" {{ request('gizi') === 'normal' ? 'selected' : '' }}>Normal</option>
                    <option value="kurang" {{ request('gizi') === 'kurang' ? 'selected' : '' }}>Kurang</option>
                    <option value="buruk" {{ request('gizi') === 'buruk' ? 'selected' : '' }}>Buruk</option>
                    <option value="lebih" {{ request('gizi') === 'lebih' ? 'selected' : '' }}>Lebih</option>
                </select>
            </div>

            <div>
                <input type="number" name="age_from" placeholder="Usia dari (bulan)" 
                       value="{{ request('age_from') }}"
                       class="w-32 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div>
                <input type="number" name="age_to" placeholder="Usia sampai (bulan)" 
                       value="{{ request('age_to') }}"
                       class="w-32 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <button type="submit" class="px-6 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg transition duration-150">
                <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Cari
            </button>

            @if(request()->hasAny(['search', 'gender', 'gizi', 'age_from', 'age_to']))
                <a href="{{ route($routePrefix . 'index') }}" class="px-6 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition duration-150">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Balita</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Orang Tua</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Usia</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">JK</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status Gizi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pemeriksaan Terakhir</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($balita as $item)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-100 dark:bg-gray-700">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($item->nama) }}&color=7F9CF5&background=EBF4FF&size=40" 
                                                 alt="{{ $item->nama }}" class="w-full h-full object-cover">
                                        </div>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $item->nama }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $item->tanggal_lahir->format('d M Y') }}</p>
                                    </div>
                                </div>
                            </td>
                             <td class="px-6 py-4">
                                 <div>
                                     @if($item->warga)
                                         <p class="text-gray-900 dark:text-white">{{ $item->warga->nama }}</p>
                                         <p class="text-xs text-gray-500 dark:text-gray-400 font-mono">{{ $item->warga->nik }}</p>
                                     @else
                                         <p class="text-red-500 italic text-xs">Data Orang Tua Tidak Ditemukan</p>
                                     @endif
                                 </div>
                             </td>
                            <td class="px-6 py-4">
                                <span class="font-medium text-gray-900 dark:text-white">{{ $item->umur_bulan }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">bulan</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-medium rounded-full 
                                    @if($item->jenis_kelamin === 'L') bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400
                                    @else bg-pink-100 dark:bg-pink-900/30 text-pink-700 dark:text-pink-400 @endif">
                                    {{ $item->jenis_kelamin_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($item->status_gizi_terakhir)
                                    <span class="px-2 py-1 text-xs font-medium rounded-full 
                                        @if($item->status_gizi_terakhir === 'normal') bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400
                                        @elseif($item->status_gizi_terakhir === 'kurang') bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400
                                        @elseif($item->status_gizi_terakhir === 'buruk') bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400
                                        @else bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400 @endif">
                                        {{ $item->status_gizi_label }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-500 dark:text-gray-400">Belum ada data</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                {{ $item->pemeriksaan_terakhir_date }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route($routePrefix . 'show', $item->id) }}" 
                                       class="text-gray-600 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300"
                                       title="Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route($routePrefix . 'edit', $item->id) }}" 
                                       class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300"
                                       title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    @if(!$item->is_verified)
                                        <form action="{{ route($routePrefix . 'verify', $item->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-green-600 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300" title="Verifikasi Data">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </button>
                                        </form>
                                        <form action="{{ route($routePrefix . 'reject', $item->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-orange-500 hover:text-orange-600 dark:text-orange-400 dark:hover:text-orange-300" title="Tolak / Hapus Data">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route($routePrefix . 'destroy', $item->id) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Hapus data balita {{ $item->nama }}? Tindakan ini tidak dapat dibatalkan.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300" title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p class="text-gray-500 dark:text-gray-400">Tidak ada data balita</p>
                                    <a href="{{ route($routePrefix . 'create') }}" class="mt-3 px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg transition duration-150">
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

@push('scripts')
<script>
    // Real-time search
    let searchTimeout;
    document.querySelector('input[name="search"]').addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            this.closest('form').submit();
        }, 500);
    });
</script>
@endpush
@endsection