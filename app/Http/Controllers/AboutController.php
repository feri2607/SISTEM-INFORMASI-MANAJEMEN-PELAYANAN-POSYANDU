<?php
// app/Http/Controllers/AboutController.php

namespace App\Http\Controllers;

use App\Models\AboutPosyandu;
use App\Models\StrukturOrganisasi;
use App\Models\Galeri;
use App\Models\NilaiPosyandu;
use App\Models\User;
use App\Models\Warga;
use App\Models\Balita;
use App\Models\KegiatanPosyandu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AboutController extends Controller
{
    public function index()
    {
        $about = new \stdClass();
        $about->nama_posyandu = setting('posyandu_name', 'Posyandu');
        $about->tahun_berdiri = '2020';
        $about->deskripsi = setting('about_content', 'Posyandu adalah pusat kegiatan masyarakat yang memberikan pelayanan kesehatan dasar, terutama untuk ibu hamil, ibu menyusui, bayi, dan balita.');
        $about->sejarah = setting('about_content', '');
        $about->motto = setting('app_slogan', 'Sistem Informasi Manajemen Pelayanan');
        $about->wilayah_pelayanan = setting('posyandu_village', '') . ', ' . setting('posyandu_city', '');
        $about->foto_hero_url = setting('about_image') ? \Storage::url(setting('about_image')) : asset('images/about-posyandu.jpg');
        $about->foto_profil_url = setting('about_image') ? \Storage::url(setting('about_image')) : asset('images/about-profil-default.jpg');
        $about->visi = setting('vision_text', 'Terwujudnya masyarakat sehat dan mandiri melalui pelayanan kesehatan ibu dan anak yang berkualitas.');
        
        $misis = json_decode(setting('missions', '[]'), true);
        if(!is_array($misis) || empty($misis) || (count($misis) === 1 && empty($misis[0]))) {
            $misis = [
                'Meningkatkan derajat kesehatan masyarakat melalui pelayanan kesehatan yang terjangkau dan bermutu.',
                'Menurunkan angka stunting melalui intervensi gizi yang tepat.'
            ];
        }
        $about->misi = $misis[0] ?? '';
        $about->misi_list = $misis;

        $tujuans = explode("\n", setting('about_values', 'Meningkatkan kesehatan ibu dan anak.'));
        $about->tujuan_list = array_filter(array_map('trim', $tujuans));

        // Lokasi
        $about->google_maps_embed = setting('posyandu_maps_embed');
        $about->alamat = setting('posyandu_address', 'Alamat belum tersedia');
        $about->telepon = setting('posyandu_phone', '-');
        $about->email = setting('posyandu_email', '-');
        $about->jam_operasional = setting('posyandu_hours', 'Senin - Sabtu: 08:00 - 15:00');

        // Struktur Organisasi
        $struktur = StrukturOrganisasi::where('is_active', true)
            ->orderBy('urutan')
            ->get();

        // Galeri
        $galeri = Galeri::where('is_active', true)
            ->orderBy('urutan')
            ->limit(6)
            ->get();

        // Nilai-nilai
        $nilai = NilaiPosyandu::where('is_active', true)
            ->orderBy('urutan')
            ->get();

        // Statistik
        $stats = Cache::remember('about_stats', 300, function () {
            return [
                'total_warga' => Warga::count(),
                'total_balita' => Balita::count(),
                'total_kader' => User::where('role', 'user')->count(),
                'total_kegiatan' => KegiatanPosyandu::count(),
            ];
        });

        // Layanan
        $services = $this->getServices();

        return view('public.about', compact(
            'about',
            'struktur',
            'galeri',
            'nilai',
            'stats',
            'services'
        ));
    }

    private function getServices()
    {
        return [
            [
                'icon' => 'scale',
                'title' => 'Penimbangan Balita',
                'description' => 'Monitoring pertumbuhan berat badan balita secara rutin',
            ],
            [
                'icon' => 'ruler',
                'title' => 'Pengukuran Tinggi Badan',
                'description' => 'Memantau pertumbuhan tinggi badan balita',
            ],
            [
                'icon' => 'shield-check',
                'title' => 'Imunisasi',
                'description' => 'Pemberian imunisasi lengkap untuk balita',
            ],
            [
                'icon' => 'beaker',
                'title' => 'Pemberian Vitamin',
                'description' => 'Suplemen vitamin untuk meningkatkan imunitas',
            ],
            [
                'icon' => 'chat-bubble-left-right',
                'title' => 'Konsultasi Gizi',
                'description' => 'Konsultasi tentang gizi dan pola makan sehat',
            ],
            [
                'icon' => 'heart',
                'title' => 'Pemeriksaan Ibu Hamil',
                'description' => 'Pemeriksaan kesehatan untuk ibu hamil',
            ],
            [
                'icon' => 'book-open',
                'title' => 'Penyuluhan Kesehatan',
                'description' => 'Edukasi kesehatan untuk masyarakat',
            ],
        ];
    }
}