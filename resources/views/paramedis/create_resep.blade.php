@extends('layouts.main')

@section('content')
    <div class="container mt-4">
        <h3 class="mb-4">Input Resep Obat</h3>

        <form action="{{ route('resep.store') }}" method="POST" class="card p-4 shadow-sm">
            @csrf

            {{-- Rekam Medis --}}
            <div class="mb-3">
                <label for="rekam_medis_id" class="form-label">Rekam Medis:</label>
                <select name="rekam_medis_id" id="rekam_medis_id" class="form-select" required>
                    <option value="">-- Pilih Rekam Medis --</option>
                    @foreach ($rekamMedis as $rm)
                        <option value="{{ $rm->id }}">
                            {{ $rm->id }} - {{ $rm->pasien->nama ?? 'Pasien tidak ditemukan' }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Obat --}}
            <div class="mb-3">
                <label for="obat_id" class="form-label">Obat:</label>
                <select name="obat_id" id="obat_id" class="form-select" required>
                    <option value="">-- Pilih Obat --</option>
                    @foreach ($obats as $obat)
                        <option value="{{ $obat->id }}">
                            {{ $obat->nama_obat }} - {{ $obat->satuan }} (Stok: {{ $obat->stok }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Jumlah --}}
            <div class="mb-3">
                <label for="jumlah" class="form-label">Jumlah:</label>
                <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" required>
            </div>

            {{-- Keterangan --}}
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan:</label>
                <textarea name="keterangan" id="keterangan" class="form-control" placeholder="Contoh: 3x1 setelah makan"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Resep</button>
        </form>
    </div>
@endsection
