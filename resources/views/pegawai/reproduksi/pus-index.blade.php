{{-- resources/views/pegawai/reproduksi/pus-index.blade.php --}}

@extends('layouts.app')

@section('title', 'Data PUS - Pegawai')

@section('page-title', '👫 Data Pasangan Usia Subur (PUS)')
@section('page-subtitle', 'Kelola daftar pasangan usia subur dan status KB mereka.')

@section('content')
<div class="space-y-6">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6">
        <form method="GET" action="{{ route('pegawai.reproduksi.pus.index') }}" class="flex flex-col sm:flex-row gap-4 mb-6">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari nama pasangan..."
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-teal-500 focus:border-teal-500 dark:bg-gray-700 dark:text-white">
            </div>
            <div>
                <select name="status_kb" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-teal-500 focus:border-teal-500 dark:bg-gray-700 dark:text-white">
                    <option value="">Semua Status KB</option>
                    <option value="aktif" {{ request('status_kb') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak_aktif" {{ request('status_kb') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    <option value="berhenti" {{ request('status_kb') == 'berhenti' ? 'selected' : '' }}>Berhenti</option>
                </select>
            </div>
            <button type="submit" class="px-6 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg transition">Filter</button>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-3">Nama Pasangan (Suami)</th>
                        <th class="px-6 py-3">Istri (WUS)</th>
                        <th class="px-6 py-3">Jml Anak</th>
                        <th class="px-6 py-3">Status KB</th>
                        <th class="px-6 py-3">Jenis Kontrasepsi</th>
                        <th class="px-6 py-3">Jadwal Kontrol</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pus as $item)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $item->nama_pasangan }}</td>
                            <td class="px-6 py-4">{{ $item->wus->nama ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $item->jumlah_anak }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-medium rounded-full 
                                    @if($item->status_kb === 'aktif') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                    @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 @endif">
                                    {{ $item->status_kb_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4">{{ $item->jenis_kontrasepsi ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $item->jadwal_kontrol ? $item->jadwal_kontrol->format('d M Y') : '-' }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('pegawai.reproduksi.pus.show', $item) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center py-8">Tidak ada data PUS.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $pus->links() }}
        </div>
    </div>
</div>
@endsection
