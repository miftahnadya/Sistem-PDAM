<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - PDAM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'pdam-dark': '#005792',
                        'pdam-blue': '#53CDE2',
                        'pdam-light': '#D1F4FA',
                        'pdam-lightest': '#EDF9FC'
                    }
                }
            }
        }
    </script>
    <style>
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 87, 146, 0.1);
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #005792 0%, #53CDE2 100%);
        }
        
        .stats-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(255,255,255,0.8) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
        }
        
        .pulse-animation {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-pdam-lightest via-white to-pdam-light min-h-screen">
    <div class="flex min-h-screen">
        <!-- Sidebar Admin -->
        @include('component.sidebar')
        
        <!-- Main Content -->
        <main class="flex-1 lg:ml-72 transition-all duration-300">
            <!-- Top Header -->
            <header class="gradient-bg shadow-lg sticky top-0 z-20">
                <div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div class="mb-4 sm:mb-0">
                            <h1 class="text-2xl sm:text-3xl font-bold text-white">Dashboard Admin</h1>
                            <p class="text-white text-opacity-90 mt-1">
                                Selamat datang kembali, {{ Auth::user()->nama_pelanggan }}!
                            </p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="text-right hidden sm:block">
                                <p class="text-sm text-white text-opacity-80">{{ date('l, d F Y') }}</p>
                                <p class="text-sm font-medium text-white" id="currentTime"></p>
                            </div>
                            <div class="w-12 h-12 sm:w-16 sm:h-16 bg-white/20 rounded-xl flex items-center justify-center">
                                <i class="fas fa-user-shield text-white text-lg sm:text-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
                <!-- Quick Stats Overview -->
                <div class="mb-8">
                    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                        <!-- Total Pengaduan -->
                        <div class="stats-card rounded-xl shadow-lg p-4 sm:p-6 card-hover fade-in">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs sm:text-sm font-medium text-gray-500 mb-1">Total Pengaduan</p>
                                    <p class="text-xl sm:text-2xl font-bold text-pdam-dark">{{ $stats['total_pengaduan'] ?? 0 }}</p>
                                </div>
                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-pdam-lightest rounded-lg flex items-center justify-center">
                                    <i class="fas fa-comments text-pdam-blue text-sm sm:text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Total Tagihan -->
                        <div class="stats-card rounded-xl shadow-lg p-4 sm:p-6 card-hover fade-in">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs sm:text-sm font-medium text-gray-500 mb-1">Total Tagihan</p>
                                    <p class="text-xl sm:text-2xl font-bold text-purple-600">{{ $stats['total_tagihan'] ?? 0 }}</p>
                                </div>
                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-file-invoice text-purple-600 text-sm sm:text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Total Pelanggan -->
                        <div class="stats-card rounded-xl shadow-lg p-4 sm:p-6 card-hover fade-in">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs sm:text-sm font-medium text-gray-500 mb-1">Total Pelanggan</p>
                                    <p class="text-xl sm:text-2xl font-bold text-indigo-600">{{ $stats['total_pelanggan'] ?? 0 }}</p>
                                </div>
                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-users text-indigo-600 text-sm sm:text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Total Pendapatan -->
                        <div class="stats-card rounded-xl shadow-lg p-4 sm:p-6 card-hover fade-in">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs sm:text-sm font-medium text-gray-500 mb-1">Pendapatan</p>
                                    <p class="text-sm sm:text-lg font-bold text-green-600">
                                        Rp {{ number_format(($stats['total_pendapatan'] ?? 0) / 1000000, 1, ',', '.') }}M
                                    </p>
                                </div>
                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-money-bill-wave text-green-600 text-sm sm:text-xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistics Cards - Pengaduan -->
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-4 sm:mb-6">
                        <h2 class="text-lg sm:text-xl font-bold text-pdam-dark">Statistik Pengaduan</h2>
                        <div class="flex items-center space-x-2 text-sm text-gray-500">
                            <i class="fas fa-chart-line"></i>
                            <span class="hidden sm:inline">Real-time</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                        <!-- Pending -->
                        <div class="bg-white rounded-xl shadow-lg border border-yellow-100 p-4 sm:p-6 card-hover fade-in">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 mb-1">Pending</p>
                                    <p class="text-2xl sm:text-3xl font-bold text-yellow-600">{{ $stats['pengaduan_pending'] ?? 0 }}</p>
                                    <div class="flex items-center mt-2">
                                        <span class="text-xs text-yellow-600 bg-yellow-100 px-2 py-1 rounded-full">
                                            <i class="fas fa-clock mr-1"></i>Menunggu
                                        </span>
                                    </div>
                                </div>
                                <div class="w-12 h-12 sm:w-16 sm:h-16 bg-yellow-100 rounded-xl flex items-center justify-center pulse-animation">
                                    <i class="fas fa-hourglass-half text-yellow-600 text-lg sm:text-2xl"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Diproses -->
                        <div class="bg-white rounded-xl shadow-lg border border-blue-100 p-4 sm:p-6 card-hover fade-in">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 mb-1">Diproses</p>
                                    <p class="text-2xl sm:text-3xl font-bold text-blue-600">{{ $stats['pengaduan_diproses'] ?? 0 }}</p>
                                    <div class="flex items-center mt-2">
                                        <span class="text-xs text-blue-600 bg-blue-100 px-2 py-1 rounded-full">
                                            <i class="fas fa-spinner fa-spin mr-1"></i>Aktif
                                        </span>
                                    </div>
                                </div>
                                <div class="w-12 h-12 sm:w-16 sm:h-16 bg-blue-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-cogs text-blue-600 text-lg sm:text-2xl"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Selesai -->
                        <div class="bg-white rounded-xl shadow-lg border border-green-100 p-4 sm:p-6 card-hover fade-in">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 mb-1">Selesai</p>
                                    <p class="text-2xl sm:text-3xl font-bold text-green-600">{{ $stats['pengaduan_selesai'] ?? 0 }}</p>
                                    <div class="flex items-center mt-2">
                                        <span class="text-xs text-green-600 bg-green-100 px-2 py-1 rounded-full">
                                            <i class="fas fa-check mr-1"></i>Selesai
                                        </span>
                                    </div>
                                </div>
                                <div class="w-12 h-12 sm:w-16 sm:h-16 bg-green-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-check-circle text-green-600 text-lg sm:text-2xl"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Ditutup -->
                        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-4 sm:p-6 card-hover fade-in">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 mb-1">Ditutup</p>
                                    <p class="text-2xl sm:text-3xl font-bold text-gray-600">{{ $stats['pengaduan_ditutup'] ?? 0 }}</p>
                                    <div class="flex items-center mt-2">
                                        <span class="text-xs text-gray-600 bg-gray-100 px-2 py-1 rounded-full">
                                            <i class="fas fa-times mr-1"></i>Ditutup
                                        </span>
                                    </div>
                                </div>
                                <div class="w-12 h-12 sm:w-16 sm:h-16 bg-gray-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-archive text-gray-600 text-lg sm:text-2xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistics Cards - Tagihan -->
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-4 sm:mb-6">
                        <h2 class="text-lg sm:text-xl font-bold text-pdam-dark">Statistik Tagihan</h2>
                        <div class="flex items-center space-x-2 text-sm text-gray-500">
                            <i class="fas fa-chart-pie"></i>
                            <span class="hidden sm:inline">Overview</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                        <!-- Tagihan Lunas -->
                        <div class="bg-white rounded-xl shadow-lg border border-green-100 p-4 sm:p-6 card-hover fade-in">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 mb-1">Tagihan Lunas</p>
                                    <p class="text-2xl sm:text-3xl font-bold text-green-600">{{ $stats['tagihan_lunas'] ?? 0 }}</p>
                                    <div class="flex items-center mt-2">
                                        @php
                                            $totalTagihan = ($stats['total_tagihan'] ?? 0);
                                            $persenLunas = $totalTagihan > 0 ? round((($stats['tagihan_lunas'] ?? 0) / $totalTagihan) * 100) : 0;
                                        @endphp
                                        <span class="text-xs text-green-600 bg-green-100 px-2 py-1 rounded-full">
                                            {{ $persenLunas }}% dari total
                                        </span>
                                    </div>
                                </div>
                                <div class="w-12 h-12 sm:w-16 sm:h-16 bg-green-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-money-check-alt text-green-600 text-lg sm:text-2xl"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Tagihan Belum Lunas -->
                        <div class="bg-white rounded-xl shadow-lg border border-red-100 p-4 sm:p-6 card-hover fade-in">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 mb-1">Belum Lunas</p>
                                    <p class="text-2xl sm:text-3xl font-bold text-red-600">{{ $stats['tagihan_belum_lunas'] ?? 0 }}</p>
                                    <div class="flex items-center mt-2">
                                        @php
                                            $persenBelumLunas = $totalTagihan > 0 ? round((($stats['tagihan_belum_lunas'] ?? 0) / $totalTagihan) * 100) : 0;
                                        @endphp
                                        <span class="text-xs text-red-600 bg-red-100 px-2 py-1 rounded-full">
                                            {{ $persenBelumLunas }}% dari total
                                        </span>
                                    </div>
                                </div>
                                <div class="w-12 h-12 sm:w-16 sm:h-16 bg-red-100 rounded-xl flex items-center justify-center pulse-animation">
                                    <i class="fas fa-exclamation-triangle text-red-600 text-lg sm:text-2xl"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Total Pemakaian -->
                        <div class="bg-white rounded-xl shadow-lg border border-blue-100 p-4 sm:p-6 card-hover fade-in">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 mb-1">Total Pemakaian</p>
                                    <p class="text-xl sm:text-2xl font-bold text-blue-600">{{ number_format($stats['total_pemakaian'] ?? 0) }}</p>
                                    <div class="flex items-center mt-2">
                                        <span class="text-xs text-blue-600 bg-blue-100 px-2 py-1 rounded-full">
                                            m³ air
                                        </span>
                                    </div>
                                </div>
                                <div class="w-12 h-12 sm:w-16 sm:h-16 bg-blue-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-tint text-blue-600 text-lg sm:text-2xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
                    <!-- Quick Actions -->
                    <div class="bg-white rounded-xl shadow-lg border border-pdam-light/30 p-4 sm:p-6 card-hover fade-in">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-bold text-pdam-dark">Aksi Cepat</h3>
                            <i class="fas fa-bolt text-pdam-blue text-lg"></i>
                        </div>
                        <div class="space-y-3 sm:space-y-4">
                            <a href="{{ route('admin.pengaduan.index') }}" 
                               class="flex items-center p-3 sm:p-4 bg-gradient-to-r from-pdam-lightest to-pdam-light/50 rounded-lg hover:from-pdam-light hover:to-pdam-lightest transition-all duration-300 group">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-pdam-blue rounded-lg flex items-center justify-center mr-3 sm:mr-4 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-comments text-white text-sm sm:text-lg"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-pdam-dark text-sm sm:text-base">Kelola Pengaduan</p>
                                    <p class="text-xs sm:text-sm text-gray-600">Lihat dan tanggapi pengaduan pelanggan</p>
                                </div>
                                <i class="fas fa-chevron-right text-pdam-blue ml-auto group-hover:translate-x-1 transition-transform"></i>
                            </a>
                            
                            <a href="{{ route('admin.isitagihan') }}" 
                               class="flex items-center p-3 sm:p-4 bg-gradient-to-r from-blue-50 to-blue-100/50 rounded-lg hover:from-blue-100 hover:to-blue-50 transition-all duration-300 group">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-600 rounded-lg flex items-center justify-center mr-3 sm:mr-4 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-file-invoice text-white text-sm sm:text-lg"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-blue-800 text-sm sm:text-base">Kelola Tagihan</p>
                                    <p class="text-xs sm:text-sm text-blue-600">Tambah atau edit data tagihan</p>
                                </div>
                                <i class="fas fa-chevron-right text-blue-600 ml-auto group-hover:translate-x-1 transition-transform"></i>
                            </a>

                            <a href="#" 
                               class="flex items-center p-3 sm:p-4 bg-gradient-to-r from-purple-50 to-purple-100/50 rounded-lg hover:from-purple-100 hover:to-purple-50 transition-all duration-300 group">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-600 rounded-lg flex items-center justify-center mr-3 sm:mr-4 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-chart-bar text-white text-sm sm:text-lg"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-purple-800 text-sm sm:text-base">Laporan</p>
                                    <p class="text-xs sm:text-sm text-purple-600">Lihat laporan dan statistik</p>
                                </div>
                                <i class="fas fa-chevron-right text-purple-600 ml-auto group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Recent Complaints -->
                    <div class="bg-white rounded-xl shadow-lg border border-pdam-light/30 p-4 sm:p-6 card-hover fade-in">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-bold text-pdam-dark">Pengaduan Terbaru</h3>
                            <a href="{{ route('admin.pengaduan.index') }}" 
                               class="text-pdam-blue hover:text-pdam-dark text-sm font-medium flex items-center">
                                Lihat Semua
                                <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                        <div class="space-y-3 sm:space-y-4 max-h-96 overflow-y-auto">
                            @forelse($pengaduan_terbaru as $pengaduan)
                            <div class="flex items-start p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="w-3 h-3 rounded-full mt-2 mr-3 flex-shrink-0
                                    @if($pengaduan->status === 'pending') bg-yellow-500 pulse-animation
                                    @elseif($pengaduan->status === 'diproses') bg-blue-500
                                    @elseif($pengaduan->status === 'selesai') bg-green-500
                                    @else bg-gray-500
                                    @endif">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $pengaduan->judul }}</p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ $pengaduan->nama_pelanggan ?? 'Pelanggan' }} - 
                                        {{ \Carbon\Carbon::parse($pengaduan->created_at)->diffForHumans() }}
                                    </p>
                                    <div class="flex items-center justify-between mt-2">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                            @if($pengaduan->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($pengaduan->status === 'diproses') bg-blue-100 text-blue-800
                                            @elseif($pengaduan->status === 'selesai') bg-green-100 text-green-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ ucfirst($pengaduan->status) }}
                                        </span>
                                        <a href="{{ route('admin.pengaduan.index') }}" 
                                           class="text-pdam-blue hover:text-pdam-dark">
                                            <i class="fas fa-eye text-sm"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-8">
                                <i class="fas fa-inbox text-gray-400 text-3xl mb-3"></i>
                                <p class="text-gray-500 text-sm">Belum ada pengaduan terbaru</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Recent Bills -->
                <div class="mt-6 lg:mt-8">
                    <div class="bg-white rounded-xl shadow-lg border border-pdam-light/30 p-4 sm:p-6 card-hover fade-in">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-bold text-pdam-dark">Tagihan Terbaru</h3>
                            <a href="{{ route('admin.isitagihan') }}" 
                               class="text-pdam-blue hover:text-pdam-dark text-sm font-medium flex items-center">
                                Lihat Semua
                                <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                        <div class="space-y-3 sm:space-y-4 max-h-96 overflow-y-auto">
                            @forelse($tagihan_terbaru as $tagihan)
                            <div class="flex items-center p-3 sm:p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-pdam-blue to-pdam-dark rounded-lg flex items-center justify-center mr-3 sm:mr-4 flex-shrink-0">
                                    <i class="fas fa-user text-white text-sm sm:text-lg"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                        <div class="mb-2 sm:mb-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">{{ $tagihan->nama_pelanggan ?? 'Pelanggan' }}</p>
                                            <p class="text-xs text-gray-500">ID: {{ $tagihan->id_pel }} - {{ $tagihan->bulan }}/{{ $tagihan->tahun }}</p>
                                        </div>
                                        <div class="text-left sm:text-right">
                                            <p class="text-sm font-medium text-gray-900">Rp {{ number_format($tagihan->total_tagihan, 0, ',', '.') }}</p>
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                                @if($tagihan->status_bayar === 'LUNAS') bg-green-100 text-green-800
                                                @else bg-red-100 text-red-800
                                                @endif">
                                                {{ $tagihan->status_bayar }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-8">
                                <i class="fas fa-file-invoice text-gray-400 text-3xl mb-3"></i>
                                <p class="text-gray-500 text-sm">Belum ada tagihan terbaru</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Update current time
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            const timeElement = document.getElementById('currentTime');
            if (timeElement) {
                timeElement.textContent = timeString;
            }
        }

        updateTime();
        setInterval(updateTime, 1000);

        // Auto refresh stats every 5 minutes
        setTimeout(function() {
            location.reload();
        }, 300000);

        // Add fade-in animation to cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.fade-in');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>
</html>