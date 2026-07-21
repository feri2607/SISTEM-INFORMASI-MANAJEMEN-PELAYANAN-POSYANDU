{{-- resources/views/profile/profileWarga/index.blade.php --}}

@extends(Auth::user()->role === 'user' || Auth::user()->role === 'warga' ? 'layouts.public' : 'layouts.app')

@section('hide-footer', true)

@section('title', 'Profil Pengguna - Sistem Informasi Posyandu')

@section('page-title', '')
@section('page-subtitle', '')

@section('content')
<div class="max-w-6xl mx-auto font-sans" x-data="{ loading: false, loadingPassword: false }">
    
    {{-- Top Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Profil Pengguna</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola data diri, keamanan, dan preferensi akun Anda.</p>
        </div>
        <div class="mt-4 md:mt-0 flex space-x-3">
            <button onclick="document.getElementById('profileForm').submit()" class="px-5 py-2 min-w-[140px] bg-[#4f649f] hover:bg-[#3f5080] text-white text-sm font-semibold rounded-lg shadow-sm flex justify-center items-center gap-2 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                </svg>
                Simpan Profil
            </button>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">
        
        {{-- Left Column --}}
        <div class="w-full lg:w-1/3 space-y-6">
            
            {{-- Profile Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 flex flex-col items-center justify-center text-center">
                <div class="relative mb-5">
                    {{-- Progress ring placeholder --}}
                    <div class="w-32 h-32 rounded-full overflow-hidden border-[3px] border-gray-100 p-1 relative">
                        {{-- Simulating the blue top border from the design --}}
                        <div class="absolute inset-0 rounded-full border-[3px] border-[#0a358c] opacity-20"></div>
                        <img id="avatarPreview" src="{{ $user->foto_url ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&color=0a358c&background=f0f4f8' }}" alt="Profile" class="w-full h-full rounded-full object-cover relative z-10">
                    </div>
                    <div class="absolute bottom-1 right-1 bg-[#0a358c] rounded-full p-2 border-2 border-white text-white cursor-pointer hover:bg-blue-800 transition" onclick="document.getElementById('avatarInput').click()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                    </div>
                </div>
                
                <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $user->name }}</h3>
                <p class="text-xs text-gray-500 mb-4">{{ $user->email }}</p>
                
                <span class="px-4 py-1.5 bg-[#f0f4f8] text-[#0a358c] text-[10px] font-bold tracking-widest rounded-full flex items-center border border-blue-100">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#0a358c] mr-2"></span>
                    {{ strtoupper($user->role_label ?? 'WARGA') }}
                </span>

                <form method="POST" action="{{ route('profile.update-avatar') }}" enctype="multipart/form-data" id="fotoForm" class="hidden">
                    @csrf
                    @method('PATCH')
                    <input type="file" name="avatar" id="avatarInput" accept="image/jpeg,image/png,image/jpg,image/webp" onchange="previewAvatar(event)">
                </form>
            </div>

            {{-- Status Akun Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center space-x-2 text-gray-800 mb-5">
                    <svg class="w-5 h-5 text-[#0a358c]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    <h3 class="font-bold">Status Akun</h3>
                </div>

                <div class="space-y-4">
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="text-sm font-medium text-gray-500">Status Verifikasi</span>
                        <span class="text-sm font-bold flex items-center text-teal-600">
                            @if($user->email_verified_at)
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                Terverifikasi
                            @else
                                <span class="text-orange-500">Belum Verifikasi</span>
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="text-sm font-medium text-gray-500">Tipe Member</span>
                        <span class="text-sm font-bold text-[#b5853b]">GOLD TIER</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-sm font-medium text-gray-500">Sejak</span>
                        <span class="text-sm font-bold text-gray-900">{{ \Carbon\Carbon::parse($user->created_at ?? now())->translatedFormat('F Y') }}</span>
                    </div>
                </div>
            </div>

            {{-- Kelengkapan Profil Card (Dark Blue) --}}
            @php
                $completionFields = [
                    'Nama Lengkap'  => !empty($user->name),
                    'Email'         => !empty($user->email),
                    'No. Telepon'   => !empty($user->no_telepon),
                    'Alamat'        => !empty($user->alamat),
                    'Foto Profil'   => !empty($user->foto),
                    'Verifikasi Email' => !empty($user->email_verified_at),
                ];
                $completedCount = count(array_filter($completionFields));
                $totalCount     = count($completionFields);
                $completionPct  = $totalCount > 0 ? round(($completedCount / $totalCount) * 100) : 0;

                $missingFields  = array_keys(array_filter($completionFields, fn($v) => !$v));
            @endphp
            <div class="bg-[#0a2366] rounded-2xl shadow-sm p-6 text-white text-center flex flex-col items-center">
                <div class="w-full flex justify-between items-end mb-4">
                    <h3 class="font-bold text-lg text-left leading-tight">Kelengkapan<br>Profil</h3>
                    <span class="text-3xl font-black">{{ $completionPct }}%</span>
                </div>
                
                <div class="w-full h-2 bg-[#1c3882] rounded-full mb-5 overflow-hidden">
                    <div class="h-full bg-white rounded-full transition-all duration-700" style="width: {{ $completionPct }}%"></div>
                </div>

                @if(count($missingFields) > 0)
                    <p class="text-xs text-[#9eb6ed] text-left mb-3 leading-relaxed w-full">
                        Belum lengkap:
                    </p>
                    <ul class="text-xs text-[#c9d8f5] text-left mb-6 w-full space-y-1">
                        @foreach($missingFields as $field)
                            <li class="flex items-center gap-2">
                                <svg class="w-3 h-3 text-[#6a88c9] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                {{ $field }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-xs text-[#9eb6ed] text-left mb-6 leading-relaxed">
                        Profil Anda sudah lengkap! Terima kasih. 🎉
                    </p>
                @endif

                <button onclick="document.getElementById('profileForm').scrollIntoView({behavior:'smooth'}); document.querySelector('#profileForm input[name=name]').focus();" class="w-full py-2.5 bg-white text-[#0a2366] font-bold text-sm rounded-xl hover:bg-gray-100 transition-colors">
                    @if($completionPct < 100) Lengkapi Sekarang @else Lihat Profil @endif
                </button>
            </div>
        </div>

        {{-- Right Column --}}
        <div class="w-full lg:w-2/3 space-y-6">
            
            {{-- Informasi Identitas --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative">
                <div class="p-6 border-b border-gray-50 bg-gray-50/30">
                    <div class="flex items-center space-x-3 text-gray-800">
                        <div class="p-2 bg-[#e8efff] rounded-lg text-[#0a358c]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-900">Informasi Identitas</h3>
                    </div>
                </div>
                
                <form id="profileForm" method="POST" action="{{ route('profile.update') }}" class="p-6">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                        {{-- Nama Lengkap --}}
                        <div>
                            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full px-4 py-3 bg-[#f8fafc] border border-gray-200 rounded-xl text-sm font-medium text-gray-800 focus:ring-2 focus:ring-[#0a358c] focus:border-transparent transition-shadow outline-none">
                        </div>
                        {{-- Email --}}
                        <div>
                            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-3 bg-[#f8fafc] border border-gray-200 rounded-xl text-sm font-medium text-gray-800 focus:ring-2 focus:ring-[#0a358c] focus:border-transparent transition-shadow outline-none">
                        </div>
                        {{-- Nomor Telepon --}}
                        <div>
                            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2">Nomor Telepon</label>
                            <input type="text" name="no_telepon" value="{{ old('no_telepon', $user->no_telepon) }}" class="w-full px-4 py-3 bg-[#f8fafc] border border-gray-200 rounded-xl text-sm font-medium text-gray-800 focus:ring-2 focus:ring-[#0a358c] focus:border-transparent transition-shadow outline-none" placeholder="+62">
                        </div>
                        {{-- Role (Readonly usually or select) --}}
                        <div>
                            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2">Role / Peran</label>
                            <select disabled class="w-full px-4 py-3 bg-gray-100 border border-gray-200 rounded-xl text-sm font-medium text-gray-600 appearance-none cursor-not-allowed">
                                <option>{{ ucfirst($user->role_label ?? 'Warga') }}</option>
                            </select>
                        </div>
                    </div>

                    {{-- Note Catatan Verifikasi --}}
                    <div class="bg-[#f0f4f8] rounded-xl p-4 flex items-start space-x-3">
                        <div class="text-[#0a358c] mt-0.5 flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-[#0a358c] mb-1">Catatan Verifikasi</h4>
                            <p class="text-xs text-gray-600">Perubahan pada nama lengkap akan memicu proses verifikasi ulang ID oleh sistem kami.</p>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Data Anak Keluarga --}}
            <div id="data-anak" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative">
                <div class="p-6 border-b border-gray-50 bg-gray-50/30 flex justify-between items-center">
                    <div class="flex items-center space-x-3 text-gray-800">
                        <div class="p-2 bg-[#e8efff] rounded-lg text-[#0a358c]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-900">Data Anak Keluarga</h3>
                    </div>
                    @if(isset($warga))
                        <a href="{{ route('profile.anak.create') }}" class="px-4 py-2 bg-[#0a358c] hover:bg-[#082a70] text-white text-xs font-bold rounded-xl transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Tambah Anak
                        </a>
                    @endif
                </div>
                
                <div class="p-6">
                    @if(!isset($warga))
                        <div class="text-center py-6">
                            <p class="text-sm text-gray-500 mb-2">Anda belum melengkapi Data Warga.</p>
                            <p class="text-xs text-gray-400">Silakan lengkapi profil Anda terlebih dahulu untuk dapat menambahkan anak.</p>
                        </div>
                    @elseif(isset($anak) && $anak->isEmpty())
                        <div class="text-center py-6">
                            <p class="text-sm text-gray-500 mb-2">Belum ada data anak yang ditambahkan.</p>
                            <p class="text-xs text-gray-400">Tambahkan data anak untuk memantau tumbuh kembang mereka.</p>
                        </div>
                    @else
                        <div class="grid gap-4">
                            @foreach($anak as $item)
                            <div class="border border-gray-100 rounded-xl p-4 flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full {{ $item->jenis_kelamin === 'L' ? 'bg-blue-100 text-blue-600' : 'bg-pink-100 text-pink-600' }} flex items-center justify-center text-lg shrink-0">
                                        {{ $item->jenis_kelamin === 'L' ? '👦' : '👧' }}
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h4 class="font-bold text-gray-900 text-sm">{{ $item->nama }}</h4>
                                            @if($item->is_balita)
                                                <span class="px-2 py-0.5 text-[9px] font-bold rounded-full bg-blue-100 text-blue-700 uppercase">Balita</span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $item->jenis_kelamin_label }} &bull; {{ $item->tanggal_lahir->format('d M Y') }} &bull; {{ $item->umur_label }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('profile.anak.edit', $item) }}" class="p-2 bg-gray-100 text-gray-600 hover:bg-gray-200 rounded-lg transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- Keamanan Akun --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-50 bg-gray-50/30">
                    <div class="flex items-center space-x-3 text-gray-800">
                        <div class="p-2 bg-[#e8efff] rounded-lg text-[#0a358c]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-900">Keamanan Akun</h3>
                    </div>
                </div>
                
                <div class="p-6">
                    
                    {{-- Form Ubah Password --}}
                    <form id="passwordForm" method="POST" action="{{ route('profile.update-password') }}">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-5">
                            <h4 class="text-sm font-bold text-gray-800 mb-4">Ubah Kata Sandi</h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                                {{-- Password Saat Ini --}}
                                <div class="md:col-span-2 md:w-1/2">
                                    <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2">Kata Sandi Saat Ini</label>
                                    <input type="password" name="current_password" placeholder="••••••••" class="w-full px-4 py-3 bg-[#f8fafc] border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#0a358c] focus:border-transparent transition-shadow outline-none">
                                </div>
                                
                                {{-- Password Baru --}}
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2">Kata Sandi Baru</label>
                                    <input type="password" name="password" class="w-full px-4 py-3 bg-[#f8fafc] border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#0a358c] focus:border-transparent transition-shadow outline-none">
                                </div>

                                {{-- Konfirmasi Password --}}
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2">Konfirmasi Kata Sandi</label>
                                    <input type="password" name="password_confirmation" class="w-full px-4 py-3 bg-[#f8fafc] border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#0a358c] focus:border-transparent transition-shadow outline-none">
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end mb-5">
                            <button type="submit" class="px-5 py-2.5 bg-[#0a358c] hover:bg-[#082a70] text-white text-xs font-bold rounded-xl transition-colors">
                                Perbarui Kata Sandi
                            </button>
                        </div>
                    </form>

                    {{-- Aktivitas Login (di luar form) --}}
                    <div class="border-t border-gray-100 pt-5">
                        <h4 class="text-sm font-bold text-gray-800 mb-4">Aktivitas Login Terakhir</h4>
                        
                        <div class="space-y-3">
                            @if(isset($loginActivities) && count($loginActivities) > 0)
                                @foreach($loginActivities as $session)
                                    <div class="flex items-center justify-between p-3 border border-gray-100 rounded-xl bg-gray-50/50">
                                        <div class="flex items-center space-x-3">
                                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                            <span class="text-xs font-semibold text-gray-700">{{ $session['user_agent'] ?? 'Browser' }} • {{ $session['ip_address'] ?? 'IP' }}</span>
                                        </div>
                                        <span class="text-[10px] font-medium text-gray-400">{{ \Carbon\Carbon::parse($session['last_activity'])->diffForHumans() }}</span>
                                    </div>
                                @endforeach
                            @else
                                <div class="flex items-center justify-between p-3 border border-gray-100 rounded-xl bg-gray-50/50">
                                    <div class="flex items-center space-x-3">
                                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                        <span class="text-xs font-semibold text-gray-700">Chrome di Windows • Jakarta, ID</span>
                                    </div>
                                    <span class="text-[10px] font-bold text-red-500">Sedang Aktif</span>
                                </div>
                                <div class="flex items-center justify-between p-3 border border-gray-100 rounded-xl bg-gray-50/50">
                                    <div class="flex items-center space-x-3">
                                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                        <span class="text-xs font-semibold text-gray-700">iPhone 13 • Bekasi, ID</span>
                                    </div>
                                    <span class="text-[10px] font-medium text-gray-400">2 jam yang lalu</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Preferensi Sistem (Bottom) --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex items-center justify-between p-6">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-gray-100 rounded-xl text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-1.066 2.573c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 mb-0.5 text-sm">Preferensi Sistem</h3>
                        <p class="text-xs text-gray-500">Kelola bahasa, notifikasi, dan tampilan dashboard.</p>
                    </div>
                </div>
                <button class="px-5 py-2.5 border-2 border-gray-200 hover:border-[#0a358c] text-[#0a358c] text-xs font-bold rounded-xl transition-colors">
                    Buka Pengaturan Lanjutan
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function previewAvatar(event) {
    const file = event.target.files[0];
    if (!file) return;

    // Validate type & size
    const allowed = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
    if (!allowed.includes(file.type)) {
        alert('Format file tidak didukung. Gunakan JPEG, PNG, atau WEBP.');
        event.target.value = '';
        return;
    }
    if (file.size > 2 * 1024 * 1024) {
        alert('Ukuran foto maksimal 2 MB.');
        event.target.value = '';
        return;
    }

    // Live preview before submit
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('avatarPreview').src = e.target.result;
        // Auto-submit after preview loads
        setTimeout(() => document.getElementById('fotoForm').submit(), 300);
    };
    reader.readAsDataURL(file);
}
</script>
@endpush
@endsection
