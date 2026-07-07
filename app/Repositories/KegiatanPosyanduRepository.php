<?php

namespace App\Repositories;

use App\Models\KegiatanPosyandu;
use Illuminate\Database\Eloquent\Collection;

class KegiatanPosyanduRepository
{
    public function getAllPaginated($perPage = 10)
    {
        return KegiatanPosyandu::latest()->paginate($perPage);
    }

    public function findById($id): KegiatanPosyandu
    {
        return KegiatanPosyandu::findOrFail($id);
    }

    public function create(array $data): KegiatanPosyandu
    {
        return KegiatanPosyandu::create($data);
    }

    public function update($id, array $data): KegiatanPosyandu
    {
        $kegiatan = KegiatanPosyandu::findOrFail($id);
        $kegiatan->update($data);
        return $kegiatan;
    }

    public function delete($id): bool
    {
        $kegiatan = KegiatanPosyandu::findOrFail($id);
        return $kegiatan->delete();
    }
}
