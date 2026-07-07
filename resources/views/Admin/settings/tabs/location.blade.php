<div x-show="activeTab === 'location'" x-cloak x-transition.opacity.duration.300ms>
    <h2 class="text-xl font-bold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-3 mb-6">Lokasi & Peta Posyandu</h2>
    
    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Latitude</label>
                <input type="text" name="location_lat" value="{{ setting('location_lat') }}" placeholder="-6.200000" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Longitude</label>
                <input type="text" name="location_lng" value="{{ setting('location_lng') }}" placeholder="106.816666" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Google Maps Embed iframe (HTML)</label>
            <textarea name="location_embed_html" rows="4" placeholder='<iframe src="https://www.google.com/maps/embed?..." width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>' class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">{{ setting('location_embed_html') }}</textarea>
            <p class="mt-1 text-xs text-gray-500">Buka Google Maps > Cari Lokasi Posyandu > Klik Bagikan (Share) > Sematkan Peta (Embed a map) > Salin HTML.</p>
        </div>

        @if(setting('location_embed_html'))
            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-2 bg-gray-50 dark:bg-gray-800">
                <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2 px-2">Preview Peta</h3>
                <div class="aspect-w-16 aspect-h-9 overflow-hidden rounded-md">
                    {!! setting('location_embed_html') !!}
                </div>
            </div>
        @endif
        
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Link Google Maps (Direct URL)</label>
            <input type="url" name="location_url" value="{{ setting('location_url') }}" placeholder="https://goo.gl/maps/..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
            <p class="mt-1 text-xs text-gray-500">URL langsung ketika pengunjung menekan tombol "Buka di Peta".</p>
        </div>
    </div>
</div>
