{{-- resources/views/pegawai/lansia/jadwal-senam/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Jadwal Senam Lansia - Sistem Informasi Posyandu')
@section('page-title', '🏃‍♂️ Jadwal Senam Lansia')
@section('page-subtitle', 'Kelola jadwal senam dan instruktur untuk Posyandu Lansia')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
    
    <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <form action="{{ route('pegawai.lansia.jadwal.index') }}" method="GET" class="flex items-center gap-3 w-full sm:w-auto">
            <select name="status" onchange="this.form.submit()" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                <option value="">Semua Status</option>
                <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="batal" {{ request('status') === 'batal' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
            @if(request('status'))
                <a href="{{ route('pegawai.lansia.jadwal.index') }}" class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">Reset</a>
            @endif
        </form>
        
        <a href="{{ route('pegawai.lansia.jadwal.create') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-[#036672] hover:bg-[#036672] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 w-full sm:w-auto">
            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Jadwal
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700/50">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">No</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal & Waktu</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Lokasi</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Instruktur</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kuota</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($jadwal as $index => $item)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500 dark:text-gray-400">{{ $jadwal->firstItem() + $index }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-bold text-gray-900 dark:text-white">{{ $item->tanggal->format('d M Y') }}</div>
                            <div class="text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::parse($item->jam)->format('H:i') }} WIB</div>
                        </td>
                        <td class="px-6 py-4 text-gray-900 dark:text-white">{{ $item->lokasi }}</td>
                        <td class="px-6 py-4 text-gray-900 dark:text-white">{{ $item->instruktur ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-900 dark:text-white">{{ $item->kuota }} orang</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusColor = match($item->status) {
                                    'aktif' => 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300',
                                    'selesai' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                    'batal' => 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300',
                                    default => 'bg-gray-100 text-gray-800',
                                };
                            @endphp
                            <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end items-center space-x-3">
                                <a href="{{ route('pegawai.lansia.jadwal.edit', $item) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300" title="Edit">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('pegawai.lansia.jadwal.destroy', $item) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" title="Hapus">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center">
                            <div class="mx-auto w-16 h-16 bg-gray-100 dark:bg-gray-700/50 rounded-full flex items-center justify-center mb-3 text-2xl">🏃</div>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Tidak ada jadwal senam</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Belum ada jadwal senam lansia yang ditambahkan.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($jadwal->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $jadwal->links() }}
        </div>
    @endif
</div>
@endsection
