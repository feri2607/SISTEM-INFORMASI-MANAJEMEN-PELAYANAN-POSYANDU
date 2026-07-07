<div x-show="activeTab === 'organization'" x-cloak x-transition.opacity.duration.300ms>
    <h2 class="text-xl font-bold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-3 mb-6">Struktur Organisasi Posyandu</h2>
    
    <div class="px-4 py-12 text-center bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 h-full flex flex-col justify-center items-center">
        <svg class="h-16 w-16 text-teal-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Manajemen Profil Pengurus</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400 max-w-md mx-auto mb-6">Kelola data profil lengkap pengurus, bidan desa, dan kader-kader yang bertugas di Posyandu. Data ini akan ditampilkan pada halaman "Tentang Kami".</p>
        
        <a href="{{ route('admin.struktur-organisasi.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#036672] hover:bg-[#036672] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
            Kelola Struktur Organisasi
            <svg class="ml-2 -mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
        </a>
    </div>
</div>
