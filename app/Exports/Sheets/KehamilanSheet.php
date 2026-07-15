<?php
namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KehamilanSheet implements FromCollection, WithTitle, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $data;
    public function __construct($data) { $this->data = collect($data); }
    public function collection() { return $this->data; }
    public function title(): string { return "Kehamilan"; }
    public function headings(): array { return ['No','Tanggal','Nama Ibu','NIK','Usia Kandungan (mgg)','Kehamilan Ke-','Berat Badan (kg)','Tekanan Darah','LILA (cm)','LILA Status','Keluhan','ANC','Catatan','Rekomendasi','Petugas']; }
    public function map($row): array {
        static $i = 0; $i++;
        return [$i, $row->created_at->format('Y-m-d'), $row->kehamilan?->warga?->nama ?? '-', $row->kehamilan?->warga?->nik ?? '-', $row->usia_kandungan_minggu ?? '-', $row->hamil_ke ?? '-', $row->berat_badan ?? '-', ($row->sistole ?? '-').'/'.($row->diastole ?? '-'), $row->lingkar_lengan_atas ?? '-', $row->status_lila ?? '-', $row->keluhan_sekarang ?? '-', $row->pemeriksaan_anc ?? '-', $row->catatan ?? '-', $row->saran ?? '-', $row->user?->name ?? '-'];
    }
    public function styles(Worksheet $sheet) {
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF036672']]
        ]);
        
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . $sheet->getHighestRow())->applyFromArray($styleArray);
    }
}