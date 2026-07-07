<div x-show="activeTab === 'identity'" x-cloak x-transition.opacity.duration.300ms>
    <h2 class="text-xl font-bold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-3 mb-6">Logo & Identitas Website</h2>
    
    <div class="space-y-6">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Singkat Aplikasi</label>
                <input type="text" name="app_name_short" value="{{ setting('app_name_short', 'Posyandu') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Slogan (Tagline)</label>
                <input type="text" name="app_slogan" value="{{ setting('app_slogan', 'Sistem Informasi Manajemen Pelayanan') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Teks Copyright Footer</label>
                <input type="text" name="app_footer_copyright" value="{{ setting('app_footer_copyright', '© 2026 Posyandu. Hak Cipta Dilindungi.') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pt-6 border-t border-gray-200 dark:border-gray-700">
            
            {{-- Logo Utama --}}
            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 bg-gray-50 dark:bg-gray-800">
                <label class="block text-sm font-bold text-gray-900 dark:text-white mb-2">Logo Utama</label>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">Tampil di background terang (header navbar desktop/kuitansi logo).</p>
                @if(setting('app_logo_main'))
                    <div class="mb-4 bg-white border border-gray-200 p-2 rounded flex justify-center">
                        <img src="{{ Storage::url(setting('app_logo_main')) }}" alt="Main Logo" class="h-16 object-contain">
                    </div>
                @endif
                <input type="file" name="app_logo_main" accept="image/*" class="block w-full text-xs text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
            </div>

            {{-- Logo Putih --}}
            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 bg-gray-50 dark:bg-gray-800">
                <label class="block text-sm font-bold text-gray-900 dark:text-white mb-2">Logo Putih / Negatif</label>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">Tampil di background gelap (contoh: dark mode atau footer color).</p>
                @if(setting('app_logo_white'))
                    <div class="mb-4 bg-gray-900 border border-gray-700 p-2 rounded flex justify-center">
                        <img src="{{ Storage::url(setting('app_logo_white')) }}" alt="White Logo" class="h-16 object-contain">
                    </div>
                @endif
                <input type="file" name="app_logo_white" accept="image/*" class="block w-full text-xs text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
            </div>

            {{-- Favicon --}}
            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 bg-gray-50 dark:bg-gray-800">
                <label class="block text-sm font-bold text-gray-900 dark:text-white mb-2">Favicon (Ikon Tab Browser)</label>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">Tampil di tab browser. Harus persegi/kotak (sebaiknya 512x512 PNG/ICO).</p>
                @if(setting('app_favicon'))
                    <div class="mb-4 bg-white border border-gray-200 p-2 rounded flex justify-center inline-block">
                        <img src="{{ Storage::url(setting('app_favicon')) }}" alt="Favicon" class="w-12 h-12 object-contain">
                    </div>
                @endif
                <input type="file" name="app_favicon" accept="image/png,image/x-icon,image/jpeg" class="block w-full text-xs text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
            </div>

        </div>
    </div>
</div>
