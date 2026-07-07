{{-- resources/views/pegawai/reproduksi/jadwal-kontrol.blade.php --}}

@extends('layouts.app')

@section('title', 'Jadwal Kontrol - Pegawai')

@section('page-title', '📅 Jadwal Kontrol WUS & PUS')
@section('page-subtitle', 'Daftar pengingat untuk pelayanan kesehatan selanjutnya')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden">
    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
        <form method="GET" action="{{ route('pegawai.reproduksi.kontrol.index') }}" class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari berdasarkan nama WUS..."
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-teal-500 focus:border-teal-500 dark:bg-gray-700 dark:text-white">
            </div>
            <div>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-teal-500 focus:border-teal-500 dark:bg-gray-700 dark:text-white">
                    <option value="">Semua Status</option>
                    <option value="terjadwal" {{ request('status') == 'terjadwal' ? 'selected' : '' }}>Terjadwal</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="terlewat" {{ request('status') == 'terlewat' ? 'selected' : '' }}>Terlewat</option>
                </select>
            </div>
            <button type="submit" class="px-6 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg transition">Filter</button>
        </form>
    </div>
    
    <div class="overflow-x-auto p-0">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="px-6 py-3">Nama WUS</th>
                    <th class="px-6 py-3">Tanggal Kontrol</th>
                    <th class="px-6 py-3">Jam & Lokasi</th>
                    <th class="px-6 py-3">Tujuan</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jadwalKontrol as $item)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                        <a href="{{ route('pegawai.reproduksi.wus.show', $item->wus_id) }}" class="text-blue-600 hover:underline">{{ $item->wus->nama }}</a>
                    </td>
                    <td class="px-6 py-4">{{ $item->tanggal->format('d M Y') }}</td>
                    <td class="px-6 py-4">{{ date('H:i', strtotime($item->jam)) }} - {{ $item->lokasi }}</td>
                    <td class="px-6 py-4">{{ $item->keterangan ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $item->status_badge }}">
                            {{ $item->status_label }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('pegawai.reproduksi.kontrol.edit', $item) }}" class="text-yellow-600 hover:text-yellow-800">Edit</a>
                        <form action="{{ route('pegawai.reproduksi.kontrol.destroy', $item) }}" method="POST" class="inline ml-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Hapus jadwal ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center">Tidak ada jadwal kontrol.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
        {{ $jadwalKontrol->links() }}
    </div>
</div>
@endsection
