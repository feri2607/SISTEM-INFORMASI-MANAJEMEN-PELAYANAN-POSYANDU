<?php
// database/seeders/ArticleSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\User;
use App\Models\ArticleCategory;
use Faker\Factory as Faker;

class ArticleSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        $user = User::where('role', 'admin')->first() ?? User::first();
        $categories = ArticleCategory::all();

        $articles = [
            [
                'title' => 'Pentingnya Imunisasi Dasar untuk Balita',
                'excerpt' => 'Imunisasi dasar sangat penting untuk melindungi balita dari berbagai penyakit berbahaya.',
                'content' => 'Konten lengkap tentang pentingnya imunisasi dasar...',
                'category' => 'Imunisasi',
                'tags' => ['Imunisasi', 'Balita', 'Kesehatan'],
            ],
            [
                'title' => 'Panduan MPASI untuk Bayi 6-12 Bulan',
                'excerpt' => 'Memberikan MPASI yang tepat sangat penting untuk pertumbuhan dan perkembangan bayi.',
                'content' => 'Konten lengkap tentang MPASI...',
                'category' => 'MPASI',
                'tags' => ['MPASI', 'Nutrisi', 'Perkembangan Anak'],
            ],
            [
                'title' => 'Manfaat ASI Eksklusif bagi Bayi',
                'excerpt' => 'ASI eksklusif memberikan nutrisi terbaik untuk pertumbuhan dan perkembangan bayi.',
                'content' => 'Konten lengkap tentang ASI eksklusif...',
                'category' => 'ASI Eksklusif',
                'tags' => ['ASI', 'Balita', 'Nutrisi'],
            ],
            [
                'title' => 'Cegah Stunting dengan Gizi Seimbang',
                'excerpt' => 'Stunting dapat dicegah dengan memberikan gizi seimbang sejak 1000 hari pertama kehidupan.',
                'content' => 'Konten lengkap tentang pencegahan stunting...',
                'category' => 'Stunting',
                'tags' => ['Stunting', 'Gizi', 'Balita'],
            ],
            [
                'title' => 'Tips Kesehatan Ibu Hamil',
                'excerpt' => 'Menjaga kesehatan selama kehamilan sangat penting untuk ibu dan janin.',
                'content' => 'Konten lengkap tentang kesehatan ibu hamil...',
                'category' => 'Kesehatan Ibu Hamil',
                'tags' => ['Ibu Hamil', 'Kesehatan', 'Nutrisi'],
            ],
            [
                'title' => 'Pentingnya Vitamin untuk Anak',
                'excerpt' => 'Vitamin sangat penting untuk mendukung pertumbuhan dan perkembangan anak.',
                'content' => 'Konten lengkap tentang vitamin untuk anak...',
                'category' => 'Vitamin & Suplemen',
                'tags' => ['Vitamin', 'Anak', 'Kesehatan'],
            ],
        ];

        foreach ($articles as $articleData) {
            $category = $categories->where('name', $articleData['category'])->first();
            
            $article = Article::create([
                'title' => $articleData['title'],
                'slug' => \Illuminate\Support\Str::slug($articleData['title']),
                'excerpt' => $articleData['excerpt'],
                'content' => $articleData['content'],
                'category_id' => $category->id,
                'user_id' => $user->id,
                'status' => 'published',
                'is_featured' => $faker->boolean(30),
                'views' => $faker->numberBetween(10, 1000),
                'published_at' => $faker->dateTimeBetween('-3 months', 'now'),
            ]);

            // Attach tags
            $tagIds = Tag::whereIn('name', $articleData['tags'])->pluck('id')->toArray();
            $article->tags()->sync($tagIds);
        }
    }
}