{{-- resources/views/Admin/warga/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Data Warga - Sistem Informasi Posyandu')

@section('page-title', 'Data Warga')
@section('page-subtitle', 'Kelola seluruh data warga yang terdaftar pada Sistem Informasi Posyandu.')

@section('content')
<div class="space-y-6">

    {{-- ===================== STATS CARDS ===================== --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

        {{-- Total Warga --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
            <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2h5M12 12a4 4 0 100-8 4 4 0 000 8z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Warga</p>
                <p class="text-2xl font-bold text-gray-800 leading-tight">{{ number_format($stats['total']) }}</p>
                <p class="text-xs text-gray-400">Warga terdaftar</p>
            </div>
        </div>

        {{-- Laki-laki --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
            <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-sky-50 flex items-center justify-center">
                <svg class="w-6 h-6 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Laki-laki</p>
                <p class="text-2xl font-bold text-sky-600 leading-tight">{{ number_format($stats['laki_laki']) }}</p>
                <p class="text-xs text-gray-400">Jenis kelamin L</p>
            </div>
        </div>

        {{-- Perempuan --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
            <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-pink-50 flex items-center justify-center">
                <svg class="w-6 h-6 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Perempuan</p>
                <p class="text-2xl font-bold text-pink-500 leading-tight">{{ number_format($stats['perempuan']) }}</p>
                <p class="text-xs text-gray-400">Jenis kelamin P</p>
            </div>
        </div>

        {{-- Profil Terverifikasi --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
            <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center">
                <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Profil Terverifikasi</p>
                <p class="text-2xl font-bold text-emerald-600 leading-tight">{{ number_format($stats['verified']) }}</p>
                <p class="text-xs text-gray-400">Data diverifikasi</p>
            </div>
        </div>

    </div>

    {{-- ===================== ACTION BAR ===================== --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <form method="GET" action="{{ route($routePrefix . 'index') }}">
            <div class="flex flex-wrap items-center gap-3">

                {{-- Tambah Warga --}}
                <a href="{{ route($routePrefix . 'create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-medium rounded-lg shadow-sm transition-colors duration-150 whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Warga
                </a>

                {{-- Divider --}}
                <div class="hidden sm:block h-8 w-px bg-gray-200"></div>

                {{-- Search --}}
                <div class="flex-1 min-w-[200px] relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" id="searchInput"
                        placeholder="Cari nama, NIK, nomor HP..."
                        value="{{ request('search') }}"
                        class="w-full pl-10 pr-4 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:bg-white transition-all duration-150">
                </div>

                {{-- Filter Jenis Kelamin --}}
                <select name="gender"
                    class="px-3 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:bg-white transition-all duration-150">
                    <option value="">Jenis Kelamin</option>
                    <option value="L" {{ request('gender') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ request('gender') === 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>

                {{-- Filter Status --}}
                <select name="status"
                    class="px-3 py-2.5 text-sm border border-gray-200 rounded-lg bg-gray-50 text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:bg-white transition-all duration-150">
                    <option value="">Status Profil</option>
                    <option value="verified"  {{ request('status') === 'verified'  ? 'selected' : '' }}>Terverifikasi</option>
                    <option value="pending"   {{ request('status') === 'pending'   ? 'selected' : '' }}>Belum Diverifikasi</option>
                    <option value="rejected"  {{ request('status') === 'rejected'  ? 'selected' : '' }}>Ditolak</option>
                </select>

                {{-- Tombol Cari --}}
                <button type="submit"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors duration-150 whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Cari
                </button>

                {{-- Tombol Reset (hanya muncul jika ada filter aktif) --}}
                @if(request()->hasAny(['search', 'gender', 'status']))
                    <a href="{{ route($routePrefix . 'index') }}"
                       class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-medium rounded-lg transition-colors duration-150 whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Reset Filter
                    </a>
                @endif

            </div>
        </form>
    </div>

    {{-- ===================== TABLE ===================== --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- Table Header Info --}}
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-semibold text-gray-700">Daftar Warga</h3>
                <p class="text-xs text-gray-400 mt-0.5">
                    Menampilkan {{ $warga->firstItem() ?? 0 }}–{{ $warga->lastItem() ?? 0 }} dari {{ $warga->total() }} data
                </p>
            </div>
            @if(request()->hasAny(['search', 'gender', 'status']))
                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-blue-50 text-blue-600 text-xs font-medium rounded-full">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.553.894l-4 2A1 1 0 016 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd"/>
                    </svg>
                    Filter Aktif
                </span>
            @endif
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Foto</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Warga</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <a href="{{ route($routePrefix . 'index', array_merge(request()->all(), ['sort' => 'nik', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}"
                               class="inline-flex items-center gap-1 hover:text-gray-700 transition-colors">
                                NIK
                                @if(request('sort') === 'nik')
                                    <span>{{ request('direction') === 'asc' ? '↑' : '↓' }}</span>
                                @else
                                    <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/></svg>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">No HP</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Jenis Kelamin</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status Profil</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <a href="{{ route($routePrefix . 'index', array_merge(request()->all(), ['sort' => 'created_at', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}"
                               class="inline-flex items-center gap-1 hover:text-gray-700 transition-colors">
                                Tanggal Dibuat
                                @if(request('sort') === 'created_at')
                                    <span>{{ request('direction') === 'asc' ? '↑' : '↓' }}</span>
                                @else
                                    <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/></svg>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($warga as $item)
                        <tr class="hover:bg-gray-50/70 transition-colors duration-100">

                            {{-- Foto --}}
                            <td class="px-6 py-4">
                                <img src="{{ $item->foto_url }}" alt="{{ $item->nama }}"
                                    class="w-10 h-10 rounded-full object-cover ring-2 ring-gray-100">
                            </td>

                            {{-- Nama Warga --}}
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-semibold text-gray-800 leading-tight">{{ $item->nama }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5 truncate max-w-[180px]">{{ Str::limit($item->alamat, 40) }}</p>
                                </div>
                            </td>

                            {{-- NIK --}}
                            <td class="px-6 py-4">
                                <span class="font-mono text-xs text-gray-600 bg-gray-100 px-2 py-1 rounded">{{ $item->nik }}</span>
                            </td>

                            {{-- No HP --}}
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $item->nomor_hp ?? $item->user?->phone ?? '-' }}
                            </td>

                            {{-- Jenis Kelamin --}}
                            <td class="px-6 py-4">
                                @if($item->jenis_kelamin === 'L')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-sky-50 text-sky-600 text-xs font-medium rounded-full">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>
                                        Laki-laki
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-pink-50 text-pink-500 text-xs font-medium rounded-full">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>
                                        Perempuan
                                    </span>
                                @endif
                            </td>

                            {{-- Status Profil --}}
                            <td class="px-6 py-4">
                                @php
                                    $status = $item->verification_status ?? 'pending';
                                @endphp
                                @if($status === 'verified')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 text-emerald-600 text-xs font-semibold rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Terverifikasi
                                    </span>
                                @elseif($status === 'rejected')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-50 text-red-500 text-xs font-semibold rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                        Ditolak
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-amber-50 text-amber-600 text-xs font-semibold rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                        Belum Diverifikasi
                                    </span>
                                @endif
                            </td>

                            {{-- Tanggal Dibuat --}}
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $item->created_at->format('d M Y') }}
                            </td>

                            {{-- Aksi --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-1">

                                    {{-- Detail --}}
                                    <a href="{{ route($routePrefix . 'show', $item) }}"
                                       title="Detail"
                                       class="p-1.5 rounded-lg text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-colors duration-150">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>

                                    {{-- Edit --}}
                                    <a href="{{ route($routePrefix . 'edit', $item) }}"
                                       title="Edit"
                                       class="p-1.5 rounded-lg text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 transition-colors duration-150">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>

                                    {{-- Verifikasi & Tolak (hanya jika belum diverifikasi secara final) --}}
                                    @if(!in_array($item->verification_status, ['verified', 'rejected']))
                                        {{-- Verifikasi --}}
                                        <form action="{{ route($routePrefix . 'verify', $item->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    title="Verifikasi Data"
                                                    class="p-1.5 rounded-lg text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 transition-colors duration-150">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </button>
                                        </form>

                                        {{-- Tolak --}}
                                        <button type="button"
                                                onclick="confirmReject('{{ $item->id }}', '{{ addslashes($item->nama) }}')"
                                                title="Tolak Data"
                                                class="p-1.5 rounded-lg text-gray-400 hover:text-orange-500 hover:bg-orange-50 transition-colors duration-150">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>

                                        <form id="reject-form-{{ $item->id }}" action="{{ route($routePrefix . 'reject', $item->id) }}" method="POST" class="hidden">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="rejected_reason" id="reject-reason-{{ $item->id }}">
                                        </form>
                                    @endif

                                    {{-- Hapus --}}
                                    <form action="{{ route($routePrefix . 'destroy', $item) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Hapus data warga \'{{ $item->nama }}\'? Tindakan ini tidak dapat dibatalkan.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                title="Hapus"
                                                class="p-1.5 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition-colors duration-150">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>

                    @empty
                        {{-- ===== EMPTY STATE ===== --}}
                        <tr>
                            <td colspan="8" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center gap-4">
                                    <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M17 20h5v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2h5M12 12a4 4 0 100-8 4 4 0 000 8z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-700">Belum ada data warga.</p>
                                        <p class="text-xs text-gray-400 mt-1">Klik tombol Tambah Warga untuk menambahkan warga pertama.</p>
                                    </div>
                                    <a href="{{ route($routePrefix . 'create') }}"
                                       class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-medium rounded-lg transition-colors duration-150">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        Tambah Warga
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($warga->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                <p class="text-xs text-gray-400">
                    Halaman {{ $warga->currentPage() }} dari {{ $warga->lastPage() }}
                </p>
                <div class="pagination-wrapper">
                    {{ $warga->withQueryString()->links() }}
                </div>
            </div>
        @endif

    </div>

    {{-- MODAL SUKSES (KREDENSIAL LOGIN) --}}
    @if(session('warga_created'))
    <div x-data="{ showModal: true }" x-show="showModal" class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" x-cloak>
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            
            {{-- Background Overlay --}}
            <div x-show="showModal" x-transition.opacity class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm" aria-hidden="true" @click="showModal = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
    
            {{-- Modal Panel --}}
            <div x-show="showModal" 
                 x-transition:enter="ease-out duration-300" 
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave="ease-in duration-200" 
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full border border-gray-100">
                
                <div class="bg-white px-5 pt-6 pb-5 sm:p-7 sm:pb-5 text-center">
                    <div class="mx-auto flex items-center justify-center h-14 w-14 rounded-full bg-emerald-50 mb-5 relative">
                        <svg class="h-7 w-7 text-emerald-500 relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <div class="absolute inset-0 rounded-full border-2 border-emerald-100 scale-110"></div>
                    </div>
                    
                    <h3 class="text-xl leading-6 font-bold text-gray-900 mb-2" id="modal-title">
                        Data Berhasil Disimpan
                    </h3>
                    
                    <div class="text-sm text-gray-500 mb-6">
                        <p class="mb-1">Akun login telah dibuat secara otomatis.</p>
                        <p>Silakan beritahukan kredensial berikut kepada warga terkait.</p>
                    </div>

                    {{-- Kredensial Box --}}
                    <div class="bg-[#F8FAFC] border border-blue-100 rounded-xl p-5 text-left shadow-inner" id="print-credentials">
                        <div class="space-y-4">
                            <div>
                                <span class="block text-[10px] font-bold uppercase tracking-wider text-blue-600 mb-1">Nama Lengkap</span>
                                <span class="block text-sm font-semibold text-gray-900">{{ session('warga_created')['nama'] }}</span>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <span class="block text-[10px] font-bold uppercase tracking-wider text-blue-600 mb-1">Username (NIK)</span>
                                    <span class="block text-sm font-bold text-gray-900 font-mono tracking-tight" id="copy-nik">{{ session('warga_created')['nik'] }}</span>
                                </div>
                                <div>
                                    <span class="block text-[10px] font-bold uppercase tracking-wider text-blue-600 mb-1.5">Role</span>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-blue-600 text-white tracking-widest uppercase">WARGA</span>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <span class="block text-[10px] font-bold uppercase tracking-wider text-blue-600 mb-1">Password Sementara</span>
                                    <span class="block text-sm font-bold text-gray-900 font-mono bg-white px-2 py-1 rounded border border-gray-200 w-fit" id="copy-password">{{ session('warga_created')['password_sementara'] }}</span>
                                </div>
                                <div>
                                    <span class="block text-[10px] font-bold uppercase tracking-wider text-blue-600 mb-1.5">Status Login</span>
                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[10px] font-bold bg-amber-50 text-amber-600 tracking-wider uppercase border border-amber-200/50">
                                        <div class="w-1.5 h-1.5 rounded-full bg-amber-500"></div>    
                                        Belum Login
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Footer Action Buttons --}}
                <div class="bg-gray-50/50 px-5 py-4 flex flex-col sm:flex-row-reverse gap-3 border-t border-gray-100">
                    <button type="button" @click="showModal = false" class="w-full inline-flex justify-center items-center rounded-xl border border-gray-200 shadow-sm px-4 py-2.5 bg-white text-sm font-semibold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:w-auto transition-all active:scale-[0.98]">
                        Tutup
                    </button>
                    
                    <button type="button" onclick="salinKredensial()" class="w-full inline-flex justify-center items-center gap-2 rounded-xl border border-transparent shadow-sm px-4 py-2.5 bg-blue-600 text-sm font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:w-auto transition-all shadow-blue-500/30 active:scale-[0.98]">
                        <svg class="w-4 h-4 text-blue-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        Salin Data
                    </button>
                    
                    <button type="button" onclick="cetakKredensial()" class="w-full inline-flex justify-center items-center gap-2 rounded-xl border border-gray-200 shadow-sm px-4 py-2.5 bg-white text-sm font-semibold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:w-auto transition-all active:scale-[0.98]">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Cetak
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>


@push('scripts')
<script>
    @if(session('warga_created'))
    function salinKredensial() {
        const nik = document.getElementById('copy-nik').innerText;
        const pwd = document.getElementById('copy-password').innerText;
        const text = `Informasi Login Warga\nUsername (NIK): ${nik}\nPassword: ${pwd}\nHarap segera mengganti password saat login pertama kali.`;
        
        navigator.clipboard.writeText(text).then(() => {
            Swal.fire({
                icon: 'success',
                title: 'Tersalin!',
                text: 'Kredensial berhasil disalin ke clipboard.',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        });
    }

    function cetakKredensial() {
        const content = document.getElementById('print-credentials').innerHTML;
        const printWindow = window.open('', '', 'width=600,height=400');
        printWindow.document.write(`
            <html>
                <head>
                    <title>Informasi Login Warga - Posyandu</title>
                    <style>
                        body { font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; padding: 20px; color: #333; }
                        h2 { text-align: center; color: #2563EB; margin-bottom: 25px; border-bottom: 1px solid #e2e8f0; padding-bottom: 15px; }
                        .card { border: 1px dashed #ccc; border-radius: 8px; padding: 25px; max-width: 450px; margin: 0 auto; background: #fff; line-height: 1.6; }
                        .grid { display: flex; flex-wrap: wrap; margin-top: 15px; }
                        .col-6 { width: 50%; margin-bottom: 15px; }
                        .col-12 { width: 100%; margin-bottom: 15px; }
                        .label { font-size: 10px; text-transform: uppercase; font-weight: bold; color: #2563eb; display: block; letter-spacing: 1px; }
                        .val { font-size: 15px; font-weight: bold; color: #0f172a; margin-top: 2px; }
                        .val-mono { font-family: monospace; letter-spacing: 1px; font-size: 15px; }
                        .badge { display: inline-block; padding: 3px 8px; border-radius: 4px; font-size: 10px; font-weight: bold; background: #2563EB; color: white; letter-spacing: 1px; margin-top: 4px; }
                        .badge-warning { background: #fef08a; color: #854d0e; border: 1px solid #fde047; }
                        .footer { text-align: center; margin-top: 30px; font-size: 11px; color: #64748b; font-style: italic; }
                        @media print { 
                            .card { border: 2px dashed #999; -webkit-print-color-adjust: exact; print-color-adjust: exact; } 
                        }
                    </style>
                </head>
                <body>
                    <h2>KREDENSIAL LOGIN POSYANDU</h2>
                    <div class="card">${content.replace(/class="[^"]*"/g, '').replace('Nama Lengkap', '<div class="col-12"><span class="label">Nama Lengkap</span>').replace('Username (NIK)', '</div><div class="grid"><div class="col-6"><span class="label">Username (NIK)</span>').replace('Role', '</div><div class="col-6"><span class="label">Role</span>').replace('Password Sementara', '</div></div><div class="grid"><div class="col-6"><span class="label">Password</span>').replace('Status Login', '</div><div class="col-6"><span class="label">Status</span>').replace('WARGA', '<span class="badge">WARGA</span>').replace('Belum Login', '<span class="badge badge-warning">Belum Login</span>')}</div></div>
                    <p class="footer"><strong>PERHATIAN:</strong><br/>Dokumen ini rahasia. Wajib mengubah password segera setelah login berhasil.</p>
                    <script>
                        setTimeout(() => {
                            window.print();
                            setTimeout(() => window.close(), 500);
                        }, 250);
                    <\/script>
                </body>
            </html>
        `);
        printWindow.document.close();
    }
    @endif

    // Real-time search (debounce 500ms)

    // Confirm reject with SweetAlert2
    function confirmReject(id, name) {
        Swal.fire({
            title: 'Tolak Verifikasi?',
            text: `Silakan berikan alasan penolakan untuk warga ${name}:`,
            input: 'textarea',
            inputPlaceholder: 'Tulis alasan minimal 10 karakter...',
            inputAttributes: { 'aria-label': 'Ketik alasan penolakan Anda di sini' },
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#F59E0B',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Ya, Tolak!',
            cancelButtonText: 'Batal',
            preConfirm: (reason) => {
                if (!reason || reason.length < 10) {
                    Swal.showValidationMessage('Mohon isi alasan penolakan minimal 10 karakter');
                }
                return reason;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('reject-reason-' + id).value = result.value;
                document.getElementById('reject-form-' + id).submit();
            }
        });
    }
</script>
@endpush
@endsection