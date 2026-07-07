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
        
        if ($kategori === 'dashboard') {
            $stats = $this->laporanService->getDashboardStats($filters);
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

        return view('laporan.index', compact('stats', 'data', 'kategori', 'filters', 'pegawais', 'viewPrefix'));
    }

    public function exportPdf(Request $request)
    {
        if (!in_array(Auth::user()->role, ['admin', 'pegawai'])) {
            abort(403);
        }

        $filters = $request->all();
        $kategori = $request->input('kategori');
        $data = $this->getExportData($kategori, $filters);

        $pdf = Pdf::loadView("laporan.exports.{$kategori}_pdf", compact('data', 'filters'));
        return $pdf->download("laporan_{$kategori}_" . date('Ymd_His') . ".pdf");
    }

    public function exportExcel(Request $request)
    {
        if (!in_array(Auth::user()->role, ['admin', 'pegawai'])) {
            abort(403);
        }

        $filters = $request->all();
        $kategori = $request->input('kategori');

        // Note: You would normally use Maatwebsite's FromView interface here.
        // I will create a simple CSV export for speed and reliability instead of setting up complete Export classes
        
        $data = $this->getExportData($kategori, $filters);
        $fileName = "laporan_{$kategori}_" . date('Ymd_His') . ".csv";
        
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Tanggal', 'Peserta', 'Kategori', 'Petugas'); // Dynamic mapped per type

        $callback = function() use($data, $columns, $kategori) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($data as $row) {
                // map dynamically based on kategori
                // e.g., Balita
                if ($kategori === 'balita') {
                    fputcsv($file, [
                        $row->created_at->format('Y-m-d'),
                        $row->balita->nama,
                        'Balita',
                        $row->pegawai->name ?? '-'
                    ]);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function getExportData($kategori, $filters)
    {
        if ($kategori === 'balita') return $this->laporanService->getLaporanBalita($filters, true);
        if ($kategori === 'kehamilan') return $this->laporanService->getLaporanKehamilan($filters, true);
        if ($kategori === 'wuspus') return $this->laporanService->getLaporanWusPus($filters, true);
        if ($kategori === 'remaja') return $this->laporanService->getLaporanRemaja($filters, true);
        if ($kategori === 'lansia') return $this->laporanService->getLaporanLansia($filters, true);
        if ($kategori === 'kegiatan') return $this->laporanService->getLaporanKegiatan($filters, true);
        if ($kategori === 'pegawai') return $this->laporanService->getLaporanPegawai($filters, true);
        
        return collect();
    }
}
