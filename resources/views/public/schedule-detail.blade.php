{{-- resources/views/public/schedule-detail.blade.php --}}

@extends('layouts.public')

@section('title', $kegiatan->nama_kegiatan . ' - Jadwal Posyandu')
@section('description', 'Detail kegiatan ' . $kegiatan->nama_kegiatan . ' di Posyandu')

@section('content')
<div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Breadcrumb --}}
        <nav class="flex items-center text-sm text-gray-600 dark:text-gray-400 mb-6" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-teal-600 dark:hover:text-teal-400 transition duration-150">Beranda</a>
            <span class="mx-2">/</span>
            <a href="{{ route('public.schedule') }}" class="hover:text-teal-600 dark:hover:text-teal-400 transition duration-150">Jadwal Posyandu</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900 dark:text-white font-medium">{{ $kegiatan->nama_kegiatan }}</span>
        </nav>

        {{-- Card --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
            {{-- Header --}}
            <div class="bg-gradient-to-r from-teal-600 to-blue-600 p-6 text-white">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <h1 class="text-2xl font-bold">{{ $kegiatan->nama_kegiatan }}</h1>
                    <span class="px-3 py-1 text-sm font-medium rounded-full {{ $kegiatan->status_badge }}">
                        {{ $kegiatan->status_label }}
                    </span>
                </div>
                <p class="text-teal-100 mt-2">
                    {{ $kegiatan->tanggal_full }} • {{ $kegiatan->jam_range }}
                </p>
            </div>

            {{-- Body --}}
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Informasi --}}
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Lokasi</p>
                            <p class="font-medium text-gray-900 dark:text-white flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $kegiatan->lokasi }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Penanggung Jawab</p>
                            <p class="font-medium text-gray-900 dark:text-white flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                {{ $kegiatan->penanggung_jawab }}
                            </p>
                        </div>

                        @if($kegiatan->kuota)
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Kuota Peserta</p>
                                <p class="font-medium text-gray-900 dark:text-white flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                    {{ $kegiatan->jumlah_peserta }} / {{ $kegiatan->kuota }}
                                    <span class="ml-2 text-sm text-gray-500">
                                        (Sisa: {{ $kegiatan->sisa_kuota }})
                                    </span>
                                </p>
                            </div>
                        @endif
                    </div>

                    {{-- Actions --}}
                    <div class="flex flex-col items-start md:items-end justify-center space-y-3">
                        @auth
                            @if($kegiatan->status === 'terjadwal' || $kegiatan->status === 'berlangsung')
                                @if($kegiatan->is_user_terdaftar)
                                    <button onclick="batalkanKonfirmasi({{ $kegiatan->id }})"
                                            class="px-6 py-2 bg-[#036672] hover:bg-[#036672] text-white font-medium rounded-lg transition duration-150">
                                        Batalkan Konfirmasi
                                    </button>
                                    <p class="text-sm text-green-600 dark:text-green-400">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Anda telah terdaftar
                                    </p>
                                @else
                                    @if($kegiatan->is_penuh)
                                        <button disabled
                                                class="px-6 py-2 bg-gray-300 text-gray-500 font-medium rounded-lg cursor-not-allowed">
                                            Kuota Penuh
                                        </button>
                                    @else
                                        <button onclick="konfirmasiKehadiran({{ $kegiatan->id }})"
                                                class="px-6 py-2 bg-[#036672] hover:bg-[#036672] text-white font-medium rounded-lg transition duration-150">
                                            Saya Akan Hadir
                                        </button>
                                    @endif
                                @endif
                            @endif
                        @else
                            <a href="{{ route('login') }}" 
                               class="px-6 py-2 bg-[#036672] hover:bg-[#036672] text-white font-medium rounded-lg transition duration-150">
                                Login untuk Konfirmasi
                            </a>
                        @endauth

                        <a href="{{ route('public.schedule') }}" 
                           class="px-6 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-lg transition duration-150">
                            Kembali ke Jadwal
                        </a>
                    </div>
                </div>

                {{-- Deskripsi --}}
                @if($kegiatan->deskripsi)
                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Deskripsi</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">{{ $kegiatan->deskripsi }}</p>
                    </div>
                @endif

                {{-- Google Maps --}}
                @if($kegiatan->google_maps_embed)
                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Lokasi Peta</h3>
                        <div class="rounded-xl overflow-hidden shadow-md h-64">
                            {!! $kegiatan->google_maps_embed !!}
                        </div>
                    </div>
                @endif

                {{-- Daftar Peserta --}}
                @if($kegiatan->kehadiran->count() > 0 && Auth::check() && Auth::user()->role === 'admin')
                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Daftar Peserta</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="text-left border-b border-gray-200 dark:border-gray-700">
                                        <th class="pb-2 font-medium text-gray-500 dark:text-gray-400">Nama</th>
                                        <th class="pb-2 font-medium text-gray-500 dark:text-gray-400">Status</th>
                                        <th class="pb-2 font-medium text-gray-500 dark:text-gray-400">Konfirmasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($kegiatan->kehadiran as $kehadiran)
                                        <tr class="border-b border-gray-100 dark:border-gray-700">
                                            <td class="py-2 text-gray-900 dark:text-white">{{ $kehadiran->user->name }}</td>
                                            <td class="py-2">
                                                <span class="px-2 py-1 text-xs font-medium rounded-full 
                                                    @if($kehadiran->status === 'terdaftar') bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400
                                                    @elseif($kehadiran->status === 'hadir') bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400
                                                    @else bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 @endif">
                                                    {{ $kehadiran->status_label }}
                                                </span>
                                            </td>
                                            <td class="py-2 text-gray-500 dark:text-gray-400">
                                                {{ $kehadiran->konfirmasi_at ? $kehadiran->konfirmasi_at->format('d M Y H:i') : '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function konfirmasiKehadiran(id) {
        Swal.fire({
            title: 'Konfirmasi Kehadiran',
            text: 'Apakah Anda yakin akan hadir dalam kegiatan ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10B981',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Ya, Saya Hadir!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/jadwal-posyandu/${id}/konfirmasi`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message,
                            timer: 2000,
                            showConfirmButton: false,
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: data.message,
                        });
                    }
                });
            }
        });
    }

    function batalkanKonfirmasi(id) {
        Swal.fire({
            title: 'Batalkan Konfirmasi?',
            text: 'Apakah Anda yakin ingin membatalkan konfirmasi kehadiran?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Ya, Batalkan!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/jadwal-posyandu/${id}/batal`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message,
                            timer: 2000,
                            showConfirmButton: false,
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: data.message,
                        });
                    }
                });
            }
        });
    }
</script>
@endpush
@endsection