{{-- resources/views/layouts/app.blade.php --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ 
    sidebarOpen: window.innerWidth >= 1024,
    showLogoutModal: false,
    init() {
        // Check window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                this.sidebarOpen = true;
            }
        });
    }
}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Sistem Informasi Posyandu'))</title>
    
    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    
    {{-- Scripts --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    

    
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900">
    <div class="min-h-screen flex">
        {{-- Sidebar --}}
        <x-sidebar />

        @php
            $sidebarOpenMargin = 'lg:ml-64';
            $sidebarClosedMargin = 'lg:ml-20';
        @endphp
        {{-- Main Content --}}
        <div class="flex-1 flex flex-col min-h-screen transition-all duration-300"
             :class="sidebarOpen ? '{{ $sidebarOpenMargin }}' : '{{ $sidebarClosedMargin }}'">
            
            {{-- Topbar --}}
            <x-topbar />

            {{-- Breadcrumb --}}
            <x-breadcrumb />

            {{-- Page Header --}}
            <div class="px-4 md:px-6 pt-4">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">
                    @yield('page-title')
                </h1>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    @yield('page-subtitle')
                </p>
            </div>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="px-4 md:px-6 mt-4">
                    <div class="p-4 bg-green-50 dark:bg-green-900/30 border-l-4 border-green-500 rounded-lg">
                        <p class="text-green-700 dark:text-green-400">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="px-4 md:px-6 mt-4">
                    <div class="p-4 bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 rounded-lg">
                        <p class="text-red-700 dark:text-red-400">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            @if(session('warning'))
                <div class="px-4 md:px-6 mt-4">
                    <div class="p-4 bg-yellow-50 dark:bg-yellow-900/30 border-l-4 border-yellow-500 rounded-lg">
                        <p class="text-yellow-700 dark:text-yellow-400">{{ session('warning') }}</p>
                    </div>
                </div>
            @endif

            {{-- Content --}}
            <main class="flex-1 p-4 md:p-6">
                @yield('content')
            </main>

            {{-- Footer --}}
            <x-footer />
        </div>
    </div>

    {{-- Scroll to Top --}}
    <button @click="window.scrollTo({top: 0, behavior: 'smooth'})"
            x-show="window.scrollY > 300"
            x-transition
            class="fixed bottom-6 right-6 p-3 bg-[#036672] hover:bg-[#036672] text-white rounded-full shadow-lg transition duration-200 z-50">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
        </svg>
    </button>

    @stack('scripts')
</body>
</html>