<!-- resources/views/dashboard.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard PDAM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#f4fbfd] min-h-screen">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-20 bg-[#10283a] min-h-screen flex flex-col items-center py-6 space-y-8">
            <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center mb-8">
                <span class="text-black font-bold text-xl">N</span>
            </div>
            <nav class="flex flex-col items-center space-y-10 flex-1">
                <a href="{{ route('dashboard') }}" class="flex flex-col items-center group opacity-100">
                    <i class="fas fa-home text-white text-3xl group-hover:text-[#92CEE6]"></i>
                    <span class="text-xs text-white mt-1">Beranda</span>
                </a>
                <a href="{{ route('cek-tagihan') }}" class="flex flex-col items-center group opacity-70 hover:opacity-100">
                    <i class="fas fa-folder text-white text-3xl group-hover:text-[#92CEE6]"></i>
                    <span class="text-xs text-white mt-1">Cek Tagihan</span>
                </a>
                <a href="{{ route('pengaduan') }}" class="flex flex-col items-center group opacity-70 hover:opacity-100">
                    <i class="fas fa-file-alt text-white text-3xl group-hover:text-[#92CEE6]"></i>
                    <span class="text-xs text-white mt-1">Pengaduan</span>
                </a>
            </nav>
            <form method="POST" action="{{ route('logout') }}" class="flex flex-col items-center group mt-8 mb-2">
                @csrf
                <button type="submit" class="flex flex-col items-center focus:outline-none">
                    <i class="fas fa-sign-out-alt text-white text-2xl group-hover:text-red-400"></i>
                    <span class="text-xs text-white mt-1">Logout</span>
                </button>
            </form>
        </aside>
        <!-- Main Content -->
        <main class="flex-1 px-8 py-8">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-4xl font-bold text-[#10283a] mb-2">Dashboard PDAM</h1>
                    <p class="text-[#4b5563]">Selamat datang di Sistem Informasi PDAM. Kelola data pelanggan, cek tagihan, dan pengaduan dengan mudah.</p>
                </div>
                <img src="{{ asset('images/logo_pdam.png') }}" alt="Logo PDAM" class="w-28 h-auto">
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
                <!-- Card 1 -->
                <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center">
                    <div class="bg-[#92CEE6] rounded-full w-16 h-16 flex items-center justify-center mb-4">
                        <i class="fas fa-users text-3xl text-white"></i>
                    </div>
                    <div class="text-2xl font-bold text-[#10283a]">Data Pelanggan</div>
                    <div class="text-[#4b5563] mb-4 text-center">Lihat dan kelola data pelanggan PDAM.</div>
                    <a href="#" class="text-[#1e355e] font-semibold hover:underline">Lihat Detail</a>
                </div>
                <!-- Card 2 -->
                <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center">
                    <div class="bg-[#92CEE6] rounded-full w-16 h-16 flex items-center justify-center mb-4">
                        <i class="fas fa-file-invoice-dollar text-3xl text-white"></i>
                    </div>
                    <div class="text-2xl font-bold text-[#10283a]">Cek Tagihan</div>
                    <div class="text-[#4b5563] mb-4 text-center">Cek dan pantau tagihan air pelanggan.</div>
                    <a href="{{ route('cek-tagihan') }}" class="text-[#1e355e] font-semibold hover:underline">Cek Tagihan</a>
                </div>
                <!-- Card 3 -->
                <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center">
                    <div class="bg-[#92CEE6] rounded-full w-16 h-16 flex items-center justify-center mb-4">
                        <i class="fas fa-comments text-3xl text-white"></i>
                    </div>
                    <div class="text-2xl font-bold text-[#10283a]">Pengaduan</div>
                    <div class="text-[#4b5563] mb-4 text-center">Kelola pengaduan dan laporan pelanggan.</div>
                    <a href="{{ route('pengaduan') }}" class="text-[#1e355e] font-semibold hover:underline">Lihat Pengaduan</a>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-xl font-bold text-[#10283a] mb-4">Informasi Penting</h2>
                <ul class="list-disc pl-6 text-[#4b5563] space-y-2">
                    <li>Pastikan data pelanggan selalu diperbarui.</li>
                    <li>Periksa tagihan pelanggan secara berkala.</li>
                    <li>Tanggapi pengaduan pelanggan dengan cepat dan profesional.</li>
                </ul>
            </div>
        </main>
    </div>
</body>
</html>