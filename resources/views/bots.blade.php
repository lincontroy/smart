@extends('layouts.app')
@section('content')

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #0a0f1c;
            color: white;
            min-height: 100vh;
        }

        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 2rem;
            background: #0f1419;
            border-bottom: 1px solid #1a2332;
        }

        .nav-left {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .logo-icon {
            width: 32px;
            height: 32px;
            background: #4ade80;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #0a0f1c;
        }

        .page-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #fbbf24;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-item {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            color: #9ca3af;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-item:hover {
            background: #1a2332;
            color: white;
        }

        .nav-item.active {
            background: #4ade80;
            color: #0a0f1c;
            font-weight: 500;
        }

        .accounts-btn {
            background: #4ade80;
            color: #0a0f1c;
            font-weight: 500;
        }

        .balance-display {
            background: #4ade80;
            color: #0a0f1c;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 600;
        }

        .main-content {
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .hero-section {
            background: linear-gradient(135deg, #1e3a8a, #3730a3);
            border-radius: 20px;
            padding: 2.5rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .hero-subtitle {
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 2rem;
        }

        .hero-stats {
            display: flex;
            gap: 4rem;
            margin-bottom: 2rem;
        }

        .stat-item {
            text-align: left;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 300;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
        }

        .weekly-return {
            color: #4ade80;
            font-size: 2rem;
            font-weight: 600;
        }

        .create-bot-btn {
            background: white;
            color: #1e3a8a;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .create-bot-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 255, 255, 0.2);
        }

        .content-grid {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 2rem;
        }

        .sidebar {
            background: #1a2332;
            border-radius: 16px;
            padding: 1.5rem;
            height: fit-content;
        }

        .sidebar-section {
            margin-bottom: 2rem;
        }

        .sidebar-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .category-list {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .category-item {
            padding: 0.75rem 1rem;
            border-radius: 8px;
            background: #374151;
            color: #9ca3af;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .category-item.active {
            background: #4ade80;
            color: #0a0f1c;
            font-weight: 500;
        }

        .category-item:hover:not(.active) {
            background: #4b5563;
            color: white;
        }

        .performance-section {
            margin-top: 1rem;
        }

        .performance-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #374151;
        }

        .performance-item:last-child {
            border-bottom: none;
        }

        .performance-change {
            color: #4ade80;
            font-weight: 600;
        }

        .main-section {
            background: #1a2332;
            border-radius: 16px;
            padding: 2rem;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .section-subtitle {
            color: #9ca3af;
            font-size: 0.9rem;
            margin-top: 0.25rem;
        }

        .create-dca-btn {
            background: #4ade80;
            color: #0a0f1c;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .create-dca-btn:hover {
            transform: translateY(-1px);
        }

        .bots-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 1.5rem;
        }

        .bot-card {
            background: #0f1419;
            border-radius: 12px;
            padding: 1.5rem;
            position: relative;
        }

        .bot-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .bot-info h3 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .bot-frequency {
            color: #9ca3af;
            font-size: 0.85rem;
        }

        .bot-status {
            padding: 0.25rem 0.75rem;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .bot-status.active {
            background: #065f46;
            color: #4ade80;
        }

        .bot-status.inactive {
            background: #374151;
            color: #9ca3af;
        }

        .bot-status.configured {
            background: #1e3a8a;
            color: #60a5fa;
        }

        .bot-description {
            color: #9ca3af;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
            line-height: 1.4;
        }

        .bot-stats {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .bot-stat {
            text-align: left;
        }

        .bot-stat-label {
            color: #9ca3af;
            font-size: 0.8rem;
            margin-bottom: 0.25rem;
        }

        .bot-stat-value {
            font-weight: 600;
        }

        .performance-positive {
            color: #4ade80;
        }

        .bot-actions {
            display: flex;
            gap: 0.75rem;
        }

        .bot-btn {
            flex: 1;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 0.85rem;
        }

        .bot-btn.primary {
            background: #4ade80;
            color: #0a0f1c;
        }

        .bot-btn.secondary {
            background: #374151;
            color: white;
        }

        .bot-btn:hover {
            transform: translateY(-1px);
        }

        @media (max-width: 1024px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
            
            .hero-stats {
                gap: 2rem;
            }
            
            .bots-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
            }
            
            .hero-section {
                padding: 1.5rem;
            }
            
            .hero-stats {
                flex-direction: column;
                gap: 1rem;
            }
            
            .nav-links {
                display: none;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="nav-left">
            <div class="logo">
                <div class="logo-icon">F</div>
                <span>FentiCoin</span>
            </div>
            <div class="page-title">Trading Bots</div>
        </div>
        <div class="nav-links">
            <a href="#" class="nav-item">🏠 Dashboard</a>
            <a href="#" class="nav-item">📊 Markets</a>
            <a href="#" class="nav-item">📈 Spot Trading</a>
            <a href="#" class="nav-item">⏰ Futures</a>
            <a href="#" class="nav-item active">🤖 Bots</a>
            <a href="#" class="nav-item accounts-btn">👤 Accounts</a>
        </div>
        <div class="balance-display">$0.00</div>
    </nav>

    <main class="main-content">
        <div class="hero-section">
            <div class="hero-content">
                <h1 class="hero-title">Automated Trading</h1>
                <p class="hero-subtitle">Create and manage algorithmic trading strategies</p>
                
                <div class="hero-stats">
                    <div class="stat-item">
                        <div class="stat-number">20</div>
                        <div class="stat-label">Total Bots</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">1</div>
                        <div class="stat-label">Active</div>
                    </div>
                    <div class="stat-item">
                        <div class="weekly-return">+4.8%</div>
                        <div class="stat-label">Weekly Return</div>
                    </div>
                </div>
                
                <button class="create-bot-btn">
                    Create New Bot →
                </button>
            </div>
        </div>

        <div class="content-grid">
            <div class="sidebar">
                <div class="sidebar-section">
                    <h3 class="sidebar-title">Bot Categories</h3>
                    <div class="category-list">
                        <div class="category-item active">Dollar-Cost Averaging</div>
                        <div class="category-item">Grid Trading</div>
                        <div class="category-item">Arbitrage</div>
                        <div class="category-item">Scalping</div>
                        <div class="category-item">Signal-Based</div>
                    </div>
                </div>
                
                <div class="sidebar-section performance-section">
                    <h3 class="sidebar-title">Bot Performance</h3>
                    <div class="performance-item">
                        <span>Best Performer</span>
                        <span class="performance-change">+10.2%</span>
                    </div>
                    <div class="performance-item">
                        <span>News Sentiment Bot</span>
                        <span></span>
                    </div>
                </div>
            </div>

            <div class="main-section">
                <div class="section-header">
                    <div>
                        <h2 class="section-title">Dollar-Cost Averaging Bots</h2>
                        <p class="section-subtitle">Regular purchases of assets regardless of price</p>
                    </div>
                    <button class="create-dca-btn">Create DCA Bot</button>
                </div>
                
                <div class="bots-grid">
                    <div class="bot-card">
                        <div class="bot-header">
                            <div class="bot-info">
                                <h3>Bitcoin Accumulation</h3>
                                <p class="bot-frequency">Weekly • DCA</p>
                            </div>
                            <div class="bot-status active">Active</div>
                        </div>
                        <p class="bot-description">Dollar-cost averaging into Bitcoin on a weekly basis</p>
                        <div class="bot-stats">
                            <div class="bot-stat">
                                <div class="bot-stat-label">Risk:</div>
                                <div class="bot-stat-value">Low</div>
                            </div>
                            <div class="bot-stat">
                                <div class="bot-stat-label">Performance:</div>
                                <div class="bot-stat-value performance-positive">+2.4%</div>
                            </div>
                        </div>
                        <div class="bot-actions">
                            <button class="bot-btn secondary">Configure</button>
                            <a href="/bt-1" class="bot-btn primary">Start</a>
                        </div>
                    </div>

                    <div class="bot-card">
                        <div class="bot-header">
                            <div class="bot-info">
                                <h3>ETH DCA Pro</h3>
                                <p class="bot-frequency">Daily • DCA</p>
                            </div>
                            <div class="bot-status inactive">Inactive</div>
                        </div>
                        <p class="bot-description">Dynamic DCA based on RSI and volume indicators</p>
                        <div class="bot-stats">
                            <div class="bot-stat">
                                <div class="bot-stat-label">Risk:</div>
                                <div class="bot-stat-value">Medium</div>
                            </div>
                            <div class="bot-stat">
                                <div class="bot-stat-label">Performance:</div>
                                <div class="bot-stat-value performance-positive">+3.7%</div>
                            </div>
                        </div>
                        <div class="bot-actions">
                            <button class="bot-btn secondary">Configure</button>
                            <button class="bot-btn primary">Configure & Run</button>
                        </div>
                    </div>

                   
                </div>
            </div>
        </div>
    </main>

    <script>
        // Category selection functionality
        document.querySelectorAll('.category-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.category-item').forEach(cat => cat.classList.remove('active'));
                this.classList.add('active');
                
                // Update main section title based on category
                const sectionTitle = document.querySelector('.section-title');
                sectionTitle.textContent = this.textContent + ' Bots';
                
                // You can add logic here to filter bots based on category
                console.log('Selected category:', this.textContent);
            });
        });

        // Bot action buttons
        document.querySelectorAll('.bot-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const action = this.textContent;
                const botName = this.closest('.bot-card').querySelector('h3').textContent;
                console.log(`${action} clicked for ${botName}`);
                
                // Add your bot action logic here
                if (action.includes('Configure')) {
                    // Open configuration modal
                } else if (action === 'View Bot') {
                    // Navigate to bot details
                } else if (action === 'Start Bot') {
                    // Start the bot
                }
            });
        });

        // Create bot buttons
        document.querySelector('.create-bot-btn').addEventListener('click', function() {
            console.log('Create New Bot clicked');
            // Open bot creation wizard
        });

        document.querySelector('.create-dca-btn').addEventListener('click', function() {
            console.log('Create DCA Bot clicked');
            // Open DCA bot creation
        });
    </script>
@endsection