@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800">Data Obat</h1>
    </div>
@endsection

@section('content')
    <div class="p-6">
        {{-- Notifikasi sukses --}}
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 border border-green-300 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Header atas tabel: tombol + search --}}
        <div class="mb-4 flex flex-col md:flex-row justify-between items-center gap-4">
            {{-- Tombol Tambah --}}
            <div class="flex gap-2">
                <a href="{{ route('obat.input') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    + Tambah Stok Obat
                </a>
                <a href="{{ route('obat.baru') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                    + Obat Baru
                </a>
            </div>

            {{-- 🔍 Form Pencarian --}}
            <form method="GET" action="{{ route('obat.index') }}" class="flex gap-2 items-center">
                <input type="text" name="search" placeholder="Cari nama obat..." value="{{ request('search') }}"
                    class="border border-gray-300 rounded-lg px-4 py-2 w-64" />
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Cari
                </button>
                @if (request('search'))
                    <a href="{{ route('obat.index') }}" class="text-sm text-red-500 ml-2 hover:underline">Reset</a>
                @endif
            </form>
        </div>

        {{-- Tabel Data Obat --}}
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-xl shadow-md">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="py-2 px-4 border">No</th>
                        <th class="py-2 px-4 border">Nama Obat</th>
                        <th class="py-2 px-4 border">Jenis</th>
                        <th class="py-2 px-4 border">Stok</th>
                        <th class="py-2 px-4 border">Satuan</th>
                        <th class="py-2 px-4 border">Tanggal Input</th>
                        <th class="py-2 px-4 border">Kadaluarsa</th>
                        <th class="py-2 px-4 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($obats as $index => $obat)
                        <tr class="hover:bg-gray-50">
                            <td class="py-2 px-4 border">{{ $obats->firstItem() + $index }}</td>
                            <td class="py-2 px-4 border">{{ $obat->nama_obat }}</td>
                            <td class="py-2 px-4 border">{{ $obat->jenis_obat }}</td>
                            <td class="py-2 px-4 border">{{ $obat->stok }}</td>
                            <td class="py-2 px-4 border">{{ $obat->satuan }}</td>
                            <td class="py-2 px-4 border">{{ \Carbon\Carbon::parse($obat->created_at)->format('d-m-Y') }}
                            </td>
                            <td class="py-2 px-4 border">{{ \Carbon\Carbon::parse($obat->expired_at)->format('d-m-Y') }}
                            </td>
                            <td class="py-2 px-4 border">
                                <a href="{{ route('obat.edit', $obat->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-gray-500">Tidak ada data obat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $obats->links() }}
        </div>
    </div>
@endsection
