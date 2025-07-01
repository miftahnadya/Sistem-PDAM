<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - PDAM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <nav class="bg-green-600 text-white p-4 shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">
                <i class="fas fa-cog mr-2"></i>Dashboard Admin - PDAM
            </h1>
            <div class="flex items-center space-x-4">
                <span class="text-green-100">
                    <i class="fas fa-user-shield mr-1"></i>{{ Auth::user()->nama_pelanggan }} (Admin)
                </span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded transition">
                        <i class="fas fa-sign-out-alt mr-1"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mx-auto mt-8 p-4">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif

        <div class="grid md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-bold mb-4">Kelola Data</h2>
                <div class="space-y-2">
                    <a href="#" class="block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Kelola User</a>
                    <a href="#" class="block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Kelola Tagihan</a>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-bold mb-4">Statistik</h2>
                <p><strong>Total User:</strong> {{ \App\Models\User::count() }}</p>
                <p><strong>User Aktif:</strong> {{ \App\Models\User::where('status_pelanggan', 'AKTIF')->count() }}</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-bold mb-4">Info Admin</h2>
                <p><strong>Nama:</strong> {{ Auth::user()->nama_pelanggan }}</p>
                <p><strong>Role:</strong> {{ Auth::user()->role }}</p>
            </div>
        </div>
    </div>
</body>
</html>