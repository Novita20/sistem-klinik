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
                            <th class="px-4 py-2 border">No</th>
                            <th class="px-4 py-2 border">Nama Pasien</th>
                            <th class="px-4 py-2 border">Tanggal Kunjungan</th>
                            <th class="px-4 py-2 border">Keluhan</th>
                            <th class="px-4 py-2 border">Status</th>
                            <th class="px-4 py-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kunjungan as $k)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2">{{ $k->pasien->user->name ?? '-' }}</td>
                                <td class="px-4 py-2">
                                    {{ \Carbon\Carbon::parse($k->tgl_kunjungan)->format('d-m-Y H:i') }}
                                </td>
                                <td class="px-4 py-2">{{ $k->keluhan ?? '-' }}</td>
                                <td class="px-4 py-2">
                                    @php
                                        $status = $k->status ?? 'belum_ditangani';
                                        $label =
                                            [
                                                'belum_ditangani' => 'text-yellow-600',
                                                'anamnesa_dokter' => 'text-blue-600',
                                                'menunggu_pemeriksaan_paramedis' => 'text-indigo-600',
                                                'selesai_pemeriksaan_paramedis' => 'text-green-600',
                                                'tindakan_dokter' => 'text-purple-600',
                                                'selesai' => 'text-gray-700',
                                            ][$status] ?? 'text-red-600';
                                    @endphp
                                    <span class="font-semibold {{ $label }}">
                                        {{ ucwords(str_replace('_', ' ', $status)) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 flex gap-2">
                                    {{-- 🔍 Detail --}}
                                    <a href="{{ route('dokter.kunjungan.show', $k->id) }}"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs">
                                        Detail
                                    </a>

                                    {{-- ✏️ Edit --}}
                                    <a href="{{ route('dokter.kunjungan.edit', $k->id) }}"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs">
                                        Edit
                                    </a>

                                    {{-- 🗑️ Delete --}}
                                    <form action="{{ route('dokter.kunjungan.destroy', $k->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus kunjungan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs">
                                            Delete
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
