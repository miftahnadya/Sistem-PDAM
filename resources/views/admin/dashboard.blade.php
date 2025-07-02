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

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-6 mb-8">
                <!-- Total Pengaduan -->
                <div class="bg-white rounded-xl shadow-lg border border-pdam-light/30 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Total Pengaduan</p>
                            <p class="text-2xl font-bold text-pdam-dark">{{ $stats['total_pengaduan'] }}</p>
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
                            <p class="text-2xl font-bold text-yellow-600">{{ $stats['pengaduan_pending'] }}</p>
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
                            <p class="text-2xl font-bold text-blue-600">{{ $stats['pengaduan_diproses'] }}</p>
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
                            <p class="text-2xl font-bold text-green-600">{{ $stats['pengaduan_selesai'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Pelanggan -->
                <div class="bg-white rounded-xl shadow-lg border border-pdam-light/30 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Total Pelanggan</p>
                            <p class="text-2xl font-bold text-purple-600">{{ $stats['total_pelanggan'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-purple-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions & Recent Complaints -->
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
                        
                        <a href="{{ route('isitagihan') }}" 
                           class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                            <i class="fas fa-file-invoice text-blue-600 text-xl mr-4"></i>
                            <div>
                                <p class="font-medium text-blue-800">Input Tagihan</p>
                                <p class="text-sm text-blue-600">Tambah atau edit data tagihan</p>
                            </div>
                        </a>
                        
                        <a href="{{ route('admin.data-pelanggan') }}" 
                           class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                            <i class="fas fa-users text-green-600 text-xl mr-4"></i>
                            <div>
                                <p class="font-medium text-green-800">Data Pelanggan</p>
                                <p class="text-sm text-green-600">Kelola informasi pelanggan</p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Recent Complaints -->
                <div class="bg-white rounded-xl shadow-lg border border-pdam-light/30 p-6">
                    <h3 class="text-lg font-bold text-pdam-dark mb-6">Pengaduan Terbaru</h3>
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
                                <p class="text-xs text-gray-500">{{ $pengaduan->nama_pelanggan }} - {{ $pengaduan->created_at->diffForHumans() }}</p>
                            </div>
                            <a href="{{ route('admin.pengaduan.show', $pengaduan->id) }}" 
                               class="text-pdam-blue hover:text-pdam-dark">
                                <i class="fas fa-eye text-sm"></i>
                            </a>
                        </div>
                        @empty
                        <p class="text-gray-500 text-center py-4">Belum ada pengaduan</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>