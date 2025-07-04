<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Tagihan - Admin PDAM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            <!-- Header with Sidebar Toggle -->
            <div class="bg-white shadow-sm border-b p-4 lg:p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <!-- Sidebar Toggle Button -->
                        <button id="sidebarToggle" class="sidebar-toggle lg:hidden mr-4 p-2 rounded-lg text-gray-600 hover:bg-gray-100">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        
                        <!-- Desktop Sidebar Toggle -->
                        <button id="desktopSidebarToggle" class="sidebar-toggle hidden lg:flex mr-4 p-2 rounded-lg text-gray-600 hover:bg-gray-100">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        
                        <div>
                            <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">
                                <i class="fas fa-file-invoice-dollar mr-2 lg:mr-3 text-blue-600"></i>
                                Kelola Tagihan
                            </h1>
                            <p class="text-gray-600 mt-1 text-sm lg:text-base">Kelola dan input tagihan pelanggan PDAM</p>
                        </div>
                    </div>
                    
                    <button onclick="showSearchPelangganModal()" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 lg:px-6 py-2 lg:py-3 rounded-lg flex items-center gap-2 transition-colors shadow-lg text-sm lg:text-base">
                        <i class="fas fa-search"></i>
                        <span class="hidden sm:inline">Cari Pelanggan</span>
                        <span class="sm:hidden">Cari</span>
                    </button>
                </div>
            </div>

            <!-- Content Area -->
            <div class="p-4 lg:p-6">
                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-3"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-3"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                <!-- Search Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <!-- Search Form -->
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">
                            <i class="fas fa-search mr-2 text-blue-600"></i>
                            Cari Pelanggan
                        </h2>
                        
                        <form id="searchForm" class="space-y-4">
                            <div>
                                <label for="search_id_pel" class="block text-sm font-medium text-gray-700 mb-2">ID Pelanggan</label>
                                <div class="relative">
                                    <input type="text" 
                                           id="search_id_pel" 
                                           name="search_id_pel" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="Masukkan ID Pelanggan"
                                           required>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <i class="fas fa-search text-gray-400"></i>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="submit" 
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg flex items-center justify-center gap-2 transition-colors">
                                <i class="fas fa-search"></i>
                                Cari Pelanggan
                            </button>
                        </form>
                    </div>
                    
                    <!-- Instructions -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">
                            <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                            Petunjuk Penggunaan
                        </h3>
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li class="flex items-start">
                                <i class="fas fa-check text-green-500 mr-2 mt-0.5"></i>
                                Masukkan ID Pelanggan yang akan ditagih
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check text-green-500 mr-2 mt-0.5"></i>
                                Sistem akan menampilkan data pelanggan
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check text-green-500 mr-2 mt-0.5"></i>
                                Isi form tagihan sesuai dengan pemakaian
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check text-green-500 mr-2 mt-0.5"></i>
                                Simpan tagihan untuk pelanggan
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Customer Info Section (Hidden by default) -->
                <div id="customerInfoSection" class="hidden bg-white rounded-lg shadow-lg p-6 mb-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">
                        <i class="fas fa-user mr-2 text-green-600"></i>
                        Data Pelanggan
                    </h2>
                    <div id="customerInfoContent">
                        <!-- Customer info will be loaded here -->
                    </div>
                </div>

                <!-- Tagihan Form Section (Hidden by default) -->
                <div id="tagihanFormSection" class="hidden bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">
                        <i class="fas fa-file-invoice mr-2 text-blue-600"></i>
                        Form Input Tagihan
                    </h2>
                    
                    <form id="tagihanForm" action="/admin/tagihan/store" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" id="form_id_pel" name="id_pel" value="">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="bulan" class="block text-sm font-medium text-gray-700 mb-2">Bulan</label>
                                <select id="bulan" name="bulan" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                    <option value="">Pilih Bulan</option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="tahun" class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
                                <select id="tahun" name="tahun" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                    <option value="">Pilih Tahun</option>
                                    @for($year = date('Y'); $year >= date('Y') - 5; $year--)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="meter_awal" class="block text-sm font-medium text-gray-700 mb-2">Meter Awal (m³)</label>
                                <input type="number" id="meter_awal" name="meter_awal" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="Masukkan meter awal" required>
                            </div>
                            
                            <div>
                                <label for="meter_akhir" class="block text-sm font-medium text-gray-700 mb-2">Meter Akhir (m³)</label>
                                <input type="number" id="meter_akhir" name="meter_akhir" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="Masukkan meter akhir" required>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="pemakaian" class="block text-sm font-medium text-gray-700 mb-2">Pemakaian (m³)</label>
                                <input type="number" id="pemakaian" name="pemakaian" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-50"
                                       placeholder="Otomatis terhitung" readonly>
                            </div>
                            
                            <div>
                                <label for="tarif_per_m3" class="block text-sm font-medium text-gray-700 mb-2">Tarif per m³</label>
                                <input type="number" id="tarif_per_m3" name="tarif_per_m3" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="Masukkan tarif per m³" required>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="biaya_admin" class="block text-sm font-medium text-gray-700 mb-2">Biaya Admin</label>
                                <input type="number" id="biaya_admin" name="biaya_admin" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="Masukkan biaya admin" value="0">
                            </div>
                            
                            <div>
                                <label for="total_tagihan" class="block text-sm font-medium text-gray-700 mb-2">Total Tagihan</label>
                                <input type="number" id="total_tagihan" name="total_tagihan" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-50"
                                       placeholder="Otomatis terhitung" readonly>
                            </div>
                        </div>
                        
                        <div>
                            <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                            <textarea id="keterangan" name="keterangan" rows="3" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                      placeholder="Masukkan keterangan (opsional)"></textarea>
                        </div>
                        
                        <div class="flex gap-4">
                            <button type="submit" 
                                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg flex items-center justify-center gap-2 transition-colors">
                                <i class="fas fa-save"></i>
                                Simpan Tagihan
                            </button>
                            <button type="button" onclick="resetForm()" 
                                    class="flex-1 bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg flex items-center justify-center gap-2 transition-colors">
                                <i class="fas fa-redo"></i>
                                Reset Form
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Recent Tagihan Section -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold text-gray-900">
                            <i class="fas fa-history mr-2 text-purple-600"></i>
                            Tagihan Terbaru
                        </h2>
                        <div class="text-sm text-gray-500">
                            Total: {{ isset($recent_tagihan) ? count($recent_tagihan) : 0 }} tagihan
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Tagihan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Pel</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemakaian</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @if(isset($recent_tagihan) && count($recent_tagihan) > 0)
                                    @foreach($recent_tagihan as $tagihan)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $tagihan->id_tagihan }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $tagihan->id_pel }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $tagihan->nama_pelanggan ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $tagihan->bulan }}/{{ $tagihan->tahun }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $tagihan->pemakaian ?? 0 }} m³
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            Rp {{ number_format($tagihan->total_tagihan ?? 0, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($tagihan->status_bayar === 'LUNAS')
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                                    Lunas
                                                </span>
                                            @else
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
                                                    Belum Lunas
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex items-center space-x-2">
                                                <button onclick="viewTagihan('{{ $tagihan->id_tagihan }}')" 
                                                        class="text-blue-600 hover:text-blue-800 transition-colors">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button onclick="editTagihan('{{ $tagihan->id_tagihan }}')" 
                                                        class="text-yellow-600 hover:text-yellow-800 transition-colors">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                @if($tagihan->status_bayar !== 'LUNAS')
                                                <button onclick="deleteTagihan('{{ $tagihan->id_tagihan }}')" 
                                                        class="text-red-600 hover:text-red-800 transition-colors">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                            <i class="fas fa-file-invoice text-4xl text-gray-300 mb-4"></i>
                                            <p class="text-lg font-medium">Belum ada tagihan yang dibuat</p>
                                            <p class="text-sm">Silakan buat tagihan baru untuk pelanggan</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination atau Load More Button -->
                    @if(isset($recent_tagihan) && count($recent_tagihan) >= 10)
                    <div class="mt-4 text-center">
                        <a href="{{ route('admin.tagihan.all') }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-list mr-2"></i>
                            Lihat Semua Tagihan
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </main>
    </div>

    <script>
        // Sidebar functionality
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const overlay = document.getElementById('overlay');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const desktopSidebarToggle = document.getElementById('desktopSidebarToggle');
        
        let sidebarOpen = true;
        
        // Mobile sidebar toggle
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('open');
            overlay.classList.toggle('show');
        });
        
        // Desktop sidebar toggle
        desktopSidebarToggle.addEventListener('click', function() {
            if (window.innerWidth >= 1024) {
                sidebarOpen = !sidebarOpen;
                
                if (sidebarOpen) {
                    sidebar.classList.remove('collapsed');
                    mainContent.classList.remove('sidebar-collapsed');
                    mainContent.style.marginLeft = '16rem';
                } else {
                    sidebar.classList.add('collapsed');
                    mainContent.classList.add('sidebar-collapsed');
                    mainContent.style.marginLeft = '0';
                }
            }
        });
        
        // Close sidebar when clicking overlay
        overlay.addEventListener('click', function() {
            sidebar.classList.remove('open');
            overlay.classList.remove('show');
        });
        
        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('open');
                overlay.classList.remove('show');
                
                if (sidebarOpen) {
                    sidebar.classList.remove('collapsed');
                    mainContent.classList.remove('sidebar-collapsed');
                    mainContent.style.marginLeft = '16rem';
                } else {
                    sidebar.classList.add('collapsed');
                    mainContent.classList.add('sidebar-collapsed');
                    mainContent.style.marginLeft = '0';
                }
            } else {
                sidebar.classList.remove('collapsed');
                mainContent.classList.remove('sidebar-collapsed');
                mainContent.style.marginLeft = '0';
            }
        });

        // Form functionality
        document.getElementById('searchForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const idPel = document.getElementById('search_id_pel').value.trim();
            if (!idPel) {
                showAlert('warning', 'Silakan masukkan ID Pelanggan');
                return;
            }
            
            searchPelanggan(idPel);
        });

        function searchPelanggan(idPel) {
            // Show loading
            showLoading();
            
            // Make AJAX request to search pelanggan
            fetch(`/admin/pelanggan/search/${idPel}`)
                .then(response => response.json())
                .then(data => {
                    hideLoading();
                    
                    if (data.success) {
                        displayCustomerInfo(data.pelanggan);
                        showTagihanForm(data.pelanggan);
                    } else {
                        showAlert('error', data.message || 'Pelanggan tidak ditemukan');
                        hideCustomerInfo();
                        hideTagihanForm();
                    }
                })
                .catch(error => {
                    hideLoading();
                    console.error('Error:', error);
                    showAlert('error', 'Terjadi kesalahan saat mencari pelanggan');
                });
        }

        // Update displayCustomerInfo function
        function displayCustomerInfo(pelanggan) {
            const customerInfoContent = document.getElementById('customerInfoContent');
            customerInfoContent.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-bold text-lg mr-4">
                                ${pelanggan.nama_pelanggan.charAt(0).toUpperCase()}
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">${pelanggan.nama_pelanggan}</h3>
                                <p class="text-sm text-gray-500">ID Pelanggan: ${pelanggan.id_pel}</p>
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Alamat:</span>
                                <span class="font-medium text-right">${pelanggan.alamat || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">No. Telepon:</span>
                                <span class="font-medium">${pelanggan.no_telepon || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Email:</span>
                                <span class="font-medium">${pelanggan.email || 'N/A'}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-blue-900 mb-2">Status Pelanggan</h4>
                            <span class="px-3 py-1 ${pelanggan.status_pelanggan === 'AKTIF' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'} rounded-full text-sm font-medium">
                                ${pelanggan.status_pelanggan || 'AKTIF'}
                            </span>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-gray-900 mb-2">Informasi Tarif</h4>
                            <div class="text-sm text-gray-600">
                                <p>Kategori: ${pelanggan.kategori || 'Rumah Tangga'}</p>
                                <p>Tarif: Rp ${formatRupiah(pelanggan.tarif_per_m3 || 2500)}/m³</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            document.getElementById('customerInfoSection').classList.remove('hidden');
        }

        function showTagihanForm(pelanggan) {
            document.getElementById('form_id_pel').value = pelanggan.id_pel;
            document.getElementById('tagihanFormSection').classList.remove('hidden');
            
            // Set default values
            document.getElementById('bulan').value = new Date().getMonth() + 1;
            document.getElementById('tahun').value = new Date().getFullYear();
            document.getElementById('tarif_per_m3').value = 5000; // Default tarif
            document.getElementById('biaya_admin').value = 2500; // Default biaya admin
        }

        function hideCustomerInfo() {
            document.getElementById('customerInfoSection').classList.add('hidden');
        }

        function hideTagihanForm() {
            document.getElementById('tagihanFormSection').classList.add('hidden');
        }

        // Calculate pemakaian and total automatically
        document.getElementById('meter_awal').addEventListener('input', calculatePemakaian);
        document.getElementById('meter_akhir').addEventListener('input', calculatePemakaian);
        document.getElementById('tarif_per_m3').addEventListener('input', calculateTotal);
        document.getElementById('biaya_admin').addEventListener('input', calculateTotal);

        function calculatePemakaian() {
            const meterAwal = parseFloat(document.getElementById('meter_awal').value) || 0;
            const meterAkhir = parseFloat(document.getElementById('meter_akhir').value) || 0;
            const pemakaian = meterAkhir - meterAwal;
            
            document.getElementById('pemakaian').value = pemakaian >= 0 ? pemakaian : 0;
            calculateTotal();
        }

        function calculateTotal() {
            const pemakaian = parseFloat(document.getElementById('pemakaian').value) || 0;
            const tarifPerM3 = parseFloat(document.getElementById('tarif_per_m3').value) || 0;
            const biayaAdmin = parseFloat(document.getElementById('biaya_admin').value) || 0;
            
            const total = (pemakaian * tarifPerM3) + biayaAdmin;
            document.getElementById('total_tagihan').value = total;
        }

        function resetForm() {
            document.getElementById('tagihanForm').reset();
            document.getElementById('search_id_pel').value = '';
            hideCustomerInfo();
            hideTagihanForm();
        }

        function showSearchPelangganModal() {
            document.getElementById('search_id_pel').focus();
        }

        function formatRupiah(angka) {
            return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function showAlert(type, message) {
            const alertTypes = {
                success: 'bg-green-100 border-green-500 text-green-700',
                error: 'bg-red-100 border-red-500 text-red-700',
                warning: 'bg-yellow-100 border-yellow-500 text-yellow-700',
                info: 'bg-blue-100 border-blue-500 text-blue-700'
            };
            
            const alertDiv = document.createElement('div');
            alertDiv.className = `${alertTypes[type]} border-l-4 p-4 mb-4 rounded-lg shadow-sm fixed top-4 right-4 z-50 max-w-md`;
            alertDiv.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-3"></i>
                    <span>${message}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-lg">&times;</button>
                </div>
            `;
            
            document.body.appendChild(alertDiv);
            
            setTimeout(() => {
                if (alertDiv.parentElement) {
                    alertDiv.remove();
                }
            }, 5000);
        }

        function showLoading() {
            // Add loading spinner or disable form
            const searchButton = document.querySelector('#searchForm button[type="submit"]');
            searchButton.disabled = true;
            searchButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mencari...';
        }

        function hideLoading() {
            const searchButton = document.querySelector('#searchForm button[type="submit"]');
            searchButton.disabled = false;
            searchButton.innerHTML = '<i class="fas fa-search mr-2"></i>Cari Pelanggan';
        }

        function viewTagihan(id) {
            window.location.href = `/admin/tagihan/view/${id}`;
        }

        function editTagihan(id) {
            window.location.href = `/admin/tagihan/edit/${id}`;
        }

        function deleteTagihan(id) {
            if (confirm('Apakah Anda yakin ingin menghapus tagihan ini?')) {
                fetch(`/admin/tagihan/delete/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert('success', 'Tagihan berhasil dihapus');
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        showAlert('error', data.message || 'Gagal menghapus tagihan');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('error', 'Terjadi kesalahan saat menghapus tagihan');
                });
            }
        }

        // Update form submission handler
        document.getElementById('tagihanForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validasi form
            const idPel = document.getElementById('form_id_pel').value;
            const bulan = document.getElementById('bulan').value;
            const tahun = document.getElementById('tahun').value;
            const meterAwal = document.getElementById('meter_awal').value;
            const meterAkhir = document.getElementById('meter_akhir').value;
            const tarifPerM3 = document.getElementById('tarif_per_m3').value;
            const totalTagihan = document.getElementById('total_tagihan').value;
            
            if (!idPel || !bulan || !tahun || !meterAwal || !meterAkhir || !tarifPerM3) {
                showAlert('error', 'Semua field wajib diisi');
                return;
            }
            
            if (parseFloat(meterAkhir) < parseFloat(meterAwal)) {
                showAlert('error', 'Meter akhir tidak boleh kurang dari meter awal');
                return;
            }
            
            const formData = new FormData(this);
            
            // Show loading
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
            
            fetch('/admin/tagihan/store', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('success', data.message);
                    resetForm();
                    // Refresh halaman setelah 2 detik
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    showAlert('error', data.message || 'Gagal menyimpan tagihan');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('error', 'Terjadi kesalahan saat menyimpan tagihan');
            })
            .finally(() => {
                // Reset button
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-save mr-2"></i>Simpan Tagihan';
            });
        });
    </script>
</body>
</html>