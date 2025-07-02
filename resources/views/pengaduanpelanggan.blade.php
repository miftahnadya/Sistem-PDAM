<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengaduan Pelanggan - PDAM</title>
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
        /* Essential Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .fade-in { animation: fadeIn 0.6s ease-out; }
        .slide-in { animation: slideIn 0.5s ease-out; }
        
        .input-focus:focus {
            box-shadow: 0 0 15px rgba(83, 205, 226, 0.3);
            border-color: #53CDE2;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #005792 0%, #53CDE2 100%);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 87, 146, 0.3);
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(0, 87, 146, 0.15);
        }
        
        .upload-zone {
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #EDF9FC 0%, #D1F4FA 100%);
        }
        
        .upload-zone:hover {
            background: linear-gradient(135deg, #D1F4FA 0%, #53CDE2 20%);
            border-color: #53CDE2;
        }
        
        .step-active {
            background: linear-gradient(135deg, #005792 0%, #53CDE2 100%);
            color: white;
        }
        
        .step-completed {
            background: #53CDE2;
            color: white;
        }
        
        .step-inactive {
            background: #EDF9FC;
            color: #005792;
        }
        
        /* Water drop animation for submit button */
        .water-drop {
            position: relative;
            overflow: hidden;
        }
        
        .water-drop::before {
            content: '';
            position: absolute;
            top: 50%;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transform: translateY(-50%);
            transition: left 0.6s;
        }
        
        .water-drop:hover::before {
            left: 100%;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-pdam-lightest to-pdam-light min-h-screen">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('component.sidebar')
        
        <!-- Main Content -->
        <main class="flex-1 lg:ml-72 px-6 py-8">
            <!-- Header Section -->
            <div class="mb-8 fade-in">
                <!-- Breadcrumb -->
                <div class="flex items-center text-sm text-pdam-dark mb-4">
                    <i class="fas fa-home mr-2"></i>
                    <span>PDAM</span>
                    <i class="fas fa-chevron-right mx-2 text-xs"></i>
                    <span class="text-pdam-blue font-medium">Pengaduan Pelanggan</span>
                </div>
                
                <!-- Title -->
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-pdam-dark mb-2">Form Pengaduan Pelanggan</h1>
                        <p class="text-gray-600">Sampaikan keluhan atau masalah terkait layanan PDAM</p>
                    </div>
                    <div class="hidden md:block">
                        <div class="w-16 h-16 bg-gradient-to-br from-pdam-dark to-pdam-blue rounded-2xl flex items-center justify-center">
                            <i class="fas fa-comments text-white text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progress Steps -->
            <div class="mb-8 slide-in">
                <div class="bg-white rounded-xl shadow-lg border border-pdam-light/30 p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <!-- Step 1: Data Pelanggan -->
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full step-active flex items-center justify-center text-sm font-bold">
                                    1
                                </div>
                                <span class="ml-2 text-sm font-medium text-pdam-dark">Data Pelanggan</span>
                            </div>
                            
                            <i class="fas fa-arrow-right text-pdam-blue"></i>
                            
                            <!-- Step 2: Detail Pengaduan -->
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full step-inactive flex items-center justify-center text-sm font-bold">
                                    2
                                </div>
                                <span class="ml-2 text-sm font-medium text-gray-500">Detail Pengaduan</span>
                            </div>
                            
                            <i class="fas fa-arrow-right text-gray-300"></i>
                            
                            <!-- Step 3: Konfirmasi -->
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full step-inactive flex items-center justify-center text-sm font-bold">
                                    3
                                </div>
                                <span class="ml-2 text-sm font-medium text-gray-500">Konfirmasi</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-xl border border-pdam-light/30 card-hover fade-in">
                <div class="p-8">
                    <!-- Upload Section -->
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-pdam-dark mb-4 flex items-center">
                            <i class="fas fa-cloud-upload-alt mr-2 text-pdam-blue"></i>
                            Upload Dokumen Pendukung (Opsional)
                        </h3>
                        <div class="upload-zone border-2 border-dashed border-pdam-light rounded-xl p-8 text-center">
                            <div class="mb-4">
                                <i class="fas fa-file-upload text-4xl text-pdam-blue mb-3"></i>
                                <p class="text-gray-600 mb-2">Drag dan drop file ke sini atau klik untuk upload</p>
                                <p class="text-sm text-gray-500">Mendukung format: JPG, PNG, PDF (Maks. 5MB)</p>
                            </div>
                            <button type="button" class="btn-primary text-white font-medium px-6 py-3 rounded-lg water-drop">
                                <i class="fas fa-upload mr-2"></i>
                                Pilih File
                            </button>
                        </div>
                    </div>

                    <!-- Form Fields -->
                    <form method="POST" action="" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Personal Information Section -->
                        <div class="mb-8">
                            <h3 class="text-lg font-bold text-pdam-dark mb-6 flex items-center">
                                <i class="fas fa-user mr-2 text-pdam-blue"></i>
                                Informasi Pelanggan
                            </h3>
                            
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- Nama Pelanggan -->
                                <div>
                                    <label class="block text-sm font-semibold mb-2 text-pdam-dark">
                                        <i class="fas fa-user-circle mr-1 text-pdam-blue"></i>
                                        Nama Pelanggan
                                    </label>
                                    <input type="text" 
                                           name="nama_pelanggan" 
                                           class="w-full border border-pdam-light/50 rounded-lg px-4 py-3 focus:outline-none input-focus transition-all duration-300 @error('nama_pelanggan') border-red-400 @enderror" 
                                           placeholder="Masukkan nama lengkap Anda"
                                           value="{{ old('nama_pelanggan', Auth::user()->nama_pelanggan ?? '') }}"
                                           required>
                                    <p class="text-xs text-gray-500 mt-1">Nama pelanggan sesuai data PDAM</p>
                                    @error('nama_pelanggan')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- ID Pelanggan -->
                                <div>
                                    <label class="block text-sm font-semibold mb-2 text-pdam-dark">
                                        <i class="fas fa-id-card mr-1 text-pdam-blue"></i>
                                        ID Pelanggan
                                    </label>
                                    <input type="text" 
                                           name="id_pelanggan" 
                                           class="w-full border border-pdam-light/50 rounded-lg px-4 py-3 focus:outline-none input-focus transition-all duration-300 @error('id_pelanggan') border-red-400 @enderror" 
                                           placeholder="Masukkan ID pelanggan"
                                           value="{{ old('id_pelanggan', Auth::user()->id_pel ?? '') }}"
                                           required>
                                    <p class="text-xs text-gray-500 mt-1">ID pelanggan tertera pada tagihan air</p>
                                    @error('id_pelanggan')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Alamat -->
                                <div class="lg:col-span-2">
                                    <label class="block text-sm font-semibold mb-2 text-pdam-dark">
                                        <i class="fas fa-map-marker-alt mr-1 text-pdam-blue"></i>
                                        Alamat
                                    </label>
                                    <textarea name="alamat" 
                                              class="w-full border border-pdam-light/50 rounded-lg px-4 py-3 focus:outline-none input-focus transition-all duration-300 min-h-[100px] @error('alamat') border-red-400 @enderror" 
                                              rows="3" 
                                              placeholder="Masukkan alamat lengkap"
                                              required>{{ old('alamat', Auth::user()->alamat ?? '') }}</textarea>
                                    <p class="text-xs text-gray-500 mt-1">Alamat lengkap sesuai lokasi pemasangan PDAM</p>
                                    @error('alamat')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- No HP -->
                                <div>
                                    <label class="block text-sm font-semibold mb-2 text-pdam-dark">
                                        <i class="fas fa-phone mr-1 text-pdam-blue"></i>
                                        Nomor HP
                                    </label>
                                    <input type="tel" 
                                           name="no_hp" 
                                           class="w-full border border-pdam-light/50 rounded-lg px-4 py-3 focus:outline-none input-focus transition-all duration-300 @error('no_hp') border-red-400 @enderror" 
                                           placeholder="08xxxxxxxxxx"
                                           value="{{ old('no_hp') }}"
                                           required>
                                    <p class="text-xs text-gray-500 mt-1">Nomor HP aktif untuk dihubungi</p>
                                    @error('no_hp')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Kategori Pengaduan -->
                                <div>
                                    <label class="block text-sm font-semibold mb-2 text-pdam-dark">
                                        <i class="fas fa-tags mr-1 text-pdam-blue"></i>
                                        Kategori Pengaduan
                                    </label>
                                    <select name="kategori" 
                                            class="w-full border border-pdam-light/50 rounded-lg px-4 py-3 focus:outline-none input-focus transition-all duration-300 @error('kategori') border-red-400 @enderror" 
                                            required>
                                        <option value="">Pilih kategori pengaduan</option>
                                        <option value="kualitas_air" {{ old('kategori') == 'kualitas_air' ? 'selected' : '' }}>Kualitas Air</option>
                                        <option value="ketersediaan_air" {{ old('kategori') == 'ketersediaan_air' ? 'selected' : '' }}>Ketersediaan Air</option>
                                        <option value="tagihan" {{ old('kategori') == 'tagihan' ? 'selected' : '' }}>Tagihan</option>
                                        <option value="pelayanan" {{ old('kategori') == 'pelayanan' ? 'selected' : '' }}>Pelayanan</option>
                                        <option value="perbaikan" {{ old('kategori') == 'perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                                        <option value="lainnya" {{ old('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                    @error('kategori')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Complaint Details Section -->
                        <div class="mb-8">
                            <h3 class="text-lg font-bold text-pdam-dark mb-6 flex items-center">
                                <i class="fas fa-edit mr-2 text-pdam-blue"></i>
                                Detail Pengaduan
                            </h3>
                            
                            <div class="space-y-6">
                                <!-- Judul Pengaduan -->
                                <div>
                                    <label class="block text-sm font-semibold mb-2 text-pdam-dark">
                                        <i class="fas fa-heading mr-1 text-pdam-blue"></i>
                                        Judul Pengaduan
                                    </label>
                                    <input type="text" 
                                           name="judul" 
                                           class="w-full border border-pdam-light/50 rounded-lg px-4 py-3 focus:outline-none input-focus transition-all duration-300 @error('judul') border-red-400 @enderror" 
                                           placeholder="Ringkasan singkat pengaduan Anda"
                                           value="{{ old('judul') }}"
                                           required>
                                    <p class="text-xs text-gray-500 mt-1">Tuliskan judul yang jelas dan singkat</p>
                                    @error('judul')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Detail Pengaduan -->
                                <div>
                                    <label class="block text-sm font-semibold mb-2 text-pdam-dark">
                                        <i class="fas fa-file-alt mr-1 text-pdam-blue"></i>
                                        Detail Pengaduan
                                    </label>
                                    <textarea name="detail_pengaduan" 
                                              class="w-full border border-pdam-light/50 rounded-lg px-4 py-3 focus:outline-none input-focus transition-all duration-300 min-h-[150px] @error('detail_pengaduan') border-red-400 @enderror" 
                                              rows="6" 
                                              placeholder="Jelaskan detail pengaduan Anda secara lengkap..."
                                              required>{{ old('detail_pengaduan') }}</textarea>
                                    <p class="text-xs text-gray-500 mt-1">Jelaskan secara rinci masalah yang Anda alami</p>
                                    @error('detail_pengaduan')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Agreement Section -->
                        <div class="mb-8">
                            <div class="bg-pdam-lightest border border-pdam-light rounded-lg p-6">
                                <label class="flex items-start gap-3 cursor-pointer">
                                    <input type="checkbox" 
                                           name="agreement" 
                                           class="w-5 h-5 text-pdam-blue bg-gray-100 border-gray-300 rounded focus:ring-pdam-blue focus:ring-2 mt-1" 
                                           required>
                                    <div>
                                        <span class="text-pdam-dark font-medium">
                                            Saya menyatakan bahwa data yang saya isi sudah benar dan dapat dipertanggungjawabkan.
                                        </span>
                                        <p class="text-xs text-gray-600 mt-1">
                                            Pastikan seluruh informasi yang Anda berikan sudah sesuai dan dapat diverifikasi.
                                        </p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-end">
                            <button type="button" 
                                    class="px-6 py-3 border border-pdam-light text-pdam-dark font-medium rounded-lg hover:bg-pdam-lightest transition-all duration-300">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Kembali
                            </button>
                            <button type="submit" 
                                    class="btn-primary text-white font-medium px-8 py-3 rounded-lg water-drop">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Kirim Pengaduan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Information Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                <!-- Info Card 1 -->
                <div class="bg-white rounded-xl shadow-lg border border-pdam-light/30 p-6 card-hover fade-in">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-pdam-lightest rounded-lg flex items-center justify-center">
                            <i class="fas fa-info-circle text-pdam-blue text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-pdam-dark mb-2">Informasi Penting</h4>
                            <p class="text-sm text-gray-600">
                                Pengaduan akan diproses dalam 1x24 jam kerja. Tim kami akan menghubungi Anda untuk tindak lanjut.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Info Card 2 -->
                <div class="bg-white rounded-xl shadow-lg border border-pdam-light/30 p-6 card-hover fade-in">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-pdam-lightest rounded-lg flex items-center justify-center">
                            <i class="fas fa-headset text-pdam-blue text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-pdam-dark mb-2">Butuh Bantuan?</h4>
                            <p class="text-sm text-gray-600">
                                Hubungi Customer Service kami di <br>
                                <span class="font-medium text-pdam-dark">📞 (021) 123-4567</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Animation delays
        document.querySelectorAll('.fade-in').forEach((el, index) => {
            el.style.animationDelay = `${index * 0.1}s`;
        });

        // Input validation feedback
        document.querySelectorAll('input, textarea, select').forEach(input => {
            input.addEventListener('input', function() {
                if (this.value.length > 0) {
                    this.classList.add('border-pdam-blue');
                    this.classList.remove('border-pdam-light/50');
                } else {
                    this.classList.remove('border-pdam-blue');
                    this.classList.add('border-pdam-light/50');
                }
            });
        });

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const agreement = document.querySelector('input[name="agreement"]');
            if (!agreement.checked) {
                e.preventDefault();
                alert('Harap centang persetujuan sebelum mengirim pengaduan.');
                agreement.focus();
            }
        });

        // File upload preview
        const uploadZone = document.querySelector('.upload-zone');
        const fileInput = document.createElement('input');
        fileInput.type = 'file';
        fileInput.multiple = true;
        fileInput.accept = '.jpg,.jpeg,.png,.pdf';

        uploadZone.addEventListener('click', () => {
            fileInput.click();
        });

        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                const fileName = this.files[0].name;
                uploadZone.querySelector('p').textContent = `File terpilih: ${fileName}`;
                uploadZone.style.borderColor = '#53CDE2';
                uploadZone.style.background = '#EDF9FC';
            }
        });

        // Drag and drop functionality
        uploadZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadZone.style.borderColor = '#53CDE2';
            uploadZone.style.background = '#EDF9FC';
        });

        uploadZone.addEventListener('dragleave', (e) => {
            e.preventDefault();
            uploadZone.style.borderColor = '#D1F4FA';
            uploadZone.style.background = 'linear-gradient(135deg, #EDF9FC 0%, #D1F4FA 100%)';
        });

        uploadZone.addEventListener('drop', (e) => {
            e.preventDefault();
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                const fileName = files[0].name;
                uploadZone.querySelector('p').textContent = `File terpilih: ${fileName}`;
            }
        });
    </script>
</body>
</html>