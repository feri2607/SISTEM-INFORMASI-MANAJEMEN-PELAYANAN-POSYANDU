{{-- resources/views/components/public/footer.blade.php --}}

<footer class="bg-gray-900 text-gray-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            {{-- About --}}
            <div>
                <div class="flex items-center space-x-3 mb-4">
                    <img src="{{ setting('app_logo_white') ? Storage::url(setting('app_logo_white')) : (setting('app_logo_main') ? Storage::url(setting('app_logo_main')) : asset('images/posyandu-logo.png')) }}" alt="Logo Posyandu" class="h-10 w-auto">
                    <span class="text-lg font-bold text-white">{{ setting('app_name_short', 'Posyandu') }}</span>
                </div>
                <p class="text-sm leading-relaxed">
                    {{ setting('posyandu_description', 'Sistem Informasi Posyandu Digital mendukung pelayanan kesehatan ibu dan anak yang lebih cepat, mudah, dan terintegrasi.') }}
                </p>
                @if(setting('social_display_active', '1') == '1')
                <div class="flex space-x-4 mt-4">
                    @if(setting('social_facebook'))
                    <a href="{{ setting('social_facebook') }}" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-white transition duration-150">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                    </a>
                    @endif
                    @if(setting('social_instagram'))
                    <a href="{{ setting('social_instagram') }}" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-white transition duration-150">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    </a>
                    @endif
                    @if(setting('social_youtube'))
                    <a href="{{ setting('social_youtube') }}" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-white transition duration-150">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                    </a>
                    @endif
                    @if(setting('social_x_twitter'))
                    <a href="{{ setting('social_x_twitter') }}" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-white transition duration-150">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z"/></svg>
                    </a>
                    @endif
                    @if(setting('social_website'))
                    <a href="{{ setting('social_website') }}" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-white transition duration-150">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                    </a>
                    @endif
                </div>
                @endif
            </div>

            {{-- Quick Links --}}
            <div>
                <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Menu Cepat</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="text-sm hover:text-white transition duration-150">Beranda</a></li>
                    <li><a href="{{ route('about') }}" class="text-sm hover:text-white transition duration-150">Tentang Posyandu</a></li>
                    <li><a href="{{ route('public.schedule') }}" class="text-sm hover:text-white transition duration-150">Jadwal Posyandu</a></li>
                    <li><a href="{{ route('public.articles') }}" class="text-sm hover:text-white transition duration-150">Artikel Edukasi</a></li>
                    <li><a href="{{ route('public.news') }}" class="text-sm hover:text-white transition duration-150">Berita</a></li>
                    <li><a href="{{ route('public.announcements') }}" class="text-sm hover:text-white transition duration-150">Pengumuman</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Kontak</h3>
                <ul class="space-y-3">
                    <li class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-teal-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="text-sm">{{ setting('posyandu_address', 'Jl. Kesehatan No. 123') }}{{ setting('posyandu_city') ? ', ' . setting('posyandu_city') : '' }}</span>
                    </li>
                    <li class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-teal-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-sm">{{ setting('contact_email', 'info@posyandu.go.id') }}</span>
                    </li>
                    <li class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-teal-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span class="text-sm">{{ setting('contact_phone', '(021) 1234-5678') }}</span>
                    </li>
                    <li class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-teal-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm">{{ setting('posyandu_service_days', 'Senin - Jumat') }}: {{ setting('posyandu_hours', '08:00 - 16:00') }}</span>
                    </li>
                </ul>
            </div>

            {{-- Newsletter --}}
            <div>
                <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Langganan</h3>
                <p class="text-sm mb-3">Dapatkan informasi terbaru dari Posyandu.</p>
                <form class="flex flex-col space-y-2">
                    <input type="email" placeholder="Email Anda" 
                           class="px-4 py-2 text-sm bg-gray-800 border border-gray-700 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-white placeholder-gray-400">
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-[#036672] hover:bg-[#036672] rounded-lg transition duration-150">
                        Berlangganan
                    </button>
                </form>
                <p class="text-xs text-gray-500 mt-2">Kami tidak akan spam, hanya informasi penting.</p>
            </div>
        </div>

        {{-- Bottom Bar --}}
        <div class="border-t border-gray-800 mt-8 pt-8 flex flex-col sm:flex-row items-center justify-between">
            <p class="text-sm text-gray-400">
                {!! setting('app_footer_copyright', '&copy; ' . date('Y') . ' Sistem Informasi Posyandu. All rights reserved.') !!}
            </p>
            <p class="text-sm text-gray-500 mt-2 sm:mt-0">
                Versi 1.0.0 | Laravel {{ app()->version() }}
            </p>
        </div>
    </div>
</footer>