{{-- resources/views/components/dashboard-stat.blade.php --}}

@props([
    'title',
    'value',
    'icon',
    'color' => 'blue',
    'subtitle' => null
])
@php
    $colors = [
        'blue' => 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400',
        'green' => 'bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400',
        'purple' => 'bg-purple-50 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400',
        'red' => 'bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400',
        'yellow' => 'bg-yellow-50 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400',
    ];

    $icons = [
        'user-group' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
        'baby' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
        'calendar' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
        'exclamation-circle' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z',
    ];
@endphp

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 transition-all duration-300 hover:shadow-lg">
    <div class="flex items-start justify-between">
    <div class="flex-1 min-w-0">
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400 truncate">{{ $title }}</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1 animate-count">
                {{ $value }}
            </p>
            @if($subtitle)
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $subtitle }}</p>
             @endif
        </div>
        <div class="flex-shrink-0 ml-4">
            <div class="w-12 h-12 rounded-lg {{ $colors[$color] }} flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icons[$icon] }}"/>
                </svg>
            </div>
        </div>
    </div>
</div>