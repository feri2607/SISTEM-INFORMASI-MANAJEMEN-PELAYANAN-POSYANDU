<?php
// app/Models/Balita.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balita extends Model
{
    use HasFactory;

    protected $table = 'balita';

    protected $fillable = [
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'warga_id',
        'berat_lahir',
        'panjang_lahir',
        'anak_ke',
        'keterangan',
        'is_verified',
        'nik',
        'nomor_kk',
        'nama_ayah',
        'nama_ibu',
        'alamat',
        'golongan_darah',
        'no_hp_orang_tua',
        'foto_path'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'berat_lahir' => 'decimal:2',
        'panjang_lahir' => 'decimal:2',
    ];

    // Relationships
    public function warga()
    {
        return $this->belongsTo(Warga::class)->withDefault([
            'nama' => 'Tidak tersedia',
            'nik' => '-',
        ]);
    }

    public function pelayanan()
    {
        return $this->hasMany(HasilPelayanan::class)->orderBy('created_at', 'desc');
    }

    public function pelayananTerakhir()
    {
        return $this->hasOne(HasilPelayanan::class)->latest();
    }

    public function pemeriksaan()
    {
        return $this->hasMany(PemeriksaanBalita::class)->orderBy('tanggal_pemeriksaan', 'desc');
    }

    public function pemeriksaanTerakhir()
    {
        return $this->hasOne(PemeriksaanBalita::class)->latestOfMany();
    }

    public function imunisasi()
    {
        return $this->hasMany(ImunisasiBalita::class)->orderBy('tanggal', 'desc');
    }

    public function vitamin()
    {
        return $this->hasMany(VitaminBalita::class)->orderBy('tanggal', 'desc');
    }

    public function perkembangan()
    {
        return $this->hasMany(PerkembanganBalita::class)->orderBy('tanggal', 'desc');
    }

    public function getFotoUrlAttribute()
    {
        if ($this->foto_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($this->foto_path)) {
            return \Illuminate\Support\Facades\Storage::url($this->foto_path);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->nama) . '&color=7F9CF5&background=EBF4FF&size=200';
    }

    // Accessors
    public function getJenisKelaminLabelAttribute()
    {
        return $this->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
    }

    public function getUmurBulanAttribute()
    {
        return $this->tanggal_lahir->diffInMonths(now());
    }

    public function getUmurTahunAttribute()
    {
        return $this->tanggal_lahir->diffInYears(now());
    }

    public function getUmurAttribute()
    {
        $diff = $this->tanggal_lahir->diff(now());

        if ($diff->y > 0) {
            return $diff->y . ' tahun ' . $diff->m . ' bulan';
        } elseif ($diff->m > 0) {
            return $diff->m . ' bulan ' . $diff->d . ' hari';
        } else {
            return $diff->d . ' hari';
        }
    }

    public function getStatusGiziTerakhirAttribute()
    {
        $pemeriksaan = $this->pemeriksaanTerakhir;
        return $pemeriksaan ? $pemeriksaan->status_gizi : null;
    }

    public function getStatusGiziLabelAttribute()
    {
        $status = $this->status_gizi_terakhir;
        $labels = [
            'normal' => 'Normal',
            'kurang' => 'Kurang',
            'buruk' => 'Buruk',
            'lebih' => 'Lebih',
        ];
        return $labels[$status] ?? '-';
    }

    public function getStatusGiziColorAttribute()
    {
        $status = $this->status_gizi_terakhir;
        $colors = [
            'normal' => 'green',
            'kurang' => 'yellow',
            'buruk' => 'red',
            'lebih' => 'orange',
        ];
        return $colors[$status] ?? 'gray';
    }

    public function getPemeriksaanTerakhirDateAttribute()
    {
        $pemeriksaan = $this->pemeriksaanTerakhir;
        return $pemeriksaan ? $pemeriksaan->tanggal_pemeriksaan->format('d M Y') : '-';
    }
}