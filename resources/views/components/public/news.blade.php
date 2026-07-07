{{-- resources/views/components/public/news.blade.php --}}

@props(['beritas'])

<section class="py-16 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row items-center justify-between mb-12">
            <div>
                <span class="inline-block px-3 py-1 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 text-xs font-medium rounded-full mb-4">
                    Berita
                </span>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Berita Terbaru</h2>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Informasi terkini seputar Posyandu</p>
            </div>
            <a href="{{ route('public.news') }}" 
               class="mt-4 sm:mt-0 inline-flex items-center text-teal-600 hover:text-teal-700 dark:text-teal-400 dark:hover:text-teal-300 font-medium">
                Lihat Semua Berita
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        @if($beritas->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($beritas as $berita)
                    <div class="group bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition duration-300">
                        <div class="relative overflow-hidden h-48">
                            <img src="{{ $berita->thumbnail_url }}" 
                                 alt="{{ $berita->title }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                 loading="lazy">
                            <div class="absolute top-4 left-4">
                                <span class="px-2 py-1 bg-[#036672] text-white text-xs font-medium rounded-full">
                                    Berita
                                </span>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center text-xs text-gray-500 dark:text-gray-400 mb-2">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $berita->published_at ? $berita->published_at->format('d M Y') : '-' }}
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2">
                                {{ $berita->title }}
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-3">
                                {{ $berita->excerpt }}
                            </p>
                            <a href="{{ route('public.news-detail', $berita->slug) }}" 
                               class="inline-flex items-center text-teal-600 hover:text-teal-700 dark:text-teal-400 dark:hover:text-teal-300 font-medium mt-4 text-sm">
                                Baca Selengkapnya
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
                <p class="text-gray-500 dark:text-gray-400">Belum ada berita</p>
            </div>
        @endif
    </div>
</section>