{{-- resources/views/components/public/about/cta.blade.php --}}

<section class="py-16 bg-gradient-to-r from-teal-600 to-blue-600 dark:from-teal-800 dark:to-blue-800">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
            Mari Bergabung Bersama Posyandu
        </h2>
        <p class="text-lg text-teal-50 dark:text-gray-300 mb-8">
            Dapatkan informasi kesehatan ibu dan anak secara mudah melalui Sistem Informasi Posyandu.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('register') }}" 
               class="px-8 py-3 bg-white text-teal-700 font-semibold rounded-xl hover:bg-gray-100 transition duration-200 shadow-lg hover:shadow-xl flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                Daftar Sekarang
            </a>
            <a href="{{ route('public.schedule') }}" 
               class="px-8 py-3 bg-[#036672]/30 text-white font-semibold rounded-xl hover:bg-[#036672]/50 transition duration-200 border border-white/20 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Lihat Jadwal
            </a>
        </div>
    </div>
</section>