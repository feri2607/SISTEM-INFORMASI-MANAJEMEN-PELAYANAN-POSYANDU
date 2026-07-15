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
            <th>Nama Pegawai</th>
            <th>Balita</th>
            <th>Kehamilan</th>
            <th>Menyusui</th>
            <th>WUS/PUS</th>
            <th>Remaja</th>
            <th>Lansia</th>
            <th>Total Pelayanan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $i => $row)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $row->nama ?? '-' }}</td>
            <td>{{ $row->balita_count ?? 0 }}</td>
            <td>{{ $row->kehamilan_count ?? 0 }}</td>
            <td>0</td>
            <td>{{ $row->wus_count ?? 0 }}</td>
            <td>{{ $row->remaja_count ?? 0 }}</td>
            <td>{{ $row->lansia_count ?? 0 }}</td>
            <td>{{ $row->total ?? 0 }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>