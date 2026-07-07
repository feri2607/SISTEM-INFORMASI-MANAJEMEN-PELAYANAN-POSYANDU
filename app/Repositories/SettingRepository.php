<?php

namespace App\Repositories;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingRepository
{
    /**
     * Get all settings as a key-value array using Cache.
     * 
     * @return array
     */
    public function getAllCached(): array
    {
        return Cache::rememberForever('system_settings', function () {
            return Setting::pluck('value', 'key')->toArray();
        });
    }

    /**
     * Get a specific setting value.
     * 
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        $settings = $this->getAllCached();
        return $settings[$key] ?? $default;
    }

    /**
     * Set a setting value.
     * 
     * @param string $key
     * @param mixed $value
     * @param string $group
     * @param string $type
     * @return Setting
     */
    public function set(string $key, $value, string $group = 'general', string $type = 'string'): Setting
    {
        $setting = Setting::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'group' => $group,
                'type' => $type
            ]
        );

        $this->clearCache();

        return $setting;
    }

    /**
     * Clear settings cache.
     * 
     * @return void
     */
    public function clearCache(): void
    {
        Cache::forget('system_settings');
    }
}
