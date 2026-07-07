{{-- resources/views/components/sidebar.blade.php --}}

@props(['user' => Auth::user()])

<aside
    class="fixed top-0 left-0 z-40 h-screen transition-all duration-300 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700"
    :class="sidebarOpen ? 'w-64 translate-x-0' : 'w-20 -translate-x-full lg:translate-x-0'" x-transition>
    
    <div class="flex flex-col h-full">
        <!-- Logo -->
        <div class="flex items-center justify-center py-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col items-center">
                <img alt="Posyandu Logo" class="h-20 w-auto mb-2 transition-all duration-300"
                    :class="sidebarOpen ? 'h-20' : 'h-10'"
                    src="{{ setting('app_logo_main') ? Storage::url(setting('app_logo_main')) : asset('images/posyandu-logo.png') }}" />
                <div x-show="sidebarOpen" x-transition class="text-center">
                    <h1 class="text-lg font-bold text-gray-900 dark:text-white">Posyandu</h1>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Sistem Informasi</p>
                </div>
            </div>
            <button @click="toggleSidebar()"
                class="lg:hidden absolute right-4 top-6 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
            @if(Auth::user()->role === 'admin')
                <!-- Dashboard admin -->
                <x-nav-link href="{{ route('admin.dashboard') }}" icon="home"
                    active="{{ request()->routeIs('admin.dashboard') }}">
                    Dashboard
                </x-nav-link>

                <!-- Dropdown: Master Data -->
                @php
                    $isAdminMasterDataActive = request()->routeIs('admin.warga*') || request()->routeIs('admin.balita*');
                @endphp
                <div x-data="{ open: {{ $isAdminMasterDataActive ? 'true' : 'false' }} }">
                    <button @click="open = !open" 
                        class="w-full flex items-center justify-between px-4 py-2.5 text-sm font-medium rounded-lg transition-all duration-300 group {{ $isAdminMasterDataActive ? 'text-blue-700 bg-blue-50/50 dark:bg-gray-800 dark:text-blue-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}"
                        :class="sidebarOpen ? '' : 'justify-center px-2'">
                        <div class="relative flex items-center">
                            <svg class="w-5 h-5 transition-all duration-300 {{ $isAdminMasterDataActive ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-700 dark:group-hover:text-gray-300' }}" :class="sidebarOpen ? 'mr-3' : 'mr-0'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            <span x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" class="truncate whitespace-nowrap">
                                Master Data
                            </span>
                        </div>
                        <svg x-show="sidebarOpen" :class="{'rotate-180': open}" class="w-4 h-4 transition-transform {{ $isAdminMasterDataActive ? 'text-blue-600' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" x-collapse class="mt-1 space-y-1" :class="sidebarOpen ? 'pl-4' : 'pl-0'">
                        <!-- Data Warga -->
                        <x-nav-link href="{{ route('admin.warga.index') }}" icon="users"
                            active="{{ request()->routeIs('admin.warga*') }}">
                            Data Warga
                        </x-nav-link>

                        <!-- Data Balita -->
                        <x-nav-link href="{{ route('admin.balita.index') }}" icon="baby"
                            active="{{ request()->routeIs('admin.balita*') }}">
                            Data Balita
                        </x-nav-link>
                    </div>
                </div>

                <!-- Kegiatan -->
                <x-nav-link href="{{ route('admin.kegiatan.index') }}" icon="calendar" active="{{ request()->routeIs('admin.kegiatan*') }}">
                    Kegiatan
                </x-nav-link>

                <!-- Hasil Pelayanan -->
                <x-nav-link href="{{ route('admin.pelayanan.index') }}" icon="clipboard-list" active="{{ request()->routeIs('admin.pelayanan*') }}">
                    Hasil Pelayanan
                </x-nav-link>

                <!-- Laporan -->
                <x-nav-link href="{{ route('admin.laporan.index') }}" icon="chart-bar" active="{{ request()->routeIs('admin.laporan*') }}">
                    📊 Laporan
                </x-nav-link>

                <div class="pt-5 pb-2 px-4 overflow-hidden" x-show="sidebarOpen" x-transition>
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block truncate">Konten & Informasi</span>
                </div>

                <x-nav-link href="{{ route('admin.articles.index') }}" icon="document-text" active="{{ request()->routeIs('admin.articles*') }}">
                    Artikel
                </x-nav-link>

                <x-nav-link href="{{ route('admin.news.index') }}" icon="newspaper" active="{{ request()->routeIs('admin.news*') }}">
                    Berita
                </x-nav-link>

                <x-nav-link href="{{ route('admin.announcements.index') }}" icon="speakerphone" active="{{ request()->routeIs('admin.announcements*') }}">
                    Pengumuman
                </x-nav-link>

                <x-nav-link href="{{ route('admin.faq.index') }}" icon="question-mark-circle" active="{{ request()->routeIs('admin.faq*') }}">
                    FAQ
                </x-nav-link>

                <!-- Khusus Admin -->
                <div class="pt-5 pb-2 px-4 overflow-hidden" x-show="sidebarOpen" x-transition>
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block truncate">Khusus
                        Admin</span>
                </div>

                <!-- Manajemen Pengguna -->
                <x-nav-link href="{{ route('admin.users.index') }}" icon="users"
                    active="{{ request()->routeIs('admin.users*') }}">
                    Manajemen Pengguna
                </x-nav-link>


            @elseif(Auth::user()->role === 'pegawai')
                <!-- Dashboard pegawai -->
                <x-nav-link href="{{ route('pegawai.dashboard') }}" icon="home"
                    active="{{ request()->routeIs('pegawai.dashboard') }}">
                    Dashboard
                </x-nav-link>

                <!-- Dropdown: Master Data -->
                @php
                    $isMasterDataActive = request()->routeIs('pegawai.warga*') || request()->routeIs('pegawai.balita*') || request()->routeIs('pegawai.remaja*') || request()->routeIs('pegawai.lansia*') || request()->routeIs('pegawai.kehamilan*') || request()->routeIs('pegawai.reproduksi*');
                @endphp
                <div x-data="{ open: {{ $isMasterDataActive ? 'true' : 'false' }} }">
                    <button @click="open = !open" 
                        class="w-full flex items-center justify-between px-4 py-2.5 text-sm font-medium rounded-lg transition-all duration-300 group {{ $isMasterDataActive ? 'text-blue-700 bg-blue-50/50 dark:bg-gray-800 dark:text-blue-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}"
                        :class="sidebarOpen ? '' : 'justify-center px-2'">
                        <div class="relative flex items-center">
                            <svg class="w-5 h-5 transition-all duration-300 {{ $isMasterDataActive ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-700 dark:group-hover:text-gray-300' }}" :class="sidebarOpen ? 'mr-3' : 'mr-0'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            <span x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" class="truncate whitespace-nowrap">
                                Master Data
                            </span>
                        </div>
                        <svg x-show="sidebarOpen" :class="{'rotate-180': open}" class="w-4 h-4 transition-transform {{ $isMasterDataActive ? 'text-blue-600' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" x-collapse class="mt-1 space-y-1" :class="sidebarOpen ? 'pl-4' : 'pl-0'">
                        <!-- Data Warga -->
                        <x-nav-link href="{{ route('pegawai.warga.index') }}" icon="users"
                            active="{{ request()->routeIs('pegawai.warga*') }}">
                            Data Warga
                        </x-nav-link>

                        <!-- Data Balita -->
                        <x-nav-link href="{{ route('pegawai.balita.index') }}" icon="baby"
                            active="{{ request()->routeIs('pegawai.balita*') }}">
                            Data Balita
                        </x-nav-link>

                        <!-- Data Remaja -->
                        <x-nav-link href="{{ route('pegawai.remaja.dashboard') }}" icon="user-group"
                            active="{{ request()->routeIs('pegawai.remaja.*') }}">
                            Data Remaja
                        </x-nav-link>

                        <!-- Data Lansia -->
                        <x-nav-link href="{{ route('pegawai.lansia.dashboard') }}" icon="user"
                            active="{{ request()->routeIs('pegawai.lansia.*') }}">
                            Data Lansia
                        </x-nav-link>

                        <!-- Manajemen Kehamilan -->
                        <x-nav-link href="{{ route('pegawai.kehamilan.dashboard') }}" icon="users"
                            active="{{ request()->routeIs('pegawai.kehamilan.*') }}">
                            Data Kehamilan
                        </x-nav-link>

                        <!-- Kesehatan Reproduksi -->
                        <x-nav-link href="{{ route('pegawai.reproduksi.dashboard') }}" icon="users" active="{{ request()->routeIs('pegawai.reproduksi.*') }}">
                            WUS/PUS
                        </x-nav-link>
                    </div>
                </div>

                <!-- Kegiatan -->
                <x-nav-link href="{{ route('pegawai.kegiatan.index') }}" icon="calendar" active="{{ request()->routeIs('pegawai.kegiatan*') }}">
                    Kegiatan
                </x-nav-link>

                <!-- Dropdown: Layanan & Riwayat -->
                @php
                    $isLayananActive = request()->routeIs('pegawai.kehadiran*') || request()->routeIs('pegawai.pelayanan-hari-ini*') || request()->routeIs('pegawai.pelayanan.index') || request()->routeIs('pegawai.pelayanan.show');
                @endphp
                <div x-data="{ open: {{ $isLayananActive ? 'true' : 'false' }} }">
                    <button @click="open = !open" 
                        class="w-full flex items-center justify-between px-4 py-2.5 text-sm font-medium rounded-lg transition-all duration-300 group {{ $isLayananActive ? 'text-blue-700 bg-blue-50/50 dark:bg-gray-800 dark:text-blue-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}"
                        :class="sidebarOpen ? '' : 'justify-center px-2'">
                        <div class="relative flex items-center">
                            <svg class="w-5 h-5 transition-all duration-300 {{ $isLayananActive ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-700 dark:group-hover:text-gray-300' }}" :class="sidebarOpen ? 'mr-3' : 'mr-0'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <span x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" class="truncate whitespace-nowrap">
                                Layanan & Riwayat
                            </span>
                        </div>
                        <svg x-show="sidebarOpen" :class="{'rotate-180': open}" class="w-4 h-4 transition-transform {{ $isLayananActive ? 'text-blue-600' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" x-collapse class="mt-1 space-y-1" :class="sidebarOpen ? 'pl-4' : 'pl-0'">
                        <!-- Registrasi Kehadiran -->
                        <x-nav-link href="{{ route('pegawai.kehadiran.index') }}" icon="clipboard-list" active="{{ request()->routeIs('pegawai.kehadiran*') }}">
                            Registrasi Kehadiran
                        </x-nav-link>

                        <!-- Pelayanan Hari Ini -->
                        <x-nav-link href="{{ route('pegawai.pelayanan-hari-ini.index') }}" icon="clipboard-list" active="{{ request()->routeIs('pegawai.pelayanan-hari-ini*') }}">
                            Pelayanan Hari Ini
                        </x-nav-link>

                        <!-- Riwayat Pelayanan -->
                        <x-nav-link href="{{ route('pegawai.pelayanan.index') }}" icon="clipboard-list" active="{{ request()->routeIs('pegawai.pelayanan.index') || request()->routeIs('pegawai.pelayanan.show') }}">
                            Riwayat Pelayanan
                        </x-nav-link>
                    </div>
                </div>

                <!-- Laporan -->

                <x-nav-link href="{{ route('admin.articles.index') }}" icon="document-text" active="{{ request()->routeIs('admin.articles*') }}">
                    Artikel
                </x-nav-link>

                <x-nav-link href="{{ route('admin.news.index') }}" icon="newspaper" active="{{ request()->routeIs('admin.news*') }}">
                    Berita
                </x-nav-link>

                <x-nav-link href="{{ route('admin.announcements.index') }}" icon="speakerphone" active="{{ request()->routeIs('admin.announcements*') }}">
                    Pengumuman
                </x-nav-link>

            @elseif(Auth::user()->role === 'warga')
                <!-- Dashboard warga -->
                <x-nav-link href="{{ route('warga.dashboard') }}" icon="home"
                    active="{{ request()->routeIs('warga.dashboard') }}">
                    Dashboard
                </x-nav-link>

                <!-- Data Warga (Diri Sendiri) -->
                <x-nav-link href="{{ route('warga.warga.index') }}" icon="user"
                    active="{{ request()->routeIs('warga.warga*') }}">
                    Data Saya
                </x-nav-link>

                <!-- Data Balita Saya -->
                <x-nav-link href="{{ route('warga.balita.index') }}" icon="baby"
                    active="{{ request()->routeIs('warga.balita*') }}">
                    Balita Saya
                </x-nav-link>

                <!-- Data Remaja -->
                <x-nav-link href="{{ route('warga.remaja.index') }}" icon="user-group"
                    active="{{ request()->routeIs('warga.remaja*') }}">
                    Data Remaja
                </x-nav-link>

                <!-- Data Lansia -->
                <x-nav-link href="{{ route('warga.lansia.index') }}" icon="user"
                    active="{{ request()->routeIs('warga.lansia*') }}">
                    Data Lansia
                </x-nav-link>

                <!-- Jadwal Posyandu -->
                <x-nav-link href="{{ route('public.schedule') }}" icon="calendar" active="{{ request()->routeIs('public.schedule') }}">
                    Jadwal Posyandu
                </x-nav-link>

                <!-- Riwayat Pelayanan -->
                <x-nav-link href="{{ route('warga.pelayanan.index') }}" icon="clipboard-list" active="{{ request()->routeIs('warga.pelayanan*') }}">
                    Riwayat Pelayanan
                </x-nav-link>

                <div class="pt-5 pb-2 px-4 overflow-hidden" x-show="sidebarOpen" x-transition>
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block truncate">Informasi</span>
                </div>

                <x-nav-link href="{{ route('public.articles') }}" icon="document-text" active="{{ request()->routeIs('public.articles*') }}">
                    Artikel
                </x-nav-link>
                
                <x-nav-link href="{{ route('public.news') }}" icon="newspaper" active="{{ request()->routeIs('public.news*') }}">
                    Berita
                </x-nav-link>
                
                <x-nav-link href="{{ route('public.announcements') }}" icon="speakerphone" active="{{ request()->routeIs('public.announcements*') }}">
                    Pengumuman
                </x-nav-link>
            @endif
        </nav>

        <!-- Sidebar Footer -->
        <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">
            <div class="flex items-center" :class="sidebarOpen ? 'space-x-3' : 'justify-center'">
                <img src="{{ $user->foto_url }}" alt="User" class="w-8 h-8 rounded-full object-cover">
                <div class="flex-1 min-w-0" x-show="sidebarOpen" x-transition>
                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $user->name }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ ucfirst($user->role) }}</p>
                </div>
                <button @click="toggleDarkMode()" x-show="sidebarOpen"
                    class="p-1.5 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                    <svg x-show="!darkMode" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                    <svg x-show="darkMode" x-cloak class="w-4 h-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</aside>

<!-- Mobile overlay -->
<div class="fixed inset-0 z-30 bg-black/50 transition-opacity duration-300 lg:hidden" x-show="sidebarOpen"
    x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    @click="sidebarOpen = false">
</div>