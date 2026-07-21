{{-- resources/views/warga/lansia/index.blade.php --}}

@extends('layouts.public')

@section('hide-footer', true)
@section('title', 'Posyandu Lansia - Sistem Informasi Posyandu')
@section('page-title', '👴 Posyandu Lansia')
@section('page-subtitle', 'Pantau kesehatan lansia secara berkala melalui layanan Posyandu.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

    {{-- ============================================================
         RINGKASAN KESEHATAN
    ============================================================ --}}
    <div>
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
            <span class="text-xl">📊</span> Ringkasan Kesehatan
        </h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-7 gap-3">
            @php
                $cards = [
                    ['label' => 'Tekanan Darah', 'value' => $stats['tekanan_darah'], 'unit' => 'mmHg', 'icon' => '🩺', 'color' => 'red'],
                    ['label' => 'Gula Darah',    'value' => $stats['gula_darah'],    'unit' => 'mg/dL','icon' => '🩸', 'color' => 'orange'],
                    ['label' => 'Kolesterol',     'value' => $stats['kolesterol'],    'unit' => 'mg/dL','icon' => '💊', 'color' => 'yellow'],
                    ['label' => 'Berat Badan',    'value' => $stats['berat_badan'],   'unit' => 'kg',   'icon' => '⚖️', 'color' => 'blue'],
                    ['label' => 'Tinggi Badan',   'value' => $stats['tinggi_badan'],  'unit' => 'cm',   'icon' => '📏', 'color' => 'purple'],
                    ['label' => 'IMT',            'value' => $stats['imt'],           'unit' => '',     'icon' => '📈', 'color' => 'green'],
                    ['label' => 'Pemeriksaan',    'value' => $stats['pemeriksaan_terakhir'], 'unit' => '', 'icon' => '📅', 'color' => 'teal'],
                ];
            @endphp

            @foreach($cards as $card)
                @php
                    $colorMap = [
                        'red'    => 'from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-900/30 border-red-200 dark:border-red-800',
                        'orange' => 'from-orange-50 to-orange-100 dark:from-orange-900/20 dark:to-orange-900/30 border-orange-200 dark:border-orange-800',
                        'yellow' => 'from-yellow-50 to-yellow-100 dark:from-yellow-900/20 dark:to-yellow-900/30 border-yellow-200 dark:border-yellow-800',
                        'blue'   => 'from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-900/30 border-blue-200 dark:border-blue-800',
                        'purple' => 'from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-900/30 border-purple-200 dark:border-purple-800',
                        'green'  => 'from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-900/30 border-green-200 dark:border-green-800',
                        'teal'   => 'from-teal-50 to-teal-100 dark:from-teal-900/20 dark:to-teal-900/30 border-teal-200 dark:border-teal-800',
                    ];
                @endphp
                <div class="bg-gradient-to-br {{ $colorMap[$card['color']] }} border rounded-2xl p-4 text-center shadow-sm hover:shadow-md transition-shadow">
                    <div class="text-2xl mb-1">{{ $card['icon'] }}</div>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">{{ $card['label'] }}</p>
                    <p class="text-sm font-bold text-gray-900 dark:text-white leading-tight">
                        {{ $card['value'] !== '-' ? $card['value'] : '-' }}
                        @if($card['value'] !== '-' && $card['unit'])
                            <span class="text-xs font-normal text-gray-500">{{ $card['unit'] }}</span>
                        @endif
                    </p>
                </div>
            @endforeach
        </div>
    </div>

    {{-- ============================================================
         DATA LANSIA
    ============================================================ --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden border border-gray-100 dark:border-gray-700">
        <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <span class="text-xl">👤</span> Data Lansia
            </h2>
            @if(!$lansia)
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-teal-50 text-teal-700 text-xs font-semibold rounded-lg border border-teal-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Tergabung Secara Otomatis
                </span>
            @endif
        </div>

        @if($lansia)
            <div class="p-6">
                <div class="flex flex-col md:flex-row gap-6">
                    {{-- Foto --}}
                    <div class="flex-shrink-0 flex flex-col items-center gap-3">
                        <img src="{{ $lansia->foto_url }}" alt="{{ $lansia->nama }}"
                             class="w-28 h-28 rounded-2xl object-cover shadow-md border-2 border-teal-200 dark:border-teal-800">
                        @if($lansia->is_verified)
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                Terverifikasi
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400">
                                ⏳ Menunggu Verifikasi
                            </span>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @php
                            $infoItems = [
                                ['label' => 'Nama Lengkap',     'value' => $lansia->nama],
                                ['label' => 'NIK',              'value' => $lansia->nik ?? '-'],
                                ['label' => 'Tanggal Lahir',    'value' => $lansia->tanggal_lahir ? $lansia->tanggal_lahir->format('d M Y') : '-'],
                                ['label' => 'Umur',             'value' => $lansia->umur ? $lansia->umur . ' tahun' : '-'],
                                ['label' => 'Jenis Kelamin',    'value' => $lansia->jenis_kelamin_label],
                                ['label' => 'Alamat',           'value' => $lansia->alamat ?? '-'],
                                ['label' => 'Golongan Darah',   'value' => $lansia->golongan_darah ?? '-'],
                                ['label' => 'No. Telepon',      'value' => $lansia->no_hp ?? '-'],
                                ['label' => 'Riwayat Penyakit', 'value' => $lansia->riwayat_penyakit ?? '-'],
                            ];
                        @endphp
                        @foreach($infoItems as $item)
                            <div>
                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">{{ $item['label'] }}</p>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $item['value'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Actions (only before verified) --}}
                    <div class="mt-5 pt-5 border-t border-gray-200 dark:border-gray-700">
                        <p class="text-xs text-gray-500 dark:text-gray-400 italic">
                            Untuk memperbarui data alamat, golongan darah, nomor telepon, maupun riwayat penyakit, ubah di halaman <strong><a href="{{ route('profile.index') }}" class="underline font-bold text-teal-600">Profil Saya</a></strong>.
                        </p>
                    </div>
            </div>
        @else
            {{-- Empty State --}}
            <div class="p-12 text-center">
                <div class="text-5xl mb-4">👴</div>
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">Belum terdapat data lansia.</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Daftarkan data lansia untuk mulai mendapatkan layanan Posyandu Lansia.</p>
                <a href="{{ route('profile.index') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 bg-[#036672] hover:bg-[#036672] text-white font-medium rounded-xl transition-colors shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Lengkapi Profil Saya
                </a>
            </div>
        @endif
    </div>

    @if($lansia)
        {{-- ============================================================
             RIWAYAT PEMERIKSAAN
        ============================================================ --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden border border-gray-100 dark:border-gray-700">
            <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <span class="text-xl">📋</span> Riwayat Pemeriksaan
                    <span class="text-xs font-normal text-gray-500 dark:text-gray-400 ml-2">(Hanya dapat dilihat)</span>
                </h2>
            </div>
            <div class="overflow-x-auto">
                @if($riwayatPemeriksaan->count() > 0)
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                @foreach(['Tanggal','Tekanan Darah','Gula Darah','Kolesterol','BB (kg)','TB (cm)','IMT','Pegawai','Aksi'] as $col)
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">{{ $col }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($riwayatPemeriksaan as $p)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                    <td class="px-4 py-3 whitespace-nowrap text-gray-900 dark:text-white font-medium">{{ $p->tanggal->format('d M Y') }}</td>
                                    <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $p->tekanan_darah ?? '-' }}</td>
                                    <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $p->gula_darah ? $p->gula_darah . ' mg/dL' : '-' }}</td>
                                    <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $p->kolesterol ? $p->kolesterol . ' mg/dL' : '-' }}</td>
                                    <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $p->berat_badan ?? '-' }}</td>
                                    <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $p->tinggi_badan ?? '-' }}</td>
                                    <td class="px-4 py-3">
                                        @if($p->imt)
                                            @php
                                                $statusColor = match($p->status_imt) {
                                                    'Normal' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                                    'Kurus' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                                                    'Gemuk' => 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400',
                                                    'Obesitas' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                                                    default => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-400',
                                                };
                                            @endphp
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium {{ $statusColor }}">
                                                {{ number_format($p->imt, 1) }} ({{ $p->status_imt }})
                                            </span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $p->user->name ?? '-' }}</td>
                                    <td class="px-4 py-3">
                                        <a href="{{ route('warga.lansia.pemeriksaan.show', $p) }}"
                                           class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-teal-700 dark:text-teal-400 bg-teal-50 dark:bg-teal-900/30 hover:bg-teal-100 dark:hover:bg-teal-900/50 rounded-lg transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if($riwayatPemeriksaan->hasPages())
                        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                            {{ $riwayatPemeriksaan->links() }}
                        </div>
                    @endif
                @else
                    <div class="py-10 text-center text-gray-400 dark:text-gray-500">
                        <div class="text-3xl mb-2">📋</div>
                        <p class="text-sm">Belum ada riwayat pemeriksaan.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- ============================================================
             GRAFIK KESEHATAN
        ============================================================ --}}
        @if($chartData && count($chartData['tekanan']['labels']) > 0)
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden border border-gray-100 dark:border-gray-700">
            <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <span class="text-xl">📈</span> Grafik Kesehatan
                </h2>
            </div>
            <div class="p-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Tekanan Darah --}}
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Tekanan Darah (mmHg)</h3>
                    <canvas id="chartTekanan" height="140"></canvas>
                </div>
                {{-- Gula Darah --}}
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Gula Darah (mg/dL)</h3>
                    <canvas id="chartGula" height="140"></canvas>
                </div>
                {{-- Kolesterol --}}
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Kolesterol (mg/dL)</h3>
                    <canvas id="chartKolesterol" height="140"></canvas>
                </div>
                {{-- Berat Badan --}}
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Berat Badan (kg)</h3>
                    <canvas id="chartBerat" height="140"></canvas>
                </div>
                {{-- IMT --}}
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 lg:col-span-2">
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">IMT (Indeks Massa Tubuh)</h3>
                    <canvas id="chartImt" height="80"></canvas>
                </div>
            </div>
        </div>
        @endif

        {{-- ============================================================
             JADWAL SENAM LANSIA
        ============================================================ --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden border border-gray-100 dark:border-gray-700">
            <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <span class="text-xl">🏃</span> Jadwal Senam Lansia
                </h2>
            </div>
            @if($jadwalSenam->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                @foreach(['Tanggal','Jam','Lokasi','Instruktur','Kuota','Status'] as $col)
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">{{ $col }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($jadwalSenam as $jadwal)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                                    <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $jadwal->tanggal->format('d M Y') }}</td>
                                    <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ \Carbon\Carbon::parse($jadwal->jam)->format('H:i') }} WIB</td>
                                    <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $jadwal->lokasi }}</td>
                                    <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $jadwal->instruktur ?? '-' }}</td>
                                    <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $jadwal->kuota }} orang</td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                            Aktif
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="py-8 text-center text-gray-400 dark:text-gray-500">
                    <div class="text-3xl mb-2">🏃</div>
                    <p class="text-sm">Belum ada jadwal senam lansia mendatang.</p>
                </div>
            @endif
        </div>

        {{-- ============================================================
             ARTIKEL EDUKASI
        ============================================================ --}}
        <div>
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                <span class="text-xl">📰</span> Artikel Edukasi Kesehatan Lansia
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach($artikel as $a)
                    @php
                        $bgColors = [
                            'red'    => 'from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-900/30 border-red-200 dark:border-red-800',
                            'orange' => 'from-orange-50 to-orange-100 dark:from-orange-900/20 dark:to-orange-900/30 border-orange-200 dark:border-orange-800',
                            'yellow' => 'from-yellow-50 to-yellow-100 dark:from-yellow-900/20 dark:to-yellow-900/30 border-yellow-200 dark:border-yellow-800',
                            'green'  => 'from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-900/30 border-green-200 dark:border-green-800',
                            'blue'   => 'from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-900/30 border-blue-200 dark:border-blue-800',
                            'purple' => 'from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-900/30 border-purple-200 dark:border-purple-800',
                            'teal'   => 'from-teal-50 to-teal-100 dark:from-teal-900/20 dark:to-teal-900/30 border-teal-200 dark:border-teal-800',
                        ];
                    @endphp
                    <div class="bg-gradient-to-br {{ $bgColors[$a['warna']] }} border rounded-xl p-4 hover:shadow-md transition-shadow">
                        <div class="text-2xl mb-2">{{ $a['icon'] }}</div>
                        <h3 class="font-semibold text-gray-900 dark:text-white text-sm mb-1">{{ $a['judul'] }}</h3>
                        <p class="text-xs text-gray-600 dark:text-gray-400">{{ $a['deskripsi'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ============================================================
             NOTIFIKASI
        ============================================================ --}}
        <div class="bg-gradient-to-br from-teal-50 to-cyan-50 dark:from-teal-900/20 dark:to-cyan-900/20 rounded-2xl border border-teal-200 dark:border-teal-800 p-6">
            <h2 class="text-base font-semibold text-teal-900 dark:text-teal-200 mb-4 flex items-center gap-2">
                <span class="text-xl">🔔</span> Notifikasi & Pengingat
            </h2>
            <ul class="space-y-2">
                @foreach([
                    ['icon' => '📅', 'text' => 'Pengingat Jadwal Posyandu — kunjungi posyandu secara rutin setiap bulan.'],
                    ['icon' => '🏃', 'text' => 'Pengingat Senam Lansia — ikuti jadwal senam untuk menjaga kebugaran.'],
                    ['icon' => '📰', 'text' => 'Artikel Baru — baca artikel kesehatan terbaru di bawah.'],
                    ['icon' => '🩺', 'text' => 'Jadwal Pemeriksaan — pastikan Anda hadir pada jadwal pemeriksaan rutin.'],
                ] as $notif)
                    <li class="flex items-start gap-3 p-3 bg-white/60 dark:bg-white/5 rounded-lg">
                        <span class="text-lg flex-shrink-0">{{ $notif['icon'] }}</span>
                        <p class="text-sm text-teal-800 dark:text-teal-300">{{ $notif['text'] }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

</div>

@if($lansia && $chartData && count($chartData['tekanan']['labels']) > 0)
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const isDark = document.documentElement.classList.contains('dark');
    const gridColor = isDark ? 'rgba(255,255,255,0.1)' : 'rgba(0,0,0,0.07)';
    const textColor = isDark ? '#9ca3af' : '#6b7280';

    const defaultOptions = {
        responsive: true,
        plugins: { legend: { labels: { color: textColor, font: { size: 12 } } } },
        scales: {
            x: { ticks: { color: textColor }, grid: { color: gridColor } },
            y: { ticks: { color: textColor }, grid: { color: gridColor } }
        }
    };

    // Tekanan Darah
    new Chart(document.getElementById('chartTekanan'), {
        type: 'line',
        data: {
            labels: @json($chartData['tekanan']['labels']),
            datasets: [
                { label: 'Sistolik', data: @json($chartData['tekanan']['sistolik']), borderColor: '#ef4444', backgroundColor: 'rgba(239,68,68,0.1)', tension: 0.4, fill: true },
                { label: 'Diastolik', data: @json($chartData['tekanan']['diastolik']), borderColor: '#f97316', backgroundColor: 'rgba(249,115,22,0.1)', tension: 0.4, fill: true },
            ]
        },
        options: defaultOptions
    });

    // Gula Darah
    new Chart(document.getElementById('chartGula'), {
        type: 'line',
        data: {
            labels: @json($chartData['gula_darah']['labels']),
            datasets: [{ label: 'Gula Darah', data: @json($chartData['gula_darah']['data']), borderColor: '#f59e0b', backgroundColor: 'rgba(245,158,11,0.1)', tension: 0.4, fill: true }]
        },
        options: defaultOptions
    });

    // Kolesterol
    new Chart(document.getElementById('chartKolesterol'), {
        type: 'line',
        data: {
            labels: @json($chartData['kolesterol']['labels']),
            datasets: [{ label: 'Kolesterol', data: @json($chartData['kolesterol']['data']), borderColor: '#8b5cf6', backgroundColor: 'rgba(139,92,246,0.1)', tension: 0.4, fill: true }]
        },
        options: defaultOptions
    });

    // Berat Badan
    new Chart(document.getElementById('chartBerat'), {
        type: 'bar',
        data: {
            labels: @json($chartData['berat']['labels']),
            datasets: [{ label: 'Berat Badan (kg)', data: @json($chartData['berat']['data']), backgroundColor: 'rgba(59,130,246,0.7)', borderRadius: 6 }]
        },
        options: defaultOptions
    });

    // IMT
    new Chart(document.getElementById('chartImt'), {
        type: 'line',
        data: {
            labels: @json($chartData['imt']['labels']),
            datasets: [{ label: 'IMT', data: @json($chartData['imt']['data']), borderColor: '#10b981', backgroundColor: 'rgba(16,185,129,0.1)', tension: 0.4, fill: true, pointRadius: 5 }]
        },
        options: {
            ...defaultOptions,
            plugins: {
                ...defaultOptions.plugins,
                annotation: {}
            }
        }
    });
</script>
@endpush
@endif

@endsection