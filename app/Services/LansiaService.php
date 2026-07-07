<?php
// app/Services/LansiaService.php

namespace App\Services;

use App\Models\Lansia;
use App\Models\PemeriksaanLansia;
use App\Models\JadwalSenamLansia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LansiaService
{
    /**
     * Get dashboard statistics for Pegawai.
     */
    public function getDashboardStats(): array
    {
        $today = now()->toDateString();

        return [
            'total_lansia'          => Lansia::count(),
            'lansia_hadir_today'    => PemeriksaanLansia::whereDate('tanggal', $today)->distinct('lansia_id')->count('lansia_id'),
            'belum_dilayani'        => Lansia::whereDoesntHave('pemeriksaan', fn($q) => $q->whereDate('tanggal', $today))->count(),
            'pemeriksaan_bulan_ini' => PemeriksaanLansia::whereMonth('tanggal', now()->month)->whereYear('tanggal', now()->year)->count(),
            'jadwal_senam_mendatang'=> JadwalSenamLansia::where('tanggal', '>=', $today)->where('status', 'aktif')->count(),
        ];
    }

    /**
     * Store new lansia identity with optional photo upload.
     */
    public function storeLansia(array $data, int $wargaId, $fotoFile = null): Lansia
    {
        if ($fotoFile) {
            $data['foto'] = $fotoFile->store('lansia', 'public');
            $data['foto'] = basename($data['foto']);
        }

        $data['warga_id'] = $wargaId;

        if (isset($data['tanggal_lahir'])) {
            $data['umur'] = \Carbon\Carbon::parse($data['tanggal_lahir'])->age;
        }

        return Lansia::create($data);
    }

    /**
     * Update lansia identity with optional photo replacement.
     */
    public function updateLansia(Lansia $lansia, array $data, $fotoFile = null): Lansia
    {
        if ($fotoFile) {
            // Delete old photo if exists
            if ($lansia->foto && Storage::disk('public')->exists('lansia/' . $lansia->foto)) {
                Storage::disk('public')->delete('lansia/' . $lansia->foto);
            }
            $data['foto'] = basename($fotoFile->store('lansia', 'public'));
        }

        if (isset($data['tanggal_lahir'])) {
            $data['umur'] = \Carbon\Carbon::parse($data['tanggal_lahir'])->age;
        }

        $lansia->update($data);
        return $lansia->fresh();
    }

    /**
     * Store pemeriksaan with auto-calculated IMT.
     */
    public function storePemeriksaan(array $data): PemeriksaanLansia
    {
        $data['imt']     = $this->calculateImt($data['berat_badan'] ?? null, $data['tinggi_badan'] ?? null);
        $data['user_id'] = Auth::id();

        return PemeriksaanLansia::create($data);
    }

    /**
     * Update pemeriksaan with recalculated IMT.
     */
    public function updatePemeriksaan(PemeriksaanLansia $pemeriksaan, array $data): PemeriksaanLansia
    {
        $data['imt'] = $this->calculateImt($data['berat_badan'] ?? null, $data['tinggi_badan'] ?? null);
        $pemeriksaan->update($data);
        return $pemeriksaan->fresh();
    }

    /**
     * Calculate IMT (Body Mass Index) from weight and height.
     */
    private function calculateImt(?float $berat, ?float $tinggi): ?float
    {
        if (!$berat || !$tinggi || $tinggi <= 0) {
            return null;
        }
        $tinggiMeter = $tinggi / 100;
        return round($berat / ($tinggiMeter * $tinggiMeter), 2);
    }

    /**
     * Get chart data for health trends.
     */
    public function getChartData(Lansia $lansia): array
    {
        $pemeriksaan = $lansia->pemeriksaan()->orderBy('tanggal')->get();

        return [
            'tekanan' => [
                'labels'    => $pemeriksaan->pluck('tanggal')->map(fn($d) => $d->format('d M Y'))->toArray(),
                'sistolik'  => $pemeriksaan->pluck('tekanan_darah')->map(fn($td) => $td ? (int)(explode('/', $td)[0] ?? null) : null)->toArray(),
                'diastolik' => $pemeriksaan->pluck('tekanan_darah')->map(fn($td) => $td ? (int)(explode('/', $td)[1] ?? null) : null)->toArray(),
            ],
            'gula_darah' => [
                'labels' => $pemeriksaan->pluck('tanggal')->map(fn($d) => $d->format('d M Y'))->toArray(),
                'data'   => $pemeriksaan->pluck('gula_darah')->toArray(),
            ],
            'kolesterol' => [
                'labels' => $pemeriksaan->pluck('tanggal')->map(fn($d) => $d->format('d M Y'))->toArray(),
                'data'   => $pemeriksaan->pluck('kolesterol')->toArray(),
            ],
            'berat' => [
                'labels' => $pemeriksaan->pluck('tanggal')->map(fn($d) => $d->format('d M Y'))->toArray(),
                'data'   => $pemeriksaan->pluck('berat_badan')->toArray(),
            ],
            'imt' => [
                'labels' => $pemeriksaan->pluck('tanggal')->map(fn($d) => $d->format('d M Y'))->toArray(),
                'data'   => $pemeriksaan->pluck('imt')->toArray(),
            ],
        ];
    }
}
