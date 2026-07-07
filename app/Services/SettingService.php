<?php

namespace App\Services;

use App\Repositories\SettingRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class SettingService
{
    protected $settingRepository;

    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    /**
     * Get all settings.
     *
     * @return array
     */
    public function getAll(): array
    {
        return $this->settingRepository->getAllCached();
    }

    /**
     * Get a specific setting.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return $this->settingRepository->get($key, $default);
    }

    /**
     * Update or create a setting.
     * Handles file uploads automatically if $value is an UploadedFile.
     *
     * @param string $key
     * @param mixed $value
     * @param string $group
     * @param string $type
     * @return void
     */
    public function set(string $key, $value, string $group = 'general', string $type = 'string')
    {
        if ($value instanceof UploadedFile) {
            $path = $value->store('settings', 'public');
            
            // Delete old file if exists
            $oldValue = $this->get($key);
            if ($oldValue && Storage::disk('public')->exists($oldValue)) {
                Storage::disk('public')->delete($oldValue);
            }
            
            $value = $path;
            $type = 'image';
        } elseif (is_array($value)) {
            $value = json_encode($value);
            $type = 'json';
        } elseif (is_bool($value)) {
            $value = $value ? '1' : '0';
            $type = 'boolean';
        }

        $this->settingRepository->set($key, $value, $group, $type);
    }
    
    /**
     * Bulk update settings.
     * 
     * @param array $settingsData
     * @param string $group
     * @return void
     */
    public function setMany(array $settingsData, string $group = 'general')
    {
        foreach ($settingsData as $key => $value) {
            if ($value !== null) { // We skip null values to prevent overwriting with empties unless intentionally done
                $this->set($key, $value, $group);
            }
        }
    }
}
