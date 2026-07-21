<?php
// app/Http/Controllers/BalitaController.php

namespace App\Http\Controllers;

use App\Models\Balita;
use App\Models\Warga;
use App\Models\PemeriksaanBalita;
use App\Models\ImunisasiBalita;
use App\Models\VitaminBalita;
use App\Models\PerkembanganBalita;
use App\Http\Requests\BalitaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BalitaController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Balita::with(['warga', 'warga.user', 'pemeriksaanTerakhir']);

        // ========================================
        // ROLE-BASED ACCESS CONTROL
        // ========================================
        if ($user->role === 'admin') {
            // Admin: melihat SEMUA balita
            // Tidak ada filter tambahan
        } elseif ($user->role === 'user') {
            // Kader: hanya melihat balita BINAANNYA
            $query->whereHas('warga', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        } elseif ($user->role === 'warga') {
            // Warga: hanya melihat balita MILIKNYA SENDIRI
            $warga = $user->warga;
            if ($warga) {
                $query->where('warga_id', $warga->id);
            } else {
                // Jika warga belum punya data, return empty
                return view('Admin.Balita.index', [
                    'balita' => collect(),
                    'stats' => $this->getEmptyStats(),
                    'wargaList' => collect(),
                    'routePrefix' => $user->role . '.balita.',
                ]);
            }
        }

        // ========================================
        // SEARCH
        // ========================================
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhereHas('warga', function ($w) use ($search) {
                        $w->where('nama', 'like', "%{$search}%")
                            ->orWhere('nik', 'like', "%{$search}%");
                    });
            });
        }

        // ========================================
        // FILTERS
        // ========================================
        // Filter by gender
        if ($request->filled('gender')) {
            $query->where('jenis_kelamin', $request->gender);
        }

        // Filter by nutrition status
        if ($request->filled('gizi')) {
            $query->whereHas('pemeriksaanTerakhir', function ($q) use ($request) {
                $q->where('status_gizi', $request->gizi);
            });
        }

        // Filter by age range
        if ($request->filled('age_from')) {
            $query->where('tanggal_lahir', '<=', now()->subMonths((int) $request->age_from));
        }
        if ($request->filled('age_to')) {
            $query->where('tanggal_lahir', '>=', now()->subMonths((int) $request->age_to));
        }

        // ========================================
        // SORTING
        // ========================================
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $balita = $query->paginate(10);

        // ========================================
        // STATISTICS
        // ========================================
        $stats = $this->getStats($user);

        // ========================================
        // WARGA LIST FOR FILTER
        // ========================================
        $wargaList = $this->getWargaList($user);

        // ========================================
        // ROUTE PREFIX
        // ========================================
        $routePrefix = $user->role . '.balita.';

        return view('Admin.Balita.index', compact('balita', 'stats', 'wargaList', 'routePrefix'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $this->authorize('create', Balita::class);

        $user = Auth::user();

        // Get warga list based on role
        $wargaList = $this->getWargaList($user);

        // If warga_id is passed from URL
        $selectedWarga = $request->warga_id ? Warga::find($request->warga_id) : null;
        
        // For warga role, pre-select their own warga
        if ($user->role === 'warga' && $user->warga) {
            $selectedWarga = $user->warga;
        }

        $routePrefix = $user->role . '.balita.';

        return view('Admin.Balita.create', compact('wargaList', 'selectedWarga', 'routePrefix'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BalitaRequest $request)
    {
        $this->authorize('create', Balita::class);

        $data = $request->validated();

        // Verify warga belongs to user
        $warga = Warga::find($data['warga_id']);
        if (!$warga) {
            return back()->with('error', 'Data warga tidak ditemukan.');
        }

        $user = Auth::user();
        
        // ========================================
        // AUTHORIZATION BASED ON ROLE
        // ========================================
        if ($user->role === 'user' && $warga->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }
        
        if ($user->role === 'warga' && $warga->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        // Automatically verify since this is added by Admin/Pegawai
        $data['is_verified'] = true;

        $balita = Balita::create($data);

        // Auto-sync ke tabel Anak agar muncul di halaman Profil/Warga (Single Source of Truth)
        \App\Models\Anak::firstOrCreate([
            'warga_id' => $data['warga_id'],
            'nama' => $data['nama'],
        ], [
            'nik' => $data['nik'] ?? null,
            'tanggal_lahir' => $data['tanggal_lahir'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'status_anak' => 'aktif',
        ]);

        return redirect()->route($user->role . '.balita.index')
            ->with('success', 'Data balita berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Balita $balita)
    {
        $this->authorize('view', $balita);

        $balita->load([
            'warga',
            'warga.user',
            'pemeriksaan' => function ($query) {
                $query->with(['pegawai'])->take(10);
            },
            'pemeriksaanTerakhir',
            'imunisasi',
            'vitamin',
            'perkembangan'
        ]);

        // Get growth data for charts
        $growthData = $this->getGrowthData($balita);
        $routePrefix = Auth::user()->role . '.balita.';

        return view('Admin.Balita.show', compact('balita', 'growthData', 'routePrefix'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Balita $balita)
    {
        $this->authorize('update', $balita);

        $user = Auth::user();
        $wargaList = $this->getWargaList($user);
        $routePrefix = $user->role . '.balita.';

        return view('Admin.Balita.edit', compact('balita', 'wargaList', 'routePrefix'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BalitaRequest $request, Balita $balita)
    {
        $this->authorize('update', $balita);

        $data = $request->validated();

        // Verify warga belongs to user
        $warga = Warga::find($data['warga_id']);
        if (!$warga) {
            return back()->with('error', 'Data warga tidak ditemukan.');
        }

        $user = Auth::user();
        
        if ($user->role === 'user' && $warga->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }
        
        if ($user->role === 'warga' && $warga->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        $oldNama = $balita->getOriginal('nama');
        $balita->update($data);

        // Auto-sync update ke tabel Anak jika namanya sama
        $anak = \App\Models\Anak::where('warga_id', $warga->id)->where('nama', $oldNama)->first();
        if ($anak) {
            $anak->update([
                'nama' => $data['nama'],
                'nik' => $data['nik'] ?? $anak->nik,
                'tanggal_lahir' => $data['tanggal_lahir'],
                'jenis_kelamin' => $data['jenis_kelamin'],
            ]);
        }

        return redirect()->route($user->role . '.balita.index')
            ->with('success', 'Data balita berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Balita $balita)
    {
        $this->authorize('delete', $balita);

        DB::beginTransaction();
        try {
            // Delete related pelayanan
            $balita->pemeriksaan()->delete();
            $balita->imunisasi()->delete();
            $balita->vitamin()->delete();
            $balita->perkembangan()->delete();
            $balita->delete();

            DB::commit();

            return redirect()->route(Auth::user()->role . '.balita.index')
                ->with('success', 'Data balita berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus data balita.');
        }
    }

    /**
     * Verify the specified balita.
     */
    public function verify(Balita $balita)
    {
        $this->authorize('verify', $balita);

        $balita->update(['is_verified' => true]);

        return back()->with('success', 'Data balita berhasil diverifikasi.');
    }

    /**
     * Reject/Delete unverified balita.
     */
    public function reject(Balita $balita)
    {
        $this->authorize('verify', $balita);

        $balita->delete();

        return back()->with('success', 'Data balita ditolak dan dihapus.');
    }

    /**
     * Get growth data for charts
     */
    private function getGrowthData($balita)
    {
        $pelayanan = $balita->pemeriksaan()->orderBy('tanggal_pemeriksaan')->get();

        return [
            'dates' => $pelayanan->pluck('tanggal_pemeriksaan')->map(function ($date) {
                return $date->format('d M Y');
            })->toArray(),
            'berat_badan' => $pelayanan->pluck('berat_badan')->toArray(),
            'tinggi_badan' => $pelayanan->pluck('tinggi_badan')->toArray(),
            'lingkar_kepala' => $pelayanan->pluck('lingkar_kepala')->toArray(),
        ];
    }

    /**
     * Get stats based on user role
     */
    private function getStats($user)
    {
        $query = Balita::query();
        
        if ($user->role === 'user') {
            $query->whereHas('warga', function ($w) use ($user) {
                $w->where('user_id', $user->id);
            });
        } elseif ($user->role === 'warga') {
            $warga = $user->warga;
            if ($warga) {
                $query->where('warga_id', $warga->id);
            } else {
                return $this->getEmptyStats();
            }
        }

        return [
            'total' => (clone $query)->count(),
            'laki_laki' => (clone $query)->where('jenis_kelamin', 'L')->count(),
            'perempuan' => (clone $query)->where('jenis_kelamin', 'P')->count(),
            'gizi_baik' => (clone $query)->whereHas('pemeriksaanTerakhir', function ($q) {
                $q->where('status_gizi', 'normal');
            })->count(),
            'gizi_kurang' => (clone $query)->whereHas('pemeriksaanTerakhir', function ($q) {
                $q->where('status_gizi', 'kurang');
            })->count(),
            'gizi_buruk' => (clone $query)->whereHas('pemeriksaanTerakhir', function ($q) {
                $q->where('status_gizi', 'buruk');
            })->count(),
        ];
    }

    /**
     * Get empty stats
     */
    private function getEmptyStats()
    {
        return [
            'total' => 0,
            'laki_laki' => 0,
            'perempuan' => 0,
            'gizi_baik' => 0,
            'gizi_kurang' => 0,
            'gizi_buruk' => 0,
        ];
    }

    /**
     * Get warga list based on user role
     */
    private function getWargaList($user)
    {
        if (in_array($user->role, ['admin', 'pegawai'])) {
            return Warga::orderBy('nama')->get();
        } elseif ($user->role === 'user') {
            return Warga::where('user_id', $user->id)->orderBy('nama')->get();
        }
        return collect();
    }

    /**
     * Export to Excel
     */
    public function exportExcel(Request $request)
    {
        // Implement Excel export
    }

    /**
     * Export to PDF
     */
    public function exportPdf(Request $request)
    {
        // Implement PDF export
    }
}