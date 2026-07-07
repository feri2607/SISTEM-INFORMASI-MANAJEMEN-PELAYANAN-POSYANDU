{{-- resources/views/public/schedule.blade.php --}}

@extends('layouts.public')

@section('title', 'Jadwal Posyandu - Sistem Informasi Posyandu Digital')
@section('description', 'Lihat jadwal kegiatan Posyandu terbaru agar Anda tidak melewatkan pelayanan kesehatan ibu dan anak.')

@section('content')
    {{-- Hero --}} <section class="relative overflow-hidden bg-gradient-to-br from-teal-600 via-teal-700 to-blue-800 py-16 lg:py-20">
   
        <div class="absolute inset-0 opacity-10">
            <svg class="absolute top-0 right-0 w-full h-full" viewBox="0 0 800 800" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="600" cy="200" r="300" fill="white" opacity="0.3"/>
                <circle cx="700" cy="500" r="200" fill="white" opacity="0.2"/>
                <circle cx="400" cy="700" r="250" fill="white" opacity="0.1"/>
            </svg>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Breadcrumb --}}
            <nav class="flex items-center text-sm text-teal-100 mb-4" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-white transition duration-150">
                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                    </svg>
                    Beranda
                </a>
                <span class="mx-2 text-teal-300">/</span>
                <span class="text-white font-medium">Jadwal Posyandu</span>
            </nav>

            <div class="text-center">
                <h1 class="text-4xl sm:text-5xl font-extrabold text-white mb-4">
                    Jadwal Posyandu
                </h1>
                <p class="text-lg text-teal-100 max-w-2xl mx-auto">
                    Lihat jadwal kegiatan Posyandu terbaru agar Anda tidak melewatkan pelayanan kesehatan ibu dan anak.
                </p>
            </div>
        </div>
    </section>

    {{-- Main Content --}}
    <section class="py-10 bg-slate-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
                
                {{-- Sidebar Kiri: Filter & Kalender --}}
                <div class="w-full lg:w-1/3 lg:max-w-[320px] flex flex-col gap-6">
                    
                    {{-- Box Filter --}}
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-5">
                        <div class="flex items-center gap-2 mb-5">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                            </svg>
                            <h3 class="text-base font-semibold text-gray-800 dark:text-gray-200">Filter Jadwal</h3>
                        </div>
                        
                        <form method="GET" action="{{ route('public.schedule') }}" x-data="scheduleFilter()" @submit.prevent="submitForm" class="space-y-4">
                            {{-- Search --}}
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                                <input type="text" name="search" x-model="search" placeholder="Cari kegiatan/lokasi..." value="{{ request('search') }}"
                                    class="w-full pl-10 pr-4 py-2 border border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-teal-500 focus:border-transparent transition">
                            </div>

                            {{-- Grid Bulan & Tahun --}}
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <select name="bulan" x-model="bulan" @change="submitForm"
                                            class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-teal-500 focus:border-transparent transition appearance-none">
                                        <option value="">Bulan</option>
                                        @foreach($months as $key => $month)
                                            <option value="{{ $key }}" {{ request('bulan') == $key ? 'selected' : '' }}>{{ $month }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <select name="tahun" x-model="tahun" @change="submitForm"
                                            class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-teal-500 focus:border-transparent transition appearance-none">
                                        <option value="">Tahun</option>
                                        @foreach($years as $year)
                                            <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Lokasi & Status --}}
                            <div>
                                <select name="status" x-model="status" @change="submitForm"
                                        class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-teal-500 focus:border-transparent transition appearance-none">
                                    <option value="">Semua Status</option>
                                    <option value="terjadwal" {{ request('status') == 'terjadwal' ? 'selected' : '' }}>Terjadwal</option>
                                    <option value="berlangsung" {{ request('status') == 'berlangsung' ? 'selected' : '' }}>Berlangsung</option>
                                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </div>

                            <button type="submit" class="hidden">Filter</button>
                            
                            @if(request()->hasAny(['search', 'bulan', 'tahun', 'lokasi', 'status']))
                                <a href="{{ route('public.schedule') }}" 
                                class="block w-full py-2.5 text-center bg-blue-100/50 hover:bg-blue-100 dark:bg-blue-900/30 dark:hover:bg-blue-900/50 text-blue-700 dark:text-blue-400 text-sm font-medium rounded-xl transition duration-150">
                                    Reset Filter
                                </a>
                            @endif
                        </form>
                    </div>

                    {{-- Box Kalender --}}
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 pb-6">
                        <x-public.schedule.calendar :calendarData="$calendarData" />
                    </div>
                </div>

                {{-- Konten Kanan: Daftar Jadwal --}}
                <div class="w-full lg:flex-1">
                    <div class="mb-5 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Kegiatan Mendatang</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Menampilkan {{ min(9, $kegiatan->count()) }} dari {{ $kegiatan->total() }} kegiatan di wilayah ini
                            </p>
                        </div>
                    </div>

                    @if($kegiatan->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            @foreach($kegiatan as $item)
                                <x-public.schedule.card :kegiatan="$item" />
                            @endforeach
                        </div>

                        <div class="mt-8">
                            {{ $kegiatan->withQueryString()->links() }}
                        </div>
                    @else
                        <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Belum Ada Jadwal</h3>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">Coba sesuaikan filter pencarian atau cek kembali nanti.</p>
                            <a href="{{ route('home') }}" class="mt-5 inline-block px-5 py-2.5 bg-[#036672] hover:bg-[#036672] text-white text-sm font-medium rounded-xl transition duration-150">
                                Kembali ke Beranda
                            </a>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </section>

    {{-- Call to Action --}}
    <x-public.cta />
@endsection

@push('scripts')
<script>
    function scheduleFilter() {
        return {
            search: '{{ request('search') }}',
            bulan: '{{ request('bulan') }}',
            tahun: '{{ request('tahun') }}',
            lokasi: '{{ request('lokasi') }}',
            status: '{{ request('status') }}',
            submitForm() {
                this.$refs.form.submit();
            }
        }
    }

    // Real-time search
    let searchTimeout;
    document.querySelector('input[name="search"]').addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            this.closest('form').submit();
        }, 500);
    });
</script>
@endpush