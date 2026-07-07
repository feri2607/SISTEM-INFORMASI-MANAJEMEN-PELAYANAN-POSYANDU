{{-- resources/views/public/news-detail.blade.php --}}

@extends('layouts.public')

@section('title', $news->meta_title . ' - Sistem Informasi Posyandu Digital')
@section('description', $news->meta_description)

@push('styles')
<style>
    .news-content {
        @apply text-gray-800 dark:text-gray-200 leading-relaxed;
    }
    .news-content h2 {
        @apply text-2xl font-bold mt-8 mb-4 text-gray-900 dark:text-white;
    }
    .news-content h3 {
        @apply text-xl font-semibold mt-6 mb-3 text-gray-900 dark:text-white;
    }
    .news-content p {
        @apply mb-4;
    }
    .news-content ul, .news-content ol {
        @apply mb-4 pl-5;
    }
    .news-content ul {
        @apply list-disc;
    }
    .news-content ol {
        @apply list-decimal;
    }
    .news-content li {
        @apply mb-1;
    }
    .news-content blockquote {
        @apply border-l-4 border-blue-500 pl-4 py-2 my-4 bg-gray-50 dark:bg-gray-700/50 rounded-r-lg;
    }
    .news-content blockquote p {
        @apply mb-0;
    }
    .news-content img {
        @apply rounded-lg shadow-md my-6 max-w-full h-auto;
    }
    .news-content table {
        @apply w-full my-4 border-collapse;
    }
    .news-content table th {
        @apply bg-gray-100 dark:bg-gray-700 p-2 border border-gray-300 dark:border-gray-600 text-left;
    }
    .news-content table td {
        @apply p-2 border border-gray-300 dark:border-gray-600;
    }
    .news-content iframe {
        @apply rounded-lg shadow-md my-6 w-full aspect-video;
    }
    .news-gallery img {
        @apply rounded-lg shadow-md hover:shadow-xl transition duration-300 cursor-pointer;
    }
</style>
@endpush

