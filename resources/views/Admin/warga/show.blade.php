{{-- resources/views/warga/show.blade.php --}}

@extends('layouts.app')

@section('title', 'Detail Warga - Sistem Informasi Posyandu')

@section('page-title', 'Detail Warga')
@section('page-subtitle', 'Informasi lengkap data warga')

@section('content')
    <div class="space-y-6">
        <!-- Profile Header -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <div class="flex flex-col md:flex-row items-center gap-6">
                    <!-- Foto -->
                    <div class="flex-shrink-0">
                        <div
                            class="w-32 h-32 rounded-full overflow-hidden border-4 border-blue-100 dark:border-blue-900/30">
                            <img src="{{ $warga->foto_url }}" alt="{{ $warga->nama }}" class="w-full h-full object-cover">
                        </div>
                    </div>

                    <!-- Info -->
                    <div class="flex-1 text-center md:text-left">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $warga->nama }}</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">NIK: {{ $warga->nik }}</p>
                        <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 mt-2">
                            <span
                                class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400">
                                Aktif
                            </span>
                            <span class="text-sm text-gray-600 dark:text-gray-400">
                                <span class="font-medium">Kader:</span> {{ $warga->user->name }}
                            </span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route($routePrefix . 'edit', $warga) }}"
                            class="px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white text-sm font-medium rounded-lg transition duration-150 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit
                        </a>
                        <button onclick="window.print()"
                            class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition duration-150 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            Cetak
                        </button>
                        <a href="{{ route($routePrefix . 'index') }}"
                            class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg transition duration-150 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Informasi Identitas -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informasi Identitas</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">NIK</p>
                                <p class="font-medium text-gray-900 dark:text-white font-mono">{{ $warga->nik }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Nama Lengkap</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $warga->nama }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Tempat Lahir</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $warga->tempat_lahir }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Tanggal Lahir</p>
                                <p class="font-medium text-gray-900 dark:text-white">
                                    {{ $warga->tanggal_lahir->format('d M Y') }}
                                    <span class="text-sm text-gray-500 dark:text-gray-400">({{ $warga->umur }} tahun)</span>
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Jenis Kelamin</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $warga->jenis_kelamin_label }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Agama</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $warga->agama ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Status Perkawinan</p>
                                <p class="font-medium text-gray-900 dark:text-white">
                                    {{ $warga->status_perkawinan_label ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Pekerjaan</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $warga->pekerjaan ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alamat -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Alamat</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-2">
                            @if($warga->alamat)
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Alamat</p>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $warga->alamat }}</p>
                                </div>
                            @endif
                            @if($warga->rt || $warga->rw)
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">RT/RW</p>
                                    <p class="font-medium text-gray-900 dark:text-white">
                                        @if($warga->rt) RT. {{ $warga->rt }} @endif
                                        @if($warga->rw) RW. {{ $warga->rw }} @endif
                                    </p>
                                </div>
                            @endif
                            @if($warga->desa)
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Kelurahan/Desa</p>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $warga->desa }}</p>
                                </div>
                            @endif
                            @if($warga->kecamatan)
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Kecamatan</p>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $warga->kecamatan }}</p>
                                </div>
                            @endif
                            @if($warga->kabupaten)
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Kabupaten/Kota</p>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $warga->kabupaten }}</p>
                                </div>
                            @endif
                            @if($warga->provinsi)
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Provinsi</p>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $warga->provinsi }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Data Balita -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Data Balita</h3>
                        <a href="{{ route(Auth::user()->role . '.balita.create', ['warga_id' => $warga->id]) }}"
                            class="px-3 py-1.5 bg-[#036672] hover:bg-[#036672] text-white text-sm rounded-lg transition duration-150 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Balita
                        </a>
                    </div>
                    <div class="p-6">
                        @if($warga->balita->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($warga->balita as $balita)
                                    <div
                                        class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150">
                                        <div class="flex items-center gap-3">
                                            <div class="flex-shrink-0">
                                                <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-100 dark:bg-gray-700">
                                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($balita->nama) }}&color=7F9CF5&background=EBF4FF&size=48"
                                                        alt="{{ $balita->nama }}" class="w-full h-full object-cover">
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="font-medium text-gray-900 dark:text-white">{{ $balita->nama }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $balita->umur_bulan }} bulan • {{ $balita->jenis_kelamin_label }}
                                                </p>
                                                @if($balita->pelayanan->first())
                                                    <span
                                                        class="inline-block mt-1 px-2 py-0.5 text-xs font-medium rounded-full 
                                                                    @if($balita->pelayanan->first()->status_gizi === 'normal') bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400
                                                                    @elseif($balita->pelayanan->first()->status_gizi === 'kurang') bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400
                                                                    @elseif($balita->pelayanan->first()->status_gizi === 'buruk') bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400
                                                                    @else bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400 @endif">
                                                        {{ $balita->pelayanan->first()->status_gizi_label }}
                                                    </span>
                                                @endif
                                            </div>
                                            <a href="{{ route(Auth::user()->role . '.balita.show', $balita) }}"
                                                class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 5l7 7-7 7" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="w-16 h-16 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400">Belum ada data balita</p>
                                <a href="{{ route(Auth::user()->role . '.balita.create', ['warga_id' => $warga->id]) }}"
                                    class="mt-3 inline-block px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white text-sm rounded-lg transition duration-150">
                                    Tambah Balita Pertama
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Riwayat Kegiatan -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Riwayat Kegiatan Posyandu</h3>
                    </div>
                    <div class="p-6">
                        @php
                            $riwayat = $warga->balita->flatMap(function ($balita) {
                                return $balita->pelayanan;
                            })->sortByDesc('created_at')->take(10);
                        @endphp

                        @if($riwayat->count() > 0)
                            <div class="space-y-3">
                                @foreach($riwayat as $pelayanan)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                        <div>
                                            <p class="font-medium text-gray-900 dark:text-white">
                                                {{ $pelayanan->kegiatan->nama_kegiatan }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $pelayanan->created_at->format('d M Y') }} •
                                                {{ $pelayanan->balita->nama }}
                                            </p>
                                        </div>
                                        <span
                                            class="px-2 py-1 text-xs font-medium rounded-full 
                                                    @if($pelayanan->status_gizi === 'normal') bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400
                                                    @elseif($pelayanan->status_gizi === 'kurang') bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400
                                                    @elseif($pelayanan->status_gizi === 'buruk') bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400
                                                    @else bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400 @endif">
                                            {{ $pelayanan->status_gizi_label }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-500 dark:text-gray-400">Belum ada riwayat kegiatan</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar Kanan -->
            <div class="space-y-6">
                <!-- Ringkasan -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Ringkasan</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Jumlah Balita</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['jumlah_balita'] }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Total Kehadiran</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['kehadiran'] }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Pelayanan Terakhir</p>
                            @if($stats['pelayanan_terakhir'])
                                <p class="font-medium text-gray-900 dark:text-white">
                                    {{ $stats['pelayanan_terakhir']->created_at->format('d M Y') }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $stats['pelayanan_terakhir']->kegiatan->nama_kegiatan ?? '-' }}
                                </p>
                            @else
                                <p class="text-gray-500 dark:text-gray-400">Belum ada pelayanan</p>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Kader</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $warga->user->name }}</p>
                        </div>
                    </div>
                </div>

                <!-- Kontak Darurat -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Kontak</h3>
                    </div>
                    <div class="p-6 space-y-3">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Nomor HP</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $warga->telepon }}</p>
                        </div>
                        @if($warga->email)
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Email</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $warga->email }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection