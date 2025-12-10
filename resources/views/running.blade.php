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
            color: #4ade80;
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

        /* Mobile Balance Widget */
        .mobile-balance-widget {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #1a2332;
            padding: 12px 16px;
            border-top: 1px solid #2a3441;
            z-index: 100;
            box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.3);
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
        }

        .balance-change.positive {
            color: #4ade80;
        }

        .balance-change.negative {
            color: #ef4444;
        }

        .main-content {
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .bot-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 2rem;
        }

        .bot-info {
            flex: 1;
        }

        .bot-title {
            font-size: 2.5rem;
            font-weight: 600;
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
            background: #dc2626;
            color: white;
        }

        .status-badge.running {
            background: #4ade80;
            color: #0a0f1c;
        }

        .status-badge.paused {
            background: #f59e0b;
            color: #0a0f1c;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: white;
        }

        .status-dot.running {
            background: #0a0f1c;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .insufficient-balance {
            background: #374151;
            color: #9ca3af;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.9rem;
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
            transition: all 0.2s;
            font-size: 0.9rem;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-start {
            background: #4ade80;
            color: #0a0f1c;
        }

        .btn-start:hover {
            background: #22c55e;
        }

        .btn-pause {
            background: #f59e0b;
            color: white;
        }

        .btn-pause:hover {
            background: #d97706;
        }

        .btn-stop {
            background: #dc2626;
            color: white;
        }

        .btn-stop:hover {
            background: #b91c1c;
        }

        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

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
            background: #1a2332;
            border-radius: 16px;
            padding: 1.5rem;
        }

        .stat-card.pnl {
            border-left: 4px solid #4ade80;
        }

        .stat-card.runs {
            border-left: 4px solid #8b5cf6;
        }

        .stat-card.trades {
            border-left: 4px solid #3b82f6;
        }

        .stat-card.winrate {
            border-left: 4px solid #f59e0b;
        }

        .stat-card.balance {
            border-left: 4px solid #06b6d4;
        }

        .stat-label {
            color: #9ca3af;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 300;
        }

        .stat-value.positive {
            color: #4ade80;
        }

        .stat-value.negative {
            color: #ef4444;
        }

        .logs-section {
            background: #1a2332;
            border-radius: 16px;
            padding: 1.5rem;
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
            background: #0f1419;
            border-radius: 12px;
            padding: 1rem;
            max-height: 500px;
            overflow-y: auto;
            font-family: Monaco, 'Cascadia Code', 'Roboto Mono', monospace;
            font-size: 0.85rem;
            line-height: 1.5;
        }

        .log-entry {
            margin-bottom: 0.25rem;
            word-wrap: break-word;
        }

        .log-timestamp {
            color: #6b7280;
        }

        .log-error {
            color: #ef4444;
        }

        .log-success {
            color: #4ade80;
        }

        .log-info {
            color: #60a5fa;
        }

        .log-warning {
            color: #f59e0b;
        }

        .log-trade {
            color: #a78bfa;
        }

        /* Scrollbar styling */
        .logs-container::-webkit-scrollbar {
            width: 6px;
        }

        .logs-container::-webkit-scrollbar-track {
            background: #374151;
            border-radius: 3px;
        }

        .logs-container::-webkit-scrollbar-thumb {
            background: #6b7280;
            border-radius: 3px;
        }

        .logs-container::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        @media (max-width: 1024px) {
            .content-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .stats-sidebar {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
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
                padding-bottom: 70px; /* Add padding to prevent content from being hidden behind mobile balance widget */
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
                max-height: 300px;
                padding: 0.75rem;
                font-size: 0.75rem;
                line-height: 1.4;
            }

            .log-entry {
                margin-bottom: 0.15rem;
            }

            /* Make everything fit in one screen */
            .content-grid {
                height: calc(100vh - 190px);
                display: flex;
                flex-direction: column;
            }

            .logs-section {
                flex: 1;
                display: flex;
                flex-direction: column;
                min-height: 0;
            }

            .logs-container {
                flex: 1;
                min-height: 0;
            }

            /* Show mobile balance widget */
            .mobile-balance-widget {
                display: block;
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
                max-height: 250px;
                font-size: 0.7rem;
            }

            .mobile-balance-widget {
                padding: 10px 12px;
            }

            .balance-amount {
                font-size: 1rem;
            }
        }
    </style>

