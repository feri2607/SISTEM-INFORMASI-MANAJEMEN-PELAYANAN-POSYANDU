@extends('layouts.app')

@section('title', 'Laporan Posyandu Terintegrasi')
@section('page-title', 'Laporan Posyandu')
@section('page-subtitle', 'Rekapitulasi seluruh pelayanan Posyandu.')

@section('content')
<div x-data="laporanTabs('{{ $kategori }}')" class="space-y-6">

    {{-- Filters --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 flex flex-col md:flex-row justify-between items-center gap-4">
        <form id="laporanFilterForm" method="GET" action="{{ route($viewPrefix . '.laporan.index') }}" class="flex-1 flex flex-wrap gap-2 w-full items-center">
            <input type="hidden" name="kategori" :value="activeTab">
            
            <select name="periode" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-sm focus:ring-blue-500">
                <option value="">Semua Periode</option>
                <option value="hari_ini" {{ ($filters['periode'] ?? '') == 'hari_ini' ? 'selected' : '' }}>Hari Ini</option>
                <option value="minggu_ini" {{ ($filters['periode'] ?? '') == 'minggu_ini' ? 'selected' : '' }}>Minggu Ini</option>
                <option value="bulan_ini" {{ ($filters['periode'] ?? '') == 'bulan_ini' ? 'selected' : '' }}>Bulan Ini</option>
                <option value="tahun_ini" {{ ($filters['periode'] ?? '') == 'tahun_ini' ? 'selected' : '' }}>Tahun Ini</option>
            </select>

            <select name="pegawai_id" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-sm focus:ring-blue-500">
                <option value="">Semua Pegawai</option>
                @foreach($pegawais as $pegawai)
                    <option value="{{ $pegawai->id }}" {{ ($filters['pegawai_id'] ?? '') == $pegawai->id ? 'selected' : '' }}>
                        {{ $pegawai->name }}
                    </option>
                @endforeach
            </select>
            
            <button type="submit" class="px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg text-sm font-medium transition flex items-center shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                Terapkan Filter
            </button>
        </form>

        <div class="flex gap-2">
            <a :href="`{{ route($viewPrefix . '.laporan.export.excel') }}?` + new URLSearchParams(new FormData(document.getElementById('laporanFilterForm'))).toString()" class="px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg text-sm font-medium transition flex items-center shadow-sm">
                Export Excel
            </a>
            <a :href="`{{ route($viewPrefix . '.laporan.export.pdf') }}?` + new URLSearchParams(new FormData(document.getElementById('laporanFilterForm'))).toString()" class="px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg text-sm font-medium transition flex items-center shadow-sm">
                Export PDF
            </a>
            <button onclick="window.print()" class="px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg text-sm font-medium transition flex items-center shadow-sm">
                Print
            </button>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="border-b border-gray-200 dark:border-gray-700">
        <nav class="-mb-px flex space-x-4 lg:space-x-8 overflow-x-auto" aria-label="Tabs">
            <button @click="switchTab('dashboard')"
                :class="activeTab === 'dashboard' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition font-bold">
                Dashboard Statistik
            </button>
            <button @click="switchTab('balita')"
                :class="activeTab === 'balita' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition">
                Balita
            </button>
            <button @click="switchTab('kehamilan')"
                :class="activeTab === 'kehamilan' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition">
                Kehamilan
            </button>
            <button @click="switchTab('wuspus')"
                :class="activeTab === 'wuspus' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition">
                WUS / PUS
            </button>
            <button @click="switchTab('remaja')"
                :class="activeTab === 'remaja' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition">
                Remaja
            </button>
            <button @click="switchTab('lansia')"
                :class="activeTab === 'lansia' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition">
                Lansia
            </button>
            <button @click="switchTab('kegiatan')"
                :class="activeTab === 'kegiatan' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition">
                Kegiatan & Kehadiran
            </button>
            <button @click="switchTab('pegawai')"
                :class="activeTab === 'pegawai' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition">
                Performa Pegawai
            </button>
        </nav>
    </div>

    {{-- Content Areas --}}
    <div x-show="activeTab === 'dashboard'" x-transition class="mt-4">
        @include('laporan.tabs.dashboard')
    </div>

    <div x-show="activeTab === 'balita'" x-transition x-cloak class="mt-4">
        @if($kategori === 'balita')
            @include('laporan.tabs.balita')
        @else
            <div class="flex justify-center p-8"><svg class="animate-spin h-8 w-8 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></div>
        @endif
    </div>

    <div x-show="activeTab === 'kehamilan'" x-transition x-cloak class="mt-4">
        @if($kategori === 'kehamilan')
            @include('laporan.tabs.kehamilan')
        @else
            <div class="flex justify-center p-8"><svg class="animate-spin h-8 w-8 text-indigo-500" ...></svg></div>
        @endif
    </div>

    <div x-show="activeTab === 'wuspus'" x-transition x-cloak class="mt-4">
        @if($kategori === 'wuspus')
            @include('laporan.tabs.wuspus')
        @else
             <div class="flex justify-center p-8"><svg class="animate-spin h-8 w-8 text-indigo-500" ...></svg></div>
        @endif
    </div>

    <div x-show="activeTab === 'remaja'" x-transition x-cloak class="mt-4">
        @if($kategori === 'remaja')
            @include('laporan.tabs.remaja')
        @else
             <div class="flex justify-center p-8"><svg class="animate-spin h-8 w-8 text-indigo-500" ...></svg></div>
        @endif
    </div>

    <div x-show="activeTab === 'lansia'" x-transition x-cloak class="mt-4">
        @if($kategori === 'lansia')
            @include('laporan.tabs.lansia')
        @else
             <div class="flex justify-center p-8"><svg class="animate-spin h-8 w-8 text-indigo-500" ...></svg></div>
        @endif
    </div>

    <div x-show="activeTab === 'kegiatan'" x-transition x-cloak class="mt-4">
        @if($kategori === 'kegiatan')
            @include('laporan.tabs.kegiatan')
        @else
             <div class="flex justify-center p-8"><svg class="animate-spin h-8 w-8 text-indigo-500" ...></svg></div>
        @endif
    </div>

    <div x-show="activeTab === 'pegawai'" x-transition x-cloak class="mt-4">
        @if($kategori === 'pegawai')
            @include('laporan.tabs.pegawai')
        @else
             <div class="flex justify-center p-8"><svg class="animate-spin h-8 w-8 text-indigo-500" ...></svg></div>
        @endif
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('laporanTabs', (initial) => ({
            activeTab: initial || 'dashboard',
            switchTab(tab) {
                this.activeTab = tab;
                // update URL category and submit form to fetch data
                document.querySelector('#laporanFilterForm [name=kategori]').value = tab;
                document.getElementById('laporanFilterForm').submit();
            }
        }));
    });
</script>
@endpush
@endsection
