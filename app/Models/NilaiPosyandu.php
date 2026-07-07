<?php
// app/Models/NilaiPosyandu.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiPosyandu extends Model
{
    use HasFactory;

    protected $table = 'nilai_posyandu';

    protected $fillable = [
        'nama',
        'ikon',
        'deskripsi',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getIkonHtmlAttribute()
    {
        $icons = [
            'pelayanan' => 'heart',
            'kepedulian' => 'hand',
            'transparansi' => 'eye',
            'profesionalisme' => 'briefcase',
            'kolaborasi' => 'users',
            'integritas' => 'shield-check',
            'inovasi' => 'light-bulb',
            'kualitas' => 'star',
        ];

        return $icons[$this->ikon] ?? 'check';
    }
}