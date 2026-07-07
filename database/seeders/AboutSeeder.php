<?php
// database/seeders/AboutSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AboutPosyandu;
use App\Models\StrukturOrganisasi;
use App\Models\Galeri;
use App\Models\NilaiPosyandu;

class AboutSeeder extends Seeder
{
    public function run()
    {
        // About Posyandu
        AboutPosyandu::create([
            'nama_posyandu' => 'Posyandu Sehat Bersama',
            'deskripsi' => 'Posyandu Sehat Bersama adalah pusat pelayanan kesehatan masyarakat yang berfokus pada kesehatan ibu dan anak. Didirikan dengan tujuan meningkatkan kualitas kesehatan masyarakat melalui pelayanan yang berkualitas dan terjangkau.',
            'sejarah' => 'Posyandu Sehat Bersama didirikan pada tahun 2020 sebagai bentuk kepedulian terhadap kesehatan masyarakat. Berawal dari kegiatan sederhana, kini Posyandu telah berkembang menjadi pusat pelayanan kesehatan yang terintegrasi dengan sistem digital.',
            'visi' => 'Terwujudnya masyarakat yang sehat, mandiri, dan sejahtera melalui pelayanan kesehatan yang berkualitas dan berkelanjutan.',
            'misi' => [
                'Meningkatkan kesehatan ibu dan anak melalui pelayanan yang berkualitas.',
                'Menurunkan angka stunting melalui intervensi gizi yang tepat.',
                'Meningkatkan cakupan imunisasi bagi balita.',
                'Memberikan edukasi kesehatan kepada masyarakat secara berkelanjutan.',
                'Membangun kemitraan dengan berbagai pihak untuk mendukung kesehatan masyarakat.',
            ],
            'tujuan' => [
                'Meningkatkan kesehatan ibu dan anak.',
                'Menurunkan angka stunting.',
                'Meningkatkan cakupan imunisasi.',
                'Memberikan edukasi kesehatan kepada masyarakat.',
                'Meningkatkan akses pelayanan kesehatan.',
                'Membangun kesadaran masyarakat akan pentingnya kesehatan.',
            ],
            'motto' => 'Bersama Menuju Masyarakat Sehat',
            'tahun_berdiri' => '2020',
            'wilayah_pelayanan' => 'Kota Posyandu dan Sekitarnya',
            'alamat' => 'Jl. Kesehatan No. 123, Kota Posyandu',
            'telepon' => '(021) 1234-5678',
            'email' => 'info@posyandu.go.id',
            'jam_operasional' => 'Senin - Jumat: 08:00 - 16:00 WIB',
            'google_maps_embed' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.567890123456!2d106.827123456789!3d-6.175123456789!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f5d2e1234567%3A0x123456789abcdef!2sJakarta!5e0!3m2!1sid!2sid!4v1234567890123" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
            'is_active' => true,
        ]);

        // Struktur Organisasi
        $struktur = [
            ['nama' => 'Dr. Siti Rahayu, Sp.A', 'jabatan' => 'Ketua Posyandu', 'urutan' => 1],
            ['nama' => 'Dewi Lestari, S.KM', 'jabatan' => 'Sekretaris', 'urutan' => 2],
            ['nama' => 'Rina Fitriani, S.E', 'jabatan' => 'Bendahara', 'urutan' => 3],
            ['nama' => 'Tim Kader Posyandu', 'jabatan' => 'Kader Posyandu', 'urutan' => 4],
        ];

        foreach ($struktur as $data) {
            StrukturOrganisasi::create($data);
        }

        // Nilai-nilai
        $nilai = [
            ['nama' => 'Pelayanan', 'ikon' => 'heart', 'deskripsi' => 'Memberikan pelayanan terbaik untuk masyarakat', 'urutan' => 1],
            ['nama' => 'Kepedulian', 'ikon' => 'hand', 'deskripsi' => 'Peduli terhadap kesehatan ibu dan anak', 'urutan' => 2],
            ['nama' => 'Transparansi', 'ikon' => 'eye', 'deskripsi' => 'Terbuka dan jujur dalam setiap layanan', 'urutan' => 3],
            ['nama' => 'Profesionalisme', 'ikon' => 'briefcase', 'deskripsi' => 'Profesional dalam memberikan pelayanan', 'urutan' => 4],
            ['nama' => 'Kolaborasi', 'ikon' => 'users', 'deskripsi' => 'Bekerja sama untuk kesehatan masyarakat', 'urutan' => 5],
        ];

        foreach ($nilai as $data) {
            NilaiPosyandu::create($data);
        }
    }
}