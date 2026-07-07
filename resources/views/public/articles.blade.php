{{-- resources/views/public/articles.blade.php --}}

@extends('layouts.public')

@section('title', 'Artikel Edukasi Kesehatan - Sistem Informasi Posyandu Digital')
@section('description', 'Temukan berbagai informasi kesehatan ibu dan anak yang terpercaya di Posyandu.')

@section('content')
    {{-- Hero & Search --}}
    <section class="bg-[#eef2fc] dark:bg-gray-900 pt-16 pb-20 lg:pt-24 lg:pb-28">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <h1 class="text-4xl md:text-5xl font-bold text-[#143d96] dark:text-blue-400 mb-4 tracking-tight">
                    Artikel Edukasi Kesehatan
                </h1>
                <p class="text-base md:text-lg text-gray-600 dark:text-gray-400 mb-10 max-w-2xl leading-relaxed">
                    Temukan panduan terpercaya mengenai kesehatan ibu dan anak, nutrisi balita, dan pencegahan stunting langsung dari para ahli.
                </p>

                <form method="GET" action="{{ route('public.articles') }}" class="relative max-w-2xl">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" 
                           name="search" 
                           placeholder="Cari judul artikel atau kata kunci (misal: Gizi, ASI)..." 
                           value="{{ request('search') }}"
                           class="w-full pl-12 pr-24 py-4 rounded-full border-none shadow-[0_4px_20px_rgb(0,0,0,0.05)] text-gray-700 bg-white focus:ring-2 focus:ring-blue-500 text-[15px] outline-none">
                    <button type="submit" class="absolute right-2.5 top-2.5 bottom-2.5 px-6 bg-[#0a256a] hover:bg-[#071947] text-white text-sm font-semibold rounded-full transition-colors">
                        Cari
                    </button>
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    @if(request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif
                </form>
            </div>
        </div>
    </section>

    {{-- Filter Categories & Main List --}}
    <section class="bg-[#fafbfc] dark:bg-gray-900 min-h-[500px] border-t border-gray-100 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-7 relative z-10">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10 pt-14">
                
                {{-- Categories Pill --}}
                <div class="flex flex-wrap items-center gap-2.5">
                    <a href="{{ route('public.articles', array_merge(request()->query(), ['category' => null])) }}" 
                       class="px-5 py-2 text-[13px] font-semibold rounded-full transition-colors border {{ !request('category') ? 'bg-[#0a256a] text-white border-[#0a256a]' : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50 hover:text-gray-900' }}">
                        Semua Artikel
                    </a>
                    
                    @foreach($categories as $cat)
                        <a href="{{ route('public.articles', array_merge(request()->query(), ['category' => $cat->id])) }}" 
                           class="px-5 py-2 text-[13px] font-semibold rounded-full transition-colors border {{ request('category') == $cat->id ? 'bg-[#0a256a] text-white border-[#0a256a]' : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50 hover:text-gray-900' }}">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>

                {{-- Sort Dropdown --}}
                <div class="flex items-center gap-3 shrink-0">
                    <span class="text-[13px] text-gray-500 font-semibold">Urutkan:</span>
                    <form method="GET" action="{{ route('public.articles') }}">
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        <select name="sort" onchange="this.form.submit()" class="px-3 py-2 bg-white border border-gray-200 rounded-lg text-[13px] font-semibold text-gray-700 outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer shadow-sm">
                            <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                            <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                            <option value="terpopuler" {{ request('sort') == 'terpopuler' ? 'selected' : '' }}>Terpopuler</option>
                        </select>
                    </form>
                </div>
            </div>

            {{-- Articles Grid --}}
            @if($articles->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-10">
                    @foreach($articles as $article)
                        <div class="bg-white dark:bg-gray-800 rounded-[20px] overflow-hidden shadow-[0_5px_15px_rgb(0,0,0,0.03)] border border-gray-100 hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:-translate-y-1 transition-all duration-300 flex flex-col h-full group">
                            
                            {{-- Image Overlay Badge --}}
                            <div class="relative h-[200px] w-full overflow-hidden shrink-0">
                                <img src="{{ $article->thumbnail_url }}" 
                                     alt="{{ $article->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-500" loading="lazy">
                                <span class="absolute top-4 left-4 inline-block bg-[#143d96] text-white text-[9px] font-extrabold px-2.5 py-1 rounded tracking-wider uppercase shadow-sm">
                                    {{ $article->category->name }}
                                </span>
                            </div>

                            {{-- Card Content --}}
                            <div class="p-6 flex flex-col flex-1">
                                {{-- Meta Date & Time --}}
                                <div class="flex items-center text-[12px] text-gray-500 font-medium mb-3 gap-4">
                                    <span class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        {{ $article->published_at ? $article->published_at->format('d M Y') : '-' }}
                                    </span>
                                    <span class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        {{ $article->reading_time }}
                                    </span>
                                </div>

                                {{-- Title & Excerpt --}}
                                <h3 class="text-[17px] font-bold text-[#111827] dark:text-white leading-[1.4] mb-3 group-hover:text-[#143d96] transition-colors line-clamp-2">
                                    <a href="{{ route('public.article-detail', $article->slug) }}">
                                        {{ $article->title }}
                                    </a>
                                </h3>
                                <p class="text-[13px] text-gray-500 leading-relaxed mb-6 line-clamp-3">
                                    {{ Str::limit(strip_tags($article->content), 120) }}
                                </p>

                                {{-- Footer Avatar & CTA --}}
                                <div class="mt-auto pt-5 border-t border-gray-100 flex items-center justify-between">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-7 h-7 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 overflow-hidden shrink-0 border border-gray-200">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($article->user->name) }}&background=E8EFFF&color=143d96" alt="{{ $article->user->name }}" class="w-full h-full object-cover">
                                        </div>
                                        <span class="text-[12px] font-bold text-gray-800">{{ $article->user->name }}</span>
                                    </div>
                                    <a href="{{ route('public.article-detail', $article->slug) }}" class="text-[12px] font-bold text-[#143d96] hover:text-blue-800 flex items-center gap-1 transition-colors">
                                        Baca <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination Customization --}}
                <div class="mt-14 mb-10 flex justify-center">
                    {{-- Minimal styles for pagination --}}
                    <style>
                        nav[role="navigation"] div.hidden { display: none !important; }
                        nav[role="navigation"] div.flex { justify-content: center; }
                        nav[role="navigation"] a, nav[role="navigation"] span.relative {
                            @apply w-10 h-10 flex items-center justify-center rounded-lg border border-gray-200 text-sm font-semibold mx-1 shadow-sm transition-colors;
                        }
                        nav[role="navigation"] span[aria-current="page"] span {
                            @apply w-full h-full flex items-center justify-center bg-[#0a256a] text-white rounded-lg border-[#0a256a];
                        }
                        nav[role="navigation"] a:hover {
                            @apply bg-gray-50 text-[#0a256a] border-gray-300;
                        }
                    </style>
                    <div class="bg-white rounded-xl shadow-[0_2px_10px_rgb(0,0,0,0.03)] border border-gray-100 p-2 inline-flex">
                        {{ $article->count() > 0 ? $articles->withQueryString()->links('pagination::tailwind') : '' }}
                    </div>
                </div>
            @else
                <div class="text-center py-24 bg-white rounded-3xl border border-gray-100 shadow-sm mt-8">
                    <svg class="w-20 h-20 text-gray-300 mx-auto mb-5" fill="none" class="stroke-1" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Artikel</h3>
                    <p class="text-sm text-gray-500 max-w-sm mx-auto">Kami belum menemukan artikel dengan pencarian atau kategori tersebut.</p>
                </div>
            @endif
        </div>
    </section>

@endsection
