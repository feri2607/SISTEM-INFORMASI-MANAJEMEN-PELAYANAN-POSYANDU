<?php
// app/Models/Warga.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Warga extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'warga';

    protected $fillable = [
        'user_id',
        'nik',
        'nomor_kk',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'golongan_darah',
        'agama',
        'status_pernikahan',
        'pendidikan',
        'pekerjaan',
        'telepon',
        'email',
        'alamat',
        'rt',
        'rw',
        'dusun',
        'desa',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'kode_pos',
        'bpjs_number',
        'kis_number',
        'jkn_number',
        'status_kependudukan',
        'status_keaktifan',
        'ktp_path',
        'kk_path',
        'verification_status',
        'verified_by',
        'verified_at',
        'rejected_reason',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'verified_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function balita()
    {
        return $this->hasMany(Balita::class);
    }

    // Accessors
    public function getFotoKtpUrlAttribute()
    {
        if ($this->ktp_path && Storage::disk('public')->exists($this->ktp_path)) {
            return Storage::url($this->ktp_path);
        }

        return null;
    }

    public function getFotoKkUrlAttribute()
    {
        if ($this->kk_path && Storage::disk('public')->exists($this->kk_path)) {
            return Storage::url($this->kk_path);
        }

        return null;
    }

    public function getVerificationStatusLabelAttribute()
    {
        $statuses = [
            'belum_lengkap' => 'Belum Lengkap',
            'pending' => 'Menunggu Verifikasi',
            'verified' => 'Terverifikasi',
            'rejected' => 'Ditolak',
        ];

        return $statuses[$this->verification_status] ?? $this->verification_status;
    }

    public function getVerificationStatusColorAttribute()
    {
        $colors = [
            'belum_lengkap' => 'gray',
            'pending' => 'yellow',
            'verified' => 'green',
            'rejected' => 'red',
        ];

        return $colors[$this->verification_status] ?? 'gray';
    }

    public function getVerificationStatusBadgeAttribute()
    {
        $badges = [
            'belum_lengkap' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
            'verified' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
            'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
        ];

        return $badges[$this->verification_status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
    }

    public function getJenisKelaminLabelAttribute()
    {
        return $this->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
    }

    public function getUmurAttribute()
    {
        return $this->tanggal_lahir->age;
    }

    public function getAlamatLengkapAttribute()
    {
        $parts = [];
        if ($this->alamat) $parts[] = $this->alamat;
        if ($this->rt) $parts[] = "RT. {$this->rt}";
        if ($this->rw) $parts[] = "RW. {$this->rw}";
        if ($this->dusun) $parts[] = $this->dusun;
        if ($this->desa) $parts[] = $this->desa;
        if ($this->kecamatan) $parts[] = $this->kecamatan;
        if ($this->kabupaten) $parts[] = $this->kabupaten;
        if ($this->provinsi) $parts[] = $this->provinsi;
        if ($this->kode_pos) $parts[] = "{$this->kode_pos}";

        return implode(', ', $parts);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('verification_status', 'pending');
    }

    public function scopeVerified($query)
    {
        return $query->where('verification_status', 'verified');
    }

    public function scopeRejected($query)
    {
        return $query->where('verification_status', 'rejected');
    }

    // Methods
    public function isVerified()
    {
        return $this->verification_status === 'verified';
    }

    public function isPending()
    {
        return $this->verification_status === 'pending';
    }

    public function isRejected()
    {
        return $this->verification_status === 'rejected';
    }

    public function isComplete()
    {
        return $this->verification_status !== 'belum_lengkap';
    }
}