@extends('layouts.main')

@section('content')
    <div class="container mt-4">
        <h2>Laporan Penggunaan Restock Obat</h2>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Obat</th>
                    <th>Jumlah</th>
                    <th>Diminta Oleh</th>
                    <th>Disetujui Oleh</th>
                    <th>Tanggal Disetujui</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pengajuan as $item)
                    <tr>
                        <td>{{ $item->obat->nama_obat ?? '-' }}</td>
                        <td>{{ $item->jumlah }}</td>
                        <td>{{ $item->requestedBy->name ?? '-' }}</td>
                        <td>{{ $item->approvedBy->name ?? '-' }}</td>
                        <td>{{ $item->updated_at->format('d-m-Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
