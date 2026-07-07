{{-- resources/views/components/public/hero.blade.php --}}

@if(setting('hero_is_active', '1') == '1')
<section class="relative overflow-hidden bg-gradient-to-br from-teal-50 via-white to-blue-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 pt-32 pb-20 lg:pt-40 lg:pb-28">
    <div class="absolute inset-0 opacity-10">
        @if(setting('hero_background'))
            <img src="{{ Storage::url(setting('hero_background')) }}" class="absolute inset-0 w-full h-full object-cover opacity-20" alt="">
        @else
        <svg class="absolute top-0 right-0 w-1/2 h-full" viewBox="0 0 800 800" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="600" cy="200" r="300" fill="#14B8A6" opacity="0.3"/>
            <circle cx="700" cy="500" r="200" fill="#3B82F6" opacity="0.2"/>
            <circle cx="400" cy="700" r="250" fill="#14B8A6" opacity="0.1"/>
        </svg>
        @endif
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            {{-- Left Content --}}
            <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
                <div class="space-y-6">
                    {{-- Badge --}}
                    <div class="inline-flex items-center px-3 py-1 bg-teal-100 dark:bg-teal-900/30 rounded-full">
                        <span class="relative flex h-2 w-2 mr-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-teal-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-teal-500"></span>
                        </span>
                        <span class="text-xs font-medium text-teal-700 dark:text-teal-400">Sistem Informasi Posyandu</span>
                    </div>

                    {{-- Title --}}
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-gray-900 dark:text-white leading-tight"
                        x-show="show"
                        x-transition:enter="transition ease-out duration-700"
                        x-transition:enter-start="opacity-0 transform -translate-y-4"
                        x-transition:enter-end="opacity-100 transform translate-y-0">
                        @php
                            $titleParts = explode(' ', setting('hero_title', 'Selamat Datang di Posyandu Kami'), 2);
                        @endphp
                        <span class="block">{{ $titleParts[0] ?? 'Selamat' }}</span>
                        <span class="block text-teal-600 dark:text-teal-400">{{ $titleParts[1] ?? 'Datang' }}</span>
                    </h1>

                    {{-- Subtitle --}}
                    <p class="text-lg text-gray-600 dark:text-gray-300 leading-relaxed font-semibold"
                       x-show="show"
                       x-transition:enter="transition ease-out duration-700 delay-50"
                       x-transition:enter-start="opacity-0 transform -translate-y-4"
                       x-transition:enter-end="opacity-100 transform translate-y-0">
                        {{ setting('hero_subtitle', 'Memantau Tumbuh Kembang dengan Penuh Cinta') }}
                    </p>

                    {{-- Description --}}
                    <p class="text-md text-gray-600 dark:text-gray-300 leading-relaxed"
                       x-show="show"
                       x-transition:enter="transition ease-out duration-700 delay-100"
                       x-transition:enter-start="opacity-0 transform -translate-y-4"
                       x-transition:enter-end="opacity-100 transform translate-y-0">
                        {{ setting('hero_description', 'Mendukung pelayanan kesehatan ibu dan anak yang lebih cepat, mudah, transparan, dan terintegrasi.') }}
                    </p>

                    {{-- Buttons --}}
                    <div class="flex flex-wrap gap-4 pt-4"
                         x-show="show"
                         x-transition:enter="transition ease-out duration-700 delay-200"
                         x-transition:enter-start="opacity-0 transform translate-y-4"
                         x-transition:enter-end="opacity-100 transform translate-y-0">
                        <a href="{{ setting('hero_btn_primary_link', '#layanan') }}" 
                           class="px-6 py-3 bg-teal-600 hover:bg-teal-700 text-white font-medium rounded-xl transition duration-200 shadow-lg hover:shadow-teal-500/25 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ setting('hero_btn_primary_text', 'Layanan Kami') }}
                        </a>
                        <a href="{{ setting('hero_btn_secondary_link', '/kontak') }}" 
                           class="px-6 py-3 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 font-medium rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-200 shadow-md flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                            {{ setting('hero_btn_secondary_text', 'Hubungi Kami') }}
                        </a>
                    </div>

                    {{-- Trust Indicators --}}
                    <div class="flex items-center space-x-6 pt-4"
                         x-show="show"
                         x-transition:enter="transition ease-out duration-700 delay-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-teal-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Terpercaya</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-teal-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Terintegrasi</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-teal-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Gratis</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Illustration --}}
            <div class="hidden lg:flex items-center justify-center"
                 x-data="{ show: false }" 
                 x-init="setTimeout(() => show = true, 300)">
                <div x-show="show"
                     x-transition:enter="transition ease-out duration-1000"
                     x-transition:enter-start="opacity-0 transform scale-75"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     class="relative">
                    <div class="absolute -inset-4 bg-gradient-to-r from-teal-200/30 to-blue-200/30 rounded-full blur-3xl"></div>
                    <img src="{{ setting('hero_image') ? Storage::url(setting('hero_image')) : asset('images/hero-illustration.png') }}" 
                         alt="Ilustrasi Posyandu" 
                         class="relative w-full max-w-lg mx-auto animate-float"
                         loading="lazy">
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
    .animate-float {
        animation: float 6s ease-in-out infinite;
    }
</style>
@endif