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

        .main-content {
            padding: 30px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .hero-section {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            border-radius: 16px;
            padding: 40px;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }

        .hero-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .hero-left {
            flex: 1;
        }

        .hero-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .hero-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 16px;
            margin-bottom: 30px;
        }

        .hero-stats {
            display: flex;
            gap: 60px;
        }

        .stat {
            text-align: left;
        }

        .stat-number {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .stat-label {
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
        }

        .weekly-return {
            color: #4ade80;
            font-size: 24px;
            font-weight: 700;
        }

        .create-bot-btn {
            background: white;
            color: #1e3a8a;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .create-bot-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 255, 255, 0.2);
        }

        .dashboard-layout {
            display: grid;
            grid-template-columns: 1fr;
            gap: 30px;
        }

        .dashboard-main {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .section-subtitle {
            color: #888;
            font-size: 14px;
        }

        .create-dca-btn {
            background: #4ade80;
            color: #000;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            margin-left: auto;
        }

        .bot-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 20px;
        }

        .bot-card {
            background: #1a1a20;
            border-radius: 12px;
            padding: 24px;
            border: 1px solid #2a2a30;
            transition: all 0.3s ease;
        }

        .bot-card:hover {
            border-color: #4ade80;
            transform: translateY(-2px);
        }

        .bot-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 16px;
        }

        .bot-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .bot-frequency {
            color: #888;
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .bot-status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-active {
            background: #4ade80;
            color: #000;
        }

        .status-inactive {
            background: #374151;
            color: #9ca3af;
        }

        .status-configured {
            background: #3b82f6;
            color: white;
        }

        .bot-description {
            color: #ccc;
            font-size: 14px;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .bot-metrics {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .metric {
            text-align: left;
        }

        .metric-label {
            color: #888;
            font-size: 12px;
            margin-bottom: 4px;
        }

        .metric-value {
            font-weight: 600;
            font-size: 14px;
        }

        .metric-value.positive {
            color: #4ade80;
        }

        .bot-actions {
            display: flex;
            gap: 12px;
        }

        .btn-secondary {
            background: #374151;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            flex: 1;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
        }

        .btn-secondary:hover {
            background: #4b5563;
        }

        .btn-primary {
            background: #4ade80;
            color: #000;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            flex: 1;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
        }

        .btn-primary:hover {
            background: #22c55e;
        }

        .btn-primary:disabled {
            background: #6b7280;
            color: #9ca3af;
            cursor: not-allowed;
        }

        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            z-index: 1000;
            backdrop-filter: blur(4px);
        }

        .modal-overlay.active {
            display: flex;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal {
            background: #1a1a20;
            border-radius: 16px;
            padding: 32px;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            border: 1px solid #2a2a30;
            animation: slideUp 0.3s ease;
            position: relative;
        }

        @keyframes slideUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid #2a2a30;
        }

        .modal-title {
            font-size: 20px;
            font-weight: 600;
            color: #4ade80;
        }

        .close-btn {
            background: none;
            border: none;
            color: #888;
            font-size: 24px;
            cursor: pointer;
            padding: 4px;
            border-radius: 4px;
            transition: all 0.2s;
        }

        .close-btn:hover {
            background: #374151;
            color: white;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 500;
            color: #e5e7eb;
        }

        .form-input,
        .form-select {
            width: 100%;
            padding: 12px;
            background: #0f1419;
            border: 1px solid #374151;
            border-radius: 8px;
            color: white;
            font-size: 14px;
            transition: all 0.2s;
        }

        .form-input:focus,
        .form-select:focus {
            outline: none;
            border-color: #4ade80;
            box-shadow: 0 0 0 3px rgba(74, 222, 128, 0.1);
        }

        .form-select option {
            background: #1a1a20;
            color: white;
        }

        .modal-actions {
            display: flex;
            gap: 12px;
            margin-top: 32px;
            padding-top: 20px;
            border-top: 1px solid #2a2a30;
        }

        .btn-cancel {
            background: #374151;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            flex: 1;
            transition: all 0.3s ease;
        }

        .btn-cancel:hover {
            background: #4b5563;
        }

        .btn-start {
            background: #4ade80;
            color: #000;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            flex: 1;
            transition: all 0.3s ease;
        }

        .btn-start:hover {
            background: #22c55e;
        }

        .btn-start:disabled {
            background: #6b7280;
            color: #9ca3af;
            cursor: not-allowed;
        }

        .investment-info {
            background: #0f1419;
            border-radius: 8px;
            padding: 12px;
            margin-top: 8px;
            border-left: 3px solid #4ade80;
        }

        .investment-info-label {
            color: #9ca3af;
            font-size: 12px;
            margin-bottom: 4px;
        }

        .investment-info-value {
            color: #4ade80;
            font-weight: 600;
            font-size: 14px;
        }

        .success-message {
            display: none;
            background: #065f46;
            border: 1px solid #10b981;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 20px;
            color: #d1fae5;
        }

        .success-message.show {
            display: block;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .error-message {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #dc2626;
            color: white;
            padding: 16px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(220, 38, 38, 0.3);
            z-index: 10000;
            max-width: 400px;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
        
        .loading {
            position: relative;
            pointer-events: none;
        }
        
        .loading::after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            margin: auto;
            border: 2px solid transparent;
            border-top-color: currentColor;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        
        .slide-in {
            animation: slideIn 0.3s ease;
        }
        
        @keyframes slideIn {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @media (max-width: 1200px) {
            .dashboard-layout {
                grid-template-columns: 1fr;
            }
            
            .hero-stats {
                gap: 40px;
            }
            
            .bot-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 20px;
            }
            
            .hero-section {
                padding: 30px 20px;
            }
            
            .hero-content {
                flex-direction: column;
                align-items: flex-start;
                gap: 20px;
            }
            
            .hero-stats {
                gap: 30px;
            }

            .modal {
                padding: 24px;
                margin: 20px;
            }
        }
    </style>

<body>
    <!-- Main Content -->
   <div class="success-message" id="successMessage">
        <strong>Bot Started Successfully!</strong> Your trading bot configuration has been saved and is now active.
    </div>

    <main class="main-content">
        <section class="hero-section">
            <div class="hero-content">
                <div class="hero-left">
                    <h1 class="hero-title">Automated Trading</h1>
                    <p class="hero-subtitle">Create and manage algorithmic trading strategies</p>
                    <div class="hero-stats">
                        <div class="stat">
                            <div class="stat-number" id="totalBots">4</div>
                            <div class="stat-label">Total Bots</div>
                        </div>
                        <div class="stat">
                            <div class="stat-number" id="activeBots">2</div>
                            <div class="stat-label">Active</div>
                        </div>
                        <div class="stat">
                            <div class="weekly-return">+4.8%</div>
                            <div class="stat-label">Weekly Return</div>
                        </div>
                    </div>
                </div>
                <button class="create-bot-btn">
                    Create New Bot →
                </button>
            </div>
        </section>

        <div class="dashboard-layout">
            <div class="dashboard-main">
                <div class="section-header">
                    <div>
                        <h2 class="section-title">Dollar-Cost Averaging Bots</h2>
                        <p class="section-subtitle">Regular purchases of assets regardless of price</p>
                    </div>
                    <button class="create-dca-btn">Create DCA Bot</button>
                </div>

                <div class="bot-grid">
                    <div class="bot-card" data-bot-id="bitcoin-accumulation">
                        <div class="bot-header">
                            <div>
                                <h3 class="bot-title">Bitcoin Accumulation</h3>
                                <div class="bot-frequency">Weekly • DCA</div>
                            </div>
                            <span class="bot-status status-inactive">Not Configured</span>
                        </div>
                        <p class="bot-description">Dollar-cost averaging into Bitcoin on a weekly basis</p>
                        <div class="bot-metrics">
                            <div class="metric">
                                <div class="metric-label">Risk:</div>
                                <div class="metric-value">Low</div>
                            </div>
                            <div class="metric">
                                <div class="metric-label">Performance:</div>
                                <div class="metric-value">--</div>
                            </div>
                        </div>
                        <div class="bot-actions">
                            <button class="btn-secondary bot-configure-btn" data-bot-type="bitcoin-accumulation">Configure</button>
                            <button class="btn-primary bot-start-btn" data-bot-type="bitcoin-accumulation" disabled>Start BA Bot</button>
                        </div>
                    </div>

                    <div class="bot-card" data-bot-id="eth-dca-pro">
                        <div class="bot-header">
                            <div>
                                <h3 class="bot-title">ETH DCA Pro</h3>
                                <div class="bot-frequency">Daily • DCA</div>
                            </div>
                            <span class="bot-status status-inactive">Not Configured</span>
                        </div>
                        <p class="bot-description">Dynamic DCA based on RSI and volume indicators</p>
                        <div class="bot-metrics">
                            <div class="metric">
                                <div class="metric-label">Risk:</div>
                                <div class="metric-value">Medium</div>
                            </div>
                            <div class="metric">
                                <div class="metric-label">Performance:</div>
                                <div class="metric-value">--</div>
                            </div>
                        </div>
                        <div class="bot-actions">
                            <button class="btn-secondary bot-configure-btn" data-bot-type="eth-dca-pro">Configure</button>
                            <button class="btn-primary bot-start-btn" data-bot-type="eth-dca-pro" disabled>Start DCA Pro</button>
                        </div>
                    </div>

                   
                </div>
            </div>
        </div>
    </main>

    <div class="modal-overlay" id="botModal">
        <div class="modal">
            <div class="modal-header">
                <h2 class="modal-title" id="modalTitle">Configure Trading Bot</h2>
                <button class="close-btn" id="closeModalBtn">&times;</button>
            </div>
            
            <form id="botConfigForm">
                <div class="form-group">
                    <label class="form-label">Select Asset</label>
                    <select class="form-select" id="assetSelect" required>
                        <option value="">Choose an asset...</option>
                        <option value="BTCUSDT">Bitcoin (BTC)</option>
                        <option value="ETHUSDT">Ethereum (ETH)</option>
                        <option value="BNBUSDT">Binance Coin (BNB)</option>
                        <option value="ADAUSDT">Cardano (ADA)</option>
                        <option value="SOLUSDT">Solana (SOL)</option>
                        <option value="DOTUSDT">Polkadot (DOT)</option>
                        <option value="MATICUSDT">Polygon (MATIC)</option>
                        <option value="LINKUSDT">Chainlink (LINK)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Investment Amount per Trade (ETB)</label>
                    <input type="number" class="form-input" id="investmentAmount" min="15545" max="1554596" step="15545" placeholder="100" required>
                    <div class="investment-info">
                        <div class="investment-info-label">Minimum: ETB 15,545.96 • Maximum: ETB 1,554,596.00</div>
                        <div class="investment-info-value">Enter the amount you want to invest per trade</div>
                    </div>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-cancel" id="cancelBtn">Cancel</button>
                    <button type="submit" class="btn-start" id="submitBtn">Save Configuration</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let currentBotType = '';
        let botConfigurations = {};

        document.addEventListener('DOMContentLoaded', function() {
            initializeEventListeners();
            addCardHoverEffects();
        });

        function initializeEventListeners() {
            console.log('Initializing event listeners...');
            
            // Configure buttons
            const configureButtons = document.querySelectorAll('.bot-configure-btn');
            configureButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const botType = this.getAttribute('data-bot-type');
                    console.log('Configure button clicked for bot type:', botType);
                    openBotModal(botType);
                });
            });

            // Start buttons
            const startButtons = document.querySelectorAll('.bot-start-btn');
            startButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const botType = this.getAttribute('data-bot-type');
                    console.log('Start button clicked for bot type:', botType);
                    
                    if (this.disabled) {
                        showError('Please configure the bot first before starting it.');
                        return;
                    }
                    
                    redirectToBotPage(botType);
                });
            });

            // Modal close event listeners
            const closeModalBtn = document.getElementById('closeModalBtn');
            const cancelBtn = document.getElementById('cancelBtn');
            const botConfigForm = document.getElementById('botConfigForm');
            
            if (closeModalBtn) {
                closeModalBtn.addEventListener('click', closeBotModal);
            }
            
            if (cancelBtn) {
                cancelBtn.addEventListener('click', closeBotModal);
            }
            
            // Form submission handler
            if (botConfigForm) {
                console.log('Attaching form submission listeners...');
                
                // Remove any existing listeners first
                const newForm = botConfigForm.cloneNode(true);
                botConfigForm.parentNode.replaceChild(newForm, botConfigForm);
                
                // Method 1: Form submit event
                newForm.addEventListener('submit', function(e) {
                    console.log('Form submit event triggered');
                    handleFormSubmission(e);
                });
                
                // Method 2: Submit button click event as backup
                const submitBtn = newForm.querySelector('#submitBtn');
                if (submitBtn) {
                    console.log('Submit button found, adding click listener');
                    submitBtn.addEventListener('click', function(e) {
                        console.log('Submit button clicked');
                        // If the button is of type submit, prevent default and handle manually
                        if (this.type === 'submit' || this.closest('form')) {
                            e.preventDefault();
                            e.stopPropagation();
                            handleFormSubmission(e);
                        }
                    });
                }
                
                console.log('Form submission listeners attached successfully');
            } else {
                console.error('botConfigForm not found during initialization!');
            }

            // Modal click outside to close
            const botModal = document.getElementById('botModal');
            if (botModal) {
                botModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeBotModal();
                    }
                });
            }

            // Keyboard event handlers
            document.addEventListener('keydown', function(e) {
                const modal = document.getElementById('botModal');
                
                if (e.key === 'Escape' && modal && modal.classList.contains('active')) {
                    closeBotModal();
                }
            });
        }

        function openBotModal(botType) {
            console.log('Opening modal for bot type:', botType);
            currentBotType = botType;
            const modal = document.getElementById('botModal');
            const title = document.getElementById('modalTitle');
            
            if (!modal) {
                console.error('Modal element not found');
                return;
            }
            
            if (title) {
                const botTitles = {
                    'bitcoin-accumulation': 'Configure Bitcoin Accumulation Bot',
                    'eth-dca-pro': 'Configure ETH DCA Pro Bot',
                    'multi-coin-dca': 'Configure Multi-Coin DCA Bot',
                    'cycle-based': 'Configure Cycle-Based Accumulation Bot'
                };
                title.textContent = botTitles[botType] || 'Configure Trading Bot';
                
                // Pre-select appropriate asset
                const assetSelect = document.getElementById('assetSelect');
                if (assetSelect) {
                    if (botType === 'bitcoin-accumulation') {
                        assetSelect.value = 'BTCUSDT';
                    } else if (botType === 'eth-dca-pro') {
                        assetSelect.value = 'ETHUSDT';
                    } else {
                        assetSelect.value = '';
                    }
                }
            }
            
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
            
            // Re-attach form listeners after modal opens to ensure they work
            setTimeout(() => {
                const form = document.getElementById('botConfigForm');
                if (form) {
                    console.log('Re-attaching form listeners after modal open');
                    
                    // Clear any existing listeners
                    const newForm = form.cloneNode(true);
                    form.parentNode.replaceChild(newForm, form);
                    
                    // Add submit event listener
                    newForm.addEventListener('submit', function(e) {
                        console.log('Form submit event (modal reattach)');
                        e.preventDefault();
                        handleFormSubmission(e);
                    });
                    
                    // Add button click listener
                    const submitButton = newForm.querySelector('#submitBtn');
                    if (submitButton) {
                        submitButton.addEventListener('click', function(e) {
                            console.log('Submit button clicked (modal reattach)');
                            const form = this.closest('form');
                            if (form) {
                                e.preventDefault();
                                const submitEvent = new Event('submit', { bubbles: true, cancelable: true });
                                form.dispatchEvent(submitEvent);
                            }
                        });
                    }
                    
                    console.log('Form listeners reattached successfully');
                } else {
                    console.error('Form not found during modal reattach');
                }
            }, 100);
        }

        function closeBotModal() {
            const modal = document.getElementById('botModal');
            if (modal) {
                modal.classList.remove('active');
            }
            document.body.style.overflow = 'auto';
            resetForm();
        }

        function resetForm() {
            const form = document.getElementById('botConfigForm');
            if (form) {
                form.reset();
            }
            currentBotType = '';
        }

        function handleFormSubmission(e) {
            console.log("=== FORM SUBMISSION HANDLER CALLED ===");
            console.log("Event:", e);
            e.preventDefault();
            e.stopPropagation();
            
            // Validate form before proceeding
            if (!validateForm()) {
                console.log("Form validation failed");
                return;
            }
            
            const assetSelect = document.getElementById('assetSelect');
            const investmentAmount = document.getElementById('investmentAmount');
            
            console.log("Asset value:", assetSelect?.value);
            console.log("Investment amount:", investmentAmount?.value);
            
            const formData = {
                botType: currentBotType,
                asset: assetSelect ? assetSelect.value : '',
                investmentAmount: investmentAmount ? parseFloat(investmentAmount.value) : 0,
                timestamp: new Date().toISOString(),
                status: 'configured'
            };
            
            console.log('Form data prepared:', formData);
            
            // Store configuration
            botConfigurations[currentBotType] = formData;
            console.log('Configuration stored for:', currentBotType);
            
            const submitBtn = document.getElementById('submitBtn');

            if (submitBtn) {
                const originalText = submitBtn.textContent;
                submitBtn.textContent = 'Saving...';
                submitBtn.disabled = true;
                submitBtn.classList.add('loading');
                console.log('Button state changed to saving...');

                setTimeout(() => {
                    console.log('Processing save...');
                    // Update bot status to configured
                    updateBotStatus(currentBotType, 'configured');
                    showSuccessMessage(`${getBotDisplayName(currentBotType)} configuration saved successfully!`);
                    
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('loading');
                    
                    console.log('Save completed successfully');
                    
                    // Close modal
                    closeBotModal();
                    
                    console.log('Bot Configuration Saved:', formData);
                }, 1500);
            } else {
                console.error('Submit button not found!');
            }
        }

        function validateForm() {
            const assetSelect = document.getElementById('assetSelect');
            const investmentAmount = document.getElementById('investmentAmount');
            
            const asset = assetSelect ? assetSelect.value : '';
            const amount = investmentAmount ? investmentAmount.value : '';
            
            if (!asset) {
                showError('Please select an asset');
                return false;
            }
            
            if (!amount || amount < 15545 || amount > 1554596) {
                showError('Please enter a valid investment amount between ETB 15545 and ETB 1554596');
                return false;
            }
            
            return true;
        }

        function updateBotStatus(botType, status) {
            const botCard = document.querySelector(`[data-bot-id="${botType}"]`);
            if (botCard) {
                const statusElement = botCard.querySelector('.bot-status');
                const startButton = botCard.querySelector('.bot-start-btn');
                
                if (status === 'configured') {
                    if (statusElement) {
                        statusElement.textContent = 'Configured';
                        statusElement.className = 'bot-status status-configured';
                    }
                    if (startButton) {
                        startButton.disabled = false;
                        startButton.classList.remove('disabled');
                    }
                } else if (status === 'active') {
                    if (statusElement) {
                        statusElement.textContent = 'Active';
                        statusElement.className = 'bot-status status-active';
                    }
                    if (startButton) {
                        startButton.textContent = 'Running';
                        startButton.disabled = true;
                        startButton.classList.add('pulse');
                    }
                }
            }
        }

        function redirectToBotPage(botType) {
            console.log('Redirecting to bot page for:', botType);
            
            // Check if bot is configured
            const config = botConfigurations[botType];
            if (!config) {
                showError('Bot is not configured. Please configure it first.');
                return;
            }
            
            // Determine bot page ID based on bot type
            let botPageId = '';
            switch(botType) {
                case 'bitcoin-accumulation':
                    botPageId = 'bt-1';
                    break;
                case 'eth-dca-pro':
                    botPageId = 'bt-2';
                    break;
                case 'multi-coin-dca':
                    botPageId = 'bt-3';
                    break;
                case 'cycle-based':
                    botPageId = 'bt-4';
                    break;
                default:
                    botPageId = 'bt-1';
            }
            
            // Update status to active before redirect
            updateBotStatus(botType, 'active');
            
            // Build redirect URL with parameters
            const redirectUrl = `/${botPageId}?amount=${config.investmentAmount}&asset=${config.asset}&botType=${botType}`;
            console.log('Redirecting to:', redirectUrl);
            
            // Show loading state on the button
            const startButton = document.querySelector(`[data-bot-type="${botType}"].bot-start-btn`);
            if (startButton) {
                startButton.textContent = 'Starting...';
                startButton.classList.add('loading');
            }
            
            // Redirect after short delay
            setTimeout(() => {
                window.location.href = redirectUrl;
            }, 1000);
        }

        function getBotDisplayName(botType) {
            const names = {
                'bitcoin-accumulation': 'Bitcoin Accumulation Bot',
                'eth-dca-pro': 'ETH DCA Pro Bot',
                'multi-coin-dca': 'Multi-Coin DCA Bot',
                'cycle-based': 'Cycle-Based Accumulation Bot'
            };
            return names[botType] || 'Trading Bot';
        }

        function showSuccessMessage(message) {
            const successDiv = document.getElementById('successMessage');
            if (successDiv) {
                successDiv.innerHTML = `<strong>Success!</strong> ${message}`;
                successDiv.classList.add('show');
                
                setTimeout(() => {
                    successDiv.classList.remove('show');
                }, 5000);
            }
        }

        function showError(message, duration = 5000) {
            console.error('Error:', message);
            
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message';
            errorDiv.innerHTML = `<strong>Error:</strong> ${message}`;
            errorDiv.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: #ef4444;
                color: white;
                padding: 12px 16px;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                z-index: 10000;
                animation: slideInRight 0.3s ease;
            `;
            
            document.body.appendChild(errorDiv);
            
            setTimeout(() => {
                errorDiv.style.animation = 'slideOutRight 0.3s ease';
                setTimeout(() => {
                    if (errorDiv.parentNode) {
                        errorDiv.parentNode.removeChild(errorDiv);
                    }
                }, 300);
            }, duration);
        }

        function addCardHoverEffects() {
            const botCards = document.querySelectorAll('.bot-card');
            botCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-4px)';
                    this.style.boxShadow = '0 12px 40px rgba(74, 222, 128, 0.15)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = 'none';
                });
            });
        }

        // Global API for external use
        window.TradingBotDashboard = {
            openModal: openBotModal,
            closeModal: closeBotModal,
            getBotConfig: function(botType) {
                return botConfigurations[botType] || null;
            },
            getAllConfigs: function() {
                return botConfigurations;
            },
            showSuccess: showSuccessMessage,
            showError: showError,
            redirectToBot: redirectToBotPage
        };

        console.log('Trading Bot Dashboard script loaded successfully');
    </script>
    </body>
@endsection