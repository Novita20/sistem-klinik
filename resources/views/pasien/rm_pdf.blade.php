<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Rekam Medis</title>
    <style>
        body {
            font-family: sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        td,
        th {
            border: 1px solid #000;
            padding: 8px;
        }
    </style>
</head>

<body>
    <h2>Rekam Medis - Kunjungan {{ $rekam->kunjungan_id }}</h2>

    <p><strong>Nama Pasien:</strong> {{ $rekam->kunjungan->pasien->user->name ?? '-' }}</p>
    <p><strong>Tanggal Kunjungan:</strong> {{ $rekam->kunjungan->tgl_kunjungan }}</p>

    <table>
        <tr>
            <th>Keluhan</th>
            <td>{{ $rekam->kunjungan->keluhan }}</td>
        </tr>
        <tr>
            <th>Anamnesa</th>
            <td>{{ $rekam->anamnesa }}</td>
        </tr>
        <tr>
            <th>Diagnosa</th>
            <td>{{ $rekam->diagnosis }}</td>
        </tr>
        <tr>
            <th>Tindakan</th>
            <td>{{ $rekam->tindakan }}</td>
        </tr>
        <tr>
            <th>Hasil Pemeriksaan (TTV)</th>
            <td>
                @php $ttv = json_decode($rekam->ttv ?? '{}'); @endphp
                <ul>
                    <li>TD: {{ $ttv->tekanan_darah ?? '-' }}</li>
                    <li>Nadi: {{ $ttv->nadi ?? '-' }}</li>
                    <li>Suhu: {{ $ttv->suhu ?? '-' }}</li>
                    {{-- dst sesuai field --}}
                </ul>
            </td>
        </tr>
        <tr>
            <th>Resep Obat</th>
            <td>
                <ul>
                    @foreach ($rekam->resepObat as $resep)
                        <li>{{ $resep->obat->nama_obat }} - {{ $resep->dosis }} - {{ $resep->aturan_pakai }}</li>
                    @endforeach
                </ul>
            </td>
        </tr>
    </table>
</body>

</html>
