<!-- filepath: resources/views/login.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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
            <form method="POST" action="{{ route('login.process') }}" class="bg-white p-8 rounded shadow w-96">
                @csrf
                <h2 class="text-2xl font-bold mb-6 text-center">Login PDAM</h2>
                <div class="mb-4">
                    <label for="nama_pelanggan" class="block text-gray-700 mb-1">Nama Pelanggan</label>
                    <input type="text" name="nama_pelanggan" id="nama_pelanggan" placeholder="Nama Pelanggan" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-300" value="{{ old('nama_pelanggan') }}">
                </div>
                <div class="mb-4">
                    <label for="id_pelanggan" class="block text-gray-700 mb-1">ID Pelanggan</label>
                    <input type="password" name="id_pelanggan" id="id_pelanggan" placeholder="ID Pelanggan" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-300">
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">Login</button>
                @if($errors->any())
                    <div class="text-red-500 mt-4 text-center">{{ $errors->first() }}</div>
                @endif
            </form>
            <div class="mt-10 text-white/70 text-xs text-center">
                © {{ date('Y') }}, PDAM
            </div>
        </div>
    </div>
</body>
</html>