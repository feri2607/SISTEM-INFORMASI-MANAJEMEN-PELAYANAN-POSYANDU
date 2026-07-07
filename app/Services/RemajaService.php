<?php
// app/Services/RemajaService.php

namespace App\Services;

use App\Models\Remaja;
use App\Models\PemeriksaanRemaja;
use App\Models\KonselingRemaja;
use App\Models\TabletTambahDarah;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RemajaService
{
    public function getDashboardStats()
    {
        return [
            'total_remaja' => Remaja::count(),
            'dilayani_hari_ini' => PemeriksaanRemaja::whereDate('created_at', today())->count(),
            'belum_dilayani' => Remaja::whereDoesntHave('pemeriksaan', function ($query) {
                $query->whereDate('created_at', today());
            })->count(),
            'pemeriksaan_bulan_ini' => PemeriksaanRemaja::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];
    }

    public function getRemajaList($request)
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

        return $query->orderBy('created_at', 'desc')->paginate(10);
    }

    public function storePemeriksaan($data)
    {
        return DB::transaction(function () use ($data) {
            // Hitung BMI
            $bmi = null;
            if (!empty($data['berat_badan']) && !empty($data['tinggi_badan'])) {
                $tinggiMeter = $data['tinggi_badan'] / 100;
                $bmi = round($data['berat_badan'] / ($tinggiMeter * $tinggiMeter), 2);
            }

            $pemeriksaan = PemeriksaanRemaja::create([
                'remaja_id' => $data['remaja_id'],
                'user_id' => Auth::id(),
                'tanggal' => $data['tanggal'],
                'berat_badan' => $data['berat_badan'] ?? null,
                'tinggi_badan' => $data['tinggi_badan'] ?? null,
                'bmi' => $bmi,
                'tekanan_darah' => $data['tekanan_darah'] ?? null,
                'status_hb' => $data['status_hb'] ?? null,
                'catatan' => $data['catatan'] ?? null,
            ]);

            // Update verifikasi remaja jika belum
            $remaja = Remaja::find($data['remaja_id']);
            if (!$remaja->is_verified) {
                $remaja->is_verified = true;
                $remaja->verified_by = Auth::id();
                $remaja->verified_at = now();
                $remaja->save();
            }

            return $pemeriksaan;
        });
    }

    public function storeKonseling($data)
    {
        return DB::transaction(function () use ($data) {
            return KonselingRemaja::create([
                'remaja_id' => $data['remaja_id'],
                'user_id' => Auth::id(),
                'tanggal' => $data['tanggal'],
                'topik' => $data['topik'],
                'catatan' => $data['catatan'] ?? null,
            ]);
        });
    }

    public function updateTabletTambahDarah($remajaId, $data)
    {
        return DB::transaction(function () use ($remajaId, $data) {
            $ttd = TabletTambahDarah::updateOrCreate(
                ['remaja_id' => $remajaId],
                [
                    'target' => $data['target'] ?? 90,
                    'dikonsumsi' => $data['dikonsumsi'] ?? 0,
                    'tanggal_mulai' => $data['tanggal_mulai'] ?? null,
                    'tanggal_selesai' => $data['tanggal_selesai'] ?? null,
                ]
            );
            return $ttd;
        });
    }
}