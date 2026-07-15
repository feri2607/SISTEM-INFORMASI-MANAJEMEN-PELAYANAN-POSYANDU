<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pelayanan Posyandu</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; line-height: 1.4; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 18px; text-transform: uppercase; }
        .header p { margin: 3px 0 0; font-size: 12px; }
        .title { text-align: center; font-size: 14px; font-weight: bold; margin: 20px 0; text-transform: uppercase; }
        
        .info-table { border-collapse: collapse; margin-bottom: 20px; width: 40%; float: left; }
        .info-table td { padding: 3px; font-size: 11px; text-align: left; vertical-align: top;}
        .info-table td.label { width: 100px; font-weight: bold; }
        
        .clear { clear: both; }
        
        table.data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table.data-table th, table.data-table td { border: 1px solid #777; padding: 6px; font-size: 10px; text-align: left; }
        table.data-table th { background: #f0f0f0; font-weight: bold; }
        
        .section-title { font-size: 13px; font-weight: bold; margin-bottom: 8px; text-transform: uppercase; }
        
        .signatures { margin-top: 50px; width: 100%; }
        .signatures td { text-align: center; width: 50%; padding-top: 80px; }
        
        @page { margin: 40px; }
        .footer { position: fixed; bottom: -20px; left: 0px; right: 0px; height: 30px; border-top: 1px solid #aaa; padding-top: 5px; font-size: 9px; }
        .footer .page-number:after { content: counter(page); }
    </style>
</head>
<body>

    <div class="footer">
        <span style="float: left;">Dicetak otomatis oleh Sistem Informasi Posyandu pada {{ date('d F Y H:i:s') }}</span>
        <span style="float: right;">Halaman <span class="page-number"></span></span>
    </div>

    <div class="header">
        <h1>POSYANDU DELIMA</h1>
        <p>Alamat: Jl. Contoh Desa, RT 01/RW 02</p>
        <p>Telepon: 081234567890 | Email: posyandu@desa.com</p>
    </div>

    <div class="title">LAPORAN PELAYANAN POSYANDU</div>

    <table class="info-table">
        <tr><td class="label">Periode</td><td>: {{ $filters['periode'] ?? 'Semua' }} {{ isset($filters['start_date']) ? '('.$filters['start_date'].' - '.$filters['end_date'].')' : '' }}</td></tr>
        <tr><td class="label">Posyandu</td><td>: Delima</td></tr>
        <tr><td class="label">Pegawai</td><td>: {{ !empty($filters['pegawai_id']) ? 'Filter ID: '.$filters['pegawai_id'] : 'Semua Pegawai' }}</td></tr>
        <tr><td class="label">Kategori</td><td>: {{ ucfirst($filters['kategori'] ?? 'Semua') }}</td></tr>
        <tr><td class="label">Status</td><td>: Seluruh Pelayanan</td></tr>
        <tr><td class="label">Tanggal Cetak</td><td>: {{ date('d-m-Y H:i') }}</td></tr>
        <tr><td class="label">Dicetak Oleh</td><td>: {{ auth()->user()->name ?? 'Administrator' }}</td></tr>
    </table>
    <div class="clear"></div>

    <div class="section-title">RINGKASAN STATISTIK</div>
    <table class="data-table">
        <tr>
            <th>Total Pelayanan</th>
            <th>Balita Dilayani</th>
            <th>Ibu Hamil Dilayani</th>
            <th>WUS/PUS Dilayani</th>
            <th>Remaja Dilayani</th>
            <th>Lansia Dilayani</th>
            <th>Total Kegiatan</th>
            <th>Pegawai Aktif</th>
        </tr>
        <tr>
            <td>{{ $stats['total_pelayanan'] ?? 0 }}</td>
            <td>{{ $stats['balita_dilayani'] ?? 0 }}</td>
            <td>{{ $stats['ibu_hamil_dilayani'] ?? 0 }}</td>
            <td>{{ $stats['wus_pus_dilayani'] ?? 0 }}</td>
            <td>{{ $stats['remaja_dilayani'] ?? 0 }}</td>
            <td>{{ $stats['lansia_dilayani'] ?? 0 }}</td>
            <td>{{ $stats['total_kegiatan'] ?? 0 }}</td>
            <td>{{ $stats['pegawai_aktif'] ?? 0 }}</td>
        </tr>
    </table>

    <div style="page-break-after: always"></div>

    <div class="section-title">ISI LAPORAN (Detail Pelayanan)</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Peserta</th>
                <th>NIK</th>
                <th>Kategori</th>
                <th>Jenis Pelayanan / Kegiatan</th>
                <th>Nama Pegawai</th>
                <th>Status</th>
                <th>Catatan</th>
                <th>Rekomendasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($datasets['semua'] as $i => $row)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $row->created_at->format('d-m-Y') }}</td>
                <td>{{ $row->nama_peserta ?? '-' }}</td>
                <td>{{ $row->nik ?? '-' }}</td>
                <td>{{ current(explode('_', $row->getTable())) }}</td>
                <td>{{ $row->jenis_pelayanan ?? $row->nama_kegiatan ?? '-' }}</td>
                <td>{{ $row->pegawai->name ?? $row->user->name ?? '-' }}</td>
                <td>Pelayanan Selesai</td>
                <td>{{ $row->catatan ?? '-' }}</td>
                <td>{{ $row->status_gizi ?? $row->rekomendasi ?? '-' }}</td>
            </tr>
            @empty
            <tr><td colspan="10" style="text-align: center;">Tidak ada data pada periode dan filter ini.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">REKAP PEGAWAI</div>
    <table class="data-table" style="width: 60%">
        <thead>
            <tr>
                <th>Nama Pegawai</th>
                <th>Jumlah Pelayanan</th>
                <th>Persentase Kontribusi</th>
            </tr>
        </thead>
        <tbody>
            @php $maxTotal = collect($datasets['pegawai'])->sum('total') ?: 1; @endphp
            @foreach($datasets['pegawai'] as $pgw)
            <tr>
                <td>{{ $pgw->nama }}</td>
                <td>{{ $pgw->total }}</td>
                <td>{{ number_format(($pgw->total / $maxTotal) * 100, 1) }} %</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="page-break-after: always"></div>

    <div class="section-title">KESIMPULAN LAPORAN</div>
    <p>Berdasarkan data filter yang dipilih selama periode ini:</p>
    <ul>
        <li><b>Jumlah seluruh pelayanan:</b> {{ $stats['total_pelayanan'] ?? 0 }} sesi</li>
        <li><b>Kategori terbanyak:</b> 
            @php
                $cat = [
                    'Balita' => $stats['balita_dilayani'] ?? 0, 'Kehamilan' => $stats['ibu_hamil_dilayani'] ?? 0, 
                    'WUS/PUS' => $stats['wus_pus_dilayani'] ?? 0, 'Remaja' => $stats['remaja_dilayani'] ?? 0, 
                    'Lansia' => $stats['lansia_dilayani'] ?? 0
                ];
                arsort($cat);
                echo array_key_first($cat) . ' (' . current($cat) . ' sesi)';
            @endphp
        </li>
        <li><b>Pegawai dengan kontribusi tertinggi:</b> 
            @php 
                $topPgw = collect($datasets['pegawai'])->sortByDesc('total')->first();
                echo $topPgw ? $topPgw->nama . ' (' . $topPgw->total . ' sesi)' : '-';
            @endphp
        </li>
    </ul>

    <table class="signatures">
        <tr>
            <td>
                Mengetahui,<br>
                <b>Ketua Posyandu</b><br>
                <br>
                ( _________________________ )
            </td>
            <td>
                Diterbitkan Oleh,<br>
                <b>Administrator Sistem</b><br>
                <br>
                ( _________________________ )
            </td>
        </tr>
    </table>

</body>
</html>
