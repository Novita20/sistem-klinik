@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800">Riwayat Kunjungan Pasien</h1>
    </div>
@endsection

@section('content')
    <div class="p-6">
        <div class="mb-4 flex justify-between items-center">
            {{-- 🔍 Form Pencarian --}}
            <form method="GET" action="{{ route('paramedis.kunjungan.riwayat') }}" class="flex gap-2">
                <input type="text" name="search" placeholder="Cari nama pasien..." value="{{ request('search') }}"
                    class="px-4 py-2 border rounded-lg w-72" />
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                    Cari
                </button>
            </form>

            {{-- 📥 Tombol Export Excel --}}
            <a href="{{ route('paramedis.kunjungan.export', request()->query()) }}"
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 whitespace-nowrap">
                📥 Export Excel
            </a>
        </div>


        <div class="bg-white p-4 rounded-lg shadow">
            <table class="min-w-full table-auto border">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="px-4 py-2 border">No.</th>
                        <th class="px-4 py-2 border">Nama Pasien</th>
                        <th class="px-4 py-2 border">Tanggal Kunjungan</th>
                        <th class="px-4 py-2 border">Keluhan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($riwayatKunjungan as $kunjungan)
                        <tr>
                            <td class="px-4 py-2 border">
                                {{ $loop->iteration + ($riwayatKunjungan->currentPage() - 1) * $riwayatKunjungan->perPage() }}
                            </td>
                            <td class="px-4 py-2 border">{{ $kunjungan->pasien->user->name ?? '-' }}</td>
                            <td class="px-4 py-2 border">
                                {{ \Carbon\Carbon::parse($kunjungan->tgl_kunjungan)->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}
                            </td>
                            <td class="px-4 py-2 border">{{ $kunjungan->keluhan ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-gray-500">Belum ada riwayat kunjungan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $riwayatKunjungan->appends(['search' => request('search')])->links() }}
            </div>
        </div>
    </div>
@endsection
