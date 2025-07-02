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
                <a href="{{ route('dashboardadmin') }}" class="nav-item flex items-center gap-4 text-white font-medium px-4 py-3 rounded-xl hover:bg-[#2a4a6b] hover:text-[#6bb6d6] transition-all duration-200 {{ request()->routeIs('dashboardadmin') ? 'bg-[#2a4a6b] text-[#6bb6d6] border-r-4 border-[#6bb6d6]' : '' }}">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-[#2a4a6b]">
                        <i class="fas fa-chart-pie text-lg"></i>
                    </div>
                    <span class="nav-text">Dashboard</span>
                </a>
                
                <a href="#" class="nav-item flex items-center gap-4 text-white font-medium px-4 py-3 rounded-xl hover:bg-[#2a4a6b] hover:text-[#6bb6d6] transition-all duration-200">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-[#2a4a6b]">
                        <i class="fas fa-file-invoice-dollar text-lg"></i>
                    </div>
                    <span class="nav-text">Kelola Tagihan</span>
                </a>
                
                <a href="#" class="nav-item flex items-center gap-4 text-white font-medium px-4 py-3 rounded-xl hover:bg-[#2a4a6b] hover:text-[#6bb6d6] transition-all duration-200">
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
                
                <a href="#" class="nav-item flex items-center gap-4 text-white font-medium px-4 py-3 rounded-xl hover:bg-[#2a4a6b] hover:text-[#6bb6d6] transition-all duration-200">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-[#2a4a6b]">
                        <i class="fas fa-headset text-lg"></i>
                    </div>
                    <span class="nav-text">Pengaduan</span>
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
                
                <a href="{{ route('pengaduanpelanggan') }}" class="nav-item flex items-center gap-4 text-white font-medium px-4 py-3 rounded-xl hover:bg-[#2a4a6b] hover:text-[#6bb6d6] transition-all duration-200 {{ request()->routeIs('user.pengaduan') ? 'bg-[#2a4a6b] text-[#6bb6d6] border-r-4 border-[#6bb6d6]' : '' }}">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-[#2a4a6b]">
                        <i class="fas fa-headset text-lg"></i>
                    </div>
                    <span class="nav-text">Pengaduan</span>
                </a>
                
                <a href="" class="nav-item flex items-center gap-4 text-white font-medium px-4 py-3 rounded-xl hover:bg-[#2a4a6b] hover:text-[#6bb6d6] transition-all duration-200 {{ request()->routeIs('user.profil') ? 'bg-[#2a4a6b] text-[#6bb6d6] border-r-4 border-[#6bb6d6]' : '' }}">
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
</script>