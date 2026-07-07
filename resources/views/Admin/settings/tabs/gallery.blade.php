<div x-show="activeTab === 'gallery'" x-cloak x-transition.opacity.duration.300ms>
    <h2 class="text-xl font-bold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-3 mb-6">Album Galeri Kegiatan</h2>
    
    <div class="px-4 py-12 text-center bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 h-full flex flex-col justify-center items-center">
        <svg class="h-16 w-16 text-teal-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Manajemen Galeri & Kategori</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400 max-w-md mx-auto mb-6">Buat album kegiatan, unggah banyak foto (batch upload), dan kelola galeri dokumentasi kegiatan rutin posyandu (seperti Imunisasi, PMT, dll).</p>
        
        <a href="{{ route('admin.galeri.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#036672] hover:bg-[#036672] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
            Kelola Galeri Foto
            <svg class="ml-2 -mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
        </a>
    </div>
</div>
