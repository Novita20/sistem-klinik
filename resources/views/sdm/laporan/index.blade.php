@extends('layouts.main')

@section('content')
    <div class="container mt-5">
        <h2 class="text-center mb-4" style="font-weight: bold; font-size: 28px;">
            Laporan Penggunaan Obat
        </h2>

        {{-- 📥 Tombol Export Excel --}}
        <div class="mb-3 text-end">
            <a href="{{ route('laporan_obat.export', request()->query()) }}" class="btn btn-success">
                📥 Export Excel
            </a>
        </div>

        {{-- 🔍 Filter Tanggal dan Pencarian --}}
        <form method="GET" action="{{ route('laporan_obat') }}" class="row g-3 align-items-end mb-4">
            <div class="col-md-3">
                <label for="start_date" class="form-label fw-semibold">Dari Tanggal</label>
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>

            <div class="col-md-3">
                <label for="end_date" class="form-label fw-semibold">Sampai Tanggal</label>
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>

            <div class="col-md-4">
                <label for="search" class="form-label fw-semibold">Cari Nama Obat</label>
                <input type="text" name="search" class="form-control" placeholder="Contoh: Paracetamol"
                    value="{{ request('search') }}">
            </div>

            <div class="col-md-2 d-grid">
                <button type="submit" class="btn btn-primary">🔍 Cari</button>
            </div>
        </form>

        {{-- 📊 Tabel Laporan Penggunaan Obat --}}
        <div class="card shadow">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Obat</th>
                            <th>Frekuensi Digunakan</th>
                            <th>Terakhir Digunakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $index => $obat)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $obat['nama_obat'] }}</td>
                                <td>{{ $obat['frekuensi'] }} kali</td>
                                <td>
                                    {{ $obat['terakhir_digunakan'] ? \Carbon\Carbon::parse($obat['terakhir_digunakan'])->format('d-m-Y') : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-3">Tidak ada data penggunaan obat pada rentang ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
