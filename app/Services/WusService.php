<?php
// app/Services/WusService.php

namespace App\Services;

use App\Models\Wus;
use App\Models\Pus;
use App\Models\PelayananReproduksi;
use App\Models\KonselingReproduksi;
use App\Models\JadwalKontrol;
use App\Models\User;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class WusService
{
    public function getDashboardStats()
    {
        return [
            'total_wus' => Wus::count(),
            'total_pus' => Pus::count(),
            'pelayanan_hari_ini' => PelayananReproduksi::whereDate('created_at', today())->count(),
            'jadwal_kontrol_hari_ini' => JadwalKontrol::whereDate('tanggal', today())->count(),
            'konseling_hari_ini' => KonselingReproduksi::whereDate('created_at', today())->count(),
        ];
    }

    public function getWusList($request)
    {
        $query = Wus::with(['warga', 'pus']);

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

    public function getPusList($request)
    {
        $query = Pus::with(['wus', 'warga']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pasangan', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status_kb')) {
            $query->where('status_kb', $request->status_kb);
        }

        return $query->orderBy('created_at', 'desc')->paginate(10);
    }

    public function storePelayanan($data)
    {
        return DB::transaction(function () use ($data) {
            $pelayanan = PelayananReproduksi::create([
                'wus_id' => $data['wus_id'],
                'user_id' => Auth::id(),
                'tanggal' => $data['tanggal'],
                'jenis_pelayanan' => $data['jenis_pelayanan'],
                'jenis_kontrasepsi' => $data['jenis_kontrasepsi'] ?? null,
                'hasil_pemeriksaan' => $data['hasil_pemeriksaan'] ?? null,
                'catatan' => $data['catatan'] ?? null,
                'jadwal_kontrol_berikutnya' => $data['jadwal_kontrol_berikutnya'] ?? null,
            ]);

            // Update PUS data
            $pus = Pus::where('warga_id', $pelayanan->wus->warga_id)->first();
            if ($pus && $data['jenis_kontrasepsi']) {
                $pus->jenis_kontrasepsi = $data['jenis_kontrasepsi'];
                $pus->status_kb = 'aktif';
                $pus->save();
            }

            // Create kontrol schedule if exists
            if (!empty($data['jadwal_kontrol_berikutnya'])) {
                JadwalKontrol::create([
                    'wus_id' => $data['wus_id'],
                    'user_id' => Auth::id(),
                    'tanggal' => $data['jadwal_kontrol_berikutnya'],
                    'jam' => $data['jam_kontrol'] ?? '08:00:00',
                    'lokasi' => $data['lokasi_kontrol'] ?? 'Posyandu',
                    'status' => 'terjadwal',
                ]);

                // Update PUS jadwal kontrol
                if ($pus) {
                    $pus->jadwal_kontrol = $data['jadwal_kontrol_berikutnya'];
                    $pus->save();
                }
            }

            return $pelayanan;
        });
    }

    public function storeKonseling($data)
    {
        return DB::transaction(function () use ($data) {
            return KonselingReproduksi::create([
                'wus_id' => $data['wus_id'],
                'user_id' => Auth::id(),
                'tanggal' => $data['tanggal'],
                'topik' => $data['topik'],
                'catatan' => $data['catatan'] ?? null,
            ]);
        });
    }

    public function storeKontrol($data)
    {
        return DB::transaction(function () use ($data) {
            $kontrol = JadwalKontrol::create([
                'wus_id' => $data['wus_id'],
                'user_id' => Auth::id(),
                'tanggal' => $data['tanggal'],
                'jam' => $data['jam'],
                'lokasi' => $data['lokasi'],
                'status' => 'terjadwal',
                'catatan' => $data['catatan'] ?? null,
            ]);

            // Update PUS jadwal kontrol
            $pus = Pus::where('warga_id', $kontrol->wus->warga_id)->first();
            if ($pus) {
                $pus->jadwal_kontrol = $data['tanggal'];
                $pus->save();
            }

            return $kontrol;
        });
    }

    public function updateKontrolStatus($id, $status)
    {
        $kontrol = JadwalKontrol::findOrFail($id);
        $kontrol->status = $status;
        $kontrol->save();

        return $kontrol;
    }
}