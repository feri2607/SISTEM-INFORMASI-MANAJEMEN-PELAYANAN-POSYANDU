<?php
// app/Http/Controllers/AnnouncementController.php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\AnnouncementCategory;
use App\Http\Requests\AnnouncementRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AnnouncementController extends Controller
{
    /**
     * Display public announcements list
     */
    public function index(Request $request)
    {
        $query = Announcement::with(['category', 'user'])
            ->where(function ($q) {
                $q->where('status', 'published')
                  ->orWhere(function ($q2) {
                      // scheduled announcements whose publish time has arrived
                      $q2->where('status', 'scheduled')
                         ->where('publish_at', '<=', now());
                  });
            })
            ->where(function ($q) {
                // Not yet expired
                $q->whereNull('expire_at')
                  ->orWhere('expire_at', '>=', now());
            });


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

        // Filter by priority
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
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
                $query->whereRaw("strftime('%m', publish_at) = ?", [$month]);
            } else {
                $query->whereMonth('publish_at', $request->bulan);
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
                $query->whereRaw("strftime('%Y', publish_at) = ?", [$request->tahun]);
            } else {
                $query->whereYear('publish_at', $request->tahun);
            }
        }

        // Sort
        $sort = $request->get('sort', 'terbaru');
        if ($sort === 'terbaru') {
            $query->orderBy('publish_at', 'desc');
        } elseif ($sort === 'terlama') {
            $query->orderBy('publish_at', 'asc');
        } elseif ($sort === 'prioritas') {
            $query->orderByRaw("FIELD(priority, 'very_important', 'important', 'normal')");
        }

        // Prioritaskan pengumuman penting
        $importantAnnouncements = (clone $query)
            ->whereIn('priority', ['important', 'very_important'])
            ->get();

        $announcements = $query->paginate(9);

        // Categories for filter
        $categories = AnnouncementCategory::where('is_active', true)->get();

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
            $years = Announcement::where('status', 'published')
                ->selectRaw("DISTINCT strftime('%Y', publish_at) as year")
                ->orderBy('year', 'desc')
                ->pluck('year')
                ->map(fn($y) => (int) $y)
                ->toArray();
        } else {
            $years = Announcement::where('status', 'published')
                ->selectRaw('DISTINCT YEAR(publish_at) as year')
                ->orderBy('year', 'desc')
                ->pluck('year')
                ->toArray();
        }

        return view('public.announcements', compact(
            'announcements',
            'importantAnnouncements',
            'categories',
            'months',
            'years'
        ));
    }

    /**
     * Display announcement detail
     */
    public function show($slug)
    {
        $announcement = Announcement::with(['category', 'user'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Check if announcement is accessible
        if ($announcement->status !== 'published') {
            abort(404);
        }

        // Increment views
        $announcement->incrementViews();

        // Related announcements
        $relatedAnnouncements = $announcement->getRelatedAnnouncements();

        // Latest announcements
        $latestAnnouncements = Announcement::where('status', 'published')
            ->where(function ($query) {
                $query->whereNull('publish_at')
                      ->orWhere('publish_at', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('expire_at')
                      ->orWhere('expire_at', '>=', now());
            })
            ->orderBy('publish_at', 'desc')
            ->limit(5)
            ->get();

        return view('public.announcement-detail', compact(
            'announcement',
            'relatedAnnouncements',
            'latestAnnouncements'
        ));
    }

    /**
     * Admin: Display announcements list
     */
    public function adminIndex(Request $request)
    {
        $this->authorize('viewAny', Announcement::class);

        $query = Announcement::with(['category', 'user']);

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

        // Filter by priority
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        $query->orderBy('created_at', 'desc');

        $announcements = $query->paginate(10);
        $categories = AnnouncementCategory::where('is_active', true)->get();

        return view('admin.announcements.index', compact('announcements', 'categories'));
    }

    /**
     * Admin: Display announcement detail
     */
    public function adminShow(Announcement $announcement)
    {
        $this->authorize('view', $announcement);
        return view('admin.announcements.show', compact('announcement'));
    }

    /**
     * Admin: Show create form
     */
    public function create()
    {
        $this->authorize('create', Announcement::class);

        $categories = AnnouncementCategory::where('is_active', true)->get();

        return view('admin.announcements.create', compact('categories'));
    }

    /**
     * Admin: Store announcement
     */
    public function store(AnnouncementRequest $request)
    {
        $this->authorize('create', Announcement::class);

        $data = $request->validated();

        // Handle attachment
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('announcements', $filename, 'public');
            $data['attachment'] = $filename;
        }

        // Create slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $data['user_id'] = Auth::id();

        // Handle scheduling
        if ($data['status'] === 'scheduled' && empty($data['publish_at'])) {
            $data['publish_at'] = now()->addDay();
        }

        if ($data['status'] === 'published' && empty($data['publish_at'])) {
            $data['publish_at'] = now();
        }

        Announcement::create($data);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil dibuat.');
    }

    /**
     * Admin: Show edit form
     */
    public function edit(Announcement $announcement)
    {
        $this->authorize('update', $announcement);

        $categories = AnnouncementCategory::where('is_active', true)->get();

        return view('admin.announcements.edit', compact('announcement', 'categories'));
    }

    /**
     * Admin: Update announcement
     */
    public function update(AnnouncementRequest $request, Announcement $announcement)
    {
        $this->authorize('update', $announcement);

        $data = $request->validated();

        // Handle attachment
        if ($request->hasFile('attachment')) {
            // Delete old attachment
            if ($announcement->attachment && Storage::disk('public')->exists('announcements/' . $announcement->attachment)) {
                Storage::disk('public')->delete('announcements/' . $announcement->attachment);
            }

            $file = $request->file('attachment');
            $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('announcements', $filename, 'public');
            $data['attachment'] = $filename;
        }

        // Create slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Handle scheduling
        if ($data['status'] === 'scheduled' && empty($data['publish_at'])) {
            $data['publish_at'] = now()->addDay();
        }

        if ($data['status'] === 'published' && empty($data['publish_at'])) {
            $data['publish_at'] = now();
        }

        $announcement->update($data);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil diperbarui.');
    }

    /**
     * Admin: Delete announcement
     */
    public function destroy(Announcement $announcement)
    {
        $this->authorize('delete', $announcement);

        // Delete attachment
        if ($announcement->attachment && Storage::disk('public')->exists('announcements/' . $announcement->attachment)) {
            Storage::disk('public')->delete('announcements/' . $announcement->attachment);
        }

        $announcement->delete();

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }

    /**
     * Admin: Publish announcement
     */
    public function publish(Announcement $announcement)
    {
        $this->authorize('publish', $announcement);

        $announcement->status = 'published';
        if (empty($announcement->publish_at)) {
            $announcement->publish_at = now();
        }
        $announcement->save();

        return redirect()->back()
            ->with('success', 'Pengumuman berhasil dipublikasikan.');
    }

    /**
     * Admin: Unpublish announcement
     */
    public function unpublish(Announcement $announcement)
    {
        $this->authorize('publish', $announcement);

        $announcement->status = 'draft';
        $announcement->save();

        return redirect()->back()
            ->with('success', 'Pengumuman berhasil di-unpublish.');
    }

    /**
     * Admin: Archive announcement
     */
    public function archive(Announcement $announcement)
    {
        $this->authorize('publish', $announcement);

        $announcement->status = 'archived';
        $announcement->save();

        return redirect()->back()
            ->with('success', 'Pengumuman berhasil diarsipkan.');
    }
}