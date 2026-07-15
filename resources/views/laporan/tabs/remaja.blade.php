{{-- laporan/tabs/remaja.blade.php --}}
<div class="space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Laporan Pelayanan Remaja</h2>
            <p class="text-sm text-gray-500 mt-0.5">Data pemeriksaan & status anemia remaja</p>
        </div>
        <span class="px-3 py-1.5 bg-teal-50 dark:bg-teal-900/30 text-teal-700 dark:text-teal-300 rounded-lg text-sm font-semibold border border-teal-100 dark:border-teal-800">
            {{ $data->total() ?? 0 }} Total Data
        </span>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider bg-gray-50 dark:bg-gray-900/50">Tanggal</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider bg-gray-50 dark:bg-gray-900/50">Nama Remaja</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider bg-gray-50 dark:bg-gray-900/50">Status Anemia (Hb)</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider bg-gray-50 dark:bg-gray-900/50">Pemberian TTD</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider bg-gray-50 dark:bg-gray-900/50">Petugas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($data as $row)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition-colors">
                        <td class="px-5 py-3.5 text-gray-500 dark:text-gray-400 whitespace-nowrap">{{ $row->created_at->format('d M Y') }}</td>
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-full bg-teal-100 dark:bg-teal-900/40 flex items-center justify-center text-teal-600 text-xs font-bold flex-shrink-0">
                                    {{ strtoupper(substr($row->remaja->warga->nama ?? 'R', 0, 1)) }}
                                </div>
                                <span class="font-semibold text-gray-900 dark:text-white">{{ $row->remaja->warga->nama ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3.5">
                            @if($row->kadar_hb)
                                <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $row->kadar_hb < 12 ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                    {{ $row->kadar_hb }} g/dL {{ $row->kadar_hb < 12 ? '(Anemia)' : '' }}
                                </span>
                            @else
                                <span class="text-gray-400">–</span>
                            @endif
                        </td>
                        <td class="px-5 py-3.5">
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $row->pemberian_ttd ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                {{ $row->pemberian_ttd ? 'Ya' : 'Tidak' }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-gray-600 dark:text-gray-300">{{ $row->pegawai->name ?? $row->user->name ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-5 py-10 text-center text-gray-400 text-sm">Tidak ada data laporan remaja.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($data->hasPages())
        <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-700">{{ $data->withQueryString()->links() }}</div>
        @endif
    </div>
</div>