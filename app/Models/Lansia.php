<?php
// app/Models/Lansia.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Lansia extends Model
{
    use HasFactory;

    protected $table = 'lansia';

    protected $fillable = [
        'warga_id',
        'nama',
        'nik',
        'tanggal_lahir',
        'umur',
        'jenis_kelamin',
        'alamat',
        'golongan_darah',
        'riwayat_penyakit',
        'no_hp',
        'foto',
        'is_verified',
        'verified_by',
        'verified_at',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'is_verified'   => 'boolean',
        'verified_at'   => 'datetime',
    ];

    // =============================================
    // Relationships
    // =============================================

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
        return $this->hasMany(PemeriksaanLansia::class)->orderBy('tanggal', 'desc');
    }

    public function jadwalSenam()
    {
        return $this->hasMany(KehadiranSenamLansia::class);
    }

    // =============================================
    // Accessors
    // =============================================

    public function getFotoUrlAttribute(): string
    {
        if ($this->foto && Storage::disk('public')->exists('lansia/' . $this->foto)) {
            return Storage::url('lansia/' . $this->foto);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->nama) . '&color=7F9CF5&background=EBF4FF&size=200';
    }

    public function getUmurAttribute(): ?int
    {
        if (!$this->tanggal_lahir) return null;
        return $this->tanggal_lahir->age;
    }

    public function getJenisKelaminLabelAttribute(): string
    {
        return $this->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
    }

    public function getStatusVerifikasiLabelAttribute(): string
    {
        return $this->is_verified ? 'Terverifikasi' : 'Menunggu Verifikasi';
    }

    // =============================================
    // Last measurement accessors
    // =============================================

    public function getTekananDarahTerakhirAttribute(): ?string
    {
        return $this->pemeriksaan()->first()?->tekanan_darah;
    }

    public function getGulaDarahTerakhirAttribute(): ?string
    {
        return $this->pemeriksaan()->first()?->gula_darah;
    }

    public function getKolesterolTerakhirAttribute(): ?string
    {
        return $this->pemeriksaan()->first()?->kolesterol;
    }

    public function getBeratBadanTerakhirAttribute(): ?string
    {
        return $this->pemeriksaan()->first()?->berat_badan;
    }

    public function getTinggiBadanTerakhirAttribute(): ?string
    {
        return $this->pemeriksaan()->first()?->tinggi_badan;
    }

    public function getImtTerakhirAttribute(): ?string
    {
        return $this->pemeriksaan()->first()?->imt;
    }

    public function getPemeriksaanTerakhirTanggalAttribute(): ?string
    {
        $p = $this->pemeriksaan()->first();
        return $p?->tanggal?->format('d M Y');
    }

    public function getStatusImtAttribute(): string
    {
        $imt = $this->imt_terakhir;
        if (!$imt) return 'Belum ada data';
        if ($imt < 18.5) return 'Kurus';
        if ($imt < 25.0) return 'Normal';
        if ($imt < 30.0) return 'Gemuk';
        return 'Obesitas';
    }

    public function getStatusImtColorAttribute(): string
    {
        $status = $this->status_imt;
        return match ($status) {
            'Normal'       => 'green',
            'Kurus'        => 'yellow',
            'Gemuk'        => 'orange',
            'Obesitas'     => 'red',
            default        => 'gray',
        };
    }
}
