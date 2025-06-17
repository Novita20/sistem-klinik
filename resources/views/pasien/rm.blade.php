@extends('layouts.main')

@section('content')
    <div class="container">
        <h1 class="mb-4">Rekam Medis Saya</h1>

        @if ($rekamMedis->isEmpty())
            <p>Tidak ada data rekam medis.</p>
        @else
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Tanggal Kunjungan</th>
                        <th>Keluhan</th>
                        <th>Diagnosa</th>
                        <th>Resep</th>
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
