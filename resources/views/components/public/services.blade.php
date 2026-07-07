{{-- resources/views/components/public/services.blade.php --}}

<section class="py-16 bg-white dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="inline-block px-3 py-1 bg-teal-100 dark:bg-teal-900/30 text-teal-700 dark:text-teal-400 text-xs font-medium rounded-full mb-4">
                Layanan
            </span>
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Layanan Posyandu</h2>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Berbagai layanan kesehatan yang tersedia di Posyandu</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            {{-- Service 1 --}}
            <div class="group bg-gray-50 dark:bg-gray-700/50 rounded-2xl p-6 hover:bg-teal-50 dark:hover:bg-teal-900/20 transition duration-300 shadow-sm hover:shadow-lg">
                <div class="inline-flex p-3 bg-teal-100 dark:bg-teal-900/30 rounded-xl mb-4 group-hover:bg-teal-200 dark:group-hover:bg-teal-800/50 transition duration-300">
                    <svg class="w-6 h-6 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Pemeriksaan Balita</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Pemeriksaan kesehatan rutin untuk balita</p>
            </div>

            {{-- Service 2 --}}
            <div class="group bg-gray-50 dark:bg-gray-700/50 rounded-2xl p-6 hover:bg-teal-50 dark:hover:bg-teal-900/20 transition duration-300 shadow-sm hover:shadow-lg">
                <div class="inline-flex p-3 bg-blue-100 dark:bg-blue-900/30 rounded-xl mb-4 group-hover:bg-blue-200 dark:group-hover:bg-blue-800/50 transition duration-300">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Penimbangan Berat Badan</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Monitoring pertumbuhan berat badan balita</p>
            </div>

            {{-- Service 3 --}}
            <div class="group bg-gray-50 dark:bg-gray-700/50 rounded-2xl p-6 hover:bg-teal-50 dark:hover:bg-teal-900/20 transition duration-300 shadow-sm hover:shadow-lg">
                <div class="inline-flex p-3 bg-green-100 dark:bg-green-900/30 rounded-xl mb-4 group-hover:bg-green-200 dark:group-hover:bg-green-800/50 transition duration-300">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Pengukuran Tinggi Badan</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Monitoring pertumbuhan tinggi badan balita</p>
            </div>

            {{-- Service 4 --}}
            <div class="group bg-gray-50 dark:bg-gray-700/50 rounded-2xl p-6 hover:bg-teal-50 dark:hover:bg-teal-900/20 transition duration-300 shadow-sm hover:shadow-lg">
                <div class="inline-flex p-3 bg-purple-100 dark:bg-purple-900/30 rounded-xl mb-4 group-hover:bg-purple-200 dark:group-hover:bg-purple-800/50 transition duration-300">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Imunisasi</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Pemberian imunisasi lengkap untuk balita</p>
            </div>

            {{-- Service 5 --}}
            <div class="group bg-gray-50 dark:bg-gray-700/50 rounded-2xl p-6 hover:bg-teal-50 dark:hover:bg-teal-900/20 transition duration-300 shadow-sm hover:shadow-lg">
                <div class="inline-flex p-3 bg-yellow-100 dark:bg-yellow-900/30 rounded-xl mb-4 group-hover:bg-yellow-200 dark:group-hover:bg-yellow-800/50 transition duration-300">
                    <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Pemberian Vitamin</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Suplemen vitamin untuk meningkatkan imunitas</p>
            </div>

            {{-- Service 6 --}}
            <div class="group bg-gray-50 dark:bg-gray-700/50 rounded-2xl p-6 hover:bg-teal-50 dark:hover:bg-teal-900/20 transition duration-300 shadow-sm hover:shadow-lg">
                <div class="inline-flex p-3 bg-red-100 dark:bg-red-900/30 rounded-xl mb-4 group-hover:bg-red-200 dark:group-hover:bg-red-800/50 transition duration-300">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Konsultasi Gizi</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Konsultasi gizi dan pola makan sehat</p>
            </div>

            {{-- Service 7 --}}
            <div class="group bg-gray-50 dark:bg-gray-700/50 rounded-2xl p-6 hover:bg-teal-50 dark:hover:bg-teal-900/20 transition duration-300 shadow-sm hover:shadow-lg">
                <div class="inline-flex p-3 bg-pink-100 dark:bg-pink-900/30 rounded-xl mb-4 group-hover:bg-pink-200 dark:group-hover:bg-pink-800/50 transition duration-300">
                    <svg class="w-6 h-6 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Pemeriksaan Ibu Hamil</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Pemeriksaan kesehatan ibu hamil</p>
            </div>

            {{-- Service 8 --}}
            <div class="group bg-gray-50 dark:bg-gray-700/50 rounded-2xl p-6 hover:bg-teal-50 dark:hover:bg-teal-900/20 transition duration-300 shadow-sm hover:shadow-lg">
                <div class="inline-flex p-3 bg-indigo-100 dark:bg-indigo-900/30 rounded-xl mb-4 group-hover:bg-indigo-200 dark:group-hover:bg-indigo-800/50 transition duration-300">
                    <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Rujukan Kesehatan</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Rujukan ke fasilitas kesehatan yang lebih lengkap</p>
            </div>
        </div>
    </div>
</section>