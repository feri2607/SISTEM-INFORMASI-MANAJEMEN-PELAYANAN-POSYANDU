<?php
// app/Models/Anak.php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anak extends Model
{
    use HasFactory;

    protected $table = 'anak';

    protected $fillable = [
        'warga_id',
        'nama',
        'nik',
        'tanggal_lahir',
        'jenis_kelamin',
        'status_anak',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    // =============================================
    // Relationships
    // =============================================

    public function warga()
    {
        return $this->belongsTo(Warga::class);
    }

    // =============================================
    // Scopes
    // =============================================

    /**
     * Scope: anak yang termasuk kategori Balita (umur <= 59 bulan / < 5 tahun)
     */
    public function scopeBalita($query)
    {
        return $query->where('tanggal_lahir', '>=', now()->subMonths(59)->startOfDay())
                     ->where('status_anak', 'aktif');
    }

    /**
     * Scope: hanya anak aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status_anak', 'aktif');
    }

    // =============================================
    // Accessors
    // =============================================

    public function getUmurBulanAttribute(): int
    {
        return (int) $this->tanggal_lahir->diffInMonths(now());
    }

    public function getUmurTahunAttribute(): int
    {
        return (int) $this->tanggal_lahir->diffInYears(now());
    }

    /**
     * Apakah anak ini masuk kategori Balita (< 5 tahun = < 60 bulan)
     */
    public function getIsBalitaAttribute(): bool
    {
        return $this->umur_bulan < 60;
    }

    /**
     * Label umur yang mudah dibaca
     * Contoh: "2 tahun 3 bulan" atau "8 bulan 12 hari"
     */
    public function getUmurLabelAttribute(): string
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

    public function getJenisKelaminLabelAttribute(): string
    {
        return $this->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
    }

    public function getIsAktifAttribute(): bool
    {
        return $this->status_anak === 'aktif';
    }
}
