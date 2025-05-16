@extends('layouts.main')

@php
    // $hidenavbar = true;
    $hideSidebar = true;
@endphp

@section('navbar')
    {{-- Kosongkan untuk menyembunyikan navbar --}}
@endsection


@section('title', 'Beranda Klinik')

@section('content')
    <!-- Hero Section -->
    <div class="relative h-[500px] md:h-[600px] overflow-hidden rounded-b-[80px]">
        <!-- Background Image -->
        <div class="absolute inset-0 bg-cover bg-center"
            style="background-image: url('{{ asset('assets/dist/img/poster.png') }}');"></div>

        <!-- Overlay -->
        {{-- <div class="absolute inset-0 bg-[#1D3557]/70"></div> --}}

        <!-- Content -->
        <div class="relative z-10 container mx-auto h-full flex items-center px-6 md:px-10">
            <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-10 w-full">
                {{-- <div class="text-white">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">The Best Medical Services</h1>
                    <p class="text-lg mb-6">Kami menyediakan layanan klinik terbaik untuk karyawan di PLN Nusantara Power
                        Paiton.</p>
                    <a href="#"
                        class="inline-block bg-white text-blue-600 font-semibold py-2 px-5 rounded shadow hover:bg-gray-100 transition">
                        Read More
                    </a>
                </div> --}}
            </div>
        </div>
    </div>


    <!-- Info Section -->
    <div class="container py-16">
        <div class="grid md:grid-cols-3 gap-6">
            <div class="border p-6 rounded shadow-sm">
                <h5 class="font-semibold text-lg mb-3">Opening Hours</h5>
                <ul class="space-y-1 text-sm">
                    <li>Mon - Thu: 08.00 - 19.00</li>
                    <li>Friday: 08.00 - 18.30</li>
                    <li>Saturday: 09.30 - 17.00</li>
                    <li>Sunday: 09.30 - 15.00</li>
                </ul>
            </div>
            <div class="border p-6 rounded shadow-sm bg-gray-50">
                <h5 class="font-semibold text-lg mb-3">Emergency</h5>
                <p class="text-sm">Hubungi kami di:</p>
                <p class="font-bold text-blue-600 text-lg">+62 812 3456 7890</p>
            </div>
            <div class="border p-6 rounded shadow-sm">
                <h5 class="font-semibold text-lg mb-3">Make an Appointment</h5>
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
    <!-- welcome.blade.php -->


    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Welcome</title>
        <!-- Link ke login-style.css jika khusus untuk login -->
        <link rel="stylesheet" href="{{ asset('css/login-style.css') }}">
    </head>

@endsection
