{{-- laporan/tabs/balita.blade.php --}}
<div class="space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Laporan Pelayanan Balita</h2>
            <p class="text-sm text-gray-500 mt-0.5">Riwayat pemeriksaan & status gizi balita</p>
        </div>
        <span class="px-3 py-1.5 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-lg text-sm font-semibold border border-blue-100 dark:border-blue-800">
            {{ $data->total() ?? 0 }} Total Data
        </span>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider bg-gray-50 dark:bg-gray-900/50">Tanggal</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider bg-gray-50 dark:bg-gray-900/50">Nama Balita</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider bg-gray-50 dark:bg-gray-900/50">Usia</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider bg-gray-50 dark:bg-gray-900/50">BB / TB</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider bg-gray-50 dark:bg-gray-900/50">Status Gizi</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider bg-gray-50 dark:bg-gray-900/50">Petugas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($data as $row)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition-colors">
                        <td class="px-5 py-3.5 text-gray-500 dark:text-gray-400 whitespace-nowrap">{{ $row->created_at->format('d M Y') }}</td>
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-full bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center text-blue-600 dark:text-blue-300 text-xs font-bold flex-shrink-0">
                                    {{ strtoupper(substr($row->balita->nama ?? 'B', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $row->balita->nama ?? '-' }}</p>
                                    <p class="text-xs text-gray-400">{{ $row->balita->warga->nama ?? '' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3.5 text-gray-600 dark:text-gray-300">{{ $row->umur_bulan ?? '-' }} bln</td>
                        <td class="px-5 py-3.5 text-gray-600 dark:text-gray-300">{{ $row->berat_badan ?? '-' }} kg / {{ $row->tinggi_badan ?? '-' }} cm</td>
                        <td class="px-5 py-3.5">
                            @if($row->status_gizi_bbtb)
                                @php $gz = strtolower($row->status_gizi_bbtb); $cls = str_contains($gz, 'baik') ? 'bg-green-100 text-green-700' : (str_contains($gz, 'kurang') ? 'bg-orange-100 text-orange-700' : 'bg-red-100 text-red-700'); @endphp
                                <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $cls }}">{{ $row->status_gizi_bbtb }}</span>
                            @else
                                <span class="text-gray-400">–</span>
                            @endif
                        </td>
                        <td class="px-5 py-3.5 text-gray-600 dark:text-gray-300">{{ $row->pegawai->name ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-5 py-10 text-center text-gray-400 text-sm">Tidak ada data laporan balita.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($data->hasPages())
        <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-700">{{ $data->withQueryString()->links() }}</div>
        @endif
    </div>
</div>