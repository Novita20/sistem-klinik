@extends('layouts.auth')

@section('content')
    <style>
        body {
            background: url('{{ asset('assets/dist/img/pltu.jpg') }}') no-repeat center center fixed;
            background-size: cover;
            position: relative;
        }

        .dark-overlay::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.65);
            z-index: 0;
        }

        .reset-card {
            background: rgba(255, 255, 255, 0.97);
            border-radius: 20px;
            padding: 40px 30px;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
            animation: fadeInDown 0.6s ease-out;
            position: relative;
            z-index: 1;
        }

        .reset-title {
            font-size: 26px;
            font-weight: 700;
            color: #0d6efd;
        }

        .reset-subtitle {
            font-size: 14px;
            color: #6c757d;
        }

        .btn-reset {
            transition: 0.3s ease-in-out;
        }

        .btn-reset:hover {
            background-color: #0b5ed7;
        }

        @keyframes fadeInDown {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <div class="dark-overlay">
        <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="col-md-10 col-lg-6">
                <div class="reset-card">
                    <div class="text-center mb-4">
                        <img src="{{ asset('assets/dist/img/pln.png') }}" alt="Logo PLN" style="width: 70px;">
                        <h4 class="reset-title mt-3">Reset Password 🔐</h4>
                        <p class="reset-subtitle">Masukkan email yang terdaftar untuk menerima link reset password Anda.</p>
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success text-center">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Alamat Email</label>
                            <input type="email" id="email" name="email" class="form-control form-control-lg"
                                placeholder="contoh@email.com" required autofocus>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg btn-reset">
                                🔁 Kirim Link Reset
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <a href="{{ route('login') }}" class="text-decoration-none text-primary fw-semibold">
                            ← Kembali ke Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
