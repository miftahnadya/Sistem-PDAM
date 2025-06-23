<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FORM PENGADUAN PELANGGAN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#9EC6F3] min-h-screen">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-72 bg-[#0F2538] min-h-screen px-6 py-8 flex flex-col justify-between rounded-tr-3xl rounded-br-3xl">
            <div>
                <div class="flex items-center gap-3 mb-10">
                    <div class="w-full flex justify-center">
                        <img src="{{ asset('images/logo_pdam.png') }}" class="h-16 mx-auto" alt="Logo PDAM">
                    </div>
                    <span class="text-white text-2xl font-bold"></span>
                </div>
                <nav class="space-y-2">
                    <div class="text-white/80 font-medium mb-2">Dashboard</div>
                    <div class="bg-white/20 rounded-lg px-3 py-2">
                        <div class="flex items-center gap-2 text-white font-semibold mb-1">
                    </div>
                    <div class="text-white/80 font-medium mt-2">Cek Tagihan</div>
                    <div class="text-white/80 font-medium mt-2">Sing Out</div>
                </nav>
            </div>
            <div class="bg-[#1a237e] rounded-xl p-4 mt-8 flex items-center justify-between text-white">
                <div>
                    <div class="font-semibold text-sm">Upgrade your tariff plan</div>
                    <div class="text-xs opacity-80">Set Business account to explore premium features</div>
                </div>
                <button class="ml-4 bg-white text-[#1a237e] rounded-full w-8 h-8 flex items-center justify-center">
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </aside>
        <!-- Main Content -->
        <main class="flex-1 px-10 py-8">
            <!-- Breadcrumb -->
            <div class="text-white mb-2">
                PDAM<an class="mx-1">›</span> PENGADUAN PELANGGAN
            </div>
            <h2 class="text-2xl font-bold text-[#1a237e] mb-6">FROM PENGADUAN PELANGGAN</h2>
            <!-- Stepper -->
            <div class="flex items-center mb-8">
                <div class="flex items-center">
                    <span class="text-[#67AE6E] font-semibold">Customer</span>
                    <span class="mx-2 text-gray-400">•</span>
                    <span class="text-[#1a237e] font-semibold">Import</span>
                    <span class="mx-2 text-gray-400">•</span>
                    <span class="text-gray-400 font-semibold">Mapping</span>
                    <span class="mx-2 text-gray-400">•</span>
                    <span class="text-gray-400 font-semibold">Margins</span>
                    <span class="mx-2 text-gray-400">•</span>
                    <span class="text-gray-400 font-semibold">Discounts</span>
                    <span class="mx-2 text-gray-400">•</span>
                    <span class="text-gray-400 font-semibold">Preview</span>
                    <span class="mx-2 text-gray-400">•</span>
                    <span class="text-gray-400 font-semibold">Complete</span>
                </div>
            </div>
            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow p-8 max-w-2xl mx-auto">
                <!-- Import Box -->
                <div class="border-2 border-dashed border-[#d1d5db] rounded-xl p-6 flex flex-col items-center mb-8">
                    <p class="text-gray-400 mb-4 text-center">Drag and Drop to upload data file (.xml) or import file from your computer</p>
                    <button type="button" class="bg-[#2d399c] hover:bg-[#1a237e] text-white font-semibold px-8 py-2 rounded-lg shadow transition">
                        <i class="fas fa-upload mr-2"></i> Import
                    </button>
                </div>
                <!-- Form Fields -->
                <form>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium mb-1 text-[#1a237e]">Nama Pelanggan</label>
                            <input type="text" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ff9800] text-gray-400" value="nama pelanggan">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1 text-[#1a237e]">Id Pelanggan</label>
                            <input type="text" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ff9800] text-gray-400" value="id pelanggan">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1 text-[#1a237e]">Alamat</label>
                            <textarea class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#ff9800] text-gray-400 min-h-[80px]" rows="3">alamat lengkap</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1 text-[#1a237e]">Detail Pengaduan</label>
                            <textarea class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#ff9800] text-gray-400 min-h-[80px]" rows="3">detail pengaduan</textarea>
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row gap-8 mb-6">
                        <label class="flex items-center gap-2 text-[#1a237e] font-medium">
                            <input type="checkbox" class="accent-[#ff9800] w-5 h-5 rounded">
                            data yang saya isi sudah benar 
                            dan dapat dipertanggungjawabkan
                        </label>
                    </div>
                    <div class="flex items-center justify-between">
                        <button type="button" class="flex items-center gap-2 text-[#1a237e] font-medium hover:underline">
                
                        </button>
                        <div class="w-full flex justify-center">
                            <button type="submit" class="bg-[#2d399c] hover:bg-[#1a237e] text-white font-semibold px-8 py-2 rounded-lg shadow transition">
                                Kirim
                            </button>
                        </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>