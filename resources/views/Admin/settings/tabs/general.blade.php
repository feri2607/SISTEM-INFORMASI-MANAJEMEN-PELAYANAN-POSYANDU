<div x-show="activeTab === 'general'" x-cloak x-transition.opacity.duration.300ms>
    <h2 class="text-xl font-bold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-3 mb-6">Pengaturan Umum Situs</h2>
    
    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Zona Waktu (Timezone)</label>
                <select name="gen_timezone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                    <option value="Asia/Jakarta" {{ setting('gen_timezone', 'Asia/Jakarta') == 'Asia/Jakarta' ? 'selected' : '' }}>WIB - Asia/Jakarta</option>
                    <option value="Asia/Makassar" {{ setting('gen_timezone') == 'Asia/Makassar' ? 'selected' : '' }}>WITA - Asia/Makassar</option>
                    <option value="Asia/Jayapura" {{ setting('gen_timezone') == 'Asia/Jayapura' ? 'selected' : '' }}>WIT - Asia/Jayapura</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bahasa Utama Sistem</label>
                <select name="gen_language" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                    <option value="id" {{ setting('gen_language', 'id') == 'id' ? 'selected' : '' }}>Bahasa Indonesia (ID)</option>
                    <option value="en" {{ setting('gen_language') == 'en' ? 'selected' : '' }}>English (EN)</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Format Tanggal Tampil</label>
                <select name="gen_date_format" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                    <option value="d M Y" {{ setting('gen_date_format', 'd M Y') == 'd M Y' ? 'selected' : '' }}>17 Ags 2026</option>
                    <option value="d F Y" {{ setting('gen_date_format') == 'd F Y' ? 'selected' : '' }}>17 Agustus 2026</option>
                    <option value="d/m/Y" {{ setting('gen_date_format') == 'd/m/Y' ? 'selected' : '' }}>17/08/2026</option>
                    <option value="Y-m-d" {{ setting('gen_date_format') == 'Y-m-d' ? 'selected' : '' }}>2026-08-17</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Format Waktu</label>
                <select name="gen_time_format" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                    <option value="H:i" {{ setting('gen_time_format', 'H:i') == 'H:i' ? 'selected' : '' }}>24 Jam (14:30)</option>
                    <option value="h:i A" {{ setting('gen_time_format') == 'h:i A' ? 'selected' : '' }}>12 Jam (02:30 PM)</option>
                </select>
            </div>
        </div>

        <div class="border-t border-gray-100 dark:border-gray-700 pt-6">
            <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Pengendalian Situs Publik</h3>
            <div class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="gen_maintenance" value="1" {{ setting('gen_maintenance', '0') == '1' ? 'checked' : '' }} class="rounded border-gray-300 text-red-600 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50 h-5 w-5">
                    <span class="ml-3 font-medium text-red-700 dark:text-red-400">Aktifkan Mode Maintenance / Sedang Perbaikan (Under Construction)</span>
                </label>
                <p class="mt-2 text-sm text-red-600 dark:text-red-300 ml-8">Jika dicentang, warga dan publik tidak dapat mengakses website dan hanya akan melihat layar perbaikan. Akses admin tetap normal.</p>
            </div>
        </div>
    </div>
</div>
