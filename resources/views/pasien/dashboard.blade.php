@extends('layouts.main')

@section('content')
    <div class="container">
        <h2 class="mb-4">Selamat Datang, {{ Auth::user()->name }}</h2>

        {{-- Profil Singkat --}}
        <div class="card mb-4">
            <div class="card-header">Profil Singkat</div>
            <div class="card-body">
                <p><strong>Nama:</strong> {{ Auth::user()->name }}</p>
                <p><strong>NIK / No. Pegawai:</strong> {{ Auth::user()->nik ?? '-' }}</p>
                <p><strong>Jenis Kelamin:</strong> {{ Auth::user()->jenis_kelamin ?? '-' }}</p>
                <p><strong>Tanggal Lahir:</strong>
                    {{ Auth::user()->tanggal_lahir ? \Carbon\Carbon::parse(Auth::user()->tanggal_lahir)->format('d M Y') : '-' }}
                </p>
            </div>
        </div>

        {{-- Menu Utama Paramedis --}}
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-header bg-info text-white">Data Kunjungan</div>
                    <div class="card-body">
                        <p>Input keluhan awal pasien sesuai tabel kunjungan.</p>
                        <a href="{{ route('kunjungan.form') }}" class="btn btn-info">Input Keluhan Awal</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-header bg-success text-white">Resep Obat</div>
                    <div class="card-body">
                        <p>Input resep berdasarkan hasil pemeriksaan atau instruksi dokter ringan.</p>
                        <a href="{{ route('pasien.resep.index') }}" class="btn btn-success">Input Resep</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-header bg-warning text-dark">Riwayat Kunjungan</div>
                    <div class="card-body">
                        <p>Melihat data kunjungan yang pernah Anda layani.</p>
                        <a href="{{ route('paramedis.kunjungan.hasil') }}" class="btn btn-warning text-dark">Lihat
                            Riwayat</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Rekam Medis (View Only) --}}
        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">Rekam Medis (View Only)</div>
            <div class="card-body">
                <p>Hanya melihat data rekam medis dari dokter sebagai referensi pemberian obat.</p>
                {{-- <a href="{{ route('rekam.medis') }}" class="btn btn-secondary">Lihat Rekam Medis</a> --}}
            </div>
        </div>

        {{-- Profil --}}
        <div class="card mb-4">
            <div class="card-header">Profil</div>
            <div class="card-body">
                <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profil</a>
            </div>
        </div>
    </div>
@endsection
