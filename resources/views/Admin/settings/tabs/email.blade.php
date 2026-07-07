<div x-show="activeTab === 'email'" x-cloak x-transition.opacity.duration.300ms>
    <h2 class="text-xl font-bold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-3 mb-6">Konfigurasi Email (SMTP)</h2>
    
    <div class="px-4 py-3 bg-yellow-50 dark:bg-yellow-900/30 border-l-4 border-yellow-400 text-yellow-800 dark:text-yellow-200 mb-6 flex">
        <svg class="h-5 w-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        <div class="text-sm">
            <p class="font-bold">Perhatian</p>
            <p>Pengaturan ini disimpan di database. Sistem akan secara otomatis mem-*bypass* konfigurasi <code>.env</code> jika data di sini diisi lengkap guna mengirimkan email notifikasi ke Warga.</p>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Mail Driver</label>
            <select name="mail_driver" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                <option value="smtp" {{ setting('mail_driver') == 'smtp' ? 'selected' : '' }}>SMTP (Umum)</option>
                <option value="log" {{ setting('mail_driver') == 'log' ? 'selected' : '' }}>Log (Dev/Test)</option>
            </select>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">SMTP Host</label>
            <input type="text" name="mail_host" value="{{ setting('mail_host', 'smtp.gmail.com') }}" placeholder="smtp.gmail.com" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">SMTP Port</label>
            <input type="text" name="mail_port" value="{{ setting('mail_port', '465') }}" placeholder="465 / 587" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Enkripsi (Encryption)</label>
            <select name="mail_encryption" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                <option value="ssl" {{ setting('mail_encryption') == 'ssl' ? 'selected' : '' }}>SSL</option>
                <option value="tls" {{ setting('mail_encryption') == 'tls' ? 'selected' : '' }}>TLS</option>
                <option value="" {{ setting('mail_encryption') == '' ? 'selected' : '' }}>None</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Username Email (SMTP User)</label>
            <input type="email" name="mail_username" value="{{ setting('mail_username') }}" placeholder="posyandu@gmail.com" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password Email (App Password)</label>
            <input type="password" name="mail_password" value="{{ setting('mail_password') }}" placeholder="••••••••••••" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Mail Dari (Email Pengirim)</label>
            <input type="email" name="mail_from_address" value="{{ setting('mail_from_address') }}" placeholder="noreply@posyandu.id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Pengirim (Mail From Name)</label>
            <input type="text" name="mail_from_name" value="{{ setting('mail_from_name', 'Sistem Posyandu') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
        </div>
    </div>
</div>
