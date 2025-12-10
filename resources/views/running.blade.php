@extends('layouts.app')
@section('content')
    <style>
        /* Enhanced UI with profit focus */
        :root {
            --profit-green: #10b981;
            --profit-dark: #065f46;
            --profit-light: #d1fae5;
            --warning: #f59e0b;
            --danger: #ef4444;
            --bg-dark: #0a0f1c;
            --card-dark: #1a2332;
            --border-dark: #2a3441;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, var(--bg-dark) 0%, #0c1220 100%);
            color: white;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .profit-glow {
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.3);
        }

        .profit-gradient {
            background: linear-gradient(135deg, var(--profit-green) 0%, #34d399 100%);
        }

        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 2rem;
            background: rgba(15, 20, 25, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-dark);
            position: sticky;
            top: 0;
            z-index: 1000;
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
            background: var(--profit-green);
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
            color: var(--profit-green);
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
            background: var(--card-dark);
            color: white;
        }

        .nav-item.active {
            background: var(--profit-green);
            color: #0a0f1c;
            font-weight: 500;
        }

        .accounts-btn {
            background: var(--profit-green);
            color: #0a0f1c;
            font-weight: 500;
        }

        .balance-display {
            background: var(--profit-green);
            color: #0a0f1c;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }

        /* Profit Alert Banner */
        .profit-alert {
            background: linear-gradient(90deg, var(--profit-dark), var(--profit-green));
            padding: 0.75rem;
            text-align: center;
            font-weight: 600;
            animation: slideIn 0.5s ease-out;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        @keyframes slideIn {
            from { transform: translateY(-100%); }
            to { transform: translateY(0); }
        }

        .profit-badge {
            background: var(--profit-green);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-left: 0.5rem;
            animation: glow 2s infinite;
        }

        @keyframes glow {
            0%, 100% { box-shadow: 0 0 5px var(--profit-green); }
            50% { box-shadow: 0 0 10px var(--profit-green); }
        }

        .main-content {
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Enhanced Bot Header */
        .bot-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 2rem;
            background: rgba(26, 35, 50, 0.8);
            padding: 1.5rem;
            border-radius: 16px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(16, 185, 129, 0.1);
        }

        .bot-info {
            flex: 1;
        }

        .bot-title {
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, #fff 0%, var(--profit-green) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .bot-subtitle {
            color: var(--profit-green);
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }

        .bot-details {
            color: #9ca3af;
            font-size: 1rem;
        }

        .status-section {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .status-badge {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            background: var(--profit-green);
            color: #0a0f1c;
            transition: all 0.3s;
        }

        .status-badge.running {
            background: var(--profit-green);
            color: #0a0f1c;
            animation: runningGlow 2s infinite;
        }

        @keyframes runningGlow {
            0%, 100% { box-shadow: 0 0 10px var(--profit-green); }
            50% { box-shadow: 0 0 20px var(--profit-green); }
        }

        .status-badge.paused {
            background: var(--warning);
            color: white;
        }

        .status-badge.stopped {
            background: #374151;
            color: #9ca3af;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #0a0f1c;
            animation: pulse 2s infinite;
        }

        .insufficient-balance {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.9rem;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .trade-controls {
            display: flex;
            gap: 0.5rem;
        }

        .btn {
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 0.9rem;
            position: relative;
            overflow: hidden;
        }

        .btn:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }

        .btn:hover:before {
            left: 100%;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        .btn-start {
            background: var(--profit-green);
            color: #0a0f1c;
        }

        .btn-start:hover {
            background: #0d9668;
        }

        .btn-pause {
            background: var(--warning);
            color: white;
        }

        .btn-pause:hover {
            background: #d97706;
        }

        .btn-stop {
            background: var(--danger);
            color: white;
        }

        .btn-stop:hover {
            background: #b91c1c;
        }

        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .btn:disabled:before {
            display: none;
        }

        /* Enhanced Content Grid */
        .content-grid {
            display: grid;
            grid-template-columns: 400px 1fr;
            gap: 2rem;
        }

        .stats-sidebar {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .stat-card {
            background: rgba(26, 35, 50, 0.8);
            border-radius: 16px;
            padding: 1.5rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.05);
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.1);
        }

        .stat-card:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--profit-green);
        }

        .stat-card.pnl:before { background: var(--profit-green); }
        .stat-card.runs:before { background: #8b5cf6; }
        .stat-card.trades:before { background: #3b82f6; }
        .stat-card.winrate:before { background: var(--warning); }
        .stat-card.balance:before { background: #06b6d4; }

        .stat-label {
            color: #9ca3af;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 600;
        }

        .stat-value.positive {
            color: var(--profit-green);
        }

        .stat-value.negative {
            color: var(--danger);
        }

        /* Profit Streak Indicator */
        .streak-indicator {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .streak-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--profit-green);
            opacity: 0.3;
        }

        .streak-dot.active {
            opacity: 1;
            animation: dotPulse 1s infinite;
        }

        @keyframes dotPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.2); }
        }

        /* Enhanced Logs Section */
        .logs-section {
            background: rgba(26, 35, 50, 0.8);
            border-radius: 16px;
            padding: 1.5rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.05);
        }

        .logs-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .logs-title {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .logs-count {
            color: #9ca3af;
            font-size: 0.9rem;
        }

        .logs-container {
            background: rgba(15, 20, 25, 0.8);
            border-radius: 12px;
            padding: 1rem;
            height: 500px;
            overflow-y: auto;
            font-family: 'Cascadia Code', 'Roboto Mono', monospace;
            font-size: 0.85rem;
            line-height: 1.5;
        }

        .log-entry {
            margin-bottom: 0.5rem;
            word-wrap: break-word;
            padding: 0.5rem;
            border-radius: 6px;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }

        .log-entry:hover {
            background: rgba(255,255,255,0.05);
        }

        .log-entry.success { border-left-color: var(--profit-green); }
        .log-entry.error { border-left-color: var(--danger); }
        .log-entry.info { border-left-color: #3b82f6; }
        .log-entry.warning { border-left-color: var(--warning); }
        .log-entry.trade { border-left-color: #8b5cf6; }

        .log-timestamp {
            color: #6b7280;
            font-family: monospace;
        }

        .log-error { color: var(--danger); }
        .log-success { color: var(--profit-green); }
        .log-info { color: #60a5fa; }
        .log-warning { color: var(--warning); }
        .log-trade { color: #a78bfa; }

        /* Mobile Balance Widget - Enhanced */
        .mobile-balance-widget {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(26, 35, 50, 0.95);
            backdrop-filter: blur(20px);
            padding: 12px 16px;
            border-top: 1px solid var(--border-dark);
            z-index: 1000;
            box-shadow: 0 -10px 30px rgba(0, 0, 0, 0.5);
        }

        .balance-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .balance-label {
            color: #9ca3af;
            font-size: 0.9rem;
        }

        .balance-amount {
            font-weight: 600;
            font-size: 1.1rem;
            color: white;
        }

        .balance-change {
            font-size: 0.8rem;
            margin-left: 8px;
            padding: 0.2rem 0.5rem;
            border-radius: 12px;
            background: rgba(16, 185, 129, 0.2);
        }

        .balance-change.positive {
            color: var(--profit-green);
        }

        .balance-change.negative {
            background: rgba(239, 68, 68, 0.2);
            color: var(--danger);
        }

        /* Profit Maximizer Panel */
        .profit-maximizer {
            background: rgba(26, 35, 50, 0.8);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .maximizer-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .maximizer-title {
            color: var(--profit-green);
            font-size: 1.1rem;
            font-weight: 600;
        }

        .maximizer-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
        }

        .maximizer-stat {
            text-align: center;
        }

        .maximizer-value {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--profit-green);
        }

        .maximizer-label {
            font-size: 0.8rem;
            color: #9ca3af;
        }

        /* Quick Actions */
        .quick-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .action-btn {
            flex: 1;
            padding: 0.5rem;
            border: 1px solid var(--border-dark);
            background: rgba(255,255,255,0.05);
            color: white;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 0.8rem;
        }

        .action-btn:hover {
            background: var(--profit-green);
            color: #0a0f1c;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .content-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .stats-sidebar {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                display: grid;
                gap: 0.75rem;
            }

            .stat-card {
                padding: 1rem;
            }

            .stat-value {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 0.5rem;
                padding-bottom: 70px;
            }
            
            .bot-header {
                flex-direction: column;
                gap: 0.75rem;
                margin-bottom: 1rem;
            }
            
            .status-section {
                flex-direction: row;
                flex-wrap: wrap;
                gap: 0.5rem;
                width: 100%;
            }
            
            .nav-links {
                display: none;
            }
            
            .bot-title {
                font-size: 1.5rem;
                margin-bottom: 0.25rem;
            }

            .bot-details {
                font-size: 0.85rem;
            }

            .status-badge {
                padding: 0.5rem 1rem;
                font-size: 0.8rem;
            }

            .insufficient-balance {
                padding: 0.4rem 0.8rem;
                font-size: 0.8rem;
            }

            .trade-controls {
                gap: 0.3rem;
            }

            .btn {
                padding: 0.5rem 1rem;
                font-size: 0.8rem;
            }

            .stats-sidebar {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.5rem;
                margin-bottom: 1rem;
            }

            .stat-card {
                padding: 0.75rem;
                border-radius: 8px;
            }

            .stat-label {
                font-size: 0.75rem;
                margin-bottom: 0.25rem;
            }

            .stat-value {
                font-size: 1.25rem;
                font-weight: 500;
            }

            .logs-section {
                padding: 1rem;
                border-radius: 8px;
            }

            .logs-header {
                margin-bottom: 1rem;
            }

            .logs-title {
                font-size: 1rem;
            }

            .logs-count {
                font-size: 0.8rem;
            }

            .logs-container {
                height: 300px;
                padding: 0.75rem;
                font-size: 0.75rem;
                line-height: 1.4;
            }

            .mobile-balance-widget {
                display: block;
            }

            .profit-maximizer {
                padding: 1rem;
            }

            .maximizer-stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .main-content {
                padding: 0.25rem;
                padding-bottom: 60px;
            }

            .bot-header {
                margin-bottom: 0.75rem;
            }

            .bot-title {
                font-size: 1.25rem;
            }

            .stats-sidebar {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.4rem;
            }

            .stat-card {
                padding: 0.5rem;
            }

            .stat-label {
                font-size: 0.7rem;
            }

            .stat-value {
                font-size: 1rem;
            }

            .status-section {
                flex-direction: column;
                align-items: stretch;
            }

            .trade-controls {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 0.25rem;
            }

            .btn {
                padding: 0.4rem 0.5rem;
                font-size: 0.75rem;
            }

            .logs-container {
                height: 250px;
                font-size: 0.7rem;
            }

            .mobile-balance-widget {
                padding: 10px 12px;
            }

            .balance-amount {
                font-size: 1rem;
            }

            .maximizer-stats {
                grid-template-columns: 1fr;
            }
        }
    </style>

<body>
    <!-- Profit Alert Banner -->
    <div class="profit-alert" id="profitAlert">
        📈 ትርፋማ ንግድ በመካሄድ ላይ / Profitable Trading Active 
        <span class="profit-badge" id="profitCounter">+ETB 0.00</span>
    </div>

    <main class="main-content">
        <div class="bot-header">
            <div class="bot-info">
                <h1 class="bot-title">የኢትዮጵያ ባህር ዳር ንግድ ሮቦት</h1>
                <div class="bot-subtitle">💰 Profit-Optimized Version 2.0</div>
                <div class="bot-details">Bot ID: ETB-PROFIT-1 • Account: Real • Currency: Ethiopian Birr (ETB)</div>
            </div>
            <div class="status-section">
                <div class="status-badge" id="statusBadge">
                    <div class="status-dot" id="statusDot"></div>
                    <span id="statusText">Ready for Profits</span>
                </div>
                <?php
                $amount = request('amount');
                $asset = request('asset');?>
                @if(Auth::user()->wallet_balance < $amount)
                    <div class="insufficient-balance">Add funds to start trading</div>
                @else
                    <div class="trade-controls" id="tradeControls">
                        <button class="btn btn-start" id="startBtn">🚀 Start Trading</button>
                        <button class="btn btn-pause" id="pauseBtn" disabled>⏸️ Pause</button>
                        <button class="btn btn-stop" id="stopBtn" disabled>🛑 Stop</button>
                    </div>
                @endif
            </div>
        </div>

        <!-- Profit Maximizer Panel -->
        <div class="profit-maximizer">
            <div class="maximizer-header">
                <div class="maximizer-title">💎 Profit Maximizer Dashboard</div>
                <div class="profit-badge">Active</div>
            </div>
            <div class="maximizer-stats">
                <div class="maximizer-stat">
                    <div class="maximizer-value" id="profitPerHour">ETB 0</div>
                    <div class="maximizer-label">Profit/Hour</div>
                </div>
                <div class="maximizer-stat">
                    <div class="maximizer-value" id="tradeAccuracy">0%</div>
                    <div class="maximizer-label">Accuracy</div>
                </div>
                <div class="maximizer-stat">
                    <div class="maximizer-value" id="profitFactor">1.0x</div>
                    <div class="maximizer-label">Profit Multiplier</div>
                </div>
            </div>
            <div class="quick-actions">
                <button class="action-btn" onclick="boostProfits()">⚡ Boost Profits</button>
                <button class="action-btn" onclick="analyzeMarket()">📊 Analyze</button>
                <button class="action-btn" onclick="optimizeStrategy()">🎯 Optimize</button>
            </div>
        </div>

        <div class="content-grid">
            <div class="stats-sidebar">
                <div class="stat-card pnl">
                    <div class="stat-label">ጠቅላላ ትርፍ/ጉዳት</div>
                    <div class="stat-label">Total P/L</div>
                    <div class="stat-value positive" id="totalPnL">+ETB 0.00</div>
                    <div class="streak-indicator" id="profitStreak">
                        <!-- Profit streak dots will be added here -->
                    </div>
                </div>
                
                <div class="stat-card runs">
                    <div class="stat-label">ጠቅላላ ስራዎች</div>
                    <div class="stat-label">Total Runs</div>
                    <div class="stat-value" id="totalRuns">0</div>
                </div>
                
                <div class="stat-card trades">
                    <div class="stat-label">ጠቅላላ ንግዶች</div>
                    <div class="stat-label">Total Trades</div>
                    <div class="stat-value" id="totalTrades">0</div>
                </div>
                
                <div class="stat-card winrate">
                    <div class="stat-label">የማሸነፍ መጠን</div>
                    <div class="stat-label">Win Rate</div>
                    <div class="stat-value" id="winRate">0.0%</div>
                </div>
                
                <div class="stat-card balance">
                    <div class="stat-label">ሒሳብ ቀሪ ሂሳብ</div>
                    <div class="stat-label">Account Balance</div>
                    <div class="stat-value" id="currentBalance">ETB {{ number_format(Auth::user()->wallet_balance, 2) }}</div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">የአሁን ደረጃ</div>
                    <div class="stat-label">Current Tier</div>
                    <div class="stat-value" id="currentTier" style="font-size: 1.2rem; color: var(--profit-green)">PROFIT MAX</div>
                </div>
            </div>

            <div class="logs-section">
                <div class="logs-header">
                    <h2 class="logs-title">📈 የሮቦት መዝገቦች / Bot Logs</h2>
                    <div class="logs-count" id="logsCount">0 entries</div>
                </div>
                
                <div class="logs-container" id="logsContainer">
                    <!-- Logs will be populated dynamically -->
                </div>
            </div>
        </div>
    </main>

    <!-- Mobile Balance Widget -->
    <div class="mobile-balance-widget">
        <div class="balance-content">
            <div class="balance-label">ሒሳብ ቀሪ ሂሳብ / Account Balance</div>
            <div>
                <span class="balance-amount" id="mobileBalance">ETB {{ number_format(Auth::user()->wallet_balance, 2) }}</span>
                <span class="balance-change positive" id="mobileBalanceChange">+ETB 0.00</span>
            </div>
        </div>
    </div>

    <script>
        // ULTIMATE PROFIT-OPTIMIZED Ethiopian Trading Bot
        let botState = {
            isRunning: false,
            isPaused: false,
            totalPnL: 0,
            totalRuns: 0,
            totalTrades: 0,
            winningTrades: 0,
            currentBalance: {{ Auth::user()->wallet_balance }},
            tradingInterval: null,
            logInterval: null,
            analysisInterval: null,
            consecutiveWins: 0,
            marketTrend: 'bullish',
            profitBoost: 0.05, // Increased from 2% to 5%
            winStreak: 0,
            lossStreak: 0,
            marketVolatility: 0.15, // Reduced volatility
            tradingSession: 0,
            profitGrowthFactor: 1.2, // Increased starting growth
            lossReductionFactor: 0.8, // Increased loss reduction
            sessionMultiplier: 1.2, // Increased starting multiplier
            profitPerHour: 0,
            sessionStartTime: null,
            smartMode: true,
            aggressiveMode: false,
            riskLevel: 'low',
            lastTradeTime: null,
            tradeFrequency: 3000, // 3 seconds base
            maxProfitPerTrade: 500,
            minProfitPerTrade: 50
        };
    
        // ENHANCED Profit-Optimized Ethiopian Trading Bot
        class ProfitOptimizedEthiopianTradingBot {
            constructor() {
                this.pairs = [
                    'ETB/USD', 
                    'ETHIOPIAN COMMODITIES',
                    'LOCAL FOREX PAIRS',
                    'REGIONAL MARKETS',
                    'DIGITAL ASSETS'
                ];
                this.currentPair = this.pairs[0];
                this.investmentAmount = {{$amount}};
                this.lastPrice = this.generateOptimizedPrice();
                this.priceHistory = [this.lastPrice];
                this.minInvestment = 50;
                
                // Enhanced tier system for maximum profits
                if (this.investmentAmount >= 10000) {
                    this.tier = 'PLATINUM';
                    this.baseWinRate = 0.88; // 88% win rate
                    this.profitRange = { min: 200, max: 800 };
                    this.lossRange = { min: 25, max: 120 };
                } else if (this.investmentAmount >= 5000) {
                    this.tier = 'GOLD';
                    this.baseWinRate = 0.85;
                    this.profitRange = { min: 120, max: 500 };
                    this.lossRange = { min: 30, max: 100 };
                } else if (this.investmentAmount >= 2000) {
                    this.tier = 'SILVER';
                    this.baseWinRate = 0.82;
                    this.profitRange = { min: 60, max: 300 };
                    this.lossRange = { min: 20, max: 80 };
                } else if (this.investmentAmount >= 500) {
                    this.tier = 'BRONZE';
                    this.baseWinRate = 0.78;
                    this.profitRange = { min: 30, max: 150 };
                    this.lossRange = { min: 15, max: 60 };
                } else {
                    this.tier = 'BASIC';
                    this.baseWinRate = 0.75;
                    this.profitRange = { min: 20, max: 100 };
                    this.lossRange = { min: 10, max: 50 };
                }
                
                // Smart adjustments based on initial balance
                if (this.investmentAmount > 5000) {
                    botState.aggressiveMode = true;
                    botState.tradeFrequency = 2000; // Faster trades
                }
            }
    
            generateOptimizedPrice(basePrice = 56.5) {
                let priceChange;
                
                if (botState.aggressiveMode) {
                    priceChange = (Math.random() - 0.4) * 1.8; // More bullish bias
                } else {
                    priceChange = (Math.random() - 0.45) * 2.0;
                }
                
                // Strong trend following
                if (botState.marketTrend === 'bullish') {
                    priceChange += Math.random() * 2.0 + 0.5;
                } else if (botState.marketTrend === 'bearish') {
                    priceChange -= Math.random() * 1.5;
                }
                
                // Add momentum from previous wins
                if (botState.consecutiveWins > 3) {
                    priceChange += botState.consecutiveWins * 0.1;
                }
                
                return Math.max(50, basePrice + priceChange);
            }
    
            updateSmartMetrics() {
                botState.tradingSession++;
                
                // Smart profit scaling
                if (botState.consecutiveWins >= 3) {
                    botState.profitGrowthFactor = Math.min(2.0, botState.profitGrowthFactor + 0.03);
                    botState.lossReductionFactor = Math.max(0.5, botState.lossReductionFactor - 0.015);
                    botState.sessionMultiplier = Math.min(2.5, botState.sessionMultiplier + 0.03);
                }
                
                // Adjust trading frequency based on performance
                if (botState.winStreak >= 5) {
                    botState.tradeFrequency = Math.max(1500, botState.tradeFrequency - 100);
                }
                
                // Calculate profit per hour
                if (botState.sessionStartTime) {
                    const hoursRunning = (new Date() - botState.sessionStartTime) / 3600000;
                    if (hoursRunning > 0.1) { // After 6 minutes
                        botState.profitPerHour = botState.totalPnL / hoursRunning;
                        updateProfitPerHour();
                    }
                }
                
                // Update profit factor display
                document.getElementById('profitFactor').textContent = 
                    botState.sessionMultiplier.toFixed(1) + 'x';
            }
    
            updateMarketTrend() {
                let bullishProb = 0.65; // Higher base probability
                
                // Performance-based trend adjustment
                if (botState.winStreak >= 3) {
                    bullishProb = 0.75;
                }
                if (botState.lossStreak >= 2) {
                    bullishProb = 0.6; // Still optimistic
                }
                
                // Time-based trend (mornings more bullish)
                const hour = new Date().getHours();
                if (hour >= 9 && hour <= 15) { // Trading hours
                    bullishProb += 0.1;
                }
                
                const trendRandom = Math.random();
                if (trendRandom < bullishProb * 0.8) {
                    botState.marketTrend = 'bullish';
                } else if (trendRandom < bullishProb) {
                    botState.marketTrend = 'neutral';
                } else {
                    botState.marketTrend = 'bearish';
                }
            }
    
            calculateOptimizedWinRate() {
                let winRate = this.baseWinRate;
                
                // Enhanced trend bonuses
                if (botState.marketTrend === 'bullish') {
                    winRate += 0.08;
                } else if (botState.marketTrend === 'bearish') {
                    winRate -= 0.04;
                }
                
                // Performance momentum
                if (botState.winStreak >= 3) {
                    winRate += 0.04 * Math.min(botState.winStreak, 5);
                }
                if (botState.consecutiveWins >= 5) {
                    winRate += 0.03;
                }
                
                // Time of day bonus
                const hour = new Date().getHours();
                if (hour >= 10 && hour <= 14) { // Peak hours
                    winRate += 0.03;
                }
                
                // Keep within highly profitable bounds (75-90%)
                return Math.max(0.75, Math.min(0.90, winRate));
            }
    
            smartTradeDecision() {
                if (botState.currentBalance < this.minInvestment * 2) {
                    return false; // Preserve capital
                }
                
                let tradeProbability = 0.8; // High base probability
                
                // Smart adjustments
                if (botState.winStreak >= 3) {
                    tradeProbability = 0.9; // Capitalize on streaks
                } else if (botState.lossStreak >= 2) {
                    tradeProbability = 0.65; // Be cautious
                }
                
                // Market condition adjustments
                if (botState.marketTrend === 'bullish') {
                    tradeProbability += 0.1;
                }
                
                return Math.random() < tradeProbability;
            }
    
            calculateOptimizedProfitLoss(isWin) {
                let amount;
                
                if (isWin) {
                    // Enhanced profit calculation with multiple factors
                    const baseProfit = Math.random() * (this.profitRange.max - this.profitRange.min) + this.profitRange.min;
                    
                    // Apply all multipliers
                    amount = baseProfit;
                    amount *= botState.profitGrowthFactor;
                    amount *= botState.sessionMultiplier;
                    amount *= (1 + botState.profitBoost);
                    
                    // Streak bonus
                    if (botState.winStreak >= 3) {
                        amount *= (1 + botState.winStreak * 0.05);
                    }
                    
                    // Aggressive mode bonus
                    if (botState.aggressiveMode) {
                        amount *= 1.15;
                    }
                    
                    // Ensure minimum profit
                    amount = Math.max(this.profitRange.min * 1.5, amount);
                    
                    // Cap maximum profit
                    return Math.min(botState.maxProfitPerTrade, amount);
                } else {
                    // Controlled, minimized losses
                    amount = Math.random() * (this.lossRange.max - this.lossRange.min) + this.lossRange.min;
                    
                    // Apply loss reduction factors
                    amount *= botState.lossReductionFactor;
                    
                    // Further reduce after consecutive losses
                    if (botState.lossStreak >= 2) {
                        amount *= 0.7;
                    }
                    
                    // Minimum loss protection
                    amount = Math.max(this.lossRange.min * 0.3, amount);
                    
                    return -Math.min(botState.maxProfitPerTrade * 0.3, amount);
                }
            }
    
            executeOptimizedTrade() {
                if (!this.smartTradeDecision()) {
                    // Still log market analysis
                    if (Math.random() < 0.2) {
                        this.logMarketAnalysis();
                    }
                    return false;
                }
    
                // Update metrics
                this.updateSmartMetrics();
                
                // Update market trend periodically
                if (Math.random() < 0.15) {
                    this.updateMarketTrend();
                }
    
                const currentPrice = this.generateOptimizedPrice(this.lastPrice);
                const winProbability = this.calculateOptimizedWinRate();
                const isWinningTrade = Math.random() < winProbability;
                
                let pnl = this.calculateOptimizedProfitLoss(isWinningTrade);
                
                // Apply consistency and momentum bonuses
                const consistencyBonus = Math.abs(pnl) * 0.015; // 1.5% bonus
                pnl = pnl > 0 ? pnl + consistencyBonus : pnl - consistencyBonus * 0.5;
                
                // Update streaks
                if (isWinningTrade) {
                    botState.consecutiveWins++;
                    botState.winStreak++;
                    botState.lossStreak = 0;
                    
                    // Special bonus for consecutive wins
                    if (botState.consecutiveWins % 5 === 0) {
                        pnl *= 1.2; // 20% bonus every 5 consecutive wins
                        this.logSpecialBonus();
                    }
                } else {
                    botState.consecutiveWins = 0;
                    botState.winStreak = 0;
                    botState.lossStreak++;
                }
    
                // Update statistics
                botState.totalTrades++;
                botState.totalPnL += pnl;
                botState.currentBalance += pnl;
                botState.lastTradeTime = new Date();
                
                if (pnl > 0) {
                    botState.winningTrades++;
                }
    
                // Update profit counter in banner
                document.getElementById('profitCounter').textContent = 
                    `+ETB ${botState.totalPnL.toFixed(2)}`;
    
                // Enhanced logging with profit focus
                const timestamp = this.getCurrentTimestamp();
                const isBuy = Math.random() > 0.5;
                const tradeType = isBuy ? 'ግዢ / BUY 📈' : 'ሽያጭ / SELL 📉';
                const pnlText = pnl >= 0 ? 
                    `🎯 +ETB ${pnl.toFixed(2)}` : 
                    `⚠️ -ETB ${Math.abs(pnl).toFixed(2)}`;
                
                // Profit-focused logging
                if (pnl > 0) {
                    const successLevel = pnl > this.profitRange.min * 3 ? '🔥' : '✓';
                    const successMessages = [
                        `${successLevel} ለተሻለ ትርፍ! / Excellent profit!`,
                        `${successLevel} የኢትዮጵያ ገበያ በማሸነፍ ላይ! / Ethiopian market winning!`,
                        `${successLevel} ትርፉ እየጨመረ ነው! / Profit increasing!`,
                        `${successLevel} ስልቱ በቅጡ እየሰራ ነው! / Strategy working perfectly!`
                    ];
                    
                    const randomMessage = successMessages[Math.floor(Math.random() * successMessages.length)];
                    addLogEntry(timestamp, 
                        `${randomMessage} | ${tradeType} ${this.currentPair} @ ETB ${currentPrice.toFixed(2)} | ትርፍ / Profit: ${pnlText}`, 
                        'success');
                    
                    // Big win celebration
                    if (pnl > this.profitRange.min * 5) {
                        addLogEntry(timestamp, "🎊 ትልቅ ትርፍ! ስልቱ ከፍተኛ አፈፃፀም ያሳያል! / Huge profit! Strategy performing exceptionally!", 'success');
                        this.triggerProfitAnimation();
                    }
                } else {
                    const controlledMessages = [
                        "🛡️ የተቆጠበ ጉዳት / Protected loss",
                        "⚖️ የመሄጃ መውረድ / Strategic drawdown",
                        "📉 ትንሽ የገበያ ማረፊያ / Minor market correction",
                        "🎯 የሚቀጥለው ይሻላል! / Next one will be better!"
                    ];
                    addLogEntry(timestamp, 
                        `${controlledMessages[Math.floor(Math.random() * controlledMessages.length)]} | ${tradeType} ${this.currentPair} @ ETB ${currentPrice.toFixed(2)} | ጉዳት / Loss: ${pnlText}`, 
                        'warning');
                }
                
                // Milestone celebrations
                this.checkMilestones(timestamp);
                
                // Update database and UI
                this.updateWalletBalance(botState.currentBalance);
                this.updateAllStats();
                
                this.lastPrice = currentPrice;
                return true;
            }
    
            logMarketAnalysis() {
                const timestamp = this.getCurrentTimestamp();
                const analyses = [
                    "📊 የቴክኒካል አመላካቾች በጣም አወንታዊ / Technical indicators very positive",
                    "💰 የትርፍ እድሎች ከፍተኛ ናቸው / High profit opportunities",
                    "⚡ የገበያ ፍጥነት እየጨመረ ነው / Market momentum increasing",
                    "🎯 አመቺ የግብይት ሁኔታዎች / Favorable trading conditions",
                    "📈 የኢትዮጵያ ብር ጠንካራ እየሆነ ነው / Ethiopian Birr strengthening",
                    "💎 የብር ዋጋ ማረፊያ ያጋጠመዋል / Price consolidation detected"
                ];
                
                const randomAnalysis = analyses[Math.floor(Math.random() * analyses.length)];
                addLogEntry(timestamp, randomAnalysis, 'info');
            }
    
            logSpecialBonus() {
                const timestamp = this.getCurrentTimestamp();
                addLogEntry(timestamp, "🏆 ልዩ ቦነስ! 5 ተከታታይ የተሳኩ ግብይቶች! / Special bonus! 5 consecutive wins!", 'success');
            }
    
            checkMilestones(timestamp) {
                // Win streak milestones
                if (botState.winStreak === 5) {
                    addLogEntry(timestamp, "🔥 5 ተከታታይ ትርፎች! አስደናቂ አፈፃፀም! / 5 consecutive profits! Amazing performance!", 'success');
                }
                if (botState.winStreak === 10) {
                    addLogEntry(timestamp, "🚀 10 ተከታታይ ትርፎች! ከፍተኛ የስልት አፈፃፀም! / 10 consecutive profits! Maximum strategy performance!", 'success');
                }
                
                // Trade count milestones
                if (botState.totalTrades % 25 === 0 && botState.totalTrades > 0) {
                    const winRate = (botState.winningTrades / botState.totalTrades * 100).toFixed(1);
                    const totalProfit = botState.totalPnL.toFixed(2);
                    const profitPerTrade = (botState.totalPnL / botState.totalTrades).toFixed(2);
                    
                    addLogEntry(timestamp, 
                        `📊 ሚሊስቶን / Milestone: ${botState.totalTrades} ግብይቶች / trades | ${winRate}% ትክክለኛነት / accuracy | አጠቃላይ ትርፍ / Total: ETB ${totalProfit} | አማካይ ትርፍ በግብይት / Avg per trade: ETB ${profitPerTrade}`, 
                        'info');
                }
                
                // Profit milestones
                if (botState.totalPnL >= 1000 && botState.totalPnL < 1010) {
                    addLogEntry(timestamp, "🎉 ከETB 1,000 በላይ ትርፍ ተሰራ! / Over ETB 1,000 profit achieved!", 'success');
                }
            }
    
            triggerProfitAnimation() {
                const profitAlert = document.getElementById('profitAlert');
                profitAlert.style.animation = 'none';
                setTimeout(() => {
                    profitAlert.style.animation = 'slideIn 0.5s ease-out, glow 1s 3';
                }, 10);
            }
    
            updateWalletBalance(newBalance) {
                fetch('/api/update-wallet-balance', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        balance: newBalance
                    })
                }).catch(error => console.error('Error updating balance:', error));
            }
    
            updateAllStats() {
                // Update main stats
                document.getElementById('totalPnL').textContent = 
                    (botState.totalPnL >= 0 ? '+' : '') + 'ETB ' + Math.abs(botState.totalPnL).toFixed(2);
                document.getElementById('totalPnL').className = 
                    'stat-value ' + (botState.totalPnL >= 0 ? 'positive' : 'negative');
                
                document.getElementById('totalTrades').textContent = botState.totalTrades;
                document.getElementById('currentBalance').textContent = 
                    'ETB ' + botState.currentBalance.toFixed(2);
                
                const winRate = botState.totalTrades > 0 ? 
                    (botState.winningTrades / botState.totalTrades * 100).toFixed(1) : 0;
                document.getElementById('winRate').textContent = winRate + '%';
                document.getElementById('tradeAccuracy').textContent = winRate + '%';
                
                // Update profit streak indicator
                this.updateProfitStreak();
                
                // Mobile updates
                document.getElementById('mobileBalance').textContent = 
                    'ETB ' + botState.currentBalance.toFixed(2);
                const changeText = (botState.totalPnL >= 0 ? '+' : '') + 'ETB ' + Math.abs(botState.totalPnL).toFixed(2);
                document.getElementById('mobileBalanceChange').textContent = changeText;
                document.getElementById('mobileBalanceChange').className = 
                    'balance-change ' + (botState.totalPnL >= 0 ? 'positive' : 'negative');
                
                // Update tier display with performance metrics
                const growthPercent = ((botState.profitGrowthFactor - 1) * 100).toFixed(1);
                document.getElementById('currentTier').textContent = 
                    `${this.tier} | +${growthPercent}% Growth`;
            }
    
            updateProfitStreak() {
                const streakContainer = document.getElementById('profitStreak');
                streakContainer.innerHTML = '';
                
                const streakCount = Math.min(botState.consecutiveWins, 10);
                for (let i = 0; i < 10; i++) {
                    const dot = document.createElement('div');
                    dot.className = 'streak-dot' + (i < streakCount ? ' active' : '');
                    streakContainer.appendChild(dot);
                }
            }
    
            getCurrentTimestamp() {
                const now = new Date();
                const ethiopianTime = new Date(now.getTime() + (3 * 60 * 60 * 1000));
                return ethiopianTime.toTimeString().split(' ')[0] + '.' + 
                       ethiopianTime.getMilliseconds().toString().padStart(3, '0');
            }
        }
    
        // Initialize the ultimate profit-optimized trading bot
        const tradingBot = new ProfitOptimizedEthiopianTradingBot();
    
        // UI Update Functions
        function updateProfitPerHour() {
            document.getElementById('profitPerHour').textContent = 
                'ETB ' + Math.max(0, botState.profitPerHour).toFixed(0);
        }
    
        function addLogEntry(timestamp, message, type = 'info') {
            const logsContainer = document.getElementById('logsContainer');
            const logEntry = document.createElement('div');
            logEntry.className = `log-entry ${type}`;
            logEntry.innerHTML = `<span class="log-timestamp">[${timestamp} EAT]</span> <span class="log-${type}">${message}</span>`;
            logsContainer.appendChild(logEntry);
            logsContainer.scrollTop = logsContainer.scrollHeight;
            document.getElementById('logsCount').textContent = `${logsContainer.children.length} entries`;
        }
    
        // Quick Action Functions
        function boostProfits() {
            if (!botState.isRunning) return;
            
            botState.profitBoost += 0.02;
            botState.aggressiveMode = true;
            botState.tradeFrequency = Math.max(1000, botState.tradeFrequency - 500);
            
            const timestamp = tradingBot.getCurrentTimestamp();
            addLogEntry(timestamp, "⚡ ትርፍ እፍጋት ተነሳ! የግብይት ፍጥነት እና ትርፍ መጠን ጨምሯል! / Profit boost activated! Increased trading speed and profit margin!", 'success');
        }
    
        function analyzeMarket() {
            const timestamp = tradingBot.getCurrentTimestamp();
            const analyses = [
                "🔍 ገበያ ትንተና: ትርፋማ እድሎች ከፍተኛ / Market analysis: High profit opportunities",
                "📈 የዋጋ እንቅስቃሴ: ወደ ላይ እየመራ ነው / Price action: Trending upward",
                "💹 የብዝበዛ መጠን: ከፍተኛ እና ጠቃሚ / Volume: High and favorable",
                "🎯 የገበያ ሁኔታ: ለንግድ በጣም አመቺ / Market condition: Highly favorable for trading"
            ];
            
            addLogEntry(timestamp, analyses[Math.floor(Math.random() * analyses.length)], 'info');
        }
    
        function optimizeStrategy() {
            tradingBot.updateSmartMetrics();
            const timestamp = tradingBot.getCurrentTimestamp();
            
            addLogEntry(timestamp, "🎯 የንግድ ስልት በተመራጭ ሁኔታ ተቀይሯል! / Trading strategy optimally adjusted!", 'success');
            addLogEntry(timestamp, `📊 አዲስ ቅንብሮች: ትርፍ ማባዣ = ${botState.sessionMultiplier.toFixed(1)}x | የማሸነፍ እድል = ${(tradingBot.calculateOptimizedWinRate()*100).toFixed(1)}%`, 'info');
        }
    
        // Bot Control Functions
        function startBot() {
            botState.isRunning = true;
            botState.isPaused = false;
            botState.totalRuns++;
            botState.sessionStartTime = new Date();
            
            document.getElementById('totalRuns').textContent = botState.totalRuns;
            updateBotStatus('running', '💰 ትርፋማ ንግድ በመካሄድ ላይ / Profitable Trading Active');
            
            document.getElementById('startBtn').disabled = true;
            document.getElementById('pauseBtn').disabled = false;
            document.getElementById('stopBtn').disabled = false;
            
            const timestamp = tradingBot.getCurrentTimestamp();
            addLogEntry(timestamp, `🚀 የትርፍ-አመቻች ኢትዮጵያ ንግድ ሮቦት ተጅምሯል! / Profit-optimized Ethiopian Trading Bot launched!`, 'success');
            addLogEntry(timestamp, `💎 ደረጃ / Tier: ${tradingBot.tier} | መሠረታዊ የማሸነፍ መጠን / Base win rate: ${(tradingBot.baseWinRate*100).toFixed(1)}%`, 'info');
            addLogEntry(timestamp, `🎯 አላማ / Target: ETB ${tradingBot.profitRange.min}-${tradingBot.profitRange.max} per winning trade`, 'info');
            addLogEntry(timestamp, `⚡ ከፍተኛ ትርፍ ሞድ ነቅቷል! / Maximum profit mode activated!`, 'success');
            
            // Optimized trading intervals
            botState.tradingInterval = setInterval(() => {
                if (botState.isRunning && !botState.isPaused) {
                    tradingBot.executeOptimizedTrade();
                }
            }, botState.tradeFrequency);
            
            // Enhanced market analysis
            botState.logInterval = setInterval(() => {
                if (botState.isRunning && !botState.isPaused) {
                    tradingBot.logMarketAnalysis();
                }
            }, Math.random() * 8000 + 4000);
            
            // Performance monitoring
            botState.analysisInterval = setInterval(() => {
                if (botState.isRunning && !botState.isPaused) {
                    tradingBot.updateSmartMetrics();
                }
            }, 30000); // Every 30 seconds
        }
    
        function pauseBot() {
            botState.isPaused = !botState.isPaused;
            const pauseBtn = document.getElementById('pauseBtn');
            if (botState.isPaused) {
                updateBotStatus('paused', '⏸️ ተቆምቷል / Paused');
                pauseBtn.textContent = '▶️ እንደገና ጀምር / Resume';
                addLogEntry(tradingBot.getCurrentTimestamp(), '⏸️ ንግዱ በቅጥ ተቆምቷል / Trading strategically paused', 'warning');
            } else {
                updateBotStatus('running', '💰 ትርፋማ ንግድ በመካሄድ ላይ / Profitable Trading Active');
                pauseBtn.textContent = '⏸️ አቁም / Pause';
                addLogEntry(tradingBot.getCurrentTimestamp(), '▶️ ንግዱ በተመራጭ ሁኔታ ቀጥሏል / Trading optimally resumed', 'success');
            }
        }
    
        function stopBot() {
            if (confirm('ንግድ ሮቦቱን ማቆም ትፈልጋለህ? የተሰራ ትርፍ ይቆጠራል! / Stop the trading bot? Profits will be saved!')) {
                botState.isRunning = false;
                botState.isPaused = false;
                clearInterval(botState.tradingInterval);
                clearInterval(botState.logInterval);
                clearInterval(botState.analysisInterval);
                updateBotStatus('stopped', '✅ ትርፍ ተቀምጧል / Profits Saved');
                
                document.getElementById('startBtn').disabled = false;
                document.getElementById('pauseBtn').disabled = true;
                document.getElementById('stopBtn').disabled = true;
                
                const winRate = botState.totalTrades > 0 ? 
                    (botState.winningTrades/botState.totalTrades*100).toFixed(1) : 0;
                const profitPerHour = botState.profitPerHour.toFixed(2);
                
                const finalStats = `📊 የክፍለ ጊዜ ማጠቃለያ / Session Summary:
                ${botState.totalTrades} ግብይቶች / trades
                ${winRate}% የማሸነፍ መጠን / win rate
                አጠቃላይ ትርፍ / Net P&L: ${botState.totalPnL >= 0 ? '+' : ''}ETB ${botState.totalPnL.toFixed(2)}
                በሰዓት ትርፍ / Profit per hour: ETB ${profitPerHour}`;
                
                addLogEntry(tradingBot.getCurrentTimestamp(), '✅ ንግድ ሮቦቱ በትክክል ተቆምቷል / Trading bot successfully stopped', 'success');
                addLogEntry(tradingBot.getCurrentTimestamp(), finalStats, 'info');
                
                // Performance rating
                if (botState.totalPnL > 500) {
                    addLogEntry(tradingBot.getCurrentTimestamp(), '🏆 ከፍተኛ አፈፃፀም! በጣም ትርፋማ ክፍለ ጊዜ! / Excellent performance! Highly profitable session!', 'success');
                } else if (botState.totalPnL > 100) {
                    addLogEntry(tradingBot.getCurrentTimestamp(), '✅ ጥሩ አፈፃፀም! ትርፋማ ክፍለ ጊዜ / Good performance! Profitable session', 'success');
                } else if (botState.totalPnL > 0) {
                    addLogEntry(tradingBot.getCurrentTimestamp(), '📈 አወንታዊ አፈፃፀም! የሚቀጥለው ይበልጣል! / Positive performance! Next will be better!', 'info');
                }
            }
        }
    
        function updateBotStatus(status, text) {
            const statusBadge = document.getElementById('statusBadge');
            const statusDot = document.getElementById('statusDot');
            const statusText = document.getElementById('statusText');
            statusBadge.className = `status-badge ${status}`;
            statusDot.className = `status-dot ${status}`;
            statusText.textContent = text;
        }
    
        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            @if(Auth::user()->wallet_balance >= $amount)
                document.getElementById('startBtn').addEventListener('click', startBot);
                document.getElementById('pauseBtn').addEventListener('click', pauseBot);
                document.getElementById('stopBtn').addEventListener('click', stopBot);
                updateBotStatus('stopped', '🚀 ለትርፋማ ንግድ ዝግጁ / Ready for Profitable Trading');
            @endif
            
            const timestamp = tradingBot.getCurrentTimestamp();
            addLogEntry(timestamp, `💎 የትርፍ-አመቻች ኢትዮጵያ ንግድ ስርዓት ተጭኗል / Profit-optimized Ethiopian Trading System loaded`, 'success');
            addLogEntry(timestamp, `💰 የመጀመሪያ ሒሳብ / Initial Balance: ETB ${botState.currentBalance.toFixed(2)}`, 'info');
            addLogEntry(timestamp, `⚡ ${tradingBot.tier} ደረጃ - ከፍተኛ ትርፍ ሞድ / ${tradingBot.tier} Tier - Maximum Profit Mode`, 'info');
            addLogEntry(timestamp, `🎯 አላማዎች / Targets: ${(tradingBot.baseWinRate*100).toFixed(1)}% win rate | ETB ${tradingBot.profitRange.min}+ per trade | Automated profit growth`, 'info');
            
            @if(Auth::user()->wallet_balance < $amount)
                addLogEntry(timestamp, '❌ በቂ ሒሳብ ቀሪ ሂሳብ የለም / Add funds to start profitable trading', 'error');
                addLogEntry(timestamp, '💡 ምክር / Tip: Deposit at least ETB 500 for optimal profit potential', 'info');
            @endif
        });
    </script>
    <!-- CSRF Token for AJAX requests -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</body>
@endsection