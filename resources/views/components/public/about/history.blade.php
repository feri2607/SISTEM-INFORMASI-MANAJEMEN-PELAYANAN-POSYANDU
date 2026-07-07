{{-- resources/views/components/public/about/history.blade.php --}}

@props(['about'])

<section class="py-16 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12" x-data="{ show: false }" x-intersect="show = true">
            <div x-show="show"
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0 transform -translate-y-4"
                 x-transition:enter-end="opacity-100 transform translate-y-0">
                <span class="inline-block px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 text-xs font-medium rounded-full mb-4">
                    Sejarah
                </span>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Sejarah Posyandu</h2>
            </div>
        </div>

        <div class="max-w-4xl mx-auto" x-data="{ show: false }" x-intersect="show = true">
            <div x-show="show"
                 x-transition:enter="transition ease-out duration-700 delay-200"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100">
                
                {{-- Timeline --}}
                <div class="relative">
                    {{-- Vertical Line --}}
                    <div class="absolute left-1/2 transform -translate-x-1/2 h-full w-0.5 bg-teal-200 dark:bg-teal-800"></div>

                    {{-- Event 1 --}}
                    <div class="relative flex items-center justify-between mb-12">
                        <div class="w-5/12 text-right pr-8">
                            <span class="text-sm font-bold text-teal-600 dark:text-teal-400">{{ setting('posyandu_reg', '2020') }}</span>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Pendirian Posyandu</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Posyandu didirikan sebagai pusat pelayanan kesehatan masyarakat.</p>
                        </div>
                        <div class="w-2/12 flex justify-center">
                            <div class="w-6 h-6 bg-teal-500 rounded-full border-4 border-white dark:border-gray-800 shadow-md"></div>
                        </div>
                        <div class="w-5/12 pl-8"></div>
                    </div>

                    {{-- Event 2 --}}
                    <div class="relative flex items-center justify-between mb-12">
                        <div class="w-5/12 pr-8"></div>
                        <div class="w-2/12 flex justify-center">
                            <div class="w-6 h-6 bg-blue-500 rounded-full border-4 border-white dark:border-gray-800 shadow-md"></div>
                        </div>
                        <div class="w-5/12 pl-8">
                            <span class="text-sm font-bold text-blue-600 dark:text-blue-400">2022</span>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Digitalisasi Pelayanan</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Posyandu mulai mengimplementasikan sistem digital untuk pelayanan.</p>
                        </div>
                    </div>

                    {{-- Event 3 --}}
                    <div class="relative flex items-center justify-between">
                        <div class="w-5/12 text-right pr-8">
                            <span class="text-sm font-bold text-teal-600 dark:text-teal-400">2024</span>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Sistem Informasi Posyandu</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Peluncuran Sistem Informasi Posyandu Digital untuk masyarakat.</p>
                        </div>
                        <div class="w-2/12 flex justify-center">
                            <div class="w-6 h-6 bg-teal-500 rounded-full border-4 border-white dark:border-gray-800 shadow-md"></div>
                        </div>
                        <div class="w-5/12 pl-8"></div>
                    </div>
                </div>

                {{-- Description --}}
                <div class="mt-12 p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-md">
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        {{ setting('about_content', 'Sejarah Posyandu belum tersedia.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>