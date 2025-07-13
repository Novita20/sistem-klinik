@extends('layouts.main')

@section('head')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content-header')
    <div class="p-4">
        <h1 class="text-2xl font-bold text-gray-800">🧾 Resepkan Obat</h1>
    </div>
@endsection

@section('content')
    <div class="p-6 max-w-3xl mx-auto bg-white rounded shadow space-y-6">
        {{-- Flash message --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-800 p-3 rounded">
                ✅ {{ session('success') }}
            </div>
        @endif

        {{-- Validasi --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-800 p-3 rounded">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('dokter.resep.storeMultiple') }}" method="POST">
            @csrf
            <input type="hidden" name="rekam_medis_id" value="{{ $rekamMedis->id }}">

            {{-- Pasien --}}
            <div>
                <label class="font-semibold">Nama Pasien:</label>
                <p>{{ $rekamMedis->kunjungan->pasien->user->name ?? '-' }}</p>
            </div>

            {{-- Form item resep --}}
            <div id="resep-container">
                <div class="resep-item grid md:grid-cols-4 gap-4 items-end mb-4 border p-4 rounded bg-gray-50">
                    <div>
                        <label class="block font-medium">Obat</label>
                        <select name="obat_id[]" class="select-obat w-full" required>
                            <option value="">-- Pilih atau ketik obat --</option>
                            @foreach ($obats as $obat)
                                <option value="{{ $obat->id }}">{{ $obat->nama_obat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block font-medium">Jumlah</label>
                        <input type="number" name="jumlah[]" class="w-full border rounded px-2 py-1" min="1"
                            required>
                    </div>
                    <div>
                        <label class="block font-medium">Dosis</label>
                        <input type="text" name="dosis[]" class="w-full border rounded px-2 py-1"
                            placeholder="Contoh: 2x sehari">
                    </div>
                    <div>
                        <label class="block font-medium">Aturan Pakai</label>
                        <div class="flex items-center gap-2">
                            <input type="text" name="aturan_pakai[]" class="w-full border rounded px-2 py-1"
                                placeholder="Contoh: sesudah makan">
                            <button type="button" class="remove-item text-red-600 font-bold text-xl">&times;</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tombol tambah --}}
            <div class="text-right">
                <button type="button" id="tambah-resep"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                    + Tambah Resep Obat
                </button>
            </div>

            {{-- Submit --}}
            <div class="text-right mt-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
                    💾 Simpan Semua Resep
                </button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        function initializeSelect2(context) {
            $(context).find('.select-obat').select2({
                placeholder: 'Ketik nama obat...',
                minimumInputLength: 2,
                ajax: {
                    url: '{{ route('obat.autocomplete') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.map(function(item) {
                                return {
                                    id: item.id,
                                    text: item.nama_obat
                                };
                            })
                        };
                    },
                    cache: true
                },
                width: '100%'
            });
        }

        $(document).ready(function() {
            console.log("Script jalan");
            initializeSelect2(document);

            $('#tambah-resep').on('click', function() {
                console.log("Tombol tambah diklik");
                const newItem = $('.resep-item').first().clone();
                newItem.find('input, select').val('');
                $('#resep-container').append(newItem);
                initializeSelect2(newItem);
            });

            $(document).on('click', '.remove-item', function() {
                if ($('.resep-item').length > 1) {
                    $(this).closest('.resep-item').remove();
                }
            });
        });
    </script>
@endsection
