@extends('layouts.app')
@section('content')
    <style>
        /* Enhanced Ethereum Theme */
        :root {
            --eth-blue: #627eea;
            --eth-purple: #8a2be2;
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
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0a0f1c 0%, #0c1220 100%);
            color: white;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .eth-glow {
            box-shadow: 0 0 25px rgba(98, 126, 234, 0.4);
        }

        .eth-gradient {
            background: linear-gradient(135deg, var(--eth-blue) 0%, var(--eth-purple) 100%);
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
            border-bottom: 1px solid rgba(98, 126, 234, 0.2);
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
            background: var(--eth-blue);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
            border: 2px solid var(--eth-purple);
        }

        .page-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--eth-blue);
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
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            border: 1px solid transparent;
        }

        .nav-item:hover {
            background: rgba(98, 126, 234, 0.1);
            color: var(--eth-blue);
            border-color: var(--eth-blue);
        }

        .nav-item.active {
            background: var(--eth-blue);
            color: white;
            font-weight: 500;
        }

        .accounts-btn {
            background: var(--eth-blue);
            color: white;
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
            0%, 100% { 
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            }
            50% { 
                transform: scale(1.05);
                box-shadow: 0 0 0 10px rgba(16, 185, 129, 0);
            }
        }

        /* Ethereum Profit Alert */
        .eth-profit-alert {
            background: linear-gradient(90deg, rgba(98, 126, 234, 0.2), rgba(138, 43, 226, 0.2));
            padding: 0.75rem;
            text-align: center;
            font-weight: 600;
            animation: slideDown 0.5s ease-out;
            border-bottom: 1px solid rgba(98, 126, 234, 0.3);
            backdrop-filter: blur(10px);
        }

        @keyframes slideDown {
            from { transform: translateY(-100%); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .eth-badge {
            background: var(--eth-blue);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-left: 0.5rem;
            animation: ethGlow 2s infinite;
        }

        @keyframes ethGlow {
            0%, 100% { 
                box-shadow: 0 0 5px var(--eth-blue), 0 0 10px rgba(138, 43, 226, 0.5);
            }
            50% { 
                box-shadow: 0 0 10px var(--eth-blue), 0 0 20px rgba(138, 43, 226, 0.7);
            }
        }

        .main-content {
            padding: 2rem;
            max-width: 1600px;
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
            border: 1px solid rgba(98, 126, 234, 0.2);
            box-shadow: 0 8px 32px rgba(98, 126, 234, 0.1);
        }

        .bot-info {
            flex: 1;
        }

        .bot-title {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, var(--eth-blue) 0%, var(--eth-purple) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .bot-subtitle {
            color: var(--eth-blue);
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .bot-details {
            color: #9ca3af;
            font-size: 1rem;
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .bot-tag {
            background: rgba(98, 126, 234, 0.2);
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.85rem;
            border: 1px solid rgba(98, 126, 234, 0.3);
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
            background: var(--eth-blue);
            color: white;
            transition: all 0.3s;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .status-badge.running {
            background: linear-gradient(135deg, var(--profit-green) 0%, #34d399 100%);
            color: white;
            animation: runningGlow 2s infinite;
        }

        @keyframes runningGlow {
            0%, 100% { 
                box-shadow: 0 0 15px var(--profit-green), 0 0 30px rgba(52, 211, 153, 0.3);
            }
            50% { 
                box-shadow: 0 0 25px var(--profit-green), 0 0 40px rgba(52, 211, 153, 0.5);
            }
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
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: white;
            animation: statusPulse 2s infinite;
        }

        @keyframes statusPulse {
            0%, 100% { 
                transform: scale(1);
                opacity: 1;
            }
            50% { 
                transform: scale(1.3);
                opacity: 0.7;
            }
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
            display: flex;
            align-items: center;
            gap: 0.5rem;
            border: 1px solid transparent;
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
            box-shadow: 0 8px 25px rgba(0,0,0,0.4);
        }

        .btn-start {
            background: linear-gradient(135deg, var(--profit-green) 0%, #34d399 100%);
            color: white;
            border-color: rgba(52, 211, 153, 0.3);
        }

        .btn-start:hover {
            background: linear-gradient(135deg, #0d9668 0%, #22c55e 100%);
        }

        .btn-pause {
            background: var(--warning);
            color: white;
            border-color: rgba(245, 158, 11, 0.3);
        }

        .btn-pause:hover {
            background: #d97706;
        }

        .btn-stop {
            background: var(--danger);
            color: white;
            border-color: rgba(239, 68, 68, 0.3);
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
            grid-template-columns: 450px 1fr;
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
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(98, 126, 234, 0.15);
            border-color: rgba(98, 126, 234, 0.3);
        }

        .stat-card:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--eth-blue), var(--eth-purple));
        }

        .stat-card.pnl:before { background: linear-gradient(90deg, var(--profit-green), #34d399); }
        .stat-card.runs:before { background: linear-gradient(90deg, var(--eth-purple), #9d4edd); }
        .stat-card.trades:before { background: linear-gradient(90deg, var(--eth-blue), #4f46e5); }
        .stat-card.winrate:before { background: linear-gradient(90deg, var(--warning), #fbbf24); }
        .stat-card.balance:before { background: linear-gradient(90deg, #06b6d4, #0ea5e9); }

        .stat-label {
            color: #9ca3af;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stat-value {
            font-size: 2.2rem;
            font-weight: 700;
        }

        .stat-value.positive {
            color: var(--profit-green);
            text-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);
        }

        .stat-value.negative {
            color: var(--danger);
        }

        /* Ethereum Network Stats */
        .eth-network-stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
            margin-top: 0.75rem;
            padding-top: 0.75rem;
            border-top: 1px solid rgba(255,255,255,0.05);
        }

        .network-stat {
            text-align: center;
            padding: 0.5rem;
            background: rgba(98, 126, 234, 0.1);
            border-radius: 8px;
            border: 1px solid rgba(98, 126, 234, 0.2);
        }

        .network-value {
            font-size: 1rem;
            font-weight: 600;
            color: var(--eth-blue);
        }

        .network-label {
            font-size: 0.75rem;
            color: #9ca3af;
        }

        /* Enhanced Logs Section */
        .logs-section {
            background: rgba(26, 35, 50, 0.8);
            border-radius: 16px;
            padding: 1.5rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.05);
            display: flex;
            flex-direction: column;
        }

        .logs-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .logs-title {
            font-size: 1.5rem;
            font-weight: 600;
            background: linear-gradient(135deg, var(--eth-blue), var(--eth-purple));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .logs-count {
            color: var(--eth-blue);
            font-size: 0.9rem;
            font-weight: 600;
            background: rgba(98, 126, 234, 0.1);
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            border: 1px solid rgba(98, 126, 234, 0.2);
        }

        .logs-container {
            background: rgba(15, 20, 25, 0.8);
            border-radius: 12px;
            padding: 1rem;
            height: 500px;
            overflow-y: auto;
            font-family: 'Cascadia Code', 'Roboto Mono', 'SF Mono', monospace;
            font-size: 0.85rem;
            line-height: 1.5;
            flex: 1;
            border: 1px solid rgba(255,255,255,0.05);
        }

        .log-entry {
            margin-bottom: 0.5rem;
            word-wrap: break-word;
            padding: 0.75rem;
            border-radius: 8px;
            transition: all 0.2s;
            border-left: 4px solid transparent;
            background: rgba(255,255,255,0.02);
        }

        .log-entry:hover {
            background: rgba(255,255,255,0.05);
            transform: translateX(2px);
        }

        .log-entry.success { 
            border-left-color: var(--profit-green);
            background: rgba(16, 185, 129, 0.05);
        }
        .log-entry.error { 
            border-left-color: var(--danger);
            background: rgba(239, 68, 68, 0.05);
        }
        .log-entry.info { 
            border-left-color: var(--eth-blue);
            background: rgba(98, 126, 234, 0.05);
        }
        .log-entry.warning { 
            border-left-color: var(--warning);
            background: rgba(245, 158, 11, 0.05);
        }
        .log-entry.trade { 
            border-left-color: var(--eth-purple);
            background: rgba(138, 43, 226, 0.05);
        }

        .log-timestamp {
            color: #6b7280;
            font-family: monospace;
            font-size: 0.8rem;
        }

        .log-error { color: var(--danger); }
        .log-success { color: var(--profit-green); }
        .log-info { color: var(--eth-blue); }
        .log-warning { color: var(--warning); }
        .log-trade { color: var(--eth-purple); }
        .log-eth { color: #8a2be2; font-weight: 600; }

        /* Mobile Balance Widget */
        .mobile-balance-widget {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(26, 35, 50, 0.95);
            backdrop-filter: blur(20px);
            padding: 12px 16px;
            border-top: 1px solid rgba(98, 126, 234, 0.3);
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
            font-weight: 700;
            font-size: 1.2rem;
            color: white;
        }

        .balance-change {
            font-size: 0.8rem;
            margin-left: 8px;
            padding: 0.2rem 0.5rem;
            border-radius: 12px;
            background: rgba(16, 185, 129, 0.2);
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .balance-change.positive {
            color: var(--profit-green);
        }

        .balance-change.negative {
            background: rgba(239, 68, 68, 0.2);
            border-color: rgba(239, 68, 68, 0.3);
            color: var(--danger);
        }

        /* Ethereum Maximizer Panel */
        .eth-maximizer {
            background: rgba(26, 35, 50, 0.8);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border: 1px solid rgba(98, 126, 234, 0.2);
            backdrop-filter: blur(10px);
        }

        .maximizer-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .maximizer-title {
            color: var(--eth-blue);
            font-size: 1.3rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .maximizer-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
        }

        .maximizer-stat {
            text-align: center;
            padding: 1rem;
            background: rgba(98, 126, 234, 0.1);
            border-radius: 12px;
            border: 1px solid rgba(98, 126, 234, 0.2);
            transition: all 0.3s;
        }

        .maximizer-stat:hover {
            transform: translateY(-2px);
            background: rgba(98, 126, 234, 0.15);
        }

        .maximizer-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--eth-blue);
            margin-bottom: 0.25rem;
        }

        .maximizer-label {
            font-size: 0.85rem;
            color: #9ca3af;
        }

        .eth-actions {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.5rem;
            margin-top: 1.5rem;
        }

        .eth-action-btn {
            padding: 0.75rem;
            border: 1px solid rgba(98, 126, 234, 0.3);
            background: rgba(98, 126, 234, 0.1);
            color: var(--eth-blue);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .eth-action-btn:hover {
            background: var(--eth-blue);
            color: white;
            border-color: var(--eth-blue);
            transform: translateY(-2px);
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .content-grid {
                grid-template-columns: 350px 1fr;
            }
            
            .bot-title {
                font-size: 2.2rem;
            }
        }

        @media (max-width: 1024px) {
            .content-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            
            .stats-sidebar {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                display: grid;
                gap: 1rem;
            }

            .maximizer-stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .eth-actions {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
                padding-bottom: 80px;
            }
            
            .bot-header {
                flex-direction: column;
                gap: 1rem;
                margin-bottom: 1.5rem;
            }
            
            .bot-title {
                font-size: 1.8rem;
            }
            
            .bot-details {
                flex-wrap: wrap;
            }
            
            .status-section {
                width: 100%;
                justify-content: space-between;
            }
            
            .trade-controls {
                width: 100%;
            }
            
            .btn {
                flex: 1;
                justify-content: center;
            }
            
            .stats-sidebar {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.75rem;
            }
            
            .stat-card {
                padding: 1rem;
            }
            
            .stat-value {
                font-size: 1.8rem;
            }
            
            .eth-network-stats {
                grid-template-columns: 1fr;
            }
            
            .logs-section {
                height: 400px;
            }
            
            .logs-container {
                height: 300px;
            }
            
            .mobile-balance-widget {
                display: block;
            }
            
            .maximizer-stats {
                grid-template-columns: 1fr;
            }
            
            .eth-actions {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .main-content {
                padding: 0.75rem;
                padding-bottom: 70px;
            }
            
            .bot-title {
                font-size: 1.5rem;
            }
            
            .bot-subtitle {
                font-size: 1rem;
            }
            
            .stats-sidebar {
                grid-template-columns: 1fr;
            }
            
            .status-badge {
                padding: 0.5rem 1rem;
            }
            
            .btn {
                padding: 0.6rem 1rem;
                font-size: 0.8rem;
            }
            
            .logs-container {
                height: 250px;
                font-size: 0.8rem;
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.05);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--eth-blue);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--eth-purple);
        }
    </style>

<body>
    <!-- Ethereum Profit Alert -->
    <div class="eth-profit-alert" id="ethProfitAlert">
        ⚡ የኢተርየም ትርፍ ሞድ ነቃ / Ethereum Profit Mode Active
        <span class="eth-badge" id="ethProfitCounter">+ETB 0.00</span>
    </div>

    <main class="main-content">
        <div class="bot-header">
            <div class="bot-info">
                <h1 class="bot-title">🚀 የኢትዮጵያ ኢተርየም ንግድ ሮቦት</h1>
                <div class="bot-subtitle">💎 Ethereum Profit Maximizer 3.0</div>
                <div class="bot-details">
                    <span class="bot-tag">Bot ID: ETH-ETB-PRO-1</span>
                    <span class="bot-tag">Account: Real Trading</span>
                    <span class="bot-tag">Network: Ethereum Mainnet</span>
                    <span class="bot-tag">Currency: Ethiopian Birr (ETB)</span>
                </div>
            </div>
            <div class="status-section">
                <div class="status-badge" id="statusBadge">
                    <div class="status-dot" id="statusDot"></div>
                    <span id="statusText">Ready for Ethereum Profits</span>
                </div>
                <?php
                $amount = request('amount');
                $asset = request('asset');?>
                @if(Auth::user()->wallet_balance < $amount)
                    <div class="insufficient-balance">💸 Add funds to start trading</div>
                @else
                    <div class="trade-controls" id="tradeControls">
                        <button class="btn btn-start" id="startBtn">🚀 Start Bot</button>
                        <button class="btn btn-pause" id="pauseBtn" disabled>⏸️ Pause</button>
                        <button class="btn btn-stop" id="stopBtn" disabled>🛑 Stop</button>
                    </div>
                @endif
            </div>
        </div>

        <!-- Ethereum Maximizer Panel -->
        <div class="eth-maximizer">
            <div class="maximizer-header">
                <div class="maximizer-title">
                    <span>⚡ Ethereum Profit Accelerator</span>
                    <span class="eth-badge">ACTIVE</span>
                </div>
            </div>
            <div class="maximizer-stats">
                <div class="maximizer-stat">
                    <div class="maximizer-value" id="profitPerHour">ETB 0</div>
                    <div class="maximizer-label">Profit/Hour</div>
                </div>
                <div class="maximizer-stat">
                    <div class="maximizer-value" id="tradeAccuracy">0%</div>
                    <div class="maximizer-label">Trade Accuracy</div>
                </div>
                <div class="maximizer-stat">
                    <div class="maximizer-value" id="profitMultiplier">1.0x</div>
                    <div class="maximizer-label">Profit Multiplier</div>
                </div>
                <div class="maximizer-stat">
                    <div class="maximizer-value" id="ethPrice">140K</div>
                    <div class="maximizer-label">ETH/ETB Rate</div>
                </div>
            </div>
            <div class="eth-actions">
                <button class="eth-action-btn" onclick="boostEthereumProfits()">
                    ⚡ Boost Profits
                </button>
                <button class="eth-action-btn" onclick="analyzeEthereumMarket()">
                    📊 Analyze Market
                </button>
                <button class="eth-action-btn" onclick="activateSmartMode()">
                    🧠 Smart Mode
                </button>
                <button class="eth-action-btn" onclick="optimizeGasFees()">
                    ⛽ Optimize Gas
                </button>
            </div>
        </div>

        <div class="content-grid">
            <div class="stats-sidebar">
                <div class="stat-card pnl">
                    <div class="stat-label">
                        <span>ጠቅላላ ትርፍ/ጉዳት</span>
                        <span>🔥 Live</span>
                    </div>
                    <div class="stat-label">Total P/L</div>
                    <div class="stat-value positive" id="totalPnL">+ETB 0.00</div>
                </div>
                
                <div class="stat-card runs">
                    <div class="stat-label">ጠቅላላ ስራዎች</div>
                    <div class="stat-label">Total Sessions</div>
                    <div class="stat-value" id="totalRuns">0</div>
                </div>
                
                <div class="stat-card trades">
                    <div class="stat-label">ጠቅላላ ንግዶች</div>
                    <div class="stat-label">Total Trades</div>
                    <div class="stat-value" id="totalTrades">0</div>
                    <div class="eth-network-stats">
                        <div class="network-stat">
                            <div class="network-value" id="ethTrades">0</div>
                            <div class="network-label">ETH Trades</div>
                        </div>
                        <div class="network-stat">
                            <div class="network-value" id="successRate">0%</div>
                            <div class="network-label">Success Rate</div>
                        </div>
                    </div>
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
                    <div class="stat-label">Trading Tier</div>
                    <div class="stat-value" id="currentTier" style="font-size: 1.3rem; color: var(--eth-blue)">ETHEREUM PRO</div>
                </div>
            </div>

            <div class="logs-section">
                <div class="logs-header">
                    <h2 class="logs-title">📊 የሮቦት መዝገቦች / Bot Logs</h2>
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
        // ULTIMATE ETHEREUM PROFIT BOT
        let botState = {
            isRunning: false,
            isPaused: false,
            totalPnL: 0,
            totalRuns: 0,
            totalTrades: 0,
            ethereumTrades: 0,
            winningTrades: 0,
            currentBalance: {{ Auth::user()->wallet_balance }},
            tradingInterval: null,
            logInterval: null,
            analysisInterval: null,
            consecutiveWins: 0,
            marketTrend: 'bullish',
            profitBoost: 0.035, // 3.5% base profit boost
            winStreak: 0,
            lossStreak: 0,
            marketVolatility: 0.16,
            tradingSession: 0,
            profitGrowthFactor: 1.25, // Starting growth factor
            lossReductionFactor: 0.75, // Starting loss reduction
            sessionMultiplier: 1.3, // Starting multiplier
            profitPerHour: 0,
            sessionStartTime: null,
            smartMode: true,
            aggressiveMode: false,
            riskLevel: 'optimized',
            lastTradeTime: null,
            tradeFrequency: 2500, // 2.5 seconds base
            maxProfitPerTrade: 1000,
            minProfitPerTrade: 50,
            ethereumPrice: 2500,
            ethToEtbRate: 140,
            gasOptimized: true,
            networkCongestion: 0.3,
            smartContracts: []
        };
    
        // ADVANCED Ethereum Profit Bot
        class AdvancedEthereumBot {
            constructor() {
                this.pairs = [
                    'ETH/ETB', 
                    'ETH/USDT', 
                    'ETH/BTC',
                    'ETH/DeFi Pairs',
                    'ETH/Layer 2'
                ];
                this.currentPair = this.pairs[0];
                this.investmentAmount = {{$amount}};
                this.lastPrice = this.generateAdvancedEthereumPrice();
                this.priceHistory = [this.lastPrice];
                this.minInvestment = 200; // Minimum 200 ETB
                
                // Advanced tier system for maximum Ethereum profits
                if (this.investmentAmount >= 20000) {
                    this.tier = 'ETHEREUM ELITE';
                    this.baseWinRate = 0.88;
                    this.profitRange = { min: 300, max: 1200 };
                    this.lossRange = { min: 40, max: 180 };
                    botState.aggressiveMode = true;
                    botState.tradeFrequency = 1800;
                } else if (this.investmentAmount >= 10000) {
                    this.tier = 'ETHEREUM PRO';
                    this.baseWinRate = 0.85;
                    this.profitRange = { min: 200, max: 800 };
                    this.lossRange = { min: 50, max: 150 };
                } else if (this.investmentAmount >= 5000) {
                    this.tier = 'ETHEREUM PLUS';
                    this.baseWinRate = 0.82;
                    this.profitRange = { min: 150, max: 500 };
                    this.lossRange = { min: 60, max: 120 };
                } else if (this.investmentAmount >= 2000) {
                    this.tier = 'ETHEREUM STANDARD';
                    this.baseWinRate = 0.78;
                    this.profitRange = { min: 80, max: 350 };
                    this.lossRange = { min: 70, max: 100 };
                } else {
                    this.tier = 'ETHEREUM BASIC';
                    this.baseWinRate = 0.75;
                    this.profitRange = { min: 50, max: 200 };
                    this.lossRange = { min: 80, max: 90 };
                }
                
                // Initialize smart contracts
                this.initializeSmartContracts();
            }
    
            initializeSmartContracts() {
                botState.smartContracts = [
                    { name: 'Profit Accelerator', active: true, multiplier: 1.2 },
                    { name: 'Loss Protection', active: true, protection: 0.7 },
                    { name: 'Trend Prediction', active: true, accuracy: 0.8 },
                    { name: 'Gas Optimizer', active: botState.gasOptimized, savings: 0.15 }
                ];
            }
    
            generateAdvancedEthereumPrice(basePrice = 2500) {
                let priceChange;
                
                // Smart trend following with momentum
                const momentum = botState.consecutiveWins * 0.5;
                priceChange = (Math.random() - 0.4 + (momentum * 0.1)) * 120 * botState.marketVolatility;
                
                // Enhanced trend analysis
                if (botState.marketTrend === 'bullish') {
                    priceChange += Math.random() * 120 + 20;
                } else if (botState.marketTrend === 'bearish') {
                    priceChange -= Math.random() * 80;
                }
                
                // Network effect bonus (Ethereum adoption)
                const networkEffect = botState.tradingSession * 0.1;
                priceChange += networkEffect;
                
                // Smart contract effect
                const contractBoost = botState.smartContracts.reduce((acc, contract) => 
                    contract.active ? acc * (contract.multiplier || 1) : acc, 1);
                priceChange *= contractBoost;
                
                const usdPrice = Math.max(1800, basePrice + priceChange);
                return usdPrice * botState.ethToEtbRate;
            }
    
            updateAdvancedMetrics() {
                botState.tradingSession++;
                
                // Dynamic profit scaling
                if (botState.consecutiveWins >= 2) {
                    botState.profitGrowthFactor = Math.min(2.2, botState.profitGrowthFactor + 0.025);
                    botState.lossReductionFactor = Math.max(0.4, botState.lossReductionFactor - 0.02);
                    botState.sessionMultiplier = Math.min(2.8, botState.sessionMultiplier + 0.035);
                    
                    // Update profit multiplier display
                    document.getElementById('profitMultiplier').textContent = 
                        botState.sessionMultiplier.toFixed(1) + 'x';
                }
                
                // Adaptive trading frequency
                if (botState.winStreak >= 4) {
                    botState.tradeFrequency = Math.max(1200, botState.tradeFrequency - 100);
                }
                
                // Calculate real-time profit per hour
                if (botState.sessionStartTime) {
                    const hoursRunning = (new Date() - botState.sessionStartTime) / 3600000;
                    if (hoursRunning > 0.083) { // After 5 minutes
                        botState.profitPerHour = botState.totalPnL / hoursRunning;
                        this.updateProfitMetrics();
                    }
                }
                
                // Update Ethereum price display
                const ethPriceInEtb = (botState.ethereumPrice * botState.ethToEtbRate / 1000).toFixed(1);
                document.getElementById('ethPrice').textContent = ethPriceInEtb + 'K';
            }
    
            updateMarketTrend() {
                let bullishProb = 0.7; // High bullish bias for Ethereum
                
                // Advanced trend prediction
                if (botState.winStreak >= 3) {
                    bullishProb = 0.82;
                } else if (botState.lossStreak >= 2) {
                    bullishProb = 0.6;
                }
                
                // Time-based market analysis (UTC peak hours)
                const hour = new Date().getUTCHours();
                if (hour >= 13 && hour <= 17) { // US market hours
                    bullishProb += 0.12;
                }
                
                // Network activity factor
                const networkActivity = Math.min(0.1, botState.totalTrades * 0.0001);
                bullishProb += networkActivity;
                
                const trendRandom = Math.random();
                if (trendRandom < bullishProb * 0.75) {
                    botState.marketTrend = 'bullish';
                } else if (trendRandom < bullishProb) {
                    botState.marketTrend = 'strong bullish';
                } else if (trendRandom < 0.9) {
                    botState.marketTrend = 'neutral';
                } else {
                    botState.marketTrend = 'bearish';
                }
            }
    
            calculateAdvancedWinRate() {
                let winRate = this.baseWinRate;
                
                // Enhanced trend bonuses
                if (botState.marketTrend === 'strong bullish') {
                    winRate += 0.12;
                } else if (botState.marketTrend === 'bullish') {
                    winRate += 0.08;
                } else if (botState.marketTrend === 'bearish') {
                    winRate -= 0.03; // Minimal reduction
                }
                
                // Smart performance bonuses
                if (botState.winStreak >= 3) {
                    winRate += 0.05 * Math.min(botState.winStreak, 6);
                }
                if (botState.consecutiveWins >= 4) {
                    winRate += 0.04;
                }
                
                // Smart contract bonuses
                const trendContract = botState.smartContracts.find(c => c.name === 'Trend Prediction');
                if (trendContract && trendContract.active) {
                    winRate += 0.03;
                }
                
                // Keep within optimal bounds (75-92%)
                return Math.max(0.75, Math.min(0.92, winRate));
            }
    
            smartTradeDecision() {
                if (botState.currentBalance < this.minInvestment * 1.5) {
                    return false;
                }
                
                let tradeProbability = 0.85; // High probability for Ethereum
                
                // Smart decision making
                if (botState.winStreak >= 3) {
                    tradeProbability = 0.92;
                } else if (botState.lossStreak >= 2) {
                    tradeProbability = 0.68;
                }
                
                // Market condition adjustments
                if (botState.marketTrend.includes('bullish')) {
                    tradeProbability += 0.1;
                }
                
                // Gas optimization check
                if (botState.gasOptimized && botState.networkCongestion < 0.5) {
                    tradeProbability += 0.05;
                }
                
                return Math.random() < tradeProbability;
            }
    
            calculateAdvancedProfitLoss(isWin) {
                let amount;
                
                if (isWin) {
                    // Advanced profit calculation with multiple enhancements
                    const baseProfit = Math.random() * (this.profitRange.max - this.profitRange.min) + this.profitRange.min;
                    
                    // Apply all profit multipliers
                    amount = baseProfit;
                    amount *= botState.profitGrowthFactor;
                    amount *= botState.sessionMultiplier;
                    amount *= (1 + botState.profitBoost);
                    
                    // Smart contract acceleration
                    const accelerator = botState.smartContracts.find(c => c.name === 'Profit Accelerator');
                    if (accelerator && accelerator.active) {
                        amount *= accelerator.multiplier;
                    }
                    
                    // Streak and momentum bonuses
                    if (botState.winStreak >= 3) {
                        amount *= (1 + botState.winStreak * 0.06);
                    }
                    
                    // Aggressive mode bonus
                    if (botState.aggressiveMode) {
                        amount *= 1.18;
                    }
                    
                    // Ensure profitable minimum
                    amount = Math.max(this.profitRange.min * 2, amount);
                    
                    // Cap with smart limits
                    return Math.min(botState.maxProfitPerTrade * 1.2, amount);
                } else {
                    // Advanced loss control with protection
                    amount = Math.random() * (this.lossRange.max - this.lossRange.min) + this.lossRange.min;
                    
                    // Apply loss reduction factors
                    amount *= botState.lossReductionFactor;
                    
                    // Smart contract protection
                    const protection = botState.smartContracts.find(c => c.name === 'Loss Protection');
                    if (protection && protection.active) {
                        amount *= protection.protection;
                    }
                    
                    // Further reduction strategies
                    if (botState.lossStreak >= 2) {
                        amount *= 0.65;
                    }
                    
                    // Gas optimization savings
                    if (botState.gasOptimized) {
                        amount *= 0.85;
                    }
                    
                    // Minimum loss with protection
                    amount = Math.max(this.lossRange.min * 0.25, amount);
                    
                    return -Math.min(botState.maxProfitPerTrade * 0.25, amount);
                }
            }
    
            executeAdvancedTrade() {
                if (!this.smartTradeDecision()) {
                    // Still provide market insights
                    if (Math.random() < 0.25) {
                        this.logMarketInsights();
                    }
                    return false;
                }
    
                // Update advanced metrics
                this.updateAdvancedMetrics();
                
                // Update market trend with smart analysis
                if (Math.random() < 0.18) {
                    this.updateMarketTrend();
                }
    
                const currentPrice = this.generateAdvancedEthereumPrice(this.lastPrice / botState.ethToEtbRate);
                const winProbability = this.calculateAdvancedWinRate();
                const isWinningTrade = Math.random() < winProbability;
                
                let pnl = this.calculateAdvancedProfitLoss(isWinningTrade);
                
                // Apply Ethereum network bonuses
                const networkBonus = Math.abs(pnl) * 0.018; // 1.8% network bonus
                pnl = pnl > 0 ? pnl + networkBonus : pnl + (networkBonus * 0.6);
                
                // Update streaks and counters
                if (isWinningTrade) {
                    botState.consecutiveWins++;
                    botState.winStreak++;
                    botState.lossStreak = 0;
                    botState.ethereumTrades++;
                    
                    // Special Ethereum bonuses
                    if (botState.consecutiveWins % 4 === 0) {
                        pnl *= 1.25; // 25% bonus every 4 wins
                        this.logEthereumBonus();
                    }
                } else {
                    botState.consecutiveWins = 0;
                    botState.winStreak = 0;
                    botState.lossStreak++;
                }
    
                // Update all statistics
                botState.totalTrades++;
                botState.totalPnL += pnl;
                botState.currentBalance += pnl;
                botState.lastTradeTime = new Date();
                
                if (pnl > 0) {
                    botState.winningTrades++;
                }
    
                // Update profit counter in real-time
                document.getElementById('ethProfitCounter').textContent = 
                    `+ETB ${botState.totalPnL.toFixed(2)}`;
    
                // Enhanced Ethereum trading logs
                const timestamp = this.getCurrentTimestamp();
                const isBuy = Math.random() > 0.5;
                const tradeType = isBuy ? 'ግዢ / BUY 📈' : 'ሽያጭ / SELL 📉';
                const ethPriceInEtb = (currentPrice / 1000).toFixed(2);
                const pnlText = pnl >= 0 ? 
                    `🎯 +ETB ${pnl.toFixed(2)}` : 
                    `⚠️ -ETB ${Math.abs(pnl).toFixed(2)}`;
                
                // Profit-focused Ethereum logging
                if (pnl > 0) {
                    const successLevel = pnl > this.profitRange.min * 4 ? '🚀' : '✅';
                    const ethSuccessMessages = [
                        `${successLevel} የኢተርየም ስልት ተሳክቷል! / Ethereum strategy successful!`,
                        `${successLevel} የኢተርየም ኔትወርክ ትርፍ አስገኝቷል! / Ethereum network generated profit!`,
                        `${successLevel} የማርት ካፕ ጭማሪ ተገኝቷል! / Market cap increase achieved!`,
                        `${successLevel} የዲፒኦኤስ ምክንያት አዋጅ! / DPoS advantage activated!`
                    ];
                    
                    const randomMessage = ethSuccessMessages[Math.floor(Math.random() * ethSuccessMessages.length)];
                    addLogEntry(timestamp, 
                        `<span class="log-eth">${randomMessage}</span> | ${tradeType} ${this.currentPair} @ ${ethPriceInEtb}K ETB | ትርፍ / Profit: ${pnlText}`, 
                        'success');
                    
                    // Major profit celebrations
                    if (pnl > this.profitRange.min * 6) {
                        addLogEntry(timestamp, "🎊 ከፍተኛ የኢተርየም ትርፍ! ስልቱ ከፍተኛ አፈፃፀም ያሳያል! / Major Ethereum profit! Exceptional strategy performance!", 'success');
                        this.triggerEthereumAnimation();
                    }
                } else {
                    const ethControlledMessages = [
                        "🛡️ የኢተርየም ጉዳት ተቆጠበ / Ethereum loss protected",
                        "⚖️ የጋዝ ክፍያ ተመዝግቧል / Gas fee accounted",
                        "📉 ትንሽ የመረብ ማስተካከል / Minor network adjustment",
                        "🎯 የሚቀጥለው የኢተርየም ግብይት ይሻላል! / Next Ethereum trade will be better!"
                    ];
                    addLogEntry(timestamp, 
                        `${ethControlledMessages[Math.floor(Math.random() * ethControlledMessages.length)]} | ${tradeType} ${this.currentPair} @ ${ethPriceInEtb}K ETB | ጉዳት / Loss: ${pnlText}`, 
                        'warning');
                }
                
                // Ethereum-specific milestones
                this.checkEthereumMilestones(timestamp);
                
                // Update all interfaces
                this.updateWalletBalance(botState.currentBalance);
                this.updateAllStats();
                
                this.lastPrice = currentPrice;
                return true;
            }
    
            logMarketInsights() {
                const timestamp = this.getCurrentTimestamp();
                const insights = [
                    "🔍 የኢተርየም ገበያ ትንተና: ትርፋማ እድሎች ከፍተኛ / Ethereum market analysis: High profit opportunities",
                    "📈 የETH ዋጋ እንቅስቃሴ: ከፍተኛ ፍጥነት / ETH price action: High momentum",
                    "💹 የዲፊ ገበያ እድገት: አወንታዊ አመላካቾች / DeFi market growth: Positive indicators",
                    "🌐 ኔትወርክ አጠቃቀም: ከፍተኛ እና ጠቃሚ / Network utilization: High and favorable",
                    "⚡ የላየር 2 መፍትሔዎች: ትርፋማ እድሎች / Layer 2 solutions: Profitable opportunities"
                ];
                
                addLogEntry(timestamp, insights[Math.floor(Math.random() * insights.length)], 'info');
            }
    
            logEthereumBonus() {
                const timestamp = this.getCurrentTimestamp();
                addLogEntry(timestamp, "🏆 የኢተርየም ልዩ ቦነስ! 4 ተከታታይ የተሳኩ ግብይቶች! / Ethereum special bonus! 4 consecutive winning trades!", 'success');
            }
    
            checkEthereumMilestones(timestamp) {
                // Win streak milestones
                if (botState.winStreak === 5) {
                    addLogEntry(timestamp, "🔥 5 ተከታታይ የኢተርየም ትርፎች! አስደናቂ አፈፃፀም! / 5 consecutive Ethereum profits! Amazing performance!", 'success');
                }
                if (botState.winStreak === 10) {
                    addLogEntry(timestamp, "🚀 10 ተከታታይ የኢተርየም ትርፎች! ከፍተኛ የስልት አፈፃፀም! / 10 consecutive Ethereum profits! Maximum strategy performance!", 'success');
                }
                
                // Trade count milestones
                if (botState.totalTrades % 20 === 0 && botState.totalTrades > 0) {
                    const winRate = (botState.winningTrades / botState.totalTrades * 100).toFixed(1);
                    const totalProfit = botState.totalPnL.toFixed(2);
                    const profitPerTrade = (botState.totalPnL / botState.totalTrades).toFixed(2);
                    const ethTrades = botState.ethereumTrades;
                    
                    addLogEntry(timestamp, 
                        `📊 የኢተርየም ሚሊስቶን / Ethereum Milestone: ${botState.totalTrades} ግብይቶች / trades (${ethTrades} ETH) | ${winRate}% ትክክለኛነት / accuracy | አጠቃላይ ትርፍ / Total: ETB ${totalProfit} | አማካይ ትርፍ በግብይት / Avg per trade: ETB ${profitPerTrade}`, 
                        'info');
                }
                
                // Major profit milestones
                if (botState.totalPnL >= 2000 && botState.totalPnL < 2010) {
                    addLogEntry(timestamp, "🎉 ከETB 2,000 በላይ የኢተርየም ትርፍ ተሰራ! / Over ETB 2,000 Ethereum profit achieved!", 'success');
                }
                if (botState.totalPnL >= 5000) {
                    addLogEntry(timestamp, "🏆 ከETB 5,000 የኢተርየም ትርፍ! ከፍተኛ አፈፃፀም! / ETB 5,000 Ethereum profit! Elite performance!", 'success');
                }
            }
    
            triggerEthereumAnimation() {
                const alertElement = document.getElementById('ethProfitAlert');
                alertElement.style.animation = 'none';
                setTimeout(() => {
                    alertElement.style.animation = 'slideDown 0.5s ease-out, ethGlow 1s 3';
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
                const pnlElement = document.getElementById('totalPnL');
                pnlElement.textContent = (botState.totalPnL >= 0 ? '+' : '') + 'ETB ' + Math.abs(botState.totalPnL).toFixed(2);
                pnlElement.className = 'stat-value ' + (botState.totalPnL >= 0 ? 'positive' : 'negative');
                
                document.getElementById('totalTrades').textContent = botState.totalTrades;
                document.getElementById('currentBalance').textContent = 'ETB ' + botState.currentBalance.toFixed(2);
                
                const winRate = botState.totalTrades > 0 ? 
                    (botState.winningTrades / botState.totalTrades * 100).toFixed(1) : 0;
                document.getElementById('winRate').textContent = winRate + '%';
                document.getElementById('tradeAccuracy').textContent = winRate + '%';
                
                // Update Ethereum-specific stats
                document.getElementById('ethTrades').textContent = botState.ethereumTrades;
                document.getElementById('successRate').textContent = winRate + '%';
                
                // Mobile updates
                document.getElementById('mobileBalance').textContent = 'ETB ' + botState.currentBalance.toFixed(2);
                const changeText = (botState.totalPnL >= 0 ? '+' : '') + 'ETB ' + Math.abs(botState.totalPnL).toFixed(2);
                document.getElementById('mobileBalanceChange').textContent = changeText;
                document.getElementById('mobileBalanceChange').className = 'balance-change ' + (botState.totalPnL >= 0 ? 'positive' : 'negative');
                
                // Update tier with performance metrics
                const growthPercent = ((botState.profitGrowthFactor - 1) * 100).toFixed(1);
                document.getElementById('currentTier').textContent = `${this.tier} | +${growthPercent}% Growth`;
            }
    
            updateProfitMetrics() {
                document.getElementById('profitPerHour').textContent = 'ETB ' + Math.max(0, botState.profitPerHour).toFixed(0);
            }
    
            getCurrentTimestamp() {
                const now = new Date();
                const ethiopianTime = new Date(now.getTime() + (3 * 60 * 60 * 1000));
                return ethiopianTime.toTimeString().split(' ')[0] + '.' + 
                       ethiopianTime.getMilliseconds().toString().padStart(3, '0');
            }
        }
    
        // Initialize the advanced Ethereum profit bot
        const tradingBot = new AdvancedEthereumBot();
    
        // UI Interaction Functions
        function addLogEntry(timestamp, message, type = 'info') {
            const logsContainer = document.getElementById('logsContainer');
            const logEntry = document.createElement('div');
            logEntry.className = `log-entry ${type}`;
            logEntry.innerHTML = `<span class="log-timestamp">[${timestamp} EAT]</span> ${message}`;
            logsContainer.appendChild(logEntry);
            logsContainer.scrollTop = logsContainer.scrollHeight;
            document.getElementById('logsCount').textContent = `${logsContainer.children.length} entries`;
        }
    
        function boostEthereumProfits() {
            if (!botState.isRunning) return;
            
            botState.profitBoost += 0.025;
            botState.aggressiveMode = true;
            botState.tradeFrequency = Math.max(1000, botState.tradeFrequency - 300);
            
            const timestamp = tradingBot.getCurrentTimestamp();
            addLogEntry(timestamp, "⚡ የኢተርየም ትርፍ እፍጋት ተነሳ! የግብይት ፍጥነት እና ትርፍ መጠን ጨምሯል! / Ethereum profit boost activated! Increased trading speed and profit margin!", 'success');
            addLogEntry(timestamp, "🎯 አዲስ ትርፍ ማባዣ: " + (1 + botState.profitBoost).toFixed(3) + "x", 'info');
        }
    
        function analyzeEthereumMarket() {
            const timestamp = tradingBot.getCurrentTimestamp();
            const analyses = [
                "🔍 የኢተርየም ገበያ ትንተና: የETH ዋጋ በማጠጋጋት ላይ / Ethereum market analysis: ETH price consolidating",
                "📈 የቴክኒካል አመላካቾች: ሁሉም አወንታዊ / Technical indicators: All positive",
                "💹 የዲፊ ትራክሽን: ከፍተኛ ዕድገት / DeFi traction: High growth",
                "🌐 ኔትወርክ እንቅስቃሴ: ከፍተኛ እና ጠቃሚ / Network activity: High and favorable",
                "⚡ የላየር 2 ውጤቶች: በጣም አወንታዊ / Layer 2 results: Very positive"
            ];
            
            addLogEntry(timestamp, analyses[Math.floor(Math.random() * analyses.length)], 'info');
        }
    
        function activateSmartMode() {
            botState.smartMode = true;
            const timestamp = tradingBot.getCurrentTimestamp();
            
            addLogEntry(timestamp, "🧠 የኢተርየም ስማርት ሞድ ተጀመረ! / Ethereum Smart Mode activated!", 'success');
            addLogEntry(timestamp, "⚡ ስማርት ኮንትራቶች ንቁ: ትርፍ ማባዣ, ጉዳት መከላከያ, ጋዝ ቅነሳ / Smart contracts active: Profit multiplier, Loss protection, Gas reduction", 'info');
        }
    
        function optimizeGasFees() {
            botState.gasOptimized = true;
            botState.networkCongestion *= 0.7;
            
            const timestamp = tradingBot.getCurrentTimestamp();
            addLogEntry(timestamp, "⛽ የኢተርየም ጋዝ ክፍያ ቅነሳ ተከናወነ! / Ethereum gas fee optimization completed!", 'success');
            addLogEntry(timestamp, "💰 የጋዝ ክፍያ ቁጠባ: " + ((1 - botState.networkCongestion) * 100).toFixed(1) + "%", 'info');
        }
    
        // Bot Control Functions
        function startBot() {
            botState.isRunning = true;
            botState.isPaused = false;
            botState.totalRuns++;
            botState.sessionStartTime = new Date();
            
            document.getElementById('totalRuns').textContent = botState.totalRuns;
            updateBotStatus('running', '⚡ የኢተርየም ትርፋማ ንግድ በመካሄድ ላይ / Ethereum Profitable Trading Active');
            
            document.getElementById('startBtn').disabled = true;
            document.getElementById('pauseBtn').disabled = false;
            document.getElementById('stopBtn').disabled = false;
            
            const timestamp = tradingBot.getCurrentTimestamp();
            addLogEntry(timestamp, `🚀 የትርፍ-አመቻች ኢትዮጵያ ኢተርየም ንግድ ሮቦት ተጅምሯል! / Profit-optimized Ethiopian Ethereum Trading Bot launched!`, 'success');
            addLogEntry(timestamp, `💎 ደረጃ / Tier: ${tradingBot.tier} | መሠረታዊ የማሸነፍ መጠን / Base win rate: ${(tradingBot.baseWinRate*100).toFixed(1)}%`, 'info');
            addLogEntry(timestamp, `🎯 አላማ / Target: ETB ${tradingBot.profitRange.min}-${tradingBot.profitRange.max} per winning trade`, 'info');
            addLogEntry(timestamp, `⚡ የኢተርየም ከፍተኛ ትርፍ ሞድ ነቅቷል! / Ethereum maximum profit mode activated!`, 'success');
            addLogEntry(timestamp, `🌐 የኢተርየም ኔትወርክ ጥቅሞች ንቁ / Ethereum network benefits active`, 'info');
            
            // Optimized Ethereum trading intervals
            botState.tradingInterval = setInterval(() => {
                if (botState.isRunning && !botState.isPaused) {
                    tradingBot.executeAdvancedTrade();
                }
            }, botState.tradeFrequency);
            
            // Enhanced market analysis
            botState.logInterval = setInterval(() => {
                if (botState.isRunning && !botState.isPaused) {
                    tradingBot.logMarketInsights();
                }
            }, Math.random() * 6000 + 3000);
            
            // Performance monitoring
            botState.analysisInterval = setInterval(() => {
                if (botState.isRunning && !botState.isPaused) {
                    tradingBot.updateAdvancedMetrics();
                }
            }, 15000); // Every 15 seconds
        }
    
        function pauseBot() {
            botState.isPaused = !botState.isPaused;
            const pauseBtn = document.getElementById('pauseBtn');
            if (botState.isPaused) {
                updateBotStatus('paused', '⏸️ ተቆምቷል / Paused');
                pauseBtn.textContent = '▶️ Resume Trading';
                addLogEntry(tradingBot.getCurrentTimestamp(), '⏸️ የኢተርየም ንግድ በቅጥ ተቆምቷል / Ethereum trading strategically paused', 'warning');
            } else {
                updateBotStatus('running', '⚡ የኢተርየም ትርፋማ ንግድ በመካሄድ ላይ / Ethereum Profitable Trading Active');
                pauseBtn.textContent = '⏸️ Pause';
                addLogEntry(tradingBot.getCurrentTimestamp(), '▶️ የኢተርየም ንግድ በተመራጭ ሁኔታ ቀጥሏል / Ethereum trading optimally resumed', 'success');
            }
        }
    
        function stopBot() {
            if (confirm('የኢተርየም ንግድ ሮቦቱን ማቆም ትፈልጋለህ? የተሰራ ትርፍ ይቆጠራል! / Stop the Ethereum trading bot? Profits will be saved!')) {
                botState.isRunning = false;
                botState.isPaused = false;
                clearInterval(botState.tradingInterval);
                clearInterval(botState.logInterval);
                clearInterval(botState.analysisInterval);
                updateBotStatus('stopped', '✅ የኢተርየም ትርፍ ተቀምጧል / Ethereum Profits Saved');
                
                document.getElementById('startBtn').disabled = false;
                document.getElementById('pauseBtn').disabled = true;
                document.getElementById('stopBtn').disabled = true;
                
                const winRate = botState.totalTrades > 0 ? 
                    (botState.winningTrades / botState.totalTrades * 100).toFixed(1) : 0;
                const profitPerHour = botState.profitPerHour.toFixed(2);
                const ethTrades = botState.ethereumTrades;
                
                const finalStats = `📊 የኢተርየም ክፍለ ጊዜ ማጠቃለያ / Ethereum Session Summary:
                ${botState.totalTrades} ግብይቶች / trades (${ethTrades} ETH)
                ${winRate}% የማሸነፍ መጠን / win rate
                አጠቃላይ ትርፍ / Net P&L: ${botState.totalPnL >= 0 ? '+' : ''}ETB ${botState.totalPnL.toFixed(2)}
                በሰዓት ትርፍ / Profit per hour: ETB ${profitPerHour}`;
                
                addLogEntry(tradingBot.getCurrentTimestamp(), '✅ የኢተርየም ንግድ ሮቦት በትክክል ተቆምቷል / Ethereum trading bot successfully stopped', 'success');
                addLogEntry(tradingBot.getCurrentTimestamp(), finalStats, 'info');
                
                // Performance rating
                if (botState.totalPnL > 1000) {
                    addLogEntry(tradingBot.getCurrentTimestamp(), '🏆 ከፍተኛ አፈፃፀም! በጣም ትርፋማ የኢተርየም ክፍለ ጊዜ! / Excellent performance! Highly profitable Ethereum session!', 'success');
                } else if (botState.totalPnL > 500) {
                    addLogEntry(tradingBot.getCurrentTimestamp(), '✅ ጥሩ አፈፃፀም! ትርፋማ የኢተርየም ክፍለ ጊዜ / Good performance! Profitable Ethereum session', 'success');
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
                updateBotStatus('stopped', '🚀 ለትርፋማ የኢተርየም ንግድ ዝግጁ / Ready for Profitable Ethereum Trading');
            @endif
            
            const timestamp = tradingBot.getCurrentTimestamp();
            addLogEntry(timestamp, `💎 የትርፍ-አመቻች ኢትዮጵያ ኢተርየም ንግድ ስርዓት ተጭኗል / Profit-optimized Ethiopian Ethereum Trading System loaded`, 'success');
            addLogEntry(timestamp, `💰 የመጀመሪያ ሒሳብ / Initial Balance: ETB ${botState.currentBalance.toFixed(2)}`, 'info');
            addLogEntry(timestamp, `⚡ ${tradingBot.tier} ደረጃ - ከፍተኛ የኢተርየም ትርፍ ሞድ / ${tradingBot.tier} Tier - Maximum Ethereum Profit Mode`, 'info');
            addLogEntry(timestamp, `🎯 አላማዎች / Targets: ${(tradingBot.baseWinRate*100).toFixed(1)}% win rate | ETB ${tradingBot.profitRange.min}+ per trade | Automated Ethereum profit growth`, 'info');
            addLogEntry(timestamp, `🌐 የኢተርየም ኔትወርክ ባህሪዎች: ስማርት ኮንትራቶች, ዲፒኦኤስ, ከፍተኛ ሽግግር / Ethereum features: Smart contracts, DPoS, high throughput`, 'info');
            
            @if(Auth::user()->wallet_balance < $amount)
                addLogEntry(timestamp, '❌ በቂ ሒሳብ ቀሪ ሂሳብ የለም / Add funds to start Ethereum trading', 'error');
                addLogEntry(timestamp, '💡 ምክር / Tip: Deposit at least ETB 500 for optimal Ethereum profit potential', 'info');
            @endif
        });
    </script>
    <!-- CSRF Token for AJAX requests -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</body>
@endsection