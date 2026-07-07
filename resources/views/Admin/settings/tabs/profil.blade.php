<div x-show="activeTab === 'profil'" x-cloak x-transition.opacity.duration.300ms>
    <h2 class="text-xl font-bold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-3 mb-6">Profil Posyandu</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Posyandu <span class="text-red-500">*</span></label>
                <input type="text" name="posyandu_name" value="{{ setting('posyandu_name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kode Posyandu</label>
                <input type="text" name="posyandu_code" value="{{ setting('posyandu_code') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Posyandu</label>
                <select name="posyandu_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                    <option value="pratama" {{ setting('posyandu_type') == 'pratama' ? 'selected' : '' }}>Pratama</option>
                    <option value="madya" {{ setting('posyandu_type') == 'madya' ? 'selected' : '' }}>Madya</option>
                    <option value="purnama" {{ setting('posyandu_type') == 'purnama' ? 'selected' : '' }}>Purnama</option>
                    <option value="mandiri" {{ setting('posyandu_type') == 'mandiri' ? 'selected' : '' }}>Mandiri</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor Registrasi</label>
                <input type="text" name="posyandu_reg" value="{{ setting('posyandu_reg') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Ketua</label>
                <input type="text" name="posyandu_head" value="{{ setting('posyandu_head') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status Aktif Posyandu</label>
                <div class="mt-2 text-sm text-gray-500">
                     <label class="inline-flex items-center">
                        <input type="checkbox" name="posyandu_active" value="1" {{ setting('posyandu_active', '1') == '1' ? 'checked' : '' }} class="rounded border-gray-300 text-teal-600 shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                        <span class="ml-2 text-gray-700 dark:text-gray-300">Sistem Posyandu Berjalan Aktif</span>
                     </label>
                </div>
            </div>
        </div>
        
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alamat Lengkap</label>
                <textarea name="posyandu_address" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">{{ setting('posyandu_address') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Desa / Kelurahan</label>
                <input type="text" name="posyandu_village" value="{{ setting('posyandu_village') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kecamatan</label>
                    <input type="text" name="posyandu_district" value="{{ setting('posyandu_district') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kabupaten/Kota</label>
                    <input type="text" name="posyandu_city" value="{{ setting('posyandu_city') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Provinsi</label>
                    <input type="text" name="posyandu_province" value="{{ setting('posyandu_province') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kode Pos</label>
                    <input type="text" name="posyandu_postal" value="{{ setting('posyandu_postal') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                </div>
            </div>
            
            <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mt-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Hari Pelayanan</label>
                        <input type="text" name="posyandu_service_days" value="{{ setting('posyandu_service_days', 'Setiap Bulan') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jam Operasional</label>
                        <input type="text" name="posyandu_hours" value="{{ setting('posyandu_hours', '08:00 - Selesai') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi Singkat Posyandu</label>
            <textarea name="posyandu_description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">{{ setting('posyandu_description') }}</textarea>
        </div>
    </div>
</div>
