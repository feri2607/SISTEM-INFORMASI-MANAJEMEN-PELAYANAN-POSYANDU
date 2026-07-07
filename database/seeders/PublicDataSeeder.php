<?php
// database/seeders/PublicDataSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Artikel;
use App\Models\Berita;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;
use App\Models\Pengumuman;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Announcement;
use App\Models\AnnouncementCategory;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class PublicDataSeeder extends Seeder
{
    public function run()
    {   
        $faker = Faker::create('id_ID');

        // Artikel
        $artikelData = [
            [
                'judul' => 'Pentingnya Imunisasi Dasar bagi Balita',
                'ringkasan' => 'Imunisasi dasar sangat penting untuk melindungi balita dari berbagai penyakit berbahaya.',
                'konten' => 'Konten lengkap tentang pentingnya imunisasi...',
                'penulis' => 'Dr. Siti Rahayu, Sp.A',
                'published_at' => now()->subDays(5),
            ],
            [
                'judul' => 'Panduan MPASI untuk Bayi 6-12 Bulan',
                'ringkasan' => 'Memberikan MPASI yang tepat sangat penting untuk pertumbuhan dan perkembangan bayi.',
                'konten' => 'Konten lengkap tentang MPASI...',
                'penulis' => 'Dra. Dian Kusumawati, M.Gizi',
                'published_at' => now()->subDays(10),
            ],
            [
                'judul' => 'Manfaat ASI Eksklusif bagi Bayi',
                'ringkasan' => 'ASI eksklusif memberikan nutrisi terbaik untuk pertumbuhan dan perkembangan bayi.',
                'konten' => 'Konten lengkap tentang ASI eksklusif...',
                'penulis' => 'Dr. Budi Santoso, Sp.A',
                'published_at' => now()->subDays(15),
            ],
        ];

        foreach ($artikelData as $data) {
            $slug = Str::slug($data['judul'] ?? time());
            if (Artikel::where('slug', $slug)->exists()) {
                continue;
            }
            $data['slug'] = $slug;
            Artikel::create($data);
        }

        // Ensure there is at least one user to assign as author (needed for Article/Announcement creation)
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Seeder',
                'email' => 'seeder@example.test',
                'password' => bcrypt('password'),
            ]);
        }

        // Also create Article (english) records from Artikel data so public ArticleController shows items
        $articleCategory = ArticleCategory::first();
        if (!$articleCategory) {
            $articleCategory = ArticleCategory::create(['name' => 'Umum', 'slug' => 'umum', 'is_active' => true]);
        }

        foreach ($artikelData as $data) {
            $slug = Str::slug($data['judul'] ?? time());
            if (Article::where('slug', $slug)->exists()) {
                continue;
            }

            Article::create([
                'title' => $data['judul'] ?? null,
                'slug' => $slug,
                'excerpt' => $data['ringkasan'] ?? null,
                'content' => $data['konten'] ?? null,
                'category_id' => $articleCategory->id,
                'user_id' => $user->id,
                'status' => 'published',
                'published_at' => $data['published_at'] ?? null,
            ]);
        }

        // Berita
        $beritaData = [
            [
                'judul' => 'Posyandu Mengadakan Sosialisasi Kesehatan Gratis',
                'ringkasan' => 'Posyandu mengadakan sosialisasi kesehatan gratis untuk masyarakat sekitar.',
                'konten' => 'Konten lengkap berita...',
                'published_at' => now()->subDays(3),
            ],
            [
                'judul' => 'Peningkatan Layanan Posyandu di Tahun 2026',
                'ringkasan' => 'Pemerintah meningkatkan layanan Posyandu dengan sistem digital terbaru.',
                'konten' => 'Konten lengkap berita...',
                'published_at' => now()->subDays(7),
            ],
            [
                'judul' => 'Program Vaksinasi di Posyandu Berjalan Lancar',
                'ringkasan' => 'Program vaksinasi di Posyandu berjalan dengan lancar dan antusias dari masyarakat.',
                'konten' => 'Konten lengkap berita...',
                'published_at' => now()->subDays(14),
            ],
        ];

        // Ensure there is at least one news category
        $newsCategory = NewsCategory::first();
        if (!$newsCategory) {
            $newsCategory = NewsCategory::create(['name' => 'Umum', 'slug' => 'umum', 'is_active' => true]);
        }

        // Ensure there is at least one user to assign as author
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Seeder',
                'email' => 'seeder@example.test',
                'password' => bcrypt('password'),
            ]);
        }

        foreach ($beritaData as $data) {
            $slug = Str::slug($data['judul'] ?? time());
            if (!Berita::where('slug', $slug)->exists()) {
                $data['slug'] = $slug;
                Berita::create($data);
            }

            // Also create corresponding News record so public /berita page shows entries
            if (News::where('slug', $slug)->exists()) {
                continue;
            }

            News::create([
                'title' => $data['judul'] ?? null,
                'slug' => $slug,
                'excerpt' => $data['ringkasan'] ?? null,
                'content' => $data['konten'] ?? null,
                'category_id' => $newsCategory->id,
                'user_id' => $user->id,
                'published_at' => $data['published_at'] ?? null,
                'status' => 'published',
            ]);
        }

        // Pengumuman
        $pengumumanData = [
            [
                'judul' => 'Jadwal Posyandu Bulan Ini',
                'ringkasan' => 'Berikut adalah jadwal Posyandu untuk bulan ini.',
                'published_at' => now()->subDays(1),
            ],
            [
                'judul' => 'Layanan Imunisasi Gratis untuk Balita',
                'ringkasan' => 'Posyandu menyediakan layanan imunisasi gratis untuk balita.',
                'published_at' => now()->subDays(2),
            ],
            [
                'judul' => 'Pemeriksaan Kesehatan Ibu Hamil',
                'ringkasan' => 'Posyandu membuka layanan pemeriksaan kesehatan ibu hamil setiap hari Selasa.',
                'published_at' => now()->subDays(3),
            ],
            [
                'judul' => 'Sosialisasi Gizi Seimbang',
                'ringkasan' => 'Posyandu mengadakan sosialisasi gizi seimbang untuk masyarakat.',
                'published_at' => now()->subDays(5),
            ],
            [
                'judul' => 'Pendaftaran Kader Posyandu Baru',
                'ringkasan' => 'Posyandu membuka pendaftaran untuk kader Posyandu baru.',
                'published_at' => now()->subDays(7),
            ],
        ];

        foreach ($pengumumanData as $data) {
            if (Pengumuman::where('judul', $data['judul'])->exists()) {
                continue;
            }
            Pengumuman::create($data);
        }

        // Also create Announcement (english) records from Pengumuman data so public AnnouncementController shows items
        $announcementCategory = AnnouncementCategory::first();
        if (!$announcementCategory) {
            $announcementCategory = AnnouncementCategory::create(['name' => 'Umum', 'slug' => 'umum', 'is_active' => true]);
        }

        foreach ($pengumumanData as $data) {
            $slug = Str::slug($data['judul'] ?? time());
            if (Announcement::where('slug', $slug)->exists()) {
                continue;
            }

            Announcement::create([
                'title' => $data['judul'] ?? null,
                'slug' => $slug,
                'excerpt' => $data['ringkasan'] ?? null,
                'content' => $data['ringkasan'] ?? null,
                'category_id' => $announcementCategory->id,
                'user_id' => $user->id,
                'status' => 'published',
                'publish_at' => $data['published_at'] ?? null,
            ]);
        }
    }
}