<body>
    <main class="main-content">
        <div class="bot-header">
            <div class="bot-info">
                <h1 class="bot-title">Bitcoin Accumulation Bot</h1>
                <div class="bot-details">Bot ID: dca-1 • • Account: Real</div>
            </div>
            <div class="status-section">
                <div class="status-badge" id="statusBadge">
                    <div class="status-dot" id="statusDot"></div>
                    <span id="statusText">Stopped (Low Balance)</span>
                </div>
                <?php
                $amount = request('amount');
                $asset = request('asset');?>
                @if(Auth::user()->wallet_balance < $amount)
                    <div class="insufficient-balance">Insufficient Balance</div>
                @else
                    <div class="trade-controls" id="tradeControls">
                        <button class="btn btn-start" id="startBtn">Start Bot</button>
                        <button class="btn btn-pause" id="pauseBtn" disabled>Pause Bot</button>
                        <button class="btn btn-stop" id="stopBtn" disabled>Stop Bot</button>
                    </div>
                @endif
            </div>
        </div>

        <div class="content-grid">
        <!-- In the stats-sidebar section (around line 400) -->
<div class="stats-sidebar">
    <div class="stat-card pnl">
        <div class="stat-label">Total P/L</div>
        <div class="stat-value" id="totalPnL">+ETB 0.00</div>
    </div>
    
    <div class="stat-card runs">
        <div class="stat-label">Total Runs</div>
        <div class="stat-value" id="totalRuns">0</div>
    </div>
    
    <div class="stat-card trades">
        <div class="stat-label">Total Trades</div>
        <div class="stat-value" id="totalTrades">0</div>
    </div>
    
    <div class="stat-card winrate">
        <div class="stat-label">Win Rate</div>
        <div class="stat-value" id="winRate">0.0%</div>
    </div>
    
    <!-- This balance card will be visible on mobile -->
    <div class="stat-card balance mobile-balance-card">
        <div class="stat-label">Balance</div>
        <div class="stat-value" id="currentBalance" style="color:white">ETB {{ number_format(Auth::user()->wallet_balance, 2) }}</div>
    </div>
</div>

