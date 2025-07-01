<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Tagihan - Admin PDAM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <div class="flex min-h-screen">
        @include('component.sidebar')
        
        <main class="flex-1 px-4 py-6 lg:px-8 lg:py-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl lg:text-4xl font-bold text-[#10283a] mb-2">
                    <i class="fas fa-file-invoice-dollar mr-3 text-[#6bb6d6]"></i>Kelola Tagihan
                </h1>
                <p class="text-gray-600">Kelola dan input tagihan pelanggan PDAM</p>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Statistik Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Total Tagihan -->
                <div class="rounded-2xl bg-gradient-to-br from-indigo-100 to-indigo-200 p-6 shadow flex flex-col relative">
                    <div class="text-gray-500 text-sm mb-2">Total Tagihan</div>
                    <div class="text-3xl font-bold text-indigo-700 mb-1">
                        Rp {{ number_format($total_tagihan, 0, ',', '.') }}
                    </div>
                    <div class="flex items-center gap-2 text-xs mb-4">
                        <span class="text-blue-500 font-semibold">{{ $total_pelanggan }} Pelanggan</span>
                    </div>
                    <div class="flex gap-1 items-end h-16 mt-auto">
                        <div class="w-3 h-4 bg-indigo-300 rounded-t"></div>
                        <div class="w-3 h-8 bg-indigo-400 rounded-t"></div>
                        <div class="w-3 h-6 bg-indigo-500 rounded-t"></div>
                        <div class="w-3 h-10 bg-indigo-600 rounded-t"></div>
                        <div class="w-3 h-7 bg-indigo-400 rounded-t"></div>
                        <div class="w-3 h-12 bg-indigo-700 rounded-t"></div>
                    </div>
                </div>
                
                <!-- Tagihan Aktif -->
                <div class="rounded-2xl bg-gradient-to-br from-blue-100 to-blue-200 p-6 shadow flex flex-col relative">
                    <div class="text-gray-500 text-sm mb-2">Pelanggan Aktif</div>
                    <div class="text-3xl font-bold text-blue-700 mb-1">
                        Rp {{ number_format($tagihan_lunas, 0, ',', '.') }}
                    </div>
                    <div class="flex items-center gap-2 text-xs mb-4">
                        <span class="text-green-500 font-semibold">Status Aktif</span>
                    </div>
                    <div class="flex gap-1 items-end h-16 mt-auto">
                        <div class="w-3 h-6 bg-blue-300 rounded-t"></div>
                        <div class="w-3 h-10 bg-blue-400 rounded-t"></div>
                        <div class="w-3 h-8 bg-blue-500 rounded-t"></div>
                        <div class="w-3 h-12 bg-blue-600 rounded-t"></div>
                        <div class="w-3 h-7 bg-blue-400 rounded-t"></div>
                        <div class="w-3 h-4 bg-blue-700 rounded-t"></div>
                    </div>
                </div>
                
                <!-- Perlu Perhatian -->
                <div class="rounded-2xl bg-gradient-to-br from-pink-100 to-pink-200 p-6 shadow flex flex-col relative">
                    <div class="text-gray-500 text-sm mb-2">Perlu Perhatian</div>
                    <div class="text-3xl font-bold text-pink-700 mb-1">
                        Rp {{ number_format($tagihan_belum_lunas, 0, ',', '.') }}
                    </div>
                    <div class="flex items-center gap-2 text-xs mb-4">
                        <span class="text-orange-500 font-semibold">Status Review</span>
                    </div>
                    <div class="flex gap-1 items-end h-16 mt-auto">
                        <div class="w-3 h-8 bg-pink-300 rounded-t"></div>
                        <div class="w-3 h-4 bg-pink-400 rounded-t"></div>
                        <div class="w-3 h-12 bg-pink-500 rounded-t"></div>
                        <div class="w-3 h-7 bg-pink-600 rounded-t"></div>
                        <div class="w-3 h-10 bg-pink-400 rounded-t"></div>
                        <div class="w-3 h-6 bg-pink-700 rounded-t"></div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mb-6 flex flex-wrap gap-4">
                <a href="{{ route('admin.input-tagihan') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg flex items-center gap-2 transition">
                    <i class="fas fa-plus"></i>
                    Input Tagihan Baru
                </a>
                
                <button onclick="exportData()" 
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg flex items-center gap-2 transition">
                    <i class="fas fa-download"></i>
                    Export Data
                </button>
                
                <button onclick="refreshData()" 
                        class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg flex items-center gap-2 transition">
                    <i class="fas fa-refresh"></i>
                    Refresh
                </button>
            </div>

            <!-- Tabel Data Tagihan -->
            <div class="bg-white rounded-2xl shadow p-4 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="font-bold text-xl text-[#10283a]">DATA TAGIHAN PELANGGAN</h2>
                    <div class="flex gap-2">
                        <input type="text" placeholder="Cari pelanggan..." 
                               class="px-3 py-2 border rounded-lg text-sm" id="searchInput">
                        <select class="px-3 py-2 border rounded-lg text-sm" id="filterStatus">
                            <option value="">Semua Status</option>
                            <option value="AKTIF">Aktif</option>
                            <option value="TIDAK AKTIF">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="bg-gradient-to-r from-[#10283a] to-[#1e355e] text-white">
                                <th class="py-3 px-4 text-left">ID Pelanggan</th>
                                <th class="py-3 px-4 text-left">Nama</th>
                                <th class="py-3 px-4 text-center">Periode</th>
                                <th class="py-3 px-4 text-center">Pemakaian</th>
                                <th class="py-3 px-4 text-right">Total Tagihan</th>
                                <th class="py-3 px-4 text-center">Status</th>
                                <th class="py-3 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tagihanTableBody">
                            @forelse($tagihan_data as $index => $tagihan)
                            <tr class="border-b hover:bg-blue-50 cursor-pointer {{ $index % 2 == 0 ? 'bg-gray-50' : 'bg-white' }}" 
                                data-nama="{{ strtolower($tagihan->nama_pelanggan) }}" 
                                data-status="{{ $tagihan->status_pelanggan }}">
                                <td class="py-3 px-4">
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium">
                                        {{ $tagihan->id_pel }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="font-medium">{{ $tagihan->nama_pelanggan }}</div>
                                    <div class="text-xs text-gray-500">{{ $tagihan->alamat }}</div>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    @if($tagihan->periode_terakhir)
                                        @php
                                            $tahun = substr($tagihan->periode_terakhir, 0, 4);
                                            $bulan = substr($tagihan->periode_terakhir, 4, 2);
                                            $nama_bulan = ['01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'Mei','06'=>'Jun','07'=>'Jul','08'=>'Ags','09'=>'Sep','10'=>'Okt','11'=>'Nov','12'=>'Des'];
                                        @endphp
                                        <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs">
                                            {{ $nama_bulan[$bulan] ?? $bulan }} {{ $tahun }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-xs">Belum ada</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <span class="font-medium">{{ $tagihan->total_pemakaian_m3 ?? 0 }}</span>
                                    <span class="text-xs text-gray-500">m³</span>
                                </td>
                                <td class="py-3 px-4 text-right font-bold">
                                    Rp {{ number_format($tagihan->total_tagihan, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-4 text-center">
                                    @if($tagihan->status_pelanggan == 'AKTIF')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-times-circle mr-1"></i>
                                            Tidak Aktif
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('admin.edit-tagihan', $tagihan->id_pel) }}" 
                                           class="text-blue-600 hover:text-blue-900 bg-blue-100 px-3 py-1 rounded transition" 
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button onclick="viewDetail('{{ $tagihan->id_pel }}')" 
                                                class="text-green-600 hover:text-green-900 bg-green-100 px-3 py-1 rounded transition" 
                                                title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button onclick="printBill('{{ $tagihan->id_pel }}')" 
                                                class="text-purple-600 hover:text-purple-900 bg-purple-100 px-3 py-1 rounded transition" 
                                                title="Print">
                                            <i class="fas fa-print"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                    <i class="fas fa-inbox text-6xl mb-4 block text-gray-300"></i>
                                    <h3 class="text-xl font-medium mb-2">Belum ada data tagihan</h3>
                                    <p class="text-sm">Mulai input tagihan untuk pelanggan</p>
                                    <a href="{{ route('admin.input-tagihan') }}" 
                                       class="inline-flex items-center mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                        <i class="fas fa-plus mr-2"></i>
                                        Input Tagihan Pertama
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Sidebar Pelanggan -->
            <div class="bg-white rounded-2xl shadow p-4">
                <h3 class="font-bold text-base mb-4">DAFTAR PELANGGAN</h3>
                <div class="space-y-3 max-h-96 overflow-y-auto">
                    @foreach($pelanggan->take(10) as $p)
                    <div class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-lg transition">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr($p->nama_pelanggan, 0, 1)) }}
                        </div>
                        <div class="flex-1">
                            <div class="font-semibold text-gray-700 text-sm">{{ $p->nama_pelanggan }}</div>
                            <div class="text-xs text-gray-400">{{ $p->id_pel }}</div>
                            <span class="inline-block mt-1 bg-{{ $p->status_pelanggan == 'AKTIF' ? 'green' : 'red' }}-100 text-{{ $p->status_pelanggan == 'AKTIF' ? 'green' : 'red' }}-800 text-xs px-2 py-0.5 rounded">
                                {{ $p->status_pelanggan }}
                            </span>
                        </div>
                        <div class="flex gap-2">
                            <button onclick="quickEdit('{{ $p->id_pel }}')" class="text-blue-500 hover:text-blue-700">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="quickView('{{ $p->id_pel }}')" class="text-green-500 hover:text-green-700">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </main>
    </div>

    <script>
        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            filterTable();
        });

        document.getElementById('filterStatus').addEventListener('change', function() {
            filterTable();
        });

        function filterTable() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const statusFilter = document.getElementById('filterStatus').value;
            const rows = document.querySelectorAll('#tagihanTableBody tr');

            rows.forEach(row => {
                if (row.children.length === 1) return; // Skip empty state row
                
                const nama = row.dataset.nama || '';
                const status = row.dataset.status || '';
                
                const matchesSearch = nama.includes(searchTerm);
                const matchesStatus = !statusFilter || status === statusFilter;
                
                row.style.display = matchesSearch && matchesStatus ? '' : 'none';
            });
        }

        function viewDetail(idPel) {
            alert('View detail untuk ID: ' + idPel);
        }

        function printBill(idPel) {
            alert('Print tagihan untuk ID: ' + idPel);
        }

        function exportData() {
            alert('Export data tagihan');
        }

        function refreshData() {
            location.reload();
        }

        function quickEdit(idPel) {
            window.location.href = `/admin/edit-tagihan/${idPel}`;
        }

        function quickView(idPel) {
            alert('Quick view untuk ID: ' + idPel);
        }
    </script>
</body>
</html>