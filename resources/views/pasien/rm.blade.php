@extends('layouts.main')

@section('content')
    <div class="container mt-4">
        <h3 class="mb-4">📋 Rekam Medis Anda</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if ($rekamMedis->isEmpty())
            <div class="alert alert-info">Belum ada Data Rekam Medis Anda.</div>
        @else
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Tanggal Kunjungan</th>
                        <th>Keluhan</th>
                        <th>Diagnosa</th>
                        <th>Resep Obat</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rekamMedis as $rm)
                        <tr>
                            <td>{{ $rm->tgl_kunjungan }}</td>
                            <td>{{ $rm->keluhan ?? '-' }}</td>
                            <td>{{ $rm->diagnosa ?? '-' }}</td>
                            <td>{{ $rm->resep ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
