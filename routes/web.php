<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\WargaController as AdminWargaController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\BalitaController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\HasilPelayananController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Kader\WargaController as KaderWargaController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\Pegawai\BalitaMedisController as PegawaiBalitaMedisController;
use App\Http\Controllers\Pegawai\KehamilanController as PegawaiKehamilanController;
use App\Http\Controllers\Pegawai\LansiaController as PegawaiLansiaController;
use App\Http\Controllers\Pegawai\RemajaController as PegawaiRemajaController;
use App\Http\Controllers\Pegawai\WusController as PegawaiWusController;
use App\Http\Controllers\Profile\ProfileController as WargaProfileController;
use App\Http\Controllers\Warga\AnakController as WargaAnakController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\Warga\BalitaController as WargaBalitaController;
use App\Http\Controllers\Warga\KehamilanController;
use App\Http\Controllers\Warga\LansiaController;
use App\Http\Controllers\Warga\PelayananController as WargaPelayananController;
use App\Http\Controllers\Warga\RemajaController;
use App\Http\Controllers\Warga\WargaController as WargaWargaController;
use App\Http\Controllers\Warga\WusController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\WargaDashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

//====================================================
// ROOT
//====================================================

Route::get('/', function () {
    return redirect()->route('login');
});

//====================================================
// PUBLIC ROUTES (Tanpa auth)
//====================================================

Route::controller(HomeController::class)->group(function () {
    // Home
    Route::get('/', 'index')->name('home');
    
    // Schedule
    Route::get('/jadwal', 'schedule')->name('public.schedule');
    
    // Articles
    Route::get('/artikel', 'articles')->name('public.articles');
    Route::get('/artikel/{slug}', 'articleDetail')->name('public.article-detail');
    
    // News
    Route::get('/berita', 'news')->name('public.news');
    Route::get('/berita/{slug}', 'newsDetail')->name('public.news-detail');
    
    // Contact
    Route::get('/kontak', 'contact')->name('contact');
});

// =============================================
// PUBLIC ROUTES
// =============================================
Route::get('/faq', [FaqController::class, 'index'])->name('public.faq');

// =============================================
// ADMIN ROUTES
// =============================================
Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('faq', [FaqController::class, 'adminIndex'])->name('faq.index');
        Route::resource('faq', FaqController::class)->except(['show', 'index']);
        Route::patch('faq/{faq}/publish', [FaqController::class, 'publish'])->name('faq.publish');
        Route::patch('faq/{faq}/unpublish', [FaqController::class, 'unpublish'])->name('faq.unpublish');
        Route::patch('faq/{faq}/toggle-featured', [FaqController::class, 'toggleFeatured'])->name('faq.toggle-featured');
        Route::post('faq/reorder', [FaqController::class, 'reorder'])->name('faq.reorder');

        // Pengaturan Sistem
        Route::get('settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
        Route::post('settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');

        // Modul Ekstensi Pengaturan
        Route::resource('struktur-organisasi', \App\Http\Controllers\Admin\StrukturOrganisasiController::class)->except(['show']);
        Route::resource('galeri', \App\Http\Controllers\Admin\GaleriController::class)->except(['show']);
    });

// =============================================
// PUBLIC ROUTES
// =============================================
Route::controller(AboutController::class)->group(function () {
    Route::get('/tentang', 'index')->name('about');
    // ... other public routes
});

Route::controller(ScheduleController::class)->group(function () {
    // Halaman utama jadwal
    Route::get('/jadwal-posyandu', 'index')->name('public.schedule');

    // Detail kegiatan
    Route::get('/jadwal-posyandu/{id}', 'show')->name('public.schedule.detail');

    // Konfirmasi kehadiran (POST)
    Route::post('/jadwal-posyandu/{id}/konfirmasi', 'konfirmasiKehadiran')->name('public.schedule.konfirmasi');

    // Batalkan konfirmasi (POST)
    Route::post('/jadwal-posyandu/{id}/batal', 'batalKonfirmasi')->name('public.schedule.batal');

    // Get events untuk kalender (GET) - tanpa API prefix
    Route::get('/jadwal-posyandu/events', 'getEvents')->name('public.schedule.events');
});

// =============================================
// PUBLIC ROUTES
// =============================================
Route::controller(ArticleController::class)->group(function () {
    Route::get('/artikel', 'index')->name('public.articles');
    Route::get('/artikel/{slug}', 'show')->name('public.article-detail');
});

