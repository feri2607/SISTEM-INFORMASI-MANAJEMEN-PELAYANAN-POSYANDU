<?php

namespace App\Providers;

use App\Models\Announcement;
use App\Models\Article;
use App\Models\Balita;
use App\Models\Faq;
use App\Models\HasilPelayanan;
use App\Models\KegiatanPosyandu;
use App\Models\News;
use App\Models\User;
use App\Models\Warga;
use App\Policies\AnnouncementPolicy;
use App\Policies\ArticlePolicy;
use App\Policies\BalitaPolicy;
use App\Policies\FaqPolicy;
use App\Policies\HasilPelayananPolicy;
use App\Policies\KegiatanPolicy;
use App\Policies\NewsPolicy;
use App\Policies\UserPolicy;
use App\Policies\WargaPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Route::bind('pelayanan', fn ($value) => HasilPelayanan::findOrFail($value));

        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Warga::class, WargaPolicy::class);
        Gate::policy(Balita::class, BalitaPolicy::class);
        Gate::policy(KegiatanPosyandu::class, KegiatanPolicy::class);
        Gate::policy(HasilPelayanan::class, HasilPelayananPolicy::class);
        Gate::policy(Announcement::class, AnnouncementPolicy::class);
        Gate::policy(Article::class, ArticlePolicy::class);
        Gate::policy(News::class, NewsPolicy::class);
        Gate::policy(Faq::class, FaqPolicy::class);

        Gate::before(function ($user, $ability) {
            if ($user->hasRole('admin')) {
                return true;
            }
        });

        // =============================================
        // Auto Populate Data Kategori
        // =============================================
        Warga::saved(function ($warga) {
            if ($warga->verification_status === 'verified') {
                app(\App\Services\CitizenCategoryService::class)->syncData($warga);
            }
        });

        // =============================================
        // View Composer: Berbagi data kategori warga
        // ke semua view warga.* dan layout warga
        // =============================================
        \Illuminate\Support\Facades\View::composer(
            ['warga.*', 'profile.*', 'layouts.warga', 'components.public.navbar'],
            function ($view) {
                if (auth()->check() && auth()->user()->role === 'user') {
                    $warga = auth()->user()->warga;
                    if ($warga) {
                        $categoryService = app(\App\Services\CitizenCategoryService::class);
                        $view->with([
                            'wargaCategories' => $categoryService->getCategories($warga),
                            'wargaMenus'      => $categoryService->getDashboardMenus($warga),
                        ]);
                    } else {
                        $view->with([
                            'wargaCategories' => [],
                            'wargaMenus'      => [],
                        ]);
                    }
                }
            }
        );
    }
}

