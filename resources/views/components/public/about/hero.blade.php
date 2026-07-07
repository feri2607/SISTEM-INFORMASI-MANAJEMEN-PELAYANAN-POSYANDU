{{-- resources/views/components/public/about/hero.blade.php --}}

@props(['about'])

<section class="relative overflow-hidden bg-gradient-to-br from-teal-600 via-teal-700 to-blue-800 py-20 lg:py-28">
    {{-- Background Pattern --}}
    <div class="absolute inset-0 opacity-10">
        <svg class="absolute top-0 right-0 w-full h-full" viewBox="0 0 800 800" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="600" cy="200" r="300" fill="white" opacity="0.3"/>
            <circle cx="700" cy="500" r="200" fill="white" opacity="0.2"/>
            <circle cx="400" cy="700" r="250" fill="white" opacity="0.1"/>
        </svg>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Breadcrumb --}}
        <nav class="flex items-center text-sm text-teal-100 mb-6" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-white transition duration-150">
                <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                </svg>
                Beranda
            </a>
            <span class="mx-2 text-teal-300">/</span>
            <span class="text-white font-medium">Tentang Posyandu</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            {{-- Left Content --}}
            <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
                <div class="space-y-6">
                    <span class="inline-block px-3 py-1 bg-[#036672]/30 text-white text-xs font-medium rounded-full backdrop-blur-sm">
                        {{ setting('posyandu_name', 'Posyandu') }}
                    </span>
                    
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white leading-tight"
                        x-show="show"
                        x-transition:enter="transition ease-out duration-700"
                        x-transition:enter-start="opacity-0 transform -translate-y-4"
                        x-transition:enter-end="opacity-100 transform translate-y-0">
                        {{ setting('about_title', 'Tentang Posyandu') }}
                    </h1>
                    
                    <p class="text-lg text-teal-100 leading-relaxed"
                       x-show="show"
                       x-transition:enter="transition ease-out duration-700 delay-100"
                       x-transition:enter-start="opacity-0 transform -translate-y-4"
                       x-transition:enter-end="opacity-100 transform translate-y-0">
                        {{ setting('about_subtitle', 'Mengenal Posyandu sebagai pusat pelayanan kesehatan ibu dan anak yang berperan dalam meningkatkan kualitas kesehatan masyarakat.') }}
                    </p>

                    @if(setting('about_motto'))
                    <div class="flex items-center space-x-2 text-teal-100"
                         x-show="show"
                         x-transition:enter="transition ease-out duration-700 delay-200"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100">
                        <svg class="w-5 h-5 text-teal-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <span class="italic">"{{ setting('about_motto') }}"</span>
                    </div>
                    @endif
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
                    <div class="absolute -inset-4 bg-white/10 rounded-full blur-3xl"></div>
                    <img src="{{ setting('about_image') ? Storage::url(setting('about_image')) : asset('images/about-hero-default.jpg') }}" 
                         alt="Tentang Posyandu" 
                         class="relative w-full max-w-lg mx-auto rounded-2xl shadow-2xl"
                         loading="lazy">
                </div>
            </div>
        </div>
    </div>
</section>