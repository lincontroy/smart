<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Smart Market - Dashboard</title>
    <link rel="stylesheet" type="text/css" href="dashboard.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        /* Bottom Navigation Styles */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            border-top: 1px solid rgba(74, 222, 128, 0.2);
            padding: 8px 0 calc(8px + env(safe-area-inset-bottom));
            z-index: 1000;
            display: none;
            backdrop-filter: blur(10px);
            box-shadow: 0 -5px 20px rgba(0, 0, 0, 0.3);
        }
        
        .bottom-nav-container {
            display: flex;
            justify-content: space-around;
            align-items: center;
            max-width: 100%;
            margin: 0 auto;
            padding: 0 16px;
        }
        
        .bottom-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: #888;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 8px 12px;
            border-radius: 12px;
            min-width: 60px;
            position: relative;
            overflow: hidden;
        }
        
        .bottom-nav-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(74, 222, 128, 0.1), rgba(34, 197, 94, 0.1));
            opacity: 0;
            transition: opacity 0.3s ease;
            border-radius: 12px;
        }
        
        .bottom-nav-item:hover::before,
        .bottom-nav-item.active::before {
            opacity: 1;
        }
        
        .bottom-nav-icon {
            font-size: 22px;
            margin-bottom: 4px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            z-index: 1;
        }
        
        .bottom-nav-label {
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.5px;
            position: relative;
            z-index: 1;
        }
        
        .bottom-nav-item:hover,
        .bottom-nav-item.active {
            color: #4ade80;
            transform: translateY(-2px);
        }
        
        .bottom-nav-item:hover .bottom-nav-icon,
        .bottom-nav-item.active .bottom-nav-icon {
            transform: scale(1.2);
            filter: drop-shadow(0 0 8px rgba(74, 222, 128, 0.5));
        }
        
        .bottom-nav-item:active {
            transform: translateY(0) scale(0.95);
        }
        
        /* Balance indicator in bottom nav */
        .bottom-nav-balance {
            background: linear-gradient(135deg, #4ade80, #22c55e);
            color: #000;
            font-weight: 600;
            font-size: 10px;
            padding: 4px 8px;
            border-radius: 8px;
            margin-top: 2px;
            box-shadow: 0 2px 8px rgba(74, 222, 128, 0.3);
        }
        
        /* Hide bottom nav on larger screens */
        @media (min-width: 769px) {
            .bottom-nav {
                display: none !important;
            }
        }
        
        /* Show bottom nav on mobile */
        @media (max-width: 768px) {
            .bottom-nav {
                display: block;
            }
            
            /* Add padding to body to account for bottom nav */
            body {
                padding-bottom: 80px;
            }
            
            /* Hide the original mobile menu on smaller screens when bottom nav is active */
            .mobile-menu {
                bottom: 80px;
            }
        }
        
        /* Notification badge */
        .nav-badge {
            position: absolute;
            top: -2px;
            right: 8px;
            background: #ef4444;
            color: white;
            font-size: 9px;
            padding: 2px 5px;
            border-radius: 10px;
            font-weight: 600;
            min-width: 16px;
            text-align: center;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        
        /* Enhanced mobile responsiveness */
        @media (max-width: 480px) {
            .bottom-nav-container {
                padding: 0 8px;
            }
            
            .bottom-nav-item {
                min-width: 50px;
                padding: 6px 8px;
            }
            
            .bottom-nav-icon {
                font-size: 20px;
            }
            
            .bottom-nav-label {
                font-size: 10px;
            }
        }
        
        /* Haptic feedback simulation */
        .bottom-nav-item:active {
            animation: tap 0.1s ease;
        }
        
        @keyframes tap {
            0% { transform: translateY(-2px) scale(1); }
            50% { transform: translateY(0) scale(0.95); }
            100% { transform: translateY(-2px) scale(1); }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="logo-section">
            <div class="logo-icon">+</div>
            <span class="logo-text">Digital Smart Market</span>
        </div>
        
        <button class="mobile-menu-btn">☰</button>
        
        <nav class="nav-menu">
            <a href="/dashboard" class="nav-item active">🏠 Dashboard</a>
            <a href="/markets" class="nav-item">📊 Markets</a>
            <a href="#" class="nav-item">⚡ Spot Trading</a>
            <a href="#" class="nav-item">⏰ Futures</a>
            <a href="/bots" class="nav-item">🤖 Bots</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <a href="#" class="nav-item" onclick="event.preventDefault(); confirmLogout();">🚪 Logout</a>
        </nav>
        
      
    </header>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <a href="/dashboard" class="nav-item active">🏠 Dashboard</a>
        <a href="/markets" class="nav-item">📊 Markets</a>
        <a href="#" class="nav-item">⚡ Spot Trading</a>
        <a href="#" class="nav-item">⏰ Futures</a>
        <a href="/bots" class="nav-item">🤖 Bots</a>
        <div class="nav-item balance">💰 $0.00</div>
        <div class="nav-item">🔧 Accounts</div>
        <a href="#" class="nav-item" onclick="event.preventDefault(); confirmLogout();">🚪 Logout</a>
    </div>

    <!-- Bottom Navigation for Mobile -->
    <nav class="bottom-nav" id="bottomNav">
        <div class="bottom-nav-container">
            <a href="/dashboard" class="bottom-nav-item active" data-page="dashboard">
                <div class="bottom-nav-icon">🏠</div>
                <span class="bottom-nav-label">Home</span>
            </a>
            
            <a href="/markets" class="bottom-nav-item" data-page="markets">
                <div class="bottom-nav-icon">📊</div>
                <span class="bottom-nav-label">Markets</span>
                <span class="nav-badge">3</span>
            </a>
            
            <a href="#" class="bottom-nav-item" data-page="trading">
                <div class="bottom-nav-icon">⚡</div>
                <span class="bottom-nav-label">Trade</span>
            </a>
            
            <a href="/bots" class="bottom-nav-item" data-page="bots">
                <div class="bottom-nav-icon">🤖</div>
                <span class="bottom-nav-label">Bots</span>
                <span class="nav-badge">1</span>
            </a>
            
            <a href="/profile" class="bottom-nav-item" data-page="account">
                <div class="bottom-nav-icon">👤</div>
                <span class="bottom-nav-label">Profile</span>
               
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    @yield('content')

    <script>
        function confirmLogout() {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will be logged out of your account!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, logout!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show success message before logout
                    Swal.fire({
                        title: 'Logging out...',
                        text: 'See you soon!',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        document.getElementById('logout-form').submit();
                    });
                }
            });
        }
    </script>       
  
    <script>
        // Add enhanced interactivity
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
            const mobileMenu = document.getElementById('mobileMenu');
            
            mobileMenuBtn.addEventListener('click', function() {
                mobileMenu.classList.toggle('active');
                this.textContent = mobileMenu.classList.contains('active') ? '✕' : '☰';
            });

            // Close mobile menu when clicking outside
            document.addEventListener('click', function(e) {
                if (!mobileMenu.contains(e.target) && e.target !== mobileMenuBtn) {
                    mobileMenu.classList.remove('active');
                    mobileMenuBtn.textContent = '☰';
                }
            });

            // Bottom navigation functionality
            const bottomNavItems = document.querySelectorAll('.bottom-nav-item');
            
            bottomNavItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    // Remove active class from all items
                    bottomNavItems.forEach(navItem => navItem.classList.remove('active'));
                    
                    // Add active class to clicked item
                    this.classList.add('active');
                    
                    // Add haptic feedback simulation
                    if (navigator.vibrate) {
                        navigator.vibrate(50);
                    }
                    
                    // Close mobile menu if open
                    mobileMenu.classList.remove('active');
                    mobileMenuBtn.textContent = '☰';
                });
            });

            // Handle account bottom nav item click for logout
            const accountNavItem = document.querySelector('[data-page="account"]');
            if (accountNavItem) {
                accountNavItem.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Show account options
                    Swal.fire({
                        title: 'Account Options',
                        html: `
                            <div style="display: flex; flex-direction: column; gap: 10px; margin-top: 20px;">
                               <button onclick="window.location.href='/profile'" class="swal2-styled" style="background: #4ade80; color: white;">
    Profile Settings
</button>

                                <button onclick="window.location.href='/dashboard'" class="swal2-styled" style="background: #3b82f6; color: white;">Balance Details</button>
<button onclick="confirmLogout()" class="swal2-styled" style="background: #ef4444; color: white;">Logout</button>

                            </div>
                        `,
                        showConfirmButton: false,
                        showCloseButton: true,
                        width: '300px'
                    });
                });
            }

            // Animate cards on scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Observe all animated elements
            document.querySelectorAll('.crypto-card, .watchlist-item, .feature-box').forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(30px)';
                el.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                observer.observe(el);
            });

            // Enhanced hover effects for cards
            document.querySelectorAll('.crypto-card').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-8px) scale(1.02)';
                    this.style.boxShadow = '0 20px 60px rgba(74, 222, 128, 0.2)';
                    this.style.transition = 'all 0.3s ease';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                    this.style.boxShadow = 'none';
                });
            });

            // Button click effects (excluding logout buttons to avoid conflicts)
            document.querySelectorAll('button:not(.mobile-menu-btn)').forEach(button => {
                button.addEventListener('click', function(e) {
                    // Skip if this is a logout-related button
                    if (this.onclick && this.onclick.toString().includes('confirmLogout')) {
                        return;
                    }
                    
                    e.preventDefault();
                    
                    // Create ripple effect
                    const ripple = document.createElement('span');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;
                    
                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = x + 'px';
                    ripple.style.top = y + 'px';
                    ripple.style.position = 'absolute';
                    ripple.style.background = 'rgba(255, 255, 255, 0.3)';
                    ripple.style.borderRadius = '50%';
                    ripple.style.transform = 'scale(0)';
                    ripple.style.animation = 'ripple 0.6s linear';
                    ripple.style.pointerEvents = 'none';
                    
                    this.style.position = 'relative';
                    this.style.overflow = 'hidden';
                    this.appendChild(ripple);
                    
                    // Remove ripple after animation
                    setTimeout(() => {
                        if (ripple.parentNode === this) {
                            this.removeChild(ripple);
                        }
                    }, 600);
                });
            });

            // Floating sidebar interactions
            document.querySelectorAll('.sidebar-item').forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.2) rotate(5deg)';
                    this.style.transition = 'transform 0.3s ease';
                });
                
                item.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1) rotate(0deg)';
                });
            });

            // Add keyboard navigation support
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Tab') {
                    document.querySelectorAll('button, a, input').forEach(el => {
                        el.style.transition = 'box-shadow 0.2s ease';
                    });
                }
            });

            // Add focus styles for accessibility
            document.querySelectorAll('button, a, input').forEach(el => {
                el.addEventListener('focus', function() {
                    this.style.outline = '2px solid rgba(74, 222, 128, 0.8)';
                    this.style.outlineOffset = '2px';
                });
                
                el.addEventListener('blur', function() {
                    this.style.outline = 'none';
                });
            });

            // Update active nav item based on current page
            function updateActiveNavItem() {
                const currentPath = window.location.pathname;
                const navItems = document.querySelectorAll('.bottom-nav-item');
                
                navItems.forEach(item => {
                    item.classList.remove('active');
                    const href = item.getAttribute('href');
                    if (href && href === currentPath) {
                        item.classList.add('active');
                    }
                });
            }

            // Call on page load
            updateActiveNavItem();
        });

        // Helper functions for account menu
        function showProfile() {
            Swal.fire({
                title: 'Profile Settings',
                html: `
                    <div style="text-align: left; margin-top: 20px;">
                        <p><strong>Email:</strong> user@example.com</p>
                        <p><strong>Account Type:</strong> Premium</p>
                        <p><strong>Member Since:</strong> January 2024</p>
                    </div>
                `,
                confirmButtonText: 'Edit Profile',
                confirmButtonColor: '#4ade80'
            });
        }

        function showBalance() {
            Swal.fire({
                title: 'Balance Details',
                html: `
                    <div style="text-align: left; margin-top: 20px;">
                        <p><strong>Available Balance:</strong> $0.00</p>
                        <p><strong>In Orders:</strong> $0.00</p>
                        <p><strong>Total Portfolio:</strong> $0.00</p>
                    </div>
                `,
                confirmButtonText: 'Deposit Funds',
                confirmButtonColor: '#3b82f6'
            });
        }

        // Add CSS for ripple animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
        
    </script>
</body>
</html>