
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Tagihan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white min-h-screen">
    <div class="flex w-full min-h-screen">
<!-- Sidebar -->
<aside class="w-20 bg-[#10283a] min-h-screen flex flex-col items-center py-6 space-y-8">
    <!-- Logo bulat di atas -->
    <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center mb-8">
        <span class="text-black font-bold text-xl">N</span>
    </div>
    <!-- Menu -->
    <nav class="flex flex-col items-center space-y-10 flex-1">
        <a href="/dashboard" class="flex flex-col items-center group">
            <i class="fas fa-home text-white text-3xl group-hover:text-[#92CEE6]"></i>
            <span class="text-xs text-white mt-1">Dashboard</span>
        </a>
        <a href="#" class="flex flex-col items-center group">
            <i class="fas fa-folder text-white text-3xl group-hover:text-[#92CEE6]"></i>
            <span class="text-xs text-white mt-1">Cek Tagihan</span>
        </a>
        <a href="#" class="flex flex-col items-center group">
            <i class="fas fa-file-alt text-white text-3xl group-hover:text-[#92CEE6]"></i>
            <span class="text-xs text-white mt-1">Pengaduan</span>
        </a>
    <!-- Logout -->
<form action="{{ route('logout') }}" method="POST" style="display:inline;">
    @csrf
    <button type="submit" class="w-12 h-12 flex items-center justify-center rounded-full bg-red-100 hover:bg-red-200 transition text-red-600 text-xl focus:outline-none" title="Logout">
        <i class="fas fa-sign-out-alt"></i>
    </button>
    <span class="text-xs text-red-600 mt-1 block text-center">Logout</span>
</form>
</aside>
        <!-- Main Content -->
        <div class="flex-1 px-8 py-8">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-4xl font-bold mb-4">Informasi Tagihan</h1>
                    <form class="flex items-center mb-20 space-x-2">
                        <label class="text-lg font">Pilih Bulan Tagihan</label>
                        <input type="month" class="border-b-2 border-gray-400 bg-transparent focus:outline-none focus:border-[#6bb6d6] text-sm px-2 py-1" />
                        <button type="submit" class="bg-[#a7d3e9] text-[#10283a] font-bold px-6 py-1 rounded-lg ml-2 hover:bg-[#6bb6d6] transition">Cek</button>
                    </form>
                </div>
                <img src="{{ asset('images/logo_pdam.png') }}" alt="Logo PDAM" class="w-32 h-auto">
            </div>
            <!-- Table -->
            <div class="overflow-x-auto mt-2">
                <table class="min-w-full border border-gray-400">
                    <thead>
                        <tr class="bg-black text-white text-sm">
                            <th class="px-4 py-2 border border-gray-400">ID Pelanggan</th>
                            <th class="px-4 py-2 border border-gray-400">Nama Pelanggan</th>
                            <th class="px-4 py-2 border border-gray-400">Periode</th>
                            <th class="px-4 py-2 border border-gray-400">Total Pemakaian</th>
                            <th class="px-4 py-2 border border-gray-400">B.Admin</th>
                            <th class="px-4 py-2 border border-gray-400">Denda</th>
                            <th class="px-4 py-2 border border-gray-400">Total Tagihan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white text-center text-sm">
                            <td class="px-4 py-2 border border-gray-400">04919</td>
                            <td class="px-4 py-2 border border-gray-400">Nadya</td>
                            <td class="px-4 py-2 border border-gray-400">Januari 2025</td>
                            <td class="px-4 py-2 border border-gray-400">244.226</td>
                            <td class="px-4 py-2 border border-gray-400">2.500</td>
                            <td class="px-4 py-2 border border-gray-400">0</td>
                            <td class="px-4 py-2 border border-gray-400 font-bold">246.726</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</body>
</html>