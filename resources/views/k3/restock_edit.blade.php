@extends('layouts.main')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg rounded-3 border-0">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Edit Status Pengajuan</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('k3.restock.update', $pengajuan->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- Informasi Obat --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Obat</label>
                                <input type="text" class="form-control" value="{{ $pengajuan->obat->nama_obat ?? '-' }}"
                                    readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Jumlah</label>
                                <input type="text" class="form-control" value="{{ $pengajuan->jumlah }}" readonly>
                            </div>

                            {{-- Status --}}
                            <div class="mb-3">
                                <label for="status" class="form-label fw-bold">Status</label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="diajukan" {{ $pengajuan->status == 'diajukan' ? 'selected' : '' }}>
                                        Diajukan</option>
                                    <option value="disetujui" {{ $pengajuan->status == 'disetujui' ? 'selected' : '' }}>
                                        Disetujui</option>
                                    <option value="ditolak" {{ $pengajuan->status == 'ditolak' ? 'selected' : '' }}>Ditolak
                                    </option>
                                </select>
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('k3.restock') }}" class="btn btn-secondary">← Batal</a>
                                <button type="submit" class="btn btn-success">💾 Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
