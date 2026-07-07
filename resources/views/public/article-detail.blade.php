{{-- resources/views/public/article-detail.blade.php --}}

@extends('layouts.public')

@section('title', $article->meta_title . ' - Sistem Informasi Posyandu Digital')
@section('description', $article->meta_description)

@push('styles')
<style>
    .article-content {
        @apply text-gray-700 dark:text-gray-300 leading-relaxed text-[15px] p-6 lg:p-8;
    }
    .article-content h2 {
        @apply text-[1.4rem] font-bold mt-8 mb-4 text-[#143d96] dark:text-blue-400;
    }
    .article-content h3 {
        @apply text-[1.2rem] font-bold mt-6 mb-3 text-[#143d96] dark:text-blue-400;
    }
    .article-content p {
        @apply mb-5;
    }
    .article-content ul, .article-content ol {
        @apply mb-5 pl-5;
    }
    .article-content ul {
        @apply list-disc;
    }
    .article-content li {
        @apply mb-2;
    }
    .article-content blockquote {
        @apply border border-blue-200 border-dashed bg-blue-50/50 dark:bg-gray-800/50 dark:border-gray-600 rounded-xl px-6 py-5 my-6 text-gray-600 dark:text-gray-400 italic flex gap-3;
    }
    .article-content img {
        @apply rounded-xl shadow-sm my-8 max-w-full h-auto;
    }
    .article-content table {
        @apply w-full my-6 border-collapse text-sm;
    }
    .article-content table th {
        @apply bg-slate-50 dark:bg-gray-800 p-3 border border-slate-200 dark:border-gray-700 text-left font-semibold;
    }
    .article-content table td {
        @apply p-3 border border-slate-200 dark:border-gray-700;
    }
</style>
@endpush

@section('content')
<div class="py-8 lg:py-12 bg-[#F9FAFF] dark:bg-gray-900 min-h-screen font-sans">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Breadcrumb --}}
        <nav class="flex items-center text-[13px] font-medium text-gray-500 dark:text-gray-400 mb-6" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-blue-600 transition-colors">Beranda</a>
            <svg class="w-3 h-3 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('public.articles') }}" class="hover:text-blue-600 transition-colors">Artikel</a>
            <svg class="w-3 h-3 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-blue-600">{{ $article->category->name }}</span>
        </nav>

        {{-- Header Data --}}
        <h1 class="text-3xl md:text-5xl leading-[1.2] font-bold text-[#111827] dark:text-white mb-6 tracking-tight">
            {{ $article->title }}
        </h1>

        <div class="flex flex-wrap items-center gap-x-6 gap-y-3 mb-8 text-[13px] text-gray-500 font-medium">
            <span class="flex items-center text-gray-900 dark:text-gray-200 font-semibold gap-2">
                <div class="w-7 h-7 rounded-full overflow-hidden shrink-0 border border-gray-200">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($article->user->name) }}&background=E8EFFF&color=143d96" alt="{{ $article->user->name }}" class="w-full h-full object-cover">
                </div>
                {{ $article->user->name }}
            </span>
            <span class="flex items-center gap-1.5">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                {{ $article->published_at ? $article->published_at->format('d F Y') : '-' }}
            </span>
            <span class="flex items-center gap-1.5">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ $article->reading_time }}
            </span>
            <span class="flex items-center gap-1.5">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                {{ number_format($article->views) }} Dilihat
            </span>
        </div>

        {{-- Thumbnail --}}
        @if($article->thumbnail)
            <div class="mb-10 rounded-2xl overflow-hidden relative w-full aspect-[21/9]">
                <img src="{{ $article->thumbnail_url }}" 
                     alt="{{ $article->title }}" 
                     class="w-full h-full object-cover">
            </div>
        @endif

        {{-- Main Layout: Article + Share Sidebar --}}
        <div class="flex flex-col lg:flex-row gap-8">
            
            {{-- Left Column: Article Content --}}
            <article class="flex-1 lg:max-w-4xl w-full">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-[0_2px_15px_rgb(0,0,0,0.03)] border border-[#eef2f9] dark:border-gray-700/60 mb-8 overflow-hidden">
                    
                    {{-- Body --}}
                    <div class="article-content">
                        {!! $article->content !!}
                    </div>

                    {{-- Tags inside the box at the very bottom --}}
                    <div class="px-6 lg:px-8 pb-8 flex flex-wrap gap-2">
                        @if($article->tags->count() > 0)
                            @foreach($article->tags as $tag)
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-[#f0f4ff] text-[#3461ff] dark:bg-gray-700 dark:text-blue-300">
                                    #{{ $tag->name }}
                                </span>
                            @endforeach
                        @else
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-[#f0f4ff] text-[#3461ff]">
                                #Posyandu
                            </span>
                        @endif
                    </div>
                </div>
            </article>

            {{-- Right Column: Sticky Share --}}
            <aside class="lg:w-[60px] shrink-0 pt-4">
                <div class="sticky top-28 flex flex-col items-center gap-3 w-full">
                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-1 text-center w-full block">Share</span>
                    
                    <button onclick="shareArticle('whatsapp')" class="w-10 h-10 rounded-full bg-[#25D366] hover:bg-[#1fae52] text-white flex items-center justify-center transition-transform hover:-translate-y-1 shadow-md shadow-green-100" aria-label="Share ke WhatsApp">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    </button>
                    
                    <button onclick="shareArticle('facebook')" class="w-10 h-10 rounded-full bg-[#1877f2] hover:bg-[#1460c5] text-white flex items-center justify-center transition-transform hover:-translate-y-1 shadow-md shadow-blue-100" aria-label="Share ke Facebook">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </button>
                    
                    <button onclick="shareArticle('telegram')" class="w-10 h-10 rounded-full bg-[#0088cc] hover:bg-[#0077b3] text-white flex items-center justify-center transition-transform hover:-translate-y-1 shadow-md shadow-blue-100" aria-label="Share ke Telegram">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M11.944 0A12 12 0 000 12a12 12 0 0012 12 12 12 0 0012-12A12 12 0 0012 0a12 12 0 00-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 01.171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>
                    </button>
                    
                    <button onclick="copyLink()" class="w-10 h-10 rounded-full bg-[#E5E7EB] hover:bg-gray-300 text-gray-600 flex items-center justify-center transition-transform hover:-translate-y-1 shadow-sm" aria-label="Copy Link">
                        <svg class="w-4 h-4" fill="none" class="stroke-2" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                    </button>
                </div>
            </aside>
        </div>

        <div class="lg:max-w-4xl">
            {{-- Artikel Terkait --}}
            @if($relatedArticles->count() > 0)
                <div class="mt-12 mb-16 pt-8 border-t border-gray-100 dark:border-gray-800">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-[1.35rem] font-bold text-[#1e1b4b] dark:text-white">Artikel Terkait</h3>
                        <a href="{{ route('public.articles') }}" class="text-sm font-bold text-[#143d96] hover:text-blue-800 flex items-center transition-colors">
                            Lihat Semua <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($relatedArticles as $related)
                            <div class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden border border-[#eef2f9] shadow-sm hover:shadow-md transition-shadow group flex flex-col h-full">
                                <div class="relative h-40 overflow-hidden w-full">
                                    <img src="{{ $related->thumbnail_url }}" 
                                         alt="{{ $related->title }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                         loading="lazy">
                                </div>
                                <div class="p-4 flex flex-col flex-1">
                                    <span class="inline-block bg-[#f0f4ff] text-[#3461ff] text-[10px] font-bold px-2 py-0.5 rounded mb-2 w-max tracking-wide uppercase">
                                        {{ $related->category->name }}
                                    </span>
                                    <h4 class="font-bold text-[15px] text-[#111827] dark:text-white leading-snug mb-3">
                                        <a href="{{ route('public.article-detail', $related->slug) }}" class="hover:text-[#143d96] transition-colors line-clamp-2">
                                            {{ $related->title }}
                                        </a>
                                    </h4>
                                    <div class="flex items-center justify-between mt-auto">
                                        <span class="text-[11px] text-gray-500 font-medium">{{ $related->published_at ? $related->published_at->format('d Oct Y') : '-' }}</span>
                                        <span class="flex items-center text-[11px] text-gray-500 font-medium">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            {{ $related->reading_time }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Komentar (Static UI from Screenshot) --}}
            <div class="mt-8 mb-16 pt-8 border-t border-gray-100 dark:border-gray-800">
                <h3 class="text-[1.35rem] font-bold text-[#1e1b4b] dark:text-white mb-6">Komentar (2)</h3>
                
                {{-- Comment List --}}
                <div class="space-y-6 mb-8">
                    {{-- Comment 1 --}}
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-green-100 overflow-hidden shrink-0">
                            <img src="https://ui-avatars.com/api/?name=Ibu+Rahayu&background=random" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-sm font-bold text-gray-900 dark:text-white">Ibu Rahayu</span>
                                <span class="text-[11px] text-gray-500">2 hari yang lalu</span>
                            </div>
                            <p class="text-[13px] text-gray-600 dark:text-gray-400 leading-relaxed bg-[#f8fafc] p-3 rounded-tr-xl rounded-b-xl border border-gray-100">
                                Informasi yang sangat bermanfaat! Saya jadi lebih paham kenapa pemberian zat besi sangat ditekan oleh kader di posyandu desa kami. Terima kasih dok..
                            </p>
                        </div>
                    </div>
                    
                    {{-- Comment 2 --}}
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-blue-100 overflow-hidden shrink-0">
                            <img src="https://ui-avatars.com/api/?name=Bapak+Budi&background=random" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-sm font-bold text-gray-900 dark:text-white">Bapak Budi</span>
                                <span class="text-[11px] text-gray-500">4 hari yang lalu</span>
                            </div>
                            <p class="text-[13px] text-gray-600 dark:text-gray-400 leading-relaxed bg-[#f8fafc] p-3 rounded-tr-xl rounded-b-xl border border-gray-100">
                                Apakah ada tips khusus untuk anak yang susah makan (GTM) dalam pemenuhan nutrisi mikro ini? Mungkin bisa dibahas di artikel selanjutnya.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Tulis Komentar --}}
                <div class="bg-[#f8fafc] rounded-2xl p-6 border border-gray-100">
                    <span class="block text-sm font-bold text-gray-700 mb-3">Tulis Komentar</span>
                    <div class="relative mb-3">
                        <textarea rows="4" class="w-full text-[13px] px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#143d96] focus:border-transparent outline-none resize-none bg-white text-gray-800 transition-all shadow-sm" placeholder="Tuliskan pendapat atau pertanyaan Anda di sini..."></textarea>
                        <div class="absolute bottom-3 right-4 flex items-center text-[10px] text-gray-400">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            Semua komentar dimoderasi
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <span class="text-[11px] text-gray-500">Tersambung sebagai <strong>{{ auth()->user()->name ?? 'Administrator' }}</strong></span>
                        <button class="w-full sm:w-auto px-6 py-2.5 bg-[#0a256a] hover:bg-[#071947] text-white text-[13px] font-bold rounded-lg transition-colors shadow-sm">
                            Kirim Komentar
                        </button>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function shareArticle(platform) {
        const url = encodeURIComponent(window.location.href);
        const title = encodeURIComponent('{{ $article->title }}');
        
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
                title: 'Berhasil menyalin Tautan',
                text: 'Tautan bisa langsung Anda tempelkan.',
                timer: 2000,
                showConfirmButton: false,
                toast: true,
                position: 'bottom-end'
            });
        });
    }
</script>
@endpush
@endsection