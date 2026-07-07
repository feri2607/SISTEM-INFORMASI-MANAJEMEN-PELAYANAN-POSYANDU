<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\KegiatanPosyandu;
use App\Services\KehadiranService;
use Illuminate\Http\Request;

class RegistrasiKehadiranController extends Controller
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
        
        // If not specified, default to today's date if possible
        if (!isset($filters['tanggal'])) {
            $filters['tanggal'] = date('Y-m-d');
        }
        
        $kehadiran = $this->kehadiranService->getAttendees($filters);
        
        $kegiatanList = KegiatanPosyandu::whereDate('tanggal', '>=', date('Y-m-d', strtotime('-1 month')))
                                        ->whereDate('tanggal', '<=', date('Y-m-d', strtotime('+1 month')))
                                        ->orderBy('tanggal', 'desc')
                                        ->get();

        $stats = [
            'total' => $kehadiran->total(),
            'hadir' => $kehadiran->getCollection()->whereIn('status_kehadiran', ['Hadir', 'Sudah Dilayani'])->count(),
            'belum_hadir' => $kehadiran->getCollection()->whereNotIn('status_kehadiran', ['Hadir', 'Sudah Dilayani'])->count(),
        ];

        return view('pegawai.kehadiran.index', compact('kehadiran', 'kegiatanList', 'filters', 'stats'));
    }

    public function markHadir($id)
    {
        try {
            $this->kehadiranService->markAsPresent($id);
            return redirect()->back()->with('success', 'Peserta berhasil diregistrasi.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


}

