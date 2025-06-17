<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

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
                <h2 class="mb-2">Selamat Datang 👋</h2>
                <p class="mb-4">Masukkan Username atau Name dan Password Anda</p>

                <!-- Alert messages -->
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <!-- Validation errors -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <input type="text" name="login" class="form-control" placeholder="Username atau Name "
                            value="{{ old('login') }}" required autofocus>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Masuk</button>
                </form>

                <div class="mt-4">
                    <a href="{{ url('/') }}" class="btn btn-light border">
                        ← Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
