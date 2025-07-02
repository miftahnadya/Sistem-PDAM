<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengaduan - Admin PDAM</title>
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
    <style>
        .fade-in { animation: fadeIn 0.5s ease-in; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(0, 87, 146, 0.15); }
        .timeline-item { position: relative; padding-left: 2rem; }
        .timeline-item::before { 
            content: ''; 
            position: absolute; 
            left: 0.5rem; 
            top: 0; 
            bottom: 0; 
            width: 2px; 
            background: #D1F4FA; 
        }
        .timeline-dot { 
            position: absolute; 
            left: 0; 
            top: 0.5rem; 
            width: 1rem; 
            height: 1rem; 
            border-radius: 50%; 
            border: 2px solid white; 
            box-shadow: 0 2px 8px rgba(0,0,0,0.1); 
        }
        .image-preview { max-width: 200px; max-height: 200px; object-fit: cover; }
        .file-icon { width: 40px; height: 40px; }
    </style>
</head>
<body class="bg-gradient-to-br from-pdam-lightest to-pdam-light min-h-screen">
    <div class="flex min-h-screen">
        <!-- Sidebar Admin -->
        @include('component.sidebar')
        
        <!-- Main Content -->
        <main class="flex-1 lg:ml-72 px-6 py-8">
            <!-- Header -->
            <div class="mb-8 fade-in">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('admin.pengaduan.index') }}" 
                           class="text-pdam-blue hover:text-pdam-dark transition-colors">
                            <i class="fas fa-arrow-left text-2xl"></i>
                        </a>
                        <div>
                            <h1 class="text-3xl font-bold text-pdam-dark mb-2">Detail Pengaduan</h1>
                            <p class="text-gray-600">Tiket: {{ $pengaduan->ticket_number }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button onclick="window.print()" 
                                class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-print mr-2"></i>
                            Cetak
                        </button>
                        <button onclick="openStatusModal()" 
                                class="bg-pdam-blue hover:bg-pdam-dark text-white px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-edit mr-2"></i>
                            Update Status
                        </button>
                        @if($pengaduan->no_hp)
                        <a href="tel:{{ $pengaduan->no_hp }}" 
                           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-phone mr-2"></i>
                            Hubungi
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Status & Priority Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 fade-in">
                        <!-- Status Card -->
                        <div class="bg-white rounded-xl shadow-lg border border-pdam-light/30 p-6 card-hover">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-bold text-pdam-dark">Status Pengaduan</h3>
                                <div class="w-3 h-3 rounded-full 
                                    @if($pengaduan->status === 'pending') bg-yellow-500
                                    @elseif($pengaduan->status === 'diproses') bg-blue-500
                                    @elseif($pengaduan->status === 'selesai') bg-green-500
                                    @else bg-gray-500
                                    @endif">
                                </div>
                            </div>
                            <div class="text-center">
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-lg font-medium 
                                    @if($pengaduan->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($pengaduan->status === 'diproses') bg-blue-100 text-blue-800
                                    @elseif($pengaduan->status === 'selesai') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    <i class="fas fa-
                                        @if($pengaduan->status === 'pending') clock
                                        @elseif($pengaduan->status === 'diproses') cogs
                                        @elseif($pengaduan->status === 'selesai') check-circle
                                        @else times-circle
                                        @endif mr-2">
                                    </i>
                                    {{ ucfirst($pengaduan->status) }}
                                </span>
                            </div>
                        </div>

                        <!-- Priority Card -->
                        <div class="bg-white rounded-xl shadow-lg border border-pdam-light/30 p-6 card-hover">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-bold text-pdam-dark">Prioritas</h3>
                                <div class="w-3 h-3 rounded-full 
                                    @if($pengaduan->prioritas === 'tinggi') bg-red-500
                                    @elseif($pengaduan->prioritas === 'sedang') bg-yellow-500
                                    @else bg-green-500
                                    @endif">
                                </div>
                            </div>
                            <div class="text-center">
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-lg font-medium 
                                    @if($pengaduan->prioritas === 'tinggi') bg-red-100 text-red-800
                                    @elseif($pengaduan->prioritas === 'sedang') bg-yellow-100 text-yellow-800
                                    @else bg-green-100 text-green-800
                                    @endif">
                                    <i class="fas fa-
                                        @if($pengaduan->prioritas === 'tinggi') exclamation-triangle
                                        @elseif($pengaduan->prioritas === 'sedang') exclamation-circle
                                        @else check-circle
                                        @endif mr-2">
                                    </i>
                                    {{ ucfirst($pengaduan->prioritas ?? 'Belum Ditentukan') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Pengaduan Details -->
                    <div class="bg-white rounded-xl shadow-lg border border-pdam-light/30 p-6 fade-in">
                        <h3 class="text-xl font-bold text-pdam-dark mb-6">Detail Pengaduan</h3>
                        
                        <div class="space-y-6">
                            <!-- Judul -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Judul Pengaduan</label>
                                <div class="bg-pdam-lightest rounded-lg p-4">
                                    <h4 class="text-lg font-semibold text-pdam-dark">{{ $pengaduan->judul }}</h4>
                                </div>
                            </div>

                            <!-- Kategori -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-pdam-light text-pdam-dark">
                                    <i class="fas fa-tag mr-2"></i>
                                    {{ ucfirst(str_replace('_', ' ', $pengaduan->kategori)) }}
                                </span>
                            </div>

                            <!-- Detail Pengaduan -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Detail Pengaduan</label>
                                <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-pdam-blue">
                                    <p class="text-gray-700 leading-relaxed">{{ $pengaduan->detail_pengaduan }}</p>
                                </div>
                            </div>

                            <!-- Files/Attachments -->
                            @if($pengaduan->files && count($pengaduan->files) > 0)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-paperclip mr-1"></i>
                                    File Lampiran ({{ count($pengaduan->files) }})
                                </label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach($pengaduan->files as $index => $file)
                                    <div class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-3">
                                                @if(in_array(strtolower(pathinfo($file['original_name'], PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif']))
                                                <div class="file-icon bg-green-100 rounded-lg flex items-center justify-center">
                                                    <i class="fas fa-image text-green-600"></i>
                                                </div>
                                                @elseif(strtolower(pathinfo($file['original_name'], PATHINFO_EXTENSION)) === 'pdf')
                                                <div class="file-icon bg-red-100 rounded-lg flex items-center justify-center">
                                                    <i class="fas fa-file-pdf text-red-600"></i>
                                                </div>
                                                @else
                                                <div class="file-icon bg-blue-100 rounded-lg flex items-center justify-center">
                                                    <i class="fas fa-file text-blue-600"></i>
                                                </div>
                                                @endif
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900 truncate max-w-40">
                                                        {{ $file['original_name'] }}
                                                    </p>
                                                    <p class="text-xs text-gray-500">
                                                        {{ number_format($file['size'] / 1024, 1) }} KB
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                @if(in_array(strtolower(pathinfo($file['original_name'], PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif']))
                                                <button onclick="previewImage('{{ Storage::url($file['path']) }}', '{{ $file['original_name'] }}')" 
                                                        class="text-pdam-blue hover:text-pdam-dark transition-colors" title="Preview">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                @endif
                                                <a href="{{ route('admin.pengaduan.download-file', [$pengaduan->id, $index]) }}" 
                                                   class="text-green-600 hover:text-green-800 transition-colors" title="Download">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <!-- Admin Response -->
                            @if($pengaduan->response_admin)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Respon Admin</label>
                                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-user-shield text-blue-600 text-lg"></i>
                                        </div>
                                        <div class="ml-3 flex-1">
                                            <p class="text-blue-700">{{ $pengaduan->response_admin }}</p>
                                            @if($pengaduan->tanggal_response)
                                            <p class="text-xs text-blue-500 mt-2">
                                                <i class="fas fa-clock mr-1"></i>
                                                {{ $pengaduan->tanggal_response->format('d/m/Y H:i') }}
                                            </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar Information -->
                <div class="space-y-6">
                    <!-- Customer Info -->
                    <div class="bg-white rounded-xl shadow-lg border border-pdam-light/30 p-6 fade-in">
                        <h3 class="text-lg font-bold text-pdam-dark mb-4">
                            <i class="fas fa-user mr-2"></i>
                            Informasi Pelanggan
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</label>
                                <p class="text-sm font-medium text-gray-900">{{ $pengaduan->nama_pelanggan }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">ID Pelanggan</label>
                                <p class="text-sm font-medium text-gray-900">{{ $pengaduan->id_pelanggan }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">No. HP</label>
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-gray-900">{{ $pengaduan->no_hp }}</p>
                                    <a href="tel:{{ $pengaduan->no_hp }}" 
                                       class="text-green-600 hover:text-green-800 transition-colors">
                                        <i class="fas fa-phone"></i>
                                    </a>
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</label>
                                <p class="text-sm text-gray-900 leading-relaxed">{{ $pengaduan->alamat }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Timeline -->
                    <div class="bg-white rounded-xl shadow-lg border border-pdam-light/30 p-6 fade-in">
                        <h3 class="text-lg font-bold text-pdam-dark mb-4">
                            <i class="fas fa-history mr-2"></i>
                            Timeline
                        </h3>
                        <div class="space-y-4">
                            <!-- Created -->
                            <div class="timeline-item">
                                <div class="timeline-dot bg-blue-500"></div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Pengaduan Dibuat</p>
                                    <p class="text-xs text-gray-500">{{ $pengaduan->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>

                            @if($pengaduan->status !== 'pending')
                            <!-- In Progress -->
                            <div class="timeline-item">
                                <div class="timeline-dot bg-yellow-500"></div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Status: {{ ucfirst($pengaduan->status) }}</p>
                                    <p class="text-xs text-gray-500">{{ $pengaduan->updated_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                            @endif

                            @if($pengaduan->tanggal_response)
                            <!-- Response -->
                            <div class="timeline-item">
                                <div class="timeline-dot bg-green-500"></div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Admin Merespon</p>
                                    <p class="text-xs text-gray-500">{{ $pengaduan->tanggal_response->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-xl shadow-lg border border-pdam-light/30 p-6 fade-in">
                        <h3 class="text-lg font-bold text-pdam-dark mb-4">
                            <i class="fas fa-bolt mr-2"></i>
                            Aksi Cepat
                        </h3>
                        <div class="space-y-3">
                            <button onclick="openStatusModal()" 
                                    class="w-full flex items-center justify-center px-4 py-2 bg-pdam-blue hover:bg-pdam-dark text-white rounded-lg transition-colors">
                                <i class="fas fa-edit mr-2"></i>
                                Update Status
                            </button>
                            @if($pengaduan->no_hp)
                            <a href="tel:{{ $pengaduan->no_hp }}" 
                               class="w-full flex items-center justify-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">
                                <i class="fas fa-phone mr-2"></i>
                                Hubungi Pelanggan
                            </a>
                            @endif
                            <button onclick="window.print()" 
                                    class="w-full flex items-center justify-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors">
                                <i class="fas fa-print mr-2"></i>
                                Cetak Detail
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Status Update Modal -->
    <div id="statusModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <form method="POST" action="{{ route('admin.pengaduan.update-status', $pengaduan->id) }}">
                @csrf
                @method('PUT')
                <div class="mt-3">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Update Status Pengaduan</h3>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" class="w-full border border-gray-300 rounded-md px-3 py-2">
                            <option value="pending" {{ $pengaduan->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="diproses" {{ $pengaduan->status === 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ $pengaduan->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="ditutup" {{ $pengaduan->status === 'ditutup' ? 'selected' : '' }}>Ditutup</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Prioritas</label>
                        <select name="prioritas" class="w-full border border-gray-300 rounded-md px-3 py-2">
                            <option value="rendah" {{ $pengaduan->prioritas === 'rendah' ? 'selected' : '' }}>Rendah</option>
                            <option value="sedang" {{ $pengaduan->prioritas === 'sedang' ? 'selected' : '' }}>Sedang</option>
                            <option value="tinggi" {{ $pengaduan->prioritas === 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Respon Admin</label>
                        <textarea name="response_admin" rows="4" 
                                  class="w-full border border-gray-300 rounded-md px-3 py-2"
                                  placeholder="Berikan respon atau keterangan...">{{ $pengaduan->response_admin }}</textarea>
                    </div>

                    <div class="flex items-center justify-end space-x-3">
                        <button type="button" onclick="closeStatusModal()" 
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Batal
                        </button>
                        <button type="submit" 
                                class="bg-pdam-dark hover:bg-pdam-blue text-white font-bold py-2 px-4 rounded">
                            Update
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Image Preview Modal -->
    <div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-75 overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto max-w-4xl">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="flex items-center justify-between p-4 border-b">
                    <h3 id="imageTitle" class="text-lg font-medium text-gray-900"></h3>
                    <button onclick="closeImageModal()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div class="p-4 text-center">
                    <img id="imagePreview" src="" alt="" class="max-w-full max-h-96 mx-auto rounded-lg shadow-md">
                </div>
            </div>
        </div>
    </div>

    <script>
        function openStatusModal() {
            document.getElementById('statusModal').classList.remove('hidden');
        }

        function closeStatusModal() {
            document.getElementById('statusModal').classList.add('hidden');
        }

        function previewImage(url, title) {
            document.getElementById('imagePreview').src = url;
            document.getElementById('imageTitle').textContent = title;
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }

        // Animation delays
        document.querySelectorAll('.fade-in').forEach((el, index) => {
            el.style.animationDelay = `${index * 0.1}s`;
        });

        // Close modals when clicking outside
        window.onclick = function(event) {
            const statusModal = document.getElementById('statusModal');
            const imageModal = document.getElementById('imageModal');
            
            if (event.target === statusModal) {
                closeStatusModal();
            }
            if (event.target === imageModal) {
                closeImageModal();
            }
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeStatusModal();
                closeImageModal();
            }
        });
    </script>
</body>
</html>