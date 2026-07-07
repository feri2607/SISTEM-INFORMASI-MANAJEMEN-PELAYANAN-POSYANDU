<div x-show="activeTab === 'landing'" x-cloak x-transition.opacity.duration.300ms>
    <h2 class="text-xl font-bold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-3 mb-6">Pengaturan Landing Page (Beranda)</h2>
    
    <div class="space-y-8">
        {{-- Hero Status --}}
        <div>
            <label class="inline-flex items-center bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-4 rounded-lg w-full cursor-pointer hover:bg-gray-100 transition-colors">
                <input type="checkbox" name="hero_is_active" value="1" {{ setting('hero_is_active', '1') == '1' ? 'checked' : '' }} class="rounded border-gray-300 text-teal-600 shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50 h-5 w-5">
                <div class="ml-3">
                    <span class="block text-sm font-bold text-gray-900 dark:text-white">Tampilkan Hero Section</span>
                    <span class="block text-xs text-gray-500 dark:text-gray-400">Jika dinonaktifkan, bagian selamat datang / spanduk utama di beranda akan disembunyikan.</span>
                </div>
            </label>
        </div>

        {{-- Hero Texts --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <h3 class="font-semibold text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-2">Konten Teks</h3>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Judul Hero (Heading)</label>
                    <input type="text" name="hero_title" value="{{ setting('hero_title', 'Selamat Datang di Posyandu Kami') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sub Judul Hero</label>
                    <input type="text" name="hero_subtitle" value="{{ setting('hero_subtitle', 'Memantau Tumbuh Kembang dengan Penuh Cinta') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi Hero</label>
                    <textarea name="hero_description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">{{ setting('hero_description') }}</textarea>
                </div>
            </div>
            
            <div class="space-y-4">
                <h3 class="font-semibold text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-2">Tombol Aksi (Buttons)</h3>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Teks Button Utama (Primary)</label>
                    <input type="text" name="hero_btn_primary_text" value="{{ setting('hero_btn_primary_text', 'Layanan Kami') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Link Button Utama</label>
                    <input type="text" name="hero_btn_primary_link" value="{{ setting('hero_btn_primary_link', '#layanan') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                </div>
                <div class="pt-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Teks Button Kedua (Secondary)</label>
                    <input type="text" name="hero_btn_secondary_text" value="{{ setting('hero_btn_secondary_text', 'Hubungi Kami') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Link Button Kedua</label>
                    <input type="text" name="hero_btn_secondary_link" value="{{ setting('hero_btn_secondary_link', '/kontak') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                </div>
            </div>
        </div>

        {{-- Hero Images --}}
        <div>
            <h3 class="font-semibold text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-2 mb-4">Gambar dan Background</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- Upload Foto Hero --}}
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Upload Foto Hero (Kanan)</label>
                    @if(setting('hero_image'))
                        <div class="mb-3">
                            <img src="{{ Storage::url(setting('hero_image')) }}" alt="Hero Image Preview" class="h-32 object-contain rounded-md bg-gray-100 p-1">
                        </div>
                    @endif
                    <input type="file" name="hero_image" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                    <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, WEBP. Maks 2MB.</p>
                </div>
                
                {{-- Upload Background Hero --}}
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Upload Background Pola (Opsional)</label>
                    @if(setting('hero_background'))
                        <div class="mb-3">
                            <img src="{{ Storage::url(setting('hero_background')) }}" alt="Hero Background Preview" class="h-32 object-cover rounded-md bg-gray-100">
                        </div>
                    @endif
                    <input type="file" name="hero_background" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                    <p class="mt-1 text-xs text-gray-500">Pola watermark atau elemen vektor di bagian belakang teks.</p>
                </div>
            </div>
        </div>

        {{-- Statistics Highlight --}}
        <div>
            <h3 class="font-semibold text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-2 mb-4">Highlight Statistik (Tampil di Beranda)</h3>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="stat_show_balita" value="1" {{ setting('stat_show_balita', '1') == '1' ? 'checked' : '' }} class="rounded border-gray-300 text-teal-600 shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Jumlah Balita</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="stat_show_ibuhamil" value="1" {{ setting('stat_show_ibuhamil', '1') == '1' ? 'checked' : '' }} class="rounded border-gray-300 text-teal-600 shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Jumlah Ibu Hamil</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="stat_show_remaja" value="1" {{ setting('stat_show_remaja', '1') == '1' ? 'checked' : '' }} class="rounded border-gray-300 text-teal-600 shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Jumlah Remaja</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="stat_show_lansia" value="1" {{ setting('stat_show_lansia', '1') == '1' ? 'checked' : '' }} class="rounded border-gray-300 text-teal-600 shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Jumlah Lansia</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="stat_show_wuspus" value="1" {{ setting('stat_show_wuspus', '1') == '1' ? 'checked' : '' }} class="rounded border-gray-300 text-teal-600 shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Jumlah WUS/PUS</span>
                </label>
            </div>
        </div>

    </div>
</div>
