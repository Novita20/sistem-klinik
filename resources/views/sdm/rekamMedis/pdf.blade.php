<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Rekam Medis - {{ $rekamMedis->kunjungan->pasien->user->name ?? '-' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 18px;
        }

        .section-title {
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 8px;
            border-bottom: 1px solid #999;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .info-table td {
            padding: 6px;
            vertical-align: top;
        }

        ul {
            margin: 5px 0 10px 20px;
            padding: 0;
        }

        .footer {
            position: absolute;
            bottom: 20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>

<body>

    <h2>Detail Rekam Medis Pasien</h2>

    <div class="section-title">Informasi Pasien</div>
    <table class="info-table">
        <tr>
            <td><strong>Nama Pasien:</strong></td>
            <td>{{ $rekamMedis->kunjungan->pasien->user->name ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>NID:</strong></td>
            <td>{{ $rekamMedis->kunjungan->pasien->user->nid ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Keluhan:</strong></td>
            <td>{{ $rekamMedis->kunjungan->keluhan ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Tanggal Kunjungan:</strong></td>
            <td>{{ \Carbon\Carbon::parse($rekamMedis->kunjungan->tgl_kunjungan)->format('d-m-Y H:i') }}</td>
        </tr>
        <tr>
            <td><strong>Tanggal Ditangani:</strong></td>
            <td>{{ \Carbon\Carbon::parse($rekamMedis->created_at)->format('d-m-Y H:i') }}</td>
        </tr>
    </table>

    <div class="section-title">Pemeriksaan</div>
    <p><strong>Anamnesa:</strong><br>{{ $rekamMedis->anamnesa ?? '-' }}</p>
    <p><strong>Diagnosa:</strong><br>{{ $rekamMedis->diagnosis ?? '-' }}</p>
    <p><strong>Tindakan:</strong><br>{{ $rekamMedis->tindakan ?? '-' }}</p>

    <div class="section-title">Hasil Pemeriksaan (TTV)</div>
    @php $ttv = json_decode($rekamMedis->ttv ?? '{}'); @endphp
    <ul>
        <li><strong>Tekanan Darah:</strong> {{ $ttv->tekanan_darah ?? '-' }}</li>
        <li><strong>Nadi:</strong> {{ $ttv->nadi ?? '-' }}</li>
        <li><strong>Suhu:</strong> {{ $ttv->suhu ?? '-' }}</li>
        <li><strong>RR:</strong> {{ $ttv->rr ?? '-' }}</li>
        <li><strong>SpO₂:</strong> {{ $ttv->spo2 ?? '-' }}</li>
        <li><strong>GDA:</strong> {{ $ttv->gda ?? '-' }}</li>
        <li><strong>Asam Urat:</strong> {{ $ttv->asam_urat ?? '-' }}</li>
        <li><strong>Kolesterol:</strong> {{ $ttv->kolesterol ?? '-' }}</li>
    </ul>

    <div class="section-title">Resep Obat</div>
    @if ($rekamMedis->resepObat->count())
        <ul>
            @foreach ($rekamMedis->resepObat as $resep)
                <li>{{ $resep->obat->nama_obat ?? '-' }} - {{ $resep->dosis ?? '-' }} -
                    {{ $resep->aturan_pakai ?? '-' }}</li>
            @endforeach
        </ul>
    @else
        <p>Tidak ada resep obat.</p>
    @endif

    <div class="footer">
        Halaman ini dicetak pada {{ now()->format('d-m-Y H:i') }}
    </div>
</body>

</html>
