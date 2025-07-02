@php
    $user = Auth::user();
    $isAdmin = $user && $user->role === 'admin';
@endphp

<!-- Mobile Menu Button -->
<button id="mobileMenuBtn" class="lg:hidden fixed top-4 left-4 z-50 bg-[#10283a] text-white p-3 rounded-lg shadow-lg hover:bg-[#1e355e] transition-all duration-300">
    <i class="fas fa-bars text-lg"></i>
</button>

<!-- Sidebar Overlay for Mobile -->
<div id="sidebarOverlay" class="lg:hidden fixed inset-0 bg-black bg-opacity-50 z-40 hidden"></div>

<!-- Sidebar -->
<aside id="sidebar" class="fixed top-0 left-0 w-72 bg-gradient-to-b from-[#10283a] to-[#1e355e] h-full flex flex-col shadow-2xl z-30 transition-transform duration-300 ease-in-out transform -translate-x-full lg:translate-x-0">
    <!-- Sidebar Header -->
    <div class="flex items-center justify-between p-6 border-b border-[#2a4a6b]">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-[#6bb6d6] rounded-full flex items-center justify-center shadow-lg">
                <i class="fas fa-tint text-white text-lg"></i>
            </div>
            <div id="sidebarText">
                <h3 class="text-white font-bold text-lg">PDAM</h3>
                <p class="text-[#92CEE6] text-xs">{{ $isAdmin ? 'Admin Panel' : 'Water Management' }}</p>
            </div>
        </div>
        
        <!-- Desktop Toggle Button -->
        <button id="desktopToggleBtn" class="hidden lg:block text-white hover:text-[#6bb6d6] transition-colors duration-200">
            <i class="fas fa-angle-left text-xl" id="toggleIcon"></i>
        </button>
        
        <!-- Mobile Close Button -->
        <button id="mobileCloseBtn" class="lg:hidden text-white hover:text-red-400 transition-colors duration-200">
            <i class="fas fa-times text-xl"></i>
        </button>
    </div>

    <!-- User Profile Section -->
    <div class="flex flex-col items-center py-6 px-4 border-b border-[#2a4a6b]">
        <div class="relative">
            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-[#6bb6d6] to-[#5090b3] flex items-center justify-center text-2xl font-bold text-white mb-3 shadow-lg">
                {{ strtoupper(substr($user->nama_pelanggan ?? 'U', 0, 1)) }}
            </div>
            <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-400 rounded-full border-2 border-white"></div>
        </div>
        <div class="text-center" id="userInfo">
            <div class="text-white font-semibold text-base">
                {{ $user->nama_pelanggan ?? 'User' }}
            </div>
            <div class="text-[#92CEE6] text-xs mt-1">
                {{ $isAdmin ? 'Administrator' : 'Pelanggan' }}
            </div>
            @if(!$isAdmin)
            <div class="text-[#92CEE6] text-xs">
                ID: {{ $user->id_pel }}
            </div>
            @endif
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 py-4 px-2 overflow-y-auto">
        <div class="space-y-2">
            @if($isAdmin)
                <!-- Admin Menu -->
                <a href="{{ route('admin.dashboard') }}" class="nav-item flex items-center gap-4 text-white font-medium px-4 py-3 rounded-xl hover:bg-[#2a4a6b] hover:text-[#6bb6d6] transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-[#2a4a6b] text-[#6bb6d6] border-r-4 border-[#6bb6d6]' : '' }}">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-[#2a4a6b]">
                        <i class="fas fa-chart-pie text-lg"></i>
                    </div>
                    <span class="nav-text">Dashboard</span>
                </a>
                
                <a href="{{ route('admin.pengaduan.index') }}" class="nav-item flex items-center gap-4 text-white font-medium px-4 py-3 rounded-xl hover:bg-[#2a4a6b] hover:text-[#6bb6d6] transition-all duration-200 {{ request()->routeIs('admin.pengaduan.*') ? 'bg-[#2a4a6b] text-[#6bb6d6] border-r-4 border-[#6bb6d6]' : '' }}">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-[#2a4a6b]">
                        <i class="fas fa-headset text-lg"></i>
                    </div>
                    <span class="nav-text">Kelola Pengaduan</span>
                </a>
                
                <a href="{{ route('isitagihan') }}" class="nav-item flex items-center gap-4 text-white font-medium px-4 py-3 rounded-xl hover:bg-[#2a4a6b] hover:text-[#6bb6d6] transition-all duration-200 {{ request()->routeIs('isitagihan') ? 'bg-[#2a4a6b] text-[#6bb6d6] border-r-4 border-[#6bb6d6]' : '' }}">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-[#2a4a6b]">
                        <i class="fas fa-file-invoice-dollar text-lg"></i>
                    </div>
                    <span class="nav-text">Kelola Tagihan</span>
                </a>
                
                <a href="{{ route('admin.data-pelanggan') }}" class="nav-item flex items-center gap-4 text-white font-medium px-4 py-3 rounded-xl hover:bg-[#2a4a6b] hover:text-[#6bb6d6] transition-all duration-200 {{ request()->routeIs('admin.data-pelanggan') ? 'bg-[#2a4a6b] text-[#6bb6d6] border-r-4 border-[#6bb6d6]' : '' }}">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-[#2a4a6b]">
                        <i class="fas fa-users text-lg"></i>
                    </div>
                    <span class="nav-text">Data Pelanggan</span>
                </a>
                
                <a href="#" class="nav-item flex items-center gap-4 text-white font-medium px-4 py-3 rounded-xl hover:bg-[#2a4a6b] hover:text-[#6bb6d6] transition-all duration-200">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-[#2a4a6b]">
                        <i class="fas fa-chart-bar text-lg"></i>
                    </div>
                    <span class="nav-text">Laporan</span>
                </a>
            @else
                <!-- User Menu -->
                <a href="{{ route('dashboardmasyarakat') }}" class="nav-item flex items-center gap-4 text-white font-medium px-4 py-3 rounded-xl hover:bg-[#2a4a6b] hover:text-[#6bb6d6] transition-all duration-200 {{ request()->routeIs('dashboardmasyarakat') ? 'bg-[#2a4a6b] text-[#6bb6d6] border-r-4 border-[#6bb6d6]' : '' }}">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-[#2a4a6b]">
                        <i class="fas fa-house-chimney text-lg"></i>
                    </div>
                    <span class="nav-text">Dashboard</span>
                </a>
                
                <a href="{{ route('cektagihan') }}" class="nav-item flex items-center gap-4 text-white font-medium px-4 py-3 rounded-xl hover:bg-[#2a4a6b] hover:text-[#6bb6d6] transition-all duration-200 {{ request()->routeIs('cektagihan') ? 'bg-[#2a4a6b] text-[#6bb6d6] border-r-4 border-[#6bb6d6]' : '' }}">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-[#2a4a6b]">
                        <i class="fas fa-file-invoice text-lg"></i>
                    </div>
                    <span class="nav-text">Cek Tagihan</span>
                </a>
                
                <a href="{{ route('pengaduanpelanggan') }}" class="nav-item flex items-center gap-4 text-white font-medium px-4 py-3 rounded-xl hover:bg-[#2a4a6b] hover:text-[#6bb6d6] transition-all duration-200 {{ request()->routeIs('pengaduanpelanggan') || request()->routeIs('pengaduan.*') ? 'bg-[#2a4a6b] text-[#6bb6d6] border-r-4 border-[#6bb6d6]' : '' }}">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-[#2a4a6b]">
                        <i class="fas fa-headset text-lg"></i>
                    </div>
                    <span class="nav-text">Pengaduan</span>
                </a>
                
                <button onclick="openTrackModal()" class="nav-item w-full flex items-center gap-4 text-white font-medium px-4 py-3 rounded-xl hover:bg-[#2a4a6b] hover:text-[#6bb6d6] transition-all duration-200">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-[#2a4a6b]">
                        <i class="fas fa-search text-lg"></i>
                    </div>
                    <span class="nav-text">Lacak Pengaduan</span>
                </button>
                
                <a href="#" class="nav-item flex items-center gap-4 text-white font-medium px-4 py-3 rounded-xl hover:bg-[#2a4a6b] hover:text-[#6bb6d6] transition-all duration-200 {{ request()->routeIs('user.profil') ? 'bg-[#2a4a6b] text-[#6bb6d6] border-r-4 border-[#6bb6d6]' : '' }}">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-[#2a4a6b]">
                        <i class="fas fa-user-circle text-lg"></i>
                    </div>
                    <span class="nav-text">Profil</span>
                </a>
            @endif
        </div>
    </nav>

    <!-- Logout Section -->
    <div class="p-4 border-t border-[#2a4a6b]">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-4 text-red-400 font-medium px-4 py-3 rounded-xl hover:bg-red-500 hover:text-white transition-all duration-200">
                <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-red-500/20">
                    <i class="fas fa-right-from-bracket text-lg"></i>
                </div>
                <span class="nav-text">Logout</span>
            </button>
        </form>
    </div>
</aside>

<!-- Modal Lacak Pengaduan -->
<div id="trackModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-hidden">
        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-[#10283a] to-[#1e355e] p-6 text-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-[#6bb6d6] rounded-lg flex items-center justify-center">
                        <i class="fas fa-search text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold">Lacak Pengaduan</h3>
                        <p class="text-[#92CEE6] text-sm">Masukkan nomor tiket untuk melacak status pengaduan</p>
                    </div>
                </div>
                <button onclick="closeTrackModal()" class="text-white hover:text-red-400 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Modal Body -->
        <div class="p-6 overflow-y-auto max-h-[calc(90vh-120px)]">
            <!-- Search Form -->
            <form id="trackForm" class="mb-6">
                <div class="relative">
                    <input type="text" 
                           id="trackTicketNumber" 
                           placeholder="Contoh: PDAM20250101001"
                           class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 pr-12 focus:outline-none focus:border-[#6bb6d6] focus:ring-2 focus:ring-[#6bb6d6]/20 transition-all">
                    <button type="submit" 
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-[#6bb6d6] text-white px-4 py-2 rounded-lg hover:bg-[#5090b3] transition-colors">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>

            <!-- Loading State -->
            <div id="trackLoading" class="hidden text-center py-8">
                <div class="inline-flex items-center space-x-2 text-[#6bb6d6]">
                    <i class="fas fa-spinner fa-spin text-2xl"></i>
                    <span class="text-lg font-medium">Mencari pengaduan...</span>
                </div>
            </div>

            <!-- Result Container -->
            <div id="trackResult" class="hidden">
                <!-- Result akan dimuat di sini -->
            </div>

            <!-- Empty State -->
            <div id="trackEmpty" class="text-center py-12">
                <div class="w-20 h-20 bg-gray-100 rounded-2xl mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-search text-gray-400 text-2xl"></i>
                </div>
                <h4 class="text-lg font-semibold text-gray-900 mb-2">Masukkan Nomor Tiket</h4>
                <p class="text-gray-600 max-w-md mx-auto">
                    Masukkan nomor tiket pengaduan untuk melihat status dan detail pengaduan Anda.
                </p>
            </div>

            <!-- Error State -->
            <div id="trackError" class="hidden text-center py-8">
                <div class="w-20 h-20 bg-red-100 rounded-2xl mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-red-500 text-2xl"></i>
                </div>
                <h4 class="text-lg font-semibold text-gray-900 mb-2">Pengaduan Tidak Ditemukan</h4>
                <p class="text-gray-600 max-w-md mx-auto mb-4">
                    Nomor tiket yang Anda masukkan tidak ditemukan. Pastikan nomor tiket sudah benar.
                </p>
                <button onclick="resetTrackModal()" class="text-[#6bb6d6] hover:text-[#5090b3] font-medium">
                    Coba Lagi
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileCloseBtn = document.getElementById('mobileCloseBtn');
    const desktopToggleBtn = document.getElementById('desktopToggleBtn');
    const toggleIcon = document.getElementById('toggleIcon');
    const sidebarText = document.getElementById('sidebarText');
    const userInfo = document.getElementById('userInfo');
    const navTexts = document.querySelectorAll('.nav-text');
    
    let isCollapsed = false;
    
    // Mobile menu toggle
    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', function() {
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
            overlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });
    }
    
    // Mobile close
    function closeMobileSidebar() {
        sidebar.classList.remove('translate-x-0');
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
        document.body.style.overflow = '';
    }
    
    if (mobileCloseBtn) {
        mobileCloseBtn.addEventListener('click', closeMobileSidebar);
    }
    
    if (overlay) {
        overlay.addEventListener('click', closeMobileSidebar);
    }
    
    // Desktop toggle
    if (desktopToggleBtn) {
        desktopToggleBtn.addEventListener('click', function() {
            isCollapsed = !isCollapsed;
            
            if (isCollapsed) {
                sidebar.style.width = '5rem';
                sidebarText.style.display = 'none';
                userInfo.style.display = 'none';
                navTexts.forEach(text => text.style.display = 'none');
                toggleIcon.classList.remove('fa-angle-left');
                toggleIcon.classList.add('fa-angle-right');
            } else {
                sidebar.style.width = '18rem';
                sidebarText.style.display = 'block';
                userInfo.style.display = 'block';
                navTexts.forEach(text => text.style.display = 'block');
                toggleIcon.classList.remove('fa-angle-right');
                toggleIcon.classList.add('fa-angle-left');
            }
            
            localStorage.setItem('sidebarCollapsed', isCollapsed);
        });
    }
    
    // Load saved state
    const savedState = localStorage.getItem('sidebarCollapsed');
    if (savedState === 'true' && window.innerWidth >= 1024) {
        desktopToggleBtn?.click();
    }
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 1024) {
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
            overlay.classList.add('hidden');
            document.body.style.overflow = '';
        } else {
            if (!sidebar.classList.contains('translate-x-0')) {
                sidebar.classList.add('-translate-x-full');
            }
            if (isCollapsed) {
                sidebar.style.width = '18rem';
                sidebarText.style.display = 'block';
                userInfo.style.display = 'block';
                navTexts.forEach(text => text.style.display = 'block');
            }
        }
    });
});

// Modal Functions
function openTrackModal(ticketNumber = '') {
    document.getElementById('trackModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    if (ticketNumber) {
        document.getElementById('trackTicketNumber').value = ticketNumber;
        // Auto search if ticket number provided
        setTimeout(() => {
            document.getElementById('trackForm').dispatchEvent(new Event('submit'));
        }, 300);
    } else {
        resetTrackModal();
    }
    
    // Focus on input
    setTimeout(() => {
        document.getElementById('trackTicketNumber').focus();
    }, 100);
}

function closeTrackModal() {
    document.getElementById('trackModal').classList.add('hidden');
    document.body.style.overflow = '';
    resetTrackModal();
}

function resetTrackModal() {
    document.getElementById('trackTicketNumber').value = '';
    document.getElementById('trackLoading').classList.add('hidden');
    document.getElementById('trackResult').classList.add('hidden');
    document.getElementById('trackError').classList.add('hidden');
    document.getElementById('trackEmpty').classList.remove('hidden');
}

// Track Form Handler
document.getElementById('trackForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const ticketNumber = document.getElementById('trackTicketNumber').value.trim();
    if (!ticketNumber) {
        alert('Silakan masukkan nomor tiket');
        return;
    }
    
    // Show loading
    document.getElementById('trackEmpty').classList.add('hidden');
    document.getElementById('trackError').classList.add('hidden');
    document.getElementById('trackResult').classList.add('hidden');
    document.getElementById('trackLoading').classList.remove('hidden');
    
    // AJAX request
    fetch('{{ route("pengaduan.track.result") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            ticket_number: ticketNumber
        })
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('trackLoading').classList.add('hidden');
        
        if (data.success) {
            displayTrackResult(data.pengaduan);
        } else {
            document.getElementById('trackError').classList.remove('hidden');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('trackLoading').classList.add('hidden');
        document.getElementById('trackError').classList.remove('hidden');
    });
});

function displayTrackResult(pengaduan) {
    const resultContainer = document.getElementById('trackResult');
    
    const statusClass = getStatusClass(pengaduan.status);
    const prioritasClass = getPriorityClass(pengaduan.prioritas);
    
    resultContainer.innerHTML = `
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">${pengaduan.ticket_number}</h3>
                    <p class="text-gray-600">${pengaduan.judul}</p>
                </div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ${statusClass}">
                    ${pengaduan.status.charAt(0).toUpperCase() + pengaduan.status.slice(1)}
                </span>
            </div>
            
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-gray-500">Tanggal:</span>
                    <span class="font-medium">${new Date(pengaduan.created_at).toLocaleDateString('id-ID')}</span>
                </div>
                <div>
                    <span class="text-gray-500">Kategori:</span>
                    <span class="font-medium">${pengaduan.kategori.replace(/_/g, ' ')}</span>
                </div>
            </div>
        </div>
        
        <div class="space-y-4">
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <h4 class="font-semibold text-gray-900 mb-2">Detail Pengaduan</h4>
                <p class="text-gray-700">${pengaduan.detail_pengaduan}</p>
            </div>
            
            ${pengaduan.response_admin ? `
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                    <h4 class="font-semibold text-blue-900 mb-2 flex items-center">
                        <i class="fas fa-user-shield mr-2"></i>
                        Respon Admin
                    </h4>
                    <p class="text-blue-800">${pengaduan.response_admin}</p>
                    ${pengaduan.tanggal_response ? `
                        <p class="text-xs text-blue-600 mt-2">
                            Direspon pada: ${new Date(pengaduan.tanggal_response).toLocaleDateString('id-ID')}
                        </p>
                    ` : ''}
                </div>
            ` : ''}
            
            <div class="bg-gray-50 rounded-xl p-4">
                <h4 class="font-semibold text-gray-900 mb-3">Timeline</h4>
                <div class="space-y-3">
                    <div class="flex items-center space-x-3">
                        <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                        <div>
                            <p class="text-sm font-medium">Pengaduan Dibuat</p>
                            <p class="text-xs text-gray-500">${new Date(pengaduan.created_at).toLocaleDateString('id-ID')}</p>
                        </div>
                    </div>
                    
                    ${pengaduan.status !== 'pending' ? `
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                            <div>
                                <p class="text-sm font-medium">Status: ${pengaduan.status}</p>
                                <p class="text-xs text-gray-500">${new Date(pengaduan.updated_at).toLocaleDateString('id-ID')}</p>
                            </div>
                        </div>
                    ` : ''}
                    
                    ${pengaduan.tanggal_response ? `
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                            <div>
                                <p class="text-sm font-medium">Admin Merespon</p>
                                <p class="text-xs text-gray-500">${new Date(pengaduan.tanggal_response).toLocaleDateString('id-ID')}</p>
                            </div>
                        </div>
                    ` : ''}
                </div>
            </div>
        </div>
    `;
    
    resultContainer.classList.remove('hidden');
}

function getStatusClass(status) {
    switch(status) {
        case 'pending': return 'bg-yellow-100 text-yellow-800';
        case 'diproses': return 'bg-blue-100 text-blue-800';
        case 'selesai': return 'bg-green-100 text-green-800';
        case 'ditutup': return 'bg-gray-100 text-gray-800';
        default: return 'bg-gray-100 text-gray-800';
    }
}

function getPriorityClass(prioritas) {
    switch(prioritas) {
        case 'tinggi': return 'bg-red-100 text-red-800';
        case 'sedang': return 'bg-yellow-100 text-yellow-800';
        case 'rendah': return 'bg-green-100 text-green-800';
        default: return 'bg-gray-100 text-gray-800';
    }
}

// Close modal when clicking outside
document.getElementById('trackModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeTrackModal();
    }
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeTrackModal();
    }
});
</script>