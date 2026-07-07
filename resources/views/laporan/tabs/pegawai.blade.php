{{-- resources/views/laporan/tabs/pegawai.blade.php --}}
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden border border-gray-200 dark:border-gray-700">
    <div class="p-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 flex justify-between items-center">
        <h3 class="text-lg font-bold text-gray-800 dark:text-white">Laporan Kinerja Pegawai</h3>
        <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-semibold">Berdasarkan Filter Sistem Aktif</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400">
                <tr>
                    <th class="px-6 py-3 text-left font-medium uppercase tracking-wider">Nama Pegawai</th>
                    <th class="px-6 py-3 text-center font-medium uppercase tracking-wider">Pelayanan Balita</th>
                    <th class="px-6 py-3 text-center font-medium uppercase tracking-wider">Pelayanan Kehamilan</th>
                    <th class="px-6 py-3 text-center font-medium uppercase tracking-wider">Pelayanan WUS/PUS</th>
                    <th class="px-6 py-3 text-center font-medium uppercase tracking-wider">Pelayanan Remaja</th>
                    <th class="px-6 py-3 text-center font-medium uppercase tracking-wider">Pelayanan Lansia</th>
                    <th class="px-6 py-3 text-center font-medium text-gray-900 dark:text-white uppercase tracking-wider">Total Dilayani</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($data as $row)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                        <td class="px-6 py-4 font-bold text-gray-900 dark:text-white flex items-center">
                            <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 mr-3 shrink-0">
                                {{ substr($row->nama, 0, 1) }}
                            </div>
                            {{ $row->nama }}
                        </td>
                        <td class="px-6 py-4 text-center">{{ $row->balita_count }}</td>
                        <td class="px-6 py-4 text-center">{{ $row->kehamilan_count }}</td>
                        <td class="px-6 py-4 text-center">{{ $row->wus_count }}</td>
                        <td class="px-6 py-4 text-center">{{ $row->remaja_count }}</td>
                        <td class="px-6 py-4 text-center">{{ $row->lansia_count }}</td>
                        <td class="px-6 py-4 text-center font-bold text-lg text-indigo-600 dark:text-indigo-400">{{ $row->total }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">Belum ada pegawai.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
