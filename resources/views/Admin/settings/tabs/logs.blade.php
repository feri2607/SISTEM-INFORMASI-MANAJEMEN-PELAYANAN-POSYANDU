<div x-show="activeTab === 'logs'" x-cloak x-transition.opacity.duration.300ms>
    <h2 class="text-xl font-bold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-3 mb-6">Riwayat Log Aktivitas Modul</h2>
    
    <div class="px-4 py-8 text-center bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 h-full flex flex-col justify-center items-center">
        <svg class="h-16 w-16 text-gray-400 dark:text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Pencatatan Audit Trail / Activity Log</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400 max-w-md mx-auto mb-6">Fitur ini menampilkan siapa Pegawai/Admin yang membuat perubahan data warga, rekam medis balita, atau menghapus postingan blog. Log akan direkam secara otomatis oleh sistem.</p>
        
        <a href="#" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#036672] focus:outline-none opacity-50 cursor-not-allowed">
            Lihat Tabel Seluruh Aktivitas
        </a>
        <p class="mt-4 text-xs italic text-gray-400">Modul Spatie Activitylog sedang diintegrasikan. Harap pantau update minor berikutnya.</p>
    </div>
</div>
