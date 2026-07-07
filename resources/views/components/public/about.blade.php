{{-- resources/views/components/public/about.blade.php --}}

<section class="py-16 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            {{-- Left: Image --}}
            <div class="relative">
                <div class="absolute -inset-4 bg-gradient-to-r from-teal-200/30 to-blue-200/30 rounded-2xl blur-2xl"></div>
                <div class="relative rounded-2xl overflow-hidden shadow-2xl">
                    <img src="{{ setting('about_image') ? Storage::url(setting('about_image')) : asset('images/about-posyandu.jpg') }}" 
                         alt="Tentang Posyandu" 
                         class="w-full h-80 object-cover"
                         loading="lazy">
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-6">
                        <p class="text-white text-sm font-medium">Pelayanan Kesehatan Ibu dan Anak</p>
                    </div>
                </div>
            </div>

            {{-- Right: Content --}}
            <div>
                <span class="inline-block px-3 py-1 bg-teal-100 dark:bg-teal-900/30 text-teal-700 dark:text-teal-400 text-xs font-medium rounded-full mb-4">
                    Tentang Kami
                </span>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                    {{ setting('about_title', 'Tentang Posyandu') }}
                </h2>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed mb-6">
                    {{ setting('about_content', 'Posyandu adalah pusat kegiatan masyarakat yang memberikan pelayanan kesehatan dasar, terutama untuk ibu hamil, ibu menyusui, bayi, dan balita. Kegiatan Posyandu meliputi penimbangan, pengukuran tinggi badan, imunisasi, pemberian vitamin, dan konsultasi gizi.') }}
                </p>

                {{-- Visi & Misi --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm">
                        <div class="flex items-center space-x-2 mb-2">
                            <svg class="w-5 h-5 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <h4 class="font-semibold text-gray-900 dark:text-white">Visi</h4>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ setting('vision_text', 'Terwujudnya masyarakat sehat dan mandiri melalui pelayanan kesehatan ibu dan anak yang berkualitas.') }}
                        </p>
                    </div>
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm">
                        <div class="flex items-center space-x-2 mb-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <h4 class="font-semibold text-gray-900 dark:text-white">Misi</h4>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            @php
                                $misis = json_decode(setting('missions', '[]'), true);
                                $firstMisi = !empty($misis) && isset($misis[0]) ? $misis[0] : 'Meningkatkan derajat kesehatan masyarakat melalui pelayanan kesehatan yang terjangkau dan bermutu.';
                            @endphp
                            {{ $firstMisi }}
                        </p>
                    </div>
                </div>

                <a href="{{ route('about') }}" 
                   class="inline-flex items-center text-teal-600 hover:text-teal-700 dark:text-teal-400 dark:hover:text-teal-300 font-medium">
                    Baca Selengkapnya
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>