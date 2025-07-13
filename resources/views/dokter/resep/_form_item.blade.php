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
        <input type="number" name="jumlah[]" class="w-full border rounded px-2 py-1" min="1" required>
    </div>
    <div>
        <label class="block font-medium">Dosis</label>
        <input type="text" name="dosis[]" class="w-full border rounded px-2 py-1" placeholder="Contoh: 100 gr">
    </div>
    <div>
        <label class="block font-medium">Aturan Pakai</label>
        <div class="flex items-center gap-2">
            <input type="text" name="aturan_pakai[]" class="w-full border rounded px-2 py-1"
                placeholder="Contoh: 1x sehari">
            {{-- <button type="button" class="text-red-600 font-bold text-xl">&times;</button> --}}
        </div>
    </div>
</div>