// =============================================
// ADMIN ROUTES
// =============================================
Route::middleware(['auth', 'verified', 'role:admin,pegawai'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('articles', [ArticleController::class, 'adminIndex'])->name('articles.index');
        Route::resource('articles', ArticleController::class)->except(['show', 'index']);
        Route::patch('articles/{article}/status', [ArticleController::class, 'toggleStatus'])->name('articles.toggle-status');
    });

// =============================================
// PUBLIC ROUTES
// =============================================
Route::controller(NewsController::class)->group(function () {
    Route::get('/berita', 'index')->name('public.news');
    Route::get('/berita/{slug}', 'show')->name('public.news-detail');
});

// =============================================
// ADMIN ROUTES
// =============================================
Route::middleware(['auth', 'verified', 'role:admin,pegawai'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('news', [NewsController::class, 'adminIndex'])->name('news.index');
        Route::resource('news', NewsController::class)->except(['show', 'index']);
        Route::patch('news/{news}/publish', [NewsController::class, 'publish'])->name('news.publish');
        Route::patch('news/{news}/unpublish', [NewsController::class, 'unpublish'])->name('news.unpublish');
        Route::patch('news/{news}/toggle-featured', [NewsController::class, 'toggleFeatured'])->name('news.toggle-featured');
        Route::patch('news/{news}/toggle-breaking', [NewsController::class, 'toggleBreaking'])->name('news.toggle-breaking');
    });

// =============================================
// PUBLIC ROUTES
// =============================================
Route::controller(AnnouncementController::class)->group(function () {
    Route::get('/pengumuman', 'index')->name('public.announcements');
    Route::get('/pengumuman/{slug}', 'show')->name('public.announcement-detail');
});

// =============================================
// ADMIN ROUTES
// =============================================
Route::middleware(['auth', 'verified', 'role:admin,pegawai'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('announcements', [AnnouncementController::class, 'adminIndex'])->name('announcements.index');
        Route::resource('announcements', AnnouncementController::class)->except(['show', 'index']);
        Route::get('announcements/{announcement}', [AnnouncementController::class, 'adminShow'])->name('announcements.show');
        Route::patch('announcements/{announcement}/publish', [AnnouncementController::class, 'publish'])->name('announcements.publish');
        Route::patch('announcements/{announcement}/unpublish', [AnnouncementController::class, 'unpublish'])->name('announcements.unpublish');
        Route::patch('announcements/{announcement}/archive', [AnnouncementController::class, 'archive'])->name('announcements.archive');
    });

// =============================================
// PUBLIC ROUTES
// =============================================
Route::controller(ContactController::class)->group(function () {
    Route::get('/kontak', 'index')->name('contact');
    Route::post('/kontak/kirim', 'send')->name('contact.send');
});

// =============================================
// ADMIN ROUTES
// =============================================
Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/kontak', [ContactController::class, 'adminIndex'])->name('contact.index');
        Route::put('/kontak', [ContactController::class, 'adminUpdate'])->name('contact.update');

        Route::get('/pesan', [ContactController::class, 'messages'])->name('contact.messages');
        Route::get('/pesan/{id}', [ContactController::class, 'showMessage'])->name('contact.message.show');
        Route::delete('/pesan/{id}', [ContactController::class, 'deleteMessage'])->name('contact.message.delete');
        Route::patch('/pesan/{id}/read', [ContactController::class, 'markAsRead'])->name('contact.message.read');
        Route::post('/pesan/{id}/reply', [ContactController::class, 'replyMessage'])->name('contact.message.reply');
        Route::patch('/pesan/mark-all-read', [ContactController::class, 'markAllAsRead'])->name('contact.mark-all-read');
    });

//====================================================
// GUEST
//====================================================

Route::middleware('guest')->group(function () {

    // Login
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // Register
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    // Forgot Password
    Route::get('forgot-password', [PasswordResetController::class, 'showForgotForm'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetController::class, 'sendResetLink'])
        ->name('password.email');

    // Reset Password
    Route::get('reset-password/{token}', [PasswordResetController::class, 'showResetForm'])
        ->name('password.reset');

    Route::post('reset-password', [PasswordResetController::class, 'reset'])
        ->name('password.update');

    // Social Login
    Route::get('auth/{provider}/redirect', [GoogleController::class, 'redirectToGoogle'])
        ->name('auth.redirect');

    Route::get('auth/{provider}/callback', [GoogleController::class, 'handleGoogleCallback'])
        ->name('auth.callback');

    // Legacy Google Login routes specified in .env
    Route::get('/login/google', [GoogleController::class, 'redirectToGoogle'])->name('login.google');
    Route::get('/login/google/callback', [GoogleController::class, 'handleGoogleCallback']);
});

