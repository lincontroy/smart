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
            <h1 class="bot-title">ETH DCA Pro</h1>
            <div class="bot-details">Bot ID: eth-dca-1 • • Account: Real • Ethereum Dollar-Cost Averaging</div>
        </div>
        <div class="status-section">
            <div class="status-badge" id="statusBadge">
                <div class="status-dot" id="statusDot"></div>
                <span id="statusText">Ready to Start ETH DCA</span>
            </div>
            <?php
            $amount = request('amount');
            $asset = request('asset');?>
            @if(Auth::user()->wallet_balance < $amount)
                <div class="insufficient-balance">Insufficient ETH Balance</div>
            @else
                <div class="trade-controls" id="tradeControls">
                    <button class="btn btn-start" id="startBtn">Start DCA Bot</button>
                    <button class="btn btn-pause" id="pauseBtn" disabled>Pause DCA</button>
                    <button class="btn btn-stop" id="stopBtn" disabled>Stop DCA</button>
                </div>
            @endif
        </div>
    </div>

    <div class="content-grid">
    <div class="stats-sidebar">
    <div class="stat-card pnl">
        <div class="stat-label">Total ETH Profit</div>
        <div class="stat-value" id="totalPnL">+ETB 0.00</div>
    </div>
    
    <div class="stat-card runs">
        <div class="stat-label">DCA Cycles</div>
        <div class="stat-value" id="totalRuns">0</div>
    </div>
    
    <div class="stat-card trades">
        <div class="stat-label">ETH Purchases</div>
        <div class="stat-value" id="totalTrades">0</div>
    </div>
    
    <div class="stat-card winrate">
        <div class="stat-label">ETH Accumulation</div>
        <div class="stat-value" id="winRate">0.00 ETH</div>
    </div>
    
    <!-- This balance card will be visible on mobile -->
    <div class="stat-card balance mobile-balance-card">
        <div class="stat-label">ETH Value</div>
        <div class="stat-value" id="currentBalance" style="color:white">ETB {{ number_format(Auth::user()->wallet_balance , 2) }}</div>
    </div>
</div>

        <div class="logs-section">
            <div class="logs-header">
                <h2 class="logs-title">ETH DCA Pro Logs</h2>
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
        <div class="balance-label">ETH Portfolio Value</div>
        <div>
            <span class="balance-amount" id="mobileBalance">ETB {{ number_format(Auth::user()->wallet_balance , 2) }}</span>
            <span class="balance-change positive" id="mobileBalanceChange">+ETB 0.00</span>
        </div>
    </div>
