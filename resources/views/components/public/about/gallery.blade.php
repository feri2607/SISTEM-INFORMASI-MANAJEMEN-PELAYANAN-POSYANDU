{{-- resources/views/components/public/about/gallery.blade.php --}}

@props(['galeri'])

<section class="py-16 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12" x-data="{ show: false }" x-intersect="show = true">
            <div x-show="show"
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0 transform -translate-y-4"
                 x-transition:enter-end="opacity-100 transform translate-y-0">
                <span class="inline-block px-3 py-1 bg-pink-100 dark:bg-pink-900/30 text-pink-700 dark:text-pink-400 text-xs font-medium rounded-full mb-4">
                    Galeri
                </span>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Galeri Kegiatan</h2>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Dokumentasi kegiatan Posyandu</p>
            </div>
        </div>

        @if($galeri->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($galeri as $index => $item)
                    <div class="group relative overflow-hidden rounded-2xl shadow-md hover:shadow-xl transition duration-300"
                         x-data="{ show: false }" 
                         x-intersect="show = true">
                        <div x-show="show"
                             x-transition:enter="transition ease-out duration-500"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             x-transition:delay="{{ $index * 100 }}">
                            
                            <img src="{{ $item->foto_url }}" 
                                 alt="{{ $item->judul }}" 
                                 class="w-full h-48 md:h-56 object-cover group-hover:scale-110 transition duration-500"
                                 loading="lazy">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300">
                                <div class="absolute bottom-0 left-0 right-0 p-4">
                                    <p class="text-white text-sm font-medium">{{ $item->judul }}</p>
                                    @if($item->deskripsi)
                                        <p class="text-white/80 text-xs">{{ $item->deskripsi }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                                <button onclick="openLightbox('{{ $item->foto_url }}', '{{ $item->judul }}')"
                                        class="p-3 bg-white/90 rounded-full shadow-lg hover:bg-white transition duration-150">
                                    <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p class="text-gray-500 dark:text-gray-400">Belum ada galeri</p>
            </div>
        @endif
    </div>
</section>

{{-- Lightbox Modal --}}
<div id="lightbox" class="fixed inset-0 z-50 hidden bg-black/90 flex items-center justify-center p-4"
     @click.self="closeLightbox()">
    <div class="relative max-w-4xl w-full">
        <button onclick="closeLightbox()" 
                class="absolute -top-12 right-0 text-white hover:text-gray-300 transition duration-150">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        <img id="lightboxImage" src="" alt="" class="w-full h-auto rounded-2xl">
        <p id="lightboxCaption" class="text-white text-center mt-4"></p>
    </div>
</div>

<script>
    function openLightbox(imageUrl, caption) {
        document.getElementById('lightboxImage').src = imageUrl;
        document.getElementById('lightboxCaption').textContent = caption || '';
        document.getElementById('lightbox').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        document.getElementById('lightbox').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Close lightbox with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeLightbox();
        }
    });
</script>