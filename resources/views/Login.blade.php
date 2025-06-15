
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Tagihan PDAM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="min-h-screen bg-gradient-to-r from-[#6bb6d6] to-[#10283a] flex items-center justify-center">
    <div class="flex w-full h-screen">
        <!-- Sidebar -->
        <div class="bg-[#10283a] w-16 flex flex-col items-center py-8 space-y-6">
            <a href="{{ url('/') }}" class="text-white text-2xl mb-4"><i class="fas fa-home"></i></a>
            <a href="#" class="text-white text-2xl"><i class="fas fa-file-alt"></i></a>
            <a href="#" class="text-white text-2xl"><i class="fas fa-user"></i></a>
        </div>
        <!-- Ilustrasi dan Form -->
        <div class="flex flex-1 items-center justify-center">
            <!-- Ilustrasi -->
            <div class="hidden md:flex flex-1 justify-center">
                <img src="{{ asset('images/ilustrasi-pdam.png') }}" alt="Ilustrasi PDAM" class="max-h-[350px]">
            </div>
            <!-- Form Cek Tagihan -->
            <div class="flex-1 flex justify-center">
                <div class="bg-[#10283a]/60 border-2 border-gray-300 rounded-lg shadow-lg p-8 w-[340px] flex flex-col items-center backdrop-blur-md">
                    <div class="bg-[#6bb6d6] rounded-full w-16 h-16 flex items-center justify-center mb-6">
                        <i class="fas fa-user text-3xl text-white"></i>
                    </div>
                    <form action="{{ route('cek-tagihan') }}" method="POST" class="w-full flex flex-col gap-6">
                        @csrf
                        <div>
                            <label class="block text-white text-sm mb-1">ID Pelanggan</label>
                            <input type="text" name="id_pelanggan" class="w-full bg-transparent border-b-2 border-gray-300 text-white focus:outline-none focus:border-[#6bb6d6] py-1" required>
                        </div>
                        <div>
                            <label class="block text-white text-sm mb-1">Nama Pelanggan</label>
                            <input type="text" name="nama_pelanggan" class="w-full bg-transparent border-b-2 border-gray-300 text-white focus:outline-none focus:border-[#6bb6d6] py-1" required>
                        </div>
                        <button type="submit" class="mt-2 w-full bg-[#6bb6d6] text-[#10283a] font-bold py-2 rounded-lg hover:bg-[#5aa3c2] transition">Cek</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>