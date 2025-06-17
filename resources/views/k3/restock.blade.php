@extends('layouts.main')

@section('content')
    <div class="container mt-4">
        <h2>Pengajuan Restock Obat</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Obat</th>
                    <th>Jumlah</th>
                    <th>Diminta Oleh</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pengajuan as $item)
                    <tr>
                        <td>{{ $item->obat->nama_obat ?? '-' }}</td>
                        <td>{{ $item->jumlah }}</td>
                        <td>{{ $item->requestedBy->name ?? '-' }}</td>
                        <td><span class="badge bg-warning text-dark">{{ ucfirst($item->status) }}</span></td>
                        <td>
                            <form method="POST" action="{{ route('k3.restock.setujui', $item->id) }}" class="d-inline">
                                @csrf
                                <button class="btn btn-success btn-sm">Setujui</button>
                            </form>
                            <form method="POST" action="{{ route('k3.restock.tolak', $item->id) }}" class="d-inline">
                                @csrf
                                <button class="btn btn-danger btn-sm">Tolak</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
