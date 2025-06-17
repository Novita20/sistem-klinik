<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/login-style.css') }}">
</head>

<body>
    <div class="content-wrapper">
        <img src="{{ asset('assets/dist/img/pltu.jpg') }}" class="background-image" alt="Background PLTU">

        <div class="overlay">
            <div class="form-wrapper text-center">
                <img src="{{ asset('assets/dist/img/pln.png') }}" class="mb-3" style="width: 120px;">
                <h2 class="mb-2">Buat Akun Baru 📝</h2>
                <p class="mb-4">Silakan isi data Anda untuk mendaftar</p>

                <!-- Alert messages -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Nama"
                            value="{{ old('name') }}" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="username" class="form-control" placeholder="Username"
                            value="{{ old('username') }}" required>
                    </div>
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email"
                            value="{{ old('email') }}" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password_confirmation" class="form-control"
                            placeholder="Konfirmasi Password" required>
                    </div>
                    <div class="mb-3">
                        <select name="role" class="form-control" required>
                            <option value="" disabled selected>Pilih Role</option>
                            <option value="pasien">Pasien</option>
                            <option value="dokter">Dokter</option>
                            <option value="paramedis">Paramedis</option>
                            <option value="sdm">SDM</option>
                            <option value="k3">K3</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Daftar</button>

                    <div class="mt-3">
                        <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900">Sudah punya
                            akun?</a>
                    </div>

                    <div class="mt-3">
                        <a href="{{ url('/') }}" class="btn btn-secondary btn-sm">← Kembali ke Home</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
