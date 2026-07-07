{{-- resources/views/components/public/about/vision.blade.php --}}

@props(['about'])

<section class="py-16 bg-gradient-to-r from-teal-600 to-blue-600 dark:from-teal-800 dark:to-blue-800">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center" 
         x-data="{ show: false }" 
         x-intersect="show = true">
        <div x-show="show"
             x-transition:enter="transition ease-out duration-700"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100">
            
            <div class="inline-flex p-4 bg-white/10 rounded-2xl backdrop-blur-sm mb-6">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            
            <span class="inline-block px-3 py-1 bg-white/20 text-white text-xs font-medium rounded-full mb-4">
                Visi
            </span>
            
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Visi Posyandu</h2>
            
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20">
                <p class="text-xl md:text-2xl text-white leading-relaxed font-light">
                    "{{ setting('vision_text', 'Mewujudkan balita sehat, cerdas, dan sejahtera untuk generasi masa depan yang gemilang.') }}"
                </p>
            </div>
        </div>
    </div>
</section>