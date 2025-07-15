@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800">Mutasi Obat</h1>
    </div>
@endsection

@section('content')
    <div class="p-6">
        {{-- ✅ Notifikasi sukses --}}
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 border border-green-300 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4 flex flex-wrap md:flex-nowrap justify-between items-center gap-4">
            {{-- 🔍 Form Pencarian --}}
            <form method="GET" action="{{ route('logobat.mutasi') }}" class="flex gap-2 items-center">
                <input type="text" name="search" placeholder="Cari nama obat..." value="{{ request('search') }}"
                    class="border border-gray-300 rounded-lg px-4 py-2 w-64" />
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Cari
                </button>
                @if (strlen(request('search')) > 0)
                    <a href="{{ route('logobat.mutasi') }}"
                        class="text-sm text-red-500 ml-2 hover:underline whitespace-nowrap">Reset</a>
                @endif
            </form>
        </div>

        {{-- 📊 Tabel Mutasi --}}
        <div class="bg-white p-4 rounded-xl shadow-md overflow-auto">
            <table class="min-w-full text-sm text-left border border-gray-200">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-2 border">No</th>
                        <th class="px-4 py-2 border">Nama Obat</th>
                        <th class="px-4 py-2 border">Jenis Mutasi</th>
                        <th class="px-4 py-2 border">Jumlah</th>
                        {{-- <th class="px-4 py-2 border">Stok Awal</th> --}}
                        <th class="px-4 py-2 border">Sisa Stok</th>
                        <th class="px-4 py-2 border">Tgl Transaksi</th>
                        <th class="px-4 py-2 border">Tgl Expired</th>
                        <th class="px-4 py-2 border">Keterangan</th>
                        <th class="px-4 py-2 border">Referensi</th>
                        <th class="px-4 py-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logObat as $index => $log)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border">{{ $logObat->firstItem() + $index }}</td>
                            <td class="px-4 py-2 border">{{ $log->obat->nama_obat ?? '-' }}</td>
                            <td class="px-4 py-2 border text-blue-700 font-semibold">{{ ucfirst($log->jenis_mutasi) }}</td>
                            <td class="px-4 py-2 border">{{ $log->jumlah }}</td>
                            {{-- <td class="px-4 py-2 border">{{ $log->stok_awal ?? 0 }}</td> --}}
                            <td class="px-4 py-2 border">{{ $log->sisa_stok ?? '-' }}</td>
                            <td class="px-4 py-2 border">
                                {{ $log->tgl_transaksi ? \Carbon\Carbon::parse($log->tgl_transaksi)->format('d-m-Y') : '-' }}
                            </td>
                            <td class="py-2 px-4 border">{{ \Carbon\Carbon::parse($log->expired_at)->format('d-m-Y') }}
                            </td>

                            <td class="px-4 py-2 border">{{ $log->keterangan ?? '-' }}</td>
                            <td class="px-4 py-2 border">
                                @if ($log->ref_type === 'obat')
                                    <span class="text-green-600 font-semibold">Input</span>
                                @elseif ($log->ref_type === 'resep')
                                    <span class="text-purple-600 font-semibold">Resep #{{ $log->ref_id }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-4 py-2 border space-x-2">
                                <a href="{{ route('logobat.edit', $log->id) }}"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center py-4 text-gray-500">Tidak ada data mutasi obat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- 📄 Pagination --}}
            <div class="mt-4">
                {{ $logObat->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
