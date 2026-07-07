{{-- resources/views/components/public/about/values.blade.php --}}

@props(['nilai'])

<section class="py-16 bg-white dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12" x-data="{ show: false }" x-intersect="show = true">
            <div x-show="show"
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0 transform -translate-y-4"
                 x-transition:enter-end="opacity-100 transform translate-y-0">
                <span class="inline-block px-3 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 text-xs font-medium rounded-full mb-4">
                    Nilai-nilai
                </span>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Nilai-nilai Posyandu</h2>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
            @php
                $defaultValues = [
                    ['nama' => 'Pelayanan', 'ikon' => 'heart', 'deskripsi' => 'Memberikan pelayanan terbaik untuk masyarakat'],
                    ['nama' => 'Kepedulian', 'ikon' => 'hand', 'deskripsi' => 'Peduli terhadap kesehatan ibu dan anak'],
                    ['nama' => 'Transparansi', 'ikon' => 'eye', 'deskripsi' => 'Terbuka dan jujur dalam setiap layanan'],
                    ['nama' => 'Profesionalisme', 'ikon' => 'briefcase', 'deskripsi' => 'Profesional dalam memberikan pelayanan'],
                    ['nama' => 'Kolaborasi', 'ikon' => 'users', 'deskripsi' => 'Bekerja sama untuk kesehatan masyarakat'],
                ];
                
                $items = $nilai->count() > 0 ? $nilai : $defaultValues;
            @endphp

            @foreach($items as $index => $item)
                <div class="group bg-gray-50 dark:bg-gray-700/50 rounded-2xl p-6 text-center hover:bg-teal-50 dark:hover:bg-teal-900/20 transition duration-300 shadow-sm hover:shadow-lg"
                     x-data="{ show: false }" 
                     x-intersect="show = true">
                    <div x-show="show"
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 transform scale-75"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         x-transition:delay="{{ $index * 100 }}">
                        
                        <div class="inline-flex p-4 bg-teal-100 dark:bg-teal-900/30 rounded-full mb-4 group-hover:bg-teal-200 dark:group-hover:bg-teal-800/50 transition duration-300">
                            @php
                                $iconName = $item->ikon_html ?? 'check';
                            @endphp
                            <svg class="w-8 h-8 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if($iconName === 'heart')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                @elseif($iconName === 'hand')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                @elseif($iconName === 'eye')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                @elseif($iconName === 'briefcase')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                @elseif($iconName === 'users')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                @elseif($iconName === 'shield-check')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                @endif
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $item->nama ?? $item['nama'] }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $item->deskripsi ?? $item['deskripsi'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>