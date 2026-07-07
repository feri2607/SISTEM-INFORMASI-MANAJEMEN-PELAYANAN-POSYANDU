{{-- resources/views/laporan/tabs/dashboard.blade.php --}}
<div class="space-y-6">
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-[#036672] dark:bg-[#036672] rounded-xl p-5 shadow-lg text-white">
            <p class="text-indigo-100 text-sm font-medium">Total Pelayanan</p>
            <p class="text-3xl font-bold mt-2">{{ $stats['total_pelayanan'] ?? 0 }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl p-5 shadow-sm border-l-4 border-blue-500">
            <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Balita Dilayani</p>
            <p class="text-2xl font-bold mt-2 text-gray-900 dark:text-white">{{ $stats['balita_dilayani'] ?? 0 }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl p-5 shadow-sm border-l-4 border-pink-500">
            <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Ibu Hamil Dilayani</p>
            <p class="text-2xl font-bold mt-2 text-gray-900 dark:text-white">{{ $stats['ibu_hamil_dilayani'] ?? 0 }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl p-5 shadow-sm border-l-4 border-purple-500">
            <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">WUS/PUS Dilayani</p>
            <p class="text-2xl font-bold mt-2 text-gray-900 dark:text-white">{{ $stats['wus_pus_dilayani'] ?? 0 }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl p-5 shadow-sm border-l-4 border-teal-500">
            <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Remaja Dilayani</p>
            <p class="text-2xl font-bold mt-2 text-gray-900 dark:text-white">{{ $stats['remaja_dilayani'] ?? 0 }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl p-5 shadow-sm border-l-4 border-orange-500">
            <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Lansia Dilayani</p>
            <p class="text-2xl font-bold mt-2 text-gray-900 dark:text-white">{{ $stats['lansia_dilayani'] ?? 0 }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl p-5 shadow-sm border-l-4 border-gray-500">
            <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Pegawai Aktif</p>
            <p class="text-2xl font-bold mt-2 text-gray-900 dark:text-white">{{ $stats['pegawai_aktif'] ?? 0 }}</p>
        </div>
    </div>

    {{-- Charts area --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-5 border border-gray-100 dark:border-gray-700">
            <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Grafik Layanan Berdasarkan Kategori</h3>
            <div class="relative h-64">
                <canvas id="kategoriChart"></canvas>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-5 border border-gray-100 dark:border-gray-700">
            <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Overview Kinerja</h3>
            <div class="flex items-center justify-center h-64 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <span class="text-gray-400">Total Pelayanan: {{ $stats['total_pelayanan'] ?? 0 }}</span>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if(document.getElementById('kategoriChart')) {
            const ctx = document.getElementById('kategoriChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Balita', 'Kehamilan', 'WUS/PUS', 'Remaja', 'Lansia'],
                    datasets: [{
                        data: [
                            {{ $stats['balita_dilayani'] ?? 0 }}, 
                            {{ $stats['ibu_hamil_dilayani'] ?? 0 }}, 
                            {{ $stats['wus_pus_dilayani'] ?? 0 }},
                            {{ $stats['remaja_dilayani'] ?? 0 }},
                            {{ $stats['lansia_dilayani'] ?? 0 }}
                        ],
                        backgroundColor: [
                            '#3b82f6', // blue
                            '#ec4899', // pink
                            '#a855f7', // purple
                            '#14b8a6', // teal
                            '#f97316'  // orange
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                color: (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) ? '#cbd5e1' : '#475569'
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
