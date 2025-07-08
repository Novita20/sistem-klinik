@extends('layouts.main')

@section('content')
    <div class="container mt-5">
        {{-- Judul Halaman --}}
        <h2 class="mb-4 text-center fw-bold" style="font-size: 32px;">
            Daftar Pengajuan Restock Obat
        </h2>

        {{-- Notifikasi Sukses --}}
        @if (session('success'))
            <div class="alert alert-success text-center">
                {{ session('success') }}
            </div>
        @endif

        {{-- 🔍 Filter dan Search --}}
        {{-- <div class="card shadow-sm mb-4 border-0">
            <div class="card-body"> --}}
        <form method="GET" action="{{ route('k3.restock') }}" class="mb-4">
            <div class="row align-items-end justify-content-between">
                {{-- Filter Status --}}
                <div class="col-md-4">
                    <label for="status" class="form-label fw-semibold">🔍 Filter Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">🌐 Semua Status</option>
                        <option value="diajukan" {{ request('status') == 'diajukan' ? 'selected' : '' }}>📤 Diajukan
                        </option>
                        <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>✅ Disetujui
                        </option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>❌ Ditolak</option>
                    </select>
                </div>

                {{-- Pencarian dan Tombol (rata kanan) --}}
                <div class="col-md-5 text-end">
                    <label for="search" class="form-label fw-semibold d-block text-start">Cari Nama Obat</label>
                    <div class="input-group">
                        <input type="text" name="search" id="search" class="form-control"
                            placeholder="Contoh: Paracetamol" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">
                            🔍 Cari
                        </button>
                        <a href="{{ route('k3.restock') }}" class="btn btn-outline-secondary">
                            Tampilkan Semua
                        </a>
                    </div>
                </div>
            </div>
        </form>

        {{-- </div>
        </div> --}}

        {{-- Tabel Data --}}
        <div class="card shadow">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Obat</th>
                            <th>Jumlah</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengajuan as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->obat->nama_obat ?? '-' }}</td>
                                <td>{{ $item->jumlah }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->timezone('Asia/Jakarta')->format('d M Y H:i') }}
                                </td>
                                <td>
                                    @if ($item->status == 'diajukan' || $item->status == 'menunggu')
                                        <span class="badge bg-warning text-dark">Menunggu</span>
                                    @elseif ($item->status == 'disetujui')
                                        <span class="badge bg-success">Disetujui</span>
                                    @else
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td>
                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('k3.restock.edit', $item->id) }}"
                                        class="btn btn-sm btn-primary mb-1">
                                        ✎ Edit
                                    </a>

                                    {{-- Tombol Hapus --}}
                                    <form method="POST" action="{{ route('k3.restock.destroy', $item->id) }}"
                                        class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pengajuan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">🗑 Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada pengajuan restock obat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="d-flex justify-content-center mt-3">
                    {{ $pengajuan->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
