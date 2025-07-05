<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Tagihan - PDAM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#005792',
                        secondary: '#53CDE2',
                        accent: '#D1F4FA',
                        light: '#EDF9FC'
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .loading {
            display: none;
        }
        
        .loading.show {
            display: inline-block;
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 87, 146, 0.1);
        }
        
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }
        
        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #005792 0%, #53CDE2 100%);
        }
        
        @media print {
            .no-print { display: none !important; }
        }
    </style>
</head>
<body class="bg-light">
    <!-- Include Sidebar -->
    @include('component.sidebar')
    
    <!-- Main Content -->
    <div class="lg:ml-72 transition-all duration-300">
        <!-- Top Header -->
        <header class="gradient-bg shadow-lg sticky top-0 z-20 no-print">
            <div class="px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="ml-12 lg:ml-0">
                        <h1 class="text-2xl font-bold text-white">
                            <i class="fas fa-file-invoice-dollar mr-3"></i>
                            Cek Tagihan
                        </h1>
                        <p class="text-white text-opacity-90 mt-1">Lihat dan kelola tagihan air Anda</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-right">
                            <p class="text-sm text-white text-opacity-80">{{ date('l, d F Y') }}</p>
                            <p class="text-sm font-medium text-white" id="currentTime"></p>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <main class="p-6 max-w-7xl mx-auto">
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center no-print">
                    <i class="fas fa-check-circle mr-3 text-green-500"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center no-print">
                    <i class="fas fa-exclamation-triangle mr-3 text-red-500"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Filter Card -->
            <div class="bg-white rounded-xl shadow-sm border border-accent p-6 mb-6 fade-in no-print">
                <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start space-y-6 lg:space-y-0">
                    <div class="flex-1">
                        <h2 class="text-lg font-semibold text-primary mb-4 flex items-center">
                            <i class="fas fa-filter text-secondary mr-3"></i>
                            Filter Tagihan
                        </h2>
                        
                        <!-- Filter Form -->
                        <div class="bg-light rounded-xl p-4">
                            <form action="{{ route('cektagihan') }}" method="GET" class="space-y-4" id="filterForm">
                                <div class="flex flex-col lg:flex-row lg:items-end space-y-4 lg:space-y-0 lg:space-x-4">
                                    <div class="flex-1">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="far fa-calendar-alt mr-2 text-secondary"></i>Pilih Bulan Tagihan
                                        </label>
                                        <select name="periode" 
                                            id="periode"
                                            class="w-full border border-accent bg-white focus:outline-none focus:border-secondary focus:ring-2 focus:ring-secondary/20 text-sm px-4 py-3 rounded-lg transition-all duration-300 hover:border-secondary/50"
                                            onchange="filterByPeriode()">
                                            <option value="">-- Pilih Periode --</option>
                                            @if(isset($periode_tersedia) && $periode_tersedia->count() > 0)
                                                @foreach($periode_tersedia as $periode)
                                                    <option value="{{ $periode['periode'] }}" 
                                                        {{ request('periode') === $periode['periode'] ? 'selected' : '' }}>
                                                        {{ $periode['formatted'] }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="lg:flex-shrink-0">
                                        <button type="submit" 
                                            class="w-full lg:w-auto bg-primary text-white font-medium px-6 py-3 rounded-lg hover:bg-primary/90 transition-all duration-300 flex items-center justify-center shadow-lg"
                                            id="searchBtn">
                                            <i class="fas fa-search mr-2"></i>
                                            <span>Cek Tagihan</span>
                                            <div class="loading ml-2">
                                                <i class="fas fa-spinner fa-spin"></i>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Quick Filter Buttons -->
                                <div class="flex flex-wrap gap-2 mt-4">
                                    @if(Auth::user()->periode_terakhir)
                                    <button type="button" onclick="setCurrentPeriode('{{ Auth::user()->periode_terakhir }}')" 
                                        class="text-sm bg-secondary/20 text-primary px-3 py-1 rounded-full hover:bg-secondary/30 transition-colors">
                                        <i class="fas fa-bolt mr-1"></i>
                                        Periode Terkini
                                    </button>
                                    @endif
                                    <button type="button" onclick="clearFilter()" 
                                        class="text-sm bg-red-100 text-red-700 px-3 py-1 rounded-full hover:bg-red-200 transition-colors">
                                        <i class="fas fa-times mr-1"></i>
                                        Reset Filter
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Info Card -->
                    <div class="flex justify-center lg:justify-end lg:ml-6">
                        <div class="bg-gradient-to-br from-accent to-light p-6 rounded-xl border border-secondary/20">
                            <div class="text-center">
                                <div class="w-16 h-16 bg-gradient-to-br from-primary to-secondary rounded-full flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-file-invoice-dollar text-white text-2xl"></i>
                                </div>
                                <h3 class="text-sm font-semibold text-primary mb-1">Informasi Tagihan</h3>
                                <p class="text-xs text-gray-700">{{ Auth::user()->nama_pelanggan ?? 'Pelanggan' }}</p>
                                <p class="text-xs text-gray-600">ID: {{ Auth::user()->id_pel ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div id="statsSection" class="{{ isset($tagihans) && $tagihans->count() > 0 ? '' : 'hidden' }}">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <div class="bg-white rounded-xl shadow-sm border border-accent p-6 fade-in card-hover">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-secondary/20 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-tint text-secondary text-lg"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Pemakaian</p>
                                <p class="text-xl font-bold text-primary" id="statPemakaian">
                                    {{ isset($summary) ? number_format($summary['total_pemakaian'], 0, ',', '.') : '0' }} m³
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow-sm border border-accent p-6 fade-in card-hover">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-money-bill-wave text-green-600 text-lg"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Tagihan</p>
                                <p class="text-xl font-bold text-primary" id="statTagihan">
                                    Rp {{ isset($summary) ? number_format($summary['total_tagihan'], 0, ',', '.') : '0' }}
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow-sm border border-accent p-6 fade-in card-hover">
                        <div class="flex items-center">
                            <div class="w-12 h-12 {{ isset($summary) && $summary['total_denda'] > 0 ? 'bg-red-100' : 'bg-green-100' }} rounded-lg flex items-center justify-center mr-4">
                                <i class="fas {{ isset($summary) && $summary['total_denda'] > 0 ? 'fa-exclamation-triangle text-red-600' : 'fa-check-circle text-green-600' }} text-lg"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Denda</p>
                                <p class="text-xl font-bold {{ isset($summary) && $summary['total_denda'] > 0 ? 'text-red-600' : 'text-green-600' }}" id="statDenda">
                                    Rp {{ isset($summary) ? number_format($summary['total_denda'], 0, ',', '.') : '0' }}
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow-sm border border-accent p-6 fade-in card-hover">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-calendar-check text-purple-600 text-lg"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Jumlah Tagihan</p>
                                <p class="text-xl font-bold text-primary" id="statRecords">
                                    {{ isset($summary) ? $summary['total_records'] : '0' }} Record
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Loading Skeleton -->
            <div id="loadingSkeleton" class="hidden">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    @for($i = 0; $i < 4; $i++)
                    <div class="bg-white rounded-xl shadow-sm border border-accent p-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gray-200 rounded-lg mr-4 skeleton"></div>
                            <div class="flex-1">
                                <div class="h-4 bg-gray-200 rounded skeleton mb-2"></div>
                                <div class="h-6 bg-gray-200 rounded skeleton"></div>
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>

            <!-- Table Card -->
            <div class="bg-white rounded-xl shadow-sm border border-accent overflow-hidden fade-in">
                <!-- Table Header -->
                <div class="gradient-bg px-6 py-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-white flex items-center">
                            <i class="fas fa-table mr-3"></i>
                            Rincian Tagihan
                            <span class="ml-2 bg-white/20 text-white px-2 py-1 rounded-full text-xs" id="recordCount">
                                {{ isset($tagihans) ? $tagihans->count() : '0' }} data
                            </span>
                        </h3>
                        <div class="flex items-center space-x-2" id="tableActions">
                            @if(isset($tagihans) && $tagihans->count() > 0)
                            <button onclick="window.print()" class="bg-white/20 text-white px-3 py-1 rounded text-sm hover:bg-white/30 transition no-print">
                                <i class="fas fa-print mr-1"></i> Print
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-accent">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">
                                    <i class="fas fa-id-card mr-1"></i>ID Pelanggan
                                </th>
                                <th class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">
                                    <i class="fas fa-user mr-1"></i>Nama Pelanggan
                                </th>
                                <th class="px-4 lg:px-6 py-3 text-center text-xs font-medium text-primary uppercase tracking-wider hidden lg:table-cell">
                                    <i class="fas fa-calendar mr-1"></i>Periode
                                </th>
                                <th class="px-4 lg:px-6 py-3 text-center text-xs font-medium text-primary uppercase tracking-wider hidden lg:table-cell">
                                    <i class="fas fa-tint mr-1"></i>Pemakaian
                                </th>
                                <th class="px-4 lg:px-6 py-3 text-right text-xs font-medium text-primary uppercase tracking-wider hidden md:table-cell">
                                    <i class="fas fa-water mr-1"></i>Harga Air
                                </th>
                                <th class="px-4 lg:px-6 py-3 text-right text-xs font-medium text-primary uppercase tracking-wider hidden lg:table-cell">
                                    <i class="fas fa-cog mr-1"></i>B.Admin
                                </th>
                                <th class="px-4 lg:px-6 py-3 text-right text-xs font-medium text-primary uppercase tracking-wider hidden lg:table-cell">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>Denda
                                </th>
                                <th class="px-4 lg:px-6 py-3 text-right text-xs font-medium text-primary uppercase tracking-wider">
                                    <i class="fas fa-money-bill mr-1"></i>Total Tagihan
                                </th>
                                <th class="px-4 lg:px-6 py-3 text-center text-xs font-medium text-primary uppercase tracking-wider no-print">
                                    <i class="fas fa-cogs mr-1"></i>Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-accent" id="tableBody">
                            @forelse($tagihans as $index => $tagihan)
                            <tr class="hover:bg-light transition-colors duration-200 table-row" 
                                style="animation-delay: {{ $index * 0.1 }}s">
                                <td class="px-4 lg:px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-secondary/20 text-primary">
                                        {{ $tagihan->id_pel }}
                                    </span>
                                </td>
                                <td class="px-4 lg:px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $tagihan->nama_pelanggan }}</div>
                                    <div class="text-sm text-gray-500 lg:hidden">
                                        {{ $tagihan->periode_formatted }}
                                    </div>
                                </td>
                                <td class="px-4 lg:px-6 py-4 whitespace-nowrap text-center hidden lg:table-cell">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $tagihan->periode_formatted }}
                                    </span>
                                </td>
                                <td class="px-4 lg:px-6 py-4 whitespace-nowrap text-center hidden lg:table-cell">
                                    <span class="text-sm text-gray-900 font-medium">{{ number_format($tagihan->pemakaian ?? 0, 0, ',', '.') }} m³</span>
                                </td>
                                <td class="px-4 lg:px-6 py-4 whitespace-nowrap text-right text-sm text-gray-900 hidden md:table-cell">
                                    Rp {{ number_format($tagihan->harga_air ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="px-4 lg:px-6 py-4 whitespace-nowrap text-right text-sm text-gray-900 hidden lg:table-cell">
                                    Rp {{ number_format($tagihan->biaya_admin ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="px-4 lg:px-6 py-4 whitespace-nowrap text-right text-sm hidden lg:table-cell">
                                    @if(($tagihan->denda_keterlambatan ?? 0) > 0)
                                        <span class="font-medium text-red-600">
                                            Rp {{ number_format($tagihan->denda_keterlambatan, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="text-green-600 font-medium">Rp 0</span>
                                    @endif
                                </td>
                                <td class="px-4 lg:px-6 py-4 whitespace-nowrap text-right">
                                    <div class="text-lg font-bold {{ ($tagihan->status_bayar ?? 'BELUM') == 'LUNAS' ? 'text-green-600' : 'text-red-600' }}">
                                        Rp {{ number_format($tagihan->total_dengan_denda ?? ($tagihan->total_tagihan ?? 0), 0, ',', '.') }}
                                    </div>
                                    <div class="text-xs {{ ($tagihan->status_bayar ?? 'BELUM') == 'LUNAS' ? 'text-green-500' : 'text-red-500' }}">
                                        {{ $tagihan->status_pembayaran ?? (($tagihan->status_bayar ?? 'BELUM') == 'LUNAS' ? 'LUNAS' : 'BELUM LUNAS') }}
                                    </div>
                                    @if(($tagihan->status_bayar ?? 'BELUM') != 'LUNAS')
                                    <div class="text-xs text-gray-500 mt-1">
                                        Jatuh Tempo: {{ $tagihan->jatuh_tempo ?? 'N/A' }}
                                    </div>
                                    @endif
                                </td>
                                <td class="px-4 lg:px-6 py-4 whitespace-nowrap text-center no-print">
                                    <div class="flex justify-center space-x-1">
                                        <button onclick="showDetails({{ $index }})" 
                                            class="bg-secondary hover:bg-secondary/80 text-white px-2 py-1 rounded text-xs transition shadow-sm"
                                            title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        @if(($tagihan->status_bayar ?? 'BELUM') != 'LUNAS')
                                        <button onclick="bayarTagihan('{{ $tagihan->id_tagihan ?? '' }}')" 
                                            class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded text-xs transition shadow-sm"
                                            title="Bayar Tagihan">
                                            <i class="fas fa-money-bill-wave"></i>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr id="emptyRow">
                                <td colspan="9" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-500">
                                        <i class="fas fa-inbox text-6xl mb-4 text-gray-300"></i>
                                        <h3 class="text-xl font-medium mb-2 text-gray-900">Tidak ada data tagihan</h3>
                                        <p class="text-sm text-gray-600 mb-4" id="emptyMessage">
                                            @if(request('periode'))
                                                Data tagihan untuk periode yang dipilih tidak ditemukan
                                            @else
                                                Belum ada tagihan yang dibuat untuk pelanggan ini
                                            @endif
                                        </p>
                                        @if(request('periode'))
                                        <button onclick="clearFilter()" class="bg-primary text-white px-4 py-2 rounded-lg text-sm hover:bg-primary/90 transition shadow-lg">
                                            <i class="fas fa-refresh mr-2"></i>Reset Filter
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Info Footer -->
                <div id="tableFooter" class="{{ isset($tagihans) && $tagihans->count() > 0 ? '' : 'hidden' }}">
                    <div class="bg-light px-6 py-4 border-t border-accent">
                        <div class="flex flex-col md:flex-row md:justify-between md:items-center space-y-2 md:space-y-0 text-sm text-gray-600">
                            <div class="flex items-center space-x-4">
                                <span>Menampilkan <strong id="footerRecords">{{ isset($summary) ? $summary['total_records'] : '0' }}</strong> data tagihan</span>
                                <span class="text-secondary">•</span>
                                <span>Total Pemakaian: <strong id="footerPemakaian">{{ isset($summary) ? number_format($summary['total_pemakaian'], 0, ',', '.') : '0' }} m³</strong></span>
                            </div>
                            <div class="flex items-center space-x-4">
                                <span>Total Tagihan: <strong class="text-primary" id="footerTagihan">Rp {{ isset($summary) ? number_format($summary['total_tagihan'], 0, ',', '.') : '0' }}</strong></span>
                                <span class="text-red-600" id="dendaIndicator" style="{{ isset($summary) && $summary['total_denda'] > 0 ? '' : 'display: none;' }}">•</span>
                                <span class="text-red-600" id="footerDenda" style="{{ isset($summary) && $summary['total_denda'] > 0 ? '' : 'display: none;' }}">Denda: <strong>Rp {{ isset($summary) ? number_format($summary['total_denda'], 0, ',', '.') : '0' }}</strong></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Detail Modal for Mobile -->
    <div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden no-print">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-xl max-w-md w-full p-6 max-h-screen overflow-y-auto">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-primary">Detail Tagihan</h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div id="modalContent">
                    <!-- Content will be loaded here -->
                </div>
                <div class="mt-6 flex justify-end">
                    <button onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-600 transition">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Helper function untuk format rupiah
        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(angka);
        }

        // Helper function untuk format number
        function formatNumber(angka) {
            return new Intl.NumberFormat('id-ID').format(angka);
        }

        // Current tagihan data for modal
        let currentTagihans = @json($tagihans ?? []);
        let currentDetailIndex = null;

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

        // Filter by periode
        function filterByPeriode() {
            const periode = document.getElementById('periode').value;
            if (periode) {
                showLoading();
                document.getElementById('filterForm').submit();
            }
        }

        // Show loading state
        function showLoading() {
            document.querySelector('#searchBtn .loading').classList.add('show');
            document.getElementById('statsSection').classList.add('hidden');
            document.getElementById('loadingSkeleton').classList.remove('hidden');
            document.getElementById('tableFooter').classList.add('hidden');
            
            // Show skeleton in table
            const tableBody = document.getElementById('tableBody');
            tableBody.innerHTML = `
                <tr>
                    <td colspan="9" class="px-6 py-4">
                        <div class="space-y-3">
                            ${Array(3).fill(0).map(() => `
                                <div class="flex items-center space-x-4">
                                    <div class="w-16 h-4 bg-gray-200 rounded skeleton"></div>
                                    <div class="w-32 h-4 bg-gray-200 rounded skeleton"></div>
                                    <div class="w-20 h-4 bg-gray-200 rounded skeleton"></div>
                                    <div class="w-24 h-4 bg-gray-200 rounded skeleton"></div>
                                    <div class="w-28 h-4 bg-gray-200 rounded skeleton"></div>
                                </div>
                            `).join('')}
                        </div>
                    </td>
                </tr>
            `;
        }

        // Hide loading state
        function hideLoading() {
            document.querySelector('#searchBtn .loading').classList.remove('show');
            document.getElementById('loadingSkeleton').classList.add('hidden');
        }

        // Quick filter functions
        function setCurrentPeriode(periode) {
            document.getElementById('periode').value = periode;
            filterByPeriode();
        }

        function clearFilter() {
            document.getElementById('periode').value = '';
            showLoading();
            document.getElementById('filterForm').submit();
        }

        // Update UI berdasarkan data
        function updateUI(data) {
            hideLoading();
            
            if (data && data.length > 0) {
                // Show stats
                document.getElementById('statsSection').classList.remove('hidden');
                document.getElementById('tableFooter').classList.remove('hidden');
                
                // Update stats dengan format yang benar
                const totalPemakaian = data.reduce((sum, item) => sum + (parseFloat(item.pemakaian) || 0), 0);
                const totalTagihan = data.reduce((sum, item) => sum + (parseFloat(item.total_tagihan) || 0), 0);
                const totalDenda = data.reduce((sum, item) => sum + (parseFloat(item.denda_keterlambatan) || 0), 0);
                
                document.getElementById('statPemakaian').textContent = `${formatNumber(totalPemakaian)} m³`;
                document.getElementById('statTagihan').textContent = formatRupiah(totalTagihan);
                document.getElementById('statDenda').textContent = formatRupiah(totalDenda);
                document.getElementById('statRecords').textContent = `${data.length} Record`;
                
                // Update footer
                document.getElementById('footerRecords').textContent = data.length;
                document.getElementById('footerPemakaian').textContent = `${formatNumber(totalPemakaian)} m³`;
                document.getElementById('footerTagihan').textContent = formatRupiah(totalTagihan);
                document.getElementById('footerDenda').textContent = `Denda: ${formatRupiah(totalDenda)}`;
                
                // Show/hide denda indicator
                if (totalDenda > 0) {
                    document.getElementById('dendaIndicator').style.display = 'inline';
                    document.getElementById('footerDenda').style.display = 'inline';
                } else {
                    document.getElementById('dendaIndicator').style.display = 'none';
                    document.getElementById('footerDenda').style.display = 'none';
                }
                
                // Update record count
                document.getElementById('recordCount').textContent = `${data.length} data`;
                
                // Show print button
                const printButton = `
                    <button onclick="window.print()" class="bg-white/20 text-white px-3 py-1 rounded text-sm hover:bg-white/30 transition no-print">
                        <i class="fas fa-print mr-1"></i> Print
                    </button>
                `;
                document.getElementById('tableActions').innerHTML = printButton;
                
            } else {
                // Hide stats and footer
                document.getElementById('statsSection').classList.add('hidden');
                document.getElementById('tableFooter').classList.add('hidden');
                document.getElementById('recordCount').textContent = '0 data';
                document.getElementById('tableActions').innerHTML = '';
            }
        }

        // Modal functions
        function showDetails(index) {
            if (!currentTagihans[index]) return;
            
            currentDetailIndex = index;
            const tagihan = currentTagihans[index];
            
            const content = `
                <div class="space-y-4">
                    <div class="bg-light p-4 rounded-lg">
                        <div class="grid grid-cols-2 gap-2 text-sm">
                            <div class="font-medium text-gray-600">ID Tagihan:</div>
                            <div class="font-semibold">${tagihan.id_tagihan || 'N/A'}</div>
                            <div class="font-medium text-gray-600">ID Pelanggan:</div>
                            <div class="font-semibold">${tagihan.id_pel || 'N/A'}</div>
                            <div class="font-medium text-gray-600">Nama:</div>
                            <div class="font-semibold">${tagihan.nama_pelanggan || 'N/A'}</div>
                            <div class="font-medium text-gray-600">Periode:</div>
                            <div class="font-semibold">${tagihan.periode_formatted || 'N/A'}</div>
                            <div class="font-medium text-gray-600">Status:</div>
                            <div class="font-semibold ${(tagihan.status_bayar || 'BELUM') == 'LUNAS' ? 'text-green-600' : 'text-red-600'}">${tagihan.status_pembayaran || ((tagihan.status_bayar || 'BELUM') == 'LUNAS' ? 'LUNAS' : 'BELUM LUNAS')}</div>
                        </div>
                    </div>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between items-center border-b pb-2">
                            <span class="text-sm font-medium text-gray-600">Meter Awal:</span>
                            <span class="font-semibold">${formatNumber(tagihan.meter_awal || 0)} m³</span>
                        </div>
                        <div class="flex justify-between items-center border-b pb-2">
                            <span class="text-sm font-medium text-gray-600">Meter Akhir:</span>
                            <span class="font-semibold">${formatNumber(tagihan.meter_akhir || 0)} m³</span>
                        </div>
                        <div class="flex justify-between items-center border-b pb-2">
                            <span class="text-sm font-medium text-gray-600">Pemakaian:</span>
                            <span class="font-semibold">${formatNumber(tagihan.pemakaian || 0)} m³</span>
                        </div>
                        <div class="flex justify-between items-center border-b pb-2">
                            <span class="text-sm font-medium text-gray-600">Tarif per m³:</span>
                            <span class="font-semibold">${formatRupiah(tagihan.tarif_per_m3 || 0)}</span>
                        </div>
                        <div class="flex justify-between items-center border-b pb-2">
                            <span class="text-sm font-medium text-gray-600">Harga Air:</span>
                            <span class="font-semibold">${formatRupiah(tagihan.harga_air || 0)}</span>
                        </div>
                        <div class="flex justify-between items-center border-b pb-2">
                            <span class="text-sm font-medium text-gray-600">Biaya Admin:</span>
                            <span class="font-semibold">${formatRupiah(tagihan.biaya_admin || 0)}</span>
                        </div>
                        <div class="flex justify-between items-center border-b pb-2">
                            <span class="text-sm font-medium text-gray-600">Denda Keterlambatan:</span>
                            <span class="font-semibold ${(tagihan.denda_keterlambatan || 0) > 0 ? 'text-red-600' : 'text-green-600'}">
                                ${formatRupiah(tagihan.denda_keterlambatan || 0)}
                            </span>
                        </div>
                        <div class="flex justify-between items-center border-b pb-2">
                            <span class="text-sm font-medium text-gray-600">Tanggal Tagihan:</span>
                            <span class="font-semibold">${tagihan.tgl_tagihan_formatted || 'N/A'}</span>
                        </div>
                        <div class="flex justify-between items-center border-b pb-2">
                            <span class="text-sm font-medium text-gray-600">Jatuh Tempo:</span>
                            <span class="font-semibold">${tagihan.jatuh_tempo || 'N/A'}</span>
                        </div>
                        ${tagihan.keterangan ? `
                        <div class="flex justify-between items-center border-b pb-2">
                            <span class="text-sm font-medium text-gray-600">Keterangan:</span>
                            <span class="font-semibold">${tagihan.keterangan}</span>
                        </div>
                        ` : ''}
                    </div>
                    
                    <div class="border-t pt-4">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-gray-900">Total Tagihan:</span>
                            <span class="text-lg font-bold ${(tagihan.status_bayar || 'BELUM') == 'LUNAS' ? 'text-green-600' : 'text-red-600'}">
                                ${formatRupiah(tagihan.total_dengan_denda || tagihan.total_tagihan || 0)}
                            </span>
                        </div>
                    </div>
                </div>
            `;
            
            document.getElementById('modalContent').innerHTML = content;
            document.getElementById('detailModal').classList.remove('hidden');
        }

        // Function untuk bayar tagihan
        function bayarTagihan(idTagihan) {
            if (confirm('Apakah Anda yakin ingin membayar tagihan ini?')) {
                // Redirect ke halaman pembayaran atau proses pembayaran
                window.location.href = `/bayar-tagihan/${idTagihan}`;
            }
        }

        function closeModal() {
            document.getElementById('detailModal').classList.add('hidden');
            currentDetailIndex = null;
        }

        // Close modal when clicking outside
        document.getElementById('detailModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Auto hide alerts
        setTimeout(function() {
            const alerts = document.querySelectorAll('[class*="bg-green-50"], [class*="bg-red-50"]');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);

        // Update UI on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateUI(currentTagihans);
            
            // Fade in animation for table rows
            const rows = document.querySelectorAll('.table-row');
            rows.forEach((row, index) => {
                setTimeout(() => {
                    row.classList.add('fade-in');
                }, index * 100);
            });
        });
    </script>
</body>
</html>