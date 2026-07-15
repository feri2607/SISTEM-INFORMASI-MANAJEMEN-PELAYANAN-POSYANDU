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
            <th>Jenis Pelayanan</th>
            <th>Jenis KB</th>
            <th>Hasil Pemeriksaan</th>
            <th>Kontrol Berikutnya</th>
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
            <td>{{ $row->jenis_pelayanan_label ?? '-' }}</td>
            <td>{{ $row->jenis_kontrasepsi ?? '-' }}</td>
            <td>{{ $row->hasil_pemeriksaan ?? '-' }}</td>
            <td>{{ $row->jadwal_kontrol_berikutnya ? $row->jadwal_kontrol_berikutnya->format('Y-m-d') : '-' }}</td>
            <td>{{ $row->catatan ?? '-' }}</td>
            <td>{{ $row->user->name ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
