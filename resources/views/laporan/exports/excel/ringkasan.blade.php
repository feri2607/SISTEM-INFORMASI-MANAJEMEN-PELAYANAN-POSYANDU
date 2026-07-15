<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
</head>
<body>
<table>
    <tr><th colspan="2">LAPORAN PELAYANAN POSYANDU</th></tr>
    <tr><th colspan="2">POSYANDU DELIMA</th></tr>
    <tr><th colspan="2">Alamat: Jl. Contoh Desa, RT 01/RW 02</th></tr>
    <tr><th colspan="2">Telp: 081234567890 | Email: posyandu@desa.com</th></tr>
    <tr><th colspan="2"></th></tr>
    
    <tr><td>Periode</td><td>{{ $filters['periode'] ?? 'Semua' }} {{ isset($filters['start_date']) ? '('.$filters['start_date'].' - '.$filters['end_date'].')' : '' }}</td></tr>
    <tr><td>Pegawai</td><td>{{ !empty($filters['pegawai_id']) ? 'Filter ID: '.$filters['pegawai_id'] : 'Semua Pegawai' }}</td></tr>
    <tr><td>Kategori</td><td>{{ ucfirst($filters['kategori'] ?? 'Semua') }}</td></tr>
    <tr><td>Tanggal Export</td><td>{{ date('Y-m-d H:i:s') }}</td></tr>
    <tr><td>Diekspor Oleh</td><td>{{ auth()->user()->name ?? 'Administrator' }}</td></tr>
    <tr><th colspan="2"></th></tr>
    
    <tr><th colspan="2">RINGKASAN STATISTIK</th></tr>
    <tr><td>Total Seluruh Pelayanan</td><td>{{ $stats['total_pelayanan'] ?? 0 }}</td></tr>
    <tr><td>Balita Dilayani</td><td>{{ $stats['balita_dilayani'] ?? 0 }}</td></tr>
    <tr><td>Ibu Hamil Dilayani</td><td>{{ $stats['ibu_hamil_dilayani'] ?? 0 }}</td></tr>
    <tr><td>WUS/PUS Dilayani</td><td>{{ $stats['wus_pus_dilayani'] ?? 0 }}</td></tr>
    <tr><td>Remaja Dilayani</td><td>{{ $stats['remaja_dilayani'] ?? 0 }}</td></tr>
    <tr><td>Lansia Dilayani</td><td>{{ $stats['lansia_dilayani'] ?? 0 }}</td></tr>
    <tr><td>Total Kegiatan Posyandu</td><td>{{ $stats['total_kegiatan'] ?? 0 }}</td></tr>
    <tr><td>Pegawai Aktif</td><td>{{ $stats['pegawai_aktif'] ?? 0 }}</td></tr>
</table>

</body>
</html>