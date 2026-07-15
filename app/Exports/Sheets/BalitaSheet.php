<?php
namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BalitaSheet implements FromCollection, WithTitle, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $data;
    public function __construct($data) { $this->data = collect($data); }
    public function collection() { return $this->data; }
    public function title(): string { return "Balita"; }
    public function headings(): array { return ['No','Tanggal','Nama Balita','NIK','Tanggal Lahir','Usia (bulan)','Berat Badan (kg)','Tinggi Badan (cm)','Lika (cm)','Lila (cm)','Status Gizi','Imunisasi','Vitamin','Catatan','Rekomendasi','Petugas']; }
    public function map($row): array {
        static $i = 0; $i++;
        return [$i, $row->created_at->format('Y-m-d'), $row->balita?->nama ?? '-', $row->balita?->warga?->nik ?? '-', $row->balita?->tanggal_lahir ? $row->balita->tanggal_lahir->format('Y-m-d') : '-', $row->umur_bulan ?? '-', $row->berat_badan ?? '-', $row->tinggi_badan ?? '-', $row->lingkar_kepala ?? '-', $row->lingkar_lengan_atas ?? '-', $row->status_gizi_bbtb ?? '-', $row->imunisasi ? 'Ya' : 'Tidak', $row->vitamin ? 'Ya' : 'Tidak', $row->catatan ?? '-', $row->rekomendasi ?? '-', $row->pegawai->name ?? '-'];
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