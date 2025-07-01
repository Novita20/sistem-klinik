@extends('layouts.main')

@section('content')
    <div class="container mt-4">
        <h3 class="mb-4">📋 Rekam Medis Anda</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if ($rekamMedis->count() == 0)
            <div class="alert alert-info">Belum ada data kunjungan Anda.</div>
        @else
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Tanggal Kunjungan</th>
                        <th>Anamnesa (Keluhan)</th>
                        <th>TTV</th>
                        <th>Diagnosa</th>
                        <th>Tindakan</th>
                        <th>Resep</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rekamMedis as $i => $rm)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($rm->tgl_kunjungan)->format('d-m-Y') }}</td>
                            <td>{{ $rm->keluhan ?? '-' }}</td>
                            <td>{{ $rm->rekamMedis->ttv ?? '-' }}</td>
                            <td>{{ $rm->rekamMedis->diagnosa ?? '-' }}</td>
                            <td>{{ $rm->rekamMedis->tindakan ?? '-' }}</td>
                            <td>{{ $rm->rekamMedis->resep ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
