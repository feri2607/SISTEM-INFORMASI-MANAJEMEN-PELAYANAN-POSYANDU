<?php
// app/Models/AboutPosyandu.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutPosyandu extends Model
{
    use HasFactory;

    protected $table = 'about_posyandu';

    protected $fillable = [
        'nama_posyandu',
        'deskripsi',
        'sejarah',
        'visi',
        'misi',
        'tujuan',
        'motto',
        'tahun_berdiri',
        'wilayah_pelayanan',
        'alamat',
        'telepon',
        'email',
        'jam_operasional',
        'google_maps_embed',
        'foto_hero',
        'foto_profil',
        'is_active',
    ];

    protected $casts = [
        'misi' => 'array',
        'tujuan' => 'array',
        'is_active' => 'boolean',
    ];

    public function getFotoHeroUrlAttribute()
    {
        if ($this->foto_hero) {
            return asset('storage/about/' . $this->foto_hero);
        }
        return asset('images/about-hero-default.jpg');
    }

    public function getFotoProfilUrlAttribute()
    {
        if ($this->foto_profil) {
            return asset('storage/about/' . $this->foto_profil);
        }
        return asset('images/about-profil-default.jpg');
    }

    public function getMisiListAttribute()
    {
        return $this->misi ?? [];
    }

    public function getTujuanListAttribute()
    {
        return $this->tujuan ?? [];
    }
}