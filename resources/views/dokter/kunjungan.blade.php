@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800">Data Kunjungan Pasien</h1>
    </div>
@endsection

@section('content')
    <div class="p-6">
        <div class="bg-white p-4 rounded-lg shadow">
            {{-- 🔍 Form Cari --}}
            <form method="GET" action="{{ route('dokter.kunjungan') }}" class="mb-4 flex items-center gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pasien..."
                    class="p-2 border rounded w-64">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Cari</button>
            </form>

            @if ($kunjungan->isEmpty())
                <p class="text-gray-500 italic">Belum ada kunjungan pasien.</p>
            @else
                {{-- 🗂️ Tabel Kunjungan --}}
                <table class="min-w-full table-auto text-sm border">
                    <thead class="bg-gray-100 text-left">
                        <tr>
                            <th class="px-4 py-2 border text-center">No</th>
                            <th class="px-4 py-2 border text-center">Nama Pasien</th>
                            <th class="px-4 py-2 border text-center">Tanggal Kunjungan</th>
                            <th class="px-4 py-2 border text-center">Keluhan</th>
                            <th class="px-4 py-2 border text-center">Status</th>
                            <th class="px-4 py-2 border text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kunjungan as $k)
                            <tr class="border-t">
                                <td class="px-4 py-2 text-center">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2">{{ $k->pasien->user->name ?? '-' }}</td>
                                <td class="px-4 py-2">
                                    {{ \Carbon\Carbon::parse($k->tgl_kunjungan)->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}
                                    WIB
                                </td>
                                <td class="px-4 py-2">{{ $k->keluhan ?? '-' }}</td>
                                <td class="px-4 py-2">
                                    @php
                                        $status = $k->status ?? 'belum_ditangani';
                                    @endphp

                                    @switch($status)
                                        @case('belum_ditangani')
                                            <span class="text-yellow-600 font-semibold">Belum Ditangani</span>
                                        @break

                                        @case('menunggu_pemeriksaan_paramedis')
                                            <span class="text-indigo-600 font-semibold">Menunggu Pemeriksaan Paramedis</span>
                                        @break

                                        @case('selesai_pemeriksaan_paramedis')
                                            <span class="text-green-600 font-semibold">Selesai Diperiksa Paramedis</span>
                                        @break

                                        @case('anamnesa_dokter')
                                            <span class="text-blue-600 font-semibold">Anamnesa Dokter</span>
                                        @break

                                        @case('tindakan_dokter')
                                            <span class="text-purple-600 font-semibold">Tindakan oleh Dokter</span>
                                        @break

                                        @case('selesai_pemeriksaan_dokter')
                                            <span class="text-green-700 font-semibold">Selesai Pemeriksaan Dokter</span>
                                        @break

                                        @case('resep_diberikan')
                                            <span class="text-pink-700 font-semibold">Resep Diberikan</span>
                                        @break

                                        @case('selesai')
                                            <span class="text-gray-700 font-semibold">Selesai</span>
                                        @break

                                        @default
                                            <span class="text-red-600 font-semibold">Status Tidak Dikenal</span>
                                    @endswitch
                                </td>
                                <td class="px-4 py-2 flex gap-2">
                                    {{-- 🔍 Detail --}}
                                    <a href="{{ route('dokter.kunjungan.show', $k->id) }}"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs">
                                        🔍 Detail
                                    </a>

                                    {{-- ✏️ Edit --}}
                                    <a href="{{ route('dokter.kunjungan.edit', $k->id) }}"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs">
                                        ✏️ Edit
                                    </a>

                                    {{-- 🗑️ Delete --}}
                                    <form action="{{ route('dokter.kunjungan.destroy', $k->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus kunjungan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs">
                                            🗑️ Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- 📄 Pagination --}}
                <div class="mt-4">
                    {{ $kunjungan->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
