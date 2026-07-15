{{-- laporan/tabs/pegawai.blade.php --}}
<div class="space-y-5">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Laporan Kinerja Pegawai</h2>
            <p class="text-sm text-gray-500 mt-0.5">Ranking produktivitas pelayanan per pegawai</p>
        </div>
        <span class="px-3 py-1.5 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-lg text-sm font-semibold border border-gray-200 dark:border-gray-600">
            {{ count($data) }} Pegawai
        </span>
    </div>

    @php $maxTotal = collect($data)->max('total') ?: 1; @endphp
    <div class="grid grid-cols-1 gap-3">
        @forelse($data as $i => $row)
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 flex items-center gap-4">
            <div class="flex-shrink-0 w-10 text-center">
                @if($i === 0)<span class="text-2xl">🥇</span>
                @elseif($i === 1)<span class="text-2xl">🥈</span>
                @elseif($i === 2)<span class="text-2xl">🥉</span>
                @else<span class="text-lg font-bold text-gray-400">#{{ $i + 1 }}</span>
                @endif
            </div>
            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-teal-400 to-teal-700 flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                {{ strtoupper(substr($row->nama, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-bold text-gray-900 dark:text-white">{{ $row->nama }}</p>
                <div class="flex flex-wrap gap-2 mt-1">
                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">Balita: {{ $row->balita_count }}</span>
                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-pink-100 text-pink-700">Hamil: {{ $row->kehamilan_count }}</span>
                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-purple-100 text-purple-700">WUS: {{ $row->wus_count }}</span>
                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-teal-100 text-teal-700">Remaja: {{ $row->remaja_count }}</span>
                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-orange-100 text-orange-700">Lansia: {{ $row->lansia_count }}</span>
                </div>
                <div class="mt-2 bg-gray-200 dark:bg-gray-700 rounded-full h-1.5 overflow-hidden">
                    <div class="h-full rounded-full bg-gradient-to-r from-teal-500 to-teal-700" style="width: {{ $maxTotal > 0 ? round($row->total / $maxTotal * 100) : 0 }}%"></div>
                </div>
            </div>
            <div class="flex-shrink-0 text-right">
                <p class="text-2xl font-extrabold text-gray-900 dark:text-white">{{ $row->total }}</p>
                <p class="text-xs text-gray-500">Total Layanan</p>
            </div>
        </div>
        @empty
        <div class="text-center py-10 text-gray-400 text-sm">Belum ada data kinerja pegawai.</div>
        @endforelse
    </div>
</div>