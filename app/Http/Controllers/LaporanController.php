<?php
namespace App\Http\Controllers;

use App\Services\LaporanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
// We will generate simple exports or use Maatwebsite if requested

class LaporanController extends Controller
{
    protected $laporanService;

    public function __construct(LaporanService $laporanService)
    {
        $this->laporanService = $laporanService;
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', \App\Models\HasilPelayanan::class); // using a generic model or dummy
        // Note: I will use LaporanPolicy which I created, but it's not tied to a specific model.
        // We can just check Policy explicitly on user
        if (!in_array(Auth::user()->role, ['admin', 'pegawai'])) {
            abort(403, 'Unauthorized action.');
        }

        $filters = $request->only(['periode', 'start_date', 'end_date', 'kategori', 'pegawai_id']);
        $kategori = $filters['kategori'] ?? 'dashboard';

        $stats = [];
        $data = null;
        
        $staffLeaderboard = collect();
        if ($kategori === 'dashboard') {
            $stats = $this->laporanService->getDashboardStats($filters);
            $staffLeaderboard = collect($this->laporanService->getLaporanPegawai($filters))
                ->sortByDesc('total')
                ->take(5)
                ->values();
        } elseif ($kategori === 'balita') {
            $data = $this->laporanService->getLaporanBalita($filters);
        } elseif ($kategori === 'kehamilan') {
            $data = $this->laporanService->getLaporanKehamilan($filters);
        } elseif ($kategori === 'wuspus') {
            $data = $this->laporanService->getLaporanWusPus($filters);
        } elseif ($kategori === 'remaja') {
            $data = $this->laporanService->getLaporanRemaja($filters);
        } elseif ($kategori === 'lansia') {
            $data = $this->laporanService->getLaporanLansia($filters);
        } elseif ($kategori === 'kegiatan') {
            $data = $this->laporanService->getLaporanKegiatan($filters);
        } elseif ($kategori === 'pegawai') {
            $data = $this->laporanService->getLaporanPegawai($filters);
        }

        $viewPrefix = Auth::user()->role === 'admin' ? 'admin' : 'pegawai';
        $pegawais = \App\Models\User::where('role', 'pegawai')->get();

        return view('laporan.index', compact('stats', 'data', 'kategori', 'filters', 'pegawais', 'viewPrefix', 'staffLeaderboard'));
    }

    public function exportPdf(Request $request)
    {
        if (!in_array(Auth::user()->role, ['admin', 'pegawai'])) {
            abort(403);
        }

        $filters = $request->all();
        $stats = $this->laporanService->getDashboardStats($filters);
        
        $datasets = $this->getAllDatasets($filters);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('laporan.exports.posyandu_pdf', compact('filters', 'stats', 'datasets'))
                    ->setPaper('a4', 'landscape');
                    
        return $pdf->download('Laporan_Posyandu_' . date('Y_m_d') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        if (!in_array(Auth::user()->role, ['admin', 'pegawai'])) {
            abort(403);
        }

        $filters = $request->all();
        $stats = $this->laporanService->getDashboardStats($filters);
        
        $datasets = $this->getAllDatasets($filters);

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\LaporanPosyanduExport($filters, $stats, $datasets), 
            'Laporan_Posyandu_' . date('Y_m_d') . '.xlsx'
        );
    }

    private function getAllDatasets($filters)
    {
        $datasets = [
            'balita' => $this->laporanService->getLaporanBalita($filters, true),
            'kehamilan' => $this->laporanService->getLaporanKehamilan($filters, true),
            'wuspus' => $this->laporanService->getLaporanWusPus($filters, true),
            'remaja' => $this->laporanService->getLaporanRemaja($filters, true),
            'lansia' => $this->laporanService->getLaporanLansia($filters, true),
            'kegiatan' => $this->laporanService->getLaporanKegiatan($filters, true),
            'pegawai' => $this->laporanService->getLaporanPegawai($filters, true),
        ];

        $semua = collect();
        foreach($datasets['balita'] as $row) { $row->nama_peserta = $row->balita?->nama ?? ''; $row->nik = $row->balita?->warga?->nik ?? ''; $semua->push($row); }
        foreach($datasets['kehamilan'] as $row) { $row->nama_peserta = $row->kehamilan?->warga?->nama ?? ''; $row->nik = $row->kehamilan?->warga?->nik ?? ''; $semua->push($row); }
        foreach($datasets['wuspus'] as $row) { $row->nama_peserta = $row->wus?->warga?->nama ?? ''; $row->nik = $row->wus?->warga?->nik ?? ''; $semua->push($row); }
        foreach($datasets['remaja'] as $row) { $row->nama_peserta = $row->remaja?->warga?->nama ?? ''; $row->nik = $row->remaja?->warga?->nik ?? ''; $semua->push($row); }
        foreach($datasets['lansia'] as $row) { $row->nama_peserta = $row->lansia?->warga?->nama ?? ''; $row->nik = $row->lansia?->warga?->nik ?? ''; $semua->push($row); }
        
        $datasets['semua'] = $semua->sortByDesc('created_at')->values();

        return $datasets;
    }
}

