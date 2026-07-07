<?php
// app/Models/Wilayah.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    use HasFactory;

    protected $table = 'wilayah';

    protected $fillable = [
        'kode',
        'nama',
        'tingkat',
        'parent_id',
    ];

    public function parent()
    {
        return $this->belongsTo(Wilayah::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Wilayah::class, 'parent_id');
    }

    public function provinsi()
    {
        return $this->hasMany(Wilayah::class, 'parent_id')->where('tingkat', 'provinsi');
    }

    public function kabupaten()
    {
        return $this->hasMany(Wilayah::class, 'parent_id')->where('tingkat', 'kabupaten');
    }

    public function kecamatan()
    {
        return $this->hasMany(Wilayah::class, 'parent_id')->where('tingkat', 'kecamatan');
    }

    public function kelurahan()
    {
        return $this->hasMany(Wilayah::class, 'parent_id')->where('tingkat', 'kelurahan');
    }
}