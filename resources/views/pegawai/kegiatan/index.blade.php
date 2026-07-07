{{-- resources/views/pegawai/kegiatan/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Daftar Kegiatan Posyandu - Sistem Informasi Posyandu')

@section('page-title', 'Daftar Kegiatan Posyandu')
@section('page-subtitle', 'Lihat daftar kegiatan Posyandu yang telah dijadwalkan oleh Admin')

@section('content')
<div class="space-y-6">

    {{-- Table --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kegiatan</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal & Waktu</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Lokasi / Posyandu</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($kegiatan as $item)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            <td class="px-6 py-4">
                                <p class="font-medium text-gray-900 dark:text-white">{{ $item->nama_kegiatan }}</p>
                                <p class="text-xs text-gray-500">{{ $item->deskripsi ? Str::limit($item->deskripsi, 50) : '-' }}</p>
                                <div class="mt-1 flex flex-wrap gap-1">
                                    @if(is_array($item->jenis_pelayanan))
                                        @foreach($item->jenis_pelayanan as $jp)
                                            <span class="px-2 py-0.5 text-xs bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300 rounded">{{ $jp }}</span>
                                        @endforeach
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                <div>{{ $item->tanggal->format('d M Y') }}</div>
                                <div class="text-xs">{{ $item->jam_mulai->format('H:i') }} - {{ $item->jam_selesai->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900 dark:text-white">{{ $item->posyandu ?: $item->lokasi }}</div>
                                <div class="text-xs text-gray-500">{{ $item->posyandu ? $item->lokasi : '' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusColors = [
                                        'Draft' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                        'Terjadwal' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300',
                                        'Berlangsung' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300',
                                        'Selesai' => 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300',
                                        'Dibatalkan' => 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300',
                                    ];
                                    $colorClass = $statusColors[$item->status] ?? $statusColors['Draft'];
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $colorClass }}">{{ $item->status }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('pegawai.kegiatan.show', $item->id) }}" class="text-blue-600 hover:text-blue-700 flex items-center justify-end gap-1 text-sm font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">Belum ada kegiatan terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $kegiatan->links() }}
        </div>
    </div>
</div>
@endsection
