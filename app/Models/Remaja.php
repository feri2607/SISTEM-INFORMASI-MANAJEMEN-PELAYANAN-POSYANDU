<?php
// app/Models/Remaja.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Remaja extends Model
{
    use HasFactory;

    protected $table = 'remaja';

    protected $fillable = [
        'warga_id',
        'nama',
        'nik',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'sekolah',
        'golongan_darah',
        'no_hp',
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

    public function pemeriksaan()
    {
        return $this->hasMany(PemeriksaanRemaja::class)->orderBy('tanggal', 'desc');
    }

    public function konseling()
    {
        return $this->hasMany(KonselingRemaja::class)->orderBy('tanggal', 'desc');
    }

    public function tabletTambahDarah()
    {
        return $this->hasOne(TabletTambahDarah::class);
    }

    public function getFotoUrlAttribute()
    {
        if ($this->foto && Storage::disk('public')->exists('remaja/' . $this->foto)) {
            return Storage::url('remaja/' . $this->foto);
        }
        $gender = $this->jenis_kelamin === 'L' ? 'boy' : 'girl';
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->nama) . '&color=7F9CF5&background=EBF4FF&size=200';
    }

    public function getUmurAttribute()
    {
        return $this->tanggal_lahir->age;
    }

    public function getJenisKelaminLabelAttribute()
    {
        return $this->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
    }

    public function getStatusVerifikasiLabelAttribute()
    {
        return $this->is_verified ? 'Terverifikasi' : 'Menunggu Verifikasi';
    }

    public function getBmiTerakhirAttribute()
    {
        $pemeriksaan = $this->pemeriksaan()->first();
        return $pemeriksaan ? $pemeriksaan->bmi : null;
    }

    public function getBeratBadanTerakhirAttribute()
    {
        $pemeriksaan = $this->pemeriksaan()->first();
        return $pemeriksaan ? $pemeriksaan->berat_badan : null;
    }

    public function getTinggiBadanTerakhirAttribute()
    {
        $pemeriksaan = $this->pemeriksaan()->first();
        return $pemeriksaan ? $pemeriksaan->tinggi_badan : null;
    }

    public function getStatusGiziAttribute()
    {
        $bmi = $this->bmi_terakhir;
        if (!$bmi) return 'Belum ada data';
        if ($bmi < 17) return 'Kurus';
        if ($bmi < 18.5) return 'Berisiko Kurus';
        if ($bmi < 25) return 'Normal';
        if ($bmi < 27) return 'Berisiko Gemuk';
        return 'Gemuk';
    }

    public function getStatusGiziColorAttribute()
    {
        $status = $this->status_gizi;
        if ($status === 'Normal') return 'green';
        if ($status === 'Kurus' || $status === 'Berisiko Kurus') return 'yellow';
        if ($status === 'Gemuk' || $status === 'Berisiko Gemuk') return 'orange';
        return 'gray';
    }
}