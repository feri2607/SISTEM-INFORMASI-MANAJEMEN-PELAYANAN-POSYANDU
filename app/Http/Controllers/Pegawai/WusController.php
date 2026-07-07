<?php
// app/Http/Controllers/Pegawai/WusController.php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Wus;
use App\Models\Pus;
use App\Models\PelayananReproduksi;
use App\Models\KonselingReproduksi;
use App\Models\JadwalKontrol;
use App\Services\WusService;
use App\Http\Requests\PelayananReproduksiRequest;
use App\Http\Requests\KonselingReproduksiRequest;
use App\Http\Requests\JadwalKontrolRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class WusController extends Controller
{
    use AuthorizesRequests;

    protected $wusService;

    public function __construct(WusService $wusService)
    {
        $this->wusService = $wusService;
    }

    public function dashboard()
    {
        $stats = $this->wusService->getDashboardStats();
        $recentPelayanan = PelayananReproduksi::with(['wus', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('pegawai.reproduksi.dashboard', compact('stats', 'recentPelayanan'));
    }

    public function indexWus(Request $request)
    {
        $wus = $this->wusService->getWusList($request);
        return view('pegawai.reproduksi.wus-index', compact('wus'));
    }

    public function showWus(Wus $wus)
    {
        $wus->load(['warga', 'pus', 'pelayanan.user', 'konseling.user', 'jadwalKontrol']);
        return view('pegawai.reproduksi.wus-show', compact('wus'));
    }

    public function verifyWus(Wus $wus)
    {
        $wus->update([
            'is_verified' => true,
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Data WUS berhasil diverifikasi.');
    }

    public function indexPus(Request $request)
    {
        $pus = $this->wusService->getPusList($request);
        return view('pegawai.reproduksi.pus-index', compact('pus'));
    }

    public function showPus(Pus $pus)
    {
        $pus->load(['wus', 'warga']);
        return view('pegawai.reproduksi.pus-show', compact('pus'));
    }

    public function createPelayanan(Wus $wus)
    {
        return view('pegawai.reproduksi.pelayanan-create', compact('wus'));
    }

    public function storePelayanan(PelayananReproduksiRequest $request)
    {
        $pelayanan = $this->wusService->storePelayanan($request->validated());

        app(\App\Services\KehadiranService::class)->markAsServed($pelayanan->wus_id, \App\Models\Wus::class);

        return redirect()->route('pegawai.reproduksi.wus.show', $pelayanan->wus_id)
            ->with('success', 'Data pelayanan berhasil disimpan.');
    }

    public function editPelayanan(PelayananReproduksi $pelayanan)
    {
        $pelayanan->load('wus');
        return view('pegawai.reproduksi.pelayanan-edit', compact('pelayanan'));
    }

    public function updatePelayanan(PelayananReproduksiRequest $request, PelayananReproduksi $pelayanan)
    {
        $pelayanan->update($request->validated());

        return redirect()->route('pegawai.reproduksi.wus.show', $pelayanan->wus_id)
            ->with('success', 'Data pelayanan berhasil diperbarui.');
    }

    public function destroyPelayanan(PelayananReproduksi $pelayanan)
    {
        $wusId = $pelayanan->wus_id;
        $pelayanan->delete();

        return redirect()->route('pegawai.reproduksi.wus.show', $wusId)
            ->with('success', 'Data pelayanan berhasil dihapus.');
    }

    public function createKonseling(Wus $wus)
    {
        return view('pegawai.reproduksi.konseling-create', compact('wus'));
    }

    public function storeKonseling(KonselingReproduksiRequest $request)
    {
        $konseling = $this->wusService->storeKonseling($request->validated());

        app(\App\Services\KehadiranService::class)->markAsServed($konseling->wus_id, \App\Models\Wus::class);

        return redirect()->route('pegawai.reproduksi.wus.show', $konseling->wus_id)
            ->with('success', 'Data konseling berhasil disimpan.');
    }

    public function editKonseling(KonselingReproduksi $konseling)
    {
        $konseling->load('wus');
        return view('pegawai.reproduksi.konseling-edit', compact('konseling'));
    }

    public function updateKonseling(KonselingReproduksiRequest $request, KonselingReproduksi $konseling)
    {
        $konseling->update($request->validated());

        return redirect()->route('pegawai.reproduksi.wus.show', $konseling->wus_id)
            ->with('success', 'Data konseling berhasil diperbarui.');
    }

    public function destroyKonseling(KonselingReproduksi $konseling)
    {
        $wusId = $konseling->wus_id;
        $konseling->delete();

        return redirect()->route('pegawai.reproduksi.wus.show', $wusId)
            ->with('success', 'Data konseling berhasil dihapus.');
    }

    public function indexKontrol(Request $request)
    {
        $query = JadwalKontrol::with(['wus', 'user']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        $kontrol = $query->orderBy('tanggal')->paginate(10);
        return view('pegawai.reproduksi.kontrol-index', compact('kontrol'));
    }

    public function createKontrol(Wus $wus)
    {
        return view('pegawai.reproduksi.kontrol-create', compact('wus'));
    }

    public function storeKontrol(JadwalKontrolRequest $request)
    {
        $kontrol = $this->wusService->storeKontrol($request->validated());

        return redirect()->route('pegawai.reproduksi.kontrol.index')
            ->with('success', 'Jadwal kontrol berhasil ditambahkan.');
    }

    public function editKontrol(JadwalKontrol $kontrol)
    {
        $kontrol->load('wus');
        return view('pegawai.reproduksi.kontrol-edit', compact('kontrol'));
    }

    public function updateKontrol(JadwalKontrolRequest $request, JadwalKontrol $kontrol)
    {
        $kontrol->update($request->validated());

        return redirect()->route('pegawai.reproduksi.kontrol.index')
            ->with('success', 'Jadwal kontrol berhasil diperbarui.');
    }

    public function updateStatusKontrol(Request $request, JadwalKontrol $kontrol)
    {
        $request->validate([
            'status' => ['required', 'in:terjadwal,hadir,tidak_hadir'],
        ]);

        $this->wusService->updateKontrolStatus($kontrol->id, $request->status);

        return redirect()->back()
            ->with('success', 'Status kontrol berhasil diperbarui.');
    }

    public function destroyKontrol(JadwalKontrol $kontrol)
    {
        $kontrol->delete();

        return redirect()->route('pegawai.reproduksi.kontrol.index')
            ->with('success', 'Jadwal kontrol berhasil dihapus.');
    }
}