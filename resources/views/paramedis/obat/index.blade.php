@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800">Data Obat</h1>
    </div>
@endsection

@section('content')
    <div class="p-6">
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 border border-green-300 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4 flex justify-between items-center">
            <a href="{{ route('obat.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                + Tambah Stok Obat
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-xl shadow-md">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="py-2 px-4 border">No</th>
                        <th class="py-2 px-4 border">Nama Obat</th>
                        <th class="py-2 px-4 border">Total Stok</th>
                        <th class="py-2 px-4 border">Jumlah Batch</th>
                        <th class="py-2 px-4 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($obats as $index => $obat)
                        {{-- Tampilkan hanya jika ada batch (log_obat) --}}
                        @if ($obat->logObat->isNotEmpty())
                            <tr class="hover:bg-gray-50">
                                <td class="py-2 px-4 border">{{ $obats->firstItem() + $index }}</td>
                                <td class="py-2 px-4 border">{{ $obat->nama_obat }}</td>
                                <td class="py-2 px-4 border">{{ $obat->logObat->sum('jumlah') }}</td> {{-- Jumlah total stok dari log_obat --}}
                                <td class="py-2 px-4 border">{{ $obat->logObat->count() }}</td> {{-- Jumlah batch --}}
                                <td class="py-2 px-4 border flex gap-2">
                                    <a href="{{ route('obat.detail', $obat->id) }}" class="text-blue-500 hover:underline">🔍
                                        Detail</a>

                                    <form action="{{ route('obat.destroy', $obat->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus obat ini? Semua batch juga akan ikut terhapus!')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline">🗑️ Hapus</button>
                                    </form>
                                </td>

                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500">
                                Belum ada stok obat yang diinputkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>
@endsection
