<?php
// database/seeders/NewsCategorySeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NewsCategory;

class NewsCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Kegiatan Posyandu', 'icon' => 'kegiatan', 'description' => 'Informasi tentang kegiatan Posyandu'],
            ['name' => 'Kesehatan', 'icon' => 'kesehatan', 'description' => 'Informasi kesehatan masyarakat'],
            ['name' => 'Pengumuman', 'icon' => 'pengumuman', 'description' => 'Pengumuman penting dari Posyandu'],
            ['name' => 'Program', 'icon' => 'program', 'description' => 'Program-program Posyandu'],
            ['name' => 'Prestasi', 'icon' => 'prestasi', 'description' => 'Prestasi dan pencapaian Posyandu'],
        ];

        foreach ($categories as $category) {
            NewsCategory::create($category);
        }
    }
}