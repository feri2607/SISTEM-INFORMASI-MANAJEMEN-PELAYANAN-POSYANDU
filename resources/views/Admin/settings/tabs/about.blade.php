<div x-show="activeTab === 'about'" x-cloak x-transition.opacity.duration.300ms>
    <h2 class="text-xl font-bold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-3 mb-6">Tentang Kami</h2>
    
    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Judul Tentang Kami</label>
                <input type="text" name="about_title" value="{{ setting('about_title', 'Mengenal Posyandu Kami Lebih Dekat') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sub Judul</label>
                <input type="text" name="about_subtitle" value="{{ setting('about_subtitle', 'Melayani dengan hati, mengabdi untuk negeri.') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Isi Tentang Kami (Rich Text)</label>
            <textarea name="about_content" rows="6" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">{{ setting('about_content') }}</textarea>
            <p class="mt-1 text-xs text-gray-500">Isikan profil lengkap, sejarah berdirinya, atau deskripsi panjang posyandu.</p>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nilai-Nilai Posyandu / Tujuan Berdiri</label>
            <textarea name="about_values" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">{{ setting('about_values') }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 bg-gray-50 dark:bg-gray-800">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Upload Foto Tentang Kami</label>
                @if(setting('about_image'))
                    <div class="mb-3">
                        <img src="{{ Storage::url(setting('about_image')) }}" alt="About Image Preview" class="h-32 object-cover rounded-md">
                    </div>
                @endif
                <input type="file" name="about_image" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
            </div>
            
            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 bg-gray-50 dark:bg-gray-800">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Upload Video Profil (Opsional)</label>
                @if(setting('about_video'))
                    <div class="mb-3">
                        <video src="{{ Storage::url(setting('about_video')) }}" controls class="h-32 rounded-md"></video>
                    </div>
                @endif
                <input type="file" name="about_video" accept="video/mp4,video/webm" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
            </div>
        </div>
    </div>
</div>
