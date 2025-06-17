@extends('layouts.main')

@section('content')
    <div class="container mt-4">
        <h2>Edit Profil</h2>

        @if (session('status') === 'profile-updated')
            <div class="alert alert-success mt-2">Profil berhasil diperbarui.</div>
        @endif

        {{-- Form Update Profil --}}
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="form-group mt-3">
                <label for="name">Nama</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}"
                    required>
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email"
                    value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>


            <div class="form-group mt-3">
                <label for="profile_picture">Foto Profil</label>
                <input type="file" class="form-control-file" id="profile_picture" name="profile_picture" accept="image/*"
                    capture="environment">
                @error('profile_picture')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

                <div class="mt-2">
                    @if ($user->profile_picture)
                        <img id="preview-img" src="{{ asset('assets/dist/img/' . $user->profile_picture) }}" class="rounded"
                            width="100" style="cursor:pointer;">
                        <button type="button" id="remove-photo" class="btn btn-sm btn-danger mt-2">Hapus
                            Foto</button>
                    @else
                        <img id="preview-img" src="#" style="display:none;" class="rounded" width="100">
                    @endif
                </div>
                <input type="hidden" name="remove_photo" id="remove_photo" value="0">
            </div>

            <button type="submit" class="btn btn-primary mt-4">Simpan Perubahan</button>

    </div>
    </div>

    {{-- Script Preview Foto --}}
    <script>
        const fileInput = document.getElementById('profile_picture');
        const previewImg = document.getElementById('preview-img');
        const removeBtn = document.getElementById('remove-photo');
        const removeInput = document.getElementById('remove_photo');

        fileInput?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewImg.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });

        removeBtn?.addEventListener('click', function() {
            previewImg.src = '';
            previewImg.style.display = 'none';
            fileInput.value = '';
            removeInput.value = '1';
        });
    </script>
@endsection
