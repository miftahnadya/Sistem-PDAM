<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PDAM Tirta Tamiang - Layanan Air Bersih Terpercaya</title>
    <meta name="description" content="PDAM Tirta Tamiang menyediakan layanan air bersih berkualitas untuk masyarakat Aceh Tamiang. Cek tagihan dan ajukan pengaduan dengan mudah.">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .bg-pdam {
            background-color: #508C9B !important;
        }
        .text-pdam {
            color: #0097a7 !important;
        }
        .ring-pdam {
            --tw-ring-color: #0097a7 !important;
        }
        html {
            scroll-behavior: smooth;
        }
        .fade-in {
            animation: fadeIn 0.8s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .slide-in-left {
            animation: slideInLeft 0.8s ease-out;
        }
        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-50px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .slide-in-right {
            animation: slideInRight 0.8s ease-out;
        }
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(50px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .hover-scale {
            transition: transform 0.3s ease;
        }
        .hover-scale:hover {
            transform: scale(1.05);
        }
        .card-shadow {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }
        .card-shadow:hover {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        /* Mobile menu styles */
        .mobile-menu {
            display: none;
        }
        .mobile-menu.active {
            display: block;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #0097a7;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #007c91;
        }
        /* Back to top button */
        .back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        .back-to-top.show {
            opacity: 1;
            visibility: visible;
        }
    </style>
</head>
<body class="font-sans antialiased bg-[#eaf6fa] overflow-x-hidden">
    <!-- Back to Top Button -->
    <button id="backToTop" class="back-to-top bg-[#0097a7] hover:bg-[#007c91] text-white p-3 rounded-full shadow-lg">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Navbar -->
    @include('component.landing.navbar')

    <!-- HERO SECTION -->
    <section id="home" class="relative w-full h-screen min-h-[600px]">
        <div class="absolute inset-0 z-0"
            style="background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.6)), url('{{ asset('images/bg pdam.png') }}') center center / cover no-repeat;">
        </div>
        <div class="relative z-20 flex flex-col items-center justify-center h-full px-6 text-center">
            <div class="fade-in">
                <h1 class="text-white text-4xl md:text-6xl font-bold drop-shadow-2xl mb-4">
                    PDAM TIRTA TAMIANG
                </h1>
                <p class="text-white text-lg md:text-2xl mb-8 drop-shadow-lg max-w-3xl">
                    Perusahaan Daerah Air Minum Aceh Tamiang
                    <br class="hidden md:block">
                    <span class="text-blue-200">Melayani dengan Dedikasi, Mengalir dengan Kualitas</span>
                </p>
            </div>

            <!-- Quick Access Buttons -->
            <div id="layanan" class="flex flex-col md:flex-row gap-6 mt-8 mb-16">
                <a href="/cektagihan" class="group fade-in">
                    <div class="bg-gradient-to-b from-[#92CEE6] to-[#0F2538] rounded-xl shadow-2xl w-44 h-44 flex flex-col items-center justify-center group-hover:scale-105 transition-all duration-300 card-shadow">
                        <i class="fas fa-search-dollar text-white text-5xl mb-3 group-hover:scale-110 transition-transform duration-300"></i>
                        <span class="text-white font-semibold text-lg">Cek Tagihan</span>
                        <span class="text-blue-200 text-sm mt-1">Mudah & Cepat</span>
                    </div>
                </a>
                <a href="/pengaduanpelanggan" class="group fade-in">
                    <div class="bg-gradient-to-b from-[#92CEE6] to-[#0F2538] rounded-xl shadow-2xl w-44 h-44 flex flex-col items-center justify-center group-hover:scale-105 transition-all duration-300 card-shadow">
                        <i class="fas fa-comments text-white text-5xl mb-3 group-hover:scale-110 transition-transform duration-300"></i>
                        <span class="text-white font-semibold text-lg">Pengaduan</span>
                        <span class="text-blue-200 text-sm mt-1">24/7 Online</span>
                    </div>
                </a>
                <a href="tel:0651-48853" class="group fade-in">
                    <div class="bg-gradient-to-b from-[#92CEE6] to-[#0F2538] rounded-xl shadow-2xl w-44 h-44 flex flex-col items-center justify-center group-hover:scale-105 transition-all duration-300 card-shadow">
                        <i class="fas fa-phone text-white text-5xl mb-3 group-hover:scale-110 transition-transform duration-300"></i>
                        <span class="text-white font-semibold text-lg">Hubungi Kami</span>
                        <span class="text-blue-200 text-sm mt-1">0651-48853</span>
                    </div>
                </a>
            </div>

            <!-- Scroll Indicator -->
            <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
                <i class="fas fa-chevron-down text-white text-2xl"></i>
            </div>
        </div>
    </section>

    <!-- Peraturan Daerah Section -->
    <section class="w-full bg-[#eaf6fa] py-16 px-6">
        <div class="max-w-6xl mx-auto">
            <div class="bg-white rounded-2xl shadow-2xl flex flex-col lg:flex-row items-center p-8 lg:p-12 card-shadow slide-in-left">
                <div class="flex-1 mb-6 lg:mb-0 lg:mr-8">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-gavel text-[#007c91] text-3xl mr-3"></i>
                        <h2 class="text-3xl font-bold text-[#007c91]">Peraturan Daerah</h2>
                    </div>
                    <p class="text-[#1e355e] text-lg leading-relaxed mb-6">
                        Sesuai dengan <strong>Qanun Kabupaten Aceh Tamiang Nomor 1 Tahun 2019</strong> tentang perubahan nama PDAM Tirta Tamiang menjadi Perumda Air Minum Tirta Tamiang serta pengaturan organisasi, modal, tugas, dan fungsi perusahaan.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <div class="bg-[#eaf6fa] px-4 py-2 rounded-lg">
                            <span class="text-[#007c91] font-semibold">✓ Transparan</span>
                        </div>
                        <div class="bg-[#eaf6fa] px-4 py-2 rounded-lg">
                            <span class="text-[#007c91] font-semibold">✓ Akuntabel</span>
                        </div>
                        <div class="bg-[#eaf6fa] px-4 py-2 rounded-lg">
                            <span class="text-[#007c91] font-semibold">✓ Profesional</span>
                        </div>
                    </div>
                </div>
                <div class="flex-shrink-0 flex justify-center slide-in-right">
                    <img src="{{ asset('images/grafik.png') }}" alt="Ilustrasi Grafik" class="w-40 h-40 md:w-48 md:h-48 object-contain drop-shadow-2xl hover-scale">
                </div>
            </div>
        </div>
    </section>

    <!-- VISI & MISI Section -->
    <section id="tentang" class="w-full bg-gradient-to-b from-[#eaf6fa] to-white py-16 px-6 scroll-mt-24">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12 fade-in">
                <h2 class="text-4xl font-bold text-[#1e355e] mb-4">Visi & Misi Kami</h2>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                    Komitmen kami dalam memberikan pelayanan air bersih terbaik untuk masyarakat Aceh Tamiang
                </p>
            </div>
            
            <div class="flex flex-col lg:flex-row gap-8">
                <div class="flex-1 bg-gradient-to-br from-[#0F2538] to-[#1e355e] p-8 rounded-2xl shadow-2xl card-shadow slide-in-left">
                    <div class="flex items-center mb-6">
                        <i class="fas fa-eye text-white text-3xl mr-3"></i>
                        <span class="text-white text-2xl font-bold">VISI</span>
                    </div>
                    <div class="text-white/90 text-lg leading-relaxed">
                        <p class="mb-4 font-medium">
                            "Menjadi perusahaan air minum yang terpercaya, berkelanjutan, dan memberikan pelayanan prima kepada masyarakat."
                        </p>
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <i class="fas fa-water text-blue-300 mt-1 mr-3"></i>
                                <span>Menyediakan air minum yang aman, berkualitas, dan cukup</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-cogs text-blue-300 mt-1 mr-3"></i>
                                <span>Pengelolaan yang efisien, transparan, dan akuntabel</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-laptop text-blue-300 mt-1 mr-3"></i>
                                <span>Pemanfaatan teknologi untuk layanan optimal</span>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="flex-1 bg-gradient-to-br from-[#b2e0f7] to-[#92CEE6] p-8 rounded-2xl shadow-2xl card-shadow slide-in-right">
                    <div class="flex items-center mb-6">
                        <i class="fas fa-bullseye text-[#1e355e] text-3xl mr-3"></i>
                        <span class="text-[#1e355e] text-2xl font-bold">MISI</span>
                    </div>
                    <div class="text-[#1e355e] text-lg leading-relaxed">
                        <ul class="space-y-4">
                            <li class="flex items-start">
                                <span class="bg-[#1e355e] text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold mr-3 mt-1">1</span>
                                <span>Menyediakan air minum yang aman, berkualitas, dan cukup untuk seluruh lapisan masyarakat</span>
                            </li>
                            <li class="flex items-start">
                                <span class="bg-[#1e355e] text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold mr-3 mt-1">2</span>
                                <span>Meningkatkan kinerja perusahaan melalui pengelolaan yang efisien, transparan, dan akuntabel</span>
                            </li>
                            <li class="flex items-start">
                                <span class="bg-[#1e355e] text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold mr-3 mt-1">3</span>
                                <span>Mengoptimalkan pemanfaatan teknologi untuk memberikan layanan yang lebih cepat dan tepat</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistik Section -->
    <section class="w-full bg-[#0F2538] py-16 px-6">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12 fade-in">
                <h2 class="text-4xl font-bold text-white mb-4">Statistik Pelayanan</h2>
                <p class="text-blue-200 text-lg">Data pencapaian kami dalam melayani masyarakat</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center fade-in">
                    <div class="bg-[#92CEE6] rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-[#0F2538] text-2xl"></i>
                    </div>
                    <div class="text-3xl font-bold text-white mb-2" data-count="5000">0</div>
                    <div class="text-blue-200">Pelanggan Aktif</div>
                </div>
                <div class="text-center fade-in">
                    <div class="bg-[#92CEE6] rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-map-marker-alt text-[#0F2538] text-2xl"></i>
                    </div>
                    <div class="text-3xl font-bold text-white mb-2" data-count="25">0</div>
                    <div class="text-blue-200">Wilayah Layanan</div>
                </div>
                <div class="text-center fade-in">
                    <div class="bg-[#92CEE6] rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-clock text-[#0F2538] text-2xl"></i>
                    </div>
                    <div class="text-3xl font-bold text-white mb-2" data-count="24">0</div>
                    <div class="text-blue-200">Jam Layanan</div>
                </div>
                <div class="text-center fade-in">
                    <div class="bg-[#92CEE6] rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-award text-[#0F2538] text-2xl"></i>
                    </div>
                    <div class="text-3xl font-bold text-white mb-2" data-count="99">0</div>
                    <div class="text-blue-200">% Kepuasan</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Informasi & Berita Section -->
    <section id="artikel" class="w-full bg-white py-16 px-6 scroll-mt-24">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12 fade-in">
                <h2 class="text-4xl font-bold mb-4">
                    Temukan <span class="text-[#0097a7]">Informasi</span> & <span class="text-yellow-500">Berita</span> Terbaru
                </h2>
                <p class="text-gray-700 text-lg max-w-2xl mx-auto">
                    Tetap terinformasi dengan pembaruan dan berita terbaru dari kami. Jangan lewatkan informasi penting dan perkembangan menarik.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <article class="bg-white rounded-2xl shadow-lg overflow-hidden card-shadow hover-scale">
                    <div class="relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=400&q=80" 
                             alt="Berita 1" class="w-full h-48 object-cover transition-transform duration-300 hover:scale-110">
                        <div class="absolute top-4 left-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                            URGENT
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-lg text-[#0097a7] hover:text-[#007c91] transition-colors duration-300 mb-3 leading-tight">
                            Pipa Tersumbat Pecah, Perumda Tirta Tamiang Bongkar Jaringan
                        </h3>
                        <p class="text-gray-600 text-sm mb-3 line-clamp-3">
                            Pasokan air sempat terganggu setelah terdengar suara gemuruh dari jaringan pipa utama...
                        </p>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-500">21 Mei 2024</span>
                            <a href="#" class="text-[#0097a7] hover:text-[#007c91] font-semibold text-sm">
                                Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </article>

                <article class="bg-white rounded-2xl shadow-lg overflow-hidden card-shadow hover-scale">
                    <div class="relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=400&q=80" 
                             alt="Berita 2" class="w-full h-48 object-cover transition-transform duration-300 hover:scale-110">
                        <div class="absolute top-4 left-4 bg-green-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                            UPDATE
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-lg text-[#0097a7] hover:text-[#007c91] transition-colors duration-300 mb-3 leading-tight">
                            Peningkatan Kualitas Air Perumda Tirta Tamiang
                        </h3>
                        <p class="text-gray-600 text-sm mb-3 line-clamp-3">
                            Solusi air minum layak dengan teknologi terbaru untuk kualitas air yang lebih baik...
                        </p>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-500">18 Mei 2024</span>
                            <a href="#" class="text-[#0097a7] hover:text-[#007c91] font-semibold text-sm">
                                Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </article>

                <article class="bg-white rounded-2xl shadow-lg overflow-hidden card-shadow hover-scale">
                    <div class="relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1502082553048-f009c37129b9?auto=format&fit=crop&w=400&q=80" 
                             alt="Berita 3" class="w-full h-48 object-cover transition-transform duration-300 hover:scale-110">
                        <div class="absolute top-4 left-4 bg-blue-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                            INFO
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-lg text-[#0097a7] hover:text-[#007c91] transition-colors duration-300 mb-3 leading-tight">
                            Layanan Air Baru Perumda Tirta Tamiang
                        </h3>
                        <p class="text-gray-600 text-sm mb-3 line-clamp-3">
                            Wadah berkemajuan dengan inovasi layanan terdepan untuk kemudahan pelanggan...
                        </p>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-500">10 Mei 2024</span>
                            <a href="#" class="text-[#0097a7] hover:text-[#007c91] font-semibold text-sm">
                                Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </article>
            </div>
            
            <div class="text-center mt-12">
                <a href="#" class="bg-[#0097a7] hover:bg-[#007c91] text-white px-8 py-3 rounded-lg font-semibold transition-all duration-300 hover-scale">
                    Lihat Semua Berita <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Sejarah Section -->
    <section id="sejarah" class="w-full bg-gradient-to-br from-[#eaf6fa] to-[#b2e0f7] py-16 px-6 scroll-mt-24">
        <div class="max-w-6xl mx-auto">
            <div class="bg-white rounded-2xl shadow-2xl p-8 lg:p-12 flex flex-col lg:flex-row gap-10 items-center card-shadow">
                <div class="flex-1 order-2 lg:order-1 slide-in-left">
                    <div class="flex items-center mb-6">
                        <i class="fas fa-history text-[#0097a7] text-3xl mr-3"></i>
                        <h3 class="font-bold text-3xl text-[#1e355e]">Sejarah Perumda Air Minum Tirta Tamiang</h3>
                    </div>
                    <div class="space-y-4 text-gray-700 leading-relaxed">
                        <p class="text-lg">
                            Perusahaan Umum Daerah Air Minum (Perumda) Tirta Tamiang merupakan perusahaan milik daerah yang bertanggung jawab dalam penyediaan layanan air bersih bagi masyarakat di Kabupaten Aceh Tamiang.
                        </p>
                        <p>
                            PDAM Tirta Tamiang didirikan berdasarkan <strong>Qanun Kabupaten Aceh Tamiang Nomor 8 Tahun 2010</strong>, yang mengatur tentang pembentukan perusahaan daerah untuk mengelola dan mendistribusikan air bersih di wilayah Kabupaten Tamiang.
                        </p>
                        <div class="bg-[#eaf6fa] p-4 rounded-lg border-l-4 border-[#0097a7]">
                            <p class="font-semibold text-[#0097a7] mb-2">Komitmen Kami:</p>
                            <ul class="space-y-1 text-sm">
                                <li>• Menyediakan layanan air bersih berkualitas tinggi</li>
                                <li>• Memenuhi standar kesehatan yang ketat</li>
                                <li>• Melayani masyarakat dengan dedikasi</li>
                            </ul>
                        </div>
                        <p>
                            Dengan visi untuk menjadi perusahaan air minum yang profesional, inovatif, dan berkelanjutan, Perumda Air Minum Tirta Tamiang terus berupaya memberikan layanan terbaik melalui tata kelola yang baik dan pemanfaatan teknologi modern.
                        </p>
                    </div>
                </div>
                <div class="flex-shrink-0 order-1 lg:order-2 slide-in-right">
                    <img src="{{ asset('images/20220616-pdam-taming 1.png') }}" 
                         alt="Kantor PDAM" 
                         class="rounded-2xl shadow-lg w-full max-w-md hover-scale">
                </div>
            </div>
        </div>
    </section>

    <!-- Struktur Organisasi Section -->
    <section id="struktur-organisasi" class="w-full bg-white py-16 px-6 scroll-mt-24">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12 fade-in">
                <h2 class="text-4xl font-bold mb-4">
                    <span class="bg-gradient-to-r from-[#0097a7] to-[#1e355e] bg-clip-text text-transparent">Struktur Organisasi</span>
                </h2>
                <p class="text-gray-600 text-lg">Tim profesional yang berdedikasi melayani masyarakat</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8 justify-items-center">
                <!-- Direktur Utama -->
                <div class="lg:col-span-5 flex justify-center mb-8">
                    <div class="flex flex-col items-center fade-in">
                        <div class="relative">
                            <div class="w-32 h-32 rounded-full border-4 border-[#0097a7] shadow-2xl flex items-center justify-center overflow-hidden bg-white card-shadow">
                                <img src="{{ asset('images/direktur.jpg') }}" alt="Drs. Tri Kurnia" class="object-cover w-full h-full">
                            </div>
                            <div class="absolute -bottom-2 -right-2 bg-[#0097a7] text-white rounded-full w-10 h-10 flex items-center justify-center">
                                <i class="fas fa-crown text-sm"></i>
                            </div>
                        </div>
                        <div class="bg-gradient-to-r from-[#1e355e] to-[#0097a7] text-white text-sm font-semibold px-4 py-2 rounded-lg mt-4 text-center shadow-lg">
                            <div class="font-bold">Drs. Tri Kurnia</div>
                            <div class="text-blue-200">Direktur Utama</div>
                        </div>
                    </div>
                </div>

                <!-- Level 2 -->
                <div class="flex flex-col items-center fade-in">
                    <div class="w-28 h-28 rounded-full border-4 border-[#1ec6e6] shadow-xl flex items-center justify-center overflow-hidden bg-white card-shadow hover-scale">
                        <img src="{{ asset('images/amirul.jpg') }}" alt="Amirul Mukminin" class="object-cover w-full h-full">
                    </div>
                    <div class="bg-[#1e355e] text-white text-xs font-semibold px-3 py-2 rounded-lg mt-3 text-center shadow-lg">
                        <div class="font-bold">Amirul Mukminin</div>
                        <div class="text-blue-200">Kabag ADM & Keu</div>
                    </div>
                </div>

                <div class="flex flex-col items-center fade-in">
                    <div class="w-28 h-28 rounded-full border-4 border-[#1ec6e6] shadow-xl flex items-center justify-center overflow-hidden bg-white card-shadow hover-scale">
                        <img src="{{ asset('images/gobang.jpg') }}" alt="Zulfikar" class="object-cover w-full h-full">
                    </div>
                    <div class="bg-[#1e355e] text-white text-xs font-semibold px-3 py-2 rounded-lg mt-3 text-center shadow-lg">
                        <div class="font-bold">Zulfikar</div>
                        <div class="text-blue-200">Kabag Teknik</div>
                    </div>
                </div>

                <div class="flex flex-col items-center fade-in">
                    <div class="w-28 h-28 rounded-full border-4 border-[#1ec6e6] shadow-xl flex items-center justify-center overflow-hidden bg-white card-shadow hover-scale">
                        <img src="{{ asset('images/jamilah.jpg') }}" alt="Jamilah" class="object-cover w-full h-full">
                    </div>
                    <div class="bg-[#1e355e] text-white text-xs font-semibold px-3 py-2 rounded-lg mt-3 text-center shadow-lg">
                        <div class="font-bold">Jamilah</div>
                        <div class="text-blue-200">Ketua SPI</div>
                    </div>
                </div>

                <div class="flex flex-col items-center fade-in">
                    <div class="w-28 h-28 rounded-full border-4 border-[#1ec6e6] shadow-xl flex items-center justify-center overflow-hidden bg-white card-shadow hover-scale">
                        <img src="{{ asset('images/yanto.jpg') }}" alt="Yanto" class="object-cover w-full h-full">
                    </div>
                    <div class="bg-[#1e355e] text-white text-xs font-semibold px-3 py-2 rounded-lg mt-3 text-center shadow-lg">
                        <div class="font-bold">Yanto</div>
                        <div class="text-blue-200">Kepala Cabang Kota</div>
                    </div>
                </div>

                <div class="flex flex-col items-center fade-in">
                    <div class="w-28 h-28 rounded-full border-4 border-[#1ec6e6] shadow-xl flex items-center justify-center overflow-hidden bg-white card-shadow hover-scale">
                        <img src="{{ asset('images/tgk.png') }}" alt="Tgk.Rubiah" class="object-cover w-full h-full">
                    </div>
                    <div class="bg-[#1e355e] text-white text-xs font-semibold px-3 py-2 rounded-lg mt-3 text-center shadow-lg">
                        <div class="font-bold">Tgk.Rubiah</div>
                        <div class="text-blue-200">Kepala Cabang Hilir</div>
                    </div>
                </div>

                <!-- Level 3 -->
                <div class="flex flex-col items-center fade-in">
                    <div class="w-24 h-24 rounded-full border-4 border-[#92CEE6] shadow-lg flex items-center justify-center overflow-hidden bg-white card-shadow hover-scale">
                        <img src="{{ asset('images/annas1-768x768.jpg') }}" alt="Aznar Annas" class="object-cover w-full h-full">
                    </div>
                    <div class="bg-[#92CEE6] text-[#1e355e] text-xs font-semibold px-2 py-1 rounded mt-2 text-center shadow">
                        <div class="font-bold">Aznar Annas</div>
                        <div>Kasubbag Hublang</div>
                    </div>
                </div>

                <div class="flex flex-col items-center fade-in">
                    <div class="w-24 h-24 rounded-full border-4 border-[#92CEE6] shadow-lg flex items-center justify-center overflow-hidden bg-white card-shadow hover-scale">
                        <img src="{{ asset('images/DIEGO-removebg-preview-removebg-preview.png') }}" alt="Diego A" class="object-cover w-full h-full">
                    </div>
                    <div class="bg-[#92CEE6] text-[#1e355e] text-xs font-semibold px-2 py-1 rounded mt-2 text-center shadow">
                        <div class="font-bold">Diego A</div>
                        <div>Kasubbag Penagihan</div>
                    </div>
                </div>

                <div class="flex flex-col items-center fade-in">
                    <div class="w-24 h-24 rounded-full border-4 border-[#92CEE6] shadow-lg flex items-center justify-center overflow-hidden bg-white card-shadow hover-scale">
                        <img src="{{ asset('images/b-tuti-768x768.jpg') }}" alt="Tuti Kurniahati" class="object-cover w-full h-full">
                    </div>
                    <div class="bg-[#92CEE6] text-[#1e355e] text-xs font-semibold px-2 py-1 rounded mt-2 text-center shadow">
                        <div class="font-bold">Tuti Kurniawati</div>
                        <div>Kasubbag Kas</div>
                    </div>
                </div>

                <div class="flex flex-col items-center fade-in">
                    <div class="w-24 h-24 rounded-full border-4 border-[#92CEE6] shadow-lg flex items-center justify-center overflow-hidden bg-white card-shadow hover-scale">
                        <img src="{{ asset('images/ijah-removebg-preview-768x768.jpg') }}" alt="Khadijah" class="object-cover w-full h-full">
                    </div>
                    <div class="bg-[#92CEE6] text-[#1e355e] text-xs font-semibold px-2 py-1 rounded mt-2 text-center shadow">
                        <div class="font-bold">Khadijah</div>
                        <div>Kasubbag</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="w-full bg-gradient-to-r from-[#0F2538] to-[#1e355e] text-white py-16">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <!-- Company Info -->
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <img src="{{ asset('images/logo_pdam.png') }}" alt="Logo PDAM" class="w-16 h-16">
                        <div>
                            <div class="font-bold text-xl text-[#92CEE6]">PDAM TIRTA TAMIANG</div>
                            <div class="text-blue-200 text-sm">Melayani dengan Dedikasi</div>
                        </div>
                    </div>
                    <p class="text-blue-200 text-sm mb-4 leading-relaxed">
                        Perusahaan Daerah Air Minum yang berkomitmen menyediakan layanan air bersih berkualitas untuk masyarakat Aceh Tamiang dengan standar pelayanan terbaik.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="bg-[#92CEE6] text-[#0F2538] p-2 rounded-full hover:bg-blue-200 transition-colors duration-300">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="bg-[#92CEE6] text-[#0F2538] p-2 rounded-full hover:bg-blue-200 transition-colors duration-300">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="bg-[#92CEE6] text-[#0F2538] p-2 rounded-full hover:bg-blue-200 transition-colors duration-300">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" class="bg-[#92CEE6] text-[#0F2538] p-2 rounded-full hover:bg-blue-200 transition-colors duration-300">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                </div>

                <!-- Contact Info -->
                <div>
                    <h4 class="font-bold text-lg mb-4 border-b-2 border-[#92CEE6] pb-2">Kontak Kami</h4>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-map-marker-alt text-[#92CEE6] mt-1"></i>
                            <span>Jln. Ir.H Juanda, Desa Tanjung Karang<br>Kec. Karang Baru, Kab. Aceh Tamiang</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-phone text-[#92CEE6]"></i>
                            <span>0651-48853</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-fax text-[#92CEE6]"></i>
                            <span>0651-48853</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-envelope text-[#92CEE6]"></i>
                            <span>pdamtirta.tamiang@yahoo.com</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="font-bold text-lg mb-4 border-b-2 border-[#92CEE6] pb-2">Layanan Cepat</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="/cektagihan" class="hover:text-[#92CEE6] transition-colors duration-300">Cek Tagihan</a></li>
                        <li><a href="/pengaduanpelanggan" class="hover:text-[#92CEE6] transition-colors duration-300">Pengaduan Online</a></li>
                        <li><a href="#tentang" class="hover:text-[#92CEE6] transition-colors duration-300">Tentang Kami</a></li>
                        <li><a href="#artikel" class="hover:text-[#92CEE6] transition-colors duration-300">Berita Terkini</a></li>
                        <li><a href="tel:0651-48853" class="hover:text-[#92CEE6] transition-colors duration-300">Hubungi Kami</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-blue-800 pt-8 text-center">
                <p class="text-blue-200 text-sm">
                    &copy; 2024 PDAM Tirta Tamiang. Semua hak dilindungi. | 
                    <a href="#" class="hover:text-[#92CEE6] transition-colors duration-300">Kebijakan Privasi</a> | 
                    <a href="#" class="hover:text-[#92CEE6] transition-colors duration-300">Syarat & Ketentuan</a>
                </p>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('active');
        });

        // Close mobile menu when clicking on links
        const mobileLinks = mobileMenu.querySelectorAll('a');
        mobileLinks.forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.remove('active');
            });
        });

        // Back to Top Button
        const backToTopBtn = document.getElementById('backToTop');
        
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTopBtn.classList.add('show');
            } else {
                backToTopBtn.classList.remove('show');
            }
        });

        backToTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Counter Animation
        const counters = document.querySelectorAll('[data-count]');
        const animateCounter = (counter) => {
            const target = parseInt(counter.getAttribute('data-count'));
            const increment = target / 100;
            let current = 0;
            
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                counter.textContent = Math.floor(current);
            }, 20);
        };

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.3,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in');
                    
                    // Animate counters
                    const counter = entry.target.querySelector('[data-count]');
                    if (counter && !counter.hasAttribute('data-animated')) {
                        counter.setAttribute('data-animated', 'true');
                        animateCounter(counter);
                    }
                }
            });
        }, observerOptions);

        // Observe all sections for animation
        document.querySelectorAll('section, .fade-in, .slide-in-left, .slide-in-right').forEach(section => {
            observer.observe(section);
        });

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add loading animation
        window.addEventListener('load', () => {
            document.body.classList.add('loaded');
        });
    </script>
</body>
</html>