<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengaduan - PDAM Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <div class="flex w-full min-h-screen">
        @include('component.sidebar')
        
        <!-- Main Content -->
        <div class="flex-1 lg:ml-0 transition-all duration-300">
            <!-- Header -->
            <div class="bg-white shadow-lg border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Kelola Pengaduan</h1>
                        <p class="text-gray-600">Pantau dan tanggapi pengaduan pelanggan</p>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Pending</p>
                                <p class="text-3xl font-bold text-gray-800">{{ $pengaduan->where('status', 'Pending')->count() }}</p>
                            </div>
                            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-clock text-yellow-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Diproses</p>
                                <p class="text-3xl font-bold text-gray-800">{{ $pengaduan->where('status', 'Diproses')->count() }}</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-cog text-blue-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Selesai</p>
                                <p class="text-3xl font-bold text-gray-800">{{ $pengaduan->where('status', 'Selesai')->count() }}</p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-check-circle text-green-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-gray-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Total</p>
                                <p class="text-3xl font-bold text-gray-800">{{ $pengaduan->count() }}</p>
                            </div>
                            <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-headset text-gray-600 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pengaduan List -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Daftar Pengaduan</h3>
                    </div>
                    
                    <div class="divide-y divide-gray-200">
                        @forelse($pengaduan as $item)
                        <div class="p-6 hover:bg-gray-50">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-4 mb-3">
                                        <div>
                                            <h4 class="text-lg font-semibold text-gray-800">{{ $item->judul }}</h4>
                                            <p class="text-sm text-gray-600">{{ $item->nama_pelanggan }} ({{ $item->id_pel }})</p>
                                        </div>
                                        <div class="flex gap-2">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                                {{ $item->status === 'Pending' ? 'bg-yellow-100 text-yellow-800' : 
                                                   ($item->status === 'Diproses' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                                {{ $item->status }}
                                            </span>
                                            <span class="px-2 py-1 text-xs font-semibold bg-gray-100 text-gray-800 rounded-full">
                                                {{ $item->kategori }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <p class="text-gray-700 mb-3">{{ $item->deskripsi }}</p>
                                    
                                    <div class="flex items-center gap-4 text-sm text-gray-500">
                                        <span><i class="fas fa-calendar mr-1"></i>{{ $item->tanggal }}</span>
                                    </div>
                                </div>
                                
                                <div class="flex gap-2 ml-4">
                                    <button onclick="respondPengaduan({{ $item->id }})" 
                                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
                                        <i class="fas fa-reply mr-1"></i>Tanggapi
                                    </button>
                                    <button onclick="viewDetail({{ $item->id }})" 
                                            class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm">
                                        <i class="fas fa-eye mr-1"></i>Detail
                                    </button>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="p-6 text-center text-gray-500">
                            Tidak ada pengaduan ditemukan
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tanggapi Pengaduan -->
    <div id="respondModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-xl shadow-2xl max-w-lg w-full mx-4">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Tanggapi Pengaduan</h3>
            </div>
            <div class="p-6">
                <form id="respondForm">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select id="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="Diproses">Diproses</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggapan</label>
                        <textarea id="tanggapan" rows="4" 
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                  placeholder="Tulis tanggapan Anda..."></textarea>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="closeRespondModal()" 
                                class="px-4 py-2 text-gray-600 hover:text-gray-800">
                            Batal
                        </button>
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                            Kirim Tanggapan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function respondPengaduan(id) {
            document.getElementById('respondModal').classList.remove('hidden');
        }

        function closeRespondModal() {
            document.getElementById('respondModal').classList.add('hidden');
        }

        function viewDetail(id) {
            alert('View detail pengaduan: ' + id);
        }

        document.getElementById('respondForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Simulasi pengiriman tanggapan
            alert('Tanggapan berhasil dikirim!');
            closeRespondModal();
            
            // Di implementasi nyata, kirim data ke server
        });
    </script>
</body>
</html>