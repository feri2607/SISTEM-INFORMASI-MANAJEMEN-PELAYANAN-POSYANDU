{{-- resources/views/profile/show.blade.php --}}

@extends(Auth::user()->role === 'user' || Auth::user()->role === 'warga' ? 'layouts.public' : 'layouts.app')

@section('hide-footer', true)

@section('title', 'Profil Pengguna - Sistem Informasi Posyandu')

{{-- Remove original page-title and page-subtitle to use custom layout --}}
@section('page-title', '')
@section('page-subtitle', '')

@section('content')
<div class="max-w-6xl mx-auto font-sans" x-data="{ activeTab: 'akun' }">
    
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-2">
        <div>
            <h2 class="text-2xl font-bold text-[#0a358c]">Profil Saya</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola informasi akun dan data pribadi Anda.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <div class="inline-flex items-center px-4 py-2 bg-[#e8efff] text-[#0a358c] rounded-xl border border-blue-100 shadow-sm">
                <div class="mr-3 p-1 rounded-full bg-[#0a358c] text-white">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold tracking-wider uppercase text-[#0a358c] opacity-80 mb-0.5" style="line-height:1">STATUS AKUN</p>
                    <p class="text-sm font-semibold" style="line-height:1">{{ $user->email_verified_at ? 'Data Terverifikasi' : 'Belum Verifikasi' }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="border-b border-gray-200 mb-6 flex space-x-6">
        <button @click="activeTab = 'akun'" 
                class="pb-3 text-sm font-bold transition-colors border-b-2"
                :class="activeTab === 'akun' ? 'border-[#0a358c] text-[#0a358c]' : 'border-transparent text-gray-500 hover:text-gray-700'">
            Akun & Keamanan
        </button>
        <button @click="activeTab = 'pribadi'" 
                class="pb-3 text-sm font-bold transition-colors border-b-2"
                :class="activeTab === 'pribadi' ? 'border-[#0a358c] text-[#0a358c]' : 'border-transparent text-gray-500 hover:text-gray-700'">
            Data Pribadi
        </button>
        <button @click="activeTab = 'preferensi'" 
                class="pb-3 text-sm font-bold transition-colors border-b-2"
                :class="activeTab === 'preferensi' ? 'border-[#0a358c] text-[#0a358c]' : 'border-transparent text-gray-500 hover:text-gray-700'">
            Preferensi
        </button>
    </div>

    {{-- Tab 1: Akun & Keamanan --}}
    <div x-show="activeTab === 'akun'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="flex flex-col lg:flex-row gap-6">
        
        {{-- Left Column --}}
        <div class="w-full lg:w-1/3 space-y-6">
            {{-- Foto Profil Card --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex flex-col items-center text-center">
                <div class="w-full text-left mb-4">
                    <h3 class="text-sm font-semibold text-gray-700">Foto Profil</h3>
                </div>
                
                <div class="relative mb-4">
                    <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-[#0a358c] p-1 bg-white">
                        <img id="fotoPreview" src="{{ $user->foto_url }}" alt="{{ $user->name }}" class="w-full h-full rounded-full object-cover">
                    </div>
                    <div class="absolute bottom-0 right-1 bg-[#0a358c] text-white p-2 rounded-full border-2 border-white shadow-sm flex items-center justify-center cursor-pointer hover:bg-[#06215b] transition-colors" onclick="document.getElementById('foto').click()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                    </div>
                </div>

                <p class="text-[11px] text-gray-500 mb-6 mt-2 leading-relaxed">
                    Besar file: maksimum 10MB. Ekstensi file yang diperbolehkan: .JPG .JPEG .PNG
                </p>

                <form method="POST" action="{{ route('profile.avatar.update') }}" enctype="multipart/form-data" id="fotoForm" class="w-full flex justify-center space-x-3">
                    @csrf
                    @method('PATCH')
                    
                    <input type="file" name="foto" id="foto" accept="image/jpeg,image/png,image/jpg" class="hidden" onchange="previewAndSubmitFoto(event)">
                    
                    <button type="button" class="px-4 py-2 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 transition-colors" onclick="document.getElementById('foto').click()">
                        Ganti Foto
                    </button>
                    <!-- Hapus button is just styled, normally requires separate route -->
                    <button type="button" class="px-4 py-2 text-sm font-semibold text-red-600 hover:text-red-700 transition-colors">
                        Hapus
                    </button>
                </form>
            </div>

            {{-- Aktivitas Terakhir Card --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-gray-700">Aktivitas Terakhir</h3>
                    <form method="POST" action="{{ route('profile.logout-all') }}" onsubmit="return confirmLogoutAll()">
                        @csrf
                        @method('POST')
                        <button type="submit" class="text-xs text-red-600 hover:text-red-700 font-semibold" title="Logout dari Semua Perangkat">Logout Semua</button>
                    </form>
                </div>

                <div class="space-y-4">
                    @foreach($sessions as $session)
                    <div class="flex items-start space-x-3">
                        <div class="mt-1 flex-shrink-0 text-gray-400">
                            @if(str_contains(strtolower($session['device']), 'iphone') || str_contains(strtolower($session['device']), 'android'))
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            @else
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">{{ $session['device'] }}</p>
                            <p class="text-[11px] text-gray-500 mt-0.5">IP: {{ $session['ip'] }} • {{ $session['last_activity'] }}</p>
                            @if($session['current'])
                                <p class="text-[10px] font-bold text-green-600 mt-1 uppercase tracking-widest">Aktif Sekarang</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Right Column --}}
        <div class="w-full lg:w-2/3 space-y-6">
            
            {{-- Informasi Akun Card --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 pb-2">
                <div class="px-6 py-5 border-b border-gray-100 mb-2">
                    <h3 class="text-sm font-semibold text-gray-700">Informasi Akun</h3>
                </div>
                <div class="p-6 pt-2">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                        <div>
                            <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1">Nama Lengkap</p>
                            <p class="font-bold text-gray-900 text-sm">{{ $user->name }}</p>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1">Email</p>
                            <p class="font-bold text-gray-900 text-sm">{{ $user->email }}</p>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1">Role</p>
                            <div class="mt-1">
                                <span class="px-3 py-1 text-xs font-semibold rounded-lg bg-[#e8efff] text-[#0a358c]">
                                    {{ $user->role_label }}
                                </span>
                            </div>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1">Bergabung Sejak</p>
                            <p class="font-bold text-gray-900 text-sm">{{ $user->tanggal_bergabung }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Ubah Kata Sandi Card --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 pb-2">
                <div class="px-6 py-5 border-b border-gray-100 mb-2">
                    <h3 class="text-sm font-semibold text-gray-700">Ubah Kata Sandi</h3>
                </div>
                <div class="p-6 pt-2">
                    <form method="POST" action="{{ route('profile.update-password') }}" x-data="passwordForm()" @submit.prevent="submitForm">
                        @csrf
                        @method('PATCH')

                        <div class="space-y-5">
                            <div>
                                <label for="current_password" class="block text-[12px] font-semibold text-gray-700 mb-1.5">
                                    Kata Sandi Saat Ini
                                </label>
                                <div class="relative">
                                    <input type="password" name="current_password" id="current_password"
                                        x-model="form.current_password" required
                                        placeholder="••••••••"
                                        class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a358c] focus:border-transparent text-gray-900 text-sm">
                                </div>
                                @error('current_password')
                                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label for="password" class="block text-[12px] font-semibold text-gray-700 mb-1.5">
                                        Kata Sandi Baru
                                    </label>
                                    <div class="relative">
                                        <input type="password" name="password" id="password" x-model="form.password"
                                            @input="checkPasswordStrength()" required
                                            placeholder="Minimal 8 karakter"
                                            class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a358c] focus:border-transparent text-gray-900 text-sm">
                                    </div>
                                    @error('password')
                                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-[12px] font-semibold text-gray-700 mb-1.5">
                                        Konfirmasi Kata Sandi
                                    </label>
                                    <div class="relative">
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            x-model="form.password_confirmation" required
                                            placeholder="Ulangi kata sandi baru"
                                            class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a358c] focus:border-transparent text-gray-900 text-sm">
                                    </div>
                                    @error('password_confirmation')
                                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex justify-end pt-2">
                                <button type="submit" x-show="!loadingPassword"
                                    class="px-6 py-2.5 bg-[#0a358c] hover:bg-[#06215b] text-white text-sm font-semibold rounded-lg transition duration-200">
                                    Update Kata Sandi
                                </button>
                                <button type="button" x-show="loadingPassword" disabled
                                    class="px-6 py-2.5 bg-blue-400 cursor-not-allowed text-white text-sm font-semibold rounded-lg flex items-center">
                                    <svg class="animate-spin h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Memproses...
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Zona Berbahaya Card --}}
            <div class="bg-[#fef2f2] rounded-xl shadow-sm border border-red-200 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center space-x-2 text-red-700 mb-3">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        <h3 class="text-sm font-bold">Zona Berbahaya</h3>
                    </div>
                    
                    <p class="text-sm text-gray-700 mb-5 leading-relaxed">
                        Menghapus akun akan menghapus semua data keluarga dan riwayat kesehatan secara permanen. Tindakan ini tidak dapat dibatalkan.
                    </p>
                    
                    <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirmDeleteAccount(event)">
                        @csrf
                        @method('DELETE')
                        {{-- Hidden password input for delete confirm, filled via JS prompt --}}
                        <input type="hidden" name="password" id="delete_password_hidden">
                        <button type="button" onclick="promptDeleteAccount()"
                            class="px-5 py-2 bg-[#036672] hover:bg-[#024d56] text-white text-sm font-semibold rounded-lg transition duration-150 inline-flex items-center">
                            Hapus Akun Permanen
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>


    {{-- Tab 2: Data Pribadi (Edit Profil Form) --}}
    <div x-show="activeTab === 'pribadi'" style="display: none;" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="max-w-3xl">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 pb-4">
            <div class="px-6 py-5 border-b border-gray-100 mb-4">
                <h3 class="text-lg font-semibold text-gray-700">Perbarui Data Pribadi</h3>
            </div>
            <div class="px-6">
                <form method="POST" action="{{ route('profile.update') }}" x-data="profileForm()" @submit.prevent="submitForm">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-5">
                        <!-- Nama -->
                        <div>
                            <label for="name" class="block text-[12px] font-semibold text-gray-700 mb-1.5">
                                Nama Lengkap
                            </label>
                            <input type="text" name="name" id="name"
                                class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a358c] focus:border-transparent text-gray-900 text-sm"
                                value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-[12px] font-semibold text-gray-700 mb-1.5">
                                Alamat Email
                            </label>
                            <input type="email" name="email" id="email"
                                class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a358c] focus:border-transparent text-gray-900 text-sm"
                                value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nomor HP -->
                        <div>
                            <label for="no_telepon" class="block text-[12px] font-semibold text-gray-700 mb-1.5">
                                Nomor HP
                            </label>
                            <input type="text" name="no_telepon" id="no_telepon"
                                class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a358c] focus:border-transparent text-gray-900 text-sm"
                                value="{{ old('no_telepon', $user->no_telepon) }}">
                            @error('no_telepon')
                                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Alamat -->
                        <div>
                            <label for="alamat" class="block text-[12px] font-semibold text-gray-700 mb-1.5">
                                Alamat Domisili
                            </label>
                            <textarea name="alamat" id="alamat" rows="3"
                                class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0a358c] focus:border-transparent text-gray-900 text-sm">{{ old('alamat', $user->alamat) }}</textarea>
                            @error('alamat')
                                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit" id="submitProfileButton" x-show="!loading"
                            class="px-6 py-2.5 bg-[#0a358c] hover:bg-[#06215b] text-white text-sm font-semibold rounded-lg transition duration-200">
                            Simpan Perubahan
                        </button>
                        <button type="button" x-show="loading" disabled
                            class="px-6 py-2.5 bg-blue-400 cursor-not-allowed text-white text-sm font-semibold rounded-lg flex items-center">
                            Memproses...
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Tab 3: Preferensi --}}
    <div x-show="activeTab === 'preferensi'" style="display: none;" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="max-w-3xl">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <p class="text-sm text-gray-600">Belum ada pengaturan preferensi saat ini.</p>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function previewAndSubmitFoto(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('fotoPreview').src = e.target.result;
                // auto submit
                document.getElementById('fotoForm').submit();
            };
            reader.readAsDataURL(file);
        }
    }

    function profileForm() {
        return {
            loading: false,
            submitForm() {
                this.loading = true;
                this.$el.submit();
            }
        }
    }

    function passwordForm() {
        return {
            loadingPassword: false,
            form: {
                current_password: '',
                password: '',
                password_confirmation: ''
            },
            checkPasswordStrength() {},
            submitForm() {
                this.loadingPassword = true;
                this.$el.submit();
            }
        }
    }

    function confirmLogoutAll() {
        return Swal.fire({
            title: 'Logout dari Semua Perangkat?',
            text: 'Anda harus login kembali setelah ini.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Ya, Logout',
            cancelButtonText: 'Batal',
        }).then((result) => result.isConfirmed);
    }

    function promptDeleteAccount() {
        Swal.fire({
            title: 'Hapus Akun Permanen?',
            text: "Ketik kata sandi Anda untuk mengonfirmasi:",
            input: 'password',
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Hapus Akun',
            confirmButtonColor: '#B91C1C',
            cancelButtonText: 'Batal',
            showLoaderOnConfirm: true,
            preConfirm: (password) => {
                if (!password) {
                    Swal.showValidationMessage('Kata sandi tidak boleh kosong')
                    return false;
                }
                document.getElementById('delete_password_hidden').value = password;
                return true;
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                document.querySelector('form[action="{{ route('profile.destroy') }}"]').submit();
            }
        })
    }
</script>
@endpush
@endsection
