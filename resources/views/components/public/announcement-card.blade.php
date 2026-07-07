{{-- resources/views/components/public/announcement-card.blade.php --}}

@props(['announcement'])

<div class="flex flex-col h-full group bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition duration-300 border-l-4 
    @if($announcement->priority === 'very_important') border-red-500
    @elseif($announcement->priority === 'important') border-orange-500
    @else border-blue-500 @endif">
    
    @if($announcement->attachment && $announcement->is_attachment_image)
        <a href="{{ route('public.announcement-detail', $announcement->slug) }}" class="block w-full overflow-hidden shrink-0">
            <img src="{{ $announcement->attachment_url }}" alt="{{ $announcement->title }}" class="w-full h-48 object-cover transform group-hover:scale-105 transition duration-500">
        </a>
    @endif

    <div class="p-5 flex flex-col flex-grow">
        {{-- Priority Badge --}}
        <div class="flex items-center justify-between mb-3">
            <span class="px-3 py-1 text-xs font-bold rounded-full {{ $announcement->priority_badge }}">
                @if($announcement->priority === 'very_important')
                    <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                @elseif($announcement->priority === 'important')
                    <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                @endif
                {{ $announcement->priority_label }}
            </span>
            @if($announcement->is_featured)
                <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400">
                    Featured
                </span>
            @endif
        </div>

        {{-- Title --}}
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2">
            <a href="{{ route('public.announcement-detail', $announcement->slug) }}" class="hover:text-yellow-600 dark:hover:text-yellow-400 transition duration-150">
                {{ $announcement->title }}
            </a>
        </h3>

        {{-- Excerpt --}}
        <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-3 mb-3">
            {{ $announcement->excerpt }}
        </p>

        {{-- Meta --}}
        <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500 dark:text-gray-400">
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                {{ $announcement->publish_date }}
            </span>
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ $announcement->expire_date }}
            </span>
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                {{ $announcement->user->name }}
            </span>
        </div>

        {{-- Actions --}}
        <div class="mt-auto pt-4 flex items-center justify-between">
            <a href="{{ route('public.announcement-detail', $announcement->slug) }}" 
               class="inline-flex items-center text-yellow-600 hover:text-yellow-700 dark:text-yellow-400 dark:hover:text-yellow-300 font-medium text-sm">
                Baca Selengkapnya
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
            <span class="text-xs text-gray-400">
                {{ number_format($announcement->views) }} dilihat
            </span>
        </div>
    </div>
</div>