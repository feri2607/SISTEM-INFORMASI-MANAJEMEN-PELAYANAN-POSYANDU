<div x-show="activeTab === 'seo'" x-cloak x-transition.opacity.duration.300ms>
    <h2 class="text-xl font-bold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-3 mb-6">SEO (Search Engine Optimization)</h2>
    
    <div class="space-y-6">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Meta Title Default</label>
                <input type="text" name="seo_meta_title" value="{{ setting('seo_meta_title', 'Posyandu Terpadu - Sistem Informasi') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Meta Keywords</label>
                <input type="text" name="seo_meta_keywords" value="{{ setting('seo_meta_keywords', 'posyandu, balita, ibu hamil, kesehatan, desa') }}" placeholder="Pisahkan dengan koma" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Meta Description</label>
                <textarea name="seo_meta_description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">{{ setting('seo_meta_description') }}</textarea>
                <p class="mt-1 text-xs text-gray-500">Maksimal disarankan 160 karakter untuk pencarian Google.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pt-6 border-t border-gray-200 dark:border-gray-700">
            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 bg-gray-50 dark:bg-gray-800">
                <label class="block text-sm font-bold text-gray-900 dark:text-white mb-2">Open Graph Image (Social Share)</label>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">Gambar ketika link website dibagikan di WhatsApp, FB, dll. (1200x630 px)</p>
                @if(setting('seo_og_image'))
                    <div class="mb-4 bg-white border border-gray-200 p-2 rounded flex justify-center">
                        <img src="{{ Storage::url(setting('seo_og_image')) }}" alt="OG Image" class="h-16 object-contain">
                    </div>
                @endif
                <input type="file" name="seo_og_image" accept="image/*" class="block w-full text-xs text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
            </div>

            <div class="space-y-4 md:col-span-1 lg:col-span-2">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Google Analytics (G-TAG ID)</label>
                    <input type="text" name="seo_google_analytics" value="{{ setting('seo_google_analytics') }}" placeholder="G-XXXXXXXXXX" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Facebook Pixel ID</label>
                    <input type="text" name="seo_fb_pixel" value="{{ setting('seo_fb_pixel') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                </div>
                <div class="pt-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="seo_robots_index" value="1" {{ setting('seo_robots_index', '1') == '1' ? 'checked' : '' }} class="rounded border-gray-300 text-teal-600 shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Izinkan Mesin Pencari (Google/Bing) mengindeks situs ini (INDEX, FOLLOW)</span>
                    </label>
                </div>
            </div>
        </div>

    </div>
</div>
