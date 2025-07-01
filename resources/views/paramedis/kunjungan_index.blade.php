@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800">Data Kunjungan Belum Ditangani</h1>
    </div>
@endsection

@section('content')
    <div class="p-6">
        <div class="bg-white p-6 rounded-xl shadow-md">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border">No.</th>
                            <th class="px-4 py-2 border">Nama Pasien</th>
                            <th class="px-4 py-2 border">Tanggal Kunjungan
                            </th>
                            <th class="px-4 py-2 border">Keluhan</th>
                            <th class="px-4 py-2 border">Status</th>
                            <th class="px-4 py-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($kunjungan as $item)
                            <tr>
                                <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 border">
                                    {{ $item->pasien->user->name ?? '-' }}
                                </td>
                                <td class="px-4 py-2 border">
                                    {{ $item->tgl_kunjungan ? \Carbon\Carbon::parse($item->tgl_kunjungan)->format('d-m-Y H:i') : '-' }}
                                </td>
                                <td class="px-4 py-2 border">
                                    {{ $item->keluhan ?? '-' }}
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap">
                                    @php
                                        $status = $item->status ?? 'belum_ditangani';
                                        $statusLabels = [
                                            'belum_ditangani' => [
                                                'label' => 'Belum Ditangani',
                                                'color' => 'text-yellow-600',
                                            ],
                                            'menunggu_pemeriksaan_paramedis' => [
                                                'label' => 'Menunggu Pemeriksaan Paramedis',
                                                'color' => 'text-yellow-600',
                                            ],
                                            'selesai_pemeriksaan_paramedis' => [
                                                'label' => 'Menunggu Pemeriksaan Dokter',
                                                'color' => 'text-blue-600',
                                            ],
                                            'anamnesa_dokter' => [
                                                'label' => 'Sedang Diperiksa Dokter',
                                                'color' => 'text-indigo-600',
                                            ],
                                            'selesai_pemeriksaan_dokter' => [
                                                'label' => 'Menunggu Obat',
                                                'color' => 'text-green-600',
                                            ],
                                            'resep_diberikan' => [
                                                'label' => 'Obat Telah Diberikan',
                                                'color' => 'text-purple-600',
                                            ],
                                            'sudah_ditangani' => [
                                                'label' => 'Sudah Ditangani',
                                                'color' => 'text-green-700',
                                            ],
                                            'selesai' => ['label' => 'Pemeriksaan Selesai', 'color' => 'text-gray-700'],
                                        ];
                                        $statusInfo = $statusLabels[$status] ?? [
                                            'label' => 'Status Tidak Dikenal',
                                            'color' => 'text-red-600',
                                        ];
                                    @endphp
                                    <span class="{{ $statusInfo['color'] }} font-semibold">{{ $statusInfo['label'] }}</span>
                                </td>
                                <td class="px-4 py-2 border">
                                    <a href="{{ route('paramedis.kunjungan.show', $item->id) }}"
                                        class="text-indigo-600 hover:text-indigo-900 font-semibold">
                                        Lihat Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-500">
                                    Tidak ada kunjungan yang perlu ditangani saat ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
