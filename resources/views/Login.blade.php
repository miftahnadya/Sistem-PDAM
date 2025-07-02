<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PDAM</title>
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
        /* Essential Animations Only */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .fade-in { animation: fadeIn 0.6s ease-out; }
        
        .input-focus:focus {
            box-shadow: 0 0 15px rgba(83, 205, 226, 0.4);
            border-color: #53CDE2;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #005792 0%, #53CDE2 100%);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 25px rgba(0, 87, 146, 0.3);
        }
        
        .loading-spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 2px solid #ffffff;
            border-top: 2px solid transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(0, 87, 146, 0.2);
        }
        
        /* Custom gradient background */
        .pdam-gradient {
            background: linear-gradient(135deg, #005792 0%, #53CDE2 50%, #D1F4FA 100%);
        }
        
        /* Responsive */
        @media (max-width: 640px) {
            .login-container {
                margin: 1rem;
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body class="min-h-screen pdam-gradient">
    <!-- Header -->
    <nav class="p-6">
        <div class="flex items-center space-x-3 max-w-7xl mx-auto">
            <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center border border-white/30">
                <i class="fas fa-tint text-white text-xl"></i>
            </div>
            <div class="text-white">
                <h1 class="text-xl font-bold">PDAM</h1>
                <p class="text-xs text-pdam-light">Perusahaan Daerah Air Minum</p>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <div class="flex items-center justify-center min-h-[calc(100vh-120px)] px-4">
        <div class="w-full max-w-md">
            <!-- Login Card -->
            <div class="login-container bg-white rounded-2xl p-8 shadow-2xl fade-in card-hover transition-all duration-300">
                <!-- Header -->
                <div class="text-center mb-8">
                    <div class="w-20 h-20 bg-gradient-to-br from-pdam-dark to-pdam-blue rounded-2xl mx-auto mb-4 flex items-center justify-center shadow-lg">
                        <i class="fas fa-user-circle text-white text-3xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-pdam-dark mb-2">Selamat Datang</h2>
                    <p class="text-gray-600 text-sm">Masuk ke akun PDAM Anda</p>
                </div>
                
                <!-- Success Message -->
                @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-3 text-green-600"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
                @endif
                
                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" id="loginForm" class="space-y-6">
                    @csrf
                    
                    <!-- Nama Pelanggan -->
                    <div>
                        <label for="nama_pelanggan" class="block text-gray-700 text-sm font-medium mb-2">
                            <i class="fas fa-user mr-2 text-pdam-blue"></i>Nama Pelanggan
                        </label>
                        <input type="text" 
                               name="nama_pelanggan" 
                               id="nama_pelanggan" 
                               placeholder="Masukkan nama lengkap" 
                               required 
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-500 focus:outline-none input-focus transition-all duration-300 @error('nama_pelanggan') border-red-400 @enderror" 
                               value="{{ old('nama_pelanggan') }}"
                               autocomplete="name">
                        @error('nama_pelanggan')
                        <div class="text-red-600 text-sm mt-2 flex items-center">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <span>{{ $message }}</span>
                        </div>
                        @enderror
                    </div>
                    
                    <!-- ID Pelanggan -->
                    <div>
                        <label for="id_pel" class="block text-gray-700 text-sm font-medium mb-2">
                            <i class="fas fa-id-card mr-2 text-pdam-blue"></i>ID Pelanggan
                        </label>
                        <input type="text" 
                               name="id_pel" 
                               id="id_pel" 
                               placeholder="Masukkan ID pelanggan" 
                               required 
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-500 focus:outline-none input-focus transition-all duration-300 @error('id_pel') border-red-400 @enderror"
                               value="{{ old('id_pel') }}"
                               autocomplete="username">
                        @error('id_pel')
                        <div class="text-red-600 text-sm mt-2 flex items-center">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <span>{{ $message }}</span>
                        </div>
                        @enderror
                    </div>
                    
                    <!-- Submit Button -->
                    <button type="submit" 
                            id="loginBtn"
                            class="w-full btn-primary text-white py-3 px-6 rounded-xl font-semibold text-lg shadow-lg">
                        <span id="btnText" class="flex items-center justify-center">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Masuk
                        </span>
                        <div class="loading-spinner mx-auto" id="loadingSpinner"></div>
                    </button>
                    
                    <!-- General Errors -->
                    @if($errors->any() && !$errors->has('nama_pelanggan') && !$errors->has('id_pel'))
                    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-exclamation-circle text-red-600 mt-0.5"></i>
                            <div>
                                @foreach($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </form>
                
                <!-- Footer Links -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row justify-between items-center space-y-3 sm:space-y-0 text-sm">
                        <a href="#" class="text-pdam-blue hover:text-pdam-dark transition-colors">
                            <i class="fas fa-question-circle mr-2"></i>Bantuan
                        </a>
                        <a href="#" class="text-gray-600 hover:text-pdam-dark transition-colors">
                            <i class="fas fa-phone mr-2"></i>Hubungi CS
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="text-center mt-6 text-white/80 text-sm">
                <p>&copy; {{ date('Y') }} PDAM. Semua hak dilindungi.</p>
            </div>
        </div>
    </div>
    
    <!-- Minimal JavaScript -->
    <script>
        // Form loading state
        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.getElementById('loginBtn');
            const btnText = document.getElementById('btnText');
            const spinner = document.getElementById('loadingSpinner');
            
            btnText.style.display = 'none';
            spinner.style.display = 'block';
            btn.disabled = true;
            btn.classList.add('opacity-80');
        });
        
        // Input validation feedback
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', function() {
                if (this.value.length > 0) {
                    this.classList.add('border-pdam-blue');
                    this.classList.remove('border-gray-200');
                } else {
                    this.classList.remove('border-pdam-blue');
                    this.classList.add('border-gray-200');
                }
            });
        });
        
        // Auto-focus first input
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('nama_pelanggan').focus();
        });
        
        // Enter key navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && e.target.id === 'nama_pelanggan') {
                e.preventDefault();
                document.getElementById('id_pel').focus();
            }
        });
    </script>
</body>
</html>