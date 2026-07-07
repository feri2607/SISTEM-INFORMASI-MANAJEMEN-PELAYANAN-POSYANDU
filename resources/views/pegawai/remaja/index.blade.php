{{-- resources/views/pegawai/remaja/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Data Remaja - Pegawai')
@section('page-title', '🧑‍🤝‍🧑 Data Remaja')
@section('page-subtitle', 'Kelola seluruh data remaja Posyandu')

@section('content')
<div class="space-y-6">

    {{-- Stats Row --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-4 text-center">
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Total Remaja</p>
            <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $remaja->total() }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-4 text-center">
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Terverifikasi</p>
            <p class="text-2xl font-bold text-green-600 dark:text-green-400">
                {{ $remaja->getCollection()->where('is_verified', true)->count() }}
            </p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-4 text-center">
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Belum Verifikasi</p>
            <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">
                {{ $remaja->getCollection()->where('is_verified', false)->count() }}
            </p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-4 text-center">
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Laki / Perempuan</p>
            <p class="text-lg font-bold text-gray-900 dark:text-white">
                <span class="text-blue-600">{{ $remaja->getCollection()->where('jenis_kelamin', 'L')->count() }}</span>
                <span class="text-gray-400 font-normal">/</span>
                <span class="text-pink-600">{{ $remaja->getCollection()->where('jenis_kelamin', 'P')->count() }}</span>
            </p>
        </div>
    </div>

    {{-- Filters & Search --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-5">
        <div class="flex flex-wrap items-center gap-3 mb-4">
            <a href="{{ route('pegawai.remaja.dashboard') }}"
               class="flex items-center gap-2 px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg transition text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>
        </div>
        <form method="GET" action="{{ route('pegawai.remaja.index') }}"
              class="flex flex-wrap gap-3 border-t border-gray-200 dark:border-gray-700 pt-4">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" placeholder="Cari nama atau NIK ..."
                       value="{{ request('search') }}"
                       class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>
            <select name="status"
                    class="px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500">
                <option value="">Semua Status</option>
                <option value="verified" {{ request('status') === 'verified' ? 'selected' : '' }}>✅ Terverifikasi</option>
                <option value="unverified" {{ request('status') === 'unverified' ? 'selected' : '' }}>⏳ Belum Verifikasi</option>
            </select>
            <select name="gender"
                    class="px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500">
                <option value="">Semua JK</option>
                <option value="L" {{ request('gender') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ request('gender') === 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
            <button type="submit"
                    class="px-5 py-2.5 bg-[#036672] hover:bg-[#036672] text-white rounded-xl text-sm font-medium transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Filter
            </button>
            @if(request()->hasAny(['search', 'status', 'gender']))
                <a href="{{ route('pegawai.remaja.index') }}"
                   class="px-5 py-2.5 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-xl text-sm transition">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Remaja</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Umur</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jenis Kelamin</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pemeriksaan</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($remaja as $item)
                        <tr class="hover:bg-purple-50 dark:hover:bg-purple-900/10 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $item->foto_url }}" alt="{{ $item->nama }}"
                                         class="w-11 h-11 rounded-full object-cover ring-2 ring-purple-200 dark:ring-purple-800 flex-shrink-0">
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-white">{{ $item->nama }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 font-mono">{{ $item->nik }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $item->umur }} tahun</td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-xs font-medium rounded-full
                                    {{ $item->jenis_kelamin === 'L'
                                        ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400'
                                        : 'bg-pink-100 dark:bg-pink-900/30 text-pink-700 dark:text-pink-400' }}">
                                    {{ $item->jenis_kelamin_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($item->pemeriksaan->isNotEmpty())
                                    <div>
                                        <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400">
                                            {{ $item->pemeriksaan->count() }}x Dilayani
                                        </span>
                                        <p class="text-xs text-gray-400 mt-1">
                                            Terakhir: {{ $item->pemeriksaan->first()?->tanggal->format('d M Y') }}
                                        </p>
                                    </div>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400">
                                        Belum ada
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($item->is_verified)
                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400">
                                        ✅ Terverifikasi
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400">
                                        ⏳ Pending
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    {{-- Detail --}}
                                    <a href="{{ route('pegawai.remaja.show', $item) }}"
                                       class="p-2 rounded-lg text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition" title="Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    {{-- Pemeriksaan --}}
                                    <a href="{{ route('pegawai.remaja.pemeriksaan.create', $item) }}"
                                       class="p-2 rounded-lg text-green-600 hover:bg-green-50 dark:hover:bg-green-900/20 transition" title="Pemeriksaan">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                        </svg>
                                    </a>
                                    {{-- Konseling --}}
                                    <a href="{{ route('pegawai.remaja.konseling.create', $item) }}"
                                       class="p-2 rounded-lg text-purple-600 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition" title="Konseling">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                        </svg>
                                    </a>
                                    {{-- Hapus --}}
                                    <form action="{{ route('pegawai.remaja.destroy', $item) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus data remaja \&quot;{{ $item->nama }}\&quot;? Tindakan ini tidak dapat dibatalkan.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition" title="Hapus">
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
                            <td colspan="6" class="px-6 py-16 text-center">
                                <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/>
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400 font-medium">Belum ada data remaja</p>
                                <p class="text-sm text-gray-400 mt-1">Data remaja akan muncul setelah warga mendaftar.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($remaja->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $remaja->withQueryString()->links() }}
            </div>
        @endif
    </div>

    {{-- Info Panduan --}}
    <div class="bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 rounded-2xl p-4">
        <div class="flex gap-3">
            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <p class="text-sm font-semibold text-purple-800 dark:text-purple-300">Panduan Pelayanan Remaja</p>
                <ul class="text-sm text-purple-700 dark:text-purple-400 mt-1 space-y-0.5">
                    <li>• Klik <strong>ikon mata</strong> untuk melihat detail dan grafik pertumbuhan remaja</li>
                    <li>• Klik <strong>ikon clipboard</strong> untuk input pemeriksaan (BB, TB, BMI, HB)</li>
                    <li>• Klik <strong>ikon chat</strong> untuk mencatat sesi konseling</li>
                    <li>• BMI dan status gizi akan dihitung <strong>otomatis</strong> oleh sistem</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
