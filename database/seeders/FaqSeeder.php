<?php
// database/seeders/FaqSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    public function run()
    {
        $faqs = [
            [
                'question' => 'Kapan jadwal Posyandu dilaksanakan?',
                'answer' => 'Jadwal Posyandu dilaksanakan setiap hari Selasa dan Kamis pada pukul 08:00 - 12:00 WIB. Untuk jadwal lengkap, silakan cek halaman Jadwal Posyandu.',
                'category' => 'jadwal',
                'sort_order' => 1,
                'is_featured' => true,
                'status' => 'published',
            ],
            [
                'question' => 'Bagaimana cara mendaftar sebagai warga Posyandu?',
                'answer' => 'Anda dapat mendaftar secara langsung di Posyandu dengan membawa KK dan KTP, atau melalui website dengan mengisi formulir pendaftaran di halaman Registrasi.',
                'category' => 'pendaftaran',
                'sort_order' => 2,
                'is_featured' => true,
                'status' => 'published',
            ],
            [
                'question' => 'Apa saja layanan yang tersedia di Posyandu?',
                'answer' => 'Layanan yang tersedia meliputi penimbangan balita, pengukuran tinggi badan, imunisasi, konsultasi gizi, pemeriksaan ibu hamil, penyuluhan kesehatan, dan pemberian vitamin.',
                'category' => 'pelayanan',
                'sort_order' => 3,
                'is_featured' => true,
                'status' => 'published',
            ],
            [
                'question' => 'Apakah layanan di Posyandu gratis?',
                'answer' => 'Ya, semua layanan dasar di Posyandu gratis untuk masyarakat. Beberapa layanan tambahan mungkin dikenakan biaya yang sangat terjangkau.',
                'category' => 'pelayanan',
                'sort_order' => 4,
                'is_featured' => false,
                'status' => 'published',
            ],
            [
                'question' => 'Bagaimana cara menghubungi kader Posyandu?',
                'answer' => 'Anda dapat menghubungi kader Posyandu melalui nomor telepon yang tertera di halaman Kontak, atau melalui WhatsApp yang tersedia.',
                'category' => 'umum',
                'sort_order' => 5,
                'is_featured' => false,
                'status' => 'published',
            ],
            [
                'question' => 'Apa saja yang perlu dibawa saat datang ke Posyandu?',
                'answer' => 'Bawa Kartu Menuju Sehat (KMS) anak, buku KIA, kartu identitas, dan catatan kesehatan lainnya jika ada.',
                'category' => 'balita',
                'sort_order' => 6,
                'is_featured' => false,
                'status' => 'published',
            ],
            [
                'question' => 'Bagaimana cara mengetahui status gizi balita?',
                'answer' => 'Status gizi balita dapat diketahui melalui penimbangan dan pengukuran yang dilakukan setiap bulan di Posyandu. Hasilnya akan dicatat di Kartu Menuju Sehat (KMS).',
                'category' => 'balita',
                'sort_order' => 7,
                'is_featured' => false,
                'status' => 'published',
            ],
            [
                'question' => 'Apa itu stunting dan bagaimana cara mencegahnya?',
                'answer' => 'Stunting adalah kondisi gagal tumbuh pada anak akibat kekurangan gizi kronis. Pencegahannya dapat dilakukan dengan memberikan gizi seimbang, ASI eksklusif, MPASI yang tepat, dan imunisasi lengkap.',
                'category' => 'balita',
                'sort_order' => 8,
                'is_featured' => false,
                'status' => 'published',
            ],
            [
                'question' => 'Bagaimana cara menjadi kader Posyandu?',
                'answer' => 'Untuk menjadi kader Posyandu, Anda dapat mendaftar melalui pengurus Posyandu setempat. Kader akan mendapatkan pelatihan dasar tentang kesehatan ibu dan anak.',
                'category' => 'kader',
                'sort_order' => 9,
                'is_featured' => false,
                'status' => 'published',
            ],
            [
                'question' => 'Apa yang harus dilakukan jika balita sakit?',
                'answer' => 'Jika balita sakit, segera bawa ke Posyandu atau fasilitas kesehatan terdekat. Jangan memberikan obat tanpa resep dokter. Tetap berikan ASI dan makanan bergizi.',
                'category' => 'balita',
                'sort_order' => 10,
                'is_featured' => false,
                'status' => 'published',
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}