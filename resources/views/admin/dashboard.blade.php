<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - PDAM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
</head>
<body class="bg-gradient-to-br from-pdam-lightest to-pdam-light min-h-screen">
    <div class="flex min-h-screen">
        <!-- Sidebar Admin -->
        @include('component.sidebar')
        
        <!-- Main Content -->
        <main class="flex-1 lg:ml-72 px-6 py-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-pdam-dark mb-2">Dashboard Admin</h1>
                        <p class="text-gray-600">Selamat datang kembali, {{ Auth::user()->nama_pelanggan }}!</p>
                    </div>
                    <div class="hidden md:block">
                        <div class="w-16 h-16 bg-gradient-to-br from-pdam-dark to-pdam-blue rounded-2xl flex items-center justify-center">
                            <i class="fas fa-user-shield text-white text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards - Pengaduan -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-pdam-dark mb-4">Statistik Pengaduan</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                    <!-- Total Pengaduan -->
                    <div class="bg-white rounded-xl shadow-lg border border-pdam-light/30 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Total Pengaduan</p>
                                <p class="text-2xl font-bold text-pdam-dark">{{ $stats['total_pengaduan'] ?? 0 }}</p>
                            </div>
                            <div class="w-12 h-12 bg-pdam-lightest rounded-lg flex items-center justify-center">
                                <i class="fas fa-comments text-pdam-blue text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Pending -->
                    <div class="bg-white rounded-xl shadow-lg border border-pdam-light/30 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Pending</p>
                                <p class="text-2xl font-bold text-yellow-600">{{ $stats['pengaduan_pending'] ?? 0 }}</p>
                            </div>
                            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-clock text-yellow-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Diproses -->
                    <div class="bg-white rounded-xl shadow-lg border border-pdam-light/30 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Diproses</p>
                                <p class="text-2xl font-bold text-blue-600">{{ $stats['pengaduan_diproses'] ?? 0 }}</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-cogs text-blue-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Selesai -->
                    <div class="bg-white rounded-xl shadow-lg border border-pdam-light/30 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Selesai</p>
                                <p class="text-2xl font-bold text-green-600">{{ $stats['pengaduan_selesai'] ?? 0 }}</p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-check-circle text-green-600 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards - Tagihan -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-pdam-dark mb-4">Statistik Tagihan</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                    <!-- Total Tagihan -->
                    <div class="bg-white rounded-xl shadow-lg border border-pdam-light/30 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Total Tagihan</p>
                                <p class="text-2xl font-bold text-purple-600">{{ $stats['total_tagihan'] ?? 0 }}</p>
                            </div>
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-file-invoice text-purple-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Tagihan Lunas -->
                    <div class="bg-white rounded-xl shadow-lg border border-pdam-light/30 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Tagihan Lunas</p>
                                <p class="text-2xl font-bold text-green-600">{{ $stats['tagihan_lunas'] ?? 0 }}</p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-check-circle text-green-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Tagihan Belum Lunas -->
                    <div class="bg-white rounded-xl shadow-lg border border-pdam-light/30 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Belum Lunas</p>
                                <p class="text-2xl font-bold text-red-600">{{ $stats['tagihan_belum_lunas'] ?? 0 }}</p>
                            </div>
                            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Total Pelanggan -->
                    <div class="bg-white rounded-xl shadow-lg border border-pdam-light/30 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Total Pelanggan</p>
                                <p class="text-2xl font-bold text-indigo-600">{{ $stats['total_pelanggan'] ?? 0 }}</p>
                            </div>
                            <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-users text-indigo-600 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Stats -->
            <div class="mb-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Total Pemakaian -->
                    <div class="bg-white rounded-xl shadow-lg border border-pdam-light/30 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Total Pemakaian (m³)</p>
                                <p class="text-2xl font-bold text-blue-600">{{ number_format($stats['total_pemakaian'] ?? 0) }}</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-tint text-blue-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Total Pendapatan -->
                    <div class="bg-white rounded-xl shadow-lg border border-pdam-light/30 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Total Pendapatan</p>
                                <p class="text-2xl font-bold text-green-600">Rp {{ number_format($stats['total_pendapatan'] ?? 0, 0, ',', '.') }}</p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-money-bill-wave text-green-600 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions & Recent Data -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-lg border border-pdam-light/30 p-6">
                    <h3 class="text-lg font-bold text-pdam-dark mb-6">Aksi Cepat</h3>
                    <div class="space-y-4">
                        <a href="{{ route('admin.pengaduan.index') }}" 
                           class="flex items-center p-4 bg-pdam-lightest rounded-lg hover:bg-pdam-light transition-colors">
                            <i class="fas fa-comments text-pdam-blue text-xl mr-4"></i>
                            <div>
                                <p class="font-medium text-pdam-dark">Kelola Pengaduan</p>
                                <p class="text-sm text-gray-600">Lihat dan tanggapi pengaduan pelanggan</p>
                            </div>
                        </a>
                        
                        <a href="{{ route('admin.isitagihan') }}" 
                           class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                            <i class="fas fa-file-invoice text-blue-600 text-xl mr-4"></i>
                            <div>
                                <p class="font-medium text-blue-800">Kelola Tagihan</p>
                                <p class="text-sm text-blue-600">Tambah atau edit data tagihan</p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Recent Complaints -->
                <div class="bg-white rounded-xl shadow-lg border border-pdam-light/30 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-pdam-dark">Pengaduan Terbaru</h3>
                        <a href="{{ route('admin.pengaduan.index') }}" class="text-pdam-blue hover:text-pdam-dark text-sm">
                            Lihat Semua
                        </a>
                    </div>
                    <div class="space-y-4">
                        @forelse($pengaduan_terbaru as $pengaduan)
                        <div class="flex items-start p-3 bg-gray-50 rounded-lg">
                            <div class="w-2 h-2 rounded-full mt-2 mr-3
                                @if($pengaduan->status === 'pending') bg-yellow-500
                                @elseif($pengaduan->status === 'diproses') bg-blue-500
                                @elseif($pengaduan->status === 'selesai') bg-green-500
                                @else bg-gray-500
                                @endif">
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $pengaduan->judul }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ $pengaduan->nama_pelanggan ?? 'Pelanggan' }} - 
                                    {{ \Carbon\Carbon::parse($pengaduan->created_at)->diffForHumans() }}
                                </p>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium mt-1
                                    @if($pengaduan->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($pengaduan->status === 'diproses') bg-blue-100 text-blue-800
                                    @elseif($pengaduan->status === 'selesai') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($pengaduan->status) }}
                                </span>
                            </div>
                            <a href="{{ route('admin.pengaduan.index') }}" 
                               class="text-pdam-blue hover:text-pdam-dark ml-2">
                                <i class="fas fa-eye text-sm"></i>
                            </a>
                        </div>
                        @empty
                        <div class="text-center py-8">
                            <i class="fas fa-inbox text-gray-400 text-3xl mb-3"></i>
                            <p class="text-gray-500">Belum ada pengaduan terbaru</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Bills -->
            <div class="mt-8">
                <div class="bg-white rounded-xl shadow-lg border border-pdam-light/30 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-pdam-dark">Tagihan Terbaru</h3>
                        <a href="{{ route('admin.isitagihan') }}" class="text-pdam-blue hover:text-pdam-dark text-sm">
                            Lihat Semua
                        </a>
                    </div>
                    <div class="space-y-4">
                        @forelse($tagihan_terbaru as $tagihan)
                        <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $tagihan->nama_pelanggan ?? 'Pelanggan' }}</p>
                                        <p class="text-xs text-gray-500">ID: {{ $tagihan->id_pel }} - {{ $tagihan->bulan }}/{{ $tagihan->tahun }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-medium text-gray-900">Rp {{ number_format($tagihan->total_tagihan, 0, ',', '.') }}</p>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
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
                            <p class="text-gray-500">Belum ada tagihan terbaru</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>