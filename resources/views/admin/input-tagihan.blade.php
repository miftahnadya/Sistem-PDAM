<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Input Tagihan - {{ $pelanggan->nama_pelanggan }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Custom styles for responsive sidebar */
        .sidebar {
            transition: transform 0.3s ease-in-out;
        }
        
        .sidebar.collapsed {
            transform: translateX(-100%);
        }
        
        .main-content {
            transition: margin-left 0.3s ease-in-out;
        }
        
        .main-content.sidebar-collapsed {
            margin-left: 0;
        }
        
        .sidebar-toggle {
            z-index: 1000;
        }
        
        .overlay {
            transition: opacity 0.3s ease-in-out;
        }
        
        @media (max-width: 1024px) {
            .sidebar {
                position: fixed;
                transform: translateX(-100%);
                z-index: 999;
            }
            
            .sidebar.open {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0 !important;
            }
            
            .overlay.show {
                opacity: 1;
                pointer-events: auto;
            }
        }
        
        /* Animation for form elements */
        .form-element {
            transition: all 0.3s ease;
        }
        
        .form-element:focus {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        /* Loading spinner */
        .loading {
            display: none;
        }
        
        .loading.show {
            display: inline-block;
        }
        
        /* Pulse animation for calculation area */
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        
        .pulse {
            animation: pulse 1s infinite;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex min-h-screen">
        <!-- Overlay for mobile -->
        <div id="overlay" class="overlay fixed inset-0 bg-black bg-opacity-50 z-50 opacity-0 pointer-events-none lg:hidden"></div>
        
        <!-- Sidebar -->
        <div id="sidebar" class="sidebar w-64 fixed h-full bg-white shadow-lg z-50">
            @include('component.sidebar')
        </div>
        
        <!-- Main Content -->
        <main id="mainContent" class="main-content flex-1 ml-64 transition-all duration-300">
            <!-- Header -->
            <div class="bg-white shadow-sm border-b p-4 lg:p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <!-- Mobile sidebar toggle -->
                        <button id="sidebarToggle" class="lg:hidden mr-4 p-2 rounded-lg text-gray-600 hover:bg-gray-100">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        
                        <!-- Back Button -->
                        <a href="{{ route('admin.isitagihan') }}" 
                           class="mr-4 p-2 rounded-lg text-gray-600 hover:bg-gray-100 transition-colors">
                            <i class="fas fa-arrow-left text-xl"></i>
                        </a>
                        
                        <div>
                            <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">
                                <i class="fas fa-file-invoice-dollar mr-2 lg:mr-3 text-blue-600"></i>
                                Input Tagihan
                            </h1>
                            <p class="text-gray-600 mt-1 text-sm lg:text-base">
                                Input tagihan untuk {{ $pelanggan->nama_pelanggan }}
                            </p>
                        </div>
                    </div>
                    
                    <!-- Quick Actions -->
                    <div class="flex items-center space-x-2">
                        <button type="button" onclick="resetForm()" 
                                class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-2 rounded-lg text-sm transition-colors">
                            <i class="fas fa-redo mr-1"></i>
                            Reset
                        </button>
                        <button type="button" onclick="document.getElementById('tagihanForm').submit()" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg text-sm transition-colors">
                            <i class="fas fa-save mr-1"></i>
                            Simpan
                        </button>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="p-4 lg:p-6">
                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm animate-fade-in">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-3 text-lg"></i>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-sm animate-fade-in">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-3 text-lg"></i>
                            <span class="font-medium">{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-sm animate-fade-in">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-3 text-lg"></i>
                            <div>
                                <p class="font-medium mb-2">Terjadi kesalahan:</p>
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li class="text-sm">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Form Input Tagihan -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-lg shadow-lg p-6">
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-xl font-bold text-gray-900">
                                    <i class="fas fa-edit mr-2 text-blue-600"></i>
                                    Form Input Tagihan
                                </h2>
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm text-gray-500">Status:</span>
                                    <span id="formStatus" class="text-sm font-medium text-blue-600">Siap Input</span>
                                </div>
                            </div>
                            
                            <form action="{{ route('admin.store-tagihan', $pelanggan->id_pel) }}" method="POST" id="tagihanForm">
                                @csrf
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Bulan -->
                                    <div class="form-group">
                                        <label for="bulan" class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-calendar-alt mr-1 text-blue-600"></i>
                                            Bulan Tagihan
                                        </label>
                                        <select name="bulan" id="bulan" class="form-element w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                            <option value="">Pilih Bulan</option>
                                            <option value="01" {{ old('bulan') == '01' ? 'selected' : '' }}>Januari</option>
                                            <option value="02" {{ old('bulan') == '02' ? 'selected' : '' }}>Februari</option>
                                            <option value="03" {{ old('bulan') == '03' ? 'selected' : '' }}>Maret</option>
                                            <option value="04" {{ old('bulan') == '04' ? 'selected' : '' }}>April</option>
                                            <option value="05" {{ old('bulan') == '05' ? 'selected' : '' }}>Mei</option>
                                            <option value="06" {{ old('bulan') == '06' ? 'selected' : '' }}>Juni</option>
                                            <option value="07" {{ old('bulan') == '07' ? 'selected' : '' }}>Juli</option>
                                            <option value="08" {{ old('bulan') == '08' ? 'selected' : '' }}>Agustus</option>
                                            <option value="09" {{ old('bulan') == '09' ? 'selected' : '' }}>September</option>
                                            <option value="10" {{ old('bulan') == '10' ? 'selected' : '' }}>Oktober</option>
                                            <option value="11" {{ old('bulan') == '11' ? 'selected' : '' }}>November</option>
                                            <option value="12" {{ old('bulan') == '12' ? 'selected' : '' }}>Desember</option>
                                        </select>
                                        @error('bulan')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <!-- Tahun -->
                                    <div class="form-group">
                                        <label for="tahun" class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-calendar mr-1 text-blue-600"></i>
                                            Tahun Tagihan
                                        </label>
                                        <select name="tahun" id="tahun" class="form-element w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                            <option value="">Pilih Tahun</option>
                                            @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                                                <option value="{{ $i }}" {{ old('tahun') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                            @endfor
                                        </select>
                                        @error('tahun')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <!-- Meter Awal -->
                                    <div class="form-group">
                                        <label for="meter_awal" class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-tachometer-alt mr-1 text-green-600"></i>
                                            Meter Awal (m³)
                                        </label>
                                        <input type="number" 
                                               name="meter_awal" 
                                               id="meter_awal" 
                                               class="form-element w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                               placeholder="Masukkan meter awal"
                                               value="{{ old('meter_awal', $tagihanTerakhir ? $tagihanTerakhir->meter_akhir : '') }}"
                                               min="0"
                                               step="1"
                                               required>
                                        @error('meter_awal')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                        @if($tagihanTerakhir)
                                            <p class="text-xs text-gray-500 mt-1">
                                                <i class="fas fa-info-circle mr-1"></i>
                                                Meter akhir periode sebelumnya: {{ $tagihanTerakhir->meter_akhir }}
                                            </p>
                                        @endif
                                    </div>
                                    
                                    <!-- Meter Akhir -->
                                    <div class="form-group">
                                        <label for="meter_akhir" class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-tachometer-alt mr-1 text-red-600"></i>
                                            Meter Akhir (m³)
                                        </label>
                                        <input type="number" 
                                               name="meter_akhir" 
                                               id="meter_akhir" 
                                               class="form-element w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                               placeholder="Masukkan meter akhir"
                                               value="{{ old('meter_akhir') }}"
                                               min="0"
                                               step="1"
                                               required>
                                        @error('meter_akhir')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                        <p class="text-xs text-gray-500 mt-1">
                                            <i class="fas fa-info-circle mr-1"></i>
                                            Meter akhir harus lebih besar dari meter awal
                                        </p>
                                    </div>
                                </div>
                                
                                <!-- Hasil Perhitungan -->
                                <div class="mt-6 p-4 bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg border border-gray-200">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                        <i class="fas fa-calculator mr-2 text-green-600"></i>
                                        Perhitungan Tagihan
                                        <span class="loading ml-2">
                                            <i class="fas fa-spinner fa-spin"></i>
                                        </span>
                                    </h3>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="flex justify-between items-center bg-white p-3 rounded-lg shadow-sm">
                                            <span class="text-gray-600 font-medium">
                                                <i class="fas fa-tint mr-1 text-blue-500"></i>
                                                Pemakaian:
                                            </span>
                                            <span id="pemakaian" class="font-bold text-blue-600">0 m³</span>
                                        </div>
                                        
                                        <div class="flex justify-between items-center bg-white p-3 rounded-lg shadow-sm">
                                            <span class="text-gray-600 font-medium">
                                                <i class="fas fa-tag mr-1 text-purple-500"></i>
                                                Tarif per m³:
                                            </span>
                                            <span class="font-bold text-purple-600">Rp {{ number_format($tarif->tarif_per_m3 ?? 0, 0, ',', '.') }}</span>
                                        </div>
                                        
                                        <div class="flex justify-between items-center bg-white p-3 rounded-lg shadow-sm">
                                            <span class="text-gray-600 font-medium">
                                                <i class="fas fa-water mr-1 text-green-500"></i>
                                                Biaya Pemakaian:
                                            </span>
                                            <span id="biaya_pemakaian" class="font-bold text-green-600">Rp 0</span>
                                        </div>
                                        
                                        <div class="flex justify-between items-center bg-white p-3 rounded-lg shadow-sm">
                                            <span class="text-gray-600 font-medium">
                                                <i class="fas fa-cogs mr-1 text-orange-500"></i>
                                                Biaya Admin:
                                            </span>
                                            <span class="font-bold text-orange-600">Rp {{ number_format($tarif->biaya_admin ?? 0, 0, ',', '.') }}</span>
                                        </div>
                                        
                                        <div class="flex justify-between items-center bg-gradient-to-r from-blue-500 to-blue-600 text-white p-4 rounded-lg shadow-lg md:col-span-2">
                                            <span class="font-bold text-lg">
                                                <i class="fas fa-money-bill-wave mr-2"></i>
                                                Total Tagihan:
                                            </span>
                                            <span id="total_tagihan" class="font-bold text-2xl">Rp 0</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Additional Notes -->
                                <div class="mt-6">
                                    <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-sticky-note mr-1 text-yellow-600"></i>
                                        Catatan (Opsional)
                                    </label>
                                    <textarea name="catatan" 
                                              id="catatan" 
                                              rows="3" 
                                              class="form-element w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                              placeholder="Tambahkan catatan khusus untuk tagihan ini...">{{ old('catatan') }}</textarea>
                                </div>
                                
                                <!-- Submit Button -->
                                <div class="flex gap-4 mt-6">
                                    <button type="submit" 
                                            id="submitBtn"
                                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-3 px-6 rounded-lg font-semibold transition-colors shadow-lg hover:shadow-xl">
                                        <i class="fas fa-save mr-2"></i>
                                        <span id="submitText">Simpan Tagihan</span>
                                        <span id="submitLoading" class="loading ml-2">
                                            <i class="fas fa-spinner fa-spin"></i>
                                        </span>
                                    </button>
                                    <a href="{{ route('admin.isi-tagihan') }}" 
                                       class="flex-1 bg-gray-500 hover:bg-gray-600 text-white py-3 px-6 rounded-lg font-semibold transition-colors text-center shadow-lg hover:shadow-xl">
                                        <i class="fas fa-times mr-2"></i>
                                        Batal
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Info Pelanggan -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg shadow-lg p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">
                                <i class="fas fa-user mr-2 text-blue-600"></i>
                                Info Pelanggan
                            </h3>
                            
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-bold text-lg mr-3">
                                        {{ strtoupper(substr($pelanggan->nama_pelanggan, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $pelanggan->nama_pelanggan }}</div>
                                        <div class="text-sm text-gray-500">ID: {{ $pelanggan->id_pel }}</div>
                                    </div>
                                </div>
                                
                                <div class="space-y-2 pt-3 border-t">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">
                                            <i class="fas fa-hashtag mr-1"></i>
                                            ID Meter:
                                        </span>
                                        <span class="font-medium">{{ $pelanggan->id_meter ?? 'N/A' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">
                                            <i class="fas fa-map-marker-alt mr-1"></i>
                                            Alamat:
                                        </span>
                                        <span class="font-medium text-right">{{ $pelanggan->alamat ?? 'N/A' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Status:
                                        </span>
                                        <span class="font-medium">
                                            @if($pelanggan->status_pelanggan == 'AKTIF')
                                                <span class="text-green-600 font-bold">{{ $pelanggan->status_pelanggan }}</span>
                                            @else
                                                <span class="text-red-600">{{ $pelanggan->status_pelanggan ?? 'N/A' }}</span>
                                            @endif
                                        </span>
                                    </div>
                                    @if($pelanggan->desa)
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">
                                                <i class="fas fa-home mr-1"></i>
                                                Desa:
                                            </span>
                                            <span class="font-medium">{{ $pelanggan->desa }}</span>
                                        </div>
                                    @endif
                                    @if($pelanggan->kecamatan)
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">
                                                <i class="fas fa-map mr-1"></i>
                                                Kecamatan:
                                            </span>
                                            <span class="font-medium">{{ $pelanggan->kecamatan }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        @if($tagihanTerakhir)
                        <div class="bg-white rounded-lg shadow-lg p-6 mt-4">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">
                                <i class="fas fa-history mr-2 text-green-600"></i>
                                Tagihan Terakhir
                            </h3>
                            
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">
                                        <i class="fas fa-calendar mr-1"></i>
                                        Periode:
                                    </span>
                                    <span class="font-medium">{{ $tagihanTerakhir->bulan }}/{{ $tagihanTerakhir->tahun }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">
                                        <i class="fas fa-tachometer-alt mr-1"></i>
                                        Meter Awal:
                                    </span>
                                    <span class="font-medium">{{ $tagihanTerakhir->meter_awal }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">
                                        <i class="fas fa-tachometer-alt mr-1"></i>
                                        Meter Akhir:
                                    </span>
                                    <span class="font-medium">{{ $tagihanTerakhir->meter_akhir }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">
                                        <i class="fas fa-tint mr-1"></i>
                                        Pemakaian:
                                    </span>
                                    <span class="font-medium">{{ $tagihanTerakhir->pemakaian }} m³</span>
                                </div>
                                <div class="flex justify-between border-t pt-2">
                                    <span class="text-gray-600">
                                        <i class="fas fa-money-bill-wave mr-1"></i>
                                        Total:
                                    </span>
                                    <span class="font-bold text-blue-600">Rp {{ number_format($tagihanTerakhir->total_tagihan, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Status:
                                    </span>
                                    <span class="font-medium">
                                        @if($tagihanTerakhir->status == 'lunas')
                                            <span class="text-green-600">Lunas</span>
                                        @else
                                            <span class="text-red-600">Belum Bayar</span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        <!-- Tarif Information -->
                        <div class="bg-white rounded-lg shadow-lg p-6 mt-4">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">
                                <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                                Info Tarif
                            </h3>
                            
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">
                                        <i class="fas fa-tag mr-1"></i>
                                        Tarif per m³:
                                    </span>
                                    <span class="font-bold text-blue-600">Rp {{ number_format($tarif->tarif_per_m3 ?? 0, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">
                                        <i class="fas fa-cogs mr-1"></i>
                                        Biaya Admin:
                                    </span>
                                    <span class="font-bold text-orange-600">Rp {{ number_format($tarif->biaya_admin ?? 0, 0, ',', '.') }}</span>
                                </div>
                                @if($tarif->denda_per_hari ?? false)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        Denda/Hari:
                                    </span>
                                    <span class="font-bold text-red-600">Rp {{ number_format($tarif->denda_per_hari, 0, ',', '.') }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script>
        // Variables
        const meterAwal = document.getElementById('meter_awal');
        const meterAkhir = document.getElementById('meter_akhir');
        const tarifPerM3 = {{ $tarif->tarif_per_m3 ?? 0 }};
        const biayaAdmin = {{ $tarif->biaya_admin ?? 0 }};
        const submitBtn = document.getElementById('submitBtn');
        const submitText = document.getElementById('submitText');
        const submitLoading = document.getElementById('submitLoading');
        const formStatus = document.getElementById('formStatus');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const sidebarToggle = document.getElementById('sidebarToggle');
        
        // Sidebar functionality
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('open');
                overlay.classList.toggle('show');
            });
        }
        
        if (overlay) {
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('open');
                overlay.classList.remove('show');
            });
        }
        
        // Calculation function
        function hitungTagihan() {
            const awal = parseInt(meterAwal.value) || 0;
            const akhir = parseInt(meterAkhir.value) || 0;
            
            if (akhir > awal) {
                const pemakaian = akhir - awal;
                const biayaPemakaian = pemakaian * tarifPerM3;
                const total = biayaPemakaian + biayaAdmin;
                
                document.getElementById('pemakaian').textContent = pemakaian + ' m³';
                document.getElementById('biaya_pemakaian').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(biayaPemakaian);
                document.getElementById('total_tagihan').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
                
                // Update form status
                formStatus.textContent = 'Siap Disimpan';
                formStatus.className = 'text-sm font-medium text-green-600';
                
                // Enable submit button
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                
            } else if (akhir < awal && akhir > 0) {
                // Invalid meter reading
                document.getElementById('pemakaian').textContent = 'Error';
                document.getElementById('biaya_pemakaian').textContent = 'Rp 0';
                document.getElementById('total_tagihan').textContent = 'Rp 0';
                
                formStatus.textContent = 'Meter Akhir Harus > Meter Awal';
                formStatus.className = 'text-sm font-medium text-red-600';
                
                // Disable submit button
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                
            } else {
                // Reset to default
                document.getElementById('pemakaian').textContent = '0 m³';
                document.getElementById('biaya_pemakaian').textContent = 'Rp 0';
                document.getElementById('total_tagihan').textContent = 'Rp 0';
                
                formStatus.textContent = 'Lengkapi Data';
                formStatus.className = 'text-sm font-medium text-gray-600';
                
                // Disable submit button
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }
        
        // Event listeners
        meterAwal.addEventListener('input', hitungTagihan);
        meterAkhir.addEventListener('input', hitungTagihan);
        
        // Form submission
        document.getElementById('tagihanForm').addEventListener('submit', function(e) {
            const awal = parseInt(meterAwal.value) || 0;
            const akhir = parseInt(meterAkhir.value) || 0;
            
            if (akhir <= awal) {
                e.preventDefault();
                alert('Meter akhir harus lebih besar dari meter awal!');
                return false;
            }
            
            // Show loading
            submitBtn.disabled = true;
            submitText.textContent = 'Menyimpan...';
            submitLoading.classList.add('show');
            
            // Update form status
            formStatus.textContent = 'Menyimpan Data...';
            formStatus.className = 'text-sm font-medium text-blue-600';
        });
        
        // Reset form function
        function resetForm() {
            if (confirm('Apakah Anda yakin ingin mereset form?')) {
                document.getElementById('tagihanForm').reset();
                
                // Reset calculations
                document.getElementById('pemakaian').textContent = '0 m³';
                document.getElementById('biaya_pemakaian').textContent = 'Rp 0';
                document.getElementById('total_tagihan').textContent = 'Rp 0';
                
                // Reset form status
                formStatus.textContent = 'Siap Input';
                formStatus.className = 'text-sm font-medium text-blue-600';
                
                // Set default values
                setDefaultValues();
            }
        }
        
        // Set default values
        function setDefaultValues() {
            const currentMonth = '{{ str_pad(date('m'), 2, "0", STR_PAD_LEFT) }}';
            const currentYear = '{{ date('Y') }}';
            
            document.getElementById('bulan').value = currentMonth;
            document.getElementById('tahun').value = currentYear;
            
            // Set meter awal if available
            @if($tagihanTerakhir)
                document.getElementById('meter_awal').value = '{{ $tagihanTerakhir->meter_akhir }}';
            @endif
        }
        
        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            setDefaultValues();
            hitungTagihan();
            
            // Auto-save draft (optional)
            const inputs = document.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                input.addEventListener('change', function() {
                    // You can implement auto-save functionality here
                    console.log('Field changed:', this.name, this.value);
                });
            });
        });
        
        // Prevent form submission on Enter key in input fields
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && e.target.tagName === 'INPUT') {
                e.preventDefault();
                return false;
            }
        });
        
        // Real-time validation
        document.getElementById('meter_akhir').addEventListener('blur', function() {
            const awal = parseInt(meterAwal.value) || 0;
            const akhir = parseInt(this.value) || 0;
            
            if (akhir > 0 && akhir <= awal) {
                this.classList.add('border-red-500');
                this.classList.remove('border-gray-300');
            } else {
                this.classList.remove('border-red-500');
                this.classList.add('border-gray-300');
            }
        });
        
        // Format number inputs
        function formatNumber(input) {
            let value = input.value.replace(/[^\d]/g, '');
            input.value = value;
        }
        
        // Apply number formatting
        document.getElementById('meter_awal').addEventListener('input', function() {
            formatNumber(this);
        });
        
        document.getElementById('meter_akhir').addEventListener('input', function() {
            formatNumber(this);
        });
        
        // Confirmation before leaving page with unsaved changes
        let formChanged = false;
        
        document.querySelectorAll('input, select, textarea').forEach(function(element) {
            element.addEventListener('change', function() {
                formChanged = true;
            });
        });
        
        window.addEventListener('beforeunload', function(e) {
            if (formChanged) {
                const confirmationMessage = 'Anda memiliki perubahan yang belum disimpan. Apakah Anda yakin ingin meninggalkan halaman ini?';
                e.returnValue = confirmationMessage;
                return confirmationMessage;
            }
        });
        
        // Reset form changed flag on successful submission
        document.getElementById('tagihanForm').addEventListener('submit', function() {
            formChanged = false;
        });
    </script>
</body>
</html>