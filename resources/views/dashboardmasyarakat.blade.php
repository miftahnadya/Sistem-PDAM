<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Pelanggan - PDAM</title>
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
                        'fade-in': 'fadeIn 0.6s ease-out',
                        'slide-up': 'slideUp 0.5s ease-out',
                        'bounce-gentle': 'bounceGentle 2s infinite',
                        'wave': 'wave 3s ease-in-out infinite',
                        'float': 'float 6s ease-in-out infinite'
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes fadeIn { 0% { opacity: 0; transform: translateY(20px); } 100% { opacity: 1; transform: translateY(0); } }
        @keyframes slideUp { 0% { opacity: 0; transform: translateY(30px); } 100% { opacity: 1; transform: translateY(0); } }
        @keyframes bounceGentle { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-5px); } }
        @keyframes wave { 0%, 100% { transform: rotate(0deg); } 25% { transform: rotate(5deg); } 75% { transform: rotate(-5deg); } }
        @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-10px); } }
        
        .interactive-card { 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }
        .interactive-card:hover { 
            transform: translateY(-8px) scale(1.02); 
            box-shadow: 0 25px 50px -12px rgba(0, 87, 146, 0.25);
        }
        .interactive-card:active { transform: translateY(-4px) scale(1.01); }
        
        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .gradient-text { background: linear-gradient(135deg, #005792, #53CDE2); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .pdam-gradient { background: linear-gradient(135deg, #005792 0%, #53CDE2 100%); }
        .pdam-gradient-light { background: linear-gradient(135deg, #D1F4FA 0%, #EDF9FC 100%); }
        
        .pulse-dot::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: #53CDE2;
            animation: pulse 2s infinite;
        }
        @keyframes pulse { 0% { transform: scale(0.8); opacity: 1; } 100% { transform: scale(2.4); opacity: 0; } }
        
        .line-clamp-1 { display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    </style>
</head>

<body class="bg-gradient-to-br from-pdam-lightest via-white to-pdam-light min-h-screen">
    @include('component.sidebar')
    
    <div class="lg:ml-72 transition-all duration-300">
        <!-- Header -->
        <header class="pdam-gradient shadow-xl sticky top-0 z-20 backdrop-blur-sm">
            <div class="px-6 py-6">
                <div class="flex items-center justify-between">
                    <div class="ml-12 lg:ml-0 text-white">
                        <h1 class="text-3xl font-bold animate-slide-up">Dashboard Pelanggan</h1>
                        <p class="text-pdam-light mt-1 animate-fade-in">
                            <i class="fas fa-user-circle mr-2 animate-wave"></i>
                            {{ Auth::user()->nama_pelanggan ?? 'Pengguna' }}
                        </p>
                    </div>
                    <div class="text-right text-white animate-fade-in">
                        <p class="text-pdam-light text-sm">{{ now()->format('l, d F Y') }}</p>
                        <p class="text-lg font-semibold" id="currentTime"></p>
                    </div>
                </div>
            </div>
        </header>

        <main class="p-6 max-w-7xl mx-auto space-y-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @php
                    $stats = [
                        [
                            'title' => 'Status Pelanggan',
                            'value' => Auth::user()->status_pelanggan ?? 'TIDAK AKTIF',
                            'icon' => Auth::user()->status_pelanggan === 'AKTIF' ? 'fa-user-check' : 'fa-user-times',
                            'color' => Auth::user()->status_pelanggan === 'AKTIF' ? 'green' : 'red',
                            'bg' => Auth::user()->status_pelanggan === 'AKTIF' ? 'bg-pdam-lightest' : 'bg-red-50'
                        ],
                        [
                            'title' => 'Pemakaian Bulan Ini',
                            'value' => (Auth::user()->total_pemakaian_m3 ?? 0) . ' m³',
                            'icon' => 'fa-tint',
                            'color' => 'blue',
                            'bg' => 'bg-pdam-lightest'
                        ],
                        [
                            'title' => 'Status Meter',
                            'value' => Auth::user()->status_meter ?? 'Normal',
                            'icon' => 'fa-tachometer-alt',
                            'color' => 'blue',
                            'bg' => 'bg-pdam-lightest'
                        ]
                    ];
                @endphp

                @foreach($stats as $index => $stat)
                <div class="glass-effect rounded-2xl p-6 interactive-card animate-fade-in" style="animation-delay: {{ $index * 0.1 }}s">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-2">{{ $stat['title'] }}</p>
                            <p class="text-xl font-bold {{ $stat['color'] === 'green' ? 'text-emerald-600' : ($stat['color'] === 'red' ? 'text-red-600' : 'text-pdam-dark') }}">
                                {{ $stat['value'] }}
                            </p>
                        </div>
                        <div class="relative {{ $stat['bg'] }} rounded-2xl w-16 h-16 flex items-center justify-center animate-float">
                            <i class="fas {{ $stat['icon'] }} text-2xl {{ $stat['color'] === 'green' ? 'text-emerald-600' : ($stat['color'] === 'red' ? 'text-red-600' : 'text-pdam-blue') }}"></i>
                            @if($stat['color'] === 'green')
                            <div class="absolute -top-1 -right-1 w-4 h-4 bg-emerald-500 rounded-full pulse-dot"></div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                <!-- Profile Card -->
                <div class="xl:col-span-1">
                    <div class="glass-effect rounded-3xl p-8 interactive-card animate-slide-up h-full">
                        <div class="text-center mb-6">
                            <div class="w-24 h-24 pdam-gradient rounded-full mx-auto mb-4 flex items-center justify-center animate-bounce-gentle shadow-xl">
                                <i class="fas fa-user text-white text-4xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold gradient-text">{{ Auth::user()->nama_pelanggan ?? 'Pelanggan' }}</h3>
                            <p class="text-pdam-dark font-medium">ID: {{ Auth::user()->id_pel ?? 'N/A' }}</p>
                        </div>

                        <div class="space-y-4">
                            @php
                                $profileData = [
                                    ['icon' => 'fa-map-marker-alt', 'label' => 'Alamat', 'value' => Auth::user()->alamat],
                                    ['icon' => 'fa-layer-group', 'label' => 'Golongan Tarif', 'value' => Auth::user()->goltar],
                                    ['icon' => 'fa-calendar', 'label' => 'Periode Terakhir', 'value' => Auth::user()->periode_terakhir]
                                ];
                            @endphp

                            @foreach($profileData as $data)
                                @if($data['value'])
                                <div class="flex items-center space-x-4 p-4 pdam-gradient-light rounded-xl hover:shadow-lg transition-all duration-300">
                                    <div class="w-10 h-10 bg-pdam-blue rounded-lg flex items-center justify-center">
                                        <i class="fas {{ $data['icon'] }} text-white"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-pdam-dark font-medium">{{ $data['label'] }}</p>
                                        <p class="font-semibold text-gray-800">{{ $data['value'] }}</p>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>

                        <!-- Quick Actions -->
                        <div class="mt-8 grid grid-cols-2 gap-4">
                            @php
                                $actions = [
                                    ['route' => 'cektagihan', 'icon' => 'fa-file-invoice', 'label' => 'Cek Tagihan', 'color' => 'pdam-dark'],
                                    ['route' => 'pengaduanpelanggan', 'icon' => 'fa-headset', 'label' => 'Pengaduan', 'color' => 'pdam-blue']
                                ];
                            @endphp

                            @foreach($actions as $action)
                            <a href="{{ route($action['route']) }}" class="group flex flex-col items-center p-4 bg-{{ $action['color'] }} text-white rounded-xl hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                <i class="fas {{ $action['icon'] }} text-2xl mb-2 group-hover:animate-bounce-gentle"></i>
                                <span class="text-sm font-medium">{{ $action['label'] }}</span>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="xl:col-span-2 space-y-8">
                    <!-- Billing Alert -->
                    @if((Auth::user()->total_tagihan ?? 0) > 0)
                    <div class="glass-effect rounded-3xl overflow-hidden interactive-card animate-slide-up border-l-4 border-red-500">
                        <div class="bg-gradient-to-r from-red-500 to-orange-500 p-6 text-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-xl font-bold flex items-center">
                                        <i class="fas fa-exclamation-triangle mr-3 animate-bounce-gentle"></i>
                                        Tagihan Tertunggak
                                    </h3>
                                    <p class="text-red-100 mt-1">Segera lakukan pembayaran</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-3xl font-bold">Rp {{ number_format(Auth::user()->total_tagihan, 0, ',', '.') }}</div>
                                    <div class="text-red-100 text-sm">Total Tagihan</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Pengaduan Section -->
                    <div class="glass-effect rounded-3xl interactive-card animate-slide-up">
                        <div class="p-6 border-b border-pdam-light/50">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <h3 class="text-2xl font-bold gradient-text flex items-center">
                                    <i class="fas fa-ticket-alt mr-3 text-pdam-blue animate-wave"></i>
                                    Tiket Pengaduan Saya
                                </h3>
                                <div class="flex items-center space-x-3">
                                    <span class="bg-pdam-blue text-white px-4 py-2 rounded-full text-sm font-medium animate-bounce-gentle">
                                        {{ isset($riwayat_pengaduan) ? $riwayat_pengaduan->count() : 0 }} tiket
                                    </span>
                                    <button onclick="openTrackModal()" class="bg-pdam-light hover:bg-pdam-blue text-pdam-dark hover:text-white px-4 py-2 rounded-xl text-sm transition-all duration-300 transform hover:scale-105">
                                        <i class="fas fa-search mr-2"></i>Lacak
                                    </button>
                                    <a href="{{ route('pengaduanpelanggan') }}" class="bg-pdam-dark hover:bg-pdam-blue text-white px-4 py-2 rounded-xl text-sm transition-all duration-300 transform hover:scale-105">
                                        <i class="fas fa-plus mr-2"></i>Buat
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            @if(isset($riwayat_pengaduan) && $riwayat_pengaduan->count() > 0)
                                <div class="space-y-4">
                                    @foreach($riwayat_pengaduan->take(3) as $pengaduan)
                                    <div class="group border-2 border-pdam-light hover:border-pdam-blue rounded-2xl p-4 interactive-card" onclick="openTrackModal('{{ $pengaduan->ticket_number }}')">
                                        <div class="flex items-start justify-between">
                                            <div class="flex items-center space-x-4">
                                                <div class="w-12 h-12 pdam-gradient rounded-xl flex items-center justify-center group-hover:animate-bounce-gentle">
                                                    <i class="fas fa-ticket-alt text-white"></i>
                                                </div>
                                                <div>
                                                    <div class="flex items-center space-x-2 mb-1">
                                                        <h4 class="font-bold text-gray-900 group-hover:text-pdam-dark">{{ $pengaduan->ticket_number }}</h4>
                                                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $pengaduan->status_class ?? 'bg-gray-100 text-gray-800' }}">
                                                            {{ ucfirst($pengaduan->status) }}
                                                        </span>
                                                    </div>
                                                    <p class="text-sm text-gray-600 line-clamp-1">{{ $pengaduan->judul }}</p>
                                                    <p class="text-xs text-gray-500 mt-1">
                                                        <i class="fas fa-calendar mr-1"></i>{{ $pengaduan->tanggal_relative ?? $pengaduan->created_at->diffForHumans() }}
                                                    </p>
                                                </div>
                                            </div>
                                            <i class="fas fa-chevron-right text-pdam-blue opacity-0 group-hover:opacity-100 transition-all duration-300"></i>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <div class="w-20 h-20 pdam-gradient-light rounded-3xl mx-auto mb-4 flex items-center justify-center animate-float">
                                        <i class="fas fa-ticket-alt text-pdam-blue text-3xl"></i>
                                    </div>
                                    <h4 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Tiket</h4>
                                    <p class="text-gray-600 mb-6">Buat pengaduan pertama Anda</p>
                                    <a href="{{ route('pengaduanpelanggan') }}" class="inline-flex items-center px-6 py-3 pdam-gradient text-white rounded-xl hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                        <i class="fas fa-plus mr-2"></i>Buat Pengaduan
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Water Usage Monitoring -->
                    <div class="glass-effect rounded-3xl p-6 interactive-card animate-slide-up">
                        <h3 class="text-xl font-bold gradient-text mb-6 flex items-center">
                            <i class="fas fa-chart-line text-pdam-blue mr-3 animate-wave"></i>
                            Monitoring Pemakaian
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @php
                                $monitoringData = [
                                    [
                                        'title' => 'Stand Meter',
                                        'value' => Auth::user()->angka_meter_kini ?? 0,
                                        'icon' => 'fa-tachometer-alt',
                                        'color' => 'blue'
                                    ],
                                    [
                                        'title' => 'Efisiensi',
                                        'value' => (Auth::user()->total_pemakaian_m3 ?? 0) <= 10 ? 'Hemat' : 'Normal',
                                        'icon' => 'fa-leaf',
                                        'color' => 'green'
                                    ]
                                ];
                            @endphp

                            @foreach($monitoringData as $data)
                            <div class="text-center p-6 pdam-gradient-light rounded-2xl hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                                <div class="w-16 h-16 pdam-gradient rounded-2xl mx-auto mb-4 flex items-center justify-center animate-float">
                                    <i class="fas {{ $data['icon'] }} text-white text-2xl"></i>
                                </div>
                                <p class="text-sm font-medium text-gray-600 mb-1">{{ $data['title'] }}</p>
                                <p class="text-2xl font-bold text-pdam-dark">{{ $data['value'] }}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Lacak Pengaduan -->
    <div id="trackModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4 backdrop-blur-sm">
        <div class="glass-effect rounded-3xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-hidden animate-slide-up">
            <div class="pdam-gradient p-6 text-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-search text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold">Lacak Pengaduan</h3>
                            <p class="text-pdam-light text-sm">Masukkan nomor tiket untuk melacak status</p>
                        </div>
                    </div>
                    <button onclick="closeTrackModal()" class="text-white hover:text-red-300 transition-colors text-2xl">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <div class="p-6 overflow-y-auto max-h-[calc(90vh-120px)]">
                <form id="trackForm" class="mb-6">
                    <div class="relative">
                        <input type="text" id="trackTicketNumber" placeholder="Contoh: PDAM20250101001" 
                               class="w-full border-2 border-pdam-light rounded-2xl px-6 py-4 pr-16 focus:outline-none focus:border-pdam-blue focus:ring-4 focus:ring-pdam-light transition-all text-lg">
                        <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-pdam-blue text-white px-6 py-2 rounded-xl hover:bg-pdam-dark transition-colors">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>

                <div id="trackLoading" class="hidden text-center py-12">
                    <div class="inline-flex items-center space-x-3 text-pdam-blue">
                        <i class="fas fa-spinner fa-spin text-3xl"></i>
                        <span class="text-xl font-medium">Mencari pengaduan...</span>
                    </div>
                </div>

                <div id="trackResult" class="hidden"></div>

                <div id="trackEmpty" class="text-center py-12">
                    <div class="w-24 h-24 pdam-gradient-light rounded-3xl mx-auto mb-4 flex items-center justify-center animate-float">
                        <i class="fas fa-search text-pdam-blue text-3xl"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2">Masukkan Nomor Tiket</h4>
                    <p class="text-gray-600">Ketik nomor tiket untuk melihat detail pengaduan</p>
                </div>

                <div id="trackError" class="hidden text-center py-12">
                    <div class="w-24 h-24 bg-red-50 rounded-3xl mx-auto mb-4 flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-red-500 text-3xl"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2">Pengaduan Tidak Ditemukan</h4>
                    <p class="text-gray-600 mb-4">Periksa kembali nomor tiket yang Anda masukkan</p>
                    <button onclick="resetTrackModal()" class="text-pdam-blue hover:text-pdam-dark font-medium">Coba Lagi</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Update time
        function updateTime() {
            document.getElementById('currentTime').textContent = new Date().toLocaleTimeString('id-ID', {
                hour: '2-digit', minute: '2-digit', second: '2-digit'
            });
        }
        updateTime();
        setInterval(updateTime, 1000);

        // Modal functions
        function openTrackModal(ticketNumber = '') {
            document.getElementById('trackModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            if (ticketNumber) {
                document.getElementById('trackTicketNumber').value = ticketNumber;
                setTimeout(() => searchTicket(ticketNumber), 300);
            } else {
                resetTrackModal();
            }
            
            setTimeout(() => document.getElementById('trackTicketNumber').focus(), 100);
        }

        function closeTrackModal() {
            document.getElementById('trackModal').classList.add('hidden');
            document.body.style.overflow = '';
            resetTrackModal();
        }

        function resetTrackModal() {
            document.getElementById('trackTicketNumber').value = '';
            ['trackLoading', 'trackResult', 'trackError'].forEach(id => document.getElementById(id).classList.add('hidden'));
            document.getElementById('trackEmpty').classList.remove('hidden');
        }

        function searchTicket(ticketNumber) {
            // Toggle states
            ['trackEmpty', 'trackError', 'trackResult'].forEach(id => document.getElementById(id).classList.add('hidden'));
            document.getElementById('trackLoading').classList.remove('hidden');
            
            fetch('/pengaduan/track-result', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ ticket_number: ticketNumber })
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('trackLoading').classList.add('hidden');
                data.success ? displayTrackResult(data.pengaduan) : document.getElementById('trackError').classList.remove('hidden');
            })
            .catch(() => {
                document.getElementById('trackLoading').classList.add('hidden');
                document.getElementById('trackError').classList.remove('hidden');
            });
        }

        function displayTrackResult(pengaduan) {
            const statusColors = {
                'pending': 'bg-yellow-100 text-yellow-800',
                'diproses': 'bg-blue-100 text-blue-800', 
                'selesai': 'bg-green-100 text-green-800',
                'ditutup': 'bg-gray-100 text-gray-800'
            };

            document.getElementById('trackResult').innerHTML = `
                <div class="pdam-gradient-light rounded-2xl p-6 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">${pengaduan.ticket_number}</h3>
                            <p class="text-gray-600">${pengaduan.judul}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-sm font-medium ${statusColors[pengaduan.status] || statusColors.ditutup}">
                            ${pengaduan.status.charAt(0).toUpperCase() + pengaduan.status.slice(1)}
                        </span>
                    </div>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div><span class="text-gray-500">Tanggal:</span> <span class="font-medium">${new Date(pengaduan.created_at).toLocaleDateString('id-ID')}</span></div>
                        <div><span class="text-gray-500">Kategori:</span> <span class="font-medium">${pengaduan.kategori.replace(/_/g, ' ')}</span></div>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div class="bg-white border border-gray-200 rounded-2xl p-4">
                        <h4 class="font-semibold text-gray-900 mb-2">Detail Pengaduan</h4>
                        <p class="text-gray-700">${pengaduan.detail_pengaduan}</p>
                    </div>
                    
                    ${pengaduan.response_admin ? `
                        <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4">
                            <h4 class="font-semibold text-blue-900 mb-2 flex items-center">
                                <i class="fas fa-user-shield mr-2"></i>Respon Admin
                            </h4>
                            <p class="text-blue-800">${pengaduan.response_admin}</p>
                        </div>
                    ` : ''}
                </div>
            `;
            document.getElementById('trackResult').classList.remove('hidden');
        }

        // Form handler
        document.getElementById('trackForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const ticketNumber = document.getElementById('trackTicketNumber').value.trim();
            if (ticketNumber) searchTicket(ticketNumber);
            else alert('Silakan masukkan nomor tiket');
        });

        // Modal close handlers
        document.getElementById('trackModal').addEventListener('click', function(e) {
            if (e.target === this) closeTrackModal();
        });
        
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeTrackModal();
        });
    </script>
</body>
</html>