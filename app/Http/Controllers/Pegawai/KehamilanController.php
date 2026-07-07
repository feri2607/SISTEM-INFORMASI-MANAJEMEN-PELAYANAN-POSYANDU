<?php
// app/Http/Controllers/Pegawai/KehamilanController.php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Requests\AncRequest;
use App\Models\Anc;
use App\Models\Kehamilan;
use App\Services\KehamilanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KehamilanController extends Controller
{
    public function __construct(private KehamilanService $service) {}

    public function dashboard()
    {
        $stats = $this->service->getPegawaiDashboardStats();

        $recentAnc = Anc::with(['kehamilan.warga', 'user'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('pegawai.kehamilan.dashboard', compact('stats', 'recentAnc'));
    }

    public function index(Request $request)
    {
        $query = Kehamilan::with(['warga', 'anc'])->where('status', 'aktif');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nama', 'like', "%$s%")
                  ->orWhere('nik', 'like', "%$s%");
            });
        }

        if ($request->filled('risiko')) {
            $query->where('risiko_tinggi', $request->risiko === 'tinggi');
        }

        if ($request->filled('status')) {
            $query->where('is_verified', $request->status === 'verified');
        }

        $list = $query->orderByDesc('created_at')->paginate(10);

        return view('pegawai.kehamilan.index', compact('list'));
    }

    public function show(Kehamilan $kehamilan)
    {
        $kehamilan->load(['anc.user', 'konsumsiTtd', 'warga', 'verifiedBy']);
        $chartData = $this->service->getChartData($kehamilan);

        return view('pegawai.kehamilan.show', compact('kehamilan', 'chartData'));
    }

    public function createAnc(Kehamilan $kehamilan)
    {
        return view('pegawai.kehamilan.anc-create', compact('kehamilan'));
    }

    public function storeAnc(AncRequest $request)
    {
        $anc = $this->service->storeAnc($request->validated());

        app(\App\Services\KehadiranService::class)->markAsServed($anc->kehamilan_id, \App\Models\Kehamilan::class);

        return redirect()->route('pegawai.kehamilan.show', $anc->kehamilan_id)
            ->with('success', 'Pemeriksaan ANC berhasil disimpan.');
    }

    public function editAnc(Anc $anc)
    {
        $anc->load('kehamilan');
        $kehamilan = $anc->kehamilan;
        return view('pegawai.kehamilan.anc-edit', compact('anc', 'kehamilan'));
    }

    public function updateAnc(AncRequest $request, Anc $anc)
    {
        $anc->update($request->validated());

        return redirect()->route('pegawai.kehamilan.show', $anc->kehamilan_id)
            ->with('success', 'Pemeriksaan ANC berhasil diperbarui.');
    }

    public function destroyAnc(Anc $anc)
    {
        $kehamilanId = $anc->kehamilan_id;
        $anc->delete();

        return redirect()->route('pegawai.kehamilan.show', $kehamilanId)
            ->with('success', 'Data ANC berhasil dihapus.');
    }

    public function verify(Kehamilan $kehamilan)
    {
        $kehamilan->update([
            'is_verified' => true,
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);

        return redirect()->route('pegawai.kehamilan.show', $kehamilan)
            ->with('success', 'Data kehamilan berhasil diverifikasi.');
    }

    public function reject(Kehamilan $kehamilan)
    {
        $kehamilan->update([
            'is_verified' => false,
            'verified_by' => null,
            'verified_at' => null,
        ]);

        return redirect()->route('pegawai.kehamilan.show', $kehamilan)
            ->with('warning', 'Verifikasi data kehamilan telah dibatalkan.');
    }
}
