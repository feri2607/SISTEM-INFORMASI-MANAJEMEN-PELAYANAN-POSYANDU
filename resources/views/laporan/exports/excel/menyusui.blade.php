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
            <th>ASI Eksklusif</th>
            <th>Berat Badan Ibu</th>
            <th>Vitamin</th>
            <th>Konseling</th>
            <th>Keluhan</th>
            <th>Catatan</th>
            <th>Petugas</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $i => $row)
        @php $warga = $row->wus?->warga ?? null; @endphp
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $row->created_at->format('Y-m-d') }}</td>
            <td>{{ $warga->nama ?? '-' }}</td>
            <td>{{ $warga->nik ?? '-' }}</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>{{ $row->keluhan ?? '-' }}</td>
            <td>{{ $row->catatan ?? '-' }}</td>
            <td>{{ $row->user->name ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
