<div x-show="activeTab === 'backup'" x-cloak x-transition.opacity.duration.300ms>
    <h2 class="text-xl font-bold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-3 mb-6">Backup Database & File Sistem</h2>
    
    <div class="px-4 py-8 text-center bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 h-full flex flex-col justify-center items-center">
        <svg class="h-16 w-16 text-teal-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Panel Manajemen Backup Manual</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400 max-w-md mx-auto mb-6">Fitur ini memungkinkan Anda mencadangkan seluruh data Posyandu (PostgreSQL / MySQL) beserta aset unggahan seperti gambar foto balita dan dokumen.</p>
        
        <div class="space-x-3">
             <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#036672] hover:bg-[#036672] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 opacity-70 cursor-not-allowed" disabled>
                 <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                 Download Full Backup (ZIP)
             </button>
             <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md shadow-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 opacity-70 cursor-not-allowed" disabled>
                 <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                 Restore Backup
             </button>
        </div>
        <p class="mt-4 text-xs italic text-gray-400">Modul Backup Spatie sedang diintegrasikan. Harap hubungi penyedia server untuk backup via CPanel/DirectAdmin saat ini.</p>
    </div>
</div>
