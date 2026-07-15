<?php
namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RemajaSheet implements FromCollection, WithTitle, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $data;
    public function __construct($data) { $this->data = collect($data); }
    public function collection() { return $this->data; }
    public function title(): string { return "Remaja"; }
    public function headings(): array { return ['No','Tanggal','Nama','NIK','TB (cm)','BB (kg)','IMT','Lingkar Perut (cm)','Tekanan Darah','HB','Pemberian TTD','Gula Darah','Catatan','Petugas']; }
    public function map($row): array {
        static $i = 0; $i++;
        return [$i, $row->created_at->format('Y-m-d'), $row->remaja?->warga?->nama ?? '-', $row->remaja?->warga?->nik ?? '-', $row->tinggi_badan ?? '-', $row->berat_badan ?? '-', $row->imt ?? '-', $row->lingkar_perut ?? '-', ($row->sistole ?? '-').'/'.($row->diastole ?? '-'), $row->kadar_hb ?? '-', $row->pemberian_ttd ? 'Ya' : 'Tidak', $row->gula_darah ?? '-', $row->kondisi_umum ?? '-', $row->user?->name ?? '-'];
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