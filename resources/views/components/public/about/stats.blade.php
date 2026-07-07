{{-- resources/views/components/public/about/stats.blade.php --}}

@props(['stats'])

<section class="py-16 bg-gradient-to-r from-teal-600 to-blue-600 dark:from-teal-800 dark:to-blue-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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
            
            <div class="text-center text-white">
                <div class="text-4xl font-bold" x-text="counters.warga.toLocaleString()">0</div>
                <p class="text-sm text-teal-100 mt-2">Total Warga</p>
            </div>

            <div class="text-center text-white">
                <div class="text-4xl font-bold" x-text="counters.balita.toLocaleString()">0</div>
                <p class="text-sm text-teal-100 mt-2">Total Balita</p>
            </div>

            <div class="text-center text-white">
                <div class="text-4xl font-bold" x-text="counters.kader.toLocaleString()">0</div>
                <p class="text-sm text-teal-100 mt-2">Total Kader</p>
            </div>

            <div class="text-center text-white">
                <div class="text-4xl font-bold" x-text="counters.kegiatan.toLocaleString()">0</div>
                <p class="text-sm text-teal-100 mt-2">Total Kegiatan</p>
            </div>
        </div>
    </div>
</section>