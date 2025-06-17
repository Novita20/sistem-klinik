@extends('layouts.main')

@section('content')
    <div class="container mt-4">
        <h3 class="mb-4">📄 Resep Obat Anda</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if ($reseps->isEmpty())
            <div class="alert alert-info">Belum ada resep obat yang tersedia.</div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Nama Obat</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                            <th>Tanggal Diberikan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reseps as $resep)
                            <tr>
                                <td>{{ $resep->obat->nama ?? '-' }}</td>
                                <td>{{ $resep->jumlah }} tablet</td>
                                <td>{{ $resep->keterangan ?? '-' }}</td>
                                <td>{{ $resep->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
