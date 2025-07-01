@extends('layouts.main')

@php
    $hideSidebar = true;
@endphp

@section('navbar')
    {{-- Kosongkan untuk menyembunyikan navbar --}}
@endsection

@section('title', 'Beranda Klinik')

@section('content')
    @push('css')
        <style>
            html,
            body {
                margin: 0 !important;
                padding: 0 !important;
                overflow-x: hidden;
            }

            .content-wrapper {
                margin: 0 !important;
                padding: 0 !important;
            }
        </style>
    @endpush

    <!-- Hero Section -->
    <div class="relative h-[500px] md:h-[600px] overflow-hidden rounded-b-[80px] -mt-8">
        <div class="absolute inset-0 bg-cover bg-center"
            style="background-image: url('{{ asset('assets/dist/img/bg.jpg') }}');"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-blue-900 via-black/40 to-transparent"></div>

        <div class="relative z-10 flex items-center justify-center h-full text-center px-4">
            <div class="text-white max-w-3xl">
                <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-4">
                    Selamat Datang di Klinik PLN Nusantara Power Paiton
                </h1>
                <p class="text-lg md:text-xl mb-6">Kami berkomitmen memberikan pelayanan kesehatan terbaik untuk Anda.</p>
                <a href="#artikel" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition">
                    Baca Info Kesehatan
                </a>
            </div>
        </div>

        <!-- Curve Transition -->
        <div class="absolute bottom-0 w-full">
            <svg class="w-full h-16" viewBox="0 0 1440 320">
                <path fill="#f9fafb" fill-opacity="1"
                    d="M0,160L80,144C160,128,320,96,480,101.3C640,107,800,149,960,154.7C1120,160,1280,128,1360,112L1440,96L1440,0L1360,0C1280,0,1120,0,960,0C800,0,640,0,480,0C320,0,160,0,80,0L0,0Z">
                </path>
            </svg>
        </div>
    </div>

    <!-- Informasi Klinik -->
    <div class="bg-gray-50 py-16">
        <div class="max-w-6xl mx-auto px-4 grid md:grid-cols-3 gap-6">
            <!-- Jam Operasional -->
            <div class="border p-6 rounded-2xl shadow text-center bg-white">
                <i class="fas fa-clock text-3xl text-blue-500 mb-3"></i>
                <h5 class="font-semibold text-lg mb-3">Jam Operasional</h5>
                <ul class="space-y-1 text-sm text-gray-700">
                    <li>Senin - Kamis: 08.00 - 19.00</li>
                    <li>Jumat: 08.00 - 18.30</li>
                    <li>Sabtu: 09.30 - 17.00</li>
                    <li>Minggu: 09.30 - 15.00</li>
                </ul>
            </div>

            <!-- Darurat -->
            <div class="border p-6 rounded-2xl shadow text-center bg-blue-50">
                <i class="fas fa-phone-alt text-3xl text-blue-600 mb-3"></i>
                <h5 class="font-semibold text-lg mb-3">Darurat</h5>
                <p class="text-sm text-gray-600">Hubungi kami segera di:</p>
                <p class="font-bold text-blue-800 text-xl">+62 812 3456 7890</p>
            </div>

            <!-- Janji Temu -->
            <div class="border p-6 rounded-2xl shadow text-center bg-white">
                <i class="fas fa-calendar-check text-3xl text-green-500 mb-3"></i>
                <h5 class="font-semibold text-lg mb-3">Buat Janji Temu</h5>
                <form>
                    <input type="text" class="form-input w-full mb-2" placeholder="Nama">
                    <input type="tel" class="form-input w-full mb-2" placeholder="Nomor HP">
                    <select class="form-select w-full mb-2">
                        <option>Pilih Dokter</option>
                    </select>
                    <button class="btn btn-primary w-full">Buat Janji</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Artikel Kesehatan -->
    <div id="artikel" class="bg-gray-100 py-16">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-2xl font-bold text-center mb-10">Info & Artikel Kesehatan</h2>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach ([['judul' => 'Tips Menjaga Kesehatan di Musim Pancaroba', 'isi' => 'Musim pancaroba rentan terhadap penyakit. Berikut tips agar tetap fit...'], ['judul' => 'Manfaat Pemeriksaan Kesehatan Rutin', 'isi' => 'Cek kesehatan rutin membantu deteksi dini penyakit serius. Pelajari lebih lanjut...'], ['judul' => 'Makanan Sehat untuk Jantung', 'isi' => 'Perhatikan nutrisi untuk menjaga kesehatan jantung Anda. Berikut rekomendasinya...']] as $artikel)
                    <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                        <h3 class="font-semibold text-lg mb-2">{{ $artikel['judul'] }}</h3>
                        <p class="text-sm text-gray-600">{{ $artikel['isi'] }}</p>
                        <a href="#" class="text-blue-500 text-sm mt-2 inline-block">Baca Selengkapnya</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
