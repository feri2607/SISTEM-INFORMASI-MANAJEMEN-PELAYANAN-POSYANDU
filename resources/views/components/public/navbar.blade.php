{{-- resources/views/components/public/navbar.blade.php --}}

<nav class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
     :class="scrollY > 50 ? 'bg-white/95 dark:bg-gray-900/95 shadow-lg backdrop-blur-sm' : 'bg-white/80 dark:bg-gray-900/80 backdrop-blur-sm'">
    <div class="w-full px-4 sm:px-8 lg:px-16 2xl:px-24">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <div class="flex items-center flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <img src="{{ setting('app_logo_main') ? Storage::url(setting('app_logo_main')) : asset('images/posyandu-logo.png') }}" alt="Logo Posyandu" class="h-10 w-auto">
                    <div class="hidden sm:block">
                        <span class="text-xl font-bold text-teal-700 dark:text-teal-400">{{ setting('app_name_short', 'Posyandu') }}</span>
                        <span class="text-sm text-gray-500 dark:text-gray-400 block">{{ setting('posyandu_name', 'Sistem Informasi') }}</span>
                    </div>
                </a>
            </div>

            {{-- Desktop Menu --}}
            <div class="hidden lg:flex items-center space-x-1">

                {{-- Beranda --}}
                <a href="{{ route('home') }}"
                   class="px-3 py-2 text-base font-medium text-teal-700 dark:text-teal-400 rounded-lg hover:bg-teal-50 dark:hover:bg-teal-900/30 transition duration-150">
                    Beranda
                </a>

                {{-- Dropdown: Kegiatan --}}
                <div x-data="{ open: false }" class="relative" @mouseleave="open = false">
                    <button @mouseenter="open = true" @click="open = !open"
                            class="flex items-center px-3 py-2 text-base font-medium text-gray-700 dark:text-gray-300 rounded-lg hover:bg-teal-50 dark:hover:bg-teal-900/30 transition duration-150">
                        Kegiatan
                        <svg class="w-4 h-4 ml-1 transition-transform duration-200" :class="open ? 'rotate-180' : ''"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" x-cloak
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-1"
                         class="absolute top-full left-0 mt-1 w-48 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 py-1 z-50">
                        <a href="{{ route('public.schedule') }}"
                           class="flex items-center px-4 py-2.5 text-base text-gray-700 dark:text-gray-300 hover:bg-teal-50 dark:hover:bg-teal-900/30 hover:text-teal-700 dark:hover:text-teal-400 transition duration-150">
                            <svg class="w-4 h-4 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Jadwal
                        </a>
                        <a href="{{ route('public.announcements') }}"
                           class="flex items-center px-4 py-2.5 text-base text-gray-700 dark:text-gray-300 hover:bg-teal-50 dark:hover:bg-teal-900/30 hover:text-teal-700 dark:hover:text-teal-400 transition duration-150">
                            <svg class="w-4 h-4 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                            </svg>
                            Pengumuman
                        </a>
                        <a href="{{ route('public.news') }}"
                           class="flex items-center px-4 py-2.5 text-base text-gray-700 dark:text-gray-300 hover:bg-teal-50 dark:hover:bg-teal-900/30 hover:text-teal-700 dark:hover:text-teal-400 transition duration-150">
                            <svg class="w-4 h-4 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                            </svg>
                            Berita
                        </a>
                    </div>
                </div>

                {{-- Dropdown: Info Dasar --}}
                <div x-data="{ open: false }" class="relative" @mouseleave="open = false">
                    <button @mouseenter="open = true" @click="open = !open"
                            class="flex items-center px-3 py-2 text-base font-medium text-gray-700 dark:text-gray-300 rounded-lg hover:bg-teal-50 dark:hover:bg-teal-900/30 transition duration-150">
                        Info Dasar
                        <svg class="w-4 h-4 ml-1 transition-transform duration-200" :class="open ? 'rotate-180' : ''"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" x-cloak
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-1"
                         class="absolute top-full left-0 mt-1 w-52 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 py-1 z-50">
                        <a href="{{ route('about') }}"
                           class="flex items-center px-4 py-2.5 text-base text-gray-700 dark:text-gray-300 hover:bg-teal-50 dark:hover:bg-teal-900/30 hover:text-teal-700 dark:hover:text-teal-400 transition duration-150">
                            <svg class="w-4 h-4 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Tentang Posyandu
                        </a>
                        <a href="{{ route('public.articles') }}"
                           class="flex items-center px-4 py-2.5 text-base text-gray-700 dark:text-gray-300 hover:bg-teal-50 dark:hover:bg-teal-900/30 hover:text-teal-700 dark:hover:text-teal-400 transition duration-150">
                            <svg class="w-4 h-4 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Artikel
                        </a>
                    </div>
                </div>

                {{-- Dropdown: Bantuan --}}
                <div x-data="{ open: false }" class="relative" @mouseleave="open = false">
                    <button @mouseenter="open = true" @click="open = !open"
                            class="flex items-center px-3 py-2 text-base font-medium text-gray-700 dark:text-gray-300 rounded-lg hover:bg-teal-50 dark:hover:bg-teal-900/30 transition duration-150">
                        Bantuan
                        <svg class="w-4 h-4 ml-1 transition-transform duration-200" :class="open ? 'rotate-180' : ''"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" x-cloak
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-1"
                         class="absolute top-full left-0 mt-1 w-44 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 py-1 z-50">
                        <a href="{{ route('contact') }}"
                           class="flex items-center px-4 py-2.5 text-base text-gray-700 dark:text-gray-300 hover:bg-teal-50 dark:hover:bg-teal-900/30 hover:text-teal-700 dark:hover:text-teal-400 transition duration-150">
                            <svg class="w-4 h-4 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Kontak
                        </a>
                        <a href="{{ route('public.faq') }}"
                           class="flex items-center px-4 py-2.5 text-base text-gray-700 dark:text-gray-300 hover:bg-teal-50 dark:hover:bg-teal-900/30 hover:text-teal-700 dark:hover:text-teal-400 transition duration-150">
                            <svg class="w-4 h-4 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            FAQ
                        </a>
                    </div>
                </div>

                {{-- Dropdown: Layanan (hanya untuk user/warga yang sudah login) --}}
                @auth
                    @if(in_array(auth()->user()->role, ['warga', 'user']))
                        <div x-data="{ open: false }" class="relative" @mouseleave="open = false">
                            <button @mouseenter="open = true" @click="open = !open"
                                    class="flex items-center px-3 py-2 text-base font-medium text-gray-700 dark:text-gray-300 rounded-lg hover:bg-teal-50 dark:hover:bg-teal-900/30 transition duration-150">
                                Layanan
                                <svg class="w-4 h-4 ml-1 transition-transform duration-200" :class="open ? 'rotate-180' : ''"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="open" x-cloak
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 translate-y-1"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="opacity-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 translate-y-1"
                                 class="absolute top-full left-0 mt-1 w-52 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 py-1 z-50">
                                @if(isset($wargaMenus) && count($wargaMenus) > 0)
                                    @foreach($wargaMenus as $menu)
                                        <a href="{{ $menu['route'] }}"
                                           class="flex items-center px-4 py-2.5 text-base text-gray-700 dark:text-gray-300 hover:bg-teal-50 dark:hover:bg-teal-900/30 hover:text-teal-700 dark:hover:text-teal-400 transition duration-150">
                                            <svg class="w-4 h-4 mr-2 {{ $menu['text'] ?? 'text-teal-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                @if($menu['icon'] === 'user-group')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                                @elseif($menu['icon'] === 'heart')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                                @elseif($menu['icon'] === 'sparkles')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                                @elseif($menu['icon'] === 'academic-cap')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                @elseif($menu['icon'] === 'shield-check')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                @else
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                                @endif
                                            </svg>
                                            {{ $menu['label'] }}
                                        </a>
                                    @endforeach
                                @else
                                    <div class="px-4 py-2.5 text-sm text-gray-500 dark:text-gray-400">
                                        @if(auth()->user()->warga && auth()->user()->warga->isVerified())
                                            Belum ada layanan aktif untuk kategori Anda.
                                        @else
                                            Silakan verifikasi profil Anda
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                @endauth

            </div>

            {{-- Auth Buttons (Desktop) --}}
            <div class="hidden lg:flex items-center space-x-3">
                @guest
                    <a href="{{ route('login') }}"
                       class="px-4 py-2 text-base font-medium text-teal-700 dark:text-teal-400 border border-teal-200 dark:border-teal-800 rounded-lg hover:bg-teal-50 dark:hover:bg-teal-900/30 transition duration-150">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                       class="px-4 py-2 text-base font-medium text-white bg-[#036672] hover:bg-[#036672] rounded-lg transition duration-150 shadow-md hover:shadow-lg">
                        Daftar
                    </a>
                @else
                    {{-- Profile Avatar Dropdown --}}
                    <div x-data="{ open: false }" class="relative" @click.outside="open = false">
                        <button @click="open = !open"
                                class="flex items-center space-x-2 p-1 rounded-full hover:ring-2 hover:ring-teal-400 transition duration-150 focus:outline-none">
                            @if(auth()->user()->foto)
                                <img src="{{ auth()->user()->foto_url }}"
                                     alt="{{ auth()->user()->name }}"
                                     class="w-9 h-9 rounded-full object-cover ring-2 ring-teal-200 dark:ring-teal-700">
                            @else
                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-teal-400 to-teal-600 flex items-center justify-center ring-2 ring-teal-200 dark:ring-teal-700">
                                    <span class="text-white text-base font-bold">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </span>
                                </div>
                            @endif
                        </button>

                        <div x-show="open" x-cloak
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 top-full mt-2 w-56 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 py-2 z-50">

                            {{-- User info --}}
                            <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700">
                                <p class="text-base font-semibold text-gray-800 dark:text-gray-100 truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ auth()->user()->email }}</p>
                            </div>

                            {{-- Profil Saya --}}
                            @if(auth()->user()->role === 'user' || auth()->user()->role === 'warga')
                                <a href="{{ route('warga.dashboard') }}"
                                   class="flex items-center px-4 py-2.5 text-base text-gray-700 dark:text-gray-300 hover:bg-teal-50 dark:hover:bg-teal-900/30 hover:text-teal-700 dark:hover:text-teal-400 transition duration-150">
                                    <svg class="w-4 h-4 mr-3 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    Dashboard
                                </a>
                                <a href="{{ route('profile.index') }}"
                                   class="flex items-center px-4 py-2.5 text-base text-gray-700 dark:text-gray-300 hover:bg-teal-50 dark:hover:bg-teal-900/30 hover:text-teal-700 dark:hover:text-teal-400 transition duration-150">
                                    <svg class="w-4 h-4 mr-3 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Profil Saya
                                </a>
                                <a href="{{ route('warga.warga.index') }}"
                                   class="flex items-center px-4 py-2.5 text-base text-gray-700 dark:text-gray-300 hover:bg-teal-50 dark:hover:bg-teal-900/30 hover:text-teal-700 dark:hover:text-teal-400 transition duration-150 justify-between">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-3 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                                        Data Warga
                                    </span>
                                    @if(!auth()->user()->warga || auth()->user()->warga->verification_status === 'belum_lengkap')
                                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-[#036672] text-white">!</span>
                                    @endif
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}"
                                   class="flex items-center px-4 py-2.5 text-base text-gray-700 dark:text-gray-300 hover:bg-teal-50 dark:hover:bg-teal-900/30 hover:text-teal-700 dark:hover:text-teal-400 transition duration-150">
                                    <svg class="w-4 h-4 mr-3 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    Dashboard
                                </a>
                            @endif

                            <div class="border-t border-gray-100 dark:border-gray-700 mt-1 pt-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="flex w-full items-center px-4 py-2.5 text-base text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition duration-150">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endguest
            </div>

            {{-- Mobile Hamburger --}}
            <div class="lg:hidden flex items-center">
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="p-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-150">
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="mobileMenuOpen" x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100"
         class="lg:hidden bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 shadow-lg max-h-[80vh] overflow-y-auto">
        <div class="px-4 py-4 space-y-1">

            <a href="{{ route('home') }}"
               class="block px-3 py-2 text-base font-medium text-teal-700 dark:text-teal-400 rounded-lg hover:bg-teal-50 dark:hover:bg-teal-900/30">
                Beranda
            </a>

            {{-- Mobile: Kegiatan --}}
            <div x-data="{ open: false }">
                <button @click="open = !open"
                        class="flex items-center justify-between w-full px-3 py-2 text-base font-medium text-gray-700 dark:text-gray-300 rounded-lg hover:bg-teal-50 dark:hover:bg-teal-900/30">
                    <span>Kegiatan</span>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" x-cloak class="pl-4 mt-1 space-y-1">
                    <a href="{{ route('public.schedule') }}"
                       class="block px-3 py-2 text-base text-gray-600 dark:text-gray-400 rounded-lg hover:bg-teal-50 dark:hover:bg-teal-900/30 hover:text-teal-700">Jadwal</a>
                    <a href="{{ route('public.announcements') }}"
                       class="block px-3 py-2 text-base text-gray-600 dark:text-gray-400 rounded-lg hover:bg-teal-50 dark:hover:bg-teal-900/30 hover:text-teal-700">Pengumuman</a>
                    <a href="{{ route('public.news') }}"
                       class="block px-3 py-2 text-base text-gray-600 dark:text-gray-400 rounded-lg hover:bg-teal-50 dark:hover:bg-teal-900/30 hover:text-teal-700">Berita</a>
                </div>
            </div>

            {{-- Mobile: Info Dasar --}}
            <div x-data="{ open: false }">
                <button @click="open = !open"
                        class="flex items-center justify-between w-full px-3 py-2 text-base font-medium text-gray-700 dark:text-gray-300 rounded-lg hover:bg-teal-50 dark:hover:bg-teal-900/30">
                    <span>Info Dasar</span>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" x-cloak class="pl-4 mt-1 space-y-1">
                    <a href="{{ route('about') }}"
                       class="block px-3 py-2 text-base text-gray-600 dark:text-gray-400 rounded-lg hover:bg-teal-50 dark:hover:bg-teal-900/30 hover:text-teal-700">Tentang Posyandu</a>
                    <a href="{{ route('public.articles') }}"
                       class="block px-3 py-2 text-base text-gray-600 dark:text-gray-400 rounded-lg hover:bg-teal-50 dark:hover:bg-teal-900/30 hover:text-teal-700">Artikel</a>
                </div>
            </div>

            {{-- Mobile: Bantuan --}}
            <div x-data="{ open: false }">
                <button @click="open = !open"
                        class="flex items-center justify-between w-full px-3 py-2 text-base font-medium text-gray-700 dark:text-gray-300 rounded-lg hover:bg-teal-50 dark:hover:bg-teal-900/30">
                    <span>Bantuan</span>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" x-cloak class="pl-4 mt-1 space-y-1">
                    <a href="{{ route('contact') }}"
                       class="block px-3 py-2 text-base text-gray-600 dark:text-gray-400 rounded-lg hover:bg-teal-50 dark:hover:bg-teal-900/30 hover:text-teal-700">Kontak</a>
                    <a href="{{ route('public.faq') }}"
                       class="block px-3 py-2 text-base text-gray-600 dark:text-gray-400 rounded-lg hover:bg-teal-50 dark:hover:bg-teal-900/30 hover:text-teal-700">FAQ</a>
                </div>
            </div>

            {{-- Mobile: Layanan (hanya warga/user yang login) --}}
            @auth
                @if(auth()->user()->hasRole('warga') || auth()->user()->hasRole('user'))
                    <div x-data="{ open: false }">
                        <button @click="open = !open"
                                class="flex items-center justify-between w-full px-3 py-2 text-base font-medium text-gray-700 dark:text-gray-300 rounded-lg hover:bg-teal-50 dark:hover:bg-teal-900/30">
                            <span>Layanan</span>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" x-cloak class="pl-4 mt-1 space-y-1">
                            @if(isset($wargaMenus) && count($wargaMenus) > 0)
                                @foreach($wargaMenus as $menu)
                                    <a href="{{ $menu['route'] }}"
                                       class="block px-3 py-2 text-base text-gray-600 dark:text-gray-400 rounded-lg hover:bg-teal-50 dark:hover:bg-teal-900/30 hover:text-teal-700">{{ $menu['label'] }}</a>
                                @endforeach
                            @else
                                <div class="px-3 py-2 text-sm text-gray-500">Profil blm lengkap</div>
                            @endif
                        </div>
                    </div>
                @endif
            @endauth

            {{-- Mobile: Auth --}}
            <div class="pt-3 border-t border-gray-200 dark:border-gray-700 space-y-2">
                @guest
                    <a href="{{ route('login') }}"
                       class="block w-full px-4 py-2 text-base font-medium text-center text-teal-700 dark:text-teal-400 border border-teal-200 dark:border-teal-800 rounded-lg hover:bg-teal-50 dark:hover:bg-teal-900/30">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                       class="block w-full px-4 py-2 text-base font-medium text-center text-white bg-[#036672] hover:bg-[#036672] rounded-lg">
                        Daftar
                    </a>
                @else
                    {{-- User info mobile --}}
                    <div class="flex items-center space-x-3 px-3 py-2">
                        @if(auth()->user()->foto)
                            <img src="{{ auth()->user()->foto_url }}"
                                 alt="{{ auth()->user()->name }}"
                                 class="w-9 h-9 rounded-full object-cover ring-2 ring-teal-200">
                        @else
                            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-teal-400 to-teal-600 flex items-center justify-center">
                                <span class="text-white text-base font-bold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                            </div>
                        @endif
                        <div>
                            <p class="text-base font-semibold text-gray-800 dark:text-gray-100">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</p>
                        </div>
                    </div>

                    @if(in_array(auth()->user()->role, ['warga', 'user']))
                        <a href="{{ route('warga.dashboard') }}"
                           class="block w-full px-4 py-2 text-base font-medium text-center text-teal-700 dark:text-teal-400 border border-teal-200 dark:border-teal-800 rounded-lg hover:bg-teal-50">
                            Dashboard
                        </a>
                        <a href="{{ route('profile.index') }}"
                           class="block w-full px-4 py-2 text-base font-medium text-center text-teal-700 dark:text-teal-400 border border-teal-200 dark:border-teal-800 rounded-lg hover:bg-teal-50">
                            Profil Saya
                        </a>
                        <a href="{{ route('warga.warga.index') }}"
                           class="flex justify-center items-center gap-2 w-full px-4 py-2 text-base font-medium text-teal-700 dark:text-teal-400 border border-teal-200 dark:border-teal-800 rounded-lg hover:bg-teal-50">
                            Data Warga
                            @if(!auth()->user()->warga || auth()->user()->warga->verification_status === 'belum_lengkap')
                                <span class="px-2 py-0.5 text-xs font-bold rounded-full bg-[#036672] text-white">!</span>
                            @endif
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}"
                           class="block w-full px-4 py-2 text-base font-medium text-center text-teal-700 dark:text-teal-400 border border-teal-200 dark:border-teal-800 rounded-lg hover:bg-teal-50">
                            Dashboard
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="block w-full px-4 py-2 text-base font-medium text-center text-white bg-[#036672] hover:bg-[#036672] rounded-lg transition duration-150">
                            Log Out
                        </button>
                    </form>
                @endguest
            </div>
        </div>
    </div>

</nav>
