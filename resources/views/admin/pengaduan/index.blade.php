<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengaduan - Admin PDAM</title>
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
        .table-hover:hover { background-color: rgba(237, 249, 252, 0.5); }
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
                    <div>
                        <h1 class="text-3xl font-bold text-pdam-dark mb-2">Kelola Pengaduan</h1>
                        <p class="text-gray-600">Monitoring dan penanganan pengaduan pelanggan PDAM</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button onclick="exportExcel()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-file-excel mr-2"></i>
                            Export Excel
                        </button>
                        <button onclick="refreshData()" class="bg-pdam-blue hover:bg-pdam-dark text-white px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-sync-alt mr-2"></i>
                            Refresh
                        </button>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-lg border border-pdam-light/30 p-6 card-hover fade-in">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Total Pengaduan</p>
                            <p class="text-2xl font-bold text-pdam-dark">{{ $stats['total'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-pdam-lightest rounded-lg flex items-center justify-center">
                            <i class="fas fa-comments text-pdam-blue text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg border border-pdam-light/30 p-6 card-hover fade-in">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Pending</p>
                            <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clock text-yellow-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg border border-pdam-light/30 p-6 card-hover fade-in">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Diproses</p>
                            <p class="text-2xl font-bold text-blue-600">{{ $stats['diproses'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-cogs text-blue-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg border border-pdam-light/30 p-6 card-hover fade-in">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Selesai</p>
                            <p class="text-2xl font-bold text-green-600">{{ $stats['selesai'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg border border-pdam-light/30 p-6 card-hover fade-in">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Ditutup</p>
                            <p class="text-2xl font-bold text-gray-600">{{ $stats['ditutup'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-times-circle text-gray-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-xl shadow-lg border border-pdam-light/30 p-6 mb-6 fade-in">
                <form method="GET" action="{{ route('admin.pengaduan.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-pdam-dark mb-2">Cari</label>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Nomor tiket, nama, ID pelanggan..."
                               class="w-full border border-pdam-light/50 rounded-lg px-4 py-2 focus:outline-none focus:border-pdam-blue">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-pdam-dark mb-2">Status</label>
                        <select name="status" class="w-full border border-pdam-light/50 rounded-lg px-4 py-2 focus:outline-none focus:border-pdam-blue">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="ditutup" {{ request('status') == 'ditutup' ? 'selected' : '' }}>Ditutup</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-pdam-dark mb-2">Kategori</label>
                        <select name="kategori" class="w-full border border-pdam-light/50 rounded-lg px-4 py-2 focus:outline-none focus:border-pdam-blue">
                            <option value="">Semua Kategori</option>
                            <option value="kualitas_air" {{ request('kategori') == 'kualitas_air' ? 'selected' : '' }}>Kualitas Air</option>
                            <option value="ketersediaan_air" {{ request('kategori') == 'ketersediaan_air' ? 'selected' : '' }}>Ketersediaan Air</option>
                            <option value="tagihan" {{ request('kategori') == 'tagihan' ? 'selected' : '' }}>Tagihan</option>
                            <option value="pelayanan" {{ request('kategori') == 'pelayanan' ? 'selected' : '' }}>Pelayanan</option>
                            <option value="perbaikan" {{ request('kategori') == 'perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                            <option value="lainnya" {{ request('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-pdam-dark mb-2">Prioritas</label>
                        <select name="prioritas" class="w-full border border-pdam-light/50 rounded-lg px-4 py-2 focus:outline-none focus:border-pdam-blue">
                            <option value="">Semua Prioritas</option>
                            <option value="rendah" {{ request('prioritas') == 'rendah' ? 'selected' : '' }}>Rendah</option>
                            <option value="sedang" {{ request('prioritas') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                            <option value="tinggi" {{ request('prioritas') == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                        </select>
                    </div>

                    <div class="md:col-span-4 flex gap-3">
                        <button type="submit" class="bg-pdam-dark hover:bg-pdam-blue text-white px-6 py-2 rounded-lg transition-colors">
                            <i class="fas fa-search mr-2"></i>
                            Filter
                        </button>
                        <a href="{{ route('admin.pengaduan.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition-colors">
                            <i class="fas fa-times mr-2"></i>
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Pengaduan Table -->
            <div class="bg-white rounded-xl shadow-lg border border-pdam-light/30 overflow-hidden fade-in">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-pdam-lightest">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-pdam-dark uppercase tracking-wider">Tiket</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-pdam-dark uppercase tracking-wider">Pelanggan</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-pdam-dark uppercase tracking-wider">Kategori</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-pdam-dark uppercase tracking-wider">Judul</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-pdam-dark uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-pdam-dark uppercase tracking-wider">Prioritas</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-pdam-dark uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-pdam-dark uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($pengaduan as $item)
                            <tr class="table-hover transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-pdam-dark">{{ $item->ticket_number }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $item->nama_pelanggan }}</div>
                                    <div class="text-sm text-gray-500">ID: {{ $item->id_pelanggan }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-pdam-dark">{{ $item->kategori_label }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 max-w-xs truncate">{{ $item->judul }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $item->status_badge }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $item->prioritas_badge }}">
                                        {{ ucfirst($item->prioritas) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $item->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('admin.pengaduan.show', $item->id) }}" 
                                           class="text-pdam-blue hover:text-pdam-dark transition-colors" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button onclick="openStatusModal({{ $item->id }}, '{{ $item->status }}', '{{ $item->prioritas }}')" 
                                                class="text-yellow-600 hover:text-yellow-800 transition-colors" title="Edit Status">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        @if($item->no_hp)
                                        <a href="tel:{{ $item->no_hp }}" 
                                           class="text-green-600 hover:text-green-800 transition-colors" title="Hubungi">
                                            <i class="fas fa-phone"></i>
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                    <i class="fas fa-inbox text-4xl mb-4 text-gray-300"></i>
                                    <p class="text-lg font-medium mb-2">Tidak ada pengaduan ditemukan</p>
                                    <p class="text-sm">Belum ada pengaduan yang masuk atau sesuai dengan filter</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($pengaduan->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $pengaduan->links() }}
                </div>
                @endif
            </div>
        </main>
    </div>

    <!-- Status Update Modal -->
    <div id="statusModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <form id="statusForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mt-3">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Update Status Pengaduan</h3>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" id="statusSelect" class="w-full border border-gray-300 rounded-md px-3 py-2">
                            <option value="pending">Pending</option>
                            <option value="diproses">Diproses</option>
                            <option value="selesai">Selesai</option>
                            <option value="ditutup">Ditutup</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Prioritas</label>
                        <select name="prioritas" id="prioritasSelect" class="w-full border border-gray-300 rounded-md px-3 py-2">
                            <option value="rendah">Rendah</option>
                            <option value="sedang">Sedang</option>
                            <option value="tinggi">Tinggi</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Respon Admin</label>
                        <textarea name="response_admin" rows="3" 
                                  class="w-full border border-gray-300 rounded-md px-3 py-2"
                                  placeholder="Berikan respon atau keterangan..."></textarea>
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

    <script>
        function openStatusModal(id, currentStatus, currentPrioritas) {
            document.getElementById('statusForm').action = `/admin/pengaduan/${id}/update-status`;
            document.getElementById('statusSelect').value = currentStatus;
            document.getElementById('prioritasSelect').value = currentPrioritas;
            document.getElementById('statusModal').classList.remove('hidden');
        }

        function closeStatusModal() {
            document.getElementById('statusModal').classList.add('hidden');
        }

        function refreshData() {
            window.location.reload();
        }

        function exportExcel() {
            window.location.href = "{{ route('admin.pengaduan.export-excel') }}?" + new URLSearchParams(window.location.search);
        }

        // Animation delays
        document.querySelectorAll('.fade-in').forEach((el, index) => {
            el.style.animationDelay = `${index * 0.1}s`;
        });

        // Auto refresh setiap 5 menit
        setInterval(function() {
            if (confirm('Refresh data pengaduan untuk update terbaru?')) {
                refreshData();
            }
        }, 300000); // 5 menit
    </script>
</body>
</html>