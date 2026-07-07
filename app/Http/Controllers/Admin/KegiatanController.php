<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KegiatanPosyandu;
use App\Http\Requests\StoreKegiatanPosyanduRequest;
use App\Http\Requests\UpdateKegiatanPosyanduRequest;
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
        return view('Admin.kegiatan.index', compact('kegiatan'));
    }

    public function create()
    {
        $this->authorize('create', KegiatanPosyandu::class);
        return view('Admin.kegiatan.create');
    }

    public function store(StoreKegiatanPosyanduRequest $request)
    {
        $this->authorize('create', KegiatanPosyandu::class);
        $this->kegiatanService->createKegiatan($request->validated());
        return redirect()->route('admin.kegiatan.index')->with('success', 'Kegiatan Posyandu berhasil dibuat.');
    }

    public function show($id)
    {
        $kegiatan = $this->kegiatanService->getKegiatanById($id);
        $this->authorize('view', $kegiatan);
        
        $pesertaTerdaftar = $kegiatan->kehadiran()->count();
        $jumlahHadir = $kegiatan->kehadiran()->where('status_kehadiran', 'Hadir')->count();
        $jumlahBelumHadir = $pesertaTerdaftar - $jumlahHadir;
        
        // Asumsi HasilPelayanan terhubung ke kehadiran atau kegiatan
        $jumlahSudahDilayani = $kegiatan->pelayanan()->count();
        $jumlahBelumDilayani = $jumlahHadir - $jumlahSudahDilayani;

        return view('Admin.kegiatan.show', compact('kegiatan', 'pesertaTerdaftar', 'jumlahHadir', 'jumlahBelumHadir', 'jumlahSudahDilayani', 'jumlahBelumDilayani'));
    }

    public function edit($id)
    {
        $kegiatan = $this->kegiatanService->getKegiatanById($id);
        $this->authorize('update', $kegiatan);
        return view('Admin.kegiatan.edit', compact('kegiatan'));
    }

    public function update(UpdateKegiatanPosyanduRequest $request, $id)
    {
        $kegiatan = $this->kegiatanService->getKegiatanById($id);
        $this->authorize('update', $kegiatan);
        $this->kegiatanService->updateKegiatan($id, $request->validated());
        return redirect()->route('admin.kegiatan.index')->with('success', 'Kegiatan Posyandu berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kegiatan = $this->kegiatanService->getKegiatanById($id);
        $this->authorize('delete', $kegiatan);
        $this->kegiatanService->deleteKegiatan($id);
        return redirect()->route('admin.kegiatan.index')->with('success', 'Kegiatan Posyandu berhasil dihapus.');
    }

    public function updateStatus(Request $request, $id)
    {
        $kegiatan = $this->kegiatanService->getKegiatanById($id);
        $this->authorize('update', $kegiatan);
        $request->validate(['status' => 'required|in:Draft,Terjadwal,Berlangsung,Selesai,Dibatalkan']);
        $this->kegiatanService->updateStatus($id, $request->status);
        return redirect()->back()->with('success', 'Status Kegiatan berhasil diubah.');
    }
}

