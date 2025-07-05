<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Tagihan - Admin PDAM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #005792 0%, #53CDE2 100%);
        }
        
        .card-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 87, 146, 0.1), 0 2px 4px -1px rgba(0, 87, 146, 0.06);
        }
        
        .input-focus:focus {
            border-color: #53CDE2;
            box-shadow: 0 0 0 3px rgba(83, 205, 226, 0.1);
        }
    </style>
</head>
<body class="bg-light">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 fixed h-full bg-white shadow-lg z-50">
            @include('component.sidebar')
        </div>
        
        <!-- Main Content -->
        <main class="flex-1 ml-64">
            <!-- Header -->
            <div class="gradient-bg shadow-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-white">
                            <i class="fas fa-file-invoice-dollar mr-3"></i>
                            Kelola Tagihan
                        </h1>
                        <p class="text-white text-opacity-90 mt-1">Kelola dan input tagihan pelanggan PDAM</p>
                    </div>
                    
                    <button onclick="showSearchPelangganModal()" 
                            class="bg-white text-primary hover:bg-light px-6 py-3 rounded-lg flex items-center gap-2 transition-colors shadow-lg font-medium">
                        <i class="fas fa-search"></i>
                        Cari Pelanggan
                    </button>
                </div>
            </div>

            <!-- Content Area -->
            <div class="p-6">
                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="bg-green-50 border-l-4 border-green-400 text-green-700 p-4 mb-6 rounded-lg card-shadow">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-3"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-50 border-l-4 border-red-400 text-red-700 p-4 mb-6 rounded-lg card-shadow">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-3"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                <!-- Centered Content Container -->
                <div class="max-w-4xl mx-auto">
                    <!-- Instructions Section (Top) -->
                    <div class="bg-gradient-to-br from-accent to-light rounded-xl p-6 border border-secondary border-opacity-20 mb-6">
                        <h3 class="text-lg font-bold text-primary mb-4 text-center">
                            <i class="fas fa-info-circle mr-2"></i>
                            Petunjuk Penggunaan
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-3">
                                <div class="flex items-start">
                                    <div class="w-6 h-6 bg-secondary rounded-full flex items-center justify-center text-white text-xs font-bold mr-3 mt-0.5">
                                        1
                                    </div>
                                    <span class="text-sm text-gray-700">Masukkan ID Pelanggan yang akan ditagih</span>
                                </div>
                                <div class="flex items-start">
                                    <div class="w-6 h-6 bg-secondary rounded-full flex items-center justify-center text-white text-xs font-bold mr-3 mt-0.5">
                                        2
                                    </div>
                                    <span class="text-sm text-gray-700">Sistem akan menampilkan data pelanggan</span>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <div class="flex items-start">
                                    <div class="w-6 h-6 bg-secondary rounded-full flex items-center justify-center text-white text-xs font-bold mr-3 mt-0.5">
                                        3
                                    </div>
                                    <span class="text-sm text-gray-700">Isi form tagihan sesuai dengan pemakaian</span>
                                </div>
                                <div class="flex items-start">
                                    <div class="w-6 h-6 bg-secondary rounded-full flex items-center justify-center text-white text-xs font-bold mr-3 mt-0.5">
                                        4
                                    </div>
                                    <span class="text-sm text-gray-700">Simpan tagihan untuk pelanggan</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Search Section (Bottom) -->
                    <div class="bg-white rounded-xl shadow-lg p-8 border border-accent mb-6">
                        <h2 class="text-2xl font-bold text-primary mb-6 text-center">
                            <i class="fas fa-search mr-3"></i>
                            Cari Pelanggan
                        </h2>
                        
                        <div class="max-w-md mx-auto">
                            <form id="searchForm" class="space-y-4">
                                <div>
                                    <label for="search_id_pel" class="block text-sm font-medium text-gray-700 mb-2 text-center">ID Pelanggan</label>
                                    <div class="relative">
                                        <input type="text" 
                                               id="search_id_pel" 
                                               name="search_id_pel" 
                                               class="w-full px-4 py-4 border border-accent rounded-lg input-focus transition-all duration-200 text-center text-lg"
                                               placeholder="Masukkan ID Pelanggan"
                                               required>
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                                            <i class="fas fa-search text-secondary text-lg"></i>
                                        </div>
                                    </div>
                                </div>
                                
                                <button type="submit" 
                                        class="w-full bg-primary hover:bg-opacity-90 text-white px-6 py-4 rounded-lg flex items-center justify-center gap-3 transition-all duration-200 shadow-lg text-lg font-medium">
                                    <i class="fas fa-search"></i>
                                    Cari Pelanggan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Customer Info Section (Hidden by default) - Smaller and Centered -->
                <div id="customerInfoSection" class="hidden max-w-2xl mx-auto bg-white rounded-xl shadow-lg p-5 mb-6 border border-accent">
                    <h2 class="text-lg font-bold text-primary mb-4 text-center">
                        <i class="fas fa-user mr-2"></i>
                        Data Pelanggan
                    </h2>
                    <div id="customerInfoContent">
                        <!-- Customer info will be loaded here -->
                    </div>
                </div>

                <!-- Tagihan Form Section (Hidden by default) - Smaller and Centered -->
                <div id="tagihanFormSection" class="hidden max-w-2xl mx-auto bg-white rounded-xl shadow-lg p-5 mb-6 border border-accent">
                    <h2 class="text-lg font-bold text-primary mb-4 text-center">
                        <i class="fas fa-file-invoice mr-2"></i>
                        Form Input Tagihan
                    </h2>
                    
                    <form id="tagihanForm" action="/admin/tagihan/store" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" id="form_id_pel" name="id_pel" value="">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="bulan" class="block text-sm font-medium text-gray-700 mb-2">Bulan</label>
                                <select id="bulan" name="bulan" class="w-full px-3 py-2 border border-accent rounded-lg input-focus transition-all duration-200" required>
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
                                <select id="tahun" name="tahun" class="w-full px-3 py-2 border border-accent rounded-lg input-focus transition-all duration-200" required>
                                    <option value="">Pilih Tahun</option>
                                    @for($year = date('Y'); $year >= date('Y') - 5; $year--)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="meter_awal" class="block text-sm font-medium text-gray-700 mb-2">Meter Awal (m³)</label>
                                <input type="number" id="meter_awal" name="meter_awal" 
                                       class="w-full px-3 py-2 border border-accent rounded-lg input-focus transition-all duration-200"
                                       placeholder="Masukkan meter awal" required>
                            </div>
                            
                            <div>
                                <label for="meter_akhir" class="block text-sm font-medium text-gray-700 mb-2">Meter Akhir (m³)</label>
                                <input type="number" id="meter_akhir" name="meter_akhir" 
                                       class="w-full px-3 py-2 border border-accent rounded-lg input-focus transition-all duration-200"
                                       placeholder="Masukkan meter akhir" required>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="pemakaian" class="block text-sm font-medium text-gray-700 mb-2">Pemakaian (m³)</label>
                                <input type="number" id="pemakaian" name="pemakaian" 
                                       class="w-full px-3 py-2 border border-accent rounded-lg bg-light text-gray-600"
                                       placeholder="Otomatis terhitung" readonly>
                            </div>
                            
                            <div>
                                <label for="tarif_per_m3" class="block text-sm font-medium text-gray-700 mb-2">Tarif per m³</label>
                                <input type="number" id="tarif_per_m3" name="tarif_per_m3" 
                                       class="w-full px-3 py-2 border border-accent rounded-lg input-focus transition-all duration-200"
                                       placeholder="Masukkan tarif per m³" required>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="biaya_admin" class="block text-sm font-medium text-gray-700 mb-2">Biaya Admin</label>
                                <input type="number" id="biaya_admin" name="biaya_admin" 
                                       class="w-full px-3 py-2 border border-accent rounded-lg input-focus transition-all duration-200"
                                       placeholder="Masukkan biaya admin" value="0">
                            </div>
                            
                            <div>
                                <label for="total_tagihan" class="block text-sm font-medium text-gray-700 mb-2">Total Tagihan</label>
                                <input type="number" id="total_tagihan" name="total_tagihan" 
                                       class="w-full px-3 py-2 border border-accent rounded-lg bg-light text-gray-600"
                                       placeholder="Otomatis terhitung" readonly>
                            </div>
                        </div>
                        
                        <div>
                            <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                            <textarea id="keterangan" name="keterangan" rows="3" 
                                      class="w-full px-3 py-2 border border-accent rounded-lg input-focus transition-all duration-200"
                                      placeholder="Masukkan keterangan (opsional)"></textarea>
                        </div>
                        
                        <div class="flex gap-3">
                            <button type="submit" 
                                    class="flex-1 bg-primary hover:bg-opacity-90 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2 transition-all duration-200 shadow-lg">
                                <i class="fas fa-save"></i>
                                Simpan Tagihan
                            </button>
                            <button type="button" onclick="resetForm()" 
                                    class="flex-1 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2 transition-all duration-200 shadow-lg">
                                <i class="fas fa-redo"></i>
                                Reset Form
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Success Message Section -->
                <div id="successSection" class="hidden max-w-2xl mx-auto bg-gradient-to-br from-green-50 to-green-100 rounded-xl shadow-lg p-6 mb-6 border border-green-200">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-check-circle text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-green-800 mb-2">Tagihan Berhasil Dibuat!</h3>
                        <p class="text-green-700 mb-4">Tagihan telah tersimpan dalam sistem.</p>
                        <div class="flex justify-center gap-4">
                            <button onclick="createNewTagihan()" 
                                    class="bg-primary hover:bg-opacity-90 text-white px-6 py-3 rounded-lg flex items-center gap-2 transition-all duration-200 shadow-lg">
                                <i class="fas fa-plus"></i>
                                Buat Tagihan Baru
                            </button>
                            <button onclick="viewAllTagihan()" 
                                    class="bg-secondary hover:bg-opacity-90 text-primary px-6 py-3 rounded-lg flex items-center gap-2 transition-all duration-200 shadow-lg">
                                <i class="fas fa-list"></i>
                                Lihat Semua Tagihan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
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

        function displayCustomerInfo(pelanggan) {
            const customerInfoContent = document.getElementById('customerInfoContent');
            customerInfoContent.innerHTML = `
                <div class="space-y-4">
                    <div class="flex items-center justify-center mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary to-secondary rounded-full flex items-center justify-center text-white font-bold text-lg mr-4">
                            ${pelanggan.nama_pelanggan.charAt(0).toUpperCase()}
                        </div>
                        <div class="text-center">
                            <h3 class="text-lg font-semibold text-primary">${pelanggan.nama_pelanggan}</h3>
                            <p class="text-sm text-gray-500">ID Pelanggan: ${pelanggan.id_pel}</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-accent p-3 rounded-lg">
                            <h4 class="font-semibold text-primary mb-2 text-sm">Informasi Kontak</h4>
                            <div class="text-sm text-gray-600 space-y-1">
                                <p><strong>Alamat:</strong> ${pelanggan.alamat || 'N/A'}</p>
                                <p><strong>Telepon:</strong> ${pelanggan.no_telepon || 'N/A'}</p>
                                <p><strong>Email:</strong> ${pelanggan.email || 'N/A'}</p>
                            </div>
                        </div>
                        
                        <div class="bg-light p-3 rounded-lg">
                            <h4 class="font-semibold text-primary mb-2 text-sm">Status & Tarif</h4>
                            <div class="text-sm text-gray-600 space-y-1">
                                <p><strong>Status:</strong> 
                                    <span class="px-2 py-1 ${pelanggan.status_pelanggan === 'AKTIF' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'} rounded-full text-xs font-medium">
                                        ${pelanggan.status_pelanggan || 'AKTIF'}
                                    </span>
                                </p>
                                <p><strong>Kategori:</strong> ${pelanggan.kategori || 'Rumah Tangga'}</p>
                                <p><strong>Tarif:</strong> Rp ${formatRupiah(pelanggan.tarif_per_m3 || 2500)}/m³</p>
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

        function showSuccessSection() {
            document.getElementById('successSection').classList.remove('hidden');
        }

        function hideSuccessSection() {
            document.getElementById('successSection').classList.add('hidden');
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
            hideSuccessSection();
        }

        function createNewTagihan() {
            resetForm();
            document.getElementById('search_id_pel').focus();
        }

        function viewAllTagihan() {
            window.location.href = '/admin/tagihan';
        }

        function showSearchPelangganModal() {
            document.getElementById('search_id_pel').focus();
        }

        function formatRupiah(angka) {
            return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function showAlert(type, message) {
            const alertTypes = {
                success: 'bg-green-50 border-green-400 text-green-700',
                error: 'bg-red-50 border-red-400 text-red-700',
                warning: 'bg-yellow-50 border-yellow-400 text-yellow-700',
                info: 'bg-accent text-primary'
            };
            
            const alertDiv = document.createElement('div');
            alertDiv.className = `${alertTypes[type]} border-l-4 p-4 mb-4 rounded-lg shadow-lg fixed top-4 right-4 z-50 max-w-md`;
            alertDiv.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-3"></i>
                    <span>${message}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-lg font-bold hover:opacity-75">&times;</button>
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
            const searchButton = document.querySelector('#searchForm button[type="submit"]');
            searchButton.disabled = true;
            searchButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mencari...';
        }

        function hideLoading() {
            const searchButton = document.querySelector('#searchForm button[type="submit"]');
            searchButton.disabled = false;
            searchButton.innerHTML = '<i class="fas fa-search mr-2"></i>Cari Pelanggan';
        }

        // Form submission handler
        document.getElementById('tagihanForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validasi form
            const idPel = document.getElementById('form_id_pel').value;
            const bulan = document.getElementById('bulan').value;
            const tahun = document.getElementById('tahun').value;
            const meterAwal = document.getElementById('meter_awal').value;
            const meterAkhir = document.getElementById('meter_akhir').value;
            const tarifPerM3 = document.getElementById('tarif_per_m3').value;
            
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
                    showAlert('success', data.message || 'Tagihan berhasil disimpan');
                    hideCustomerInfo();
                    hideTagihanForm();
                    showSuccessSection();
                    // Scroll to success section
                    document.getElementById('successSection').scrollIntoView({ behavior: 'smooth' });
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