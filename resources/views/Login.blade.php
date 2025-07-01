<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PDAM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="min-h-screen w-full">
    <div class="relative min-h-screen w-full flex items-center justify-center">
        <div class="absolute inset-0">
            <img src="{{ asset('images/air 1.jpeg') }}" alt="background" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-[#003366]/30"></div>
        </div>
        
        <div class="relative z-10 w-full max-w-md px-8 py-10 rounded-2xl bg-white/10 backdrop-blur-md shadow-lg flex flex-col">
            <div class="flex items-center mb-8">
                <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center mr-2">
                    <i class="fas fa-building text-[#003366]"></i>
                </div>
                <span class="text-white font-semibold text-lg">PDAM</span>
            </div>
            <h2 class="text-2xl font-bold text-white mb-8">Login ke Akun Anda</h2>
            
            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                </div>
            @endif
            
            <form method="POST" action="{{ route('login') }}" class="bg-white p-8 rounded-lg shadow-lg">
                @csrf
                <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Login PDAM</h2>
                
                <!-- Nama Pelanggan Field -->
                <div class="mb-4">
                    <label for="nama_pelanggan" class="block text-gray-700 text-sm font-bold mb-2">
                        <i class="fas fa-user mr-1"></i>Nama Pelanggan
                    </label>
                    <input type="text" 
                           name="nama_pelanggan" 
                           id="nama_pelanggan" 
                           placeholder="Masukkan nama pelanggan" 
                           required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nama_pelanggan') border-red-500 @enderror" 
                           value="{{ old('nama_pelanggan') }}">
                    @error('nama_pelanggan')
                        <div class="text-red-500 text-sm mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>
                
                <!-- ID Pelanggan Field -->
                <div class="mb-6">
                    <label for="id_pel" class="block text-gray-700 text-sm font-bold mb-2">
                        <i class="fas fa-id-card mr-1"></i>ID Pelanggan
                    </label>
                    <input type="text" 
                           name="id_pel" 
                           id="id_pel" 
                           placeholder="Masukkan ID pelanggan" 
                           required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('id_pel') border-red-500 @enderror">
                    @error('id_pel')
                        <div class="text-red-500 text-sm mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>
                
                <!-- Submit Button -->
                <button type="submit" class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-200 font-semibold">
                    <i class="fas fa-sign-in-alt mr-2"></i>Login
                </button>
                
                <!-- General Error Messages -->
                @if($errors->any() && !$errors->has('nama_pelanggan') && !$errors->has('id_pel'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mt-4">
                        <i class="fas fa-times-circle mr-2"></i>
                        @foreach($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif
            </form>
            
            <div class="mt-4 text-white/70 text-xs text-center">
                © {{ date('Y') }}, PDAM - Sistem Cek Tagihan
            </div>
        </div>
    </div>
</body>
</html>