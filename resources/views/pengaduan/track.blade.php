<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lacak Pengaduan - PDAM</title>
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
</head>
<body class="bg-gradient-to-br from-pdam-lightest to-pdam-light min-h-screen">
    <div class="min-h-screen flex items-center justify-center px-4 py-8">
        <div class="bg-white rounded-2xl shadow-xl border border-pdam-light/30 p-8 max-w-md w-full">
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-pdam-lightest rounded-full mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-search text-pdam-blue text-2xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-pdam-dark mb-2">Lacak Status Pengaduan</h1>
                <p class="text-gray-600">Masukkan nomor tiket untuk melihat status pengaduan Anda</p>
            </div>
            
            @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
            @endif
            
            <form method="POST" action="{{ route('pengaduan.track.result') }}">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-medium text-pdam-dark mb-2">
                        <i class="fas fa-ticket-alt mr-1"></i>
                        Nomor Tiket
                    </label>
                    <input type="text" 
                           name="ticket_number" 
                           required
                           class="w-full border border-pdam-light/50 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-pdam-blue focus:border-transparent"
                           placeholder="Contoh: PDAM20240101001"
                           value="{{ old('ticket_number') }}">
                    <p class="text-xs text-gray-500 mt-1">Format: PDAMYYYYMMDDXXX</p>
                </div>
                
                <button type="submit" 
                        class="w-full bg-pdam-dark hover:bg-pdam-blue text-white py-3 rounded-lg transition-colors font-medium">
                    <i class="fas fa-search mr-2"></i>
                    Lacak Pengaduan
                </button>
            </form>
            
            <div class="mt-6 pt-6 border-t border-gray-200 text-center">
                <p class="text-sm text-gray-600 mb-4">Belum punya nomor tiket?</p>
                <a href="{{ route('pengaduanpelanggan') }}" 
                   class="text-pdam-blue hover:text-pdam-dark font-medium">
                    <i class="fas fa-plus mr-1"></i>
                    Buat Pengaduan Baru
                </a>
            </div>
        </div>
    </div>
</body>
</html>