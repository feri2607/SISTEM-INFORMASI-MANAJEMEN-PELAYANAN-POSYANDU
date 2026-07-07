<?php
// database/seeders/ArticleCategorySeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ArticleCategory;

class ArticleCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Gizi Balita', 'icon' => 'gizi', 'description' => 'Informasi tentang gizi dan nutrisi untuk balita'],
            ['name' => 'Imunisasi', 'icon' => 'imunisasi', 'description' => 'Informasi tentang imunisasi dan vaksinasi'],
            ['name' => 'Stunting', 'icon' => 'stunting', 'description' => 'Informasi tentang pencegahan dan penanganan stunting'],
            ['name' => 'MPASI', 'icon' => 'mpasi', 'description' => 'Informasi tentang Makanan Pendamping ASI'],
            ['name' => 'ASI Eksklusif', 'icon' => 'asi', 'description' => 'Informasi tentang ASI eksklusif'],
            ['name' => 'Kesehatan Ibu Hamil', 'icon' => 'ibu_hamil', 'description' => 'Informasi tentang kesehatan ibu hamil'],
            ['name' => 'Vitamin & Suplemen', 'icon' => 'vitamin', 'description' => 'Informasi tentang vitamin dan suplemen'],
            ['name' => 'Penyakit Anak', 'icon' => 'penyakit_anak', 'description' => 'Informasi tentang penyakit pada anak'],
        ];

        foreach ($categories as $category) {
            ArticleCategory::create($category);
        }
    }
}