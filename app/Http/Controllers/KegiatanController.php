<?php
// app/Http/Controllers/KegiatanController.php

namespace App\Http\Controllers;

use App\Models\KegiatanPosyandu;
use App\Models\Balita;
use App\Models\HasilPelayanan;
use App\Http\Requests\KegiatanRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = KegiatanPosyandu::with(['user', 'pelayanan']);

        // Kader only sees their own activities
        if ($user->role === 'user') {
            $query->where('user_id', $user->id);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_kegiatan', 'like', "%{$search}%")
                    ->orWhere('lokasi', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by month
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        // Filter by year
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        // Sorting
        $sortField = $request->get('sort', 'tanggal');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $kegiatan = $query->paginate(10);

        // Stats
        $stats = [
            'total' => KegiatanPosyandu::when($user->role === 'user', function ($q) use ($user) {
                return $q->where('user_id', $user->id);
            })->count(),
            'terjadwal' => KegiatanPosyandu::when($user->role === 'user', function ($q) use ($user) {
                return $q->where('user_id', $user->id);
            })->where('status', 'terjadwal')->count(),
            'berlangsung' => KegiatanPosyandu::when($user->role === 'user', function ($q) use ($user) {
                return $q->where('user_id', $user->id);
            })->where('status', 'berlangsung')->count(),
            'selesai' => KegiatanPosyandu::when($user->role === 'user', function ($q) use ($user) {
                return $q->where('user_id', $user->id);
            })->where('status', 'selesai')->count(),
        ];

        // Get months for filter
        $months = [];
        for ($m = 1; $m <= 12; $m++) {
            $months[$m] = date('F', mktime(0, 0, 0, $m, 1));
        }

        // Get years for filter (SQLite tidak mendukung fungsi YEAR())
        $years = KegiatanPosyandu::pluck('tanggal')
            ->map(fn($tanggal) => $tanggal->year)
            ->unique()
            ->sortDesc()
            ->values()
            ->toArray();

        return view('kegiatan.index', compact('kegiatan', 'stats', 'months', 'years'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(!in_array(auth()->user()->role, ['admin', 'pegawai']), 403, 'Unauthorized access.');
        return view('kegiatan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KegiatanRequest $request)
    {
        abort_if(!in_array(auth()->user()->role, ['admin', 'pegawai']), 403, 'Unauthorized access.');

        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $data['penanggung_jawab'] = Auth::user()->name;

        KegiatanPosyandu::create($data);

        return redirect()->route(auth()->user()->role . '.kegiatan.index')
            ->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(KegiatanPosyandu $kegiatan)
    {
        // $this->authorize('view', $kegiatan);

        // Load relationships
        $kegiatan->load([
            'user',
            'pelayanan' => function ($query) {
                $query->with(['balita.warga', 'user'])->latest();
            }
        ]);

        // Get all balita in the area for attendance tracking
        $allBalita = Balita::with('warga')->get();

        // Get attended balita IDs
        $hadirIds = $kegiatan->pelayanan->pluck('balita_id')->toArray();

        // Prepare peserta data
        $peserta = $allBalita->map(function ($balita) use ($hadirIds, $kegiatan) {
            $pelayanan = $kegiatan->pelayanan->where('balita_id', $balita->id)->first();
            return [
                'balita' => $balita,
                'hadir' => in_array($balita->id, $hadirIds),
                'pelayanan' => $pelayanan,
            ];
        });

        // Summary statistics
        $summary = [
            'total_balita' => $allBalita->count(),
            'hadir' => $kegiatan->pelayanan->count(),
            'tidak_hadir' => $allBalita->count() - $kegiatan->pelayanan->count(),
            'pelayanan_selesai' => $kegiatan->pelayanan->count(),
        ];

        // Nutrition summary from this activity
        $nutritionSummary = [
            'normal' => $kegiatan->pelayanan->where('status_gizi', 'normal')->count(),
            'kurang' => $kegiatan->pelayanan->where('status_gizi', 'kurang')->count(),
            'buruk' => $kegiatan->pelayanan->where('status_gizi', 'buruk')->count(),
            'lebih' => $kegiatan->pelayanan->where('status_gizi', 'lebih')->count(),
            'vitamin' => $kegiatan->pelayanan->whereNotNull('vitamin')->count(),
            'imunisasi' => $kegiatan->pelayanan->whereNotNull('imunisasi')->count(),
        ];

        // Timeline
        $timeline = $this->getTimeline($kegiatan);

        return view('kegiatan.show', compact('kegiatan', 'peserta', 'summary', 'nutritionSummary', 'timeline'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KegiatanPosyandu $kegiatan)
    {
        abort_if(!in_array(auth()->user()->role, ['admin', 'pegawai']), 403, 'Unauthorized access.');
        return view('kegiatan.edit', compact('kegiatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KegiatanRequest $request, KegiatanPosyandu $kegiatan)
    {
        abort_if(!in_array(auth()->user()->role, ['admin', 'pegawai']), 403, 'Unauthorized access.');

        $data = $request->validated();
        $data['penanggung_jawab'] = Auth::user()->name;
        
        $kegiatan->update($data);

        return redirect()->route(auth()->user()->role . '.kegiatan.index')
            ->with('success', 'Kegiatan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KegiatanPosyandu $kegiatan)
    {
        abort_if(!in_array(auth()->user()->role, ['admin', 'pegawai']), 403, 'Unauthorized access.');

        DB::beginTransaction();
        try {
            // Delete related pelayanan
            $kegiatan->pelayanan()->delete();
            $kegiatan->delete();

            DB::commit();

            return redirect()->route(auth()->user()->role . '.kegiatan.index')
                ->with('success', 'Kegiatan berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus kegiatan.');
        }
    }

    /**
     * Update kegiatan status
     */
    public function updateStatus(Request $request, KegiatanPosyandu $kegiatan)
    {
        abort_if(!in_array(auth()->user()->role, ['admin', 'pegawai']), 403, 'Unauthorized access.');

        $request->validate([
            'status' => ['required', 'in:terjadwal,berlangsung,selesai,dibatalkan'],
        ]);

        $kegiatan->status = $request->status;
        $kegiatan->save();

        return redirect()->route(auth()->user()->role . '.kegiatan.show', $kegiatan)
            ->with('success', 'Status kegiatan berhasil diperbarui.');
    }

    /**
     * Get timeline for kegiatan
     */
    private function getTimeline($kegiatan)
    {
        $timeline = [];

        // Kegiatan dibuat
        $timeline[] = [
            'tanggal' => $kegiatan->created_at,
            'title' => 'Kegiatan Dibuat',
            'description' => 'Kegiatan "' . $kegiatan->nama_kegiatan . '" telah dibuat oleh ' . $kegiatan->user->name,
            'icon' => 'plus',
            'color' => 'blue',
        ];

        // Jika sudah berlangsung
        if (in_array($kegiatan->status, ['berlangsung', 'selesai'])) {
            $jamMulaiStr = $kegiatan->jam_mulai ? (is_string($kegiatan->jam_mulai) ? $kegiatan->jam_mulai : $kegiatan->jam_mulai->format('H:i:s')) : '08:00:00';
            $waktuMulai = \Carbon\Carbon::parse($kegiatan->tanggal->format('Y-m-d') . ' ' . $jamMulaiStr);

            $timeline[] = [
                'tanggal' => $waktuMulai,
                'title' => 'Kegiatan Dimulai',
                'description' => 'Kegiatan dimulai pada ' . $kegiatan->tanggal_formatted . ' pukul ' . date('H:i', strtotime($jamMulaiStr)),
                'icon' => 'play',
                'color' => 'green',
            ];
        }

        // Pelayanan
        if ($kegiatan->pelayanan->count() > 0) {
            $timeline[] = [
                'tanggal' => $kegiatan->pelayanan->first()->created_at,
                'title' => 'Pelayanan Dilakukan',
                'description' => 'Sebanyak ' . $kegiatan->pelayanan->count() . ' balita telah mendapatkan pelayanan',
                'icon' => 'clipboard',
                'color' => 'purple',
            ];
        }

        // Jika selesai
        if ($kegiatan->status === 'selesai') {
            $timeline[] = [
                'tanggal' => $kegiatan->updated_at,
                'title' => 'Kegiatan Selesai',
                'description' => 'Kegiatan telah selesai dilaksanakan',
                'icon' => 'check',
                'color' => 'green',
            ];
        }

        // Jika dibatalkan
        if ($kegiatan->status === 'dibatalkan') {
            $timeline[] = [
                'tanggal' => $kegiatan->updated_at,
                'title' => 'Kegiatan Dibatalkan',
                'description' => 'Kegiatan telah dibatalkan',
                'icon' => 'x',
                'color' => 'red',
            ];
        }

        // Sort by date
        usort($timeline, function ($a, $b) {
            return $a['tanggal'] <=> $b['tanggal'];
        });

        return $timeline;
    }

    /**
     * Export to Excel
     */
    public function exportExcel(Request $request)
    {
        abort_if(!in_array(auth()->user()->role, ['admin', 'pegawai']), 403, 'Unauthorized access.');
        // Implement Excel export
        // return Excel::download(new KegiatanExport($request), 'kegiatan.xlsx');
    }

    /**
     * Export to PDF
     */
    public function exportPdf(Request $request)
    {
        abort_if(!in_array(auth()->user()->role, ['admin', 'pegawai']), 403, 'Unauthorized access.');
        // Implement PDF export
        // $kegiatan = KegiatanPosyandu::with(['user', 'pelayanan'])->get();
        // $pdf = PDF::loadView('kegiatan.pdf', compact('kegiatan'));
        // return $pdf->download('kegiatan.pdf');
    }

    /**
     * Print attendance list
     */
    public function printAbsensi(KegiatanPosyandu $kegiatan)
    {
        // $this->authorize('view', $kegiatan);

        $kegiatan->load(['pelayanan.balita.warga', 'user']);

        return view('kegiatan.print-absensi', compact('kegiatan'));
    }
}