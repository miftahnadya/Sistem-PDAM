<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PDAM Tirta Tamiang</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .bg-pdam {
            background-color:rgb(90, 143, 211) !important;
        }
        .text-pdam {
            color: #0097a7 !important;
        }
        .ring-pdam {
            --tw-ring-color: #0097a7 !important;

        }
    </style>
</head>
<body class="font-sans antialiased bg-[#eaf6fa]">
    <!-- Navbar -->
    <nav class="sticky top-0 left-0 w-full z-50 bg-pdam shadow-lg">
        <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-2">
            <img src="{{ asset('images/logo_pdam.png') }}" alt="Logo PDAM" class="h-14">
            <ul class="flex flex-row space-x-10 font-medium text-lg">
                <li><a href="{{ url('/') }}" class="text-white font-semibold hover:text-blue-200">Beranda</a></li>
                <li><a href="#tentang" class="text-white hover:text-blue-200">Tentang Kami</a></li>
                <li><a href="#artikel" class="text-white hover:text-blue-200">Artikel</a></li>
                <li><a href="#sejarah" class="text-white hover:text-blue-200">Sejarah</a></li>
                <li><a href="#struktur-organisasi" class="text-white hover:text-blue-200">Organisasi</a></li>
            </ul>
            <a href="{{ url('/login') }}" class="bg-white text-[#0097a7] font-bold px-6 py-1 rounded-lg hover:bg-blue-100 transition">LOGIN</a>
        </div>
    </nav>

    <!-- HERO & BACKGROUND (hanya sampai peraturan) -->
    <div class="relative w-full" style="height: 540px;">
        <div class="absolute inset-0 z-0"
            style="background: url('{{ asset('images/bg pdam.png') }}') center center / cover no-repeat;">
        </div>
        <div class="absolute inset-0 bg-black/40 z-10"></div>
        <div class="relative z-20 flex flex-col items-center justify-center h-full pt-24">
            <h1 class="text-white text-3xl md:text-5xl font-bold drop-shadow-lg text-center mb-2 pt-10">PDAM TIRTA TAMIANG</h1>
            <p class="text-white text-lg md:text-2xl mb-8 drop-shadow text-center">Perusahaan Daerah air minum Aceh Tamiang</p>
            <div class="flex gap-8 mt-2 mb-12"> <!-- mb-12 agar lebih jauh dari bawah -->
                <a href="#cek-tagihan" class="flex flex-col items-center group">
                    <div class="bg-gradient-to-b from-[#0097a7] to-[#003f4c] rounded-lg shadow-lg w-36 h-36 flex items-center justify-center mb-2 group-hover:scale-105 transition">
                        <i class="fas fa-search-dollar text-white text-4xl"></i>
                    </div>
                    <span class="text-white font-semibold text-base">Cek Tagihan</span>
                </a>
                <a href="#pengaduan" class="flex flex-col items-center group">
                    <div class="bg-gradient-to-b from-[#0097a7] to-[#003f4c] rounded-lg shadow-lg w-36 h-36 flex items-center justify-center mb-2 group-hover:scale-105 transition">
                        <i class="fas fa-comments text-white text-4xl"></i>
                    </div>
                    <span class="text-white font-semibold text-base">Pengaduan pelanggan</span>
                </a>
            </div>
            <!-- Peraturan Daerah Card -->
            <div class="w-[90%] max-w-3xl mx-auto bg-[#b2e0f7] rounded-xl shadow-lg flex flex-col md:flex-row items-center p-6 md:p-8 mt-8"> <!-- mt-8 agar lebih jauh dari atas -->
                <div class="flex-1 mb-6 md:mb-0 md:mr-8">
                    <h2 class="text-2xl font-bold text-[#007c91] mb-2">Peraturan Daerah</h2>
                    <p class="text-[#1e355e] text-base md:text-lg">
                        Sesuai dengan Qanun Kabupaten Aceh Tamiang Nomor 1 Tahun 2019 tentang perubahan nama PDAM Tirta Tamiang menjadi Perumda Air Minum Tirta Tamiang serta pengaturan organisasi, modal, tugas, dan fungsi perusahaan.
                    </p>
                </div>
                <div class="flex-shrink-0 flex justify-center">
                    <img src="{{ asset('images/grafik.png') }}" alt="Ilustrasi Grafik" class="w-32 h-32 md:w-40 md:h-40 object-contain drop-shadow-xl">
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Section berikutnya -->
    <div class="w-full bg-[#eaf6fa] pt-16 pb-8">
        <!-- VISI & MISI -->
        <section class="w-full flex flex-col md:flex-row gap-10 mb-16">
            <div class="flex-1 bg-[#1e355e] p-8 flex flex-col items-start shadow-md rounded-xl">
                <span class="text-white text-lg font-bold px-4 py-2 rounded bg-[#1e355e] mb-4 shadow">VISI</span>
                <ol class="list-decimal ml-6 text-white/90 text-base space-y-2">
                    <li>Menyediakan air minum yang aman, berkualitas, dan cukup untuk seluruh lapisan masyarakat.</li>
                    <li>Melaksanakan kinerja perusahaan melalui pengelolaan yang efisien, transparan, dan akuntabel.</li>
                    <li>Mengoptimalkan pemanfaatan teknologi untuk memberikan layanan yang lebih cepat dan tepat.</li>
                </ol>
            </div>
            <div class="flex-1 bg-[#b2e0f7] p-8 flex flex-col items-start shadow-md rounded-xl">
                <span class="text-[#1e355e] text-lg font-bold px-4 py-2 rounded bg-[#b2e0f7] mb-4 shadow">MISI</span>
                <ol class="list-decimal ml-6 text-[#1e355e] text-base space-y-2">
                    <li>Menyediakan air minum yang aman, berkualitas, dan cukup untuk seluruh lapisan masyarakat.</li>
                    <li>Meningkatkan kinerja perusahaan melalui pengelolaan yang efisien, transparan, dan akuntabel.</li>
                    <li>Mengoptimalkan pemanfaatan teknologi untuk memberikan layanan yang lebih cepat dan tepat.</li>
                </ol>
            </div>
        </section>

        <!-- Informasi & Berita -->
        <div class="w-full max-w-5xl mx-auto mb-16">
            <h2 class="text-2xl md:text-3xl font-bold mb-2">
                Temukan <span class="text-[#0097a7]">Informasi</span> & <span class="text-yellow-500">berita</span> terbaru kami
            </h2>
            <p class="text-gray-700 mb-6">
                Tetap terinformasi dengan pembaruan dan berita terbaru dari kami. Jangan lewatkan informasi penting dan perkembangan menarik. Simak cerita terbaru kami sekarang!
            </p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-lg shadow p-3 flex flex-col">
                    <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=400&q=80" alt="Berita 1" class="rounded mb-2 h-28 object-cover">
                    <a href="#" class="font-semibold text-[#0097a7] hover:underline">Pipa Tersumbat Pecah, Perumda Tirta Tamiang Bongkar Jaringan, Pasokan Air Sempat Dengar Suara Gemuruh</a>
                    <span class="text-xs text-gray-500 mt-1">21 Mei 2024</span>
                </div>
                <div class="bg-white rounded-lg shadow p-3 flex flex-col">
                    <img src="https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=400&q=80" alt="Berita 2" class="rounded mb-2 h-28 object-cover">
                    <a href="#" class="font-semibold text-[#0097a7] hover:underline">Peningkatan Kualitas Air Perumda Tirta Tamiang: Solusi Air Minum Layak</a>
                    <span class="text-xs text-gray-500 mt-1">18 Mei 2024</span>
                </div>
                <div class="bg-white rounded-lg shadow p-3 flex flex-col">
                    <img src="https://images.unsplash.com/photo-1502082553048-f009c37129b9?auto=format&fit=crop&w=400&q=80" alt="Berita 3" class="rounded mb-2 h-28 object-cover">
                    <a href="#" class="font-semibold text-[#0097a7] hover:underline">Wadah Berkemajuan, Perumda Tirta Tamiang Luncurkan Layanan Air Baru</a>
                    <span class="text-xs text-gray-500 mt-1">10 Mei 2024</span>
                </div>
            </div>
        </div>

        <!-- Sejarah -->
        <div class="w-full max-w-5xl mx-auto bg-white rounded-xl shadow-lg p-6 md:p-10 flex flex-col md:flex-row gap-10 items-center mb-16">
            <div class="flex-1">
                <h3 class="font-bold text-lg md:text-xl mb-2 text-[#1e355e]">Sejarah Perumda Air Minum Tirta Tamiang</h3>
                <p class="text-gray-700 mb-2">
                    Perusahaan Umum Daerah Air Minum (Perumda) Tirta Tamiang merupakan perusahaan milik daerah yang bertanggung jawab dalam penyediaan layanan air bersih bagi masyarakat di Kabupaten Aceh Tamiang. Sejarah pendirian perusahaan ini tidak lepas dari kebutuhan masyarakat akan air bersih yang layak serta upaya pemerintah daerah dalam meningkatkan pelayanan publik di sektor air minum.
                </p>
                <p class="text-gray-700 mb-2">
                    PDAM Tirta Tamiang didirikan berdasarkan Qanun Kabupaten Aceh Tamiang Nomor 8 Tahun 2010, yang mengatur tentang pembentukan perusahaan daerah untuk mengelola dan mendistribusikan air bersih di wilayah Kabupaten Tamiang. Sejak awal berdiri, PDAM Tirta Tamiang berkomitmen untuk menyediakan layanan air bersih yang dapat diakses oleh masyarakat secara luas, dengan kualitas yang memenuhi standar kesehatan.
                </p>
                <p class="text-gray-700 mb-2">
                    Namun, dalam perkembangannya, tantangan dalam pengelolaan air bersih di PDAM semakin meningkat. Faktor seperti keterbatasan infrastruktur, sumber daya manusia, serta meningkatnya permintaan air bersih oleh penduduk menjadi perhatian utama. Oleh karena itu, inovasi dan peningkatan efisiensi dalam setiap lini kerja telah terus diusahakan untuk memberikan solusi efektif dan pelayanan terbaik.
                </p>
                <p class="text-gray-700">
                    Dengan visi untuk menjadi perusahaan air minum yang profesional, inovatif, dan berkelanjutan, Perumda Air Minum Tirta Tamiang akan terus berupaya memberikan layanan terbaik bagi masyarakat. Melalui tata kelola yang baik dan pemanfaatan teknologi, perusahaan ini optimis dapat memenuhi kebutuhan air bersih yang berkualitas bagi seluruh pelanggan.
                </p>
            </div>
            <img src="https://asset.kompas.com/crops/3p9Qw5Qn2y5wQnQw5Qn2y5wQnQw=/0x0:780x390/750x500/data/photo/2020/01/16/5e1f1e7e2e1e2.jpg" alt="Kantor PDAM" class="rounded-lg shadow w-full max-w-xs object-cover">
        </div>

        <!-- Struktur Organisasi -->
        <section class="w-full bg-white py-16 px-2 flex flex-col items-center mb-16" id="struktur-organisasi">
            <h2 class="text-xl md:text-2xl font-bold text-center mb-10">
                <span class="bg-[#b2e0f7] px-6 py-2 rounded shadow text-[#1e355e]">Struktur Organisasi</span>
            </h2>
            <div class="w-full max-w-5xl grid grid-cols-2 md:grid-cols-5 gap-y-10 gap-x-4 mb-12 justify-items-center">
                <!-- Contoh 1 baris atas -->
                <div class="flex flex-col items-center">
                    <img src="{{ asset('images/struktur/1.jpg') }}" alt="Drs. Tri Kurnia" class="w-28 h-28 rounded-full object-cover border-4 border-[#1ec6e6] shadow">
                    <div class="bg-[#1e355e] text-white text-xs font-semibold px-3 py-1 rounded mt-3 w-32 text-center">Nama 1</div>
                </div>
                <div class="flex flex-col items-center">
                    <img src="{{ asset('images/struktur/2.jpg') }}" alt="Amirul Mukminin" class="w-28 h-28 rounded-full object-cover border-4 border-[#1ec6e6] shadow">
                    <div class="bg-[#1e355e] text-white text-xs font-semibold px-3 py-1 rounded mt-3 w-32 text-center">Nama 2</div>
                </div>
                <div class="flex flex-col items-center">
                    <img src="{{ asset('images/struktur/3.jpg') }}" alt="Zulfikar" class="w-28 h-28 rounded-full object-cover border-4 border-[#1ec6e6] shadow">
                    <div class="bg-[#1e355e] text-white text-xs font-semibold px-3 py-1 rounded mt-3 w-32 text-center">Nama 3</div>
                </div>
                <div class="flex flex-col items-center">
                    <img src="{{ asset('images/struktur/4.jpg') }}" alt="Yanto" class="w-28 h-28 rounded-full object-cover border-4 border-[#1ec6e6] shadow">
                    <div class="bg-[#1e355e] text-white text-xs font-semibold px-3 py-1 rounded mt-3 w-32 text-center">Nama 4</div>
                </div>
                <div class="flex flex-col items-center">
                    <img src="{{ asset('images/struktur/5.jpg') }}" alt="Tgk.Rubiah" class="w-28 h-28 rounded-full object-cover border-4 border-[#1ec6e6] shadow">
                    <div class="bg-[#1e355e] text-white text-xs font-semibold px-3 py-1 rounded mt-3 w-32 text-center">Nama 5</div>
                </div>
                <!-- Baris bawah -->
                <div class="flex flex-col items-center">
                    <img src="{{ asset('images/struktur/6.jpg') }}" alt="Aznar Annas" class="w-28 h-28 rounded-full object-cover border-4 border-[#1ec6e6] shadow">
                    <div class="bg-[#1e355e] text-white text-xs font-semibold px-3 py-1 rounded mt-3 w-32 text-center">Tjut Rahida<br>Kepala Cabang Hilir</div>
                </div>
                <div class="flex flex-col items-center">
                    <img src="{{ asset('images/struktur/7.jpg') }}" alt="Diego A" class="w-28 h-28 rounded-full object-cover border-4 border-[#1ec6e6] shadow">
                    <div class="bg-[#1e355e] text-white text-xs font-semibold px-3 py-1 rounded mt-3 w-32 text-center">Azwar Anwar<br>Kasi Bidang Hubung</div>
                </div>
                <div class="flex flex-col items-center">
                    <img src="{{ asset('images/struktur/8.jpg') }}" alt="Tuti Kurniahati" class="w-28 h-28 rounded-full object-cover border-4 border-[#1ec6e6] shadow">
                    <div class="bg-[#1e355e] text-white text-xs font-semibold px-3 py-1 rounded mt-3 w-32 text-center">Dispa A<br>Kasi Bidang Pengadaan</div>
                </div>
                <div class="flex flex-col items-center">
                    <img src="{{ asset('images/struktur/9.jpg') }}" alt="Khadijah" class="w-28 h-28 rounded-full object-cover border-4 border-[#1ec6e6] shadow">
                    <div class="bg-[#1e355e] text-white text-xs font-semibold px-3 py-1 rounded mt-3 w-32 text-center">Teti Nurhalizah<br>Kasi Bidang Keu</div>
                </div>
                <div class="flex flex-col items-center">
                    <img src="{{ asset('images/struktur/10.jpg') }}" alt="Musliadi" class="w-28 h-28 rounded-full object-cover border-4 border-[#1ec6e6] shadow">
                    <div class="bg-[#1e355e] text-white text-xs font-semibold px-3 py-1 rounded mt-3 w-32 text-center">Musliadi<br>Kasi Bidang SPI</div>
                </div>
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer class="w-full bg-[#10283a] text-white pt-8 pb-6 mt-0">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center md:items-start px-4 gap-8 w-full">
            <!-- Kontak Kami -->
            <div class="flex-1 mb-8 md:mb-0 w-full">
                <div class="font-semibold text-sm mb-2 border-b-2 border-[#00bcd4] w-40 pb-1">Kontak kami</div>
                <div class="font-bold text-base text-white mb-1">PDAM TIRTA TAMIANG</div>
                <div class="text-sm mb-1 flex items-start gap-2">
                    <svg class="w-4 h-4 mt-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 12.414a2 2 0 0 0-2.828 0l-4.243 4.243a8 8 0 1 1 11.314 0z"/><circle cx="12" cy="12" r="3"/></svg>
                    <span>
                        Jln. Ir.H Juanda, Desa Tanjung Karang<br>
                        Kec. Karang Baru, Kab. Aceh Tamiang
                    </span>
                </div>
                <div class="text-sm mb-1 flex items-start gap-2">
                    <svg class="w-4 h-4 mt-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5z"/><path d="M16 3v4a1 1 0 0 1-1 1H9a1 1 0 0 1-1-1V3"/></svg>
                    <span>
                        Telp. 0651-48853<br>
                        Fax. 0651-48853
                    </span>
                </div>
                <div class="text-sm mb-1 flex items-start gap-2">
                    <svg class="w-4 h-4 mt-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10.5a8.38 8.38 0 0 1-1.9.5 4.19 4.19 0 0 0 1.8-2.3 8.27 8.27 0 0 1-2.6 1 4.14 4.14 0 0 0-7 3.8A11.75 11.75 0 0 1 3 8.1a4.13 4.13 0 0 0 1.3 5.5 4.07 4.07 0 0 1-1.9-.5v.05a4.15 4.15 0 0 0 3.3 4.1 4.09 4.09 0 0 1-1.9.07 4.16 4.16 0 0 0 3.9 2.9A8.32 8.32 0 0 1 2 19.5a11.73 11.73 0 0 0 6.3 1.8c7.5 0 11.6-6.2 11.6-11.6 0-.2 0-.4 0-.6A8.18 8.18 0 0 0 22 6.5a8.36 8.36 0 0 1-2.4.7z"/></svg>
                    <span>pdamtirta.tamiang@yahoo.com</span>
                </div>
            </div>
            <!-- Logo Tengah -->
            <div class="flex-1 flex flex-col items-center w-full">
                <img src="{{ asset('images/logo_pdam.png') }}" alt="Logo PDAM" class="w-32 mb-2 drop-shadow-lg">
                <div class="font-bold text-[#00bcd4] text-lg tracking-wide">TIRTA TAMIANG</div>
            </div>
            <!-- Social Media -->
            <div class="flex-1 w-full">
                <div class="font-semibold text-sm mb-2 border-b-2 border-[#00bcd4] w-40 pb-1">Social Media</div>
                <ul class="space-y-2 text-sm">
                    <li class="flex items-center gap-2">
                        <i class="fab fa-facebook-f w-5"></i> Facebook
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fab fa-instagram w-5"></i> Instagram
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fab fa-youtube w-5"></i> Youtube
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fab fa-twitter w-5"></i> Twitter
                    </li>
                </ul>
            </div>
        </div>
    </footer>
</body>
</html>