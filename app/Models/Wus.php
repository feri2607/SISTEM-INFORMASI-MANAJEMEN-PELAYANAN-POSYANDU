<?php
// app/Models/Wus.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Wus extends Model
{
    use HasFactory;

    protected $table = 'wus';

    protected $fillable = [
        'warga_id',
        'nama',
        'nik',
        'tanggal_lahir',
        'status_pernikahan',
        'alamat',
        'no_hp',
        'golongan_darah',
        'riwayat_penyakit',
        'status_anemia',
        'foto',
        'is_verified',
        'verified_by',
        'verified_at',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
    ];

    public function warga()
    {
        return $this->belongsTo(Warga::class);
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function pus()
    {
        return $this->hasOne(Pus::class, 'warga_id', 'warga_id');
    }

    public function pelayanan()
    {
        return $this->hasMany(PelayananReproduksi::class)->orderBy('tanggal', 'desc');
    }

    public function konseling()
    {
        return $this->hasMany(KonselingReproduksi::class)->orderBy('tanggal', 'desc');
    }

    public function jadwalKontrol()
    {
        return $this->hasMany(JadwalKontrol::class)->orderBy('tanggal', 'desc');
    }

    public function getFotoUrlAttribute()
    {
        if ($this->foto && Storage::disk('public')->exists('wus/' . $this->foto)) {
            return Storage::url('wus/' . $this->foto);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->nama) . '&color=7F9CF5&background=EBF4FF&size=200';
    }

    public function getUmurAttribute()
    {
        return $this->tanggal_lahir->age;
    }

    public function getStatusVerifikasiLabelAttribute()
    {
        return $this->is_verified ? 'Terverifikasi' : 'Menunggu Verifikasi';
    }

    public function getStatusVerifikasiColorAttribute()
    {
        return $this->is_verified ? 'green' : 'yellow';
    }
}