@section('content')
<div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Breadcrumb --}}
        <nav class="flex items-center text-sm text-gray-600 dark:text-gray-400 mb-6" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition duration-150">Beranda</a>
            <span class="mx-2">/</span>
            <a href="{{ route('public.news') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition duration-150">Berita</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900 dark:text-white font-medium">{{ $news->title }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            {{-- Main Content --}}
            <div class="lg:col-span-3">
                <article class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
                    {{-- Thumbnail --}}
                    @if($news->thumbnail)
                        <div class="relative h-64 md:h-96">
                            <img src="{{ $news->thumbnail_url }}" 
                                 alt="{{ $news->title }}" 
                                 class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                            <div class="absolute bottom-6 left-6">
                                <span class="px-3 py-1 text-sm font-medium rounded-full bg-[#036672] text-white">
                                    {{ $news->category->name }}
                                </span>
                            </div>
                            @if($news->is_breaking)
                                <div class="absolute top-6 left-6">
                                    <span class="px-4 py-2 text-sm font-bold rounded-full bg-[#036672] text-white animate-pulse">
                                        Breaking News
                                    </span>
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- Content --}}
                    <div class="p-6 md:p-8">
                        {{-- Header --}}
                        <header class="mb-8">
                            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                                {{ $news->title }}
                            </h1>

                            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    {{ $news->user->name }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $news->published_date }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $news->reading_time }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    {{ number_format($news->views) }} dilihat
                                </span>
                            </div>
                        </header>

                        {{-- Body --}}
                        <div class="news-content">
                            {!! $news->content !!}
                        </div>

                        {{-- Gallery --}}
                        @if($news->gallery && count($news->gallery) > 0)
                            <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Galeri</h3>
                                <div class="news-gallery grid grid-cols-2 md:grid-cols-3 gap-4">
                                    @foreach($news->gallery_urls as $image)
                                        <div class="relative overflow-hidden rounded-lg">
                                            <img src="{{ $image }}" 
                                                 alt="Galeri Berita" 
                                                 class="w-full h-48 object-cover cursor-pointer"
                                                 loading="lazy"
                                                 onclick="openLightbox('{{ $image }}')">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Share Buttons --}}
                        <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Bagikan berita ini:</p>
                            <div class="flex flex-wrap gap-3">
                                <button onclick="shareNews('facebook')" 
                                        class="px-4 py-2 bg-[#1877f2] hover:bg-[#0d65d9] text-white text-sm font-medium rounded-lg transition duration-150 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                    Facebook
                                </button>
                                <button onclick="shareNews('whatsapp')" 
                                        class="px-4 py-2 bg-[#25D366] hover:bg-[#1da851] text-white text-sm font-medium rounded-lg transition duration-150 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                    </svg>
                                    WhatsApp
                                </button>
                                <button onclick="shareNews('telegram')" 
                                        class="px-4 py-2 bg-[#0088cc] hover:bg-[#0077b3] text-white text-sm font-medium rounded-lg transition duration-150 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M11.944 0A12 12 0 000 12a12 12 0 0012 12 12 12 0 0012-12A12 12 0 0012 0a12 12 0 00-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 01.171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                                    </svg>
                                    Telegram
                                </button>
                                <button onclick="shareNews('twitter')" 
                                        class="px-4 py-2 bg-[#000000] hover:bg-[#1a1a1a] text-white text-sm font-medium rounded-lg transition duration-150 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                    </svg>
                                    Twitter/X
                                </button>
                                <button onclick="copyLink()" 
                                        class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg transition duration-150 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                    Salin Link
                                </button>
                            </div>
                        </div>
                    </div>
                </article>

                {{-- Related News --}}
                @if($relatedNews->count() > 0)
                    <div class="mt-12">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Berita Terkait</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($relatedNews as $related)
                                <div class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-md hover:shadow-lg transition duration-300">
                                    <div class="relative h-40">
                                        <img src="{{ $related->thumbnail_url }}" 
                                             alt="{{ $related->title }}" 
                                             class="w-full h-full object-cover"
                                             loading="lazy">
                                    </div>
                                    <div class="p-4">
                                        <span class="text-xs text-blue-600 dark:text-blue-400 font-medium">{{ $related->category->name }}</span>
                                        <h4 class="font-semibold text-gray-900 dark:text-white mt-1 line-clamp-2">
                                            <a href="{{ route('public.news-detail', $related->slug) }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition duration-150">
                                                {{ $related->title }}
                                            </a>
                                        </h4>
                                        <a href="{{ route('public.news-detail', $related->slug) }}" 
                                           class="inline-flex items-center text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium mt-2">
                                            Baca Selengkapnya
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-1 space-y-6">
                {{-- Popular News --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Berita Populer</h3>
                    <div class="space-y-4">
                        @foreach($popularNews as $popular)
                            <div class="group">
                                <a href="{{ route('public.news-detail', $popular->slug) }}" 
                                   class="flex items-start space-x-3 hover:text-blue-600 dark:hover:text-blue-400 transition duration-150">
                                    <div class="flex-shrink-0 w-16 h-16 rounded-lg overflow-hidden">
                                        <img src="{{ $popular->thumbnail_url }}" 
                                             alt="{{ $popular->title }}" 
                                             class="w-full h-full object-cover"
                                             loading="lazy">
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900 dark:text-white line-clamp-2 group-hover:text-blue-600 dark:group-hover:text-blue-400">
                                            {{ $popular->title }}
                                        </h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            {{ $popular->views }} dilihat
                                        </p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Categories --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Kategori</h3>
                    <div class="space-y-2">
                        @foreach($categories ?? [] as $category)
                            <a href="{{ route('public.news', ['category' => $category->id]) }}" 
                               class="flex items-center justify-between p-2 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition duration-150">
                                <span class="text-sm text-gray-700 dark:text-gray-300">{{ $category->name }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $category->news_count ?? 0 }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Archive --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Arsip</h3>
                    <div class="space-y-2">
                        @foreach($archives ?? [] as $archive)
                            <a href="{{ route('public.news', ['bulan' => $archive->month, 'tahun' => $archive->year]) }}" 
                               class="flex items-center justify-between p-2 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition duration-150">
                                <span class="text-sm text-gray-700 dark:text-gray-300">{{ $archive->month_name }} {{ $archive->year }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $archive->total }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Lightbox Modal --}}
<div id="lightbox" class="fixed inset-0 z-50 hidden bg-black/90 flex items-center justify-center p-4"
     @click.self="closeLightbox()">
    <div class="relative max-w-4xl w-full">
        <button onclick="closeLightbox()" 
                class="absolute -top-12 right-0 text-white hover:text-gray-300 transition duration-150">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        <img id="lightboxImage" src="" alt="" class="w-full h-auto rounded-2xl">
    </div>
</div>

@push('scripts')
<script>
    function shareNews(platform) {
        const url = encodeURIComponent(window.location.href);
        const title = encodeURIComponent('{{ $news->title }}');
        
        let shareUrl = '';
        switch(platform) {
            case 'facebook':
                shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
                break;
            case 'whatsapp':
                shareUrl = `https://api.whatsapp.com/send?text=${title}%20${url}`;
                break;
            case 'telegram':
                shareUrl = `https://t.me/share/url?url=${url}&text=${title}`;
                break;
            case 'twitter':
                shareUrl = `https://twitter.com/intent/tweet?text=${title}&url=${url}`;
                break;
        }
        
        window.open(shareUrl, '_blank', 'width=600,height=400');
    }

    function copyLink() {
        const url = window.location.href;
        navigator.clipboard.writeText(url).then(() => {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Link berita telah disalin ke clipboard.',
                timer: 2000,
                showConfirmButton: false,
            });
        });
    }

    function openLightbox(imageUrl) {
        document.getElementById('lightboxImage').src = imageUrl;
        document.getElementById('lightbox').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        document.getElementById('lightbox').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeLightbox();
        }
    });
</script>
@endpush
@endsection