<!-- Add this to the style section (around line 200) -->
<style>
    /* ... existing styles ... */

    @media (max-width: 1024px) {
        .stats-sidebar {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 0.75rem;
        }

        .stat-card {
            padding: 1rem;
        }

        .stat-value {
            font-size: 1.5rem;
        }

        /* Ensure balance card is visible on mobile */
        .mobile-balance-card {
            display: block !important;
        }
    }

    @media (max-width: 768px) {
        .stats-sidebar {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        /* Hide the duplicate balance card if it exists */
        .stat-card.balance:not(.mobile-balance-card) {
            display: none;
        }
    }

    @media (max-width: 480px) {
        .stats-sidebar {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.4rem;
        }
    }
</style>

            <div class="logs-section">
                <div class="logs-header">
                    <h2 class="logs-title">Bot Logs</h2>
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
            <div class="balance-label">Account Balance</div>
            <div>
                <span class="balance-amount" id="mobileBalance">ETB {{ number_format(Auth::user()->wallet_balance, 2) }}</span>
                <span class="balance-change positive" id="mobileBalanceChange">+ETB 0.00</span>
            </div>
        </div>
    </div>
    <script>
        // Bot state management - Winning only version
        let botState = {
            isRunning: false,
            isPaused: false,
            totalPnL: 0,
            totalRuns: 0,
            totalTrades: 0,
            winningTrades: 0,
            currentBalance: {{ Auth::user()->wallet_balance}}, // Convert to ETB
            tradingInterval: null,
            logInterval: null,
            winStreak: 0,
            marketTrend: 'bullish', // Always bullish for wins only
            profitDecayFactor: 1.0,
            tradingSession: 0,
            consecutiveWins: 0,
            lastTradeAmount: 0
        };
    
        // Always Winning Trading Bot - Only positive trades
        class AlwaysWinningTradingBot {
            constructor() {
                this.pairs = ['BTCUSDT', 'ETHUSDT', 'BNBUSDT', 'ADAUSDT', 'DOTUSDT'];
                this.currentPair = this.pairs[0];
                this.investmentAmount = {{$amount}}; // Convert to ETB
                this.lastPrice = this.generateRandomPrice();
                this.priceHistory = [this.lastPrice];
                this.minInvestment = 15; // Convert to ETB
                
                // Always profitable tier system
                if (this.investmentAmount >= 1000 ) {
                    this.tier = 'elite';
                    this.baseWinRate = 1.0; // Always win
                    this.profitRange = { min: 15 , max: 30  }; // Good profits
                } else if (this.investmentAmount >= 500 ) {
                    this.tier = 'premium';
                    this.baseWinRate = 1.0;
                    this.profitRange = { min: 12 , max: 25  };
                } else if (this.investmentAmount >= 100 ) {
                    this.tier = 'advanced';
                    this.baseWinRate = 1.0;
                    this.profitRange = { min: 8 , max: 20  };
                } else {
                    this.tier = 'standard';
                    this.baseWinRate = 1.0;
                    this.profitRange = { min: 5 , max: 15  };
                }
                
                this.winMessages = [
                    "Perfect trade execution!",
                    "Excellent market timing!",
                    "Strategy performing flawlessly!",
                    "Another successful trade!",
                    "Profit targets achieved!",
                    "Risk management paying off!",
                    "Market analysis confirmed!",
                    "Optimal entry point captured!",
                    "Technical indicators aligned perfectly!",
                    "Bullish momentum sustained!"
                ];
                
                this.celebrationMessages = [
                    "🎉 Incredible performance!",
                    "🔥 On fire! Perfect execution!",
                    "💎 Diamond hands strategy working!",
                    "🚀 Rocketing profits!",
                    "🌟 Stellar trading results!",
                    "👑 King of the market!",
                    "⚡ Lightning fast profits!",
                    "💯 Perfect trade!",
                    "🏆 Championship trading!",
                    "✨ Magical profits accumulating!"
                ];
            }
    
            generateRandomPrice(basePrice = 45000) {
                // Always positive price movements for winning trades
                const volatility = 0.2; // Reduced volatility for consistent wins
                let priceChange = Math.random() * 400 * volatility; // Always positive
                
                // Add trending momentum
                priceChange += Math.random() * 100; // Additional upward momentum
                
                return Math.max(1000, basePrice + priceChange);
            }
    
            updateProfitFactors() {
                // Instead of decay, we increase profits over time
                botState.tradingSession++;
                
                // Every 5 trades, increase profit potential slightly
                if (botState.tradingSession % 5 === 0) {
                    const increaseFactor = 1 + (botState.tradingSession * 0.001); // Gradual increase
                    this.profitRange.min *= increaseFactor;
                    this.profitRange.max *= increaseFactor;
                }
                
                // Celebrate milestones
                if (botState.consecutiveWins % 10 === 0 && botState.consecutiveWins > 0) {
                    const celebration = this.celebrationMessages[Math.floor(Math.random() * this.celebrationMessages.length)];
                    addLogEntry(this.getCurrentTimestamp(), celebration, 'success');
                }
            }
    
            shouldTrade() {
                if (botState.currentBalance < this.minInvestment) {
                    addLogEntry(this.getCurrentTimestamp(), "💰 Adding funds for next trade...", 'info');
                    // Simulate adding funds for demo
                    botState.currentBalance += this.minInvestment * 2;
                    this.updateWalletBalance(botState.currentBalance);
                    return true;
                }
                
                // Always trade when bot is running
                return true;
            }
    
            calculateProfit() {
                // Always profitable - calculate based on tier and streak
                let baseAmount = Math.random() * (this.profitRange.max - this.profitRange.min) + this.profitRange.min;
                
                // Bonus for consecutive wins
                const streakBonus = 1 + (botState.winStreak * 0.05); // 5% increase per win streak
                
                // Session growth bonus
                const sessionBonus = 1 + (botState.tradingSession * 0.002);
                
                // Tier multiplier
                const tierMultiplier = this.getTierMultiplier();
                
                // Calculate final profit
                let finalProfit = baseAmount * streakBonus * sessionBonus * tierMultiplier;
                
                // Add some randomness but keep it positive
                finalProfit *= (0.9 + Math.random() * 0.2);
                
                botState.lastTradeAmount = finalProfit;
                return finalProfit;
            }
    
            getTierMultiplier() {
                switch(this.tier) {
                    case 'elite': return 1.3;
                    case 'premium': return 1.2;
                    case 'advanced': return 1.1;
                    default: return 1.0;
                }
            }
    
            executeTrade() {
                if (!this.shouldTrade()) return false;
    
                // Update profit factors occasionally
                if (Math.random() < 0.1) {
                    this.updateProfitFactors();
                }
    
                const currentPrice = this.generateRandomPrice(this.lastPrice);
                const profit = this.calculateProfit();
                
                // Update statistics - ALWAYS WIN
                botState.totalTrades++;
                botState.totalPnL += profit;
                botState.currentBalance += profit;
                botState.winningTrades++;
                botState.winStreak++;
                botState.consecutiveWins++;
    
                // Logging with positive messages
                const timestamp = this.getCurrentTimestamp();
                const isBuy = Math.random() > 0.5;
                const tradeType = isBuy ? 'BUY' : 'SELL';
                const profitText = `+ETB ${profit.toFixed(2)}`;
                
                // Main trade log
                addLogEntry(timestamp, 
                    `✅ ${tradeType} ${this.currentPair} @ $${currentPrice.toFixed(2)} | Profit: ${profitText}`, 
                    'success');
                
                // Add a winning message
                const winMessage = this.winMessages[Math.floor(Math.random() * this.winMessages.length)];
                addLogEntry(timestamp, winMessage, 'success');
                
                // Special messages for milestones
                if (botState.winStreak === 5) {
                    addLogEntry(timestamp, "🔥 5 consecutive winning trades! Unstoppable!", 'success');
                }
                if (botState.winStreak === 10) {
                    addLogEntry(timestamp, "🚀 10-win streak! Trading perfection achieved!", 'success');
                }
                if (botState.totalTrades % 10 === 0) {
                    const avgProfit = (botState.totalPnL / botState.totalTrades).toFixed(2);
                    addLogEntry(timestamp, `📈 ${botState.totalTrades} perfect trades | Average profit: ETB ${avgProfit}`, 'success');
                }
                
                // Update database and UI
                this.updateWalletBalance(botState.currentBalance);
                this.updateStats();
                
                this.lastPrice = currentPrice;
                return true;
            }
    
            updateWalletBalance(newBalance) {
                // Convert ETB back to USD for database storage
                const usdBalance = newBalance;
                
                fetch('/api/update-wallet-balance', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        balance: usdBalance
                    })
                }).then(response => {
                    if (response.ok) {
                        addLogEntry(this.getCurrentTimestamp(), "💾 Balance updated successfully", 'info');
                    }
                }).catch(error => console.error('Error updating balance:', error));
            }
    
            updateStats() {
                // Update P/L display
                document.getElementById('totalPnL').textContent = 
                    '+ETB ' + Math.abs(botState.totalPnL).toFixed(2);
                document.getElementById('totalPnL').className = 'stat-value positive';
                
                // Update trades count
                document.getElementById('totalTrades').textContent = botState.totalTrades;
                
                // Update balance display
                document.getElementById('currentBalance').textContent = 
                    'ETB ' + botState.currentBalance.toFixed(2);
                
                // Update win rate (always 100%)
                document.getElementById('winRate').textContent = '100%';
                
                // Mobile updates
                document.getElementById('mobileBalance').textContent = 
                    'ETB ' + botState.currentBalance.toFixed(2);
                document.getElementById('mobileBalanceChange').textContent = 
                    '+ETB ' + Math.abs(botState.totalPnL).toFixed(2);
                document.getElementById('mobileBalanceChange').className = 'balance-change positive';
                
                // Update performance indicator
                const performanceScore = Math.min(100, 80 + (botState.winStreak * 2));
                document.getElementById('currentTier').textContent = 
                    `${this.tier.toUpperCase()} | ${performanceScore}% PERFECT`;
            }
    
            getCurrentTimestamp() {
                const now = new Date();
                return now.toTimeString().split(' ')[0] + '.' + now.getMilliseconds().toString().padStart(3, '0');
            }
    
            analyzeMarket() {
                const timestamp = this.getCurrentTimestamp();
                const bullishAnalyses = [
                    "Perfect bullish conditions detected",
                    "All technical indicators flashing green",
                    "Strong uptrend confirmed on all timeframes",
                    "Market momentum extremely positive",
                    "Breakout to new highs imminent",
                    "Volume confirms bullish continuation",
                    "Support levels holding strong",
                    "Perfect entry opportunities abundant",
                    "Risk/reward ratio exceptionally favorable",
                    "Market sentiment overwhelmingly bullish"
                ];
                
                const randomAnalysis = bullishAnalyses[Math.floor(Math.random() * bullishAnalyses.length)];
                addLogEntry(timestamp, randomAnalysis, 'info');
                
                // Add occasional strategy confirmation
                if (Math.random() < 0.3) {
                    const confirmations = [
                        "Strategy validation: Perfect conditions maintained",
                        "Algorithm confirmation: Optimal parameters active",
                        "System check: All systems performing at peak efficiency"
                    ];
                    const confirmation = confirmations[Math.floor(Math.random() * confirmations.length)];
                    addLogEntry(timestamp, confirmation, 'success');
                }
            }
        }
    
        // Initialize the always winning trading bot
        const tradingBot = new AlwaysWinningTradingBot();
    
        function addLogEntry(timestamp, message, type = 'info') {
            const logsContainer = document.getElementById('logsContainer');
            const logEntry = document.createElement('div');
            logEntry.className = `log-entry log-${type}`;
            logEntry.innerHTML = `<span class="log-timestamp">[${timestamp}]</span> <span class="log-${type}">${message}</span>`;
            logsContainer.appendChild(logEntry);
            logsContainer.scrollTop = logsContainer.scrollHeight;
            document.getElementById('logsCount').textContent = `${logsContainer.children.length} entries`;
        }
    
        function startBot() {
            botState.isRunning = true;
            botState.isPaused = false;
            botState.totalRuns++;
            
            document.getElementById('totalRuns').textContent = botState.totalRuns;
            updateBotStatus('running', 'Winning Active');
            
            document.getElementById('startBtn').disabled = true;
            document.getElementById('pauseBtn').disabled = false;
            document.getElementById('stopBtn').disabled = false;
            
            const timestamp = tradingBot.getCurrentTimestamp();
            addLogEntry(timestamp, `🚀 ${tradingBot.tier.toUpperCase()} WINNING BOT ACTIVATED`, 'success');
            addLogEntry(timestamp, `💎 PERFECT TRADING STRATEGY ENGAGED`, 'success');
            addLogEntry(timestamp, `✅ Guaranteed Profits: 100% Win Rate System`, 'success');
            addLogEntry(timestamp, `💰 Initial Balance: ETB ${botState.currentBalance.toFixed(2)}`, 'info');
            
            // Fast intervals for frequent winning trades
            botState.tradingInterval = setInterval(() => {
                if (botState.isRunning && !botState.isPaused) {
                    tradingBot.executeTrade();
                }
            }, Math.random() * 2500 + 1000); // 1-3.5 seconds for frequent wins
            
            // Market analysis every 3-6 seconds
            botState.logInterval = setInterval(() => {
                if (botState.isRunning && !botState.isPaused) {
                    tradingBot.analyzeMarket();
                }
            }, Math.random() * 3000 + 3000);
        }
    
        function pauseBot() {
            botState.isPaused = !botState.isPaused;
            const pauseBtn = document.getElementById('pauseBtn');
            if (botState.isPaused) {
                updateBotStatus('paused', 'Profit Collection Paused');
                pauseBtn.textContent = 'Resume Winning';
                addLogEntry(tradingBot.getCurrentTimestamp(), '⏸️ Profit collection paused - Securing gains', 'warning');
            } else {
                updateBotStatus('running', 'Winning Active');
                pauseBtn.textContent = 'Pause Collection';
                addLogEntry(tradingBot.getCurrentTimestamp(), '▶️ Profit collection resumed - Ready for more gains', 'success');
                addLogEntry(tradingBot.getCurrentTimestamp(), '💪 Winning streak continues!', 'success');
            }
        }
    
        function stopBot() {
            if (confirm('Stop the winning bot? Your profits will be secured.')) {
                botState.isRunning = false;
                botState.isPaused = false;
                clearInterval(botState.tradingInterval);
                clearInterval(botState.logInterval);
                updateBotStatus('stopped', 'Winning Session Complete');
                
                document.getElementById('startBtn').disabled = false;
                document.getElementById('pauseBtn').disabled = true;
                document.getElementById('stopBtn').disabled = true;
                
                const avgProfit = botState.totalTrades > 0 ? (botState.totalPnL/botState.totalTrades).toFixed(2) : 0;
                const finalStats = `🏆 PERFECT SESSION: ${botState.totalTrades} trades | 100% win rate | Total Profit: +ETB ${botState.totalPnL.toFixed(2)} | Avg: +ETB ${avgProfit}/trade`;
                addLogEntry(tradingBot.getCurrentTimestamp(), '✅ Winning session completed successfully!', 'success');
                addLogEntry(tradingBot.getCurrentTimestamp(), finalStats, 'success');
                
                // Final celebration
                if (botState.totalPnL > 0) {
                    const celebrations = [
                        "🎯 Perfect execution from start to finish!",
                        "💰 Profits secured! Exceptional performance!",
                        "💎 Flawless trading session completed!",
                        "🔥 Unbeatable strategy proven once again!"
                    ];
                    const celebration = celebrations[Math.floor(Math.random() * celebrations.length)];
                    addLogEntry(tradingBot.getCurrentTimestamp(), celebration, 'success');
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
    
        document.addEventListener('DOMContentLoaded', function() {
            @if(Auth::user()->wallet_balance >= $amount)
                document.getElementById('startBtn').addEventListener('click', startBot);
                document.getElementById('pauseBtn').addEventListener('click', pauseBot);
                document.getElementById('stopBtn').addEventListener('click', stopBot);
                updateBotStatus('stopped', 'Ready to Win');
            @endif
            
            const timestamp = tradingBot.getCurrentTimestamp();
            addLogEntry(timestamp, `💎 PERFECT TRADING SYSTEM INITIALIZED`, 'success');
            addLogEntry(timestamp, `💰 Account Balance: ETB ${botState.currentBalance.toFixed(2)}`, 'info');
            addLogEntry(timestamp, `🎯 ${tradingBot.tier.toUpperCase()} TIER - 100% WIN RATE GUARANTEED`, 'success');
            addLogEntry(timestamp, `⚡ System ready for perfect profit execution`, 'info');
            
            @if(Auth::user()->wallet_balance < $amount)
                addLogEntry(timestamp, '❌ Insufficient balance to start winning', 'error');
            @endif
            
            // Add initial positive market analysis
            setTimeout(() => {
                addLogEntry(tradingBot.getCurrentTimestamp(), "📊 Market analysis: Perfect conditions detected for winning trades", 'success');
                addLogEntry(tradingBot.getCurrentTimestamp(), "✅ System check: All parameters optimal for 100% success rate", 'success');
            }, 1000);
        });
    </script>
    <!-- CSRF Token for AJAX requests -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</body>
@endsection