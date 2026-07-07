{{-- resources/views/pegawai/reproduksi/wus-show.blade.php --}}

@extends('layouts.app')

@section('title', 'Detail WUS - Pegawai')

@section('page-title', '👩 Detail WUS')
@section('page-subtitle', 'Informasi lengkap data WUS dan riwayat pelayanan')

@section('content')
<div class="space-y-6">
    {{-- Profile Card --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden">
        <div class="p-6">
            <div class="flex flex-col md:flex-row items-center gap-6">
                <div class="flex-shrink-0">
                    <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-teal-100 dark:border-teal-900/30">
                        <img src="{{ $wus->foto_url }}" alt="{{ $wus->nama }}" class="w-full h-full object-cover">
                    </div>
                </div>
                <div class="flex-1 text-center md:text-left">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $wus->nama }}</h2>
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-2 mt-2">
                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                            NIK: {{ $wus->nik }}
                        </span>
                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400">
                            {{ $wus->umur }} tahun
                        </span>
                        @if($wus->is_verified)
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400">✅ Terverifikasi</span>
                        @else
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400">⏳ Pending</span>
                        @endif
                    </div>
                    <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Status Pernikahan</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $wus->status_pernikahan ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Golongan Darah</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $wus->golongan_darah ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Status Anemia</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $wus->status_anemia ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Alamat</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $wus->alamat ?? '-' }}</p>
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2">
                    @if(!$wus->is_verified)
                        <form action="{{ route('pegawai.reproduksi.wus.verify', $wus) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg transition duration-150 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Verifikasi
                            </button>
                        </form>
                    @endif
                    <a href="{{ route('pegawai.reproduksi.pelayanan.create', $wus) }}" 
                       class="px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg transition duration-150 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Pelayanan
                    </a>
                    <a href="{{ route('pegawai.reproduksi.konseling.create', $wus) }}" 
                       class="px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg transition duration-150 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        Konseling
                    </a>
                    <a href="{{ route('pegawai.reproduksi.kontrol.create', $wus) }}" 
                       class="px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg transition duration-150 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Jadwal Kontrol
                    </a>
                    <a href="{{ route('pegawai.reproduksi.wus.index') }}" 
                       class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition duration-150">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Data PUS --}}
    @if($wus->pus)
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Data PUS</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Nama Pasangan</p>
                    <p class="font-medium text-gray-900 dark:text-white">{{ $wus->pus->nama_pasangan }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Jumlah Anak</p>
                    <p class="font-medium text-gray-900 dark:text-white">{{ $wus->pus->jumlah_anak }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Status KB</p>
                    <p class="font-medium text-gray-900 dark:text-white">{{ $wus->pus->status_kb_label }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Jenis Kontrasepsi</p>
                    <p class="font-medium text-gray-900 dark:text-white">{{ $wus->pus->jenis_kontrasepsi ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Jadwal Kontrol</p>
                    <p class="font-medium text-gray-900 dark:text-white">{{ $wus->pus->jadwal_kontrol ? $wus->pus->jadwal_kontrol->format('d M Y') : '-' }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Riwayat Pelayanan --}}
    @if($wus->pelayanan->count() > 0)
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Riwayat Pelayanan</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jenis</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kontrasepsi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kontrol Berikutnya</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pegawai</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($wus->pelayanan as $item)
                        <tr>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $item->tanggal->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $item->jenis_pelayanan_label }}</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $item->jenis_kontrasepsi ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $item->jadwal_kontrol_berikutnya ? $item->jadwal_kontrol_berikutnya->format('d M Y') : '-' }}</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $item->user->name }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('pegawai.reproduksi.pelayanan.edit', $item) }}" 
                                       class="text-yellow-600 hover:text-yellow-700 dark:text-yellow-400 dark:hover:text-yellow-300">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('pegawai.reproduksi.pelayanan.destroy', $item) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- Jadwal Kontrol --}}
    @if($wus->jadwalKontrol->count() > 0)
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Jadwal Kontrol</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jam</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Lokasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($wus->jadwalKontrol as $item)
                        <tr>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $item->tanggal->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ date('H:i', strtotime($item->jam)) }}</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $item->lokasi }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $item->status_badge }}">
                                    {{ $item->status_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('pegawai.reproduksi.kontrol.edit', $item) }}" 
                                       class="text-yellow-600 hover:text-yellow-700 dark:text-yellow-400 dark:hover:text-yellow-300">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('pegawai.reproduksi.kontrol.destroy', $item) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection