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
            <th>Tekanan Darah</th>
            <th>Gula Darah</th>
            <th>Kolesterol</th>
            <th>Asam Urat</th>
            <th>IMT</th>
            <th>Kemandirian</th>
            <th>Status Mental</th>
            <th>Petugas</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $i => $row)
        @php $warga = $row->lansia?->warga ?? null; @endphp
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $row->created_at->format('Y-m-d') }}</td>
            <td>{{ $warga->nama ?? '-' }}</td>
            <td>{{ $warga->nik ?? '-' }}</td>
            <td>{{ $row->lansia?->umur ?? '-' }}</td>
            <td>{{ $row->sistole ?? '-' }}/{{ $row->diastole ?? '-' }}</td>
            <td>{{ $row->gula_darah ?? '-' }}</td>
            <td>{{ $row->kolesterol ?? '-' }}</td>
            <td>{{ $row->asam_urat ?? '-' }}</td>
            <td>{{ $row->imt ?? '-' }}</td>
            <td>{{ $row->indeks_kemandirian ?? '-' }}</td>
            <td>{{ $row->status_mental ?? '-' }}</td>
            <td>{{ $row->user->name ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
