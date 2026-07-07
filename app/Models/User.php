<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'provider',
        'provider_id',
        'email_verified_at',
        'foto',
        'no_telepon',
        'alamat',
        'last_login_at',
        'last_login_ip',
        'last_login_browser',
        'preferences', // <-- Tambahkan ini agar bisa disimpan ke database
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'last_login_at' => 'datetime',
        'deleted_at' => 'datetime',
        'preferences' => 'array', // <-- Tambahkan ini agar otomatis di-cast ke array
    ];

    // Relationships
    public function warga()
    {
        return $this->hasOne(Warga::class);
    }

    public function kegiatan()
    {
        return $this->hasMany(KegiatanPosyandu::class);
    }

    public function pelayanan()
    {
        return $this->hasMany(HasilPelayanan::class);
    }

    // Accessors
    public function getFotoUrlAttribute()
    {
        if ($this->foto && Storage::disk('public')->exists('foto-user/' . $this->foto)) {
            return Storage::url('foto-user/' . $this->foto);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF&size=200';
    }

    public function getRoleLabelAttribute()
    {
        $labels = [
            'admin' => 'Admin',
            'pegawai' => 'pegawai',
            'user' => 'Warga',
        ];
        return $labels[$this->role] ?? ucfirst($this->role);
    }

    public function getProviderLabelAttribute()
    {
        if (!$this->provider) return 'Email';
        return ucfirst($this->provider);
    }

    public function getStatusVerifikasiAttribute()
    {
        return $this->email_verified_at ? 'Terverifikasi' : 'Belum Verifikasi';
    }

    public function getStatusVerifikasiColorAttribute()
    {
        return $this->email_verified_at ? 'green' : 'red';
    }

    public function getTanggalBergabungAttribute()
    {
        return $this->created_at->format('d M Y H:i');
    }

    public function getLastLoginFormattedAttribute()
    {
        return $this->last_login_at ? $this->last_login_at->format('d M Y H:i') : 'Belum pernah login';
    }

    // ============================================
    // PREFERENCES METHODS
    // ============================================

    public function isSocialLogin()
    {
        return !empty($this->provider) && !empty($this->provider_id);
    }

    /**
     * Ambil preferensi user. Jika belum ada, kembalikan default.
     */
    public function getPreferences()
    {
        return $this->preferences ?? [
            'theme' => 'system',
            'language' => 'id',
            'email_notification' => true,
            'jadwal_notification' => true,
            'pengumuman_notification' => true,
            'artikel_notification' => true,
        ];
    }

    /**
     * Update preferensi user. Hanya mengganti key yang dikirim.
     */
    public function updatePreferences($preferences)
    {
        $current = $this->getPreferences();
        $this->preferences = array_merge($current, $preferences);
        $this->save();
        return $this;
    }
}