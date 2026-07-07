{{-- resources/views/laporan/tabs/balita.blade.php --}}
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden border border-gray-200 dark:border-gray-700">
    <div class="p-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 flex justify-between items-center">
        <h3 class="text-lg font-bold text-gray-800 dark:text-white">Laporan Pelayanan Balita</h3>
        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">Total: {{ $data->total() ?? 0 }}</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400">
                <tr>
                    <th class="px-6 py-3 text-left font-medium uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-left font-medium uppercase tracking-wider">Nama Peserta (Balita)</th>
                    <th class="px-6 py-3 text-left font-medium uppercase tracking-wider">Usia (Bulan)</th>
                    <th class="px-6 py-3 text-left font-medium uppercase tracking-wider">Status Gizi (BB/TB)</th>
                    <th class="px-6 py-3 text-left font-medium uppercase tracking-wider">Petugas</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($data as $row)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                        <td class="px-6 py-4">{{ $row->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $row->balita->nama ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $row->umur_bulan ?? '-' }} bln</td>
                        <td class="px-6 py-4">
                            @if($row->status_gizi_bbtb)
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">{{ $row->status_gizi_bbtb }}</span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-500">{{ $row->pegawai->name ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">Data laporan tidak ditemukan untuk filter ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
        {{ $data->withQueryString()->links() ?? '' }}
    </div>
</div>
