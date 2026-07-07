{{-- resources/views/Admin/kegiatan/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Manajemen Kegiatan Posyandu - Sistem Informasi Posyandu')

@section('page-title', 'Kegiatan Posyandu')
@section('page-subtitle', 'Kelola daftar kegiatan Posyandu')

@section('content')
<div class="space-y-6" x-data="kegiatanIndex">
    {{-- Actions --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 flex flex-wrap items-center justify-between gap-3">
        <a href="{{ route('admin.kegiatan.create') }}" 
           class="px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg transition duration-150 flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Kegiatan
        </a>
    </div>

    {{-- Table --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kegiatan</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal & Waktu</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Lokasi / Posyandu</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($kegiatan as $item)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            <td class="px-6 py-4">
                                <p class="font-medium text-gray-900 dark:text-white">{{ $item->nama_kegiatan }}</p>
                                <p class="text-xs text-gray-500">{{ $item->deskripsi ? Str::limit($item->deskripsi, 50) : '-' }}</p>
                                <div class="mt-1 flex flex-wrap gap-1">
                                    @if(is_array($item->jenis_pelayanan))
                                        @foreach($item->jenis_pelayanan as $jp)
                                            <span class="px-2 py-0.5 text-xs bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300 rounded">{{ $jp }}</span>
                                        @endforeach
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                <div>{{ $item->tanggal->format('d M Y') }}</div>
                                <div class="text-xs">{{ $item->jam_mulai->format('H:i') }} - {{ $item->jam_selesai->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900 dark:text-white">{{ $item->posyandu ?: $item->lokasi }}</div>
                                <div class="text-xs text-gray-500">{{ $item->posyandu ? $item->lokasi : '' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusColors = [
                                        'Draft' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                        'Terjadwal' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300',
                                        'Berlangsung' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300',
                                        'Selesai' => 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300',
                                        'Dibatalkan' => 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300',
                                    ];
                                    $colorClass = $statusColors[$item->status] ?? $statusColors['Draft'];
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $colorClass }}">{{ $item->status }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.kegiatan.show', $item->id) }}" class="text-gray-600 hover:text-gray-700" title="Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    
                                    @if(!in_array($item->status, ['Selesai', 'Dibatalkan']))
                                        <a href="{{ route('admin.kegiatan.edit', $item->id) }}" class="text-blue-600 hover:text-blue-700" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                    @endif
                                    
                                    <button onclick="confirmDelete(this.dataset.id, this.dataset.title)"
                                            data-id="{{ $item->id }}" data-title="{{ $item->nama_kegiatan }}"
                                            class="text-red-600 hover:text-red-700" title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">Belum ada kegiatan terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $kegiatan->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id, title) {
        Swal.fire({
            title: 'Hapus Kegiatan?',
            text: `Anda yakin ingin menghapus kegiatan "${title}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = "{{ url('admin/kegiatan') }}/" + id;
                form.innerHTML = `<input type="hidden" name="_token" value="{{ csrf_token() }}"><input type="hidden" name="_method" value="DELETE">`;
                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    document.addEventListener('alpine:init', () => {
        Alpine.data('kegiatanIndex', () => ({
            // State for filtering can be added here
        }));
    });
</script>
@endpush
@endsection
