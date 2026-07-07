<?php
// app/Models/Galeri.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'foto',
        'deskripsi',
        'kategori',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/galeri/' . $this->foto);
        }
        return asset('images/placeholder.jpg');
    }
}