{{-- resources/views/components/public/schedule/card.blade.php --}}

@props(['kegiatan'])

<div class="group bg-gray-50 dark:bg-gray-700/50 rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition duration-300">
    {{-- Header --}}
    <div class="relative p-4 bg-gradient-to-r from-teal-500 to-blue-500">
        <div class="flex items-center justify-between">
            <span class="text-white text-sm font-medium">{{ $kegiatan->tanggal_formatted }}</span>
            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $kegiatan->status_badge }}">
                {{ $kegiatan->status_label }}
            </span>
        </div>
        <div class="mt-1 text-teal-100 text-xs">
            <span class="inline-block mr-3">{{ $kegiatan->hari }}</span>
            <span>{{ $kegiatan->jam_range }}</span>
        </div>
    </div>

    {{-- Body --}}
    <div class="p-5">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2">
            {{ $kegiatan->nama_kegiatan }}
        </h3>

        <div class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
            <div class="flex items-start">
                <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span class="line-clamp-1">{{ $kegiatan->lokasi }}</span>
            </div>

            <div class="flex items-start">
                <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span>{{ $kegiatan->penanggung_jawab }}</span>
            </div>

            @if($kegiatan->kuota)
                <div class="flex items-start">
                    <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <span>
                        Peserta: {{ $kegiatan->jumlah_peserta }}
                        @if($kegiatan->kuota)
                            / {{ $kegiatan->kuota }}
                            <span class="text-xs text-gray-400">
                                (Sisa: {{ $kegiatan->sisa_kuota }})
                            </span>
                        @endif
                    </span>
                </div>
            @endif
        </div>

        {{-- Actions --}}
        <div class="mt-4 flex flex-wrap gap-2">
            <a href="{{ route('public.schedule.detail', $kegiatan->id) }}" 
               class="flex-1 text-center px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white text-sm font-medium rounded-lg transition duration-150">
                Lihat Detail
            </a>

            @auth
                @if($kegiatan->status === 'terjadwal' || $kegiatan->status === 'berlangsung')
                    @if($kegiatan->is_user_terdaftar)
                        <button onclick="batalkanKonfirmasi({{ $kegiatan->id }})"
                                class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 text-sm font-medium rounded-lg transition duration-150">
                            Batalkan
                        </button>
                    @else
                        @if($kegiatan->is_penuh)
                            <button disabled
                                    class="px-4 py-2 bg-gray-300 text-gray-500 text-sm font-medium rounded-lg cursor-not-allowed">
                                Penuh
                            </button>
                        @else
                            <button onclick="konfirmasiKehadiran({{ $kegiatan->id }})"
                                    class="px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white text-sm font-medium rounded-lg transition duration-150">
                                Saya Akan Hadir
                            </button>
                        @endif
                    @endif
                @endif
            @else
                <a href="{{ route('login') }}" 
                   class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition duration-150">
                    Login untuk Konfirmasi
                </a>
            @endauth
        </div>

        @if($kegiatan->is_user_terdaftar)
            <p class="mt-2 text-xs text-green-600 dark:text-green-400">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Anda telah terdaftar untuk kegiatan ini.
            </p>
        @endif
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