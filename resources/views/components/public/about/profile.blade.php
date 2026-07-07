{{-- resources/views/components/public/about/profile.blade.php --}}

@props(['about'])

<section class="py-16 bg-white dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            {{-- Left: Image --}}
            <div class="relative" 
                 x-data="{ show: false }" 
                 x-intersect="show = true">
                <div class="absolute -inset-4 bg-gradient-to-r from-teal-100/50 to-blue-100/50 dark:from-teal-900/20 dark:to-blue-900/20 rounded-2xl blur-2xl"></div>
                <div class="relative rounded-2xl overflow-hidden shadow-2xl"
                     x-show="show"
                     x-transition:enter="transition ease-out duration-700"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     x-transition:enter-end="opacity-100 transform scale-100">
                    <img src="{{ setting('about_image') ? Storage::url(setting('about_image')) : asset('images/about-profil-default.jpg') }}" 
                         alt="Profil Posyandu" 
                         class="w-full h-80 object-cover"
                         loading="lazy">
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-6">
                        <p class="text-white text-sm font-medium">{{ setting('posyandu_name', 'Posyandu') }}</p>
                        <p class="text-teal-200 text-xs">Wilayah: {{ setting('posyandu_village', '-') }}</p>
                    </div>
                </div>
            </div>

            {{-- Right: Content --}}
            <div x-data="{ show: false }" x-intersect="show = true">
                <div x-show="show"
                     x-transition:enter="transition ease-out duration-700 delay-200"
                     x-transition:enter-start="opacity-0 transform translate-x-8"
                     x-transition:enter-end="opacity-100 transform translate-x-0">
                    
                    <span class="inline-block px-3 py-1 bg-teal-100 dark:bg-teal-900/30 text-teal-700 dark:text-teal-400 text-xs font-medium rounded-full mb-4">
                        Profil
                    </span>
                    
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                        Profil Posyandu
                    </h2>
                    
                    <div class="space-y-4 text-gray-600 dark:text-gray-400 leading-relaxed">
                        <p>{{ setting('about_content', 'Deskripsi Posyandu belum tersedia.') }}</p>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0 w-10 h-10 bg-teal-100 dark:bg-teal-900/30 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Kecamatan</p>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ setting('posyandu_district', '-') }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0 w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Desa/Kelurahan</p>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ setting('posyandu_village', '-') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>