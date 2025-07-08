<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Export Rekam Medis</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #eee;
        }

        .judul {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            padding-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="judul">Laporan Rekam Medis</div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pasien</th>
                <th>Keluhan</th>
                <th>Anamnesa</th>
                <th>Diagnosa</th>
                <th>Tindakan</th>
                <th>TD</th>
                <th>Nadi</th>
                <th>Suhu</th>
                <th>RR</th>
                <th>SpO2</th>
                <th>GDA</th>
                <th>Asam Urat</th>
                <th>Kolesterol</th>
                <th>Resep Obat</th>
                <th>Tanggal Kunjungan</th>
                <th>Tanggal Ditangani</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rekammedis as $index => $rm)
                @php $ttv = json_decode($rm->ttv ?? '{}'); @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $rm->kunjungan->pasien->user->name ?? '-' }}</td>
                    <td>{{ $rm->kunjungan->keluhan ?? '-' }}</td>
                    <td>{{ $rm->anamnesa ?? '-' }}</td>
                    <td>{{ $rm->diagnosis ?? '-' }}</td>
                    <td>{{ $rm->tindakan ?? '-' }}</td>
                    <td>{{ $ttv->tekanan_darah ?? '-' }}</td>
                    <td>{{ $ttv->nadi ?? '-' }}</td>
                    <td>{{ $ttv->suhu ?? '-' }}</td>
                    <td>{{ $ttv->rr ?? '-' }}</td>
                    <td>{{ $ttv->spo2 ?? '-' }}</td>
                    <td>{{ $ttv->gda ?? '-' }}</td>
                    <td>{{ $ttv->asam_urat ?? '-' }}</td>
                    <td>{{ $ttv->kolesterol ?? '-' }}</td>
                    <td>
                        @foreach ($rm->resepObat as $resep)
                            {{ $resep->obat->nama_obat ?? '-' }} - {{ $resep->dosis ?? '-' }} -
                            {{ $resep->aturan_pakai ?? '-' }}<br>
                        @endforeach
                    </td>
                    <td>{{ \Carbon\Carbon::parse($rm->kunjungan->tgl_kunjungan)->format('d-m-Y H:i') }}</td>
                    <td>{{ \Carbon\Carbon::parse($rm->created_at)->format('d-m-Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
