<?php
// app/Http/Controllers/Pegawai/RemajaController.php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Remaja;
use App\Models\PemeriksaanRemaja;
use App\Models\KonselingRemaja;
use App\Models\TabletTambahDarah;
use App\Services\RemajaService;
use App\Http\Requests\PemeriksaanRemajaRequest;
use App\Http\Requests\KonselingRemajaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RemajaController extends Controller
{
    use AuthorizesRequests;

    protected $remajaService;

    public function __construct(RemajaService $remajaService)
    {
        $this->remajaService = $remajaService;
    }

    public function dashboard()
    {
        $stats = $this->remajaService->getDashboardStats();
        
        $recentPemeriksaan = PemeriksaanRemaja::with(['remaja', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('pegawai.remaja.dashboard', compact('stats', 'recentPemeriksaan'));
    }

    public function index(Request $request)
    {
        $query = Remaja::with(['warga', 'pemeriksaan']);

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

        $remaja = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('pegawai.remaja.index', compact('remaja'));
    }

    public function show(Remaja $remaja)
    {
        $remaja->load(['pemeriksaan.user', 'konseling.user', 'tabletTambahDarah', 'warga']);
        
        // Growth data for charts
        $growthData = $this->getGrowthData($remaja);
        
        return view('pegawai.remaja.show', compact('remaja', 'growthData'));
    }

    public function createPemeriksaan(Remaja $remaja)
    {
        return view('pegawai.remaja.pemeriksaan-create', compact('remaja'));
    }

    public function storePemeriksaan(PemeriksaanRemajaRequest $request)
    {
        $pemeriksaan = $this->remajaService->storePemeriksaan($request->validated());
        
        app(\App\Services\KehadiranService::class)->markAsServed($pemeriksaan->remaja_id, \App\Models\Remaja::class);

        return redirect()->route('pegawai.remaja.show', $pemeriksaan->remaja_id)
            ->with('success', 'Data pemeriksaan berhasil disimpan.');
    }

    public function editPemeriksaan(PemeriksaanRemaja $pemeriksaan)
    {
        $pemeriksaan->load('remaja');
        return view('pegawai.remaja.pemeriksaan-edit', compact('pemeriksaan'));
    }

    public function updatePemeriksaan(PemeriksaanRemajaRequest $request, PemeriksaanRemaja $pemeriksaan)
    {
        $data = $request->validated();
        
        // Hitung ulang BMI
        $bmi = null;
        if (!empty($data['berat_badan']) && !empty($data['tinggi_badan'])) {
            $tinggiMeter = $data['tinggi_badan'] / 100;
            $bmi = round($data['berat_badan'] / ($tinggiMeter * $tinggiMeter), 2);
        }
        $data['bmi'] = $bmi;
        
        $pemeriksaan->update($data);
        
        return redirect()->route('pegawai.remaja.show', $pemeriksaan->remaja_id)
            ->with('success', 'Data pemeriksaan berhasil diperbarui.');
    }

    public function destroyPemeriksaan(PemeriksaanRemaja $pemeriksaan)
    {
        $remajaId = $pemeriksaan->remaja_id;
        $pemeriksaan->delete();
        
        return redirect()->route('pegawai.remaja.show', $remajaId)
            ->with('success', 'Data pemeriksaan berhasil dihapus.');
    }

    public function createKonseling(Remaja $remaja)
    {
        return view('pegawai.remaja.konseling-create', compact('remaja'));
    }

    public function storeKonseling(KonselingRemajaRequest $request)
    {
        $konseling = $this->remajaService->storeKonseling($request->validated());
        
        app(\App\Services\KehadiranService::class)->markAsServed($konseling->remaja_id, \App\Models\Remaja::class);

        return redirect()->route('pegawai.remaja.show', $konseling->remaja_id)
            ->with('success', 'Data konseling berhasil disimpan.');
    }

    public function editKonseling(KonselingRemaja $konseling)
    {
        $konseling->load('remaja');
        return view('pegawai.remaja.konseling-edit', compact('konseling'));
    }

    public function updateKonseling(KonselingRemajaRequest $request, KonselingRemaja $konseling)
    {
        $konseling->update($request->validated());
        
        return redirect()->route('pegawai.remaja.show', $konseling->remaja_id)
            ->with('success', 'Data konseling berhasil diperbarui.');
    }

    public function destroyKonseling(KonselingRemaja $konseling)
    {
        $remajaId = $konseling->remaja_id;
        $konseling->delete();
        
        return redirect()->route('pegawai.remaja.show', $remajaId)
            ->with('success', 'Data konseling berhasil dihapus.');
    }

    public function verify(Remaja $remaja)
    {
        $remaja->update([
            'is_verified'  => true,
            'verified_by'  => Auth::id(),
            'verified_at'  => now(),
        ]);

        return redirect()->route('pegawai.remaja.show', $remaja)
            ->with('success', 'Data remaja berhasil diverifikasi.');
    }

    public function reject(Remaja $remaja)
    {
        $remaja->update([
            'is_verified'  => false,
            'verified_by'  => null,
            'verified_at'  => null,
        ]);

        return redirect()->route('pegawai.remaja.show', $remaja)
            ->with('warning', 'Verifikasi data remaja telah dibatalkan.');
    }

    public function destroy(Remaja $remaja)
    {
        // Delete related photos if exists
        if ($remaja->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists('remaja/' . $remaja->foto)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete('remaja/' . $remaja->foto);
        }

        $remaja->delete();

        return redirect()->route('pegawai.remaja.index')
            ->with('success', 'Data remaja berhasil dihapus.');
    }

    public function updateTtd(Request $request, Remaja $remaja)
    {
        $request->validate([
            'target' => ['nullable', 'integer', 'min:1'],
            'dikonsumsi' => ['nullable', 'integer', 'min:0'],
            'tanggal_mulai' => ['nullable', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after:tanggal_mulai'],
        ]);
        
        $this->remajaService->updateTabletTambahDarah($remaja->id, $request->all());
        
        return redirect()->route('pegawai.remaja.show', $remaja)
            ->with('success', 'Data Tablet Tambah Darah berhasil diperbarui.');
    }

    private function getGrowthData($remaja)
    {
        $pemeriksaan = $remaja->pemeriksaan()->orderBy('tanggal')->get();
        
        return [
            'berat' => [
                'labels' => $pemeriksaan->pluck('tanggal')->map(fn($d) => $d->format('d M Y'))->toArray(),
                'data' => $pemeriksaan->pluck('berat_badan')->toArray(),
            ],
            'tinggi' => [
                'labels' => $pemeriksaan->pluck('tanggal')->map(fn($d) => $d->format('d M Y'))->toArray(),
                'data' => $pemeriksaan->pluck('tinggi_badan')->toArray(),
            ],
            'bmi' => [
                'labels' => $pemeriksaan->pluck('tanggal')->map(fn($d) => $d->format('d M Y'))->toArray(),
                'data' => $pemeriksaan->pluck('bmi')->toArray(),
            ],
        ];
    }
}