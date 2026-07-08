{{-- resources/views/layouts/public.blade.php --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    {{-- SEO Meta Tags --}}
    <title>@yield('title', setting('seo_meta_title', 'Sistem Informasi Posyandu Digital'))</title>
    <meta name="description" content="@yield('description', setting('seo_meta_description', 'Sistem Informasi Posyandu Digital - Mendukung pelayanan kesehatan ibu dan anak yang lebih cepat, mudah, transparan, dan terintegrasi.'))">
    <meta name="keywords" content="{{ setting('seo_meta_keywords', 'posyandu, kesehatan, ibu, anak, balita, imunisasi, gizi, kesehatan masyarakat') }}">
    <meta name="robots" content="{{ setting('seo_robots_index', '1') == '1' ? 'index, follow' : 'noindex, nofollow' }}">
    <link rel="canonical" href="{{ url()->current() }}">
    
    {{-- Open Graph --}}
    <meta property="og:title" content="@yield('title', setting('seo_meta_title', 'Sistem Informasi Posyandu Digital'))">
    <meta property="og:description" content="@yield('description', setting('seo_meta_description', 'Sistem Informasi Posyandu Digital - Mendukung pelayanan kesehatan ibu dan anak yang lebih cepat, mudah, transparan, dan terintegrasi.'))">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ setting('seo_og_image') ? Storage::url(setting('seo_og_image')) : asset('images/og-image.jpg') }}">
    <meta property="og:site_name" content="{{ setting('app_name_short', 'Sistem Informasi Posyandu') }}">
    
    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', setting('seo_meta_title', 'Sistem Informasi Posyandu Digital'))">
    <meta name="twitter:description" content="@yield('description', setting('seo_meta_description', 'Sistem Informasi Posyandu Digital - Mendukung pelayanan kesehatan ibu dan anak yang lebih cepat, mudah, transparan, dan terintegrasi.'))">
    <meta name="twitter:image" content="{{ setting('seo_og_image') ? Storage::url(setting('seo_og_image')) : asset('images/og-image.jpg') }}">

    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ setting('app_favicon') ? Storage::url(setting('app_favicon')) : asset('images/favicon.png') }}">
    
    @if(setting('seo_google_analytics'))
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ setting('seo_google_analytics') }}"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '{{ setting("seo_google_analytics") }}');
    </script>
    @endif
    
    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    
    {{-- Scripts --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')
</head>
<body x-data="{ 
    mobileMenuOpen: false,
    scrollY: 0,
    init() {
        window.addEventListener('scroll', () => {
            this.scrollY = window.scrollY;
        });
    }
}" 
class="font-sans antialiased bg-white text-gray-800" 
@scroll.window="scrollY = window.scrollY">

    {{-- Navbar --}}
    <x-public.navbar />

    {{-- Main Content --}}
    <main class="pt-20 pb-12">

        {{-- Page Header (hanya jika ada section page-title) --}}
        @hasSection('page-title')
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">
                @yield('page-title')
            </h1>
            @hasSection('page-subtitle')
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                @yield('page-subtitle')
            </p>
            @endif
        </div>
        @endif

        {{-- Flash Messages --}}
        @if(session('success') || session('error') || session('warning'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-4">
            @if(session('success'))
                <div class="p-4 bg-green-50 dark:bg-green-900/30 border-l-4 border-green-500 rounded-lg mb-2">
                    <p class="text-green-700 dark:text-green-400">{{ session('success') }}</p>
                </div>
            @endif
            @if(session('error'))
                <div class="p-4 bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 rounded-lg mb-2">
                    <p class="text-red-700 dark:text-red-400">{{ session('error') }}</p>
                </div>
            @endif
            @if(session('warning'))
                <div class="p-4 bg-yellow-50 dark:bg-yellow-900/30 border-l-4 border-yellow-500 rounded-lg mb-2">
                    <p class="text-yellow-700 dark:text-yellow-400">{{ session('warning') }}</p>
                </div>
            @endif
        </div>
        @endif

        @yield('content')
    </main>

    {{-- Footer (disembunyikan jika view mendefinisikan @section('hide-footer')) --}}
    @unless(View::hasSection('hide-footer'))
        <x-public.footer />
    @endunless

    {{-- Scroll to Top --}}
    <button @click="window.scrollTo({top: 0, behavior: 'smooth'})"
            x-show="scrollY > 300"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-75"
            x-transition:enter-end="opacity-100 transform scale-100"
            class="fixed bottom-6 right-6 p-3 bg-[#036672] hover:bg-[#036672] text-white rounded-full shadow-lg transition duration-200 z-50">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
        </svg>
    </button>

    @stack('scripts')
</body>
</html>