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
            <th>Nama Peserta</th>
            <th>NIK</th>
            <th>Kategori</th>
            <th>Catatan</th>
            <th>Rekomendasi / Status</th>
            <th>Nama Pegawai</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $i => $row)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $row->created_at->format('Y-m-d') }}</td>
            <td>{{ $row->nama_peserta ?? '-' }}</td>
            <td>{{ $row->nik ?? '-' }}</td>
            <td>{{ current(explode('_', $row->getTable())) }}</td>
            <td>{{ $row->catatan ?? '-' }}</td>
            <td>{{ $row->status_gizi ?? $row->rekomendasi ?? '-' }}</td>
            <td>{{ $row->pegawai->name ?? $row->user->name ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>