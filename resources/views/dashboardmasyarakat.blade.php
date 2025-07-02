<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pelanggan - PDAM</title>
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
        .fade-in { animation: fadeIn 0.5s ease-in; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 10px 25px rgba(0, 87, 146, 0.15); }
        .pdam-gradient { background: linear-gradient(135deg, #005792 0%, #53CDE2 100%); }
        .pulse-ring { animation: pulse-ring 1.85s cubic-bezier(0.215, 0.61, 0.355, 1) infinite; }
        @keyframes pulse-ring { 0% { transform: scale(0.33); } 80%, 100% { opacity: 0; } }
        
        /* Water Animation Styles */
        .water-container {
            position: relative;
            overflow: hidden;
            border-radius: 1.5rem;
        }
        
        .water-wave {
            position: absolute;
            top: 0;
            left: -100%;
            width: 200%;
            height: 100%;
            background: linear-gradient(90deg, 
                rgba(0, 87, 146, 0.1) 0%, 
                rgba(83, 205, 226, 0.2) 25%, 
                rgba(0, 87, 146, 0.15) 50%, 
                rgba(83, 205, 226, 0.2) 75%, 
                rgba(0, 87, 146, 0.1) 100%);
            animation: wave-flow 3s linear infinite;
        }
        
        .water-wave-2 {
            position: absolute;
            top: 0;
            right: -100%;
            width: 200%;
            height: 100%;
            background: linear-gradient(90deg, 
                rgba(209, 244, 250, 0.08) 0%, 
                rgba(237, 249, 252, 0.15) 25%, 
                rgba(209, 244, 250, 0.12) 50%, 
                rgba(237, 249, 252, 0.15) 75%, 
                rgba(209, 244, 250, 0.08) 100%);
            animation: wave-flow-reverse 4s linear infinite;
        }
        
        @keyframes wave-flow {
            0% { transform: translateX(0); }
            100% { transform: translateX(50%); }
        }
        
        @keyframes wave-flow-reverse {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        
        /* Water droplets animation */
        .water-droplets {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }
        
        .droplet {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(83, 205, 226, 0.6);
            border-radius: 50%;
            animation: droplet-fall linear infinite;
        }
        
        .droplet:nth-child(1) { left: 10%; animation-duration: 2s; animation-delay: 0s; }
        .droplet:nth-child(2) { left: 30%; animation-duration: 2.5s; animation-delay: 0.5s; }
        .droplet:nth-child(3) { left: 50%; animation-duration: 1.8s; animation-delay: 1s; }
        .droplet:nth-child(4) { left: 70%; animation-duration: 2.2s; animation-delay: 1.5s; }
        .droplet:nth-child(5) { left: 90%; animation-duration: 2.8s; animation-delay: 0.8s; }
        
        @keyframes droplet-fall {
            0% { top: -10px; opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { top: 100%; opacity: 0; }
        }
        
        /* Bubble animation */
        .bubble {
            position: absolute;
            border-radius: 50%;
            background: rgba(237, 249, 252, 0.3);
            animation: bubble-rise linear infinite;
        }
        
        .bubble:nth-child(1) { 
            width: 8px; height: 8px; left: 15%; 
            animation-duration: 3s; animation-delay: 0s; 
        }
        .bubble:nth-child(2) { 
            width: 12px; height: 12px; left: 45%; 
            animation-duration: 4s; animation-delay: 1s; 
        }
        .bubble:nth-child(3) { 
            width: 6px; height: 6px; left: 75%; 
            animation-duration: 2.5s; animation-delay: 2s; 
        }
        
        @keyframes bubble-rise {
            0% { bottom: -20px; opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { bottom: 100%; opacity: 0; }
        }
        
        /* Water flow in pipes */
        .pipe-flow {
            position: relative;
            overflow: hidden;
        }
        
        .pipe-flow::before {
            content: '';
            position: absolute;
            top: 50%;
            left: -20px;
            transform: translateY(-50%);
            width: 40px;
            height: 4px;
            background: linear-gradient(90deg, 
                transparent 0%, 
                rgba(83, 205, 226, 0.8) 50%, 
                transparent 100%);
            animation: pipe-flow 1.5s linear infinite;
        }
        
        @keyframes pipe-flow {
            0% { left: -40px; }
            100% { left: 100%; }
        }
        
        /* Header water background */
        .header-water {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            overflow: hidden;
            z-index: 0;
        }
        
        .header-water::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 200%;
            height: 100%;
            background: linear-gradient(90deg, 
                transparent 0%, 
                rgba(237, 249, 252, 0.1) 25%, 
                rgba(237, 249, 252, 0.2) 50%, 
                rgba(237, 249, 252, 0.1) 75%, 
                transparent 100%);
            animation: header-flow 8s ease-in-out infinite;
        }
        
        @keyframes header-flow {
            0%, 100% { transform: translateX(0); }
            50% { transform: translateX(50%); }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-pdam-lightest to-pdam-light min-h-screen">
    <!-- Include Sidebar -->
    @include('component.sidebar')
    
    <!-- Main Content -->
    <div class="lg:ml-72 transition-all duration-300">
        <!-- Header dengan Gradient dan Water Effect -->
        <header class="pdam-gradient shadow-lg sticky top-0 z-20 relative">
            <div class="header-water"></div>
            <div class="px-6 py-6 relative z-10">
                <div class="flex items-center justify-between">
                    <div class="ml-12 lg:ml-0 text-white">
                        <h1 class="text-3xl font-bold">Dashboard Pelanggan</h1>
                        <p class="text-pdam-light mt-1">
                            <i class="fas fa-user-circle mr-2"></i>
                            {{ Auth::user()->nama_pelanggan ?? 'Pengguna' }}
                        </p>
                    </div>
                    <div class="text-right text-white">
                        <p class="text-pdam-light text-sm">{{ date('l, d F Y') }}</p>
                        <p class="text-lg font-semibold" id="currentTime"></p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <main class="p-6 max-w-7xl mx-auto">
            <!-- Quick Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
                <!-- Status Pelanggan -->
                <div class="bg-white rounded-2xl shadow-lg border border-pdam-light/30 p-6 card-hover fade-in water-container">
                    <div class="water-wave"></div>
                    <div class="water-droplets">
                        <div class="droplet"></div>
                        <div class="droplet"></div>
                        <div class="droplet"></div>
                        <div class="droplet"></div>
                        <div class="droplet"></div>
                    </div>
                    <div class="flex items-center justify-between relative z-10">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-2">Status Pelanggan</p>
                            <p class="text-xl font-bold {{ (Auth::user()->status_pelanggan ?? '') === 'AKTIF' ? 'text-pdam-dark' : 'text-red-500' }}">
                                {{ Auth::user()->status_pelanggan ?? 'TIDAK AKTIF' }}
                            </p>
                        </div>
                        <div class="relative">
                            <div class="w-16 h-16 {{ (Auth::user()->status_pelanggan ?? '') === 'AKTIF' ? 'bg-pdam-lightest' : 'bg-red-100' }} rounded-2xl flex items-center justify-center">
                                <i class="fas {{ (Auth::user()->status_pelanggan ?? '') === 'AKTIF' ? 'fa-user-check text-pdam-dark' : 'fa-user-times text-red-500' }} text-2xl"></i>
                            </div>
                            @if((Auth::user()->status_pelanggan ?? '') === 'AKTIF')
                            <div class="absolute -top-1 -right-1 w-6 h-6 bg-pdam-blue rounded-full pulse-ring"></div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Pemakaian Air -->
                <div class="bg-white rounded-2xl shadow-lg border border-pdam-light/30 p-6 card-hover fade-in water-container">
                    <div class="water-wave-2"></div>
                    <div class="water-droplets">
                        <div class="bubble"></div>
                        <div class="bubble"></div>
                        <div class="bubble"></div>
                    </div>
                    <div class="flex items-center justify-between relative z-10">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-2">Pemakaian Bulan Ini</p>
                            <p class="text-xl font-bold text-pdam-dark">
                                {{ Auth::user()->total_pemakaian_m3 ?? 0 }} m³
                            </p>
                            <div class="pipe-flow mt-2">
                                <div class="h-1 bg-pdam-light rounded-full"></div>
                            </div>
                        </div>
                        <div class="w-16 h-16 bg-pdam-lightest rounded-2xl flex items-center justify-center">
                            <i class="fas fa-tint text-pdam-blue text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Status Meter -->
                <div class="bg-white rounded-2xl shadow-lg border border-pdam-light/30 p-6 card-hover fade-in water-container">
                    <div class="water-wave"></div>
                    <div class="flex items-center justify-between relative z-10">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-2">Status Meter</p>
                            <p class="text-lg font-bold text-pdam-dark">
                                {{ Auth::user()->status_meter ?? 'Normal' }}
                            </p>
                        </div>
                        <div class="w-16 h-16 bg-pdam-lightest rounded-2xl flex items-center justify-center">
                            <i class="fas fa-tachometer-alt text-pdam-blue text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Grid -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                <!-- Left: Info Pelanggan -->
                <div class="xl:col-span-1">
                    <div class="bg-white rounded-2xl shadow-lg border border-pdam-light/30 p-6 card-hover fade-in h-full water-container">
                        <div class="water-wave-2"></div>
                        <div class="relative z-10">
                            <div class="text-center mb-6">
                                <div class="w-20 h-20 pdam-gradient rounded-full mx-auto mb-4 flex items-center justify-center">
                                    <i class="fas fa-user text-white text-3xl"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900">{{ Auth::user()->nama_pelanggan ?? 'Pelanggan' }}</h3>
                                <p class="text-pdam-dark">ID: {{ Auth::user()->id_pel ?? 'N/A' }}</p>
                            </div>

                            <div class="space-y-4">
                                @if(Auth::user()->alamat)
                                <div class="flex items-start space-x-3 p-3 bg-pdam-lightest rounded-lg">
                                    <i class="fas fa-map-marker-alt text-pdam-blue mt-1"></i>
                                    <div>
                                        <p class="text-sm text-gray-500">Alamat</p>
                                        <p class="font-medium">{{ Auth::user()->alamat }}</p>
                                    </div>
                                </div>
                                @endif

                                @if(Auth::user()->goltar)
                                <div class="flex items-center space-x-3 p-3 bg-pdam-lightest rounded-lg">
                                    <i class="fas fa-layer-group text-pdam-blue"></i>
                                    <div>
                                        <p class="text-sm text-gray-500">Golongan Tarif</p>
                                        <p class="font-medium">{{ Auth::user()->goltar }}</p>
                                    </div>
                                </div>
                                @endif

                                @if(Auth::user()->periode_terakhir)
                                <div class="flex items-center space-x-3 p-3 bg-pdam-lightest rounded-lg">
                                    <i class="fas fa-calendar text-pdam-blue"></i>
                                    <div>
                                        <p class="text-sm text-gray-500">Periode Terakhir</p>
                                        <p class="font-medium">{{ Auth::user()->periode_terakhir }}</p>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <!-- Quick Actions -->
                            <div class="mt-6 pt-6 border-t border-pdam-light/50">
                                <div class="grid grid-cols-2 gap-3">
                                    <a href="{{ route('cektagihan') }}" class="flex flex-col items-center p-4 bg-pdam-lightest hover:bg-pdam-light rounded-xl transition-all group">
                                        <i class="fas fa-file-invoice text-pdam-dark text-xl mb-2 group-hover:scale-110 transition-transform"></i>
                                        <span class="text-sm font-medium text-pdam-dark">Cek Tagihan</span>
                                    </a>
                                    <a href="#" class="flex flex-col items-center p-4 bg-pdam-lightest hover:bg-pdam-light rounded-xl transition-all group">
                                        <i class="fas fa-headset text-pdam-blue text-xl mb-2 group-hover:scale-110 transition-transform"></i>
                                        <span class="text-sm font-medium text-pdam-blue">Pengaduan</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Jatuh Tempo & Riwayat -->
                <div class="xl:col-span-2 space-y-8">
                    <!-- Jatuh Tempo Card - Only if there's a bill -->
                    @if((Auth::user()->total_tagihan ?? 0) > 0)
                    <div class="bg-white rounded-2xl shadow-lg border border-pdam-light/30 overflow-hidden card-hover fade-in">
                        <div class="bg-gradient-to-r from-orange-500 to-red-500 p-6 text-white relative">
                            <div class="header-water"></div>
                            <div class="flex items-center justify-between relative z-10">
                                <div>
                                    <h3 class="text-xl font-bold mb-2">
                                        <i class="fas fa-clock mr-2"></i>
                                        Jatuh Tempo Pembayaran
                                    </h3>
                                    @php
                                        $jatuhTempo = isset($jatuh_tempo) ? $jatuh_tempo : ['tanggal' => 'Tidak diketahui', 'hari_tersisa' => 0, 'status' => 'normal'];
                                    @endphp
                                    <p class="text-orange-100">{{ $jatuhTempo['tanggal'] }}</p>
                                </div>
                                <div class="text-right">
                                    @if($jatuhTempo['hari_tersisa'] > 0)
                                        <div class="text-3xl font-bold">{{ $jatuhTempo['hari_tersisa'] }}</div>
                                        <div class="text-orange-100 text-sm">Hari tersisa</div>
                                    @else
                                        <div class="text-2xl font-bold">{{ $jatuhTempo['status'] === 'danger' ? 'LEWAT' : 'HARI INI' }}</div>
                                        <div class="text-orange-100 text-sm">Jatuh tempo</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-600">Total yang harus dibayar:</p>
                                    <p class="text-2xl font-bold text-red-600">Rp {{ number_format(Auth::user()->total_tagihan, 0, ',', '.') }}</p>
                                </div>
                                <a href="{{ route('cektagihan') }}" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-medium transition-all transform hover:scale-105">
                                    <i class="fas fa-credit-card mr-2"></i>
                                    Bayar Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Riwayat Pengaduan -->
                    <div class="bg-white rounded-2xl shadow-lg border border-pdam-light/30 card-hover fade-in water-container">
                        <div class="water-wave"></div>
                        <div class="p-6 border-b border-pdam-light/50 relative z-10">
                            <div class="flex items-center justify-between">
                                <h3 class="text-xl font-bold text-gray-900">
                                    <i class="fas fa-history text-pdam-blue mr-2"></i>
                                    Riwayat Pengaduan
                                </h3>
                                <span class="bg-pdam-lightest text-pdam-dark px-3 py-1 rounded-full text-sm font-medium">
                                    {{ isset($riwayat_pengaduan) ? $riwayat_pengaduan->count() : 0 }} pengaduan
                                </span>
                            </div>
                        </div>
                        
                        <div class="p-6 relative z-10">
                            @if(isset($riwayat_pengaduan) && $riwayat_pengaduan->count() > 0)
                                <div class="space-y-4">
                                    @foreach($riwayat_pengaduan->take(5) as $pengaduan)
                                    <div class="flex items-start space-x-4 p-4 bg-pdam-lightest rounded-lg hover:bg-pdam-light transition-colors">
                                        <div class="w-10 h-10 bg-pdam-light rounded-lg flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-ticket-alt text-pdam-dark"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between mb-1">
                                                <h4 class="font-medium text-gray-900 truncate">{{ $pengaduan->judul }}</h4>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $pengaduan->status_class }}">
                                                    {{ $pengaduan->status }}
                                                </span>
                                            </div>
                                            <p class="text-sm text-gray-600 mb-2">{{ $pengaduan->isi_pengaduan }}</p>
                                            <p class="text-xs text-gray-400">{{ $pengaduan->tanggal }}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                    
                                    @if($riwayat_pengaduan->count() > 5)
                                    <div class="text-center pt-4">
                                        <a href="#" class="text-pdam-blue hover:text-pdam-dark font-medium text-sm">
                                            Lihat semua pengaduan <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <i class="fas fa-comments text-gray-300 text-4xl mb-4"></i>
                                    <h4 class="text-lg font-medium text-gray-500 mb-2">Belum ada pengaduan</h4>
                                    <p class="text-gray-400 mb-4">Anda belum pernah mengajukan pengaduan</p>
                                    <a href="#" class="inline-flex items-center px-4 py-2 bg-pdam-dark text-white rounded-lg hover:bg-pdam-blue transition-colors">
                                        <i class="fas fa-plus mr-2"></i>
                                        Buat Pengaduan Baru
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Water Usage Chart -->
                    <div class="bg-white rounded-2xl shadow-lg border border-pdam-light/30 card-hover fade-in water-container">
                        <div class="water-wave-2"></div>
                        <div class="p-6 relative z-10">
                            <h3 class="text-xl font-bold text-gray-900 mb-6">
                                <i class="fas fa-chart-line text-pdam-blue mr-2"></i>
                                Monitoring Pemakaian Air
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="text-center p-4 bg-pdam-lightest rounded-xl">
                                    <div class="pipe-flow mb-3">
                                        <i class="fas fa-tint text-pdam-blue text-3xl"></i>
                                    </div>
                                    <p class="text-sm font-medium text-gray-600 mb-1">Stand Meter Saat Ini</p>
                                    <p class="text-2xl font-bold text-pdam-dark">
                                        {{ Auth::user()->angka_meter_kini ?? 0 }}
                                    </p>
                                </div>
                                
                                <div class="text-center p-4 bg-pdam-lightest rounded-xl">
                                    <i class="fas fa-leaf text-pdam-blue text-3xl mb-3"></i>
                                    <p class="text-sm font-medium text-gray-600 mb-1">Status Efisiensi</p>
                                    <p class="text-lg font-bold text-pdam-dark">
                                        @php
                                            $usage = Auth::user()->total_pemakaian_m3 ?? 0;
                                            $efficiency = $usage <= 10 ? 'Sangat Hemat' : ($usage <= 20 ? 'Hemat' : 'Normal');
                                        @endphp
                                        {{ $efficiency }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Update time
        function updateTime() {
            const now = new Date();
            document.getElementById('currentTime').textContent = now.toLocaleTimeString('id-ID', {
                hour: '2-digit', minute: '2-digit', second: '2-digit'
            });
        }
        updateTime();
        setInterval(updateTime, 1000);

        // Add fade-in animation delay
        document.querySelectorAll('.fade-in').forEach((el, index) => {
            el.style.animationDelay = `${index * 0.1}s`;
        });

        // Water effects interaction
        document.querySelectorAll('.card-hover').forEach(card => {
            card.addEventListener('mouseenter', function() {
                const waves = this.querySelectorAll('.water-wave, .water-wave-2');
                waves.forEach(wave => {
                    wave.style.animationDuration = '1.5s';
                });
            });
            
            card.addEventListener('mouseleave', function() {
                const waves = this.querySelectorAll('.water-wave, .water-wave-2');
                waves.forEach(wave => {
                    wave.style.animationDuration = '3s';
                });
            });
        });
    </script>
</body>
</html>