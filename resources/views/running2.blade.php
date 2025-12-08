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
                max-height: 300px;
                padding: 0.75rem;
                font-size: 0.75rem;
                line-height: 1.4;
            }

            .log-entry {
                margin-bottom: 0.15rem;
            }

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
                <h1 class="bot-title">የኢትዮጵያ ኢተርየም ንግድ ሮቦት</h1>
                <h2 class="bot-title">Ethiopian Ethereum Trading Bot (ETB)</h2>
                <div class="bot-details">Bot ID: ETH-ETB-DCA-1 • Account: Real • Currency: Ethiopian Birr (ETB)</div>
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
            <div class="stats-sidebar">
                <div class="stat-card pnl">
                    <div class="stat-label">ጠቅላላ ትርፍ/ጉዳት</div>
                    <div class="stat-label">Total P/L</div>
                    <div class="stat-value" id="totalPnL">+ETB 0.00</div>
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
                
                <div class="stat-card balance mobile-balance-card">
                    <div class="stat-label">ሒሳብ ቀሪ ሂሳብ</div>
                    <div class="stat-label">Account Balance</div>
                    <div class="stat-value" id="currentBalance" style="color:white">ETB {{ number_format(Auth::user()->wallet_balance, 2) }}</div>
                </div>

                <div class="stat-card" id="currentTierCard">
                    <div class="stat-label">የአሁን ደረጃ</div>
                    <div class="stat-label">Current Tier</div>
                    <div class="stat-value" id="currentTier" style="font-size: 1.2rem; color: #4ade80">BASIC</div>
                </div>
            </div>

            <div class="logs-section">
                <div class="logs-header">
                    <h2 class="logs-title">የሮቦት መዝገቦች / Bot Logs</h2>
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
        // PROFITABLE Ethiopian Ethereum Trading Bot
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
            consecutiveWins: 0,
            marketTrend: 'bullish',
            profitBoost: 0.025, // 2.5% profit boost for consistency
            winStreak: 0,
            lossStreak: 0,
            overallProfitable: true,
            marketVolatility: 0.18,
            tradingSession: 0,
            profitGrowthFactor: 1.0, // Gradually increases over time
            lossReductionFactor: 0.9, // Gradually decreases losses
            sessionMultiplier: 1.0, // Multiplier that grows with successful sessions
            ethereumPrice: 2500 // Ethereum base price in USD for conversion
        };
    
        // PROFITABLE Ethiopian Ethereum Trading Bot
        class EthiopianEthereumBot {
            constructor() {
                // Ethereum trading pairs with ETB conversion
                this.pairs = [
                    'ETH/ETB', 
                    'ETH/USDT', 
                    'ETH/BTC',
                    'ETH/LOCAL MARKETS',
                    'ETH/DIGITAL ASSETS'
                ];
                this.currentPair = this.pairs[0];
                this.investmentAmount = {{$amount}};
                this.lastPrice = this.generateRealisticEthereumPrice();
                this.priceHistory = [this.lastPrice];
                this.minInvestment = 100; // Minimum 100 ETB
                
                // Tier system optimized for Ethiopian market
                if (this.investmentAmount >= 10000) {
                    this.tier = 'PREMIUM';
                    this.baseWinRate = 0.85; // 85% win rate
                    this.profitRange = { min: 200, max: 800 }; // 200-800 ETB profit
                    this.lossRange = { min: 50, max: 200 }; // 50-200 ETB loss (controlled)
                } else if (this.investmentAmount >= 5000) {
                    this.tier = 'ADVANCED';
                    this.baseWinRate = 0.80;
                    this.profitRange = { min: 100, max: 500 };
                    this.lossRange = { min: 40, max: 150 };
                } else if (this.investmentAmount >= 1000) {
                    this.tier = 'STANDARD';
                    this.baseWinRate = 0.76;
                    this.profitRange = { min: 50, max: 300 };
                    this.lossRange = { min: 30, max: 100 };
                } else {
                    this.tier = 'BASIC';
                    this.baseWinRate = 0.73;
                    this.profitRange = { min: 25, max: 150 };
                    this.lossRange = { min: 20, max: 80 };
                }
                
                // ETH to ETB conversion rate (approximate)
                this.ethToEtbRate = 140; // 1 ETH ≈ 140,000 ETB (simplified)
            }
    
            generateRealisticEthereumPrice(basePrice = 2500) {
                const volatility = botState.marketVolatility;
                // Ethereum typically has higher volatility but we'll control it
                let priceChange = (Math.random() - 0.48) * 100 * volatility; // Bias slightly positive
                
                // Ethereum market trends (generally bullish long-term)
                if (botState.marketTrend === 'bullish') {
                    priceChange += Math.random() * 80;
                } else if (botState.marketTrend === 'bearish') {
                    priceChange -= Math.random() * 60;
                }
                
                // Convert to ETB for local market
                const usdPrice = Math.max(1500, basePrice + priceChange);
                return usdPrice * this.ethToEtbRate; // Convert to ETB
            }
    
            updateGrowthFactors() {
                botState.tradingSession++;
                
                // Every 7 trades, increase profit potential and decrease loss potential
                if (botState.tradingSession % 7 === 0 && botState.consecutiveWins > 2) {
                    botState.profitGrowthFactor = Math.min(1.5, botState.profitGrowthFactor + 0.02); // +2% profits
                    botState.lossReductionFactor = Math.max(0.6, botState.lossReductionFactor - 0.015); // -1.5% losses
                    botState.sessionMultiplier = Math.min(1.8, botState.sessionMultiplier + 0.03);
                }
                
                // Smart volatility adjustment
                if (botState.winStreak >= 4) {
                    botState.marketVolatility = Math.max(0.12, botState.marketVolatility - 0.008);
                } else if (botState.lossStreak >= 2) {
                    botState.marketVolatility = Math.min(0.25, botState.marketVolatility + 0.005);
                }
            }
    
            updateMarketTrend() {
                // Ethereum tends to have bullish bias, especially in growing markets
                const trendRandom = Math.random();
                let bullishProb = 0.65; // Higher probability for Ethereum bullish trends
                
                // Adjust based on performance and session
                if (botState.winStreak >= 3) {
                    bullishProb = 0.75;
                } else if (botState.lossStreak >= 2) {
                    bullishProb = 0.55;
                }
                
                // Ethereum-specific market factors
                if (botState.tradingSession > 50) {
                    bullishProb += 0.05; // Ethereum often strengthens over time
                }
                
                if (trendRandom < bullishProb) {
                    botState.marketTrend = 'bullish';
                } else if (trendRandom < 0.85) {
                    botState.marketTrend = 'neutral';
                } else {
                    botState.marketTrend = 'bearish';
                }
            }
    
            calculateWinRate() {
                let winRate = this.baseWinRate;
                
                // Market trend adjustments (Ethereum specific)
                if (botState.marketTrend === 'bullish') {
                    winRate += 0.06; // Stronger bullish effect for Ethereum
                } else if (botState.marketTrend === 'bearish') {
                    winRate -= 0.04; // Smaller reduction for Ethereum
                }
                
                // Performance-based adjustments
                if (botState.winStreak >= 3) {
                    winRate += 0.04;
                }
                if (botState.consecutiveWins >= 4) {
                    winRate += 0.03;
                }
                
                // Ethereum network effects (gains from adoption)
                const networkEffect = Math.min(0.05, botState.tradingSession * 0.0005);
                winRate += networkEffect;
                
                // Keep profitable bounds (70-90%)
                return Math.max(0.70, Math.min(0.90, winRate));
            }
    
            shouldTrade() {
                if (botState.currentBalance < this.minInvestment) {
                    return false;
                }
                
                // Smart Ethereum trading strategy
                let baseFrequency = 0.72;
                if (botState.winStreak >= 3) {
                    baseFrequency = 0.82;
                } else if (botState.lossStreak >= 2) {
                    baseFrequency = 0.62;
                }
                
                // Ethereum network activity factor
                const networkActivity = 1 + (Math.random() * 0.1);
                baseFrequency *= networkActivity;
                
                return Math.random() < baseFrequency;
            }
    
            calculateProfitLoss(isWin) {
                let amount;
                
                if (isWin) {
                    // Profits that grow with Ethereum adoption
                    amount = Math.random() * (this.profitRange.max - this.profitRange.min) + this.profitRange.min;
                    amount *= botState.profitGrowthFactor; // Apply growth
                    amount *= botState.sessionMultiplier; // Session multiplier
                    
                    // Ethereum-specific profit boost (network effects)
                    const ethBoost = 1 + (Math.random() * 0.15);
                    amount *= ethBoost;
                    
                    // Add consistent profit boost
                    amount *= (1 + botState.profitBoost);
                    
                    // Minimum profitable amount for Ethiopian market
                    return Math.max(this.profitRange.min * 0.7, amount);
                } else {
                    // Controlled losses that decrease over time
                    amount = Math.random() * (this.lossRange.max - this.lossRange.min) + this.lossRange.min;
                    amount *= botState.lossReductionFactor; // Apply reduction
                    
                    // Loss protection for Ethereum volatility
                    const lossProtection = 0.7 + (Math.random() * 0.2);
                    amount *= lossProtection;
                    
                    // Cap maximum loss
                    amount = Math.min(amount, this.lossRange.max * 0.7);
                    
                    return -Math.max(this.lossRange.min * 0.4, amount);
                }
            }
    
            executeTrade() {
                if (!this.shouldTrade()) return false;
    
                // Update growth factors regularly
                if (Math.random() < 0.18) {
                    this.updateGrowthFactors();
                }
                
                // Update market trend
                if (Math.random() < 0.12) {
                    this.updateMarketTrend();
                }
    
                const currentPrice = this.generateRealisticEthereumPrice(this.lastPrice / this.ethToEtbRate);
                const winProbability = this.calculateWinRate();
                const isWinningTrade = Math.random() < winProbability;
                
                let pnl = this.calculateProfitLoss(isWinningTrade);
                
                // Apply Ethereum network consistency bonus
                const networkBonus = Math.abs(pnl) * 0.015; // 1.5% network bonus
                pnl = pnl > 0 ? pnl + networkBonus : pnl + (networkBonus * 0.5);
                
                // Update streaks
                if (isWinningTrade) {
                    botState.consecutiveWins++;
                    botState.winStreak++;
                    botState.lossStreak = 0;
                } else {
                    botState.consecutiveWins = 0;
                    botState.winStreak = 0;
                    botState.lossStreak++;
                }
    
                // Update statistics
                botState.totalTrades++;
                botState.totalPnL += pnl;
                botState.currentBalance += pnl;
                
                if (pnl > 0) {
                    botState.winningTrades++;
                }
    
                botState.overallProfitable = botState.totalPnL > 0;
    
                // Bilingual logging with Ethereum context
                const timestamp = this.getCurrentTimestamp();
                const isBuy = Math.random() > 0.5;
                const tradeType = isBuy ? 'ግዢ / BUY' : 'ሽያጭ / SELL';
                const ethPriceInEtb = (currentPrice / 1000).toFixed(2); // Show in thousands
                const pnlText = pnl >= 0 ? `+ETB ${pnl.toFixed(2)}` : `-ETB ${Math.abs(pnl).toFixed(2)}`;
                
                // Ethereum-specific success messages
                if (pnl > 0) {
                    const ethSuccessMessages = [
                        "✓ ኢተርየም ግብይት ተሳክቷል! / Ethereum trade successful!",
                        "✓ የኢተርየም ኔትወርክ አዋክ! / Ethereum network active!",
                        "✓ በመረብ አይነት ውጤት ተገኘ! / Network effect achieved!",
                        "✓ የዲፒኦኤስ ጥቅም አሳየ! / DPoS advantage shown!"
                    ];
                    addLogEntry(timestamp, 
                        `${ethSuccessMessages[Math.floor(Math.random() * ethSuccessMessages.length)]} | ${tradeType} ${this.currentPair} @ ${ethPriceInEtb}K ETB | ትርፍ / Profit: ${pnlText}`, 
                        'success');
                    
                    // Ethereum milestone celebrations
                    if (pnl > this.profitRange.min * 4) {
                        addLogEntry(timestamp, "🚀 ትልቅ የኢተርየም ትርፍ! / Big Ethereum profit!", 'success');
                    }
                } else {
                    const ethControlledMessages = [
                        "የኢተርየም ቮላቲሊቲ ተቆጣጠረ / Ethereum volatility controlled",
                        "ትንሽ የመረብ ማስተካከል / Minor network adjustment",
                        "የጋዝ ክፍያ ተመዝግቧል / Gas fee accounted",
                        "የቴስት ኔት እድሳት / Testnet update"
                    ];
                    addLogEntry(timestamp, 
                        `${ethControlledMessages[Math.floor(Math.random() * ethControlledMessages.length)]} | ${tradeType} ${this.currentPair} @ ${ethPriceInEtb}K ETB | ጉዳት / Loss: ${pnlText}`, 
                        'warning');
                }
                
                // Ethereum-specific milestones
                if (botState.winStreak === 5) {
                    addLogEntry(timestamp, "🏆 5 ተከታታይ የኢተርየም ግብይቶች! / 5 consecutive Ethereum trades!", 'success');
                }
                if (botState.totalTrades % 15 === 0) {
                    const winRate = (botState.winningTrades / botState.totalTrades * 100).toFixed(1);
                    const totalProfit = botState.totalPnL.toFixed(2);
                    const ethPrice = (botState.ethereumPrice * this.ethToEtbRate / 1000).toFixed(2);
                    addLogEntry(timestamp, `📊 የኢተርየም ማጠቃለያ / Ethereum Summary: ${botState.totalTrades} ግብይቶች / trades | ${winRate}% የማሸነፍ መጠን / win rate | አጠቃላይ ትርፍ / Total Profit: ETB ${totalProfit} | ETH ዋጋ / Price: ${ethPrice}K ETB`, 'info');
                }
                
                // Update database and UI
                this.updateWalletBalance(botState.currentBalance);
                this.updateStats();
                
                this.lastPrice = currentPrice;
                return true;
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
    
            updateStats() {
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
                
                // Mobile updates
                document.getElementById('mobileBalance').textContent = 
                    'ETB ' + botState.currentBalance.toFixed(2);
                const changeText = (botState.totalPnL >= 0 ? '+' : '') + 'ETB ' + Math.abs(botState.totalPnL).toFixed(2);
                document.getElementById('mobileBalanceChange').textContent = changeText;
                document.getElementById('mobileBalanceChange').className = 
                    'balance-change ' + (botState.totalPnL >= 0 ? 'positive' : 'negative');
                
                // Display tier and Ethereum performance
                const growthPercent = ((botState.profitGrowthFactor - 1) * 100).toFixed(1);
                const multiplierPercent = ((botState.sessionMultiplier - 1) * 100).toFixed(1);
                const ethRate = this.ethToEtbRate;
                document.getElementById('currentTier').textContent = 
                    `${this.tier} ETH | +${growthPercent}% Growth | +${multiplierPercent}% Multiplier | 1 ETH ≈ ${ethRate}K ETB`;
            }
    
            getCurrentTimestamp() {
                const now = new Date();
                const ethiopianTime = new Date(now.getTime() + (3 * 60 * 60 * 1000)); // Ethiopian timezone
                return ethiopianTime.toTimeString().split(' ')[0] + '.' + ethiopianTime.getMilliseconds().toString().padStart(3, '0');
            }
    
            analyzeMarket() {
                const timestamp = this.getCurrentTimestamp();
                const ethereumMarketAnalyses = [
                    "የኢተርየም ኔትወርክ እየበረታ ነው / Ethereum network strengthening",
                    "የዲፒኦኤስ ምክንያት ትርፋማ ነው / DPoS factor profitable",
                    "የማይን ማዕድን አዋቂ / Mining activity increasing",
                    "የዲፓ አጠቃቀም እየጨመረ ነው / DApp usage growing",
                    "የማርት ካፕ ከፍተኛ / Market cap rising",
                    "የጋዝ ክፍያዎች በማሻሻል ላይ / Gas fees optimizing",
                    "የሴምር አፕግሬድ ተጽዕኖ አዋክ / Shanghai upgrade effect"
                ];
                
                const ethTechnicalAnalyses = [
                    "የኢተርየም ምልክት አወንታዊ / Ethereum signal positive",
                    "የቴክኒካል አመላካቾች ለሁለተኛው ላየር ጥሩ ናቸው / Layer 2 indicators good",
                    "የኔትወርክ አጠቃቀም ከፍተኛ / Network utilization high",
                    "የስማርት ኮንትራት እውቅና እየጨመረ ነው / Smart contract adoption growing",
                    "የዲፊ ዕድሎች በርካታ / DeFi opportunities abundant",
                    "ETH 2.0 ሽግግር አዎንታዊ / ETH 2.0 transition positive"
                ];
                
                // Mix Ethereum and technical analyses
                let analysisPool = ethereumMarketAnalyses;
                if (Math.random() < 0.45) {
                    analysisPool = ethTechnicalAnalyses;
                }
                
                const randomAnalysis = analysisPool[Math.floor(Math.random() * analysisPool.length)];
                addLogEntry(timestamp, randomAnalysis, 'info');
            }
        }
    
        // Initialize the profitable Ethiopian Ethereum trading bot
        const tradingBot = new EthiopianEthereumBot();
    
        function addLogEntry(timestamp, message, type = 'info') {
            const logsContainer = document.getElementById('logsContainer');
            const logEntry = document.createElement('div');
            logEntry.className = `log-entry log-${type}`;
            logEntry.innerHTML = `<span class="log-timestamp">[${timestamp} EAT]</span> <span class="log-${type}">${message}</span>`;
            logsContainer.appendChild(logEntry);
            logsContainer.scrollTop = logsContainer.scrollHeight;
            document.getElementById('logsCount').textContent = `${logsContainer.children.length} entries`;
        }
    
        function startBot() {
            botState.isRunning = true;
            botState.isPaused = false;
            botState.totalRuns++;
            
            document.getElementById('totalRuns').textContent = botState.totalRuns;
            updateBotStatus('running', 'ሮቦት እየሰራ ነው / Bot Running');
            
            document.getElementById('startBtn').disabled = true;
            document.getElementById('pauseBtn').disabled = false;
            document.getElementById('stopBtn').disabled = false;
            
            const timestamp = tradingBot.getCurrentTimestamp();
            addLogEntry(timestamp, `🚀 የኢትዮጵያ ኢተርየም ንግድ ሮቦት አገልግሎት ጀመረ / Ethiopian Ethereum Trading Bot Activated`, 'success');
            addLogEntry(timestamp, `📈 የኢተርየም ንግድ ስልት / Ethereum Strategy: High-accuracy trading with ${(tradingBot.baseWinRate*100).toFixed(1)}% win rate`, 'success');
            addLogEntry(timestamp, `💰 የመጀመሪያ ሒሳብ / Initial Balance: ETB ${botState.currentBalance.toFixed(2)}`, 'info');
            addLogEntry(timestamp, `🎯 የአሁን ደረጃ / Current Tier: ${tradingBot.tier} ETHEREUM`, 'info');
            addLogEntry(timestamp, `⚡ ETH/ETB የምንዛሬ ምንጭ / Exchange Rate: 1 ETH ≈ ${tradingBot.ethToEtbRate}K ETB`, 'info');
            
            // Optimal Ethereum trading intervals
            botState.tradingInterval = setInterval(() => {
                if (botState.isRunning && !botState.isPaused) {
                    tradingBot.executeTrade();
                }
            }, Math.random() * 3500 + 1800); // 1.8-5.3 seconds
            
            // Ethereum market analysis every 4-8 seconds
            botState.logInterval = setInterval(() => {
                if (botState.isRunning && !botState.isPaused) {
                    tradingBot.analyzeMarket();
                }
            }, Math.random() * 4000 + 4000);
        }
    
        function pauseBot() {
            botState.isPaused = !botState.isPaused;
            const pauseBtn = document.getElementById('pauseBtn');
            if (botState.isPaused) {
                updateBotStatus('paused', 'ተቆምቷል / Paused');
                pauseBtn.textContent = 'ሮቦት እንደገና ጀምር / Resume Bot';
                addLogEntry(tradingBot.getCurrentTimestamp(), '⏸️ የኢተርየም ንግድ ተቆምቷል / Ethereum trading paused', 'warning');
            } else {
                updateBotStatus('running', 'ሮቦት እየሰራ ነው / Bot Running');
                pauseBtn.textContent = 'ሮቦት አቁም / Pause Bot';
                addLogEntry(tradingBot.getCurrentTimestamp(), '▶️ የኢተርየም ንግድ ቀጠለ / Ethereum trading resumed', 'success');
            }
        }
    
        function stopBot() {
            if (confirm('የኢተርየም ንግድ ሮቦቱን ማቆም ትፈልጋለህ? / Stop the Ethereum trading bot?')) {
                botState.isRunning = false;
                botState.isPaused = false;
                clearInterval(botState.tradingInterval);
                clearInterval(botState.logInterval);
                updateBotStatus('stopped', 'ተቆምቷል / Stopped');
                
                document.getElementById('startBtn').disabled = false;
                document.getElementById('pauseBtn').disabled = true;
                document.getElementById('stopBtn').disabled = true;
                
                const winRate = botState.totalTrades > 0 ? (botState.winningTrades/botState.totalTrades*100).toFixed(1) : 0;
                const finalStats = `📊 የኢተርየም ክፍለ ጊዜ ማጠቃለያ / Ethereum Session Summary: ${botState.totalTrades} ግብይቶች / trades | ${winRate}% የማሸነፍ መጠን / win rate | አጠቃላይ ትርፍ / Net P&L: ${botState.totalPnL >= 0 ? '+' : ''}ETB ${botState.totalPnL.toFixed(2)}`;
                addLogEntry(tradingBot.getCurrentTimestamp(), '🛑 የኢተርየም ንግድ ሮቦቱ ተቆምቷል / Ethereum trading bot stopped', 'warning');
                addLogEntry(tradingBot.getCurrentTimestamp(), finalStats, 'info');
                
                // Ethereum-specific performance analysis
                if (botState.totalPnL > 500) {
                    addLogEntry(tradingBot.getCurrentTimestamp(), '✅ በጣም ትርፋማ የኢተርየም ክፍለ ጊዜ! / Very profitable Ethereum session!', 'success');
                } else if (botState.totalPnL > 100) {
                    addLogEntry(tradingBot.getCurrentTimestamp(), '✅ ትርፋማ የኢተርየም ክፍለ ጊዜ / Profitable Ethereum session', 'success');
                } else if (botState.totalPnL > 0) {
                    addLogEntry(tradingBot.getCurrentTimestamp(), '📊 የኢተርየም ትርፍ ተገኘ / Ethereum profit achieved', 'info');
                } else {
                    addLogEntry(tradingBot.getCurrentTimestamp(), '📊 የኢተርየም ምርመራ - የሚቀጥለው ረጅም ጊዜ የተሻለ ይሆናል / Ethereum test - Next long-term will be better', 'info');
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
                updateBotStatus('stopped', 'ለመጀመር ዝግጁ / Ready to Start');
            @endif
            
            const timestamp = tradingBot.getCurrentTimestamp();
            addLogEntry(timestamp, `💼 የኢትዮጵያ ኢተርየም ባህር ዳር ንግድ ስርዓት ተጭኗል / Ethiopian Ethereum Trading System loaded`, 'success');
            addLogEntry(timestamp, `💰 ሒሳብ ቀሪ ሂሳብ / Account Balance: ETB ${botState.currentBalance.toFixed(2)}`, 'info');
            addLogEntry(timestamp, `⚡ ${tradingBot.tier} ETH ደረጃ ንቃ / ${tradingBot.tier} ETHEREUM Tier Active - Optimized for smart contract profits`, 'info');
            addLogEntry(timestamp, `📊 የኢተርየም መሰረታዊ የማሸነፍ መጠን / Ethereum Base win rate: ${(tradingBot.baseWinRate*100).toFixed(1)}% | አላማ / Target: ETB ${tradingBot.profitRange.min}-${tradingBot.profitRange.max} per trade`, 'info');
            addLogEntry(timestamp, `🌐 የኢተርየም ኔትወርክ ጥቅሞች ንቁ / Ethereum network benefits active`, 'info');
            
            @if(Auth::user()->wallet_balance < $amount)
                addLogEntry(timestamp, '❌ በቂ ሒሳብ ቀሪ ሂሳብ የለም / Insufficient balance to start Ethereum trading', 'error');
            @endif
        });
    </script>
    <!-- CSRF Token for AJAX requests -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</body>
@endsection