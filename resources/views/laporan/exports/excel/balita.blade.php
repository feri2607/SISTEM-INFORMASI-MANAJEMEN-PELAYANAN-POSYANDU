<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
</head>
<body>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Nama Balita</th>
            <th>NIK</th>
            <th>Tanggal Lahir</th>
            <th>Usia (bulan)</th>
            <th>Berat Badan (kg)</th>
            <th>Tinggi Badan (cm)</th>
            <th>Lika (cm)</th>
            <th>Lila (cm)</th>
            <th>Status Gizi</th>
            <th>Imunisasi</th>
            <th>Vitamin</th>
            <th>Catatan</th>
            <th>Rekomendasi</th>
            <th>Petugas</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $i => $row)
        @php $warga = $row->balita?->warga ?? null; @endphp
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $row->created_at->format('Y-m-d') }}</td>
            <td>{{ $row->balita?->nama ?? '-' }}</td>
            <td>{{ $warga->nik ?? '-' }}</td>
            <td>{{ $row->balita?->tanggal_lahir ? $row->balita?->tanggal_lahir->format('Y-m-d') : '-' }}</td>
            <td>{{ $row->umur_bulan ?? '-' }}</td>
            <td>{{ $row->berat_badan ?? '-' }}</td>
            <td>{{ $row->tinggi_badan ?? '-' }}</td>
            <td>{{ $row->lingkar_kepala ?? '-' }}</td>
            <td>{{ $row->lingkar_lengan_atas ?? '-' }}</td>
            <td>{{ $row->status_gizi_bbtb ?? '-' }}</td>
            <td>{{ $row->imunisasi ? 'Ya' : 'Tidak' }}</td>
            <td>{{ $row->vitamin ? 'Ya' : 'Tidak' }}</td>
            <td>{{ $row->catatan ?? '-' }}</td>
            <td>{{ $row->rekomendasi ?? '-' }}</td>
            <td>{{ $row->pegawai->name ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
