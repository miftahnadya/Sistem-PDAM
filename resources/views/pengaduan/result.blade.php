<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pengaduan - PDAM</title>
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
    <div class="min-h-screen py-8 px-4">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl border border-pdam-light/30 overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-pdam-dark to-pdam-blue p-6 text-white">
                    <h1 class="text-2xl font-bold mb-2">Status Pengaduan</h1>
                    <p class="opacity-90">Tiket: {{ $pengaduan->ticket_number }}</p>
                </div>
                
                <!-- Content -->
                <div class="p-6">
                    <!-- Status Badge -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm font-medium text-gray-500">Status Saat Ini</span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                @if($pengaduan->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($pengaduan->status === 'diproses') bg-blue-100 text-blue-800
                                @elseif($pengaduan->status === 'selesai') bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($pengaduan->status) }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Pengaduan Details -->
                    <div class="space-y-6">
                        <div>
                            <h3 class="font-semibold text-pdam-dark mb-3">Informasi Pengaduan</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">Nama Pelanggan</p>
                                    <p class="font-medium">{{ $pengaduan->nama_pelanggan }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">ID Pelanggan</p>
                                    <p class="font-medium">{{ $pengaduan->id_pelanggan }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Kategori</p>
                                    <p class="font-medium">{{ ucfirst(str_replace('_', ' ', $pengaduan->kategori)) }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Tanggal Dibuat</p>
                                    <p class="font-medium">{{ $pengaduan->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-500 mb-2">Judul Pengaduan</p>
                            <p class="font-medium">{{ $pengaduan->judul }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-500 mb-2">Detail Pengaduan</p>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-gray-700">{{ $pengaduan->detail_pengaduan }}</p>
                            </div>
                        </div>
                        
                        @if($pengaduan->response_admin)
                        <div>
                            <p class="text-sm text-gray-500 mb-2">Respon Admin</p>
                            <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                                <p class="text-blue-700">{{ $pengaduan->response_admin }}</p>
                                @if($pengaduan->tanggal_response)
                                <p class="text-xs text-blue-500 mt-2">
                                    {{ $pengaduan->tanggal_response->format('d/m/Y H:i') }}
                                </p>
                                @endif
                            </div>
                        </div>
                        @endif
                        
                        @if($pengaduan->files && count($pengaduan->files) > 0)
                        <div>
                            <p class="text-sm text-gray-500 mb-2">File Lampiran</p>
                            <div class="space-y-2">
                                @foreach($pengaduan->files as $index => $file)
                                <div class="flex items-center justify-between bg-gray-50 rounded-lg p-3">
                                    <div class="flex items-center">
                                        <i class="fas fa-file text-gray-400 mr-3"></i>
                                        <span class="text-sm">{{ $file['original_name'] }}</span>
                                    </div>
                                    <a href="{{ Storage::url($file['path']) }}" 
                                       target="_blank"
                                       class="text-pdam-blue hover:text-pdam-dark">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="bg-gray-50 px-6 py-4 flex gap-3">
                    <a href="{{ route('pengaduan.track') }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
                    <button onclick="window.print()" 
                            class="bg-pdam-blue hover:bg-pdam-dark text-white px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-print mr-2"></i>
                        Cetak
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>