@extends('layouts.main')

@section('content')
    <div class="container mx-auto mt-4">
        <h2 class="text-xl font-bold mb-6 text-gray-800">💊 Resep Obat dari Dokter</h2>

        @if ($resepObat->isEmpty())
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6" role="alert">
                <p class="font-bold">Tidak ada data</p>
                <p>Belum ada resep obat dari dokter.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300 shadow-sm rounded">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="px-4 py-2 border">No.</th>
                            <th class="px-4 py-2 border">Nama Pasien</th>
                            <th class="px-4 py-2 border">Tanggal Kunjungan</th>
                            <th class="px-4 py-2 border">Keluhan</th>
                            <th class="px-4 py-2 border">Nama Obat</th>
                            <th class="px-4 py-2 border">Jumlah</th>
                            <th class="px-4 py-2 border">Dosis</th>
                            <th class="px-4 py-2 border">Aturan Pakai</th>
                            <th class="px-4 py-2 border">Tanggal Diberikan</th>
                            <th class="px-4 py-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($resepObat as $resep)
                            <tr class="text-center hover:bg-gray-50">
                                <td>{{ $loop->iteration }}</td>
                                <td class="border px-4 py-2">
                                    {{ $resep->pasien->user->name ?? '-' }}
                                </td>
                                <td>
                                    {{ optional($resep->rekamMedis->kunjungan)->tgl_kunjungan
                                        ? \Carbon\Carbon::parse($resep->rekamMedis->kunjungan->tgl_kunjungan)->format('d-m-Y H:i')
                                        : '-' }}
                                </td>
                                <td>{{ $resep->rekamMedis->kunjungan->keluhan ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $resep->obat->nama_obat ?? '-' }}</td>
                                <td>{{ $resep->jumlah }} tablet</td>
                                <td class="border px-4 py-2">{{ $resep->dosis ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $resep->aturan_pakai ?? '-' }}</td>
                                <td>{{ $resep->created_at->format('d-m-Y H:i') }}</td>
                                <td class="border px-4 py-2">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('resep.edit', $resep->id) }}"
                                            class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-sm">
                                            Edit
                                        </a>

                                        <form action="{{ route('resep.destroy', $resep->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus resep ini?')"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $resepObat->links() }}
            </div>
        @endif
    </div>
@endsection
