{{-- resources/views/components/public/article-card.blade.php --}}

@props(['article'])

<div class="group bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition duration-300">
    {{-- Thumbnail --}}
    <div class="relative overflow-hidden h-48">
        <img src="{{ $article->thumbnail_url }}" 
             alt="{{ $article->title }}" 
             class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
             loading="lazy">
        <div class="absolute top-4 left-4">
            <span class="px-2 py-1 text-xs font-medium rounded-full bg-[#036672] text-white">
                {{ $article->category->name }}
            </span>
        </div>
        @if($article->is_featured)
            <div class="absolute top-4 right-4">
                <span class="px-2 py-1 text-xs font-medium rounded-full bg-[#036672] text-white">
                    Featured
                </span>
            </div>
        @endif
    </div>

    {{-- Content --}}
    <div class="p-5">
        <div class="flex items-center text-xs text-gray-500 dark:text-gray-400 mb-2">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            {{ $article->user->name }}
            <span class="mx-2">•</span>
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            {{ $article->published_at ? $article->published_at->format('d M Y') : '-' }}
            <span class="mx-2">•</span>
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ $article->reading_time }}
        </div>

        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2">
            <a href="{{ route('public.article-detail', $article->slug) }}" class="hover:text-teal-600 dark:hover:text-teal-400 transition duration-150">
                {{ $article->title }}
            </a>
        </h3>
        
        <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-3 mb-3">
            {{ $article->excerpt }}
        </p>

        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4 text-xs text-gray-500 dark:text-gray-400">
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    {{ number_format($article->views) }}
                </span>
            </div>

            <a href="{{ route('public.article-detail', $article->slug) }}" 
               class="inline-flex items-center text-teal-600 hover:text-teal-700 dark:text-teal-400 dark:hover:text-teal-300 font-medium text-sm">
                Baca Selengkapnya
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>
</div>