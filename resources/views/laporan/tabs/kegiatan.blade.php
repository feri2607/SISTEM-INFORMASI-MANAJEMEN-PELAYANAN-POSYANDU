{{-- laporan/tabs/kegiatan.blade.php --}}
<div class="space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Laporan Kegiatan Posyandu</h2>
            <p class="text-sm text-gray-500 mt-0.5">Ringkasan kegiatan, kehadiran, dan pelayanan</p>
        </div>
        <span class="px-3 py-1.5 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 rounded-lg text-sm font-semibold border border-indigo-100 dark:border-indigo-800">
            {{ $data->total() ?? 0 }} Kegiatan
        </span>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider bg-gray-50 dark:bg-gray-900/50">Tanggal & Waktu</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider bg-gray-50 dark:bg-gray-900/50">Nama Kegiatan</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider bg-gray-50 dark:bg-gray-900/50">Lokasi</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider bg-gray-50 dark:bg-gray-900/50">Hadir</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider bg-gray-50 dark:bg-gray-900/50">Dilayani</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider bg-gray-50 dark:bg-gray-900/50">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($data as $row)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition-colors">
                        <td class="px-5 py-3.5 whitespace-nowrap">
                            <p class="font-medium text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($row->tanggal)->format('d M Y') }}</p>
                            <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($row->waktu_mulai)->format('H:i') }} – {{ \Carbon\Carbon::parse($row->waktu_selesai)->format('H:i') }}</p>
                        </td>
                        <td class="px-5 py-3.5 font-semibold text-gray-900 dark:text-white">{{ $row->nama_kegiatan }}</td>
                        <td class="px-5 py-3.5 text-gray-600 dark:text-gray-300">{{ $row->lokasi ?? '-' }}</td>
                        <td class="px-5 py-3.5 text-center text-lg font-bold text-blue-600 dark:text-blue-400">{{ $row->hadir_count }}</td>
                        <td class="px-5 py-3.5 text-center text-lg font-bold text-green-600 dark:text-green-400">{{ $row->dilayani_count }}</td>
                        <td class="px-5 py-3.5 text-center">
                            @php $hari = \Carbon\Carbon::parse($row->tanggal); $today = \Carbon\Carbon::today(); @endphp
                            @if($today->gt($hari))
                                <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">Selesai</span>
                            @elseif($today->lt($hari))
                                <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">Akan Datang</span>
                            @else
                                <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-700">Hari Ini</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-5 py-10 text-center text-gray-400 text-sm">Tidak ada data kegiatan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($data->hasPages())
        <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-700">{{ $data->withQueryString()->links() }}</div>
        @endif
    </div>
</div>