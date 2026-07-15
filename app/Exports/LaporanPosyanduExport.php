<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LaporanPosyanduExport implements WithMultipleSheets
{
    use Exportable;

    protected $filters;
    protected $stats;
    protected $datasets;

    public function __construct(array $filters, array $stats, array $datasets)
    {
        $this->filters = $filters;
        $this->stats = $stats;
        $this->datasets = $datasets;
    }

    public function sheets(): array
    {
        return [
            new Sheets\RingkasanSheet($this->filters, $this->stats),
            new Sheets\DataPelayananSheet($this->datasets['semua'] ?? collect()),
            new Sheets\BalitaSheet($this->datasets['balita'] ?? collect()),
            new Sheets\KehamilanSheet($this->datasets['kehamilan'] ?? collect()),
            new Sheets\MenyusuiSheet($this->datasets['menyusui'] ?? collect()),
            new Sheets\WusPusSheet($this->datasets['wuspus'] ?? collect()),
            new Sheets\RemajaSheet($this->datasets['remaja'] ?? collect()),
            new Sheets\LansiaSheet($this->datasets['lansia'] ?? collect()),
            new Sheets\KegiatanSheet($this->datasets['kegiatan'] ?? collect()),
            new Sheets\KinerjaPegawaiSheet($this->datasets['pegawai'] ?? collect()),
        ];
    }
}
