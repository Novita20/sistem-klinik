@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800">Rekap Penggunaan Obat</h1>
    </div>
@endsection

@section('content')
    <div class="p-6">
        {{-- Tombol Export Excel --}}
        <div class="mb-4 flex justify-end">
            <form method="GET" action="{{ route('obat.rekap.export') }}">
                <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                <input type="hidden" name="end_date" value="{{ request('end_date') }}">
                <button type="submit"
                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 whitespace-nowrap">
                    📥 Export Excel
                </button>
            </form>
        </div>

        {{-- Tabel Rekap Obat --}}
        <div class="bg-white p-6 rounded-xl shadow w-full overflow-auto">

            {{-- Filter Rentang Tanggal --}}
            <div class="mb-4">
                <form method="GET" action="{{ route('obat.rekap') }}" class="flex flex-wrap items-end gap-4">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Dari Tanggal:</label>
                        <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                            class="form-input rounded px-3 py-1 border w-44" />
                    </div>
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700">Sampai Tanggal:</label>
                        <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                            class="form-input rounded px-3 py-1 border w-44" />
                    </div>

                    <div class="flex gap-2 mt-5">
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Terapkan</button>

                        <a href="{{ route('obat.rekap') }}"
                            class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Reset</a>
                    </div>
                </form>
            </div>


            <table class="table-auto w-full border text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2">No</th>
                        <th class="p-2">Nama Obat</th>
                        <th class="p-2">Total Masuk</th>
                        <th class="p-2">Total Keluar</th>
                        <th class="p-2">Sisa Stok</th>
                        <th class="p-2">Frekuensi Digunakan</th>
                        <th class="p-2">Terakhir Digunakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $index => $obat)
                        <tr class="border-t">
                            <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 border">{{ $obat['nama_obat'] }}</td>
                            <td class="px-4 py-2 border">{{ $obat['total_masuk'] }}</td>
                            <td class="px-4 py-2 border">{{ $obat['total_keluar'] }}</td>
                            <td class="px-4 py-2 border">{{ $obat['stok'] }}</td>
                            <td class="px-4 py-2 border">{{ $obat['frekuensi'] }} kali</td>
                            <td class="px-4 py-2 border">
                                {{ $obat['terakhir_digunakan'] ? \Carbon\Carbon::parse($obat['terakhir_digunakan'])->format('d-m-Y') : '-' }}
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">Tidak ada data penggunaan obat pada rentang ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
@endsection
