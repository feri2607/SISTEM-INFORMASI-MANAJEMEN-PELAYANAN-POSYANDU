<?php
namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RingkasanSheet implements FromArray, WithTitle, WithStyles, ShouldAutoSize
{
    protected $filters;
    protected $stats;

    public function __construct($filters, $stats)
    {
        $this->filters = $filters;
        $this->stats = $stats;
    }

    public function array(): array
    {
        $periode = $this->filters["periode"] ?? "Semua";
        if (isset($this->filters["start_date"])) {
            $periode .= " (" . $this->filters["start_date"] . " - " . $this->filters["end_date"] . ")";
        }
        $pegawai = !empty($this->filters["pegawai_id"]) ? "Filter ID: " . $this->filters["pegawai_id"] : "Semua Pegawai";
        $kategori = ucfirst($this->filters["kategori"] ?? "Semua");
        
        return [
            ["LAPORAN PELAYANAN POSYANDU"],
            ["POSYANDU DELIMA"],
            ["Alamat: Jl. Contoh Desa, RT 01/RW 02"],
            ["Telp: 081234567890 | Email: posyandu@desa.com"],
            [],
            ["Periode", $periode],
            ["Pegawai", $pegawai],
            ["Kategori", $kategori],
            ["Tanggal Export", date("Y-m-d H:i:s")],
            [],
            ["RINGKASAN STATISTIK"],
            ["Total Seluruh Pelayanan", $this->stats["total_pelayanan"] ?? 0],
            ["Balita Dilayani", $this->stats["balita_dilayani"] ?? 0],
            ["Ibu Hamil Dilayani", $this->stats["ibu_hamil_dilayani"] ?? 0],
            ["WUS/PUS Dilayani", $this->stats["wus_pus_dilayani"] ?? 0],
            ["Remaja Dilayani", $this->stats["remaja_dilayani"] ?? 0],
            ["Lansia Dilayani", $this->stats["lansia_dilayani"] ?? 0],
            ["Total Kegiatan Posyandu", $this->stats["total_kegiatan"] ?? 0],
            ["Pegawai Aktif", $this->stats["pegawai_aktif"] ?? 0],
        ];
    }

    public function title(): string
    {
        return "Ringkasan Laporan";
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle("A1:A4")->getFont()->setBold(true);
        $sheet->getStyle("A11")->getFont()->setBold(true);
        $sheet->getStyle("A6:A9")->getFont()->setBold(true);
        $sheet->getStyle("A12:A19")->getFont()->setBold(true);
    }
}
