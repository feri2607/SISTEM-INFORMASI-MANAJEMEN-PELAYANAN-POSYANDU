{{-- resources/views/warga/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Data Warga - Sistem Informasi Posyandu')

@section('page-title', 'Data Warga')
@section('page-subtitle', 'Kelola seluruh data warga Posyandu.')

@section('content')
    <div class="space-y-6">
        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
                <p class="text-sm text-gray-600 dark:text-gray-400">Total Warga</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total']) }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
                <p class="text-sm text-gray-600 dark:text-gray-400">Laki-laki</p>
                <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ number_format($stats['laki_laki']) }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
                <p class="text-sm text-gray-600 dark:text-gray-400">Perempuan</p>
                <p class="text-2xl font-bold text-pink-600 dark:text-pink-400">{{ number_format($stats['perempuan']) }}</p>
            </div>
        </div>

        <!-- Actions -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route($routePrefix . 'create') }}"
                        class="px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg transition duration-150 flex items-center">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Warga
                    </a>
                </div>
            </div>
        </div>

        <!-- Filters & Search -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
            <form method="GET" action="{{ route($routePrefix . 'index') }}" class="flex flex-wrap gap-3">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" name="search" placeholder="Cari nama, NIK, alamat, atau HP..."
                        value="{{ request('search') }}"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <select name="gender"
                        class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Semua Jenis Kelamin</option>
                        <option value="L" {{ request('gender') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ request('gender') === 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <button type="submit"
                    class="px-6 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg transition duration-150">
                    <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Cari
                </button>

                @if(request()->hasAny(['search', 'gender']))
                    <a href="{{ route($routePrefix . 'index') }}"
                        class="px-6 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition duration-150">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- Table -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Warga</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                <a href="{{ route($routePrefix . 'index', array_merge(request()->all(), ['sort' => 'nik', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}"
                                    class="hover:text-gray-700 dark:hover:text-gray-300">
                                    NIK
                                    @if(request('sort') === 'nik')
                                        <span class="ml-1">{{ request('direction') === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </a>
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Jenis Kelamin</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Tanggal Lahir</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Balita</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                <a href="{{ route($routePrefix . 'index', array_merge(request()->all(), ['sort' => 'created_at', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}"
                                    class="hover:text-gray-700 dark:hover:text-gray-300">
                                    Dibuat
                                    @if(request('sort') === 'created_at')
                                        <span class="ml-1">{{ request('direction') === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </a>
                            </th>
                            <th
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($warga as $item)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <img src="{{ $item->foto_url }}" alt="{{ $item->nama }}"
                                            class="w-10 h-10 rounded-full object-cover">
                                        <div>
                                            <p class="font-medium text-gray-900 dark:text-white">{{ $item->nama }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $item->alamat }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-mono text-gray-900 dark:text-white">{{ $item->nik }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2 py-1 text-xs font-medium rounded-full 
                                                                            @if($item->jenis_kelamin === 'L') bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400
                                                                            @else bg-pink-100 dark:bg-pink-900/30 text-pink-700 dark:text-pink-400 @endif">
                                        {{ $item->jenis_kelamin_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                                    {{ $item->tanggal_lahir->format('d M Y') }}
                                    <span class="text-xs text-gray-500 dark:text-gray-400">({{ $item->umur }} thn)</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="px-2 py-1 text-xs font-medium rounded-full bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400">
                                        {{ $item->jumlah_balita }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                    {{ $item->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route($routePrefix . 'show', $item) }}"
                                            class="text-gray-600 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300"
                                            title="Detail">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route($routePrefix . 'edit', $item) }}"
                                            class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300"
                                            title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        @if($item->verification_status === 'pending')
                                            <!-- Tombol Verifikasi -->
                                            <form action="{{ route($routePrefix . 'verify', $item->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-green-600 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300" title="Verifikasi Data">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                </button>
                                            </form>
                                            <!-- Tombol Tolak -->
                                            <button type="button" onclick="confirmReject('{{ $item->id }}', '{{ addslashes($item->nama) }}')" class="text-orange-500 hover:text-orange-600 dark:text-orange-400 dark:hover:text-orange-300" title="Tolak Data">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                            
                                            <form id="reject-form-{{ $item->id }}" action="{{ route($routePrefix . 'reject', $item->id) }}" method="POST" class="hidden">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="rejected_reason" id="reject-reason-{{ $item->id }}">
                                            </form>
                                        @endif
                                        <form action="{{ route($routePrefix . 'destroy', $item) }}" method="POST" class="inline"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus data warga \'{{ $item->nama }}\'? Tindakan ini tidak dapat dibatalkan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300" title="Hapus">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400">Tidak ada data warga</p>
                                        <a href="{{ route($routePrefix . 'create') }}"
                                            class="mt-3 px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg transition duration-150">
                                            Tambah Warga Pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $warga->withQueryString()->links() }}
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Real-time search
            let searchTimeout;
            document.querySelector('input[name="search"]').addEventListener('input', function () {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    this.closest('form').submit();
                }, 500);
            });
            function confirmReject(id, name) {
                Swal.fire({
                    title: 'Tolak Verifikasi?',
                    text: `Silakan berikan alasan penolakan untuk warga ${name}:`,
                    input: 'textarea',
                    inputPlaceholder: 'Tulis alasan minimal 10 karakter...',
                    inputAttributes: {
                        'aria-label': 'Ketik alasan penolakan Anda di sini'
                    },
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#F59E0B',
                    cancelButtonColor: '#6B7280',
                    confirmButtonText: 'Ya, Tolak!',
                    cancelButtonText: 'Batal',
                    preConfirm: (reason) => {
                        if (!reason || reason.length < 10) {
                            Swal.showValidationMessage('Mohon isi alasan penolakan minimal 10 karakter');
                        }
                        return reason;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.getElementById('reject-form-' + id);
                        document.getElementById('reject-reason-' + id).value = result.value;
                        form.submit();
                    }
                });
            }
        </script>
    @endpush
@endsection