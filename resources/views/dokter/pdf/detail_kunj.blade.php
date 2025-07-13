<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Detail Kunjungan Pasien</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        .section {
            margin-bottom: 15px;
        }

        .section h2 {
            font-size: 14px;
            margin-bottom: 5px;
        }

        .section p {
            margin: 0;
        }
    </style>
</head>

<body>
    <h1 style="text-align: center;">Detail Kunjungan Pasien</h1>

    <div class="section">
        <h2>Data Pasien</h2>
        <p><strong>Nama:</strong> {{ $kunjungan->pasien->user->name ?? '-' }}</p>
        <p><strong>NID:</strong> {{ $kunjungan->pasien->user->nid ?? '-' }}</p>
        <p><strong>Jenis Kelamin:</strong> {{ $kunjungan->pasien->jenis_kelamin ?? '-' }}</p>
        <p><strong>Tanggal Lahir:</strong>
            {{ \Carbon\Carbon::parse($kunjungan->pasien->tanggal_lahir)->format('d-m-Y') }}</p>
    </div>

    <div class="section">
        <h2>Data Kunjungan</h2>
        <p><strong>Tanggal Kunjungan:</strong>
            {{ \Carbon\Carbon::parse($kunjungan->tgl_kunjungan)->format('d-m-Y H:i') }}</p>
        <p><strong>Status:</strong> {{ ucwords(str_replace('_', ' ', $kunjungan->status)) }}</p>
        <p><strong>Keluhan:</strong> {{ $kunjungan->keluhan }}</p>
    </div>

    @if ($kunjungan->rekamMedis)
        <div class="section">
            <h2>Anamnesa</h2>
            <p>{{ $kunjungan->rekamMedis->anamnesa }}</p>
        </div>

        <div class="section">
            <h2>Diagnosa & Tindakan</h2>
            <p><strong>Diagnosa:</strong> {{ $kunjungan->rekamMedis->diagnosis }}</p>
            <p><strong>Tindakan:</strong> {{ $kunjungan->rekamMedis->tindakan }}</p>
        </div>

        <div class="section">
            <h2>Resep Obat</h2>
            @forelse ($kunjungan->rekamMedis->resepObat as $resep)
                <p>• {{ $resep->obat->nama_obat ?? '-' }} - {{ $resep->dosis ?? '-' }} -
                    {{ $resep->aturan_pakai ?? '-' }}</p>
            @empty
                <p>-</p>
            @endforelse
        </div>
    @endif
</body>

</html>
