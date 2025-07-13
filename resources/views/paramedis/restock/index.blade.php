@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Pengajuan Restock Obat</h1>
    </div>
@endsection

@section('content')
    <div class="p-6">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="mb-4">
            <a href="{{ route('paramedis.restock.create') }}" class="btn btn-primary">+ Ajukan Restock</a>
        </div>

        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-bordered text-sm">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama Obat</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Tanggal Pengajuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengajuan as $key => $item)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td>{{ $item->obat->nama_obat ?? '-' }}</td>
                                <td class="text-center">{{ $item->jumlah }}</td>
                                <td class="text-center">
                                    @if ($item->status == 'diajukan')
                                        <span class="badge bg-warning text-dark">Menunggu</span>
                                    @elseif ($item->status == 'disetujui')
                                        <span class="badge bg-success">Disetujui</span>
                                    @else
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->timezone('Asia/Jakarta')->format('d M Y H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada pengajuan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
