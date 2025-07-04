<nav class="fixed top-0 left-0 w-full z-50 transition-all duration-500" id="navbar">
    <!-- Main Navbar -->
    <div class="backdrop-blur-md bg-gradient-to-r from-[#005792]/90 to-[#53CDE2]/90 border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 lg:h-20">
                <!-- Logo Section -->
                <div class="flex items-center space-x-4 flex-shrink-0">
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-r from-[#53CDE2] to-[#D1F4FA] rounded-full blur-lg opacity-20 group-hover:opacity-40 transition-opacity duration-300"></div>
                        <img src="{{ asset('images/logo_pdam.png') }}" 
                             alt="PDAM Logo" 
                             class="relative h-12 w-12 lg:h-16 lg:w-16 bg-white/10 backdrop-blur-sm rounded-full p-2 shadow-2xl transition-all duration-300 group-hover:scale-110 group-hover:rotate-3">
                    </div>
                    <div class="hidden sm:block">
                        <div class="text-white font-bold text-lg lg:text-2xl tracking-tight">PDAM</div>
                        <div class="text-[#D1F4FA] text-xs lg:text-sm font-medium">Tirta Tamiang</div>
                    </div>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center">
                    <div class="flex space-x-1 bg-white/5 backdrop-blur-sm rounded-full p-1 border border-white/10">
                        <a href="#home" 
                           class="nav-link relative px-4 py-2 text-sm font-medium text-white/80 hover:text-white rounded-full transition-all duration-300 group">
                            <span class="relative z-10">Beranda</span>
                            <div class="absolute inset-0 bg-gradient-to-r from-[#53CDE2]/20 to-[#D1F4FA]/20 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </a>
                        <a href="#tentang" 
                           class="nav-link relative px-4 py-2 text-sm font-medium text-white/80 hover:text-white rounded-full transition-all duration-300 group">
                            <span class="relative z-10">Tentang</span>
                            <div class="absolute inset-0 bg-gradient-to-r from-[#53CDE2]/20 to-[#D1F4FA]/20 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </a>
                        <a href="#layanan" 
                           class="nav-link relative px-4 py-2 text-sm font-medium text-white/80 hover:text-white rounded-full transition-all duration-300 group">
                            <span class="relative z-10">Layanan</span>
                            <div class="absolute inset-0 bg-gradient-to-r from-[#53CDE2]/20 to-[#D1F4FA]/20 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </a>
                        <a href="#artikel" 
                           class="nav-link relative px-4 py-2 text-sm font-medium text-white/80 hover:text-white rounded-full transition-all duration-300 group">
                            <span class="relative z-10">Artikel</span>
                            <div class="absolute inset-0 bg-gradient-to-r from-[#53CDE2]/20 to-[#D1F4FA]/20 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </a>
                        <a href="#sejarah" 
                           class="nav-link relative px-4 py-2 text-sm font-medium text-white/80 hover:text-white rounded-full transition-all duration-300 group">
                            <span class="relative z-10">Sejarah</span>
                            <div class="absolute inset-0 bg-gradient-to-r from-[#53CDE2]/20 to-[#D1F4FA]/20 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </a>
                        <a href="#struktur-organisasi" 
                           class="nav-link relative px-4 py-2 text-sm font-medium text-white/80 hover:text-white rounded-full transition-all duration-300 group">
                            <span class="relative z-10">Organisasi</span>
                            <div class="absolute inset-0 bg-gradient-to-r from-[#53CDE2]/20 to-[#D1F4FA]/20 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </a>
                    </div>
                </div>

                <!-- Right Section -->
                <div class="flex items-center space-x-4">
                    <!-- Login Button -->
                    <a href="/login" 
                       class="group relative overflow-hidden bg-gradient-to-r from-[#53CDE2] to-[#D1F4FA] hover:from-[#005792] hover:to-[#53CDE2] text-[#005792] hover:text-white font-semibold px-6 py-2.5 lg:px-8 lg:py-3 rounded-full transition-all duration-300 transform hover:scale-105 hover:shadow-2xl hover:shadow-[#53CDE2]/25">
                        <div class="absolute inset-0 bg-gradient-to-r from-white/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <span class="relative flex items-center">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            <span class="hidden sm:inline">LOGIN</span>
                            <span class="sm:hidden">Login</span>
                        </span>
                    </a>

                    <!-- Mobile Menu Button -->
                    <button id="mobile-menu-button" 
                            class="lg:hidden relative group p-2 rounded-xl bg-white/10 backdrop-blur-sm border border-white/20 hover:bg-[#53CDE2]/20 focus:outline-none focus:ring-2 focus:ring-[#53CDE2]/50 transition-all duration-300">
                        <span class="sr-only">Open main menu</span>
                        <div class="relative w-6 h-6">
                            <div id="menu-icon" class="absolute inset-0 transition-all duration-300">
                                <div class="absolute top-1.5 left-0 w-6 h-0.5 bg-white rounded-full transition-all duration-300 group-hover:bg-[#D1F4FA]"></div>
                                <div class="absolute top-3 left-0 w-6 h-0.5 bg-white rounded-full transition-all duration-300 group-hover:bg-[#D1F4FA]"></div>
                                <div class="absolute top-4.5 left-0 w-6 h-0.5 bg-white rounded-full transition-all duration-300 group-hover:bg-[#D1F4FA]"></div>
                            </div>
                            <div id="close-icon" class="absolute inset-0 transition-all duration-300 opacity-0 rotate-180">
                                <div class="absolute top-3 left-0 w-6 h-0.5 bg-white rounded-full transform rotate-45"></div>
                                <div class="absolute top-3 left-0 w-6 h-0.5 bg-white rounded-full transform -rotate-45"></div>
                            </div>
                        </div>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div id="mobile-menu" class="lg:hidden absolute top-full left-0 w-full transition-all duration-500 transform origin-top scale-y-0 opacity-0">
            <div class="backdrop-blur-xl bg-[#005792]/95 border-t border-white/10 shadow-2xl">
                <div class="max-w-7xl mx-auto px-4 py-6">
                    <!-- Navigation Links -->
                    <div class="space-y-2 mb-6">
                        <a href="#home" 
                           class="mobile-nav-link group flex items-center px-4 py-3 text-white/80 hover:text-white rounded-xl hover:bg-white/10 transition-all duration-300">
                            <div class="w-10 h-10 rounded-lg bg-[#53CDE2]/20 flex items-center justify-center mr-3 group-hover:bg-[#53CDE2]/30 transition-colors duration-300">
                                <i class="fas fa-home text-[#D1F4FA]"></i>
                            </div>
                            <span class="font-medium">Beranda</span>
                        </a>
                        <a href="#tentang" 
                           class="mobile-nav-link group flex items-center px-4 py-3 text-white/80 hover:text-white rounded-xl hover:bg-white/10 transition-all duration-300">
                            <div class="w-10 h-10 rounded-lg bg-[#53CDE2]/20 flex items-center justify-center mr-3 group-hover:bg-[#53CDE2]/30 transition-colors duration-300">
                                <i class="fas fa-info-circle text-[#D1F4FA]"></i>
                            </div>
                            <span class="font-medium">Tentang</span>
                        </a>
                        <a href="#layanan" 
                           class="mobile-nav-link group flex items-center px-4 py-3 text-white/80 hover:text-white rounded-xl hover:bg-white/10 transition-all duration-300">
                            <div class="w-10 h-10 rounded-lg bg-[#53CDE2]/20 flex items-center justify-center mr-3 group-hover:bg-[#53CDE2]/30 transition-colors duration-300">
                                <i class="fas fa-cogs text-[#D1F4FA]"></i>
                            </div>
                            <span class="font-medium">Layanan</span>
                        </a>
                        <a href="#artikel" 
                           class="mobile-nav-link group flex items-center px-4 py-3 text-white/80 hover:text-white rounded-xl hover:bg-white/10 transition-all duration-300">
                            <div class="w-10 h-10 rounded-lg bg-[#53CDE2]/20 flex items-center justify-center mr-3 group-hover:bg-[#53CDE2]/30 transition-colors duration-300">
                                <i class="fas fa-newspaper text-[#D1F4FA]"></i>
                            </div>
                            <span class="font-medium">Artikel</span>
                        </a>
                        <a href="#sejarah" 
                           class="mobile-nav-link group flex items-center px-4 py-3 text-white/80 hover:text-white rounded-xl hover:bg-white/10 transition-all duration-300">
                            <div class="w-10 h-10 rounded-lg bg-[#53CDE2]/20 flex items-center justify-center mr-3 group-hover:bg-[#53CDE2]/30 transition-colors duration-300">
                                <i class="fas fa-history text-[#D1F4FA]"></i>
                            </div>
                            <span class="font-medium">Sejarah</span>
                        </a>
                        <a href="#struktur-organisasi" 
                           class="mobile-nav-link group flex items-center px-4 py-3 text-white/80 hover:text-white rounded-xl hover:bg-white/10 transition-all duration-300">
                            <div class="w-10 h-10 rounded-lg bg-[#53CDE2]/20 flex items-center justify-center mr-3 group-hover:bg-[#53CDE2]/30 transition-colors duration-300">
                                <i class="fas fa-sitemap text-[#D1F4FA]"></i>
                            </div>
                            <span class="font-medium">Organisasi</span>
                        </a>
                    </div>
                    
                    <!-- Quick Actions -->
                    <div class="border-t border-white/10 pt-6">
                        <div class="text-[#D1F4FA] text-sm font-semibold mb-4 px-4">Akses Cepat</div>
                        <div class="grid grid-cols-1 gap-3">
                            <a href="/cektagihan" 
                               class="group flex items-center px-4 py-3 bg-gradient-to-r from-[#53CDE2]/20 to-[#D1F4FA]/20 rounded-xl hover:from-[#53CDE2]/30 hover:to-[#D1F4FA]/30 transition-all duration-300">
                                <div class="w-10 h-10 rounded-lg bg-[#53CDE2]/30 flex items-center justify-center mr-3">
                                    <i class="fas fa-search-dollar text-[#EDF9FC]"></i>
                                </div>
                                <div>
                                    <div class="text-white font-medium">Cek Tagihan</div>
                                    <div class="text-[#D1F4FA]/60 text-xs">Mudah & Cepat</div>
                                </div>
                            </a>
                            <a href="/pengaduanpelanggan" 
                               class="group flex items-center px-4 py-3 bg-gradient-to-r from-[#53CDE2]/20 to-[#EDF9FC]/20 rounded-xl hover:from-[#53CDE2]/30 hover:to-[#EDF9FC]/30 transition-all duration-300">
                                <div class="w-10 h-10 rounded-lg bg-[#D1F4FA]/30 flex items-center justify-center mr-3">
                                    <i class="fas fa-comments text-[#005792]"></i>
                                </div>
                                <div>
                                    <div class="text-white font-medium">Pengaduan</div>
                                    <div class="text-[#D1F4FA]/60 text-xs">24/7 Online</div>
                                </div>
                            </a>
                            <a href="tel:0651-48853" 
                               class="group flex items-center px-4 py-3 bg-gradient-to-r from-[#005792]/20 to-[#53CDE2]/20 rounded-xl hover:from-[#005792]/30 hover:to-[#53CDE2]/30 transition-all duration-300">
                                <div class="w-10 h-10 rounded-lg bg-[#005792]/30 flex items-center justify-center mr-3">
                                    <i class="fas fa-phone text-[#D1F4FA]"></i>
                                </div>
                                <div>
                                    <div class="text-white font-medium">Hubungi Kami</div>
                                    <div class="text-[#D1F4FA]/60 text-xs">0651-48853</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<style>
/* Modern Navbar Styles with Custom Color Palette */
#navbar {
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
}

