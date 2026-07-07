<?php
// app/Http/Controllers/NewsController.php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsCategory;
use App\Http\Requests\NewsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    /**
     * Display public news list
     */
    public function index(Request $request)
    {
        $query = News::with(['category', 'user'])
            ->where('status', 'published')
            ->whereNotNull('published_at');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($u) use ($search) {
                      $u->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by month
        if ($request->filled('bulan')) {
            try {
                $driver = DB::connection()->getPDO()->getAttribute(\PDO::ATTR_DRIVER_NAME);
            } catch (\Throwable $e) {
                $driver = null;
            }

            if ($driver === 'sqlite') {
                $month = str_pad($request->bulan, 2, '0', STR_PAD_LEFT);
                $query->whereRaw("strftime('%m', published_at) = ?", [$month]);
            } else {
                $query->whereMonth('published_at', $request->bulan);
            }
        }

        // Filter by year
        if ($request->filled('tahun')) {
            try {
                $driver = DB::connection()->getPDO()->getAttribute(\PDO::ATTR_DRIVER_NAME);
            } catch (\Throwable $e) {
                $driver = null;
            }

            if ($driver === 'sqlite') {
                $query->whereRaw("strftime('%Y', published_at) = ?", [$request->tahun]);
            } else {
                $query->whereYear('published_at', $request->tahun);
            }
        }

        // Sort
        $sort = $request->get('sort', 'terbaru');
        if ($sort === 'terbaru') {
            $query->orderBy('published_at', 'desc');
        } elseif ($sort === 'terlama') {
            $query->orderBy('published_at', 'asc');
        } elseif ($sort === 'terpopuler') {
            $query->orderBy('views', 'desc');
        }

        $news = $query->paginate(9);

        // Categories for filter
        $categories = NewsCategory::where('is_active', true)->get();

        // Months for filter
        $months = [];
        for ($m = 1; $m <= 12; $m++) {
            $months[$m] = date('F', mktime(0, 0, 0, $m, 1));
        }

        // Years for filter
        try {
            $driver = DB::connection()->getPDO()->getAttribute(\PDO::ATTR_DRIVER_NAME);
        } catch (\Throwable $e) {
            $driver = null;
        }

        if ($driver === 'sqlite') {
            $years = News::where('status', 'published')
                ->selectRaw("DISTINCT strftime('%Y', published_at) as year")
                ->orderBy('year', 'desc')
                ->pluck('year')
                ->map(fn($y) => (int) $y)
                ->toArray();
        } else {
            $years = News::where('status', 'published')
                ->selectRaw('DISTINCT YEAR(published_at) as year')
                ->orderBy('year', 'desc')
                ->pluck('year')
                ->toArray();
        }

        return view('public.news', compact('news', 'categories', 'months', 'years'));
    }

    /**
     * Display news detail
     */
    public function show($slug)
    {
        $news = News::with(['category', 'user'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Increment views
        $news->incrementViews();

        // Related news
        $relatedNews = $news->getRelatedNews();

        // Popular news
        $popularNews = News::where('status', 'published')
            ->orderBy('views', 'desc')
            ->limit(5)
            ->get();

        return view('public.news-detail', compact(
            'news',
            'relatedNews',
            'popularNews'
        ));
    }

    /**
     * Admin: Display news list
     */
    public function adminIndex(Request $request)
    {
        $this->authorize('viewAny', News::class);

        $query = News::with(['category', 'user']);

        // Search
        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%");
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $query->orderBy('created_at', 'desc');

        $news = $query->paginate(10);
        $categories = NewsCategory::where('is_active', true)->get();

        return view('admin.news.index', compact('news', 'categories'));
    }

    /**
     * Admin: Show create form
     */
    public function create()
    {
        $this->authorize('create', News::class);

        $categories = NewsCategory::where('is_active', true)->get();

        return view('admin.news.create', compact('categories'));
    }

    /**
     * Admin: Store news
     */
    public function store(NewsRequest $request)
    {
        $this->authorize('create', News::class);

        $data = $request->validated();

        // Handle thumbnail
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('news', $filename, 'public');
            $data['thumbnail'] = $filename;
        }

        // Handle gallery
        if ($request->hasFile('gallery')) {
            $gallery = [];
            foreach ($request->file('gallery') as $file) {
                $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('news/gallery', $filename, 'public');
                $gallery[] = $filename;
            }
            $data['gallery'] = $gallery;
        }

        // Create slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $data['user_id'] = Auth::id();

        if ($data['status'] === 'published') {
            $data['published_at'] = now();
        }

        News::create($data);

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil dibuat.');
    }

    /**
     * Admin: Show edit form
     */
    public function edit(News $news)
    {
        $this->authorize('update', $news);

        $categories = NewsCategory::where('is_active', true)->get();

        return view('admin.news.edit', compact('news', 'categories'));
    }

    /**
     * Admin: Update news
     */
    public function update(NewsRequest $request, News $news)
    {
        $this->authorize('update', $news);

        $data = $request->validated();

        // Handle thumbnail
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($news->thumbnail && Storage::disk('public')->exists('news/' . $news->thumbnail)) {
                Storage::disk('public')->delete('news/' . $news->thumbnail);
            }

            $file = $request->file('thumbnail');
            $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('news', $filename, 'public');
            $data['thumbnail'] = $filename;
        }

        // Handle gallery
        if ($request->hasFile('gallery')) {
            // Delete old gallery
            if ($news->gallery) {
                foreach ($news->gallery as $oldImage) {
                    if (Storage::disk('public')->exists('news/gallery/' . $oldImage)) {
                        Storage::disk('public')->delete('news/gallery/' . $oldImage);
                    }
                }
            }

            $gallery = [];
            foreach ($request->file('gallery') as $file) {
                $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('news/gallery', $filename, 'public');
                $gallery[] = $filename;
            }
            $data['gallery'] = $gallery;
        }

        // Create slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        if ($data['status'] === 'published' && $news->status !== 'published') {
            $data['published_at'] = now();
        }

        $news->update($data);

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Admin: Delete news
     */
    public function destroy(News $news)
    {
        $this->authorize('delete', $news);

        // Delete thumbnail
        if ($news->thumbnail && Storage::disk('public')->exists('news/' . $news->thumbnail)) {
            Storage::disk('public')->delete('news/' . $news->thumbnail);
        }

        // Delete gallery
        if ($news->gallery) {
            foreach ($news->gallery as $image) {
                if (Storage::disk('public')->exists('news/gallery/' . $image)) {
                    Storage::disk('public')->delete('news/gallery/' . $image);
                }
            }
        }

        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil dihapus.');
    }

    /**
     * Admin: Publish news
     */
    public function publish(News $news)
    {
        $this->authorize('publish', $news);

        $news->status = 'published';
        $news->published_at = now();
        $news->save();

        return redirect()->back()
            ->with('success', 'Berita berhasil dipublikasikan.');
    }

    /**
     * Admin: Unpublish news
     */
    public function unpublish(News $news)
    {
        $this->authorize('publish', $news);

        $news->status = 'draft';
        $news->save();

        return redirect()->back()
            ->with('success', 'Berita berhasil di-unpublish.');
    }

    /**
     * Admin: Toggle featured status
     */
    public function toggleFeatured(News $news)
    {
        $this->authorize('update', $news);

        $news->is_featured = !$news->is_featured;
        $news->save();

        return redirect()->back()
            ->with('success', 'Status featured berhasil diubah.');
    }

    /**
     * Admin: Toggle breaking news status
     */
    public function toggleBreaking(News $news)
    {
        $this->authorize('update', $news);

        $news->is_breaking = !$news->is_breaking;
        $news->save();

        return redirect()->back()
            ->with('success', 'Status breaking news berhasil diubah.');
    }
}