</div>
    <script>
        // ETH DCA Pro Bot State - Always Profitable ETH Accumulation
        let botState = {
            isRunning: false,
            isPaused: false,
            totalPnL: 0,
            totalRuns: 0,
            totalTrades: 0,
            totalEthAccumulated: 0,
            currentBalance: {{ Auth::user()->wallet_balance }},
            tradingInterval: null,
            logInterval: null,
            consecutiveProfits: 0,
            marketTrend: 'bullish',
            ethGrowthMultiplier: 1.18, // 18% ETH growth factor
            profitStreak: 0,
            tradingSession: 0,
            ethVolatility: 0.06, // Low volatility for ETH DCA
            ethPrice: 2200, // USD base price for ETH
            ethToEtbRate: 58, // Exchange rate
            averageEntryPrice: 0,
            totalEthValue: 0,
            dcaCycleCount: 0
        };
    
        // ETH DCA Pro Bot - Automatic Ethereum Accumulation
        class ETHDCAProBot {
            constructor() {
                this.pairs = ['ETH/ETB', 'ETH/USDT', 'ETH/BTC', 'ETH/LOCAL', 'ETH/REGIONAL'];
                this.currentPair = this.pairs[0];
                this.dcaAmount = {{$amount}} ;
                this.lastEthPrice = this.generateOptimisticETHPrice();
                this.priceHistory = [this.lastEthPrice];
                this.minDCA = 50 ;
                
                // ETH DCA Tier System
                if (this.dcaAmount >= 50000 ) {
                    this.tier = 'ETH WHALE DCA';
                    this.baseProfitRange = { min: 280, max: 1100 };
                    this.ethAccumulationRate = 0.008; // 0.8% ETH per cycle
                } else if (this.dcaAmount >= 25000 ) {
                    this.tier = 'ETH ELITE DCA';
                    this.baseProfitRange = { min: 180, max: 750 };
                    this.ethAccumulationRate = 0.006;
                } else if (this.dcaAmount >= 10000 ) {
                    this.tier = 'ETH PRO DCA';
                    this.baseProfitRange = { min: 120, max: 500 };
                    this.ethAccumulationRate = 0.005;
                } else if (this.dcaAmount >= 5000 ) {
                    this.tier = 'ETH PLUS DCA';
                    this.baseProfitRange = { min: 80, max: 320 };
                    this.ethAccumulationRate = 0.004;
                } else if (this.dcaAmount >= 2000 ) {
                    this.tier = 'ETH STANDARD DCA';
                    this.baseProfitRange = { min: 50, max: 220 };
                    this.ethAccumulationRate = 0.003;
                } else {
                    this.tier = 'ETH BASIC DCA';
                    this.baseProfitRange = { min: 30, max: 130 };
                    this.ethAccumulationRate = 0.002;
                }
            }
    
            generateOptimisticETHPrice(basePrice = 2200) {
                // Always positive ETH price movement for DCA
                const volatility = botState.ethVolatility;
                let priceChange = Math.random() * 120 * volatility + 25;
                
                // Strong bullish ETH trend
                if (botState.marketTrend === 'bullish') {
                    priceChange += Math.random() * 180;
                }
                
                // ETH 2.0 and scaling bonus
                const eth2Bonus = Math.random() * 150;
                priceChange += eth2Bonus;
                
                // Consecutive profit momentum
                if (botState.consecutiveProfits > 2) {
                    priceChange += botState.consecutiveProfits * 25;
                }
                
                const usdPrice = Math.max(1500, basePrice + priceChange);
                return usdPrice * botState.ethToEtbRate;
            }
    
            updateETHGrowth() {
                botState.tradingSession++;
                botState.dcaCycleCount++;
                
                // Increase profit potential with every DCA cycle
                if (botState.dcaCycleCount % 2 === 0) {
                    botState.ethGrowthMultiplier = Math.min(2.5, botState.ethGrowthMultiplier + 0.09);
                }
                
                // ETH 2.0 staking yield simulation
                if (botState.totalEthAccumulated > 0) {
                    const stakingYield = botState.totalEthAccumulated * 0.0005;
                    botState.totalPnL += stakingYield;
                    botState.currentBalance += stakingYield;
                }
            }
    
            updateMarketTrend() {
                // Always bullish for ETH (Ethereum 2.0 transition)
                const trendRandom = Math.random();
                let bullishProb = 0.92;
                
                // Higher probability with accumulated ETH
                if (botState.totalEthAccumulated > 0.1) {
                    bullishProb = 0.96;
                }
                
                // ETH 2.0 adoption factor
                const eth2Factor = 0.03;
                bullishProb += eth2Factor;
                
                if (trendRandom < bullishProb) {
                    botState.marketTrend = 'bullish';
                } else {
                    botState.marketTrend = 'very bullish';
                }
            }
    
            calculateDCAProfit() {
                // Calculate ETH DCA profit with compounding
                let amount = Math.random() * (this.baseProfitRange.max - this.baseProfitRange.min) + this.baseProfitRange.min;
                
                // Apply ETH growth factors
                amount *= botState.ethGrowthMultiplier;
                
                // DCA consistency bonus
                if (botState.dcaCycleCount >= 3) {
                    amount *= (1 + botState.dcaCycleCount * 0.015);
                }
                
                // Consecutive profit bonus
                if (botState.consecutiveProfits >= 2) {
                    amount *= (1 + botState.consecutiveProfits * 0.025);
                }
                
                // ETH network effect bonus
                const networkBonus = amount * 0.018;
                amount += networkBonus;
                
                // Smart contract utility bonus
                const utilityBonus = amount * 0.012;
                amount += utilityBonus;
                
                // Ensure minimum profit
                amount = Math.max(this.baseProfitRange.min * 0.9, amount);
                
                return Math.min(800, amount);
            }
    
            calculateETHPurchase() {
                // Calculate ETH accumulation for this DCA cycle
                const ethPriceInEtb = this.lastEthPrice;
                const dcaAmountInEtb = this.dcaAmount;
                
                // Base ETH purchase
                let ethPurchased = dcaAmountInEtb / ethPriceInEtb;
                
                // Apply accumulation rate
                ethPurchased *= (1 + this.ethAccumulationRate);
                
                // Bonus ETH from staking yield
                const stakingBonus = ethPurchased * 0.0015;
                ethPurchased += stakingBonus;
                
                // DCA efficiency bonus
                if (botState.dcaCycleCount > 5) {
                    const efficiencyBonus = ethPurchased * 0.0008 * botState.dcaCycleCount;
                    ethPurchased += efficiencyBonus;
                }
                
                return ethPurchased;
            }
    
            shouldExecuteDCA() {
                if (botState.currentBalance < this.minDCA) {
                    return false;
                }
                
                // High DCA execution frequency
                let dcaFrequency = 0.88;
                if (botState.consecutiveProfits >= 3) {
                    dcaFrequency = 0.94;
                }
                
                return Math.random() < dcaFrequency;
            }
    
            executeDCA() {
                if (!this.shouldExecuteDCA()) return false;
    
                // Update growth factors
                if (Math.random() < 0.35) {
                    this.updateETHGrowth();
                }
                
                // Update market trend
                if (Math.random() < 0.28) {
                    this.updateMarketTrend();
                }
    
                const currentEthPrice = this.generateOptimisticETHPrice(this.lastEthPrice / botState.ethToEtbRate);
                
                // Execute profitable ETH DCA
                let profit = this.calculateDCAProfit();
                let ethPurchased = this.calculateETHPurchase();
                
                // Apply DCA consistency bonus
                const consistencyBonus = profit * 0.015;
                profit += consistencyBonus;
                
                // Update streaks and statistics
                botState.consecutiveProfits++;
                botState.profitStreak++;
                botState.totalTrades++;
                botState.totalPnL += profit;
                botState.currentBalance += profit;
                botState.totalEthAccumulated += ethPurchased;
                
                // Update average entry price
                const totalInvestment = (botState.totalEthAccumulated - ethPurchased) * botState.averageEntryPrice + ethPurchased * currentEthPrice;
                botState.averageEntryPrice = totalInvestment / botState.totalEthAccumulated;
                botState.totalEthValue = botState.totalEthAccumulated * currentEthPrice;
    
                // Logging with ETH DCA focus
                const timestamp = this.getCurrentTimestamp();
                const ethPriceInEtb = (currentEthPrice / 1000).toFixed(2);
                const profitText = `+ETB ${profit.toFixed(2)}`;
                const ethText = `+${ethPurchased.toFixed(6)} ETH`;
                
                // ETH DCA Success messages
                const ethDCAmessages = [
                    "✅ ETH DCA EXECUTED SUCCESSFULLY!",
                    "✅ ETHEREUM ACCUMULATION COMPLETE!",
                    "✅ SMART DCA: ETH PURCHASE OPTIMAL!",
                    "✅ ETH 2.0 DCA PROFIT GENERATED!",
                    "✅ ETHEREUM STACKING SUCCESSFUL!"
                ];
                
                const randomMessage = ethDCAmessages[Math.floor(Math.random() * ethDCAmessages.length)];
                addLogEntry(timestamp, 
                    `${randomMessage} | DCA ${this.currentPair} @ ${ethPriceInEtb}K ETB | Profit: ${profitText} | ETH: ${ethText}`, 
                    'success');
                
                // Celebration for ETH accumulation milestones
                if (botState.totalEthAccumulated > 0.01 && botState.totalEthAccumulated < 0.011) {
                    addLogEntry(timestamp, "🎯 FIRST 0.01 ETH ACCUMULATED! DCA WORKING PERFECTLY!", 'success');
                }
                
                if (botState.profitStreak === 5) {
                    addLogEntry(timestamp, "🔥 5 CONSECUTIVE PROFITABLE DCA CYCLES!", 'success');
                }
                
                if (botState.totalTrades % 10 === 0) {
                    const totalProfit = botState.totalPnL.toFixed(2);
                    const totalEth = botState.totalEthAccumulated.toFixed(4);
                    addLogEntry(timestamp, `📊 ETH DCA MILESTONE: ${botState.totalTrades} cycles | Total Profit: ETB ${totalProfit} | ETH Held: ${totalEth}`, 'info');
                }
                
                // Update database and UI
                this.updateWalletBalance(botState.currentBalance);
                this.updateStats();
                
                this.lastEthPrice = currentEthPrice;
                return true;
            }
    
            updateWalletBalance(newBalance) {
                const usdBalance = newBalance ;
                
                fetch('/api/update-wallet-balance', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        balance: usdBalance
                    })
                }).catch(error => console.error('Error updating balance:', error));
            }
    
            updateStats() {
                document.getElementById('totalPnL').textContent = 
                    '+ETB ' + Math.abs(botState.totalPnL).toFixed(2);
                document.getElementById('totalPnL').className = 'stat-value positive';
                
                document.getElementById('totalTrades').textContent = botState.totalTrades;
                document.getElementById('currentBalance').textContent = 
                    'ETB ' + botState.currentBalance.toFixed(2);
                
                document.getElementById('winRate').textContent = botState.totalEthAccumulated.toFixed(4) + ' ETH';
                
                // Mobile updates
                document.getElementById('mobileBalance').textContent = 
                    'ETB ' + botState.currentBalance.toFixed(2);
                document.getElementById('mobileBalanceChange').textContent = 
                    '+ETB ' + Math.abs(botState.totalPnL).toFixed(2);
                document.getElementById('mobileBalanceChange').className = 'balance-change positive';
                
                // Display ETH DCA performance
                const growthPercent = ((botState.ethGrowthMultiplier - 1) * 100).toFixed(1);
                const ethValue = (botState.totalEthAccumulated * botState.ethPrice * botState.ethToEtbRate).toFixed(2);
                document.getElementById('currentTier').textContent = 
                    `${this.tier} | +${growthPercent}% Growth | ETH Value: ETB ${ethValue}`;
            }
    
            getCurrentTimestamp() {
                const now = new Date();
                return now.toTimeString().split(' ')[0] + '.' + now.getMilliseconds().toString().padStart(3, '0');
            }
    
            analyzeMarket() {
                const timestamp = this.getCurrentTimestamp();
                const ethOptimisticAnalyses = [
                    "📈 ETHEREUM DCA CONDITIONS OPTIMAL - ACCUMULATE NOW",
                    "💰 ETH 2.0 STAKING YIELD BOOSTING DCA PROFITS",
                    "🚀 ETHEREUM SCALING SOLUTIONS DRIVING VALUE",
                    "✅ SMART CONTRACT ACTIVITY SUPPORTING ETH PRICE",
                    "💹 ETH DEFI ECOSYSTEM EXPANDING - BULLISH FOR DCA",
                    "🎯 ETHEREUM DCA AVERAGING DOWN COST BASIS",
                    "⚡ ETH LAYER 2 ADOPTION ACCELERATING",
                    "📊 ETHEREUM NETWORK EFFECT STRENGTHENING",
                    "🏦 ETH AS DIGITAL OIL - STORE OF VALUE CONFIRMED",
                    "🎯 ETH 2.0 TRANSITION SMOOTH - DCA BENEFITING",
                    "💎 ETHEREUM DEVELOPER ACTIVITY AT ALL-TIME HIGH",
                    "🔐 ETH POS SECURITY MODEL PROVEN EFFECTIVE"
                ];
                
                const randomAnalysis = ethOptimisticAnalyses[Math.floor(Math.random() * ethOptimisticAnalyses.length)];
                addLogEntry(timestamp, randomAnalysis, 'info');
            }
        }
    
        // Initialize the ETH DCA Pro bot
        const tradingBot = new ETHDCAProBot();
    
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
            updateBotStatus('running', 'ETH DCA Active');
            
            document.getElementById('startBtn').disabled = true;
            document.getElementById('pauseBtn').disabled = false;
            document.getElementById('stopBtn').disabled = false;
            
            const timestamp = tradingBot.getCurrentTimestamp();
            addLogEntry(timestamp, `🚀 ETH DCA PRO BOT ACTIVATED`, 'success');
            addLogEntry(timestamp, `💰 INITIAL ETH PORTFOLIO: ETB ${botState.currentBalance.toFixed(2)}`, 'info');
            addLogEntry(timestamp, `🎯 DCA STRATEGY: ${tradingBot.tier}`, 'info');
            addLogEntry(timestamp, `✅ AUTOMATIC ETH ACCUMULATION: ENABLED`, 'success');
            addLogEntry(timestamp, `⚡ ETH 2.0 STAKING YIELD: INTEGRATED`, 'success');
            addLogEntry(timestamp, `🌐 ETH/ETB RATE: 1 ETH ≈ ${(botState.ethPrice * botState.ethToEtbRate / 1000).toFixed(1)}K ETB`, 'info');
            addLogEntry(timestamp, `🏦 ETHEREUM DCA: COST AVERAGING ACTIVE`, 'success');
            
            // DCA execution intervals
            botState.tradingInterval = setInterval(() => {
                if (botState.isRunning && !botState.isPaused) {
                    tradingBot.executeDCA();
                }
            }, Math.random() * 2500 + 1200); // 1.2-3.7 seconds
            
            // ETH Market analysis
            botState.logInterval = setInterval(() => {
                if (botState.isRunning && !botState.isPaused) {
                    tradingBot.analyzeMarket();
                }
            }, Math.random() * 3000 + 2500);
        }
    
        function pauseBot() {
            botState.isPaused = !botState.isPaused;
            const pauseBtn = document.getElementById('pauseBtn');
            if (botState.isPaused) {
                updateBotStatus('paused', 'DCA Paused');
                pauseBtn.textContent = 'Resume DCA';
                addLogEntry(tradingBot.getCurrentTimestamp(), '⏸️ ETH DCA PAUSED - ETH SECURED', 'warning');
            } else {
                updateBotStatus('running', 'ETH DCA Active');
                pauseBtn.textContent = 'Pause DCA';
                addLogEntry(tradingBot.getCurrentTimestamp(), '▶️ ETH DCA RESUMED - ACCUMULATION CONTINUES', 'success');
            }
        }
    
        function stopBot() {
            if (confirm('Stop ETH DCA Pro bot? Your ETH accumulation and profits will be saved.')) {
                botState.isRunning = false;
                botState.isPaused = false;
                clearInterval(botState.tradingInterval);
                clearInterval(botState.logInterval);
                updateBotStatus('stopped', 'DCA Complete - ETH Saved');
                
                document.getElementById('startBtn').disabled = false;
                document.getElementById('pauseBtn').disabled = true;
                document.getElementById('stopBtn').disabled = true;
                
                const finalStats = `📊 ETH DCA SESSION: ${botState.totalTrades} cycles | ETH Accumulated: ${botState.totalEthAccumulated.toFixed(4)} | Total Profit: +ETB ${botState.totalPnL.toFixed(2)}`;
                addLogEntry(tradingBot.getCurrentTimestamp(), '✅ ETH DCA PRO SESSION COMPLETE', 'success');
                addLogEntry(tradingBot.getCurrentTimestamp(), finalStats, 'info');
                
                // ETH accumulation summary
                const ethValue = (botState.totalEthAccumulated * botState.ethPrice * botState.ethToEtbRate).toFixed(2);
                addLogEntry(tradingBot.getCurrentTimestamp(), `💰 ETH PORTFOLIO VALUE: ETB ${ethValue}`, 'success');
                
                if (botState.totalEthAccumulated > 0.05) {
                    addLogEntry(tradingBot.getCurrentTimestamp(), '🚀 SIGNIFICANT ETH ACCUMULATION ACHIEVED!', 'success');
                } else if (botState.totalEthAccumulated > 0.01) {
                    addLogEntry(tradingBot.getCurrentTimestamp(), '💰 SOLID ETH ACCUMULATION PROGRESS!', 'success');
                }
                
                // ETH 2.0 staking reminder
                addLogEntry(tradingBot.getCurrentTimestamp(), '🎯 ETH 2.0 STAKING: CONTINUOUS YIELD GENERATION ACTIVE', 'info');
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
                updateBotStatus('stopped', 'Ready for ETH DCA');
            @endif
            
            const timestamp = tradingBot.getCurrentTimestamp();
            addLogEntry(timestamp, `💼 ETH DCA PRO SYSTEM INITIALIZED`, 'success');
            addLogEntry(timestamp, `💰 ETH PORTFOLIO VALUE: ETB ${botState.currentBalance.toFixed(2)}`, 'info');
            addLogEntry(timestamp, `⚡ ${tradingBot.tier} STRATEGY LOADED`, 'info');
            addLogEntry(timestamp, `📊 DCA PROFIT RANGE: ETB ${tradingBot.baseProfitRange.min}-${tradingBot.baseProfitRange.max} per cycle`, 'info');
            addLogEntry(timestamp, `✅ ETHEREUM ACCUMULATION: READY`, 'success');
            addLogEntry(timestamp, `🏦 ETH 2.0 STAKING YIELD: INTEGRATED`, 'success');
            addLogEntry(timestamp, `🎯 SMART DCA ALGORITHM: OPTIMIZED FOR ETH`, 'success');
            
            @if(Auth::user()->wallet_balance < $amount)
                addLogEntry(timestamp, '❌ INSUFFICIENT ETH BALANCE FOR DCA', 'error');
            @endif
        });
    </script>
    <!-- CSRF Token for AJAX requests -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</body>
@endsection