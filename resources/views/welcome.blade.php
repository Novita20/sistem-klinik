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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
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

            .swiper {
                width: 100%;
                max-height: 500px;
            }

            .swiper-slide img {
                object-fit: cover;
                width: 100%;
                height: 100%;
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
                <a href="#artikel"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition">
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
                    <li>Senin - Kamis: 08.00 - 16.00</li>
                    <li>Jumat: 08.00 - 15.00</li>
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

            <!-- Info Kesehatan (Pengganti Janji Temu) -->
            <div class="border p-6 rounded-2xl shadow text-center bg-white relative overflow-hidden">
                <i class="fas fa-heartbeat text-3xl text-red-500 mb-3 animate-pulse"></i>
                <h5 class="font-semibold text-lg mb-4">💬 Kutipan Kesehatan</h5>

                <!-- Container untuk kutipan -->
                <div id="quote-slider" class="text-sm text-blue-700 italic transition-opacity duration-500 ease-in-out">
                    "Sehat bukan segalanya, tapi tanpa sehat segalanya tak berarti."
                </div>
            </div>

            <!-- JS untuk slide quote -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const quotes = [
                        "Sehat bukan segalanya, tapi tanpa sehat segalanya tak berarti.",
                        "Mencegah lebih baik daripada mengobati.",
                        "Tubuh yang sehat adalah rumah bagi jiwa yang kuat.",
                        "Minum air putih cukup bantu tubuh tetap bugar.",
                        "Tidur cukup adalah bentuk perawatan diri paling sederhana."
                    ];

                    let index = 0;
                    const quoteElement = document.getElementById('quote-slider');

                    setInterval(() => {
                        quoteElement.style.opacity = 0;
                        setTimeout(() => {
                            index = (index + 1) % quotes.length;
                            quoteElement.textContent = quotes[index];
                            quoteElement.style.opacity = 1;
                        }, 400); // transisi keluar sebelum masuk
                    }, 5000); // setiap 5 detik
                });
            </script>

        </div>
    </div>
    <!-- Galeri Foto -->
    <!-- Galeri Foto -->
    <div class="bg-white py-16">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-2xl font-bold text-center mb-10">Galeri Kegiatan & Fasilitas Klinik</h2>

            <div class="swiper w-full h-[500px] rounded-2xl overflow-hidden shadow-lg">
                <div class="swiper-wrapper">
                    <!-- Ganti gambar sesuai kebutuhan -->
                    <div class="swiper-slide">
                        <img src="{{ asset('assets/dist/img/galeri1.jpg') }}" class="w-full h-full object-cover"
                            alt="Foto 1">
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ asset('assets/dist/img/galeri2.jpg') }}" class="w-full h-full object-cover"
                            alt="Foto 2">
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ asset('assets/dist/img/galeri3.jpg') }}" class="w-full h-full object-cover"
                            alt="Foto 3">
                    </div>
                </div>
                <!-- Pagination + Optional Navigation -->
                <div class="swiper-pagination mt-4"></div>
            </div>
        </div>
    </div>

    <!-- Artikel Kesehatan -->
    <div id="artikel" class="bg-gray-100 py-16">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-2xl font-bold text-center mb-10">Info & Artikel Kesehatan</h2>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach ([
            [
                'judul' => 'Tips Menjaga Kesehatan di Musim Pancaroba',
                'isi' => 'Musim pancaroba rentan terhadap penyakit. Berikut tips agar tetap fit selama cuaca tidak menentu, menjaga imun dan kebugaran tubuh.',
                'link' => 'https://www.halodoc.com/artikel/6-tips-menjaga-daya-tahan-tubuh-di-musim-pancaroba',
            ],
            [
                'judul' => 'Manfaat Pemeriksaan Kesehatan Rutin',
                'isi' => 'Cek kesehatan rutin membantu deteksi dini penyakit serius. Jadwalkan pemeriksaan Anda untuk pencegahan dan penanganan lebih awal.',
                'link' => 'https://prodiadigital.com/id/artikel/ketahui-manfaat-pemeriksaan-kesehatan-dan-jenis-pemeriksaannya',
            ],
            [
                'judul' => 'Makanan Sehat untuk Jantung',
                'isi' => 'Perhatikan nutrisi untuk menjaga kesehatan jantung Anda. Konsumsi makanan rendah lemak, tinggi serat, dan hindari makanan olahan.',
                'link' => 'https://www.halodoc.com/artikel/6-makanan-sehat-untuk-menjaga-kesehatan-jantung',
            ],
        ] as $artikel)
                    <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                        <h3 class="font-semibold text-lg mb-2">{{ $artikel['judul'] }}</h3>
                        <p class="text-sm text-gray-600">{{ \Illuminate\Support\Str::limit($artikel['isi'], 100) }}</p>
                        <a href="{{ $artikel['link'] ?? 'javascript:void(0)' }}"
                            class="text-sm mt-2 inline-block hover:underline" style="color: #2563eb !important"
                            {{ $artikel['link'] ? 'target=_blank rel=noreferrer' : '' }}>
                            Baca Selengkapnya
                        </a>



                    </div>
                @endforeach
            </div>



            <!-- Lokasi Klinik -->
            <div class="bg-white py-16">
                <div class="max-w-6xl mx-auto px-4 text-center">
                    <h2 class="text-2xl font-bold mb-6">Lokasi Klinik PLN NP Paiton</h2>
                    <p class="text-gray-600 mb-6">Kunjungi kami langsung di lokasi kami untuk pelayanan terbaik.</p>

                    <div class="w-full h-[400px] rounded-xl overflow-hidden shadow-lg">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.261146230578!2d113.43136947416485!3d-7.763569476948276!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd6d35d9b69ad4b%3A0xd0d72cc086d9753!2sPLN%20Nusantara%20Power%20UP%20Paiton!5e0!3m2!1sid!2sid!4v1720584001234!5m2!1sid!2sid"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>

            @push('scripts')
                <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        new Swiper('.swiper', {
                            loop: true,
                            autoplay: {
                                delay: 3000,
                                disableOnInteraction: false,
                            },
                            pagination: {
                                el: '.swiper-pagination',
                                clickable: true,
                            },
                        });
                    });
                </script>
            @endpush

        @endsection
