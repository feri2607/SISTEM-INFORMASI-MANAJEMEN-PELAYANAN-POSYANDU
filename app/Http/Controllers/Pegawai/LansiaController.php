<?php
// app/Http/Controllers/Pegawai/LansiaController.php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Lansia;
use App\Models\PemeriksaanLansia;
use App\Models\JadwalSenamLansia;
use App\Services\LansiaService;
use App\Http\Requests\PemeriksaanLansiaRequest;
use App\Http\Requests\JadwalSenamLansiaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LansiaController extends Controller
{
    use AuthorizesRequests;

    public function __construct(protected LansiaService $lansiaService) {}

    // =============================================
    // DASHBOARD
    // =============================================

    public function dashboard()
    {
        $stats = $this->lansiaService->getDashboardStats();

        $recentPemeriksaan = PemeriksaanLansia::with(['lansia', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $jadwalMendatang = JadwalSenamLansia::where('tanggal', '>=', now()->toDateString())
            ->where('status', 'aktif')
            ->orderBy('tanggal')
            ->limit(5)
            ->get();

        return view('pegawai.lansia.dashboard', compact('stats', 'recentPemeriksaan', 'jadwalMendatang'));
    }

    // =============================================
    // DATA LANSIA
    // =============================================

    public function index(Request $request)
    {
        $query = Lansia::with(['warga', 'pemeriksaan']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_verified', $request->status === 'verified');
        }

        if ($request->filled('gender')) {
            $query->where('jenis_kelamin', $request->gender);
        }

        $lansia = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('pegawai.lansia.index', compact('lansia'));
    }

    public function show(Lansia $lansia)
    {
        $lansia->load(['pemeriksaan.user', 'warga', 'verifiedBy']);
        $chartData = $this->lansiaService->getChartData($lansia);
        return view('pegawai.lansia.show', compact('lansia', 'chartData'));
    }

    // =============================================
    // PEMERIKSAAN
    // =============================================

    public function createPemeriksaan(Lansia $lansia)
    {
        return view('pegawai.lansia.pemeriksaan-create', compact('lansia'));
    }

    public function storePemeriksaan(PemeriksaanLansiaRequest $request)
    {
        DB::transaction(function () use ($request, &$pemeriksaan) {
            $pemeriksaan = $this->lansiaService->storePemeriksaan($request->validated());
        });

        app(\App\Services\KehadiranService::class)->markAsServed($pemeriksaan->lansia_id, \App\Models\Lansia::class);

        return redirect()->route('pegawai.lansia.show', $pemeriksaan->lansia_id)
            ->with('success', 'Data pemeriksaan berhasil disimpan. IMT otomatis dihitung.');
    }

    public function editPemeriksaan(PemeriksaanLansia $pemeriksaan)
    {
        $pemeriksaan->load('lansia');
        return view('pegawai.lansia.pemeriksaan-edit', compact('pemeriksaan'));
    }

    public function updatePemeriksaan(PemeriksaanLansiaRequest $request, PemeriksaanLansia $pemeriksaan)
    {
        DB::transaction(function () use ($request, $pemeriksaan) {
            $this->lansiaService->updatePemeriksaan($pemeriksaan, $request->validated());
        });

        return redirect()->route('pegawai.lansia.show', $pemeriksaan->lansia_id)
            ->with('success', 'Data pemeriksaan berhasil diperbarui.');
    }

    public function destroyPemeriksaan(PemeriksaanLansia $pemeriksaan)
    {
        $lansiaId = $pemeriksaan->lansia_id;
        $pemeriksaan->delete();
        return redirect()->route('pegawai.lansia.show', $lansiaId)
            ->with('success', 'Data pemeriksaan berhasil dihapus.');
    }

    // =============================================
    // JADWAL SENAM
    // =============================================

    public function indexJadwal(Request $request)
    {
        $query = JadwalSenamLansia::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $jadwal = $query->orderBy('tanggal', 'desc')->paginate(10)->withQueryString();

        return view('pegawai.lansia.jadwal-senam.index', compact('jadwal'));
    }

    public function createJadwal()
    {
        return view('pegawai.lansia.jadwal-senam.create');
    }

    public function storeJadwal(JadwalSenamLansiaRequest $request)
    {
        JadwalSenamLansia::create($request->validated());
        return redirect()->route('pegawai.lansia.jadwal.index')
            ->with('success', 'Jadwal senam berhasil ditambahkan.');
    }

    public function editJadwal(JadwalSenamLansia $jadwal)
    {
        return view('pegawai.lansia.jadwal-senam.edit', compact('jadwal'));
    }

    public function updateJadwal(JadwalSenamLansiaRequest $request, JadwalSenamLansia $jadwal)
    {
        $jadwal->update($request->validated());
        return redirect()->route('pegawai.lansia.jadwal.index')
            ->with('success', 'Jadwal senam berhasil diperbarui.');
    }

    public function destroyJadwal(JadwalSenamLansia $jadwal)
    {
        $jadwal->delete();
        return redirect()->route('pegawai.lansia.jadwal.index')
            ->with('success', 'Jadwal senam berhasil dihapus.');
    }

    // =============================================
    // VERIFIKASI
    // =============================================

    public function verify(Lansia $lansia)
    {
        $lansia->update([
            'is_verified'  => true,
            'verified_by'  => Auth::id(),
            'verified_at'  => now(),
        ]);
        return redirect()->route('pegawai.lansia.show', $lansia)
            ->with('success', 'Data lansia berhasil diverifikasi.');
    }

    public function reject(Lansia $lansia)
    {
        $lansia->update([
            'is_verified'  => false,
            'verified_by'  => null,
            'verified_at'  => null,
        ]);
        return redirect()->route('pegawai.lansia.show', $lansia)
            ->with('warning', 'Verifikasi data lansia telah dibatalkan.');
    }

    public function destroy(Lansia $lansia)
    {
        if ($lansia->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists('lansia/' . $lansia->foto)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete('lansia/' . $lansia->foto);
        }

        $lansia->delete();

        return redirect()->route('pegawai.lansia.index')
            ->with('success', 'Data lansia berhasil dihapus.');
    }

    // =============================================
    // LAPORAN
    // =============================================

    public function laporan(Request $request)
    {
        $query = PemeriksaanLansia::with(['lansia', 'user']);

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }

        $pemeriksaan = $query->orderBy('tanggal', 'desc')->paginate(15)->withQueryString();

        $totalLansia          = Lansia::count();
        $totalPemeriksaanBulan = PemeriksaanLansia::whereMonth('tanggal', now()->month)->count();

        return view('pegawai.lansia.laporan', compact('pemeriksaan', 'totalLansia', 'totalPemeriksaanBulan'));
    }
}
