<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Services\KehadiranService;
use Illuminate\Http\Request;

class PelayananHariIniController extends Controller
{
    protected $kehadiranService;

    public function __construct(KehadiranService $kehadiranService)
    {
        $this->kehadiranService = $kehadiranService;
    }

    public function index(Request $request)
    {
        if (count(array_intersect(['kegiatan_id', 'tanggal', 'kategori', 'search'], array_keys($request->all()))) > 0) {
            $filters = $request->session()->get('kehadiran_filters', []);
            if ($request->has('kegiatan_id')) $filters['kegiatan_id'] = $request->kegiatan_id;
            if ($request->has('tanggal')) $filters['tanggal'] = $request->tanggal;
            if ($request->has('kategori')) $filters['kategori'] = $request->kategori;
            if ($request->has('search')) $filters['search'] = $request->search;
            $request->session()->put('kehadiran_filters', $filters);
        } else {
            $filters = $request->session()->get('kehadiran_filters', []);
        }
        
        if (!isset($filters['tanggal'])) {
            $filters['tanggal'] = date('Y-m-d');
        }
        
        $kehadiran = $this->kehadiranService->getAttendees($filters);
        
        // Filter those who are marked as Hadir but optionally might need check if they are already served.
        // Actually, let's just get the collection and maybe filter out 'Sudah Dilayani' if needed? 
        // The prompt says "merouting ke form spesifik... Saat form pemeriksaan disimpan, status kehadiran diubah menjadi Sudah Dilayani".
        // Wait, KehadiranService doesn't have "Sudah Dilayani" status automatically. Wait, if status_kehadiran is explicitly "Sudah Dilayani", it means they were served.
        // Let's filter to only show 'Hadir' in the list.
        $pesertaHadir = $kehadiran->filter(function($k) {
            return $k->status_kehadiran === 'Hadir';
        });

        // Add Layani URLs
        foreach ($pesertaHadir as $item) {
            $item->layani_url = $this->generateLayaniUrl($item);
        }

        return view('pegawai.pelayanan_hari_ini.index', compact('pesertaHadir', 'filters', 'kehadiran'));
    }

    private function generateLayaniUrl($kehadiran)
    {
        if (!$kehadiran->peserta) return '#';

        $id = $kehadiran->peserta_id;
        
        switch ($kehadiran->kategori) {
            case 'Balita':
                return route('pegawai.balita.medis.pemeriksaan.create', ['balita' => $id]);
            case 'Kehamilan':
                return route('pegawai.kehamilan.anc.create', ['kehamilan' => $id]);
            case 'Lansia':
                return route('pegawai.lansia.pemeriksaan.create', ['lansia' => $id]);
            case 'Remaja':
                return route('pegawai.remaja.pemeriksaan.create', ['remaja' => $id]);
            case 'WUS/PUS':
            case 'Menyusui':
                return route('pegawai.reproduksi.pelayanan.create', ['wus' => $id]); // Assuming wus param for both
            default:
                return '#';
        }
    }
}

