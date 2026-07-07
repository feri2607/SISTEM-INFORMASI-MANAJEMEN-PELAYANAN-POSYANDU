{{-- resources/views/components/public/about/goals.blade.php --}}

@props(['about'])

<section class="py-16 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12" x-data="{ show: false }" x-intersect="show = true">
            <div x-show="show"
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0 transform -translate-y-4"
                 x-transition:enter-end="opacity-100 transform translate-y-0">
                <span class="inline-block px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400 text-xs font-medium rounded-full mb-4">
                    Tujuan
                </span>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Tujuan Posyandu</h2>
            </div>
        </div>

        @php
            $about_values_raw = setting('about_values', '');
            $tujuans = array_filter(array_map('trim', explode("\n", $about_values_raw)));
            if (empty($tujuans)) {
                $tujuans = [
                    'Meningkatkan kesehatan ibu dan anak.',
                    'Menurunkan angka stunting.',
                    'Meningkatkan cakupan imunisasi.',
                    'Memberikan edukasi kesehatan kepada masyarakat.',
                    'Meningkatkan akses pelayanan kesehatan.',
                    'Membangun kesadaran masyarakat akan pentingnya kesehatan.',
                ];
            }
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($tujuans as $index => $tujuan)
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-md hover:shadow-lg transition duration-300 border-l-4 border-teal-500"
                     x-data="{ show: false }" 
                     x-intersect="show = true">
                    <div x-show="show"
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 transform translate-x-4"
                         x-transition:enter-end="opacity-100 transform translate-x-0"
                         x-transition:delay="{{ $index * 100 }}">
                        
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 w-8 h-8 bg-teal-100 dark:bg-teal-900/30 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-teal-600 dark:text-teal-400">{{ $index + 1 }}</span>
                            </div>
                            <p class="text-gray-700 dark:text-gray-300">{{ $tujuan }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>