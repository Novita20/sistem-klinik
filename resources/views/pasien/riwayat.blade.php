@extends('layouts.main')

@section('content')
    <div class="container mt-4">
        <h3 class="mb-4">📋 Riwayat Kunjungan Anda</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if ($riwayat->isEmpty())
            <div class="alert alert-info">Belum ada riwayat kunjungan.</div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Tanggal</th>
                            <th>Poli</th>
                            <th>Dokter</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($riwayat as $kunjungan)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($kunjungan->waktu_kunjungan)->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}
                                </td>
                                <td>{{ $kunjungan->poli->nama ?? '-' }}</td>
                                <td>{{ $kunjungan->dokter->name ?? '-' }}</td>
                                <td>{{ ucfirst($kunjungan->status) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
