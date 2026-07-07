{{-- resources/views/laporan/tabs/remaja.blade.php --}}
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden border border-gray-200 dark:border-gray-700">
    <div class="p-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 flex justify-between items-center">
        <h3 class="text-lg font-bold text-gray-800 dark:text-white">Laporan Pelayanan Remaja</h3>
        <span class="px-3 py-1 bg-teal-100 text-teal-800 rounded-full text-xs font-semibold">Total: {{ $data->total() ?? 0 }}</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400">
                <tr>
                    <th class="px-6 py-3 text-left font-medium uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-left font-medium uppercase tracking-wider">Nama Remaja</th>
                    <th class="px-6 py-3 text-left font-medium uppercase tracking-wider">Status Anemia (Hb)</th>
                    <th class="px-6 py-3 text-left font-medium uppercase tracking-wider">Pemberian TTD</th>
                    <th class="px-6 py-3 text-left font-medium uppercase tracking-wider">Petugas</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($data as $row)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                        <td class="px-6 py-4">{{ $row->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $row->remaja->warga->nama ?? '-' }}</td>
                        <td class="px-6 py-4">
                            @if($row->kadar_hb)
                                <span class="px-2 py-1 {{ $row->kadar_hb < 12 ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }} rounded-full text-xs font-semibold">
                                    {{ $row->kadar_hb }} g/dL
                                </span>
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4">{{ $row->pemberian_ttd ? 'Ya' : 'Tidak' }}</td>
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
