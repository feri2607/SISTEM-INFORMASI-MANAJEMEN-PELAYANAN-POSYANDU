{{-- resources/views/components/public/announcements.blade.php --}}

@props(['pengumumans'])

<section class="py-16 bg-white dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row items-center justify-between mb-12">
            <div>
                <span class="inline-block px-3 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 text-xs font-medium rounded-full mb-4">
                    Pengumuman
                </span>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Pengumuman Terbaru</h2>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Informasi penting dari Posyandu</p>
            </div>
            <a href="{{ route('public.announcements') }}" 
               class="mt-4 sm:mt-0 inline-flex items-center text-teal-600 hover:text-teal-700 dark:text-teal-400 dark:hover:text-teal-300 font-medium">
                Lihat Semua Pengumuman
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        @if($pengumumans->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($pengumumans as $pengumuman)
                    <x-public.announcement-card :announcement="$pengumuman" />
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                </svg>
                <p class="text-gray-500 dark:text-gray-400">Belum ada pengumuman</p>
            </div>
        @endif
    </div>
</section>