//====================================================
// AUTH
//====================================================

Route::middleware('auth')->group(function () {

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    Route::get('email/verify', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('email/verify/{id}/{hash}', VerifyEmailController::class)
        ->middleware('signed')
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->name('verification.send');
});

//====================================================
// AUTH + VERIFIED
//====================================================

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    //====================================================
    // ADMIN
    //====================================================

    Route::middleware(['role:admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            Route::get('/dashboard', [DashboardController::class, 'admin'])
                ->name('dashboard');

            //================================================
            // USER
            //================================================
    
            Route::prefix('users')->name('users.')->group(function () {

                Route::get('/', [AdminUserController::class, 'index'])
                    ->name('index');

                Route::get('/{user}/role', [AdminUserController::class, 'editRole'])
                    ->name('edit-role');

                Route::put('/{user}/role', [AdminUserController::class, 'updateRole'])
                    ->name('update-role');

                Route::delete('/{user}', [AdminUserController::class, 'destroy'])
                    ->name('destroy');
            });

            //================================================
            // WARGA
            //================================================

            Route::resource('warga', AdminWargaController::class);
            Route::patch('warga/{warga}/verify', [AdminWargaController::class, 'verify'])->name('warga.verify');
            Route::patch('warga/{warga}/reject', [AdminWargaController::class, 'reject'])->name('warga.reject');

            //================================================
            // BALITA
            //================================================
    
            Route::resource('balita', BalitaController::class)->parameters(['balita' => 'balita']);
            Route::patch('balita/{balita}/verify', [BalitaController::class, 'verify'])->name('balita.verify');
            Route::patch('balita/{balita}/reject', [BalitaController::class, 'reject'])->name('balita.reject');
            Route::get('balita/export/excel', [BalitaController::class, 'exportExcel'])->name('balita.export.excel');
            Route::get('balita/export/pdf', [BalitaController::class, 'exportPdf'])->name('balita.export.pdf');

            // Balita Medis (Admin)
            Route::prefix('balita/{balita}/medis')->name('balita.medis.')->group(function () {
                Route::get('pemeriksaan/create', [PegawaiBalitaMedisController::class, 'createPemeriksaan'])->name('pemeriksaan.create');
                Route::post('pemeriksaan', [PegawaiBalitaMedisController::class, 'storePemeriksaan'])->name('pemeriksaan.store');
                Route::get('imunisasi/create', [PegawaiBalitaMedisController::class, 'createImunisasi'])->name('imunisasi.create');
                Route::post('imunisasi', [PegawaiBalitaMedisController::class, 'storeImunisasi'])->name('imunisasi.store');
                Route::get('vitamin/create', [PegawaiBalitaMedisController::class, 'createVitamin'])->name('vitamin.create');
                Route::post('vitamin', [PegawaiBalitaMedisController::class, 'storeVitamin'])->name('vitamin.store');
                Route::get('perkembangan/create', [PegawaiBalitaMedisController::class, 'createPerkembangan'])->name('perkembangan.create');
                Route::post('perkembangan', [PegawaiBalitaMedisController::class, 'storePerkembangan'])->name('perkembangan.store');
            });

            //================================================
            // KEGIATAN
            //================================================
    
            Route::resource('kegiatan', \App\Http\Controllers\Admin\KegiatanController::class);

            Route::patch(
                'kegiatan/{kegiatan}/status',
                [\App\Http\Controllers\Admin\KegiatanController::class, 'updateStatus']
            )->name('kegiatan.update-status');

            Route::get(
                'kegiatan/{kegiatan}/print-absensi',
                [KegiatanController::class, 'printAbsensi']
            )->name('kegiatan.print-absensi');

            //================================================
            // PELAYANAN
            //================================================
    
            Route::resource('pelayanan', HasilPelayananController::class);

            Route::get(
                'pelayanan/search/balita',
                [HasilPelayananController::class, 'searchBalita']
            )->name('pelayanan.search.balita');

            Route::get(
                'pelayanan/balita/detail',
                [HasilPelayananController::class, 'getBalitaDetail']
            )->name('pelayanan.balita.detail');

            Route::get(
                'pelayanan/{pelayanan}/print',
                [HasilPelayananController::class, 'print']
            )->name('pelayanan.print');

            //================================================
            // LAPORAN (ADMIN)
            //================================================
            Route::prefix('laporan')->name('laporan.')->group(function () {
                Route::get('/', [LaporanController::class, 'index'])->name('index');
                Route::get('/export/pdf', [LaporanController::class, 'exportPdf'])->name('export.pdf');
                Route::get('/export/excel', [LaporanController::class, 'exportExcel'])->name('export.excel');
            });

            //================================================
            // EXPORT
            //================================================

            Route::prefix('export')->name('export.')->group(function () {

                Route::get(
                    'warga/excel',
                    [AdminWargaController::class, 'exportExcel']
                )->name('warga.excel');

                Route::get(
                    'warga/pdf',
                    [AdminWargaController::class, 'exportPdf']
                )->name('warga.pdf');

                Route::get(
                    'balita/excel',
                    [BalitaController::class, 'exportExcel']
                )->name('balita.excel');

                Route::get(
                    'balita/pdf',
                    [BalitaController::class, 'exportPdf']
                )->name('balita.pdf');

                Route::get(
                    'kegiatan/excel',
                    [KegiatanController::class, 'exportExcel']
                )->name('kegiatan.excel');

                Route::get(
                    'kegiatan/pdf',
                    [KegiatanController::class, 'exportPdf']
                )->name('kegiatan.pdf');

                // Export Pelayanan
    
                Route::get(
                    'pelayanan/excel',
                    [HasilPelayananController::class, 'exportExcel']
                )->name('pelayanan.excel');

                Route::get(
                    'pelayanan/pdf',
                    [HasilPelayananController::class, 'exportPdf']
                )->name('pelayanan.pdf');
            });
        });

    //====================================================
    // PEGAWAI ROUTES (role:pegawai)
    //====================================================

    Route::middleware(['role:pegawai'])
        ->prefix('pegawai')
        ->name('pegawai.')
        ->group(function () {

            Route::get('/dashboard', [DashboardController::class, 'pegawai'])
                ->name('dashboard');
            
            // Profile
            Route::get('profil-saya', [ProfileController::class, 'show'])->name('profile.index');

            // Warga
            Route::resource('warga', AdminWargaController::class);
            Route::patch('warga/{warga}/verify', [AdminWargaController::class, 'verify'])->name('warga.verify');
            Route::patch('warga/{warga}/reject', [AdminWargaController::class, 'reject'])->name('warga.reject');

            // Balita Management - menggunakan BalitaController yang sama
            Route::resource('balita', BalitaController::class)->parameters(['balita' => 'balita']);
            Route::patch('balita/{balita}/verify', [BalitaController::class, 'verify'])->name('balita.verify');
            Route::patch('balita/{balita}/reject', [BalitaController::class, 'reject'])->name('balita.reject');

            // Balita Medis (Pegawai)
            Route::prefix('balita/{balita}/medis')->name('balita.medis.')->group(function () {
                Route::get('pemeriksaan/create', [PegawaiBalitaMedisController::class, 'createPemeriksaan'])->name('pemeriksaan.create');
                Route::post('pemeriksaan', [PegawaiBalitaMedisController::class, 'storePemeriksaan'])->name('pemeriksaan.store');
                Route::get('imunisasi/create', [PegawaiBalitaMedisController::class, 'createImunisasi'])->name('imunisasi.create');
                Route::post('imunisasi', [PegawaiBalitaMedisController::class, 'storeImunisasi'])->name('imunisasi.store');
                Route::get('vitamin/create', [PegawaiBalitaMedisController::class, 'createVitamin'])->name('vitamin.create');
                Route::post('vitamin', [PegawaiBalitaMedisController::class, 'storeVitamin'])->name('vitamin.store');
                Route::get('perkembangan/create', [PegawaiBalitaMedisController::class, 'createPerkembangan'])->name('perkembangan.create');
                Route::post('perkembangan', [PegawaiBalitaMedisController::class, 'storePerkembangan'])->name('perkembangan.store');
            });

            // Kegiatan
            Route::resource('kegiatan', \App\Http\Controllers\Pegawai\KegiatanController::class)->only(['index', 'show']);
            Route::patch(
                'kegiatan/{kegiatan}/status',
                [\App\Http\Controllers\Admin\KegiatanController::class, 'updateStatus']
            )->name('kegiatan.update-status');
            Route::get(
                'kegiatan/{kegiatan}/print-absensi',
                [\App\Http\Controllers\Admin\KegiatanController::class, 'printAbsensi']
            )->name('kegiatan.print-absensi');

            // Registrasi Kehadiran
            Route::get('registrasi-kehadiran', [\App\Http\Controllers\Pegawai\RegistrasiKehadiranController::class, 'index'])->name('kehadiran.index');
            Route::patch('registrasi-kehadiran/{id}/hadir', [\App\Http\Controllers\Pegawai\RegistrasiKehadiranController::class, 'markHadir'])->name('kehadiran.hadir');

            // Pelayanan Hari Ini
            Route::get('pelayanan-hari-ini', [\App\Http\Controllers\Pegawai\PelayananHariIniController::class, 'index'])->name('pelayanan-hari-ini.index');

            // Pelayanan Riwayat
    
            Route::resource('pelayanan', HasilPelayananController::class);

            Route::get(
                'pelayanan/search/balita',
                [HasilPelayananController::class, 'searchBalita']
            )->name('pelayanan.search.balita');

            Route::get(
                'pelayanan/balita/detail',
                [HasilPelayananController::class, 'getBalitaDetail']
            )->name('pelayanan.balita.detail');

            // Kesehatan Reproduksi untuk pegawai
            Route::prefix('reproduksi')->name('reproduksi.')->group(function () {
                Route::get('dashboard', [PegawaiWusController::class, 'dashboard'])->name('dashboard');

                Route::get('wus', [PegawaiWusController::class, 'indexWus'])->name('wus.index');
                Route::get('wus/{wus}', [PegawaiWusController::class, 'showWus'])->name('wus.show');
                Route::patch('wus/{wus}/verify', [PegawaiWusController::class, 'verifyWus'])->name('wus.verify');

                Route::get('pus', [PegawaiWusController::class, 'indexPus'])->name('pus.index');
                Route::get('pus/{pus}', [PegawaiWusController::class, 'showPus'])->name('pus.show');

                Route::get('pelayanan/{wus}/create', [PegawaiWusController::class, 'createPelayanan'])->name('pelayanan.create');
                Route::post('pelayanan', [PegawaiWusController::class, 'storePelayanan'])->name('pelayanan.store');
                Route::get('pelayanan/{pelayanan}/edit', [PegawaiWusController::class, 'editPelayanan'])->name('pelayanan.edit');
                Route::put('pelayanan/{pelayanan}', [PegawaiWusController::class, 'updatePelayanan'])->name('pelayanan.update');
                Route::delete('pelayanan/{pelayanan}', [PegawaiWusController::class, 'destroyPelayanan'])->name('pelayanan.destroy');

                Route::get('konseling/{wus}/create', [PegawaiWusController::class, 'createKonseling'])->name('konseling.create');
                Route::post('konseling', [PegawaiWusController::class, 'storeKonseling'])->name('konseling.store');
                Route::get('konseling/{konseling}/edit', [PegawaiWusController::class, 'editKonseling'])->name('konseling.edit');
                Route::put('konseling/{konseling}', [PegawaiWusController::class, 'updateKonseling'])->name('konseling.update');
                Route::delete('konseling/{konseling}', [PegawaiWusController::class, 'destroyKonseling'])->name('konseling.destroy');

                Route::get('kontrol', [PegawaiWusController::class, 'indexKontrol'])->name('kontrol.index');
                Route::get('kontrol/{wus}/create', [PegawaiWusController::class, 'createKontrol'])->name('kontrol.create');
                Route::post('kontrol', [PegawaiWusController::class, 'storeKontrol'])->name('kontrol.store');
                Route::get('kontrol/{kontrol}/edit', [PegawaiWusController::class, 'editKontrol'])->name('kontrol.edit');
                Route::put('kontrol/{kontrol}', [PegawaiWusController::class, 'updateKontrol'])->name('kontrol.update');
                Route::patch('kontrol/{kontrol}/status', [PegawaiWusController::class, 'updateStatusKontrol'])->name('kontrol.status');
                Route::delete('kontrol/{kontrol}', [PegawaiWusController::class, 'destroyKontrol'])->name('kontrol.destroy');
            });
            // =============================================
            // PEGAWAI REMAJA
            // =============================================
            Route::prefix('remaja')->name('remaja.')->group(function () {
                // Dashboard
                Route::get('dashboard', [PegawaiRemajaController::class, 'dashboard'])->name('dashboard');

                // Data Remaja
                Route::get('/', [PegawaiRemajaController::class, 'index'])->name('index');
                Route::get('{remaja}', [PegawaiRemajaController::class, 'show'])->name('show');
                Route::delete('{remaja}', [PegawaiRemajaController::class, 'destroy'])->name('destroy');

                // Pemeriksaan
                Route::get('{remaja}/pemeriksaan/create', [PegawaiRemajaController::class, 'createPemeriksaan'])->name('pemeriksaan.create');
                Route::post('pemeriksaan', [PegawaiRemajaController::class, 'storePemeriksaan'])->name('pemeriksaan.store');
                Route::get('pemeriksaan/{pemeriksaan}/edit', [PegawaiRemajaController::class, 'editPemeriksaan'])->name('pemeriksaan.edit');
                Route::put('pemeriksaan/{pemeriksaan}', [PegawaiRemajaController::class, 'updatePemeriksaan'])->name('pemeriksaan.update');
                Route::delete('pemeriksaan/{pemeriksaan}', [PegawaiRemajaController::class, 'destroyPemeriksaan'])->name('pemeriksaan.destroy');

                // Konseling
                Route::get('{remaja}/konseling/create', [PegawaiRemajaController::class, 'createKonseling'])->name('konseling.create');
                Route::post('konseling', [PegawaiRemajaController::class, 'storeKonseling'])->name('konseling.store');
                Route::get('konseling/{konseling}/edit', [PegawaiRemajaController::class, 'editKonseling'])->name('konseling.edit');
                Route::put('konseling/{konseling}', [PegawaiRemajaController::class, 'updateKonseling'])->name('konseling.update');
                Route::delete('konseling/{konseling}', [PegawaiRemajaController::class, 'destroyKonseling'])->name('konseling.destroy');

                // Tablet Tambah Darah
                Route::post('{remaja}/ttd', [PegawaiRemajaController::class, 'updateTtd'])->name('ttd.update');

                // Verifikasi
                Route::patch('{remaja}/verify', [PegawaiRemajaController::class, 'verify'])->name('verify');
                Route::patch('{remaja}/reject', [PegawaiRemajaController::class, 'reject'])->name('reject');
            });

            // =============================================
            // PEGAWAI LANSIA
            // =============================================
            Route::prefix('lansia')->name('lansia.')->group(function () {
                Route::get('dashboard', [PegawaiLansiaController::class, 'dashboard'])->name('dashboard');
                Route::get('/', [PegawaiLansiaController::class, 'index'])->name('index');

                // Jadwal Senam
                Route::get('jadwal-senam', [PegawaiLansiaController::class, 'indexJadwal'])->name('jadwal.index');
                Route::get('jadwal-senam/create', [PegawaiLansiaController::class, 'createJadwal'])->name('jadwal.create');
                Route::post('jadwal-senam', [PegawaiLansiaController::class, 'storeJadwal'])->name('jadwal.store');
                Route::get('jadwal-senam/{jadwal}/edit', [PegawaiLansiaController::class, 'editJadwal'])->name('jadwal.edit');
                Route::put('jadwal-senam/{jadwal}', [PegawaiLansiaController::class, 'updateJadwal'])->name('jadwal.update');
                Route::delete('jadwal-senam/{jadwal}', [PegawaiLansiaController::class, 'destroyJadwal'])->name('jadwal.destroy');

                // Laporan
                Route::get('laporan', [PegawaiLansiaController::class, 'laporan'])->name('laporan');

                Route::get('{lansia}', [PegawaiLansiaController::class, 'show'])->name('show');
                Route::delete('{lansia}', [PegawaiLansiaController::class, 'destroy'])->name('destroy');

                // Pemeriksaan
                Route::get('{lansia}/pemeriksaan/create', [PegawaiLansiaController::class, 'createPemeriksaan'])->name('pemeriksaan.create');
                Route::post('pemeriksaan', [PegawaiLansiaController::class, 'storePemeriksaan'])->name('pemeriksaan.store');
                Route::get('pemeriksaan/{pemeriksaan}/edit', [PegawaiLansiaController::class, 'editPemeriksaan'])->name('pemeriksaan.edit');
                Route::put('pemeriksaan/{pemeriksaan}', [PegawaiLansiaController::class, 'updatePemeriksaan'])->name('pemeriksaan.update');
                Route::delete('pemeriksaan/{pemeriksaan}', [PegawaiLansiaController::class, 'destroyPemeriksaan'])->name('pemeriksaan.destroy');

                // Verifikasi
                Route::patch('{lansia}/verify', [PegawaiLansiaController::class, 'verify'])->name('verify');
                Route::patch('{lansia}/reject', [PegawaiLansiaController::class, 'reject'])->name('reject');
            });

            // =============================================
            // PEGAWAI KEHAMILAN
            // =============================================
            Route::prefix('kehamilan')->name('kehamilan.')->group(function () {
                Route::get('dashboard', [PegawaiKehamilanController::class, 'dashboard'])->name('dashboard');
                Route::get('/', [PegawaiKehamilanController::class, 'index'])->name('index');
                Route::get('{kehamilan}', [PegawaiKehamilanController::class, 'show'])->name('show');

                // ANC
                Route::get('{kehamilan}/anc/create', [PegawaiKehamilanController::class, 'createAnc'])->name('anc.create');
                Route::post('anc', [PegawaiKehamilanController::class, 'storeAnc'])->name('anc.store');
                Route::get('anc/{anc}/edit', [PegawaiKehamilanController::class, 'editAnc'])->name('anc.edit');
                Route::put('anc/{anc}', [PegawaiKehamilanController::class, 'updateAnc'])->name('anc.update');
                Route::delete('anc/{anc}', [PegawaiKehamilanController::class, 'destroyAnc'])->name('anc.destroy');

                // Verifikasi
                Route::patch('{kehamilan}/verify', [PegawaiKehamilanController::class, 'verify'])->name('verify');
                Route::patch('{kehamilan}/reject', [PegawaiKehamilanController::class, 'reject'])->name('reject');
            });
            // LAPORAN (PEGAWAI)
            // =============================================
            Route::prefix('laporan')->name('laporan.')->group(function () {
                Route::get('/', [LaporanController::class, 'index'])->name('index');
                Route::get('/export/pdf', [LaporanController::class, 'exportPdf'])->name('export.pdf');
                Route::get('/export/excel', [LaporanController::class, 'exportExcel'])->name('export.excel');
            });
        });

    // =============================================
    // WARGA ROUTES (role:warga)
    // =============================================
    Route::middleware(['auth', 'verified', 'role:warga,user'])
        ->prefix('warga')
        ->name('warga.')
        ->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

            Route::resource('balita', WargaBalitaController::class)->parameters(['balita' => 'balita']);

            // Kesehatan Reproduksi (WUS/PUS)
            Route::get('kesehatan-reproduksi', [WusController::class, 'index'])->name('reproduksi.index');
            Route::get('kesehatan-reproduksi/create', [WusController::class, 'create'])->name('reproduksi.create');
            Route::post('kesehatan-reproduksi', [WusController::class, 'store'])->name('reproduksi.store');
            Route::get('kesehatan-reproduksi/{wus}', [WusController::class, 'show'])->name('reproduksi.show');
            Route::get('kesehatan-reproduksi/{wus}/edit', [WusController::class, 'edit'])->name('reproduksi.edit');
            Route::put('kesehatan-reproduksi/{wus}', [WusController::class, 'update'])->name('reproduksi.update');
            Route::delete('kesehatan-reproduksi/{wus}', [WusController::class, 'destroy'])->name('reproduksi.destroy');
            Route::get('kesehatan-reproduksi/{pus}/pus', [WusController::class, 'showPus'])->name('reproduksi.pus');
            Route::get('pelayanan-reproduksi/{pelayanan}', [WusController::class, 'showPelayanan'])->name('reproduksi.pelayanan.show');

            Route::get('posyandu-remaja', [RemajaController::class, 'index'])->name('remaja.index');

            Route::middleware('role:warga,user')->group(function () {
                Route::get('posyandu-remaja/create', [RemajaController::class, 'create'])->name('remaja.create');
                Route::post('posyandu-remaja', [RemajaController::class, 'store'])->name('remaja.store');
                Route::get('posyandu-remaja/{remaja}/edit', [RemajaController::class, 'edit'])->name('remaja.edit');
                Route::put('posyandu-remaja/{remaja}', [RemajaController::class, 'update'])->name('remaja.update');
                Route::delete('posyandu-remaja/{remaja}', [RemajaController::class, 'destroy'])->name('remaja.destroy');
                Route::get('pemeriksaan-remaja/{pemeriksaan}', [RemajaController::class, 'showPemeriksaan'])->name('remaja.pemeriksaan.show');
            });

            Route::get('posyandu-remaja/{remaja}', [RemajaController::class, 'show'])->name('remaja.show');

            Route::get('posyandu-lansia', [LansiaController::class, 'index'])->name('lansia.index');
            Route::get('posyandu-lansia/create', [LansiaController::class, 'create'])->name('lansia.create');
            Route::post('posyandu-lansia', [LansiaController::class, 'store'])->name('lansia.store');
            Route::get('posyandu-lansia/{lansia}', [LansiaController::class, 'show'])->name('lansia.show');
            Route::get('posyandu-lansia/{lansia}/edit', [LansiaController::class, 'edit'])->name('lansia.edit');
            Route::put('posyandu-lansia/{lansia}', [LansiaController::class, 'update'])->name('lansia.update');
            Route::get('pemeriksaan-lansia/{pemeriksaan}', [LansiaController::class, 'showPemeriksaan'])->name('lansia.pemeriksaan.show');
        });


    // =============================================
    // WARGA ROUTES (role:user)
    // =============================================
    Route::middleware(['role:user'])
        ->prefix('warga')
        ->name('warga.')
        ->group(function () {
            // Dashboard
            Route::get('/dashboard', [\App\Http\Controllers\Warga\DashboardController::class, 'index'])->name('dashboard');

            // Data Warga
            Route::prefix('warga')->name('warga.')->group(function () {
                Route::get('/', [WargaWargaController::class, 'index'])->name('index');
                Route::get('/create', [WargaWargaController::class, 'create'])->name('create');
                Route::post('/', [WargaWargaController::class, 'store'])->name('store');
                Route::get('/edit', [WargaWargaController::class, 'edit'])->name('edit');
                Route::put('/', [WargaWargaController::class, 'update'])->name('update');
                Route::get('/download-ktp', [WargaWargaController::class, 'downloadKtp'])->name('download-ktp');
                Route::get('/download-kk', [WargaWargaController::class, 'downloadKk'])->name('download-kk');
            });
            
            // Balita Management (Warga only sees their own)
            Route::resource('balita', WargaBalitaController::class)->parameters(['balita' => 'balita']);
            
            // Kehamilan
            Route::get('kehamilan', [KehamilanController::class, 'index'])->name('kehamilan.index');
            Route::get('kehamilan/create', [KehamilanController::class, 'create'])->name('kehamilan.create');
            Route::post('kehamilan', [KehamilanController::class, 'store'])->name('kehamilan.store');
            Route::get('kehamilan/{kehamilan}', [KehamilanController::class, 'show'])->name('kehamilan.show');
            Route::get('kehamilan/{kehamilan}/edit', [KehamilanController::class, 'edit'])->name('kehamilan.edit');
            Route::put('kehamilan/{kehamilan}', [KehamilanController::class, 'update'])->name('kehamilan.update');

            // Pelayanan
            Route::get('pelayanan', [WargaPelayananController::class, 'index'])->name('pelayanan.index');
            Route::get('pelayanan/{pelayanan}', [WargaPelayananController::class, 'show'])->name('pelayanan.show');
        });

    // =============================================
    // PROFILE WARGA ROUTES
    // =============================================
    Route::middleware(['auth', 'verified', 'role:user'])
        ->prefix('profil-saya')
        ->name('profile.')
        ->group(function () {
            Route::get('/', [WargaProfileController::class, 'index'])->name('index');
            Route::put('/', [WargaProfileController::class, 'update'])->name('update');
            Route::patch('/photo', [WargaProfileController::class, 'updateAvatar'])->name('update-avatar');
            Route::delete('/photo', [WargaProfileController::class, 'deleteAvatar'])->name('delete-avatar');
            Route::patch('/password', [WargaProfileController::class, 'updatePassword'])->name('update-password');
            Route::post('/password', [WargaProfileController::class, 'createPassword'])->name('create-password');
            Route::patch('/preferences', [WargaProfileController::class, 'updatePreferences'])->name('update-preferences');
            Route::delete('/account', [WargaProfileController::class, 'deleteAccount'])->name('delete-account');
            Route::get('/activities', [WargaProfileController::class, 'getLoginActivities'])->name('activities');

            // Data Anak (CRUD via Profil Saya)
            Route::get('/anak', [WargaAnakController::class, 'index'])->name('anak.index');
            Route::get('/anak/tambah', [WargaAnakController::class, 'create'])->name('anak.create');
            Route::post('/anak', [WargaAnakController::class, 'store'])->name('anak.store');
            Route::get('/anak/{anak}/ubah', [WargaAnakController::class, 'edit'])->name('anak.edit');
            Route::put('/anak/{anak}', [WargaAnakController::class, 'update'])->name('anak.update');
            Route::delete('/anak/{anak}', [WargaAnakController::class, 'destroy'])->name('anak.destroy');
        });
});


// =============================================
// AUTHENTICATED ROUTES
// =============================================
Route::middleware(['auth', 'verified'])->group(function () {

    // ... existing routes ...

    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    Route::post('/profile/logout-all', [ProfileController::class, 'logoutAllDevices'])->name('profile.logout-all');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});