/* Active link styles */
.nav-link.active {
    background: linear-gradient(135deg, rgba(0, 87, 146, 0.3), rgba(83, 205, 226, 0.3));
    color: white !important;
    box-shadow: 0 4px 15px rgba(83, 205, 226, 0.2);
}

.mobile-nav-link.active {
    background: linear-gradient(135deg, rgba(0, 87, 146, 0.2), rgba(83, 205, 226, 0.2));
    color: white !important;
    transform: translateX(8px);
    border-left: 3px solid #53CDE2;
}

/* Glassmorphism effect */
.nav-link::before {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: inherit;
    padding: 1px;
    background: linear-gradient(135deg, rgba(209, 244, 250, 0.1), rgba(237, 249, 252, 0.05));
    mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    mask-composite: exclude;
    -webkit-mask-composite: xor;
    pointer-events: none;
}

/* Mobile menu animations */
#mobile-menu.show {
    transform: scaleY(1);
    opacity: 1;
}

/* Navbar scroll effect */
.navbar-scrolled {
    background: linear-gradient(135deg, rgba(0, 87, 146, 0.95), rgba(83, 205, 226, 0.95)) !important;
    backdrop-filter: blur(25px);
    border-bottom: 1px solid rgba(209, 244, 250, 0.1);
    box-shadow: 0 8px 32px rgba(0, 87, 146, 0.1);
}

