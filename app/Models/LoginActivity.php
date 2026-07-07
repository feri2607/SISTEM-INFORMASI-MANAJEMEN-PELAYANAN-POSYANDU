<?php
// app/Models/LoginActivity.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
        'device',
        'platform',
        'browser',
        'login_at',
        'logout_at',
        'session_id',
    ];

    protected $casts = [
        'login_at' => 'datetime',
        'logout_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDurationAttribute()
    {
        if ($this->login_at && $this->logout_at) {
            return $this->login_at->diffInMinutes($this->logout_at) . ' menit';
        }
        return 'Masih aktif';
    }

    public function getDeviceInfoAttribute()
    {
        $parts = [];
        if ($this->device) $parts[] = $this->device;
        if ($this->platform) $parts[] = $this->platform;
        if ($this->browser) $parts[] = $this->browser;
        return implode(' • ', $parts);
    }
}