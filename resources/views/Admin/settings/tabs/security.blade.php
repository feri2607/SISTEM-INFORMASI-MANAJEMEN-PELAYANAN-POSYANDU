<div x-show="activeTab === 'security'" x-cloak x-transition.opacity.duration.300ms>
    <h2 class="text-xl font-bold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-3 mb-6">Keamanan Sistem</h2>
    
    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Minimum Karakter Password</label>
                <input type="number" name="security_password_min" value="{{ setting('security_password_min', '8') }}" min="6" max="32" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sesi Login Timeout (Menit)</label>
                <input type="number" name="security_session_timeout" value="{{ setting('security_session_timeout', '120') }}" min="15" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Batas Max Gagal Login (Attempt Limit)</label>
                <input type="number" name="security_login_attempt" value="{{ setting('security_login_attempt', '5') }}" min="1" max="10" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Durasi Blokir Gagal Login (Menit)</label>
                <input type="number" name="security_login_block" value="{{ setting('security_login_block', '60') }}" min="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
            </div>
        </div>

        <div class="border-t border-gray-100 dark:border-gray-700 pt-6">
            <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Fitur Tambahan Keamanan</h3>
            <div class="space-y-3">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="security_2fa" value="1" {{ setting('security_2fa', '0') == '1' ? 'checked' : '' }} class="rounded border-gray-300 text-teal-600 shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Wajibkan Two-Factor Authentication (2FA) untuk Semua Pegawai & Admin</span>
                </label>
                <br>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="security_google_login" value="1" {{ setting('security_google_login', '0') == '1' ? 'checked' : '' }} class="rounded border-gray-300 text-teal-600 shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Aktifkan Login dengan akun Google (SSO) Warga</span>
                </label>
                <br>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="security_email_verify" value="1" {{ setting('security_email_verify', '1') == '1' ? 'checked' : '' }} class="rounded border-gray-300 text-teal-600 shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Pendaftaran Akun Baru Wajib Verifikasi Email</span>
                </label>
                <br>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="security_audit_log" value="1" {{ setting('security_audit_log', '1') == '1' ? 'checked' : '' }} class="rounded border-gray-300 text-teal-600 shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Aktifkan Audit Log (Riwayat Aktivitas semua User)</span>
                </label>
            </div>
        </div>
    </div>
</div>
