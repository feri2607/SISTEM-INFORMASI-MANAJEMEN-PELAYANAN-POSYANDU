<?php
// app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Warga;
use App\Models\Balita;
use App\Models\KegiatanPosyandu;
use App\Models\Article;
use App\Models\News;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        // Statistik - Cache 5 menit
        $stats = Cache::remember('home_stats', 300, function () {
            return [
                'total_warga' => Warga::count(),
                'total_balita' => Balita::count(),
                'total_kader' => User::where('role', 'user')->count(),
                'total_kegiatan' => KegiatanPosyandu::count(),
            ];
        });

        // Kegiatan mendatang (max 3)
        $upcomingActivities = KegiatanPosyandu::with('user')
            ->where('status', '!=', 'selesai')
            ->where('status', '!=', 'dibatalkan')
            ->whereDate('tanggal', '>=', now())
            ->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->limit(3)
            ->get();

        // Artikel terbaru (max 3)
        $artikels = Article::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        // Berita terbaru (max 3)
        $beritas = News::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        // Pengumuman terbaru (max 5)
        $pengumumans = Announcement::where('status', 'published')
            ->orderBy('publish_at', 'desc')
            ->limit(5)
            ->get();

        return view('public.home', compact(
            'stats',
            'upcomingActivities',
            'artikels',
            'beritas',
            'pengumumans'
        ));
    }

    public function about()
    {
        $about = \App\Models\AboutPosyandu::where('is_active', true)->first() ?? new \App\Models\AboutPosyandu();
        
        $nilai = [
            ['title' => 'Integritas', 'description' => 'Menjaga kepercayaan masyarakat dengan pelayanan jujur dan transparan.', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
            ['title' => 'Proaktif', 'description' => 'Cepat tanggap dalam memberikan solusi kesehatan terpadu.', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
            ['title' => 'Inklusif', 'description' => 'Melayani semua kalangan tanpa membeda-bedakan latar belakang.', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
        ];

        $services = [
            ['title' => 'Pelayanan Balita', 'description' => 'Penimbangan dan pengukuran balita', 'icon' => 'M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3'],
            ['title' => 'Pelayanan Lansia', 'description' => 'Pemeriksaan kesehatan lansia berkala', 'icon' => 'M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9'],
            ['title' => 'Pelayanan Ibu Hamil', 'description' => 'Pemeriksaan kehamilan rutin', 'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'],
        ];

        $struktur = \App\Models\StrukturOrganisasi::where('is_active', true)->orderBy('urutan')->get() ?? [];

        $stats = [
            'total_warga' => \App\Models\Warga::count(),
            'total_balita' => \App\Models\Balita::count(),
            'total_kader' => \App\Models\User::where('role', 'user')->count(),
            'total_kegiatan' => \App\Models\KegiatanPosyandu::count()
        ];

        $galeri = [];

        return view('public.about', compact('about', 'nilai', 'services', 'struktur', 'stats', 'galeri'));
    }

    public function schedule()
    {
        // 1. Ambil filter dari request, jika kosong gunakan bulan dan tahun sekarang
        $selectedMonth = request('bulan', now()->format('m'));
        $selectedYear = request('tahun', now()->format('Y'));
        $selectedLocation = request('lokasi');

        // 2. Query data kegiatan berdasarkan filter (Pagination tetap jalan)
        $query = KegiatanPosyandu::with('user');

        if (request()->has('bulan') && request('bulan') != '') {
            $query->whereRaw('strftime("%m", tanggal) = ?', [sprintf('%02d', $selectedMonth)]);
        }

        if (request()->has('tahun') && request('tahun') != '') {
            $query->whereRaw('strftime("%Y", tanggal) = ?', [$selectedYear]);
        }

        if ($selectedLocation) {
            $query->where('lokasi', $selectedLocation);
        }

        $kegiatan = $query->orderBy('tanggal')
                          ->orderBy('jam_mulai')
                          ->paginate(10);

        // 3. Siapkan data penunjang komponen kalender & dropdown filter
        $months = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
            '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
            '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];

        $years = KegiatanPosyandu::selectRaw('distinct strftime("%Y", tanggal) as year')
                    ->whereNotNull('tanggal')
                    ->pluck('year');

        $lokasiList = KegiatanPosyandu::select('lokasi')
                        ->distinct()
                        ->whereNotNull('lokasi')
                        ->pluck('lokasi');

        $calendarData = [
            'month' => (int) $selectedMonth,
            'year' => (int) $selectedYear,
        ];

        // 4. Kirim semua variabel ke view termasuk state bulan yang aktif
        return view('public.schedule', compact(
            'kegiatan',
            'months',
            'years',
            'lokasiList',
            'selectedMonth',
            'selectedYear',
            'calendarData'
        ));
    }

    public function articles()
    {
        $artikels = Article::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->paginate(9);

        return view('public.articles', compact('artikels'));
    }

    public function articleDetail($slug)
    {
        $artikel = Article::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return view('public.article-detail', compact('artikel'));
    }

    public function news()
    {
        $beritas = News::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->paginate(9);

        return view('public.news', compact('beritas'));
    }

    public function newsDetail($slug)
    {
        $berita = News::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return view('public.news-detail', compact('berita'));
    }

    public function announcements()
    {
        $pengumumans = Announcement::where('status', 'published')
            ->orderBy('publish_at', 'desc')
            ->paginate(10);

        return view('public.announcements', compact('pengumumans'));
    }

    public function announcementDetail($id)
    {
        $pengumuman = Announcement::where('id', $id)
            ->where('status', 'published')
            ->firstOrFail();

        return view('public.announcement-detail', compact('pengumuman'));
    }

    public function contact()
    {
        return view('public.contact');
    }

    public function faq()
    {
        return view('public.faq');
    }
}