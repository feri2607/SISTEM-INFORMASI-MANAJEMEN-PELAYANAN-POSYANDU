<?php
// app/Http/Controllers/HasilPelayananController.php

namespace App\Http\Controllers;

use App\Models\HasilPelayanan;
use App\Models\KegiatanPosyandu;
use App\Models\Balita;
use App\Models\User;
use App\Http\Requests\PelayananRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HasilPelayananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = HasilPelayanan::with(['balita.warga', 'kegiatan', 'user']);

        // Kader only sees their own services
        if ($user->role === 'user') {
            $query->where('user_id', $user->id);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('balita', function ($b) use ($search) {
                    $b->where('nama', 'like', "%{$search}%")
                        ->orWhereHas('warga', function ($w) use ($search) {
                            $w->where('nama', 'like', "%{$search}%");
                        });
                })->orWhereHas('kegiatan', function ($k) use ($search) {
                    $k->where('nama_kegiatan', 'like', "%{$search}%");
                });
            });
        }

        // Filter by month
        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->bulan);
        }

        // Filter by year
        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        // Filter by kegiatan
        if ($request->filled('kegiatan_id')) {
            $query->where('kegiatan_id', $request->kegiatan_id);
        }

        // Filter by status gizi
        if ($request->filled('status_gizi')) {
            $query->where('status_gizi', $request->status_gizi);
        }

        // Filter by petugas
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $pelayanan = $query->paginate(10);

        // Stats
        $stats = [
            'total' => HasilPelayanan::when($user->role === 'user', function ($q) use ($user) {
                return $q->where('user_id', $user->id);
            })->count(),
            'bulan_ini' => HasilPelayanan::when($user->role === 'user', function ($q) use ($user) {
                return $q->where('user_id', $user->id);
            })->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'gizi_baik' => HasilPelayanan::when($user->role === 'user', function ($q) use ($user) {
                return $q->where('user_id', $user->id);
            })->where('status_gizi', 'normal')->count(),
            'gizi_kurang' => HasilPelayanan::when($user->role === 'user', function ($q) use ($user) {
                return $q->where('user_id', $user->id);
            })->where('status_gizi', 'kurang')->count(),
            'gizi_buruk' => HasilPelayanan::when($user->role === 'user', function ($q) use ($user) {
                return $q->where('user_id', $user->id);
            })->where('status_gizi', 'buruk')->count(),
        ];

        // Get filter options
        $kegiatanList = KegiatanPosyandu::orderBy('tanggal', 'desc')->get();
        $petugasList = User::where('role', 'user')->orderBy('name')->get();

        $months = [];
        for ($m = 1; $m <= 12; $m++) {
            $months[$m] = date('F', mktime(0, 0, 0, $m, 1));
        }

  
        $years = HasilPelayanan::selectRaw("DISTINCT strftime('%Y', created_at) as year")
                       ->orderBy('year', 'desc')
                       ->get();


        return view('pelayanan.index', compact(
            'pelayanan',
            'stats',
            'kegiatanList',
            'petugasList',
            'months',
            'years'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $this->authorize('create', HasilPelayanan::class);

        $kegiatanList = KegiatanPosyandu::where('status', '!=', 'dibatalkan')
            ->orderBy('tanggal', 'desc')
            ->get();

        $selectedKegiatan = $request->kegiatan_id ? KegiatanPosyandu::find($request->kegiatan_id) : null;
        $selectedBalita = $request->balita_id ? Balita::find($request->balita_id) : null;

        return view('pelayanan.create', compact(
            'kegiatanList',
            'selectedKegiatan',
            'selectedBalita'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PelayananRequest $request)
    {
        $this->authorize('create', HasilPelayanan::class);

        $data = $request->validated();

        // Get balita data
        $balita = Balita::with('warga')->find($data['balita_id']);
        if (!$balita) {
            return back()->with('error', 'Data balita tidak ditemukan.');
        }

        // Calculate nutrition status
        $statusGizi = $this->hitungStatusGizi(
            $balita,
            $data['berat_badan'],
            $data['tinggi_badan']
        );

        $data['status_gizi'] = $statusGizi;
        $data['user_id'] = Auth::id();

        // Convert arrays to JSON
        if (isset($data['imunisasi'])) {
            $data['imunisasi'] = json_encode($data['imunisasi']);
        }
        if (isset($data['vitamin'])) {
            $data['vitamin'] = json_encode($data['vitamin']);
        }

        HasilPelayanan::create($data);

        return redirect()->route('admin.pelayanan.index')
            ->with('success', 'Data pelayanan berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(HasilPelayanan $pelayanan)
    {
        $this->authorize('view', $pelayanan);

        $pelayanan->load(['balita.warga', 'kegiatan', 'user']);

        // Get growth history for chart
        $growthData = $this->getGrowthData($pelayanan->balita);

        return view('pelayanan.show', compact('pelayanan', 'growthData'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HasilPelayanan $pelayanan)
    {
        $this->authorize('update', $pelayanan);

        $kegiatanList = KegiatanPosyandu::where('status', '!=', 'dibatalkan')
            ->orderBy('tanggal', 'desc')
            ->get();

        $balitaList = Balita::with('warga')->get();

        return view('pelayanan.edit', compact('pelayanan', 'kegiatanList', 'balitaList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PelayananRequest $request, HasilPelayanan $pelayanan)
    {
        $this->authorize('update', $pelayanan);

        $data = $request->validated();

        // Recalculate nutrition status
        $balita = Balita::find($data['balita_id']);
        if ($balita) {
            $statusGizi = $this->hitungStatusGizi(
                $balita,
                $data['berat_badan'],
                $data['tinggi_badan']
            );
            $data['status_gizi'] = $statusGizi;
        }

        // Convert arrays to JSON
        if (isset($data['imunisasi'])) {
            $data['imunisasi'] = json_encode($data['imunisasi']);
        }
        if (isset($data['vitamin'])) {
            $data['vitamin'] = json_encode($data['vitamin']);
        }

        $pelayanan->update($data);

        return redirect()->route('admin.pelayanan.index')
            ->with('success', 'Data pelayanan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HasilPelayanan $pelayanan)
    {
        $this->authorize('delete', $pelayanan);

        $pelayanan->delete();

        return redirect()->route('admin.pelayanan.index')
            ->with('success', 'Data pelayanan berhasil dihapus.');
    }

    /**
     * Calculate nutrition status based on WHO standards
     */
    private function hitungStatusGizi($balita, $beratBadan, $tinggiBadan)
    {
        // Simplified WHO-based calculation
        // In production, use proper WHO standards with z-scores
        $umurBulan = $balita->umur_bulan;
        $jk = $balita->jenis_kelamin;

        // Calculate BMI
        $bmi = $beratBadan / (($tinggiBadan / 100) * ($tinggiBadan / 100));

        // Simple classification based on age and BMI
        // This is a simplified version - use proper WHO standards in production
        if ($umurBulan < 60) {
            // Under 5 years
            if ($bmi < 13) {
                return 'buruk';
            } elseif ($bmi < 14) {
                return 'kurang';
            } elseif ($bmi > 18) {
                return 'lebih';
            } else {
                return 'normal';
            }
        } else {
            // Above 5 years
            if ($bmi < 14) {
                return 'buruk';
            } elseif ($bmi < 16) {
                return 'kurang';
            } elseif ($bmi > 25) {
                return 'lebih';
            } else {
                return 'normal';
            }
        }
    }

    /**
     * Get growth data for charts
     */
    private function getGrowthData($balita)
    {
        $pelayanan = $balita->pelayanan()->orderBy('created_at')->get();

        return [
            'dates' => $pelayanan->pluck('created_at')->map(function ($date) {
                return $date->format('d M Y');
            })->toArray(),
            'berat_badan' => $pelayanan->pluck('berat_badan')->toArray(),
            'tinggi_badan' => $pelayanan->pluck('tinggi_badan')->toArray(),
            'lingkar_kepala' => $pelayanan->pluck('lingkar_kepala')->toArray(),
        ];
    }

    /**
     * Search balita for autocomplete
     */
    public function searchBalita(Request $request)
    {
        $search = $request->get('q');
        $user = Auth::user();

        $query = Balita::with('warga');

        if ($user->role === 'user') {
            $query->whereHas('warga', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhereHas('warga', function ($w) use ($search) {
                        $w->where('nama', 'like', "%{$search}%")
                            ->orWhere('nik', 'like', "%{$search}%");
                    });
            });
        }

        $balita = $query->limit(10)->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'nama' => $item->nama,
                'orang_tua' => $item->warga->nama,
                'nik' => $item->warga->nik,
                'umur' => $item->umur,
                'foto' => $item->foto_url,
            ];
        });

        return response()->json($balita);
    }

    /**
     * Get balita detail for preview
     */
    public function getBalitaDetail(Request $request)
    {
        $balita = Balita::with('warga')->find($request->balita_id);

        if (!$balita) {
            return response()->json(['error' => 'Balita not found'], 404);
        }

        return response()->json([
            'id' => $balita->id,
            'nama' => $balita->nama,
            'orang_tua' => $balita->warga->nama,
            'umur' => $balita->umur,
            'jenis_kelamin' => $balita->jenis_kelamin_label,
            'foto' => $balita->foto_url,
            'status_gizi_terakhir' => $balita->status_gizi_label,
        ]);
    }

    /**
     * Export to Excel
     */
    public function exportExcel(Request $request)
    {
        $this->authorize('export', HasilPelayanan::class);
        // Implement Excel export
        // return Excel::download(new PelayananExport($request), 'pelayanan.xlsx');
    }

    /**
     * Export to PDF
     */
    public function exportPdf(Request $request)
    {
        $this->authorize('export', HasilPelayanan::class);
        // Implement PDF export
        // $pelayanan = HasilPelayanan::with(['balita.warga', 'kegiatan', 'user'])->get();
        // $pdf = PDF::loadView('pelayanan.pdf', compact('pelayanan'));
        // return $pdf->download('pelayanan.pdf');
    }

    /**
     * Print pelayanan data
     */
    public function print(HasilPelayanan $pelayanan)
    {
        $this->authorize('view', $pelayanan);
        $pelayanan->load(['balita.warga', 'kegiatan', 'user']);
        return view('pelayanan.print', compact('pelayanan'));
    }

}