<div x-show="activeTab === 'notification'" x-cloak x-transition.opacity.duration.300ms>
    <h2 class="text-xl font-bold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-3 mb-6">Arus Sistem Notifikasi</h2>
    
    <div class="space-y-6">
        <div>
            <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Pengaturan Global Notifikasi</h3>
            <div class="space-y-3">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="notif_email_active" value="1" {{ setting('notif_email_active', '1') == '1' ? 'checked' : '' }} class="rounded border-gray-300 text-teal-600 shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Aktifkan Pengiriman Email Massal / Reminder</span>
                </label>
                <br>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="notif_wa_active" value="1" {{ setting('notif_wa_active', '0') == '1' ? 'checked' : '' }} class="rounded border-gray-300 text-teal-600 shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Aktifkan Notifikasi via WhatsApp (Membutuhkan integrasi API pihak ke-3 otomatis / Gateway)</span>
                </label>
                <br>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="notif_inapp_active" value="1" {{ setting('notif_inapp_active', '1') == '1' ? 'checked' : '' }} class="rounded border-gray-300 text-teal-600 shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Aktifkan Notifikasi In-App Database Warga</span>
                </label>
            </div>
        </div>

        <div class="border-t border-gray-100 dark:border-gray-700 pt-6">
            <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Otomatisasi Reminder / Jadwal</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="notif_reminder_jadwal" value="1" {{ setting('notif_reminder_jadwal', '1') == '1' ? 'checked' : '' }} class="rounded border-gray-300 text-teal-600 shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Reminder H-1 Jadwal Posyandu Warga</span>
                </label>
                
                <label class="inline-flex items-center">
                    <input type="checkbox" name="notif_reminder_imunisasi" value="1" {{ setting('notif_reminder_imunisasi', '1') == '1' ? 'checked' : '' }} class="rounded border-gray-300 text-teal-600 shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Reminder Keterlambatan Imunisasi Balita</span>
                </label>

                <label class="inline-flex items-center">
                    <input type="checkbox" name="notif_reminder_kehamilan" value="1" {{ setting('notif_reminder_kehamilan', '1') == '1' ? 'checked' : '' }} class="rounded border-gray-300 text-teal-600 shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Reminder Pemeriksaan ANC Kehamilan</span>
                </label>

                <label class="inline-flex items-center">
                    <input type="checkbox" name="notif_reminder_stunting" value="1" {{ setting('notif_reminder_stunting', '1') == '1' ? 'checked' : '' }} class="rounded border-gray-300 text-teal-600 shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Kirim Peringatan Gizi Kurang/Stunting Berkala</span>
                </label>
            </div>
            <p class="mt-3 text-xs text-gray-500">Note: Reminder di atas ditenagai oleh <code>php artisan schedule:run</code> atau task scheduler dari server.</p>
        </div>
    </div>
</div>
