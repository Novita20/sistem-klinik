@extends('layouts.main')

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800 text-center">Daftar Rekam Medis</h1>
    </div>
@endsection

@section('content')
    <div class="p-6">
        <div class="mb-4 flex flex-wrap md:flex-nowrap justify-between items-center gap-2">
            {{-- 🔍 Form Pencarian --}}
            <form method="GET" action="{{ route('paramedis.rekammedis.index') }}" class="flex gap-2 items-center">
                <input type="text" name="search" placeholder="Cari nama pasien..." value="{{ request('search') }}"
                    class="border border-gray-300 rounded-lg px-4 py-2 w-64">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Cari
                </button>
                @if (request('search'))
                    <a href="{{ route('paramedis.rekammedis.index') }}"
                        class="text-sm text-red-500 ml-2 hover:underline">Reset</a>
                @endif
            </form>

            {{-- 📥 Tombol Export Excel --}}
            <a href="{{ route('paramedis.rekammedis.export', request()->query()) }}"
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 whitespace-nowrap">
                📥 Export Excel
            </a>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md overflow-x-auto">
            <table class="min-w-full w-full border border-gray-300 text-sm text-left">
                <thead class="bg-gray-100 text-gray-700 text-center">
                    <tr>
                        <th class="border px-3 py-2">No</th>
                        <th class="border px-3 py-2">Nama Pasien</th>
                        <th class="border px-3 py-2">Keluhan</th>
                        <th class="border px-3 py-2">Tanggal Kunjungan</th>
                        <th class="border px-3 py-2">Tanggal Ditangani</th>
                        <th class="border px-3 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rekammedis as $index => $rm)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-3 py-2 text-center">{{ $rekammedis->firstItem() + $index }}</td>
                            <td class="border px-3 py-2">{{ $rm->kunjungan->pasien->user->name ?? '-' }}</td>
                            <td class="border px-3 py-2">{{ $rm->kunjungan->keluhan ?? '-' }}</td>
                            <td class="border px-3 py-2">
                                {{ \Carbon\Carbon::parse($rm->kunjungan->tgl_kunjungan)->format('d-m-Y H:i') }}
                            </td>
                            <td class="border px-3 py-2">
                                {{ \Carbon\Carbon::parse($rm->created_at)->format('d-m-Y H:i') }}
                            </td>
                            <td class="border px-3 py-2 text-center whitespace-nowrap">
                                <div class="flex justify-center gap-1">
                                    <a href="{{ route('paramedis.rekammedis.show', $rm->id) }}"
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-xs">
                                        🔍 Detail
                                    </a>
                                    <a href="{{ route('paramedis.rekammedis.edit', $rm->id) }}"
                                        class="bg-yellow-400 hover:bg-yellow-500 text-white px-2 py-1 rounded text-xs">
                                        ✏️ Edit
                                    </a>
                                    <form action="{{ route('paramedis.rekammedis.destroy', $rm->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus rekam medis ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-xs">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-gray-500 py-4">Belum ada data rekam medis.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ✅ Pagination --}}
        <div class="mt-4">
            {{ $rekammedis->withQueryString()->links('pagination::tailwind') }}
        </div>
    </div>
@endsection
