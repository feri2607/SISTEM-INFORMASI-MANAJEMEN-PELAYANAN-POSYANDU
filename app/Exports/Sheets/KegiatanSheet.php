<?php
namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KegiatanSheet implements FromCollection, WithTitle, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $data;
    public function __construct($data) { $this->data = collect($data); }
    public function collection() { return $this->data; }
    public function title(): string { return "Kegiatan"; }
    public function headings(): array { return ['No','Nama Kegiatan','Tanggal','Waktu','Lokasi','Topik','Jumlah Terdaftar','Jumlah Hadir','Jumlah Dilayani']; }
    public function map($row): array {
        static $i = 0; $i++;
        return [$i, $row->nama_kegiatan ?? '-', $row->tanggal ?? '-', ($row->waktu_mulai ?? '-').' - '.($row->waktu_selesai ?? '-'), $row->lokasi ?? '-', $row->topik_pembahasan ?? '-', $row->kehadiran_count ?? '-', $row->hadir_count ?? '-', $row->dilayani_count ?? '-'];
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