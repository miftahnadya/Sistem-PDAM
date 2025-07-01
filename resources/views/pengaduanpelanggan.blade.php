<!DOCTYPE html>
<html lang="id">
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
        @include('component.sidebar')
        <!-- Main Content -->
        <main class="flex-1 px-10 py-8">
            <!-- Breadcrumb -->
            <div class="text-white mb-2">
                PDAM <span class="mx-1">›</span> PENGADUAN PELANGGAN
            </div>
            <h2 class="text-2xl font-bold text-[#1a237e] mb-6">FORM PENGADUAN PELANGGAN</h2>
            <!-- Stepper -->
            <div class="flex items-center mb-8">
                <div class="flex items-center flex-wrap gap-2 text-sm">
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
                    <p class="text-gray-400 mb-4 text-center">Drag and Drop untuk upload file data (.xml) atau import file dari komputer Anda</p>
                    <button type="button" class="bg-[#2d399c] hover:bg-[#1a237e] text-white font-semibold px-8 py-2 rounded-lg shadow transition">
                        <i class="fas fa-upload mr-2"></i> Import
                    </button>
                </div>
                <!-- Form Fields -->
                <form>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <div>
                            <label class="block text-sm font-semibold mb-1 text-[#1a237e]">Nama Pelanggan</label>
                            <input type="text" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#2d399c] text-black" placeholder="Masukkan nama lengkap Anda">
                            <p class="text-xs text-gray-500 mt-1">Masukkan nama pelanggan sesuai data PDAM.</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-1 text-[#1a237e]">ID Pelanggan</label>
                            <input type="text" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#2d399c] text-black" placeholder="Masukkan ID pelanggan">
                            <p class="text-xs text-gray-500 mt-1">ID pelanggan dapat dilihat pada tagihan air Anda.</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-1 text-[#1a237e]">Alamat</label>
                            <textarea class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#2d399c] text-black min-h-[80px]" rows="3" placeholder="Masukkan alamat lengkap"></textarea>
                            <p class="text-xs text-gray-500 mt-1">Tulis alamat lengkap sesuai lokasi pemasangan PDAM.</p>
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-sm font-semibold mb-1 text-[#1a237e]">Detail Pengaduan</label>
                            <textarea class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#2d399c] text-black min-h-[80px]" rows="3" placeholder="Jelaskan detail pengaduan Anda"></textarea>
                            <p class="text-xs text-gray-500 mt-1">Jelaskan secara rinci masalah atau keluhan yang Anda alami.</p>
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-sm font-semibold mb-1 text-[#1a237e]">No HP</label>
                            <input type="text" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#2d399c] text-black" placeholder="Masukkan nomor HP aktif">
                            <p class="text-xs text-gray-500 mt-1">Pastikan nomor HP yang Anda masukkan aktif dan dapat dihubungi.</p>
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row gap-4 mb-8">
                        <label class="flex items-start gap-3 text-[#1a237e] font-medium">
                            <input type="checkbox" class="accent-[#2d399c] w-5 h-5 mt-1 rounded">
                            <span>
                                Data yang saya isi sudah benar dan dapat dipertanggungjawabkan.
                                <p class="text-xs text-gray-500">Pastikan seluruh data yang Anda masukkan sudah sesuai.</p>
                            </span>
                        </label>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-[#2d399c] hover:bg-[#1a237e] text-white font-semibold px-8 py-2 rounded-lg shadow transition">
                            Kirim Pengaduan
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>