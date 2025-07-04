@extends('layouts.main')
@section('content')
    <div class="p-6 max-w-5xl mx-auto bg-white rounded-xl shadow-md space-y-6">

    @section('content-header')
        <div class="p-4">
            <h1 class="text-2xl font-bold text-gray-800 text-center">Resep Obat Pasien</h1>
        </div>
    @endsection

    {{-- ✅ Tabel Resep --}}
    @if ($reseps->isEmpty())
        <p class="text-gray-500">Belum ada resep untuk pasien ini.</p>
    @else
        <form method="GET" action="{{ route('dokter.resep') }}" class="mb-4">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari nama pasien atau obat..." class="p-2 border rounded">
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Cari</button>
        </form>
        <table class="min-w-full table-auto border text-center">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">No</th>
                    <th class="px-4 py-2 border">Nama Pasien</th>
                    <th class="px-4 py-2 border">Tanggal Kunjungan</th>
                    <th class="px-4 py-2 border">Nama Obat</th>
                    <th class="px-4 py-2 border">Jumlah</th>
                    <th class="px-4 py-2 border">Dosis</th>
                    <th class="px-4 py-2 border">Aturan Pakai</th>
                    <th class="px-4 py-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($reseps as $resep)
                    <tr>
                        <td class="px-4 py-2 border text-center">{{ $no++ }}</td>
                        <td class="px-4 py-2 border">{{ $resep->rekamMedis->kunjungan->pasien->user->name ?? '-' }}</td>
                        <td class="px-4 py-2 border">
                            {{ \Carbon\Carbon::parse($resep->rekamMedis->kunjungan->tgl_kunjungan)->format('d-m-Y H:i') }}
                        </td>
                        <td class="px-4 py-2 border">{{ $resep->obat->nama_obat ?? '-' }}</td>
                        <td class="px-4 py-2 border">{{ $resep->jumlah }}</td>
                        <td class="px-4 py-2 border">{{ $resep->dosis ?? '-' }}</td>
                        <td class="px-4 py-2 border">{{ $resep->aturan_pakai ?? '-' }}</td>
                        <td class="px-4 py-2 border">
                            <div class="flex items-center space-x-2">
                                {{-- Tombol Edit --}}
                                <a href="{{ route('dokter.resep.edit', $resep->id) }}"
                                    class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-xs">
                                    Edit
                                </a>

                                {{-- Tombol Delete --}}
                                <form action="{{ route('dokter.resep.destroy', $resep->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus resep ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>


                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $reseps->appends(['search' => request('search')])->links() }}
        </div>
    @endif

    <div class="text-right">
        <a href="{{ url()->previous() }}"
            class="inline-block bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
            ← Kembali
        </a>
    </div>
</div>
@endsection
