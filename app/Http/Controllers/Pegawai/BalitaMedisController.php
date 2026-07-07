<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Balita;
use App\Models\PemeriksaanBalita;
use App\Models\ImunisasiBalita;
use App\Models\PerkembanganBalita;
use App\Models\VitaminBalita;
use App\Services\NutritionService;
use App\Notifications\HasilPemeriksaanNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BalitaMedisController extends Controller
{
    /**
     * Show form to create Pemeriksaan
     */
    public function createPemeriksaan(Balita $balita)
    {
        return view('Admin.Balita.Medis.pemeriksaan-create', compact('balita'));
    }

    /**
     * Store Pemeriksaan
     */
    public function storePemeriksaan(Request $request, Balita $balita)
    {
        $validated = $request->validate([
            'tanggal_pemeriksaan' => 'required|date',
            'berat_badan' => 'required|numeric|min:0',
            'tinggi_badan' => 'required|numeric|min:0',
            'lingkar_kepala' => 'nullable|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $validated['balita_id'] = $balita->id;
        $validated['pegawai_id'] = Auth::id(); // Fixed from petugas_id

        // Map keterangan to catatan_pegawai
        if (isset($validated['keterangan'])) {
            $validated['catatan_pegawai'] = $validated['keterangan'];
            unset($validated['keterangan']);
        }

        // Calculate Status Gizi WHO Automatically!
        $nutritionResult = NutritionService::calculateWFA($balita, (float) $validated['berat_badan']);
        $validated['status_gizi'] = $nutritionResult['status'];

        $pemeriksaan = PemeriksaanBalita::create($validated);

        // Send notification to the Warga / Ortu
        if ($balita->warga && $balita->warga->user) {
            $balita->warga->user->notify(new HasilPemeriksaanNotification($pemeriksaan));
        }

        app(\App\Services\KehadiranService::class)->markAsServed($balita->id, \App\Models\Balita::class);
        $this->syncHasilPelayanan($balita->id, $validated);

        return redirect()->route(Auth::user()->role . '.balita.show', $balita->id)
            ->with('success', 'Data pemeriksaan berhasil ditambahkan.');
    }

    /**
     * Show form to create Imunisasi
     */
    public function createImunisasi(Balita $balita)
    {
        return view('Admin.Balita.Medis.imunisasi-create', compact('balita'));
    }

    /**
     * Store Imunisasi
     */
    public function storeImunisasi(Request $request, Balita $balita)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jenis_imunisasi' => 'required|string|max:100',
            'keterangan' => 'nullable|string',
        ]);

        $validated['balita_id'] = $balita->id;
        $validated['pegawai_id'] = Auth::id();
        $validated['status'] = 'diberikan'; // default status

        // Map keterangan to catatan
        if (isset($validated['keterangan'])) {
            $validated['catatan'] = $validated['keterangan'];
            unset($validated['keterangan']);
        }

        ImunisasiBalita::create($validated);

        app(\App\Services\KehadiranService::class)->markAsServed($balita->id, \App\Models\Balita::class);
        $this->syncHasilPelayanan($balita->id, $validated);

        return redirect()->route(Auth::user()->role . '.balita.show', $balita->id)
            ->with('success', 'Data imunisasi berhasil ditambahkan.');
    }

    /**
     * Show form to create Vitamin
     */
    public function createVitamin(Balita $balita)
    {
        return view('Admin.Balita.Medis.vitamin-create', compact('balita'));
    }

    /**
     * Store Vitamin
     */
    public function storeVitamin(Request $request, Balita $balita)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jenis_vitamin' => 'required|string|max:100',
            'keterangan' => 'nullable|string',
        ]);

        $validated['balita_id'] = $balita->id;
        $validated['pegawai_id'] = Auth::id();
        $validated['dosis'] = '1 Dosis'; // Default dosis to pass NOT NULL constraint if omitted from form

        // Map keterangan to catatan
        if (isset($validated['keterangan'])) {
            $validated['catatan'] = $validated['keterangan'];
            unset($validated['keterangan']);
        }

        VitaminBalita::create($validated);

        app(\App\Services\KehadiranService::class)->markAsServed($balita->id, \App\Models\Balita::class);
        $this->syncHasilPelayanan($balita->id, $validated);

        return redirect()->route(Auth::user()->role . '.balita.show', $balita->id)
            ->with('success', 'Data vitamin berhasil ditambahkan.');
    }

    /**
     * Show form to create Perkembangan
     */
    public function createPerkembangan(Balita $balita)
    {
        return view('Admin.Balita.Medis.perkembangan-create', compact('balita'));
    }

    /**
     * Store Perkembangan
     */
    public function storePerkembangan(Request $request, Balita $balita)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'motorik_kasar' => 'nullable|string',
            'motorik_halus' => 'nullable|string',
            'bahasa' => 'nullable|string',
            'sosial' => 'nullable|string',
        ]);

        $validated['balita_id'] = $balita->id;
        $validated['pegawai_id'] = Auth::id();

        PerkembanganBalita::create($validated);

        app(\App\Services\KehadiranService::class)->markAsServed($balita->id, \App\Models\Balita::class);
        $this->syncHasilPelayanan($balita->id, $validated);

        return redirect()->route(Auth::user()->role . '.balita.show', $balita->id)
            ->with('success', 'Data perkembangan berhasil ditambahkan.');
    }

    private function syncHasilPelayanan($balitaId, $data = [])
    {
        $kehadiran = \App\Models\KehadiranKegiatan::where('peserta_id', $balitaId)
            ->where('peserta_type', \App\Models\Balita::class)
            ->where('status_kehadiran', '!=', 'Belum Hadir')
            ->latest('created_at')
            ->first();

        if (!$kehadiran || !$kehadiran->kegiatan_id) {
            $keg = \App\Models\KegiatanPosyandu::whereDate('tanggal', date('Y-m-d'))->first();
            if (!$keg) return;
            $kegiatanId = $keg->id;
        } else {
            $kegiatanId = $kehadiran->kegiatan_id;
        }

        $hp = \App\Models\HasilPelayanan::firstOrNew([
            'kegiatan_id' => $kegiatanId,
            'balita_id' => $balitaId,
        ]);

        if (isset($data['berat_badan'])) $hp->berat_badan = $data['berat_badan'];
        if (isset($data['tinggi_badan'])) $hp->tinggi_badan = $data['tinggi_badan'];
        if (isset($data['lingkar_kepala'])) $hp->lingkar_kepala = $data['lingkar_kepala'];
        if (isset($data['status_gizi'])) $hp->status_gizi = $data['status_gizi'];
        if (isset($data['catatan_pegawai'])) $hp->catatan = $data['catatan_pegawai'];

        if (isset($data['jenis_imunisasi'])) {
            $im = $hp->imunisasi ?? [];
            if (!in_array($data['jenis_imunisasi'], $im)) {
                $im[] = $data['jenis_imunisasi'];
                $hp->imunisasi = $im;
            }
        }
        
        if (isset($data['jenis_vitamin'])) {
            $vit = $hp->vitamin ?? [];
            if (!in_array($data['jenis_vitamin'], $vit)) {
                $vit[] = $data['jenis_vitamin'];
                $hp->vitamin = $vit;
            }
        }

        if (!$hp->exists) {
            $hp->berat_badan = $hp->berat_badan ?? 0;
            $hp->tinggi_badan = $hp->tinggi_badan ?? 0;
            $hp->lingkar_kepala = $hp->lingkar_kepala ?? 0;
            $hp->status_gizi = $hp->status_gizi ?? 'normal';
            $hp->user_id = \Illuminate\Support\Facades\Auth::id() ?? 1;
        }

        $hp->save();
    }
}
