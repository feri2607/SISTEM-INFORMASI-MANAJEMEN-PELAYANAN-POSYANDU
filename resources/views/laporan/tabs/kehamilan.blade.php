{{-- resources/views/laporan/tabs/kehamilan.blade.php --}}
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden border border-gray-200 dark:border-gray-700">
    <div class="p-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 flex justify-between items-center">
        <h3 class="text-lg font-bold text-gray-800 dark:text-white">Laporan Pelayanan Ibu Hamil (ANC)</h3>
        <span class="px-3 py-1 bg-pink-100 text-pink-800 rounded-full text-xs font-semibold">Total: {{ $data->total() ?? 0 }}</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400">
                <tr>
                    <th class="px-6 py-3 text-left font-medium uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-left font-medium uppercase tracking-wider">Nama Ibu Hamil</th>
                    <th class="px-6 py-3 text-left font-medium uppercase tracking-wider">Kehamilan Ke</th>
                    <th class="px-6 py-3 text-left font-medium uppercase tracking-wider">Usia Kandungan</th>
                    <th class="px-6 py-3 text-left font-medium uppercase tracking-wider">Petugas</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($data as $row)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                        <td class="px-6 py-4">{{ $row->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $row->kehamilan->warga->nama ?? '-' }}</td>
                        <td class="px-6 py-4 text-center">{{ $row->hamil_ke ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $row->usia_kandungan_minggu ?? '-' }} mgg</td>
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
