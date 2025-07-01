@extends('layouts.main')

@section('content')
    <div class="container mt-4">
        <h3 class="mb-4">📋 Riwayat Kunjungan Anda</h3>

        {{-- Flash message --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- Data riwayat --}}
        @if ($riwayat->isEmpty())
            <div class="alert alert-info">Belum ada riwayat kunjungan.</div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Keluhan</th>
                            <th>Dokter</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($riwayat as $kunjungan)
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($kunjungan->tgl_kunjungan ?? now())->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}
                                </td>
                                <td>{{ $kunjungan->keluhan ?? '-' }}</td>
                                <td>
                                    {{ $kunjungan->rekamMedis && $kunjungan->rekamMedis->dokter ? $kunjungan->rekamMedis->dokter->name : '-' }}
                                </td>
                                <td>
                                    @php
                                        $status = $kunjungan->status ?? 'belum_ditangani';
                                    @endphp

                                    @switch($status)
                                        @case('belum_ditangani')
                                            <span class="badge bg-warning text-dark">Belum Ditangani</span>
                                        @break

                                        @case('anamnesa_dokter')
                                            <span class="badge bg-primary">Anamnesa Dokter</span>
                                        @break

                                        @case('menunggu_pemeriksaan_paramedis')
                                            <span class="badge bg-info text-dark">Menunggu Pemeriksaan</span>
                                        @break

                                        @case('selesai_pemeriksaan_paramedis')
                                            <span class="badge bg-secondary">Pemeriksaan Selesai</span>
                                        @break

                                        @case('tindakan_dokter')
                                            <span class="badge bg-primary">Tindakan Dokter</span>
                                        @break

                                        @case('selesai')
                                            <span class="badge bg-success">Selesai</span>
                                        @break

                                        @default
                                            <span class="badge bg-dark">-</span>
                                    @endswitch
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
