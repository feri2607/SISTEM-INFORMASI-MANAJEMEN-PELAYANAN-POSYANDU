{{-- resources/views/admin/users/edit-role.blade.php --}}

@extends('layouts.app')

@section('title', 'Ubah Role - Sistem Informasi Posyandu')

@section('page-title', 'Ubah Role Pengguna')
@section('page-subtitle', 'Atur hak akses pengguna dalam sistem')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <div class="flex items-center space-x-3 mb-6">
                <img src="{{ $user->foto_url }}" alt="{{ $user->name }}" class="w-16 h-16 rounded-full object-cover">
                <div>
                    <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $user->name }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $user->email }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.users.update-role', $user) }}" id="roleForm">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Role
                    </label>
                    <select id="role" name="role"
                        class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white">
                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="pegawai" {{ $user->role === 'pegawai' ? 'selected' : '' }}>Pegawai</option>
                        <option value="warga" {{ $user->role === 'warga' ? 'selected' : '' }}>Warga</option>
                    </select>
                    @error('role')
                        <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end space-x-3">
                    <a href="{{ route('admin.users.index') }}"
                        class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition duration-150">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-[#036672] hover:bg-[#036672] text-white rounded-lg transition duration-150"
                        onclick="return confirmUpdate()">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function confirmUpdate() {
                const role = document.getElementById('role').value;
                const labels = { admin: 'Admin', pegawai: 'Pegawai', warga: 'Warga', user: 'User' };
                const roleLabel = labels[role] || role;

                return Swal.fire({
                    title: 'Ubah Role?',
                    text: `Apakah Anda yakin ingin mengubah role menjadi ${roleLabel}?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3B82F6',
                    cancelButtonColor: '#6B7280',
                    confirmButtonText: 'Ya, Ubah!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('roleForm').submit();
                    }
                    return result.isConfirmed;
                });
            }
        </script>
    @endpush
@endsection