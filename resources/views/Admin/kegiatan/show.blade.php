{{-- resources/views/Admin/kegiatan/show.blade.php --}}

@extends('layouts.app')

@section('title', 'Detail Kegiatan - ' . $kegiatan->nama_kegiatan)
@section('page-title', 'Detail Kegiatan Posyandu')
@section('page-subtitle', $kegiatan->nama_kegiatan)

@section('content')
<div class="space-y-6">
    {{-- Header Content --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $kegiatan->nama_kegiatan }}</h2>
                <div class="text-gray-500 flex items-center gap-2 mt-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    {{ $kegiatan->posyandu ?: $kegiatan->lokasi }}
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                @if(auth()->user()->role === 'admin')
                <form action="{{ route('admin.kegiatan.update-status', $kegiatan->id) }}" method="POST" class="flex items-center gap-2">
                    @csrf
                    @method('PATCH')
                    <select name="status" onchange="this.form.submit()" class="text-sm px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 dark:text-white focus:ring-yellow-500">
                        @foreach(['Draft', 'Terjadwal', 'Berlangsung', 'Selesai', 'Dibatalkan'] as $st)
                            <option value="{{ $st }}" {{ $kegiatan->status === $st ? 'selected' : '' }}>{{ $st }}</option>
                        @endforeach
                    </select>
                </form>

                <a href="{{ route('admin.kegiatan.edit', $kegiatan->id) }}" class="px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg flex items-center gap-1 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    Edit
                </a>
                @endif
            </div>
        </div>
    </div>

    {{-- Detail & Statistik Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Kolom Informasi --}}
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
                <h3 class="font-bold text-gray-800 dark:text-white text-lg mb-4 pb-2 border-b dark:border-gray-700">Informasi Kegiatan</h3>
                <dl class="space-y-4 text-sm text-gray-600 dark:text-gray-300">
                    <div>
                        <dt class="font-semibold text-gray-900 dark:text-gray-100">Waktu Pelaksanaan</dt>
                        <dd class="mt-1 flex items-center gap-2">
                            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            {{ $kegiatan->tanggal->format('d F Y') }} <br>
                            {{ $kegiatan->jam_mulai->format('H:i') }} - {{ $kegiatan->jam_selesai->format('H:i') }} WIB
                        </dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-gray-900 dark:text-gray-100">Jenis Pelayanan</dt>
                        <dd class="mt-1 flex flex-wrap gap-1">
                            @if(is_array($kegiatan->jenis_pelayanan))
                                @foreach($kegiatan->jenis_pelayanan as $jp)
                                    <span class="px-2 py-1 bg-yellow-100 dark:bg-yellow-900/50 text-yellow-800 dark:text-yellow-300 rounded text-xs">{{ $jp }}</span>
                                @endforeach
                            @else
                                -
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-gray-900 dark:text-gray-100">Target Peserta</dt>
                        <dd class="mt-1">{{ $kegiatan->target_peserta ?: '-' }}</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-gray-900 dark:text-gray-100">Deskripsi</dt>
                        <dd class="mt-1 bg-gray-50 dark:bg-gray-700 p-3 rounded">{{ $kegiatan->deskripsi ?: 'Tidak ada deskripsi.' }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        {{-- Kolom Statistik --}}
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 h-full">
                <h3 class="font-bold text-gray-800 dark:text-white text-lg mb-6 pb-2 border-b dark:border-gray-700">Statistik Kehadiran & Pelayanan</h3>
                
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    {{-- Card Terdaftar --}}
                    <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-xl border border-blue-100 dark:border-blue-800">
                        <div class="text-blue-500 text-sm font-semibold mb-1">Peserta Terdaftar</div>
                        <div class="text-3xl font-bold text-blue-900 dark:text-blue-100">{{ $pesertaTerdaftar }}</div>
                    </div>
                    
                    {{-- Card Hadir --}}
                    <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-xl border border-green-100 dark:border-green-800">
                        <div class="text-green-500 text-sm font-semibold mb-1">Hadir</div>
                        <div class="text-3xl font-bold text-green-900 dark:text-green-100">{{ $jumlahHadir }}</div>
                    </div>

                    {{-- Card Belum Hadir --}}
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-xl border border-gray-200 dark:border-gray-600">
                        <div class="text-gray-500 dark:text-gray-400 text-sm font-semibold mb-1">Belum Hadir</div>
                        <div class="text-3xl font-bold text-gray-700 dark:text-gray-300">{{ $jumlahBelumHadir }}</div>
                    </div>

                    {{-- Card Sudah Dilayani --}}
                    <div class="bg-indigo-50 dark:bg-indigo-900/20 p-4 rounded-xl border border-indigo-100 dark:border-indigo-800">
                        <div class="text-indigo-500 text-sm font-semibold mb-1">Sudah Dilayani</div>
                        <div class="text-3xl font-bold text-indigo-900 dark:text-indigo-100">{{ $jumlahSudahDilayani }}</div>
                    </div>

                    {{-- Card Menunggu --}}
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded-xl border border-yellow-100 dark:border-yellow-800">
                        <div class="text-yellow-500 text-sm font-semibold mb-1">Belum Dilayani</div>
                        <div class="text-3xl font-bold text-yellow-900 dark:text-yellow-100">{{ $jumlahBelumDilayani }}</div>
                    </div>
                </div>

                <div class="mt-8 border-t dark:border-gray-700 pt-6">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Dibuat oleh: <span class="font-medium text-gray-700 dark:text-gray-300">{{ $kegiatan->user?->name ?: 'Admin' }}</span></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
