<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\KegiatanPosyandu;
use App\Services\KegiatanPosyanduService;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class KegiatanController extends Controller
{
    use AuthorizesRequests;

    protected $kegiatanService;

    public function __construct(KegiatanPosyanduService $kegiatanService)
    {
        $this->kegiatanService = $kegiatanService;
    }

    public function index()
    {
        $this->authorize('viewAny', KegiatanPosyandu::class);
        $kegiatan = KegiatanPosyandu::latest()->paginate(10);
        return view('pegawai.kegiatan.index', compact('kegiatan'));
    }

    public function show($id)
    {
        $kegiatan = $this->kegiatanService->getKegiatanById($id);
        $this->authorize('view', $kegiatan);
        
        $pesertaTerdaftar = $kegiatan->kehadiran()->count();
        $jumlahHadir = $kegiatan->kehadiran()->where('status_kehadiran', 'Hadir')->count();
        $jumlahBelumHadir = $pesertaTerdaftar - $jumlahHadir;
        
        $jumlahSudahDilayani = $kegiatan->pelayanan()->count();
        $jumlahBelumDilayani = $jumlahHadir - $jumlahSudahDilayani;

        return view('Admin.kegiatan.show', compact('kegiatan', 'pesertaTerdaftar', 'jumlahHadir', 'jumlahBelumHadir', 'jumlahSudahDilayani', 'jumlahBelumDilayani'));
    }
}

