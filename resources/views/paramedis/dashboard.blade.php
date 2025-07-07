@extends('layouts.main')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4 text-2xl font-bold text-primary">👩‍⚕️ Selamat Datang, {{ Auth::user()->name }}</h2>

        {{-- Profil Singkat --}}
        <div class="card shadow-sm mb-4 border-left-primary">
            <div class="card-body d-flex align-items-center">
                <i class="bi bi-person-circle display-4 text-primary me-3"></i>
                <div>
                    <h5 class="mb-1">Profil Singkat</h5>
                    <p class="mb-1"><strong>Nama:</strong> {{ Auth::user()->name }}</p>
                    <p class="mb-1"><strong>NIK / No. Pegawai:</strong> {{ Auth::user()->nik ?? '-' }}</p>
                    <p class="mb-1"><strong>Jenis Kelamin:</strong> {{ Auth::user()->jenis_kelamin ?? '-' }}</p>
                    <p class="mb-0"><strong>Tanggal Lahir:</strong>
                        {{ Auth::user()->tanggal_lahir ? \Carbon\Carbon::parse(Auth::user()->tanggal_lahir)->format('d M Y') : '-' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Menu Utama --}}
        <div class="row">
            {{-- Input Keluhan --}}
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-left-info">
                    <div class="card-body text-center">
                        <i class="bi bi-journal-medical fs-1 text-info mb-3"></i>
                        <h5 class="card-title">Data Kunjungan</h5>
                        <p class="card-text">Input keluhan awal pasien sesuai tabel kunjungan.</p>
                        <a href="{{ route('kunjungan.form') }}" class="btn btn-info w-100">Input Keluhan</a>
                    </div>
                </div>
            </div>

            {{-- Riwayat Kunjungan --}}
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-left-warning">
                    <div class="card-body text-center">
                        <i class="bi bi-clock-history fs-1 text-warning mb-3"></i>
                        <h5 class="card-title">Riwayat Kunjungan</h5>
                        <p class="card-text">Lihat data kunjungan yang pernah Anda layani.</p>
                        <a href="{{ route('paramedis.kunjungan.hasil') }}" class="btn btn-warning text-dark w-100">Lihat
                            Riwayat</a>
                    </div>
                </div>
            </div>

            {{-- Rekam Medis --}}
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-left-secondary">
                    <div class="card-body text-center">
                        <i class="bi bi-file-medical fs-1 text-secondary mb-3"></i>
                        <h5 class="card-title">Rekam Medis</h5>
                        <p class="card-text">Lihat data rekam medis dari dokter untuk referensi obat.</p>
                        <a href="{{ route('rekam.medis') }}" class="btn btn-secondary w-100">Lihat Rekam Medis</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Edit Profil --}}
        <div class="text-end mt-4">
            <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                <i class="bi bi-pencil-square"></i> Edit Profil
            </a>
        </div>
    </div>
@endsection
