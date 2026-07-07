<?php
// app/Http/Controllers/FaqController.php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Http\Requests\FaqRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class FaqController extends Controller
{
    /**
     * Display public FAQ page
     */
    public function index(Request $request)
    {
        $query = Faq::published()->ordered();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('question', 'like', "%{$search}%")
                  ->orWhere('answer', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $faqs = $query->get();

        // Get popular FAQs
        $popularFaqs = Cache::remember('popular_faqs', 3600, function () {
            return Faq::published()
                ->orderBy('views', 'desc')
                ->limit(5)
                ->get();
        });

        // Get categories for filter
        $categories = Faq::getCategoryList();

        return view('public.faq', compact('faqs', 'popularFaqs', 'categories'));
    }

    /**
     * Admin: Display FAQ list
     */
    public function adminIndex(Request $request)
    {
        $this->authorize('viewAny', Faq::class);

        $query = Faq::query();

        // Search
        if ($request->filled('search')) {
            $query->where('question', 'like', "%{$request->search}%");
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $query->orderBy('sort_order')->orderBy('created_at', 'desc');

        $faqs = $query->paginate(10);
        $categories = Faq::getCategoryList();

        return view('admin.faq.index', compact('faqs', 'categories'));
    }

    /**
     * Admin: Show create form
     */
    public function create()
    {
        $this->authorize('create', Faq::class);

        $categories = Faq::getCategoryList();

        return view('admin.faq.create', compact('categories'));
    }

    /**
     * Admin: Store FAQ
     */
    public function store(FaqRequest $request)
    {
        $this->authorize('create', Faq::class);

        $data = $request->validated();

        if (empty($data['sort_order'])) {
            $data['sort_order'] = Faq::max('sort_order') + 1;
        }

        Faq::create($data);

        // Clear cache
        Cache::forget('popular_faqs');

        return redirect()->route('admin.faq.index')
            ->with('success', 'FAQ berhasil ditambahkan.');
    }

    /**
     * Admin: Show edit form
     */
    public function edit(Faq $faq)
    {
        $this->authorize('update', $faq);

        $categories = Faq::getCategoryList();

        return view('admin.faq.edit', compact('faq', 'categories'));
    }

    /**
     * Admin: Update FAQ
     */
    public function update(FaqRequest $request, Faq $faq)
    {
        $this->authorize('update', $faq);

        $faq->update($request->validated());

        // Clear cache
        Cache::forget('popular_faqs');

        return redirect()->route('admin.faq.index')
            ->with('success', 'FAQ berhasil diperbarui.');
    }

    /**
     * Admin: Delete FAQ
     */
    public function destroy(Faq $faq)
    {
        $this->authorize('delete', $faq);

        $faq->delete();

        // Clear cache
        Cache::forget('popular_faqs');

        return redirect()->route('admin.faq.index')
            ->with('success', 'FAQ berhasil dihapus.');
    }

    /**
     * Admin: Publish FAQ
     */
    public function publish(Faq $faq)
    {
        $this->authorize('publish', $faq);

        $faq->status = 'published';
        $faq->save();

        // Clear cache
        Cache::forget('popular_faqs');

        return redirect()->back()
            ->with('success', 'FAQ berhasil dipublikasikan.');
    }

    /**
     * Admin: Unpublish FAQ
     */
    public function unpublish(Faq $faq)
    {
        $this->authorize('publish', $faq);

        $faq->status = 'draft';
        $faq->save();

        // Clear cache
        Cache::forget('popular_faqs');

        return redirect()->back()
            ->with('success', 'FAQ berhasil di-unpublish.');
    }

    /**
     * Admin: Toggle featured status
     */
    public function toggleFeatured(Faq $faq)
    {
        $this->authorize('update', $faq);

        $faq->is_featured = !$faq->is_featured;
        $faq->save();

        // Clear cache
        Cache::forget('popular_faqs');

        return redirect()->back()
            ->with('success', 'Status populer berhasil diubah.');
    }

    /**
     * Admin: Reorder FAQs
     */
    public function reorder(Request $request)
    {
        $this->authorize('update', Faq::class);

        $orders = $request->orders;

        foreach ($orders as $order) {
            Faq::where('id', $order['id'])->update(['sort_order' => $order['order']]);
        }

        return response()->json(['success' => true]);
    }
}