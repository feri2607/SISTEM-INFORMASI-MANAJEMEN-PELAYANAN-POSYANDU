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
            <th>Nama</th>
            <th>NIK</th>
            <th>Umur</th>
            <th>TB (cm)</th>
            <th>BB (kg)</th>
            <th>IMT</th>
            <th>Lingkar Perut (cm)</th>
            <th>Tekanan Darah</th>
            <th>HB</th>
            <th>Pemberian TTD</th>
            <th>Gula Darah</th>
            <th>Catatan</th>
            <th>Petugas</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $i => $row)
        @php $warga = $row->remaja?->warga ?? null; @endphp
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $row->created_at->format('Y-m-d') }}</td>
            <td>{{ $warga->nama ?? '-' }}</td>
            <td>{{ $warga->nik ?? '-' }}</td>
            <td>{{ $warga && $warga->tanggal_lahir ? $warga->tanggal_lahir->diffInYears($row->created_at) : '-' }}</td>
            <td>{{ $row->tinggi_badan ?? '-' }}</td>
            <td>{{ $row->berat_badan ?? '-' }}</td>
            <td>{{ $row->imt ?? '-' }}</td>
            <td>{{ $row->lingkar_perut ?? '-' }}</td>
            <td>{{ $row->sistole ?? '-' }}/{{ $row->diastole ?? '-' }}</td>
            <td>{{ $row->kadar_hb ?? '-' }}</td>
            <td>{{ $row->pemberian_ttd ? 'Ya' : 'Tidak' }}</td>
            <td>{{ $row->gula_darah ?? '-' }}</td>
            <td>{{ $row->kondisi_umum ?? '-' }}</td>
            <td>{{ $row->user->name ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
