{{-- resources/views/components/warga/dashboard/stat-card.blade.php --}}

@props(['title', 'value', 'icon', 'color' => 'blue', 'subtitle' => null])

@php
    $colors = [
        'blue' => 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400',
        'green' => 'bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400',
        'purple' => 'bg-purple-50 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400',
        'orange' => 'bg-orange-50 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400',
        'red' => 'bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400',
        'teal' => 'bg-teal-50 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400',
        'pink' => 'bg-pink-50 dark:bg-pink-900/30 text-pink-600 dark:text-pink-400',
        'yellow' => 'bg-yellow-50 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400',
    ];
    
    $iconPaths = [
        'users' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
        'baby' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
        'calendar' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
        'clipboard' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01',
        'bell' => 'M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0',
        'book-open' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18s-3.332.477-4.5 1.253',
    ];
    
    $iconPath = $iconPaths[$icon] ?? '';
@endphp

<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md hover:shadow-xl transition duration-300 p-6 group">
    <div class="flex items-start justify-between">
        <div class="flex-1">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $title }}</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $value }}</p>
            @if($subtitle)
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">{{ $subtitle }}</p>
            @endif
        </div>
        <div class="flex-shrink-0 ml-4">
            <div class="w-12 h-12 rounded-xl {{ $colors[$color] }} flex items-center justify-center group-hover:scale-110 transition duration-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $iconPath }}"/>
                </svg>
            </div>
        </div>
    </div>
</div>