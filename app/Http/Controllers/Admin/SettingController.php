<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SettingService;

class SettingController extends Controller
{
    protected $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function index()
    {
        $settings = $this->settingService->getAll();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        \Log::info('FILES:', $_FILES ?: []);
        \Log::info('REQUEST:', $request->except(['_token', '_method', 'active_tab']) ?: []);
        $settingsData = $request->except(['_token', '_method', 'active_tab']);
        $activeTab = $request->input('active_tab', 'profil');

        $fileFields = [
            'hero_image', 'hero_background', 'about_image', 'about_video',
            'app_logo_main', 'app_logo_white', 'app_favicon', 'seo_og_image'
        ];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $path = $request->file($field)->store('settings', 'public');
                $settingsData[$field] = $path;
            }
        }

        if ($request->has('missions')) {
            $missions = array_filter($request->input('missions', []), function($item) {
                return trim((string)$item) !== '';
            });
            $settingsData['missions'] = json_encode(array_values($missions));
        }

        $booleanFields = [
            'posyandu_active', 'hero_is_active', 'stat_show_balita', 'stat_show_ibuhamil', 
            'stat_show_remaja', 'stat_show_lansia', 'stat_show_wuspus', 'social_display_active', 
            'seo_robots_index', 'notif_email_active', 'notif_wa_active', 'notif_inapp_active', 
            'notif_reminder_jadwal', 'notif_reminder_imunisasi', 'notif_reminder_kehamilan', 
            'notif_reminder_stunting', 'security_2fa', 'security_google_login', 
            'security_email_verify', 'security_audit_log', 'gen_maintenance'
        ];

        foreach ($booleanFields as $field) {
            $settingsData[$field] = $request->has($field) ? '1' : '0';
        }

        $this->settingService->setMany($settingsData);
        
        return redirect()->back()->with('success', 'Pengaturan sistem berhasil diperbarui.')->with(['active_tab' => $activeTab]);
    }
}
