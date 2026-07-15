{{-- laporan/tabs/wuspus.blade.php --}}
<div class="space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Laporan Pelayanan WUS / PUS</h2>
            <p class="text-sm text-gray-500 mt-0.5">Wanita Usia Subur & Pasangan Usia Subur</p>
        </div>
        <span class="px-3 py-1.5 bg-purple-50 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 rounded-lg text-sm font-semibold border border-purple-100 dark:border-purple-800">
            {{ $data->total() ?? 0 }} Total Data
        </span>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider bg-gray-50 dark:bg-gray-900/50">Tanggal</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider bg-gray-50 dark:bg-gray-900/50">Nama Peserta</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider bg-gray-50 dark:bg-gray-900/50">Jenis Pelayanan</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider bg-gray-50 dark:bg-gray-900/50">Jenis KB</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider bg-gray-50 dark:bg-gray-900/50">Petugas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($data as $row)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition-colors">
                        <td class="px-5 py-3.5 text-gray-500 dark:text-gray-400 whitespace-nowrap">{{ $row->created_at->format('d M Y') }}</td>
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-full bg-purple-100 dark:bg-purple-900/40 flex items-center justify-center text-purple-600 text-xs font-bold flex-shrink-0">
                                    {{ strtoupper(substr($row->wus->warga->nama ?? 'W', 0, 1)) }}
                                </div>
                                <span class="font-semibold text-gray-900 dark:text-white">{{ $row->wus->warga->nama ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3.5">
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-purple-100 text-purple-700">{{ $row->jenis_pelayanan_label ?? '-' }}</span>
                        </td>
                        <td class="px-5 py-3.5 text-gray-700 dark:text-gray-300">{{ $row->jenis_kontrasepsi ?? '-' }}</td>
                        <td class="px-5 py-3.5 text-gray-600 dark:text-gray-300">{{ $row->user->name ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-5 py-10 text-center text-gray-400 text-sm">Tidak ada data laporan WUS/PUS.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($data->hasPages())
        <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-700">{{ $data->withQueryString()->links() }}</div>
        @endif
    </div>
</div>