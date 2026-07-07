{{-- resources/views/components/public/about/organization.blade.php --}}

@props(['struktur'])

<section class="py-16 bg-white dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12" x-data="{ show: false }" x-intersect="show = true">
            <div x-show="show"
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0 transform -translate-y-4"
                 x-transition:enter-end="opacity-100 transform translate-y-0">
                <span class="inline-block px-3 py-1 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400 text-xs font-medium rounded-full mb-4">
                    Struktur
                </span>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Struktur Organisasi</h2>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Pengurus Posyandu yang berdedikasi</p>
            </div>
        </div>

        @php
            $defaultStruktur = [
                ['nama' => 'Dr. Siti Rahayu', 'jabatan' => 'Ketua Posyandu', 'deskripsi' => 'Memimpin dan mengkoordinasikan seluruh kegiatan Posyandu'],
                ['nama' => 'Dewi Lestari, S.KM', 'jabatan' => 'Sekretaris', 'deskripsi' => 'Mengelola administrasi dan dokumentasi Posyandu'],
                ['nama' => 'Rina Fitriani, S.E', 'jabatan' => 'Bendahara', 'deskripsi' => 'Mengelola keuangan dan anggaran Posyandu'],
                ['nama' => 'Tim Kader Posyandu', 'jabatan' => 'Kader Posyandu', 'deskripsi' => 'Melaksanakan pelayanan kesehatan kepada masyarakat'],
            ];
            
            $items = $struktur->count() > 0 ? $struktur : $defaultStruktur;
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($items as $index => $item)
                <div class="group bg-gray-50 dark:bg-gray-700/50 rounded-2xl p-6 text-center hover:bg-teal-50 dark:hover:bg-teal-900/20 transition duration-300 shadow-sm hover:shadow-lg"
                     x-data="{ show: false }" 
                     x-intersect="show = true">
                    <div x-show="show"
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 transform scale-75"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         x-transition:delay="{{ $index * 100 }}">
                        
                        <div class="w-24 h-24 mx-auto rounded-full overflow-hidden border-4 border-teal-100 dark:border-teal-900/30 mb-4 group-hover:border-teal-300 dark:group-hover:border-teal-700 transition duration-300">
                            <img src="{{ $item->foto_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($item['nama']) . '&color=7F9CF5&background=EBF4FF&size=150' }}" 
                                 alt="{{ $item->nama ?? $item['nama'] }}" 
                                 class="w-full h-full object-cover"
                                 loading="lazy">
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $item->nama ?? $item['nama'] }}</h3>
                        <p class="text-sm font-medium text-teal-600 dark:text-teal-400 mb-2">{{ $item->jabatan ?? $item['jabatan'] }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $item->deskripsi ?? $item['deskripsi'] ?? '' }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>