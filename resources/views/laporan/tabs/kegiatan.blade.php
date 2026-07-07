{{-- resources/views/laporan/tabs/kegiatan.blade.php --}}
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden border border-gray-200 dark:border-gray-700">
    <div class="p-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 flex justify-between items-center">
        <h3 class="text-lg font-bold text-gray-800 dark:text-white">Ringkasan Kegiatan Posyandu</h3>
        <span class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-xs font-semibold">Total Kegiatan: {{ $data->total() ?? 0 }}</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400">
                <tr>
                    <th class="px-6 py-3 text-left font-medium uppercase tracking-wider">Tanggal & Waktu</th>
                    <th class="px-6 py-3 text-left font-medium uppercase tracking-wider">Nama Kegiatan</th>
                    <th class="px-6 py-3 text-left font-medium uppercase tracking-wider">Lokasi</th>
                    <th class="px-6 py-3 text-center font-medium uppercase tracking-wider">Terdaftar Hadir</th>
                    <th class="px-6 py-3 text-center font-medium uppercase tracking-wider">Sudah Dilayani</th>
                    <th class="px-6 py-3 text-left font-medium uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($data as $row)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($row->tanggal)->format('d M Y') }}</div>
                            <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($row->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($row->waktu_selesai)->format('H:i') }}</div>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $row->nama_kegiatan }}</td>
                        <td class="px-6 py-4">{{ $row->lokasi }}</td>
                        <td class="px-6 py-4 text-center font-bold text-blue-600">{{ $row->hadir_count }}</td>
                        <td class="px-6 py-4 text-center font-bold text-green-600">{{ $row->dilayani_count }}</td>
                        <td class="px-6 py-4">
                            @if(\Carbon\Carbon::today()->gt(\Carbon\Carbon::parse($row->tanggal)))
                                <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-semibold">Selesai</span>
                            @elseif(\Carbon\Carbon::today()->lt(\Carbon\Carbon::parse($row->tanggal)))
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">Akan Datang</span>
                            @else
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Hari Ini</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">Data kegiatan tidak ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
        {{ $data->withQueryString()->links() ?? '' }}
    </div>
</div>
