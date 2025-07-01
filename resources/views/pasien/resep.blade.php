@extends('layouts.main')

@section('content')
    <div class="container mt-4">
        <h3 class="mb-4">📄 Resep Obat Anda</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if ($resepObat->isEmpty())
            <div class="alert alert-info">Belum ada resep obat yang tersedia.</div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No.</th>
                            <th>Tanggal Kunjungan</th>
                            <th>Keluhan</th>
                            <th>Nama Obat</th>
                            <th>Jumlah</th>
                            <th>Dosis</th>
                            <th>Aturan Pakai</th>
                            <th>Tanggal Diberikan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($resepObat as $resep)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ optional($resep->rekamMedis->kunjungan)->tgl_kunjungan
                                    ? \Carbon\Carbon::parse($resep->rekamMedis->kunjungan->tgl_kunjungan)->format('d-m-Y H:i')
                                    : '-' }}
                                </td>
                                <td>{{ $resep->rekamMedis->kunjungan->keluhan ?? '-' }}</td>
                                <td>{{ $resep->obat->nama_obat ?? 'Obat Tidak Ditemukan' }}</td>
                                <td>{{ $resep->jumlah }} tablet</td>
                                <td>{{ $resep->dosis ?? '-' }}</td>
                                <td>{{ $resep->aturan_pakai ?? '-' }}</td>
                                <td>{{ $resep->created_at->format('d-m-Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
