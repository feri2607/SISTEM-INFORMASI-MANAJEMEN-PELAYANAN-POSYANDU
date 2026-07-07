{{-- resources/views/public/news.blade.php --}}

@extends('layouts.public')

@section('title', 'Berita Posyandu - Sistem Informasi Posyandu Digital')
@section('description', 'Ikuti informasi terbaru mengenai kegiatan Posyandu, pelayanan kesehatan, dan program masyarakat.')

@section('content')
    {{-- Hero --}}
   <section class="relative overflow-hidden bg-gradient-to-br from-teal-600 via-teal-700 to-blue-800 py-16 lg:py-20">
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
                <span class="text-white font-medium">Berita</span>
            </nav>

             <div class="text-center">
                <h1 class="text-4xl sm:text-5xl font-extrabold text-white mb-4">
                    Berita Posyandu
                </h1>
                <p class="text-lg text-blue-100 max-w-2xl mx-auto">
                    Ikuti informasi terbaru mengenai kegiatan Posyandu, pelayanan kesehatan, dan program masyarakat.
                </p>
            </div>
        </div>
    </section>

    {{-- Filter & Search --}}
    <section class="py-8 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 sticky top-16 z-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <form method="GET" action="{{ route('public.news') }}" 
                  x-data="newsFilter()"
                  @submit.prevent="submitForm">
                <div class="flex flex-wrap gap-3">
                    {{-- Search --}}
                    <div class="flex-1 min-w-[200px]">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text" 
                                   name="search" 
                                   x-model="search"
                                   placeholder="Cari berita..." 
                                   value="{{ request('search') }}"
                                   class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>

                    {{-- Category --}}
                    <div>
                        <select name="category" x-model="category"
                                class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Bulan --}}
                    <div>
                        <select name="bulan" x-model="bulan"
                                class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Semua Bulan</option>
                            @foreach($months as $key => $month)
                                <option value="{{ $key }}" {{ request('bulan') == $key ? 'selected' : '' }}>
                                    {{ $month }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tahun --}}
                    <div>
                        <select name="tahun" x-model="tahun"
                                class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Semua Tahun</option>
                            @foreach($years as $year)
                                <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Sort --}}
                    <div>
                        <select name="sort" x-model="sort"
                                class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                            <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                            <option value="terpopuler" {{ request('sort') == 'terpopuler' ? 'selected' : '' }}>Terpopuler</option>
                        </select>
                    </div>

                    <button type="submit" 
                            class="px-6 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg transition duration-150">
                        <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Filter
                    </button>

                    @if(request()->hasAny(['search', 'category', 'bulan', 'tahun', 'sort']))
                        <a href="{{ route('public.news') }}" 
                           class="px-6 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition duration-150">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </section>

    {{-- News Grid --}}
    <section class="py-12 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($news->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($news as $item)
                        <x-public.news-card :news="$item" />
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $news->withQueryString()->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <svg class="w-24 h-24 text-gray-400 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Belum Ada Berita</h3>
                    <p class="text-gray-500 dark:text-gray-400">Belum ada berita yang dipublikasikan.</p>
                </div>
            @endif
        </div>
    </section>

    {{-- Call to Action --}}
    <x-public.cta />
@endsection

@push('scripts')
<script>
    function newsFilter() {
        return {
            search: '{{ request('search') }}',
            category: '{{ request('category') }}',
            bulan: '{{ request('bulan') }}',
            tahun: '{{ request('tahun') }}',
            sort: '{{ request('sort', 'terbaru') }}',
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
