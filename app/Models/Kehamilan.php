<?php
// app/Models/Kehamilan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Kehamilan extends Model
{
    use HasFactory;

    protected $table = 'kehamilan';

    protected $fillable = [
        'warga_id',
        'nama',
        'nik',
        'tanggal_lahir',
        'no_hp',
        'alamat',
        'kehamilan_ke',
        'hpht',
        'hpl',
        'usia_kehamilan',
        'golongan_darah',
        'riwayat_penyakit',
        'riwayat_alergi',
        'risiko_tinggi',
        'foto',
        'status',
        'is_verified',
        'verified_by',
        'verified_at',
    ];

    protected $casts = [
        'hpht'         => 'date',
        'hpl'          => 'date',
        'tanggal_lahir' => 'date',
        'risiko_tinggi' => 'boolean',
        'is_verified'  => 'boolean',
        'verified_at'  => 'datetime',
    ];

    // ==========================================
    // Relationships
    // ==========================================

    public function warga()
    {
        return $this->belongsTo(Warga::class);
    }

    public function anc()
    {
        return $this->hasMany(Anc::class)->orderBy('tanggal', 'desc');
    }

    public function konsumsiTtd()
    {
        return $this->hasOne(KonsumsiTtd::class);
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // ==========================================
    // Computed Attributes
    // ==========================================

    public function getFotoUrlAttribute()
    {
        if ($this->foto && Storage::disk('public')->exists('kehamilan/' . $this->foto)) {
            return Storage::url('kehamilan/' . $this->foto);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->nama ?? 'Ibu Hamil')
             . '&color=EC4899&background=FDF2F8&size=200';
    }

    public function getUsiaKehamilanInMingguAttribute()
    {
        if (!$this->hpht) return null;
        return (int) $this->hpht->diffInWeeks(now());
    }

    public function getUsiaKehamilanInHariAttribute()
    {
        if (!$this->hpht) return null;
        return (int) $this->hpht->diffInDays(now());
    }

    public function getHplFormattedAttribute()
    {
        return $this->hpl ? $this->hpl->format('d M Y') : '-';
    }

    public function getHphtFormattedAttribute()
    {
        return $this->hpht ? $this->hpht->format('d M Y') : '-';
    }

    public function getUmurAttribute()
    {
        return $this->tanggal_lahir ? $this->tanggal_lahir->age : null;
    }

    public function getAncTerakhirAttribute()
    {
        return $this->anc()->first();
    }

    public function getStatusRisikoLabelAttribute()
    {
        return $this->risiko_tinggi ? 'Risiko Tinggi' : 'Normal';
    }

    public function getStatusRisikoBadgeAttribute()
    {
        return $this->risiko_tinggi
            ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400'
            : 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400';
    }

    public function getHariMenujuHplAttribute()
    {
        if (!$this->hpl) return null;
        return max(0, (int) now()->diffInDays($this->hpl, false));
    }

    public function getStatusVerifikasiLabelAttribute()
    {
        return $this->is_verified ? 'Terverifikasi' : 'Menunggu Verifikasi';
    }
}