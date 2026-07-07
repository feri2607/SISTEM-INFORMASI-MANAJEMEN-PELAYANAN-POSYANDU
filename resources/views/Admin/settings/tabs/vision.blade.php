<div x-show="activeTab === 'vision'" x-cloak x-transition.opacity.duration.300ms>
    <h2 class="text-xl font-bold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-3 mb-6">Visi & Misi Posyandu</h2>
    
    <div class="space-y-8">
        {{-- Visi --}}
        <div>
            <h3 class="font-semibold text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-2 mb-4">Visi Utama</h3>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Teks Visi (Rich Text) <span class="text-red-500">*</span></label>
                <textarea name="vision_text" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">{{ setting('vision_text', 'Mewujudkan balita sehat, cerdas, dan sejahtera untuk generasi masa depan yang gemilang.') }}</textarea>
            </div>
        </div>

        {{-- Misi Repeater --}}
        <div x-data="{ 
                missions: {{ json_encode(json_decode(setting('missions', '[]'), true) ?: ['']) }} 
            }">
            
            <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-700 pb-2 mb-4">
                <h3 class="font-semibold text-gray-900 dark:text-white">Daftar Misi</h3>
                <button type="button" @click="missions.push('')" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-[#036672] hover:bg-[#036672] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    Tambah Misi
                </button>
            </div>

            <div class="space-y-3">
                <template x-for="(mission, index) in missions" :key="index">
                    <div class="flex items-start space-x-3 bg-gray-50 dark:bg-gray-800 p-3 rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="flex-shrink-0 pt-1 cursor-grab opacity-50 hover:opacity-100">
                            <svg class="h-5 w-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 5a2 2 0 114 0v10a2 2 0 11-4 0V5zm10 0a2 2 0 114 0v10a2 2 0 11-4 0V5z" clip-rule="evenodd" /></svg>
                        </div>
                        <div class="flex-grow">
                            <input type="text" :name="'missions[]'" x-model="missions[index]" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm" placeholder="Contoh: Menyelenggarakan pelayanan kesehatan ibu dan anak secara rutin">
                        </div>
                        <div class="flex-shrink-0">
                            <button type="button" @click="missions.splice(index, 1)" class="p-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-md transition-colors">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>
                </template>
                <div x-show="missions.length === 0" class="text-center py-6 text-sm text-gray-500 dark:text-gray-400 italic">
                    Belum ada data Misi. Klik "Tambah Misi" untuk mulai menambahkan.
                </div>
            </div>
            <p class="mt-2 text-xs text-gray-500">Urutan misi dapat disesuaikan dengan mengubah isian (drag and drop coming soon).</p>
        </div>
    </div>
</div>