/* Floating effect */
.navbar-floating {
    margin: 10px 20px;
    border-radius: 20px;
    background: linear-gradient(135deg, rgba(0, 87, 146, 0.9), rgba(83, 205, 226, 0.9)) !important;
    border: 1px solid rgba(209, 244, 250, 0.1);
    box-shadow: 0 20px 40px rgba(0, 87, 146, 0.1);
}

/* Logo glow effect */
.logo-glow {
    filter: drop-shadow(0 0 20px rgba(83, 205, 226, 0.3));
}

/* Hover animations */
.nav-link:hover {
    transform: translateY(-1px);
    color: #D1F4FA !important;
}

.mobile-nav-link:hover {
    transform: translateX(4px);
}

/* Custom progress bar for active sections */
.nav-link.active::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 50%;
    transform: translateX(-50%);
    width: 20px;
    height: 2px;
    background: linear-gradient(90deg, #53CDE2, #D1F4FA);
    border-radius: 1px;
}

/* Modern scrollbar */
::-webkit-scrollbar {
    width: 6px;
}

::-webkit-scrollbar-track {
    background: rgba(237, 249, 252, 0.1);
    border-radius: 3px;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, rgba(0, 87, 146, 0.5), rgba(83, 205, 226, 0.5));
    border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, rgba(0, 87, 146, 0.7), rgba(83, 205, 226, 0.7));
}

