<?php
// app/Http/Controllers/ArticleController.php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Tag;
use App\Http\Requests\ArticleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class ArticleController extends Controller
{
    /**
     * Display public articles list
     */
    public function index(Request $request)
    {
        $query = Article::with(['category', 'user', 'tags'])
            ->where('status', 'published')
            ->whereNotNull('published_at');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
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

        $articles = $query->paginate(9);

        // Categories for filter
        $categories = ArticleCategory::where('is_active', true)->get();

        return view('public.articles', compact('articles', 'categories'));
    }

    /**
     * Display article detail
     */
    public function show($slug)
    {
        $article = Article::with(['category', 'user', 'tags'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Increment views
        $article->incrementViews();

        // Related articles
        $relatedArticles = $article->getRelatedArticles();

        // Popular articles
        $popularArticles = Article::where('status', 'published')
            ->orderBy('views', 'desc')
            ->limit(5)
            ->get();

        return view('public.article-detail', compact(
            'article',
            'relatedArticles',
            'popularArticles'
        ));
    }

    /**
     * Admin: Display articles list
     */
    public function adminIndex(Request $request)
    {
        $this->authorize('viewAny', Article::class);

        $query = Article::with(['category', 'user', 'tags']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%");
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

        $articles = $query->paginate(10);
        $categories = ArticleCategory::where('is_active', true)->get();

        return view('admin.articles.index', compact('articles', 'categories'));
    }

    /**
     * Admin: Show create form
     */
    public function create()
    {
        $this->authorize('create', Article::class);

        $categories = ArticleCategory::where('is_active', true)->get();
        $tags = Tag::all();

        return view('admin.articles.create', compact('categories', 'tags'));
    }

    /**
     * Admin: Store article
     */
    public function store(ArticleRequest $request)
    {
        $this->authorize('create', Article::class);

        $data = $request->validated();

        // Handle thumbnail
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('articles', $filename, 'public');
            $data['thumbnail'] = $filename;
        }

        // Create slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $data['user_id'] = Auth::id();

        if ($data['status'] === 'published') {
            $data['published_at'] = now();
        }

        $article = Article::create($data);

        // Sync tags
        if ($request->filled('tags')) {
            $article->tags()->sync($request->tags);
        }

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil dibuat.');
    }

    /**
     * Admin: Show edit form
     */
    public function edit(Article $article)
    {
        $this->authorize('update', $article);

        $categories = ArticleCategory::where('is_active', true)->get();
        $tags = Tag::all();
        $article->load('tags');

        return view('admin.articles.edit', compact('article', 'categories', 'tags'));
    }

    /**
     * Admin: Update article
     */
    public function update(ArticleRequest $request, Article $article)
    {
        $this->authorize('update', $article);

        $data = $request->validated();

        // Handle thumbnail
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($article->thumbnail && Storage::disk('public')->exists('articles/' . $article->thumbnail)) {
                Storage::disk('public')->delete('articles/' . $article->thumbnail);
            }

            $file = $request->file('thumbnail');
            $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('articles', $filename, 'public');
            $data['thumbnail'] = $filename;
        }

        // Create slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        if ($data['status'] === 'published' && $article->status !== 'published') {
            $data['published_at'] = now();
        }

        $article->update($data);

        // Sync tags
        if ($request->filled('tags')) {
            $article->tags()->sync($request->tags);
        } else {
            $article->tags()->detach();
        }

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil diperbarui.');
    }

    /**
     * Admin: Delete article
     */
    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);

        // Delete thumbnail
        if ($article->thumbnail && Storage::disk('public')->exists('articles/' . $article->thumbnail)) {
            Storage::disk('public')->delete('articles/' . $article->thumbnail);
        }

        $article->delete();

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil dihapus.');
    }

    /**
     * Admin: Toggle article status
     */
    public function toggleStatus(Request $request, Article $article)
    {
        $this->authorize('publish', $article);

        $status = $request->status;

        if ($status === 'published') {
            $article->published_at = now();
        }

        $article->status = $status;
        $article->save();

        return redirect()->back()
            ->with('success', 'Status artikel berhasil diubah.');
    }

    /**
     * API: Get article data for editor
     */
    public function getArticleData(Article $article)
    {
        $this->authorize('view', $article);
        $article->load(['category', 'tags']);
        return response()->json($article);
    }
}