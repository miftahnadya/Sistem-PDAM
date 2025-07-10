<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Form Pengaduan Pelanggan - PDAM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'pdam': {
                            'dark': '#005792',
                            'blue': '#53CDE2', 
                            'light': '#D1F4FA',
                            'lightest': '#EDF9FC'
                        }
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-out',
                        'slide-up': 'slideUp 0.4s ease-out',
                        'bounce-in': 'bounceIn 0.6s ease-out',
                        'pulse-success': 'pulseSuccess 2s infinite'
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes fadeIn { 0% { opacity: 0; transform: translateY(15px); } 100% { opacity: 1; transform: translateY(0); } }
        @keyframes slideUp { 0% { opacity: 0; transform: translateY(20px); } 100% { opacity: 1; transform: translateY(0); } }
        @keyframes bounceIn { 0% { opacity: 0; transform: scale(0.3); } 50% { transform: scale(1.05); } 70% { transform: scale(0.9); } 100% { opacity: 1; transform: scale(1); } }
        @keyframes pulseSuccess { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.1); } }
        
        .form-input {
            transition: all 0.3s ease;
            border: 2px solid #D1F4FA;
        }
        .form-input:focus {
            border-color: #53CDE2;
            box-shadow: 0 0 0 3px rgba(83, 205, 226, 0.1);
            outline: none;
        }
        .form-input.valid {
            border-color: #10b981;
        }
        .form-input.invalid {
            border-color: #ef4444;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #005792, #53CDE2);
            transition: all 0.3s ease;
        }
        .btn-primary:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 87, 146, 0.3);
        }
        .btn-primary:disabled {
            opacity: 0.6;
            transform: none;
            cursor: not-allowed;
        }
        
        .upload-area {
            border: 2px dashed #D1F4FA;
            transition: all 0.3s ease;
        }
        .upload-area:hover, .upload-area.drag-over {
            border-color: #53CDE2;
            background: rgba(83, 205, 226, 0.05);
        }
        
        .step-indicator {
            background: linear-gradient(135deg, #EDF9FC, #D1F4FA);
        }
        
        .loading-spinner {
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top: 3px solid #ffffff;
            width: 24px;
            height: 24px;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Responsive overrides */
        @media (max-width: 1023px) {
            .lg\:ml-72 { margin-left: 0 !important; }
        }
        @media (max-width: 767px) {
            .max-w-4xl, .max-w-md { max-width: 100% !important; }
            .p-6, .md\:p-8, .px-6, .md\:px-8, .py-6, .pt-8 { padding: 1rem !important; }
            .rounded-2xl, .rounded-3xl { border-radius: 1rem !important; }
            .text-2xl { font-size: 1.25rem !important; }
            .text-xl { font-size: 1.1rem !important; }
            .w-16, .h-16 { width: 3rem !important; height: 3rem !important; }
            .w-20, .h-20 { width: 4rem !important; height: 4rem !important; }
            .w-10, .h-10 { width: 2.25rem !important; height: 2.25rem !important; }
            .w-8, .h-8 { width: 2rem !important; height: 2rem !important; }
            .flex-row { flex-direction: column !important; }
            .gap-4, .gap-3, .gap-6, .gap-8 { gap: 1rem !important; }
        }
        @media (max-width: 640px) {
            .sm\:flex-row { flex-direction: column !important; }
            .sm\:inline { display: none !important; }
            .sm\:block { display: block !important; }
            .sm\:hidden { display: none !important; }
            .sm\:px-6 { padding-left: 1rem !important; padding-right: 1rem !important; }
        }
    </style>
</head>

<body class="bg-gradient-to-br from-pdam-lightest via-white to-pdam-light min-h-screen">
    @include('component.sidebar')
    
    <div class="lg:ml-72 min-h-screen">
        <!-- Header -->
        <header class="bg-gradient-to-r from-pdam-dark to-pdam-blue text-white p-6 shadow-lg">
            <div class="max-w-4xl mx-auto">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="animate-fade-in text-center md:text-left w-full">
                        <h1 class="text-2xl md:text-3xl font-bold mb-2">Form Pengaduan</h1>
                        <p class="text-pdam-light">Sampaikan keluhan Anda, kami siap membantu</p>
                    </div>
                    <div class="hidden md:block animate-slide-up">
                        <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                            <i class="fas fa-headset text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Error Alert -->
        @if($errors->any())
        <div class="max-w-4xl mx-auto p-6">
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg animate-fade-in">
                <div class="flex">
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan pada form:</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Success Alert -->
        @if(session('success'))
        <div class="max-w-4xl mx-auto p-6">
            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg animate-fade-in">
                <div class="flex">
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-green-800">{{ session('success') }}</h3>
                        @if(session('ticket_number'))
                        <p class="text-sm text-green-700 mt-1">Nomor Tiket: <strong>{{ session('ticket_number') }}</strong></p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Main Content -->
        <main class="max-w-4xl mx-auto p-6">
            <!-- Progress Steps -->
            <div class="step-indicator rounded-2xl p-4 mb-6 animate-fade-in">
                <div class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-8">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-pdam-blue text-white rounded-full flex items-center justify-center text-sm font-bold">1</div>
                        <span class="text-pdam-dark font-medium">Isi Data</span>
                    </div>
                    <div class="w-12 h-0.5 bg-pdam-light hidden sm:block"></div>
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-pdam-light text-pdam-dark rounded-full flex items-center justify-center text-sm font-bold">2</div>
                        <span class="text-gray-500">Kirim</span>
                    </div>
                    <div class="w-12 h-0.5 bg-pdam-light hidden sm:block"></div>
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-pdam-light text-pdam-dark rounded-full flex items-center justify-center text-sm font-bold">3</div>
                        <span class="text-gray-500">Selesai</span>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-xl border border-pdam-light/30 overflow-hidden animate-slide-up">
                <form method="POST" action="{{ route('pengaduan.store') }}" enctype="multipart/form-data" id="pengaduanForm">
                    @csrf
                    
                    <div class="p-6 md:p-8 space-y-8">
                        <!-- Section 1: Data Pelanggan -->
                        <div class="space-y-6">
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="w-10 h-10 bg-pdam-blue rounded-lg flex items-center justify-center">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                                <h3 class="text-xl font-bold text-pdam-dark">Data Pelanggan</h3>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Nama -->
                                <div>
                                    <label class="block text-sm font-semibold mb-2 text-gray-700">Nama Lengkap</label>
                                    <input type="text" name="nama_pelanggan" 
                                           class="form-input w-full rounded-xl px-4 py-3 text-gray-900 placeholder-gray-400"
                                           placeholder="Masukkan nama lengkap"
                                           value="{{ old('nama_pelanggan', Auth::user()->nama_pelanggan ?? '') }}" required>
                                    @error('nama_pelanggan')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- ID Pelanggan -->
                                <div>
                                    <label class="block text-sm font-semibold mb-2 text-gray-700">ID Pelanggan</label>
                                    <input type="text" name="id_pelanggan" 
                                           class="form-input w-full rounded-xl px-4 py-3 text-gray-900 placeholder-gray-400"
                                           placeholder="ID pada tagihan air"
                                           value="{{ old('id_pelanggan', Auth::user()->id_pel ?? '') }}" required>
                                    @error('id_pelanggan')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- No HP -->
                                <div>
                                    <label class="block text-sm font-semibold mb-2 text-gray-700">Nomor HP</label>
                                    <input type="tel" name="no_hp" 
                                           class="form-input w-full rounded-xl px-4 py-3 text-gray-900 placeholder-gray-400"
                                           placeholder="08xxxxxxxxxx"
                                           value="{{ old('no_hp') }}" required>
                                    @error('no_hp')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Kategori -->
                                <div>
                                    <label class="block text-sm font-semibold mb-2 text-gray-700">Kategori Masalah</label>
                                    <select name="kategori" class="form-input w-full rounded-xl px-4 py-3 text-gray-900" required>
                                        <option value="">Pilih kategori</option>
                                        <option value="kualitas_air" {{ old('kategori') == 'kualitas_air' ? 'selected' : '' }}>Kualitas Air</option>
                                        <option value="ketersediaan_air" {{ old('kategori') == 'ketersediaan_air' ? 'selected' : '' }}>Ketersediaan Air</option>
                                        <option value="tagihan" {{ old('kategori') == 'tagihan' ? 'selected' : '' }}>Tagihan</option>
                                        <option value="pelayanan" {{ old('kategori') == 'pelayanan' ? 'selected' : '' }}>Pelayanan</option>
                                        <option value="perbaikan" {{ old('kategori') == 'perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                                        <option value="lainnya" {{ old('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                    @error('kategori')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Alamat -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold mb-2 text-gray-700">Alamat Lengkap</label>
                                    <textarea name="alamat" rows="3"
                                              class="form-input w-full rounded-xl px-4 py-3 text-gray-900 placeholder-gray-400 resize-none"
                                              placeholder="Alamat lengkap sesuai pemasangan PDAM"
                                              required>{{ old('alamat', Auth::user()->alamat ?? '') }}</textarea>
                                    @error('alamat')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Detail Pengaduan -->
                        <div class="space-y-6 border-t border-gray-100 pt-8">
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="w-10 h-10 bg-pdam-blue rounded-lg flex items-center justify-center">
                                    <i class="fas fa-edit text-white"></i>
                                </div>
                                <h3 class="text-xl font-bold text-pdam-dark">Detail Pengaduan</h3>
                            </div>

                            <!-- Judul -->
                            <div>
                                <label class="block text-sm font-semibold mb-2 text-gray-700">Judul Pengaduan</label>
                                <input type="text" name="judul" 
                                       class="form-input w-full rounded-xl px-4 py-3 text-gray-900 placeholder-gray-400"
                                       placeholder="Ringkasan masalah dalam satu kalimat"
                                       value="{{ old('judul') }}" required>
                                @error('judul')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Detail -->
                            <div>
                                <label class="block text-sm font-semibold mb-2 text-gray-700">Ceritakan Detail Masalah</label>
                                <textarea name="detail_pengaduan" rows="5"
                                          class="form-input w-full rounded-xl px-4 py-3 text-gray-900 placeholder-gray-400 resize-none"
                                          placeholder="Jelaskan masalah secara detail: kapan terjadi, dampaknya, dll."
                                          required>{{ old('detail_pengaduan') }}</textarea>
                                @error('detail_pengaduan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Section 3: Upload File -->
                        <div class="space-y-6 border-t border-gray-100 pt-8">
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="w-10 h-10 bg-pdam-blue rounded-lg flex items-center justify-center">
                                    <i class="fas fa-camera text-white"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-pdam-dark">Foto Pendukung</h3>
                                    <p class="text-sm text-gray-500">Opsional - bantu kami memahami masalah dengan foto</p>
                                </div>
                            </div>

                            <div class="upload-area rounded-2xl p-8 text-center cursor-pointer" id="uploadArea">
                                <div class="space-y-4">
                                    <div class="w-16 h-16 bg-pdam-light rounded-2xl mx-auto flex items-center justify-center">
                                        <i class="fas fa-cloud-upload-alt text-pdam-blue text-2xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-lg font-medium text-gray-700" id="uploadText">Klik untuk upload foto</p>
                                        <p class="text-sm text-gray-500">JPG, PNG (max 5MB per file)</p>
                                    </div>
                                </div>
                                <input type="file" name="files[]" multiple accept=".jpg,.jpeg,.png" class="hidden" id="fileInput">
                            </div>

                            <!-- File Preview -->
                            <div id="filePreview" class="hidden space-y-3"></div>
                        </div>

                        <!-- Agreement -->
                        <div class="border-t border-gray-100 pt-8">
                            <label class="flex items-start space-x-3 cursor-pointer p-4 bg-pdam-lightest rounded-xl">
                                <input type="checkbox" name="agreement" class="w-5 h-5 text-pdam-blue bg-gray-100 border-gray-300 rounded focus:ring-pdam-blue mt-0.5" required>
                                <div>
                                    <span class="text-gray-900 font-medium">Saya menyatakan data yang diisi benar</span>
                                    <p class="text-sm text-gray-600 mt-1">Data akan diverifikasi dan digunakan untuk proses pengaduan</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="bg-gray-50 px-6 md:px-8 py-6 border-t border-gray-100">
                        <div class="flex flex-col sm:flex-row gap-4 justify-end">
                            <button type="button" onclick="history.back()"
                                    class="px-6 py-3 border-2 border-pdam-light text-pdam-dark font-medium rounded-xl hover:bg-pdam-lightest transition-all">
                                <i class="fas fa-arrow-left mr-2"></i>Kembali
                            </button>
                            <button type="submit" id="submitBtn"
                                    class="btn-primary text-white font-semibold px-8 py-3 rounded-xl">
                                <span id="submitText">
                                    <i class="fas fa-paper-plane mr-2"></i>Kirim Pengaduan
                                </span>
                                <span id="loadingText" class="hidden">
                                    <div class="loading-spinner inline-block mr-2"></div>Mengirim...
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4 backdrop-blur-sm">
        <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full overflow-hidden animate-bounce-in">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-6 text-white text-center">
                <div class="w-20 h-20 bg-white/20 rounded-full mx-auto mb-4 flex items-center justify-center animate-pulse-success">
                    <i class="fas fa-check text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold mb-2">Pengaduan Berhasil Dikirim!</h3>
                <p class="text-green-100">Terima kasih atas laporan Anda</p>
            </div>

            <!-- Modal Body -->
            <div class="p-8 text-center">
                <div class="space-y-6">
                    <!-- Ticket Number -->
                    <div class="bg-pdam-lightest rounded-2xl p-6">
                        <p class="text-sm font-medium text-gray-600 mb-2">Nomor Tiket Pengaduan</p>
                        <p class="text-2xl font-bold text-pdam-dark" id="ticketNumber">-</p>
                        <p class="text-xs text-gray-500 mt-2">Simpan nomor ini untuk melacak pengaduan</p>
                    </div>

                    <!-- Info -->
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3 text-left">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-clock text-blue-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Respon dalam 1×24 jam</p>
                                <p class="text-xs text-gray-500">Tim kami akan segera menindaklanjuti</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-3 text-left">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-bell text-green-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Notifikasi Update</p>
                                <p class="text-xs text-gray-500">Anda akan mendapat pemberitahuan via SMS</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-3 text-left">
                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-search text-purple-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Lacak Pengaduan</p>
                                <p class="text-xs text-gray-500">Gunakan nomor tiket untuk melacak status</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="bg-gray-50 px-8 py-6 flex flex-col sm:flex-row gap-3">
                <button onclick="trackComplaint()" class="flex-1 bg-pdam-blue hover:bg-pdam-dark text-white font-medium py-3 px-4 rounded-xl transition-colors">
                    <i class="fas fa-search mr-2"></i>Lacak Pengaduan
                </button>
                <button onclick="closeSuccessModal()" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-3 px-4 rounded-xl transition-colors">
                    <i class="fas fa-home mr-2"></i>Ke Dashboard
                </button>
            </div>
        </div>
    </div>

    <script>
        // Animation delays
        document.querySelectorAll('.animate-fade-in').forEach((el, index) => {
            el.style.animationDelay = `${index * 0.1}s`;
        });

        // File upload handling
        const uploadArea = document.getElementById('uploadArea');
        const fileInput = document.getElementById('fileInput');
        const uploadText = document.getElementById('uploadText');
        const filePreview = document.getElementById('filePreview');

        uploadArea?.addEventListener('click', () => fileInput?.click());

        fileInput?.addEventListener('change', function() {
            handleFiles(this.files);
        });

        function handleFiles(files) {
            if (!files || files.length === 0) return;

            uploadText.textContent = `${files.length} file dipilih`;
            filePreview.innerHTML = '';
            filePreview.classList.remove('hidden');

            Array.from(files).forEach((file, index) => {
                const fileItem = document.createElement('div');
                fileItem.className = 'flex items-center justify-between p-3 bg-white rounded-xl border border-pdam-light';
                fileItem.innerHTML = `
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-pdam-lightest rounded-lg flex items-center justify-center">
                            <i class="fas fa-file-image text-pdam-blue text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">${file.name}</p>
                            <p class="text-xs text-gray-500">${(file.size / 1024).toFixed(1)} KB</p>
                        </div>
                    </div>
                    <button type="button" onclick="removeFile(${index})" class="text-red-500 hover:text-red-700 p-2">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                filePreview.appendChild(fileItem);
            });
        }

        function removeFile(index) {
            try {
                const dt = new DataTransfer();
                const files = fileInput?.files;
                
                if (!files) return;
                
                for (let i = 0; i < files.length; i++) {
                    if (i !== index) dt.items.add(files[i]);
                }
                
                fileInput.files = dt.files;
                handleFiles(fileInput.files);
                
                if (fileInput.files.length === 0) {
                    uploadText.textContent = 'Klik untuk upload foto';
                    filePreview.classList.add('hidden');
                }
            } catch (error) {
                console.error('Error removing file:', error);
            }
        }

        // Drag & drop
        uploadArea?.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('drag-over');
        });

        uploadArea?.addEventListener('dragleave', () => {
            uploadArea.classList.remove('drag-over');
        });

        uploadArea?.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('drag-over');
            if (fileInput) {
                fileInput.files = e.dataTransfer.files;
                handleFiles(e.dataTransfer.files);
            }
        });

        // Form submission - Traditional submit (no AJAX)
        document.getElementById('pengaduanForm')?.addEventListener('submit', function(e) {
            const agreement = document.querySelector('input[name="agreement"]');
            if (!agreement?.checked) {
                e.preventDefault();
                alert('Harap centang persetujuan terlebih dahulu');
                agreement?.focus();
                return false;
            }

            // Show loading state
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const loadingText = document.getElementById('loadingText');
            
            if (submitBtn && submitText && loadingText) {
                submitBtn.disabled = true;
                submitText.classList.add('hidden');
                loadingText.classList.remove('hidden');
            }
            
            // Let the form submit normally
            return true;
        });

        // Modal functions
        function showSuccessModal() {
            const modal = document.getElementById('successModal');
            if (modal) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeSuccessModal() {
            const modal = document.getElementById('successModal');
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }
            // Redirect to dashboard
            window.location.href = '{{ route("dashboardmasyarakat") }}';
        }

        function trackComplaint() {
            const ticketNumber = document.getElementById('ticketNumber')?.textContent;
            // Close modal first
            const modal = document.getElementById('successModal');
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }
            
            // Redirect to dashboard with tracking modal
            if (ticketNumber && ticketNumber !== '-') {
                window.location.href = '{{ route("dashboardmasyarakat") }}?track=' + ticketNumber;
            } else {
                window.location.href = '{{ route("dashboardmasyarakat") }}';
            }
        }

        // Real-time validation feedback
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('input', function() {
                // Remove existing validation classes
                this.classList.remove('valid', 'invalid');
                
                // Add appropriate class based on validity
                if (this.value.trim() && this.checkValidity()) {
                    this.classList.add('valid');
                } else if (this.value.trim() && !this.checkValidity()) {
                    this.classList.add('invalid');
                }
            });
        });

        // Check for success message from session and show modal
        @if(session('success') && session('ticket_number'))
            document.addEventListener('DOMContentLoaded', function() {
                const ticketElement = document.getElementById('ticketNumber');
                if (ticketElement) {
                    ticketElement.textContent = '{{ session("ticket_number") }}';
                    showSuccessModal();
                }
            });
        @endif
    </script>
</body>
</html>