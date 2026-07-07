<?php
// app/Services/KehamilanService.php

namespace App\Services;

use App\Models\Kehamilan;
use App\Models\Anc;
use App\Models\KonsumsiTtd;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class KehamilanService
{
    // ==========================================
    // Dashboard Stats (Pegawai)
    // ==========================================
    public function getPegawaiDashboardStats(): array
    {
        return [
            'total_ibu_hamil'    => Kehamilan::where('status', 'aktif')->count(),
            'anc_hari_ini'       => Anc::whereDate('tanggal', today())->count(),
            'belum_dilayani'     => Kehamilan::where('status', 'aktif')
                                              ->whereDoesntHave('anc')->count(),
            'risiko_tinggi'      => Kehamilan::where('risiko_tinggi', true)->count(),
            'pending_verifikasi' => Kehamilan::where('is_verified', false)->count(),
        ];
    }

    // ==========================================
    // Warga Dashboard Data
    // ==========================================
    public function getWargaDashboard(int $wargaId): array
    {
        $kehamilan = Kehamilan::where('warga_id', $wargaId)
                              ->where('status', 'aktif')
                              ->with(['anc.user', 'konsumsiTtd'])
                              ->latest()
                              ->first();

        return [
            'kehamilan'  => $kehamilan,
            'anc_list'   => $kehamilan?->anc ?? collect(),
            'ttd'        => $kehamilan?->konsumsiTtd,
            'chart_data' => $kehamilan ? $this->getChartData($kehamilan) : null,
        ];
    }

    // ==========================================
    // Create Kehamilan (Warga)
    // ==========================================
    public function storeKehamilan(array $data, $fotoFile = null): Kehamilan
    {
        return DB::transaction(function () use ($data, $fotoFile) {
            // Hitung HPL dari HPHT (HPHT + 280 hari)
            $hpht = Carbon::parse($data['hpht']);
            $hpl  = $hpht->copy()->addDays(280);

            $foto = null;
            if ($fotoFile) {
                $foto = $fotoFile->store('kehamilan', 'public');
                $foto = basename($foto);
            }

            $kehamilan = Kehamilan::create([
                'warga_id'         => $data['warga_id'],
                'nama'             => $data['nama'],
                'nik'              => $data['nik'],
                'tanggal_lahir'    => $data['tanggal_lahir'],
                'no_hp'            => $data['no_hp'] ?? null,
                'alamat'           => $data['alamat'] ?? null,
                'kehamilan_ke'     => $data['kehamilan_ke'] ?? 1,
                'hpht'             => $hpht,
                'hpl'              => $hpl,
                'golongan_darah'   => $data['golongan_darah'] ?? null,
                'riwayat_penyakit' => $data['riwayat_penyakit'] ?? null,
                'riwayat_alergi'   => $data['riwayat_alergi'] ?? null,
                'foto'             => $foto,
                'status'           => 'aktif',
            ]);

            // Init TTD record
            KonsumsiTtd::create([
                'kehamilan_id'    => $kehamilan->id,
                'jumlah_target'   => 90,
                'jumlah_diminum'  => 0,
                'tanggal_mulai'   => today(),
            ]);

            return $kehamilan;
        });
    }

    // ==========================================
    // Update Kehamilan (Warga — before verified)
    // ==========================================
    public function updateKehamilan(Kehamilan $kehamilan, array $data, $fotoFile = null): Kehamilan
    {
        return DB::transaction(function () use ($kehamilan, $data, $fotoFile) {
            $hpht = Carbon::parse($data['hpht']);
            $hpl  = $hpht->copy()->addDays(280);

            $foto = $kehamilan->foto;
            if ($fotoFile) {
                if ($foto) Storage::disk('public')->delete('kehamilan/' . $foto);
                $foto = basename($fotoFile->store('kehamilan', 'public'));
            }

            $kehamilan->update([
                'nama'             => $data['nama'],
                'nik'              => $data['nik'],
                'tanggal_lahir'    => $data['tanggal_lahir'],
                'no_hp'            => $data['no_hp'] ?? null,
                'alamat'           => $data['alamat'] ?? null,
                'kehamilan_ke'     => $data['kehamilan_ke'] ?? 1,
                'hpht'             => $hpht,
                'hpl'              => $hpl,
                'golongan_darah'   => $data['golongan_darah'] ?? null,
                'riwayat_penyakit' => $data['riwayat_penyakit'] ?? null,
                'riwayat_alergi'   => $data['riwayat_alergi'] ?? null,
                'foto'             => $foto,
            ]);

            return $kehamilan;
        });
    }

    // ==========================================
    // Store ANC (Pegawai)
    // ==========================================
    public function storeAnc(array $data): Anc
    {
        return DB::transaction(function () use ($data) {
            $kehamilan = Kehamilan::findOrFail($data['kehamilan_id']);

            $mingguKe = $kehamilan->hpht
                ? (int) Carbon::parse($kehamilan->hpht)->diffInWeeks(Carbon::parse($data['tanggal']))
                : ($data['minggu_ke'] ?? 0);

            $anc = Anc::create([
                'kehamilan_id'  => $data['kehamilan_id'],
                'user_id'       => Auth::id(),
                'tanggal'       => $data['tanggal'],
                'minggu_ke'     => $mingguKe,
                'tekanan_darah' => $data['tekanan_darah'] ?? null,
                'berat_badan'   => $data['berat_badan'] ?? null,
                'lila'          => $data['lila'] ?? null,
                'tinggi_fundus' => $data['tinggi_fundus'] ?? null,
                'detak_jantung' => $data['detak_jantung'] ?? null,
                'posisi_janin'  => $data['posisi_janin'] ?? null,
                'keluhan'       => $data['keluhan'] ?? null,
                'diagnosis'     => $data['diagnosis'] ?? null,
                'pemberian_ttd' => (bool) ($data['pemberian_ttd'] ?? false),
                'rujukan'       => (bool) ($data['rujukan'] ?? false),
                'catatan'       => $data['catatan'] ?? null,
            ]);

            // Verifikasi otomatis saat ANC pertama
            if (!$kehamilan->is_verified) {
                $kehamilan->update([
                    'is_verified' => true,
                    'verified_by' => Auth::id(),
                    'verified_at' => now(),
                ]);
            }

            // Update TTD jika ada pemberian
            if ($anc->pemberian_ttd) {
                $ttd = $kehamilan->konsumsiTtd;
                if ($ttd) {
                    $ttd->increment('jumlah_diminum', 30);
                }
            }

            return $anc;
        });
    }

    // ==========================================
    // Chart Data
    // ==========================================
    public function getChartData(Kehamilan $kehamilan): array
    {
        $ancs = $kehamilan->anc()->orderBy('tanggal')->get();

        $labels = $ancs->map(fn($a) => 'Mgg ' . $a->minggu_ke)->toArray();

        return [
            'labels'       => $labels,
            'berat_badan'  => $ancs->pluck('berat_badan')->toArray(),
            'tinggi_fundus'=> $ancs->pluck('tinggi_fundus')->toArray(),
            'tekanan_sistol' => $ancs->map(function ($a) {
                if ($a->tekanan_darah && str_contains($a->tekanan_darah, '/')) {
                    return (int) explode('/', $a->tekanan_darah)[0];
                }
                return null;
            })->toArray(),
        ];
    }
}
