<?php

namespace App\Services;

use App\Models\KehadiranKegiatan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KehadiranService
{
    /**
     * Mark a participant as present and record their arrival time.
     */
    public function markAsPresent($kehadiranId)
    {
        return DB::transaction(function () use ($kehadiranId) {
            $kehadiran = KehadiranKegiatan::findOrFail($kehadiranId);
            
            $kehadiran->update([
                'status_kehadiran' => 'Hadir',
                'jam_datang' => Carbon::now()->format('H:i:s'),
                'hadir_at' => Carbon::now(),
            ]);

            return $kehadiran;
        });
    }

    /**
     * Mark a participant as served (Sudah Dilayani).
     */
    public function markAsServed($pesertaId, $pesertaType)
    {
        // Temukan kehadiran terbaru untuk peserta ini (yang belum 'Sudah Dilayani')
        $kehadiran = KehadiranKegiatan::where('peserta_id', $pesertaId)
            ->where('peserta_type', $pesertaType)
            ->whereIn('status_kehadiran', ['Hadir', 'Belum Hadir'])
            ->latest('created_at')
            ->first();

        if ($kehadiran) {
            $updateData = ['status_kehadiran' => 'Sudah Dilayani'];
            
            // Record waktu kedatangan juga jika sebelumnya 'Belum Hadir' namun langsung dilayani
            if ($kehadiran->status_kehadiran === 'Belum Hadir') {
                $updateData['hadir_at'] = Carbon::now();
                $updateData['jam_datang'] = Carbon::now()->format('H:i:s');
            }

            $kehadiran->update($updateData);
        }
    }

    /**
     * Get attendees list for a specific activity, optionally filtered
     */
    public function getAttendees(array $filters = [])
    {
        $query = KehadiranKegiatan::with(['peserta.warga', 'kegiatan', 'user'])->has('peserta');

        if (!empty($filters['kegiatan_id'])) {
            $query->where('kegiatan_id', $filters['kegiatan_id']);
        }

        if (!empty($filters['kategori'])) {
            $query->where('kategori', $filters['kategori']);
        }

        if (!empty($filters['tanggal']) && empty($filters['kegiatan_id'])) {
            $query->whereHas('kegiatan', function ($q) use ($filters) {
                $q->whereDate('tanggal', $filters['tanggal']);
            });
        }

        if (!empty($filters['kegiatan_id']) && !empty($filters['kategori'])) {
            $this->generateExpectedAttendees($filters['kegiatan_id'], $filters['kategori']);
        }

        if (!empty($filters['search'])) {
            $searchTerm = $filters['search'];
            $query->whereHas('peserta', function ($q) use ($searchTerm) {
                $q->where('nama', 'like', "%{$searchTerm}%");
            });
        }

        return $query->paginate(15);
    }

    public function generateExpectedAttendees($kegiatanId, $kategori)
    {
        $kegiatan = \App\Models\KegiatanPosyandu::find($kegiatanId);
        if (!$kegiatan) return;
        
        $pesertaList = collect();
        $pesertaType = '';

        if ($kategori === 'Balita') {
            $pesertaList = \App\Models\Balita::all();
            $pesertaType = \App\Models\Balita::class;
        } elseif ($kategori === 'Lansia') {
            $pesertaList = \App\Models\Lansia::all();
            $pesertaType = \App\Models\Lansia::class;
        } elseif ($kategori === 'Remaja') {
            $pesertaList = \App\Models\Remaja::all();
            $pesertaType = \App\Models\Remaja::class;
        } elseif ($kategori === 'WUS/PUS' || $kategori === 'Menyusui') {
            $pesertaList = \App\Models\Wus::all();
            $pesertaType = \App\Models\Wus::class;
        } elseif ($kategori === 'Kehamilan') {
            $pesertaList = \App\Models\Kehamilan::all();
            $pesertaType = \App\Models\Kehamilan::class;
        }

        foreach ($pesertaList as $peserta) {
            $exists = KehadiranKegiatan::where([
                'kegiatan_id' => $kegiatanId,
                'peserta_id' => $peserta->id,
                'peserta_type' => $pesertaType,
            ])->exists();

            if (!$exists) {
                KehadiranKegiatan::create([
                    'kegiatan_id' => $kegiatanId,
                    'user_id' => auth()->id() ?? 1, // Fallback if CLI
                    'peserta_id' => $peserta->id,
                    'peserta_type' => $pesertaType,
                    'kategori' => $kategori,
                    'status_kehadiran' => 'Belum Hadir',
                ]);
            }
        }
    }
}
