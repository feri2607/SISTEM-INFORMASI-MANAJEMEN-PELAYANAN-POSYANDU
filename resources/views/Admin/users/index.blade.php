{{-- resources/views/admin/users/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Manajemen Pengguna - Sistem Informasi Posyandu')

@section('page-title', 'Manajemen Pengguna')
@section('page-subtitle', 'Kelola seluruh akun yang memiliki akses ke sistem.')

@section('content')
    <div class="space-y-6">
        <!-- Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
                <p class="text-sm text-gray-600 dark:text-gray-400">Total Admin</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_admin']) }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
                <p class="text-sm text-gray-600 dark:text-gray-400">Total Kader</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_user']) }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
                <p class="text-sm text-gray-600 dark:text-gray-400">Terverifikasi</p>
                <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ number_format($stats['verified']) }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
                <p class="text-sm text-gray-600 dark:text-gray-400">Belum Verifikasi</p>
                <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ number_format($stats['unverified']) }}
                </p>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
            <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-wrap gap-3">
                <!-- Search -->
                <div class="flex-1 min-w-[200px]">
                    <input type="text" name="search" placeholder="Cari nama atau email..." value="{{ request('search') }}"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <!-- Role Filter -->
                <div>
                    <select name="role"
                        class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="all">Semua Role</option>
                        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User</option>
                    </select>
                </div>

                <!-- Provider Filter -->
                <div>
                    <select name="provider"
                        class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="all">Semua Provider</option>
                        <option value="email" {{ request('provider') === 'email' ? 'selected' : '' }}>Email</option>
                        <option value="google" {{ request('provider') === 'google' ? 'selected' : '' }}>Google</option>
                        <option value="github" {{ request('provider') === 'github' ? 'selected' : '' }}>GitHub</option>
                    </select>
                </div>

                <!-- Verification Filter -->
                <div>
                    <select name="verification"
                        class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="all">Semua Status</option>
                        <option value="verified" {{ request('verification') === 'verified' ? 'selected' : '' }}>Terverifikasi
                        </option>
                        <option value="unverified" {{ request('verification') === 'unverified' ? 'selected' : '' }}>Belum
                            Verifikasi</option>
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

                @if(request()->hasAny(['search', 'role', 'provider', 'verification']))
                    <a href="{{ route('admin.users.index') }}"
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
                                User</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                <a href="{{ route('admin.users.index', array_merge(request()->all(), ['sort' => 'role', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}"
                                    class="hover:text-gray-700 dark:hover:text-gray-300">
                                    Role
                                    @if(request('sort') === 'role')
                                        <span class="ml-1">{{ request('direction') === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </a>
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Provider</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Status</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                <a href="{{ route('admin.users.index', array_merge(request()->all(), ['sort' => 'created_at', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}"
                                    class="hover:text-gray-700 dark:hover:text-gray-300">
                                    Tanggal Daftar
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
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <img src="{{ $user->foto_url }}" alt="{{ $user->name }}"
                                            class="w-10 h-10 rounded-full object-cover">
                                        <div>
                                            <p class="font-medium text-gray-900 dark:text-white">{{ $user->name }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full 
                                            @if($user->role === 'admin') bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400
                                            @else bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 @endif">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($user->provider)
                                        <span class="flex items-center space-x-1">
                                            @if($user->provider === 'google')
                                                <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" viewBox="0 0 48 48">
                                                    <path fill="#EA4335"
                                                        d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z" />
                                                    <path fill="#4285F4"
                                                        d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z" />
                                                    <path fill="#FBBC05"
                                                        d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24s.92 7.54 2.56 10.78l7.97-6.19z" />
                                                    <path fill="#34A853"
                                                        d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z" />
                                                </svg>
                                            @elseif($user->provider === 'github')
                                                <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.15 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.62.24 2.85.12 3.15.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z" />
                                                </svg>
                                            @endif
                                            <span
                                                class="text-xs text-gray-500 dark:text-gray-400">{{ ucfirst($user->provider) }}</span>
                                        </span>
                                    @else
                                        <span class="text-xs text-gray-500 dark:text-gray-400">Email</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($user->email_verified_at)
                                        <span class="flex items-center text-green-600 dark:text-green-400">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Terverifikasi
                                        </span>
                                    @else
                                        <span class="flex items-center text-yellow-600 dark:text-yellow-400">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Belum
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                    {{ $user->created_at->format('d M Y H:i') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('admin.users.edit-role', $user) }}"
                                            class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300"
                                            title="Ubah Role">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </a>
                                        @if(Auth::id() !== $user->id)
                                            <button onclick="confirmDelete('{{ $user->id }}', '{{ $user->name }}')"
                                                class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300"
                                                title="Hapus">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400">Tidak ada data pengguna</p>
                                        <a href="{{ route('admin.users.index') }}"
                                            class="mt-3 px-4 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg transition duration-150">
                                            Refresh
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $users->withQueryString()->links() }}
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function confirmDelete(userId, userName) {
                Swal.fire({
                    title: 'Hapus Pengguna?',
                    text: `Apakah Anda yakin ingin menghapus ${userName}?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#EF4444',
                    cancelButtonColor: '#6B7280',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `{{ route('admin.users.destroy', ['user' => ':id']) }}`.replace(':id', userId);
                        form.innerHTML = `
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="DELETE">
                        `;
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            }

            // Real-time search
            let searchTimeout;
            document.querySelector('input[name="search"]').addEventListener('input', function () {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    this.closest('form').submit();
                }, 500);
            });
        </script>
    @endpush
@endsection