/* Loading shimmer effect */
@keyframes shimmer {
    0% { background-position: -200% 0; }
    100% { background-position: 200% 0; }
}

.shimmer {
    background: linear-gradient(90deg, rgba(209, 244, 250, 0) 0%, rgba(209, 244, 250, 0.1) 50%, rgba(209, 244, 250, 0) 100%);
    background-size: 200% 100%;
    animation: shimmer 2s infinite;
}

/* Pulse effect for important elements */
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

.pulse-effect {
    animation: pulse 2s ease-in-out infinite;
}

/* Gradient text effect */
.gradient-text {
    background: linear-gradient(45deg, #005792, #53CDE2, #D1F4FA);
    background-size: 200% 200%;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: gradientShift 3s ease infinite;
}

@keyframes gradientShift {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

/* Enhanced focus states for accessibility */
.nav-link:focus,
.mobile-nav-link:focus {
    outline: 2px solid #53CDE2;
    outline-offset: 2px;
    background: rgba(83, 205, 226, 0.1);
}

/* Smooth color transitions */
* {
    transition: color 0.3s ease, background-color 0.3s ease, border-color 0.3s ease;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');
    const closeIcon = document.getElementById('close-icon');
    const navbar = document.getElementById('navbar');
    
    let isMenuOpen = false;
    
    // Toggle mobile menu with enhanced animations
    mobileMenuButton.addEventListener('click', function() {
        isMenuOpen = !isMenuOpen;
        
        if (isMenuOpen) {
            // Open menu
            mobileMenu.classList.add('show');
            menuIcon.style.opacity = '0';
            menuIcon.style.transform = 'rotate(180deg)';
            closeIcon.style.opacity = '1';
            closeIcon.style.transform = 'rotate(0deg)';
            
            // Add blur to background
            document.body.style.overflow = 'hidden';
        } else {
            // Close menu
            mobileMenu.classList.remove('show');
            menuIcon.style.opacity = '1';
            menuIcon.style.transform = 'rotate(0deg)';
            closeIcon.style.opacity = '0';
            closeIcon.style.transform = 'rotate(-180deg)';
            
            // Remove blur from background
            document.body.style.overflow = '';
        }
    });

    // Close mobile menu when clicking on links
    const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');
    mobileNavLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (isMenuOpen) {
                mobileMenuButton.click();
            }
        });
    });

    // Enhanced scroll effects
    let lastScrollTop = 0;
    let scrollTimeout;
    
    window.addEventListener('scroll', function() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        // Clear existing timeout
        clearTimeout(scrollTimeout);
        
        // Add scrolled class with delay
        scrollTimeout = setTimeout(() => {
            if (scrollTop > 50) {
                navbar.classList.add('navbar-scrolled');
                if (scrollTop > 200) {
                    navbar.classList.add('navbar-floating');
                }
            } else {
                navbar.classList.remove('navbar-scrolled', 'navbar-floating');
            }
        }, 50);
        
        // Smart hide/show navbar
        if (scrollTop > lastScrollTop && scrollTop > 100) {
            // Scrolling down
            navbar.style.transform = 'translateY(-100%)';
        } else {
            // Scrolling up
            navbar.style.transform = 'translateY(0)';
        }
        lastScrollTop = scrollTop;
        
        // Update active link
        updateActiveLink();
    });

    // Enhanced active link detection
    function updateActiveLink() {
        const sections = document.querySelectorAll('section[id]');
        const navLinks = document.querySelectorAll('.nav-link, .mobile-nav-link');
        
        let currentSection = '';
        const scrollPosition = window.scrollY + 120;
        
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.offsetHeight;
            
            if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                currentSection = '#' + section.id;
            }
        });
        
        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === currentSection) {
                link.classList.add('active');
            }
        });
    }

    // Enhanced smooth scrolling
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                const offsetTop = target.offsetTop - 100;
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Close mobile menu on outside click
    document.addEventListener('click', function(e) {
        if (isMenuOpen && !navbar.contains(e.target)) {
            mobileMenuButton.click();
        }
    });

    // Keyboard navigation
    mobileMenuButton.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            this.click();
        }
    });

    // Enhanced logo effects
    const logo = document.querySelector('img[alt="PDAM Logo"]');
    if (logo) {
        logo.addEventListener('mouseenter', function() {
            this.classList.add('logo-glow');
        });
        
        logo.addEventListener('mouseleave', function() {
            this.classList.remove('logo-glow');
        });
    }

    // Initialize
    updateActiveLink();
    
    // Add shimmer effect to login button periodically
    const loginButton = document.querySelector('a[href="/login"]');
    if (loginButton) {
        setInterval(() => {
            loginButton.classList.add('shimmer');
            setTimeout(() => {
                loginButton.classList.remove('shimmer');
            }, 2000);
        }, 10000);
    }

    // Add pulse effect to important elements on scroll
    window.addEventListener('scroll', function() {
        const importantElements = document.querySelectorAll('.nav-link.active');
        importantElements.forEach(element => {
            element.classList.add('pulse-effect');
            setTimeout(() => {
                element.classList.remove('pulse-effect');
            }, 1000);
        });
    });
});
</script>