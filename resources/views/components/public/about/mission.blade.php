{{-- resources/views/components/public/about/mission.blade.php --}}

@props(['about'])

<section class="py-16 bg-white dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12" x-data="{ show: false }" x-intersect="show = true">
            <div x-show="show"
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0 transform -translate-y-4"
                 x-transition:enter-end="opacity-100 transform translate-y-0">
                <span class="inline-block px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-medium rounded-full mb-4">
                    Misi
                </span>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Misi Posyandu</h2>
            </div>
        </div>

        @php
            $misis = json_decode(setting('missions', '[]'), true);
            if (empty($misis)) {
                $misis = [
                    'Meningkatkan kesehatan ibu dan anak melalui pelayanan yang berkualitas.',
                    'Menurunkan angka stunting melalui intervensi gizi yang tepat.',
                    'Meningkatkan cakupan imunisasi bagi balita.',
                    'Memberikan edukasi kesehatan kepada masyarakat secara berkelanjutan.',
                    'Membangun kemitraan dengan berbagai pihak untuk mendukung kesehatan masyarakat.',
                ];
            }
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($misis as $index => $misi)
                <div class="group bg-gray-50 dark:bg-gray-700/50 rounded-2xl p-6 hover:bg-teal-50 dark:hover:bg-teal-900/20 transition duration-300 shadow-sm hover:shadow-lg"
                     x-data="{ show: false }" 
                     x-intersect="show = true">
                    <div x-show="show"
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 transform translate-y-4"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         x-transition:delay="{{ $index * 100 }}">
                        
                        <div class="inline-flex p-3 bg-teal-100 dark:bg-teal-900/30 rounded-xl mb-4 group-hover:bg-teal-200 dark:group-hover:bg-teal-800/50 transition duration-300">
                            <svg class="w-6 h-6 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Misi {{ $index + 1 }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $misi }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>