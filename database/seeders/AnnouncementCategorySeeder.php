<?php
// database/seeders/AnnouncementCategorySeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AnnouncementCategory;

class AnnouncementCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Pelayanan', 'description' => 'Informasi tentang pelayanan Posyandu'],
            ['name' => 'Jadwal', 'description' => 'Perubahan jadwal kegiatan Posyandu'],
            ['name' => 'Kegiatan', 'description' => 'Informasi kegiatan Posyandu'],
            ['name' => 'Pengumuman Umum', 'description' => 'Pengumuman untuk masyarakat umum'],
            ['name' => 'Program', 'description' => 'Program-program Posyandu'],
        ];

        foreach ($categories as $category) {
            AnnouncementCategory::create($category);
        }
    }
}