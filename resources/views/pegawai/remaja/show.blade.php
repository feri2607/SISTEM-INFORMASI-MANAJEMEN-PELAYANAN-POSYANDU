{{-- resources/views/pegawai/remaja/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Remaja - ' . $remaja->nama)
@section('page-title', '👤 Detail Remaja')
@section('page-subtitle', $remaja->nama . ' — NIK: ' . $remaja->nik)

@section('content')
<div class="space-y-6" x-data="{ activeTab: 'pemeriksaan' }">

    {{-- Back + Actions --}}
    <div class="flex flex-wrap items-center gap-3">
        <a href="{{ route('pegawai.remaja.index') }}"
           class="flex items-center gap-2 px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-xl text-sm font-medium transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
        <a href="{{ route('pegawai.remaja.pemeriksaan.create', $remaja) }}"
           class="flex items-center gap-2 px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-xl text-sm font-medium transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Pemeriksaan Baru
        </a>
        <a href="{{ route('pegawai.remaja.konseling.create', $remaja) }}"
           class="flex items-center gap-2 px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-xl text-sm font-medium transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            Konseling Baru
        </a>

        {{-- Verifikasi / Batalkan Verifikasi --}}
        @if(!$remaja->is_verified)
            <form method="POST" action="{{ route('pegawai.remaja.verify', $remaja) }}"
                  x-data
                  @submit.prevent="
                    Swal.fire({
                        title: 'Verifikasi akun remaja ini?',
                        text: 'Status akan berubah menjadi Terverifikasi.',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#16a34a',
                        confirmButtonText: 'Ya, Verifikasi!',
                        cancelButtonText: 'Batal'
                    }).then(result => { if(result.isConfirmed) $el.submit(); })
                  ">
                @csrf @method('PATCH')
                <button type="submit"
                        class="flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-semibold transition shadow">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    ✅ Verifikasi Akun
                </button>
            </form>
        @else
            <form method="POST" action="{{ route('pegawai.remaja.reject', $remaja) }}"
                  x-data
                  @submit.prevent="
                    Swal.fire({
                        title: 'Batalkan verifikasi?',
                        text: 'Status akan kembali ke Belum Terverifikasi.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        confirmButtonText: 'Ya, Batalkan',
                        cancelButtonText: 'Tutup'
                    }).then(result => { if(result.isConfirmed) $el.submit(); })
                  ">
                @csrf @method('PATCH')
                <button type="submit"
                        class="flex items-center gap-2 px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-xl text-sm font-semibold transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    ❌ Batalkan Verifikasi
                </button>
            </form>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Profil Card --}}
        <div class="lg:col-span-1 space-y-4">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow overflow-hidden">
                {{-- Header --}}
                <div class="bg-gradient-to-br from-purple-600 to-purple-800 p-6 text-center">
                    <img src="{{ $remaja->foto_url }}" alt="{{ $remaja->nama }}"
                         class="w-24 h-24 rounded-full object-cover mx-auto ring-4 ring-white/30 shadow-lg">
                    <h2 class="text-xl font-bold text-white mt-3">{{ $remaja->nama }}</h2>
                    <p class="text-purple-200 text-sm">{{ $remaja->umur }} tahun • {{ $remaja->jenis_kelamin_label }}</p>
                    <div class="mt-3">
                        @if($remaja->is_verified)
                            <span class="px-3 py-1 bg-[#036672]/30 text-green-200 rounded-full text-xs font-medium border border-green-400/30">
                                ✅ Terverifikasi
                            </span>
                        @else
                            <span class="px-3 py-1 bg-[#036672]/30 text-yellow-200 rounded-full text-xs font-medium border border-yellow-400/30">
                                ⏳ Menunggu Verifikasi
                            </span>
                        @endif
                    </div>
                </div>
                {{-- Identitas --}}
                <div class="p-5 space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 dark:text-gray-400">NIK</span>
                        <span class="font-mono font-medium text-gray-900 dark:text-white">{{ $remaja->nik }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 dark:text-gray-400">Tgl. Lahir</span>
                        <span class="text-gray-900 dark:text-white">{{ $remaja->tanggal_lahir->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 dark:text-gray-400">Gol. Darah</span>
                        <span class="text-gray-900 dark:text-white">{{ $remaja->golongan_darah ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 dark:text-gray-400">Sekolah</span>
                        <span class="text-gray-900 dark:text-white text-right max-w-[160px]">{{ $remaja->sekolah ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 dark:text-gray-400">No. HP</span>
                        <span class="text-gray-900 dark:text-white">{{ $remaja->no_hp ?? '-' }}</span>
                    </div>
                    <div class="pt-3 border-t border-gray-200 dark:border-gray-700">
                        <p class="text-xs text-gray-500 dark:text-gray-400">Alamat</p>
                        <p class="text-sm text-gray-900 dark:text-white mt-1">{{ $remaja->alamat ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- Health Summary --}}
            @php $lastP = $remaja->pemeriksaan->first(); @endphp
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-5 space-y-3">
                <h4 class="font-semibold text-gray-900 dark:text-white text-sm">📊 Kondisi Terkini</h4>
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-3 text-center">
                        <p class="text-xs text-blue-600 dark:text-blue-400">Berat</p>
                        <p class="text-xl font-bold text-blue-700 dark:text-blue-300">{{ $lastP?->berat_badan ?? '-' }}</p>
                        @if($lastP?->berat_badan) <p class="text-xs text-blue-500">kg</p> @endif
                    </div>
                    <div class="bg-green-50 dark:bg-green-900/20 rounded-xl p-3 text-center">
                        <p class="text-xs text-green-600 dark:text-green-400">Tinggi</p>
                        <p class="text-xl font-bold text-green-700 dark:text-green-300">{{ $lastP?->tinggi_badan ?? '-' }}</p>
                        @if($lastP?->tinggi_badan) <p class="text-xs text-green-500">cm</p> @endif
                    </div>
                    <div class="bg-purple-50 dark:bg-purple-900/20 rounded-xl p-3 text-center">
                        <p class="text-xs text-purple-600 dark:text-purple-400">BMI</p>
                        <p class="text-xl font-bold text-purple-700 dark:text-purple-300">{{ $lastP?->bmi ?? '-' }}</p>
                    </div>
                    <div class="rounded-xl p-3 text-center
                        {{ $remaja->status_gizi === 'Normal' ? 'bg-green-50 dark:bg-green-900/20' : 'bg-yellow-50 dark:bg-yellow-900/20' }}">
                        <p class="text-xs {{ $remaja->status_gizi === 'Normal' ? 'text-green-600 dark:text-green-400' : 'text-yellow-600 dark:text-yellow-400' }}">Status Gizi</p>
                        <p class="text-sm font-bold {{ $remaja->status_gizi === 'Normal' ? 'text-green-700 dark:text-green-300' : 'text-yellow-700 dark:text-yellow-300' }}">
                            {{ $remaja->status_gizi ?? '-' }}
                        </p>
                    </div>
                </div>
                @if($lastP)
                    <p class="text-xs text-gray-400 text-center">Terakhir diperiksa: {{ $lastP->tanggal->format('d M Y') }}</p>
                @endif
            </div>
        </div>

        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Charts --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-5">
                <h4 class="font-semibold text-gray-900 dark:text-white mb-4">📈 Grafik Pertumbuhan</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-center text-gray-500 dark:text-gray-400 mb-2">Berat Badan (kg)</p>
                        <div class="relative h-40">
                            <canvas id="chartBB"></canvas>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs text-center text-gray-500 dark:text-gray-400 mb-2">BMI</p>
                        <div class="relative h-40">
                            <canvas id="chartBMI"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabs --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow overflow-hidden">
                {{-- Tab Nav --}}
                <div class="flex border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                    <button @click="activeTab = 'pemeriksaan'"
                            :class="activeTab === 'pemeriksaan' ? 'border-b-2 border-purple-600 text-purple-600 dark:text-purple-400 bg-white dark:bg-gray-800' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700'"
                            class="px-5 py-3 text-sm font-medium transition">
                        📋 Riwayat Pemeriksaan ({{ $remaja->pemeriksaan->count() }})
                    </button>
                    <button @click="activeTab = 'konseling'"
                            :class="activeTab === 'konseling' ? 'border-b-2 border-purple-600 text-purple-600 dark:text-purple-400 bg-white dark:bg-gray-800' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700'"
                            class="px-5 py-3 text-sm font-medium transition">
                        💬 Konseling ({{ $remaja->konseling->count() }})
                    </button>
                </div>

                {{-- Tab: Pemeriksaan --}}
                <div x-show="activeTab === 'pemeriksaan'" class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Tanggal</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">BB</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">TB</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">BMI</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Tek. Darah</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">HB</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Status Gizi</th>
                                <th class="px-5 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($remaja->pemeriksaan as $p)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    <td class="px-5 py-3 text-gray-900 dark:text-white font-medium">{{ $p->tanggal->format('d M Y') }}</td>
                                    <td class="px-5 py-3 text-gray-600 dark:text-gray-400">{{ $p->berat_badan ? $p->berat_badan . ' kg' : '-' }}</td>
                                    <td class="px-5 py-3 text-gray-600 dark:text-gray-400">{{ $p->tinggi_badan ? $p->tinggi_badan . ' cm' : '-' }}</td>
                                    <td class="px-5 py-3 font-semibold text-gray-900 dark:text-white">{{ $p->bmi ?? '-' }}</td>
                                    <td class="px-5 py-3 text-gray-600 dark:text-gray-400">{{ $p->tekanan_darah ?? '-' }}</td>
                                    <td class="px-5 py-3 text-gray-600 dark:text-gray-400">{{ $p->status_hb ?? '-' }}</td>
                                    <td class="px-5 py-3">
                                        @if($p->status_gizi)
                                            @php $c = $p->status_gizi_color; @endphp
                                            <span class="px-2 py-0.5 text-xs rounded-full bg-{{ $c }}-100 dark:bg-{{ $c }}-900/30 text-{{ $c }}-700 dark:text-{{ $c }}-400">
                                                {{ $p->status_gizi }}
                                            </span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3 text-right">
                                        <div class="flex justify-end gap-1">
                                            <a href="{{ route('pegawai.remaja.pemeriksaan.edit', $p) }}"
                                               class="p-1.5 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                            <form method="POST" action="{{ route('pegawai.remaja.pemeriksaan.destroy', $p) }}"
                                                  x-data
                                                  @submit.prevent="
                                                    Swal.fire({
                                                        title: 'Hapus pemeriksaan?',
                                                        text: 'Data tidak dapat dikembalikan.',
                                                        icon: 'warning',
                                                        showCancelButton: true,
                                                        confirmButtonColor: '#dc2626',
                                                        confirmButtonText: 'Ya, hapus!',
                                                        cancelButtonText: 'Batal'
                                                    }).then(result => { if(result.isConfirmed) $el.submit(); })
                                                  ">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                        class="p-1.5 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-5 py-10 text-center text-gray-500 dark:text-gray-400">
                                        Belum ada riwayat pemeriksaan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Tab: Konseling --}}
                <div x-show="activeTab === 'konseling'" class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Tanggal</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Topik</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Catatan</th>
                                <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Pegawai</th>
                                <th class="px-5 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($remaja->konseling as $k)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    <td class="px-5 py-3 font-medium text-gray-900 dark:text-white">{{ $k->tanggal->format('d M Y') }}</td>
                                    <td class="px-5 py-3">
                                        <span class="px-2.5 py-1 text-xs rounded-full bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400">
                                            {{ ucfirst($k->topik) }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3 text-gray-600 dark:text-gray-400 max-w-xs truncate">{{ $k->catatan ?? '-' }}</td>
                                    <td class="px-5 py-3 text-gray-600 dark:text-gray-400">{{ $k->user?->name ?? '-' }}</td>
                                    <td class="px-5 py-3 text-right">
                                        <div class="flex justify-end gap-1">
                                            <a href="{{ route('pegawai.remaja.konseling.edit', $k) }}"
                                               class="p-1.5 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                            <form method="POST" action="{{ route('pegawai.remaja.konseling.destroy', $k) }}"
                                                  x-data
                                                  @submit.prevent="
                                                    Swal.fire({
                                                        title: 'Hapus konseling?',
                                                        icon: 'warning',
                                                        showCancelButton: true,
                                                        confirmButtonColor: '#dc2626',
                                                        confirmButtonText: 'Hapus',
                                                        cancelButtonText: 'Batal'
                                                    }).then(result => { if(result.isConfirmed) $el.submit(); })
                                                  ">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-1.5 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-10 text-center text-gray-500 dark:text-gray-400">
                                        Belum ada riwayat konseling.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
    const growthData = @json($growthData);

    // Chart Berat Badan
    new Chart(document.getElementById('chartBB'), {
        type: 'line',
        data: {
            labels: growthData.berat.labels,
            datasets: [{
                label: 'Berat Badan (kg)',
                data: growthData.berat.data,
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59,130,246,0.1)',
                borderWidth: 2,
                pointBackgroundColor: '#3b82f6',
                tension: 0.4,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: false, grid: { color: 'rgba(107,114,128,0.15)' } },
                x: { grid: { display: false } }
            }
        }
    });

    // Chart BMI
    new Chart(document.getElementById('chartBMI'), {
        type: 'line',
        data: {
            labels: growthData.bmi.labels,
            datasets: [{
                label: 'BMI',
                data: growthData.bmi.data,
                borderColor: '#8b5cf6',
                backgroundColor: 'rgba(139,92,246,0.1)',
                borderWidth: 2,
                pointBackgroundColor: '#8b5cf6',
                tension: 0.4,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: false, grid: { color: 'rgba(107,114,128,0.15)' } },
                x: { grid: { display: false } }
            }
        }
    });
</script>
@endpush
