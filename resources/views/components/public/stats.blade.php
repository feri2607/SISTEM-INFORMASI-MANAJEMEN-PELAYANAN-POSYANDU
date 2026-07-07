{{-- resources/views/components/public/stats.blade.php --}}

@props(['stats'])

<section class="py-16 bg-white dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Statistik Posyandu</h2>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Data terkini pelayanan Posyandu</p>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6" 
             x-data="{ 
                counters: {
                    warga: 0,
                    balita: 0,
                    kader: 0,
                    kegiatan: 0
                },
                init() {
                    const targetWarga = {{ $stats['total_warga'] ?? 0 }};
                    const targetBalita = {{ $stats['total_balita'] ?? 0 }};
                    const targetKader = {{ $stats['total_kader'] ?? 0 }};
                    const targetKegiatan = {{ $stats['total_kegiatan'] ?? 0 }};
                    
                    this.animateCounter('warga', targetWarga);
                    this.animateCounter('balita', targetBalita);
                    this.animateCounter('kader', targetKader);
                    this.animateCounter('kegiatan', targetKegiatan);
                },
                animateCounter(key, target) {
                    let current = 0;
                    const duration = 2000;
                    const steps = 60;
                    const increment = target / steps;
                    
                    const interval = setInterval(() => {
                        current += increment;
                        if (current >= target) {
                            current = target;
                            clearInterval(interval);
                        }
                        this.counters[key] = Math.floor(current);
                    }, duration / steps);
                }
             }">
            
            {{-- Total Warga --}}
            <div class="bg-gradient-to-br from-teal-50 to-blue-50 dark:from-gray-700 dark:to-gray-800 rounded-2xl p-6 text-center shadow-md hover:shadow-lg transition duration-300">
                <div class="inline-flex p-3 bg-teal-100 dark:bg-teal-900/30 rounded-xl mb-4">
                    <svg class="w-8 h-8 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <p class="text-3xl font-bold text-gray-900 dark:text-white" x-text="counters.warga.toLocaleString()">0</p>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Total Warga</p>
            </div>

            @if(setting('stat_show_balita', '1') == '1')
            {{-- Total Balita --}}
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-gray-700 dark:to-gray-800 rounded-2xl p-6 text-center shadow-md hover:shadow-lg transition duration-300">
                <div class="inline-flex p-3 bg-blue-100 dark:bg-blue-900/30 rounded-xl mb-4">
                    <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-3xl font-bold text-gray-900 dark:text-white" x-text="counters.balita.toLocaleString()">0</p>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Total Balita</p>
            </div>
            @endif

            {{-- Total Kader --}}
            <div class="bg-gradient-to-br from-green-50 to-teal-50 dark:from-gray-700 dark:to-gray-800 rounded-2xl p-6 text-center shadow-md hover:shadow-lg transition duration-300">
                <div class="inline-flex p-3 bg-green-100 dark:bg-green-900/30 rounded-xl mb-4">
                    <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <p class="text-3xl font-bold text-gray-900 dark:text-white" x-text="counters.kader.toLocaleString()">0</p>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Total Kader</p>
            </div>

            {{-- Total Kegiatan --}}
            <div class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-gray-700 dark:to-gray-800 rounded-2xl p-6 text-center shadow-md hover:shadow-lg transition duration-300">
                <div class="inline-flex p-3 bg-purple-100 dark:bg-purple-900/30 rounded-xl mb-4">
                    <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <p class="text-3xl font-bold text-gray-900 dark:text-white" x-text="counters.kegiatan.toLocaleString()">0</p>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Total Kegiatan</p>
            </div>
        </div>
    </div>
</section>