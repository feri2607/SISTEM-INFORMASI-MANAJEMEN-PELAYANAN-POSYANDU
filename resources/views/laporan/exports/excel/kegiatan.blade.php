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
            <th>Nama Kegiatan</th>
            <th>Tanggal</th>
            <th>Waktu</th>
            <th>Lokasi</th>
            <th>Topik</th>
            <th>Jumlah Terdaftar</th>
            <th>Jumlah Hadir</th>
            <th>Jumlah Dilayani</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $i => $row)
        @php
            $hari = \Carbon\Carbon::parse($row->tanggal);
            $today = \Carbon\Carbon::today();
            $status = 'Akan Datang';
            if ($today->gt($hari)) $status = 'Selesai';
            elseif ($today->eq($hari)) $status = 'Hari Ini';
        @endphp
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $row->nama_kegiatan ?? '-' }}</td>
            <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('Y-m-d') }}</td>
            <td>{{ $row->waktu_mulai ?? '-' }} - {{ $row->waktu_selesai ?? '-' }}</td>
            <td>{{ $row->lokasi ?? '-' }}</td>
            <td>{{ $row->topik_pembahasan ?? '-' }}</td>
            <td>{{ $row->kehadiran_count ?? '-' }}</td>
            <td>{{ $row->hadir_count ?? '-' }}</td>
            <td>{{ $row->dilayani_count ?? '-' }}</td>
            <td>{{ $status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>