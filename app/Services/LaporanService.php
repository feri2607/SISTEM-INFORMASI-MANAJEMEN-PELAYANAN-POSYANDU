<?php

namespace App\Services;

use App\Models\PemeriksaanBalita;
use App\Models\Anc;
use App\Models\PemeriksaanRemaja;
use App\Models\PemeriksaanLansia;
use App\Models\PelayananReproduksi;
use App\Models\User;
use Carbon\Carbon;

class LaporanService
{
    /**
     * Compute query boundaries based on requested period filter
     */
    public function parsePeriodeFilter($query, $periodeKey, $startDate, $endDate, $dateColumn = 'created_at')
    {
        switch ($periodeKey) {
            case 'hari_ini':
                $query->whereDate($dateColumn, Carbon::today());
                break;
            case 'minggu_ini':
                $query->whereBetween($dateColumn, [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'bulan_ini':
                $query->whereMonth($dateColumn, Carbon::now()->month)
                      ->whereYear($dateColumn, Carbon::now()->year);
                break;
            case 'tahun_ini':
                $query->whereYear($dateColumn, Carbon::now()->year);
                break;
            case 'custom':
                if ($startDate && $endDate) {
                    $query->whereBetween($dateColumn, [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()]);
                }
                break;
            default:
                // no filter
                break;
        }
        return $query;
    }

    /**
     * Generic filter applier
     */
    public function applyFilters($query, array $filters, $pegawaiCol = 'pegawai_id', $dateCol = 'created_at')
    {
        $this->parsePeriodeFilter($query, $filters['periode'] ?? null, $filters['start_date'] ?? null, $filters['end_date'] ?? null, $dateCol);
        
        if (!empty($filters['pegawai_id'])) {
            $query->where($pegawaiCol, $filters['pegawai_id']);
        }
        
        return $query;
    }

    public function getDashboardStats(array $filters = [])
    {
        // Balita
        $balitaQ = PemeriksaanBalita::query();
        $this->applyFilters($balitaQ, $filters);
        
        // Kehamilan
        $kehamilanQ = Anc::query();
        $this->applyFilters($kehamilanQ, $filters);
        
        // WUS/PUS & Menyusui
        $wusQ = PelayananReproduksi::query();
        $this->applyFilters($wusQ, $filters, 'user_id', 'created_at');
        // split wus vs menyusui if needed (assuming WUS covers menyusui or separate flags exist)
        
        // Remaja
        $remajaQ = PemeriksaanRemaja::query();
        $this->applyFilters($remajaQ, $filters);
        
        // Lansia
        $lansiaQ = PemeriksaanLansia::query();
        $this->applyFilters($lansiaQ, $filters);

        $totalBalita = $balitaQ->count();
        $totalKehamilan = $kehamilanQ->count();
        $totalWusPus = $wusQ->count();
        $totalRemaja = $remajaQ->count();
        $totalLansia = $lansiaQ->count();

        $totalAll = $totalBalita + $totalKehamilan + $totalWusPus + $totalRemaja + $totalLansia;

        // Daily chart data (last 7 days by default)
        // Note: Full analytics implementation requires chart dataset building, keeping simple for stats

        return [
            'total_pelayanan' => $totalAll,
            'balita_dilayani' => $totalBalita,
            'ibu_hamil_dilayani' => $totalKehamilan,
            'wus_pus_dilayani' => $totalWusPus,
            'remaja_dilayani' => $totalRemaja,
            'lansia_dilayani' => $totalLansia,
            'pegawai_aktif' => User::where('role', 'pegawai')->count()
        ];
    }

    public function getLaporanBalita(array $filters = [], $isExport = false)
    {
        $q = PemeriksaanBalita::with(['balita.warga', 'pegawai']);
        $this->applyFilters($q, $filters);
        $q->latest('created_at');
        return $isExport ? $q->get() : $q->paginate(15);
    }

    public function getLaporanKehamilan(array $filters = [], $isExport = false)
    {
        $q = Anc::with(['kehamilan.warga', 'user']);
        $this->applyFilters($q, $filters, 'user_id', 'created_at'); // Anc uses user_id
        $q->latest('created_at');
        return $isExport ? $q->get() : $q->paginate(15);
    }

    public function getLaporanWusPus(array $filters = [], $isExport = false)
    {
        $q = PelayananReproduksi::with(['wus.warga', 'user']);
        $this->applyFilters($q, $filters, 'user_id', 'created_at');
        $q->latest('created_at');
        return $isExport ? $q->get() : $q->paginate(15);
    }

    public function getLaporanRemaja(array $filters = [], $isExport = false)
    {
        $q = PemeriksaanRemaja::with(['remaja.warga', 'user']);
        $this->applyFilters($q, $filters, 'user_id');
        $q->latest('created_at');
        return $isExport ? $q->get() : $q->paginate(15);
    }

    public function getLaporanLansia(array $filters = [], $isExport = false)
    {
        $q = PemeriksaanLansia::with(['lansia.warga', 'user']);
        $this->applyFilters($q, $filters, 'user_id');
        $q->latest('created_at');
        return $isExport ? $q->get() : $q->paginate(15);
    }

    public function getLaporanKegiatan(array $filters = [], $isExport = false)
    {
        $q = \App\Models\KegiatanPosyandu::withCount([
            'kehadiran as hadir_count' => function ($query) {
                $query->whereIn('status_kehadiran', ['Hadir', 'Sudah Dilayani']);
            },
            'kehadiran as dilayani_count' => function ($query) {
                $query->where('status_kehadiran', 'Sudah Dilayani');
            }
        ]);
        
        $this->parsePeriodeFilter($q, $filters['periode'] ?? null, $filters['start_date'] ?? null, $filters['end_date'] ?? null, 'tanggal');

        $q->latest('tanggal');
        return $isExport ? $q->get() : $q->paginate(15);
    }

    public function getLaporanPegawai(array $filters = [], $isExport = false)
    {
        // Simple manual aggregation per pegawai
        $pegawais = User::where('role', 'pegawai')->get();
        
        $data = $pegawais->map(function ($pegawai) use ($filters) {
            $balita = PemeriksaanBalita::where('pegawai_id', $pegawai->id);
            $this->parsePeriodeFilter($balita, $filters['periode'] ?? null, $filters['start_date'] ?? null, $filters['end_date'] ?? null, 'created_at');
            
            $anc = Anc::where('user_id', $pegawai->id);
            $this->parsePeriodeFilter($anc, $filters['periode'] ?? null, $filters['start_date'] ?? null, $filters['end_date'] ?? null, 'created_at');
            
            $wus = PelayananReproduksi::where('user_id', $pegawai->id);
            $this->parsePeriodeFilter($wus, $filters['periode'] ?? null, $filters['start_date'] ?? null, $filters['end_date'] ?? null, 'created_at');
            
            $remaja = PemeriksaanRemaja::where('user_id', $pegawai->id);
            $this->parsePeriodeFilter($remaja, $filters['periode'] ?? null, $filters['start_date'] ?? null, $filters['end_date'] ?? null, 'created_at');
            
            $lansia = PemeriksaanLansia::where('user_id', $pegawai->id);
            $this->parsePeriodeFilter($lansia, $filters['periode'] ?? null, $filters['start_date'] ?? null, $filters['end_date'] ?? null, 'created_at');
            
            $obj = new \stdClass();
            $obj->nama = $pegawai->name;
            $obj->balita_count = $balita->count();
            $obj->kehamilan_count = $anc->count();
            $obj->wus_count = $wus->count();
            $obj->remaja_count = $remaja->count();
            $obj->lansia_count = $lansia->count();
            $obj->total = $obj->balita_count + $obj->kehamilan_count + $obj->wus_count + $obj->remaja_count + $obj->lansia_count;
            
            return $obj;
        });

        // Paginate a collection is manual, so I will just return the full list or manual paginator, full list is fine for pegawai.
        return $data;
    }
}
