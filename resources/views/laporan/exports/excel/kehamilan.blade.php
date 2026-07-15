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
            <th>Nama Ibu</th>
            <th>NIK</th>
            <th>Usia Kandungan (mgg)</th>
            <th>Kehamilan Ke-</th>
            <th>Berat Badan (kg)</th>
            <th>Tekanan Darah</th>
            <th>LILA (cm)</th>
            <th>LILA Status</th>
            <th>Keluhan</th>
            <th>ANC</th>
            <th>Catatan</th>
            <th>Rekomendasi</th>
            <th>Petugas</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $i => $row)
        @php $warga = $row->kehamilan?->warga ?? null; @endphp
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $row->created_at->format('Y-m-d') }}</td>
            <td>{{ $warga->nama ?? '-' }}</td>
            <td>{{ $warga->nik ?? '-' }}</td>
            <td>{{ $row->usia_kandungan_minggu ?? '-' }}</td>
            <td>{{ $row->hamil_ke ?? '-' }}</td>
            <td>{{ $row->berat_badan ?? '-' }}</td>
            <td>{{ $row->sistole ?? '-' }}/{{ $row->diastole ?? '-' }}</td>
            <td>{{ $row->lingkar_lengan_atas ?? '-' }}</td>
            <td>{{ $row->status_lila ?? '-' }}</td>
            <td>{{ $row->keluhan_sekarang ?? '-' }}</td>
            <td>{{ $row->pemeriksaan_anc ?? '-' }}</td>
            <td>{{ $row->catatan ?? '-' }}</td>
            <td>{{ $row->saran ?? '-' }}</td>
            <td>{{ $row->user->name ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
