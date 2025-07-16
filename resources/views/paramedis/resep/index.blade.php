@extends('layouts.main')

@section('content')
    <div class="container mx-auto mt-6">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Daftar Resep Obat</h2>

        @if ($resepObat->isEmpty())
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded mb-6" role="alert">
                <p class="font-bold">Belum Ada Resep</p>
                <p>Belum ada resep obat yang tersedia.</p>
            </div>
        @else
            <div class="overflow-x-auto bg-white rounded shadow-sm">
                <table class="min-w-full border border-gray-300">
                    <thead class="bg-gray-100 text-gray-700 text-center">
                        <tr>
                            <th class="px-4 py-2 border">No</th>
                            <th class="px-4 py-2 border">Nama Pasien</th>
                            <th class="px-4 py-2 border">Tgl. Kunjungan</th>
                            <th class="px-4 py-2 border">Keluhan</th>
                            <th class="px-4 py-2 border">Nama Obat</th>
                            <th class="px-4 py-2 border">Jumlah</th>
                            <th class="px-4 py-2 border">Dosis</th>
                            <th class="px-4 py-2 border">Aturan Pakai</th>
                            <th class="px-4 py-2 border">Tgl. Diberikan</th>
                            <th class="px-4 py-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($resepObat as $resep)
                            <tr class="text-center hover:bg-gray-50">
                                <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="border px-4 py-2">{{ $resep->pasien->user->name ?? '-' }}</td>
                                <td class="border px-4 py-2">
                                    {{ optional($resep->rekamMedis->kunjungan)->tgl_kunjungan
                                        ? \Carbon\Carbon::parse($resep->rekamMedis->kunjungan->tgl_kunjungan)->format('d-m-Y H:i')
                                        : '-' }}
                                </td>
                                <td class="border px-4 py-2">{{ $resep->rekamMedis->kunjungan->keluhan ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $resep->obat->nama_obat ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $resep->jumlah }} tablet</td>
                                <td class="border px-4 py-2">{{ $resep->dosis ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $resep->aturan_pakai ?? '-' }}</td>
                                <td class="border px-4 py-2">
                                    {{ optional($resep->logObat)->tgl_transaksi
                                        ? \Carbon\Carbon::parse($resep->logObat->tgl_transaksi)->format('d-m-Y H:i')
                                        : '-' }}
                                </td>
                                <td class="border px-4 py-2">
                                    {{-- ✅ Tombol Berikan & Reset --}}
                                    @if (!$resep->status_diberikan)
                                        <div class="flex flex-col items-center gap-1">
                                            {{-- 🔵 Tombol Berikan --}}
                                            <form action="{{ route('paramedis.resep.berikan', ['id' => $resep->id]) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin memberikan obat ini?');">
                                                @csrf
                                                <button type="submit"
                                                    class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm w-full">
                                                    Berikan
                                                </button>
                                            </form>

                                            {{-- ⚪ Tombol Reset Status --}}
                                            <form action="{{ route('resep.reset', $resep->id) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded text-xs w-full">
                                                    Reset Status
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <div class="flex flex-col items-center gap-1">
                                            <span class="text-green-600 font-semibold text-sm">✅ Sudah Diberikan</span>

                                            {{-- Optional: tombol reset meski sudah diberikan (untuk pengujian cepat) --}}
                                            <form action="{{ route('resep.reset', $resep->id) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded text-xs mt-1 w-full">
                                                    Reset Status
                                                </button>
                                            </form>
                                        </div>
                                    @endif


                                    {{-- ✅ Tombol Edit & Hapus --}}
                                    <div class="flex justify-center space-x-2 mt-2">
                                        <a href="{{ route('paramedis.resep.edit', $resep->id) }}"
                                            class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-sm">
                                            Edit
                                        </a>
                                        <form action="{{ route('paramedis.resep.destroy', $resep->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus resep ini?')">
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

            {{-- PAGINATION --}}
            <div class="mt-4">
                {{ $resepObat->links() }}
            </div>
        @endif
    </div>
@endsection
