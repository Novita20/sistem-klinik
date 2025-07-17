<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>PDF Rekam Medis</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
        }

        h1 {
            text-align: center;
            font-size: 18px;
            margin-bottom: 20px;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 5px;
            text-decoration: underline;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 4px 8px;
            vertical-align: top;
        }

        .info-table tr:nth-child(even) {
            background-color: #f7f7f7;
        }

        .bordered-table {
            border: 1px solid #000;
            width: 100%;
            margin-top: 10px;
        }

        .bordered-table th,
        .bordered-table td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
    </style>
</head>

<body>

    <h1>Detail Rekam Medis Pasien</h1>

    {{-- Informasi Umum --}}
    <div class="section">
        <table class="info-table">
            <tr>
                <td><strong>Nama Pasien:</strong></td>
                <td>{{ $rm->kunjungan->pasien->user->name ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Keluhan:</strong></td>
                <td>{{ $rm->kunjungan->keluhan ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal Kunjungan:</strong></td>
                <td>{{ \Carbon\Carbon::parse($rm->kunjungan->tgl_kunjungan)->format('d-m-Y H:i') }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal Ditangani:</strong></td>
                <td>{{ \Carbon\Carbon::parse($rm->created_at)->format('d-m-Y H:i') }}</td>
            </tr>
        </table>
    </div>

    {{-- Anamnesa --}}
    <div class="section">
        <div class="section-title">Anamnesa</div>
        <p>{{ $rm->anamnesa ?? '-' }}</p>
    </div>

    {{-- Diagnosa --}}
    <div class="section">
        <div class="section-title">Diagnosa</div>
        <p>{{ $rm->diagnosis ?? '-' }}</p>
    </div>

    {{-- Tindakan --}}
    <div class="section">
        <div class="section-title">Tindakan</div>
        <p>{{ $rm->tindakan ?? '-' }}</p>
    </div>

    {{-- Pemeriksaan TTV --}}
    @php $ttv = json_decode($rm->ttv ?? '{}'); @endphp
    <div class="section">
        <div class="section-title">Hasil Pemeriksaan (TTV)</div>
        <table class="info-table">
            <tr>
                <td><strong>Tekanan Darah:</strong></td>
                <td>{{ $ttv->tekanan_darah ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Nadi:</strong></td>
                <td>{{ $ttv->nadi ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Suhu:</strong></td>
                <td>{{ $ttv->suhu ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>RR:</strong></td>
                <td>{{ $ttv->rr ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>SpO₂:</strong></td>
                <td>{{ $ttv->spo2 ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>GDA:</strong></td>
                <td>{{ $ttv->gda ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Asam Urat:</strong></td>
                <td>{{ $ttv->asam_urat ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Kolesterol:</strong></td>
                <td>{{ $ttv->kolesterol ?? '-' }}</td>
            </tr>
        </table>
    </div>

    {{-- Resep Obat --}}
    <div class="section">
        <div class="section-title">Resep Obat</div>
        @if ($rm->resepObat->count())
            <table class="bordered-table">
                <thead>
                    <tr>
                        <th>Nama Obat</th>
                        <th>Dosis</th>
                        <th>Aturan Pakai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rm->resepObat as $resep)
                        <tr>
                            <td>{{ $resep->obat->nama_obat ?? '-' }}</td>
                            <td>{{ $resep->dosis ?? '-' }}</td>
                            <td>{{ $resep->aturan_pakai ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>-</p>
        @endif
    </div>

</body>

</html>
