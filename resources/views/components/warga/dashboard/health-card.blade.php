{{-- resources/views/components/warga/dashboard/health-card.blade.php --}}

@props(['title', 'icon', 'description', 'data', 'route', 'color' => 'blue'])

@php
    $colors = [
        'blue' => 'from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-900/10 border-blue-200 dark:border-blue-800',
        'green' => 'from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-900/10 border-green-200 dark:border-green-800',
        'purple' => 'from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-900/10 border-purple-200 dark:border-purple-800',
        'pink' => 'from-pink-50 to-pink-100 dark:from-pink-900/20 dark:to-pink-900/10 border-pink-200 dark:border-pink-800',
        'yellow' => 'from-yellow-50 to-yellow-100 dark:from-yellow-900/20 dark:to-yellow-900/10 border-yellow-200 dark:border-yellow-800',
        'red' => 'from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-900/10 border-red-200 dark:border-red-800',
    ];
    
    $buttonColors = [
        'blue' => 'bg-blue-600 hover:bg-blue-700',
        'green' => 'bg-green-600 hover:bg-green-700',
        'purple' => 'bg-purple-600 hover:bg-purple-700',
        'pink' => 'bg-pink-600 hover:bg-pink-700',
        'yellow' => 'bg-yellow-600 hover:bg-yellow-700',
        'red' => 'bg-red-600 hover:bg-red-700',
    ];
@endphp

<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border-t-4 border-{{ $color }}-500 hover:shadow-xl transition duration-300">
    <div class="p-6">
        <div class="flex items-start justify-between mb-4">
            <div>
                <div class="text-3xl mb-2">{{ $icon }}</div>
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $title }}</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $description }}</p>
            </div>
            <span class="px-2 py-1 text-xs font-medium rounded-full bg-{{ $color }}-100 dark:bg-{{ $color }}-900/30 text-{{ $color }}-700 dark:text-{{ $color }}-400">
                {{ $data['total'] ?? 0 }}
            </span>
        </div>

        <div class="space-y-2 text-sm">
            @foreach($data as $key => $value)
                @if($key !== 'total')
                    <div class="flex items-center justify-between py-1 border-b border-gray-100 dark:border-gray-700 last:border-0">
                        <span class="text-gray-600 dark:text-gray-400">{{ ucwords(str_replace('_', ' ', $key)) }}</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $value }}</span>
                    </div>
                @endif
            @endforeach
        </div>

        <div class="mt-4">
            <a href="{{ $route }}" 
               class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white {{ $buttonColors[$color] }} rounded-lg transition duration-150">
                Lihat Detail
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>
</div>