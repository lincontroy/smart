@extends('layouts.app')
@section('content')

<main class="main-content">
    <h1 class="page-title">Dashboard</h1>

    <!-- Portfolio Section -->
    <section class="portfolio-section">
        <div class="portfolio-header">Real Portfolio</div>
        <div class="portfolio-balance" id="portfolio-balance">
            ETB {{ number_format(auth()->user()->wallet_balance, 2) }}
        </div>
        <div class="portfolio-change" id="portfolio-change">↗ 0.00%</div>
        <div class="portfolio-actions">
            <button class="btn-deposit" id="deposit-btn">Deposit</button>
            <button class="btn-withdraw" id="withdraw-btn">Withdraw</button>
        </div>
    </section>

    <!-- Deposit Contact Admin Modal -->
    <div id="deposit-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">💰 Deposit Instructions</h2>
                <button class="modal-close" id="deposit-modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="instruction-step">
                    <div class="step-icon">1</div>
                    <div class="step-content">
                        <h3>Contact Admin</h3>
                        <p>To make a deposit, please contact our support team directly.</p>
                    </div>
                </div>
                
                <div class="instruction-step">
                    <div class="step-icon">2</div>
                    <div class="step-content">
                        <h3>Available Contact Methods</h3>
                        <div class="contact-methods">
                            <div class="contact-method">
                                <span class="method-icon">✉️</span>
                                <span class="method-text">Email: support@ethiotrade.com</span>
                            </div>
                            <div class="contact-method">
                                <span class="method-icon">📱</span>
                                <span class="method-text">Telegram: @ethiotrade_support</span>
                            </div>
                            <div class="contact-method">
                                <span class="method-icon">💬</span>
                                <span class="method-text">WhatsApp: +251 9XX XXX XXX</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="instruction-step">
                    <div class="step-icon">3</div>
                    <div class="step-content">
                        <h3>Information to Provide</h3>
                        <ul class="info-list">
                            <li>Your Account ID: <strong>{{ auth()->user()->id }}</strong></li>
                            <li>Your Username: <strong>{{ auth()->user()->name }}</strong></li>
                            <li>Deposit Amount (ETB)</li>
                            <li>Preferred Payment Method</li>
                        </ul>
                    </div>
                </div>
                
                <div class="instruction-step">
                    <div class="step-icon">4</div>
                    <div class="step-content">
                        <h3>Deposit Processing</h3>
                        <p>Once you contact support, they will guide you through the deposit process. Deposits are typically processed within 1-2 hours during business hours.</p>
                    </div>
                </div>
                
                <div class="quick-actions">
                    <button class="btn-copy" id="copy-email">
                        <span class="btn-icon">📋</span> Copy Email
                    </button>
                    <button class="btn-copy" id="copy-telegram">
                        <span class="btn-icon">📋</span> Copy Telegram
                    </button>
                    <button class="btn-copy" id="copy-user-info">
                        <span class="btn-icon">👤</span> Copy My Info
                    </button>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-confirm" id="deposit-confirm-understand">I Understand</button>
            </div>
        </div>
    </div>

    <!-- Withdraw Contact Admin Modal (Asks for Bank Details) -->
    <div id="withdraw-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #dc2626, #b91c1c);">
                <h2 class="modal-title">💳 Withdraw Funds</h2>
                <button class="modal-close" id="withdraw-modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="instruction-step">
                    <div class="step-icon" style="background: #dc2626;">1</div>
                    <div class="step-content">
                        <h3>Contact Admin for Withdrawal</h3>
                        <p>To withdraw funds, you need to provide your bank details to our support team for processing.</p>
                    </div>
                </div>
                
                <div class="instruction-step">
                    <div class="step-icon" style="background: #dc2626;">2</div>
                    <div class="step-content">
                        <h3>Available Contact Methods</h3>
                        <div class="contact-methods">
                            <div class="contact-method">
                                <span class="method-icon">✉️</span>
                                <span class="method-text">Email: support@ethiotrade.com</span>
                            </div>
                            <div class="contact-method">
                                <span class="method-icon">📱</span>
                                <span class="method-text">Telegram: @ethiotrade_support</span>
                            </div>
                            <div class="contact-method">
                                <span class="method-icon">💬</span>
                                <span class="method-text">WhatsApp: +251 9XX XXX XXX</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="instruction-step">
                    <div class="step-icon" style="background: #dc2626;">3</div>
                    <div class="step-content">
                        <h3>Required Bank Information</h3>
                        <p class="info-note">📋 Please provide these details to admin:</p>
                        <div class="bank-details-form">
                            <div class="form-group">
                                <label>Bank Name:</label>
                                <input type="text" id="bank-name" placeholder="e.g., Commercial Bank of Ethiopia" class="form-input">
                            </div>
                            <div class="form-group">
                                <label>Account Holder Name:</label>
                                <input type="text" id="account-holder" placeholder="Your full name as on bank account" class="form-input" value="{{ auth()->user()->name }}">
                            </div>
                            <div class="form-group">
                                <label>Account Number:</label>
                                <input type="text" id="account-number" placeholder="Your bank account number" class="form-input">
                            </div>
                            <div class="form-group">
                                <label>Withdrawal Amount (ETB):</label>
                                <input type="number" id="withdraw-amount" placeholder="Enter amount" class="form-input" min="100" max="{{ auth()->user()->wallet_balance }}">
                                <div class="amount-info">
                                    Available: ETB {{ number_format(auth()->user()->wallet_balance, 2) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="instruction-step">
                    <div class="step-icon" style="background: #dc2626;">4</div>
                    <div class="step-content">
                        <h3>Withdrawal Processing</h3>
                        <ul class="info-list">
                            <li>Minimum withdrawal: <strong>ETB 100</strong></li>
                            <li>Processing time: <strong>24-48 hours</strong></li>
                            <li>Bank transfer fees: <strong>Covered by platform</strong></li>
                            <li>Verification: <strong>ID may be required for first withdrawal</strong></li>
                        </ul>
                    </div>
                </div>
                
                <div class="quick-actions">
                    <button class="btn-copy" id="copy-withdraw-email">
                        <span class="btn-icon">📋</span> Copy Email
                    </button>
                    <button class="btn-copy" id="copy-bank-template">
                        <span class="btn-icon">🏦</span> Copy Bank Template
                    </button>
                    <button class="btn-copy" id="copy-withdraw-info">
                        <span class="btn-icon">👤</span> Copy My Info
                    </button>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-confirm" id="withdraw-confirm-understand" style="background: linear-gradient(135deg, #dc2626, #b91c1c);">Contact Admin with Details</button>
            </div>
        </div>
    </div>

    <!-- Dashboard Grid -->
    <div class="dashboard-grid">
        <!-- Watchlist Section -->
        <section class="section">
            <div class="section-header">
                <h2 class="section-title">Watchlist</h2>
                <a href="#" class="see-all">See All →</a>
            </div>
            
            <div class="watchlist-item" data-coin="ETH">
                <div class="crypto-info">
                    <div class="crypto-icon eth">ETH</div>
                    <div class="crypto-details">
                        <h4>ETH</h4>
                        <p>Ethereum</p>
                    </div>
                </div>
                <div class="crypto-price">
                    <div class="price" id="eth-price">Loading...</div>
                    <div class="change" id="eth-change">-</div>
                </div>
            </div>

            <div class="watchlist-item" data-coin="BTC">
                <div class="crypto-info">
                    <div class="crypto-icon btc">BTC</div>
                    <div class="crypto-details">
                        <h4>BTC</h4>
                        <p>Bitcoin</p>
                    </div>
                </div>
                <div class="crypto-price">
                    <div class="price" id="btc-price">Loading...</div>
                    <div class="change" id="btc-change">-</div>
                </div>
            </div>

            <div class="watchlist-item" data-coin="USDC">
                <div class="crypto-info">
                    <div class="crypto-icon usdc">USD</div>
                    <div class="crypto-details">
                        <h4>USDC</h4>
                        <p>USDC</p>
                    </div>
                </div>
                <div class="crypto-price">
                    <div class="price" id="usdc-price">Loading...</div>
                    <div class="change" id="usdc-change">-</div>
                </div>
            </div>
            
            <div class="api-status">
                <span id="api-status">Using: CoinGecko</span>
            </div>
            <button class="refresh-btn" id="refresh-watchlist">Refresh Prices</button>
        </section>

        <!-- Your Crypto Section -->
        <section class="section">
            <div class="section-header">
                <h2 class="section-title">Your Crypto</h2>
            </div>
            
            <div class="crypto-grid">
                <div class="crypto-card" data-coin="BTC" data-amount="0.01">
                    <div class="crypto-card-header">
                        <div class="crypto-card-icon btc">BTC</div>
                        <div class="crypto-card-change" id="your-btc-change">Loading...</div>
                    </div>
                    <div class="crypto-card-price" id="your-btc-price">-</div>
                    <div class="crypto-card-details">Amount: 0.01 BTC</div>
                    <div class="crypto-card-value" id="your-btc-value">Value: -</div>
                    <div class="crypto-card-footer">
                        <button class="trade-btn">📈 Trade</button>
                        <div class="last-updated" id="btc-updated">Last updated: <span class="update-time">-</span></div>
                    </div>
                </div>

                <div class="crypto-card" data-coin="ETH" data-amount="0.25">
                    <div class="crypto-card-header">
                        <div class="crypto-card-icon eth">ETH</div>
                        <div class="crypto-card-change" id="your-eth-change">Loading...</div>
                    </div>
                    <div class="crypto-card-price" id="your-eth-price">-</div>
                    <div class="crypto-card-details">Amount: 0.25 ETH</div>
                    <div class="crypto-card-value" id="your-eth-value">Value: -</div>
                    <div class="crypto-card-footer">
                        <button class="trade-btn">📈 Trade</button>
                        <div class="last-updated" id="eth-updated">Last updated: <span class="update-time">-</span></div>
                    </div>
                </div>

                <div class="crypto-card" data-coin="BNB" data-amount="1.5">
                    <div class="crypto-card-header">
                        <div class="crypto-card-icon bnb">BNB</div>
                        <div class="crypto-card-change" id="your-bnb-change">Loading...</div>
                    </div>
                    <div class="crypto-card-price" id="your-bnb-price">-</div>
                    <div class="crypto-card-details">Amount: 1.5 BNB</div>
                    <div class="crypto-card-value" id="your-bnb-value">Value: -</div>
                    <div class="crypto-card-footer">
                        <button class="trade-btn">📈 Trade</button>
                        <div class="last-updated" id="bnb-updated">Last updated: <span class="update-time">-</span></div>
                    </div>
                </div>

                <div class="crypto-card" data-coin="SOL" data-amount="2.5">
                    <div class="crypto-card-header">
                        <div class="crypto-card-icon sol">SOL</div>
                        <div class="crypto-card-change" id="your-sol-change">Loading...</div>
                    </div>
                    <div class="crypto-card-price" id="your-sol-price">-</div>
                    <div class="crypto-card-details">Amount: 2.5 SOL</div>
                    <div class="crypto-card-value" id="your-sol-value">Value: -</div>
                    <div class="crypto-card-footer">
                        <button class="trade-btn">📈 Trade</button>
                        <div class="last-updated" id="sol-updated">Last updated: <span class="update-time">-</span></div>
                    </div>
                </div>
            </div>
            
            <button class="refresh-btn" id="refresh-crypto">Refresh All Prices</button>
        </section>
    </div>
</main>

<style>
    .main-content {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .page-title {
        font-size: 28px;
        margin-bottom: 30px;
        font-weight: 600;
        color: #1f2937;
    }

    /* Portfolio Section */
    .portfolio-section {
        background: linear-gradient(135deg, #1e293b, #334155);
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 30px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        color: white;
    }

    .portfolio-header {
        font-size: 18px;
        color: #94a3b8;
        margin-bottom: 8px;
    }

    .portfolio-balance {
        font-size: 42px;
        font-weight: 700;
        margin-bottom: 12px;
    }

    .portfolio-change {
        font-size: 18px;
        color: #10b981;
        margin-bottom: 20px;
    }

    .portfolio-change.negative {
        color: #ef4444;
    }

    .portfolio-actions {
        display: flex;
        gap: 12px;
    }

    .btn-deposit, .btn-withdraw {
        padding: 12px 24px;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-deposit {
        background-color: #3b82f6;
        color: white;
    }

    .btn-withdraw {
        background-color: #ef4444;
        color: white;
    }

    .btn-deposit:hover {
        background-color: #2563eb;
    }

    .btn-withdraw:hover {
        background-color: #dc2626;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        z-index: 1000;
        align-items: center;
        justify-content: center;
        animation: fadeIn 0.3s ease;
    }

    .modal.active {
        display: flex;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from { 
            opacity: 0;
            transform: translateY(50px);
        }
        to { 
            opacity: 1;
            transform: translateY(0);
        }
    }

    .modal-content {
        background: white;
        border-radius: 20px;
        width: 90%;
        max-width: 550px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        animation: slideUp 0.4s ease;
    }

    .modal-header {
        padding: 24px;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: linear-gradient(135deg, #1e293b, #334155);
        color: white;
        border-radius: 20px 20px 0 0;
    }

    .modal-title {
        font-size: 24px;
        font-weight: 700;
        margin: 0;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 32px;
        color: white;
        cursor: pointer;
        padding: 0;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: background-color 0.2s;
    }

    .modal-close:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }

    .modal-body {
        padding: 24px;
    }

    .instruction-step {
        display: flex;
        gap: 16px;
        margin-bottom: 24px;
        padding: 16px;
        background: #f8fafc;
        border-radius: 12px;
        border-left: 4px solid #3b82f6;
    }

    .step-icon {
        width: 36px;
        height: 36px;
        background: #3b82f6;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 18px;
        flex-shrink: 0;
    }

    .step-content h3 {
        margin: 0 0 8px 0;
        color: #1f2937;
        font-size: 18px;
    }

    .step-content p {
        margin: 0;
        color: #6b7280;
        line-height: 1.6;
    }

    /* Bank Details Form */
    .bank-details-form {
        margin-top: 16px;
        background: white;
        padding: 20px;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #374151;
        font-size: 14px;
    }

    .form-input {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 16px;
        transition: all 0.2s;
        background: #f9fafb;
    }

    .form-input:focus {
        outline: none;
        border-color: #3b82f6;
        background: white;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-input::placeholder {
        color: #9ca3af;
    }

    .amount-info {
        margin-top: 8px;
        font-size: 14px;
        color: #6b7280;
        padding: 8px 12px;
        background: #f0f9ff;
        border-radius: 6px;
        border-left: 3px solid #3b82f6;
    }

    .info-note {
        margin: 0 0 16px 0;
        color: #374151;
        font-weight: 500;
        padding: 12px;
        background: #fef3c7;
        border-radius: 8px;
        border-left: 4px solid #f59e0b;
    }

    .contact-methods {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-top: 12px;
    }

    .contact-method {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        background: white;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        transition: all 0.2s;
    }

    .contact-method:hover {
        border-color: #3b82f6;
        transform: translateX(4px);
    }

    .method-icon {
        font-size: 20px;
    }

    .method-text {
        flex: 1;
        color: #374151;
        font-weight: 500;
    }

    .info-list {
        margin: 12px 0 0 0;
        padding-left: 20px;
    }

    .info-list li {
        margin-bottom: 8px;
        color: #6b7280;
    }

    .info-list strong {
        color: #1f2937;
        background: #f0f9ff;
        padding: 2px 6px;
        border-radius: 4px;
        font-weight: 600;
    }

    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 12px;
        margin-top: 24px;
    }

    .btn-copy {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px;
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        color: #374151;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-copy:hover {
        background: #3b82f6;
        color: white;
        border-color: #3b82f6;
    }

    .btn-copy.warning:hover {
        background: #ef4444;
        border-color: #ef4444;
    }

    .btn-icon {
        font-size: 18px;
    }

    .modal-footer {
        padding: 20px 24px;
        border-top: 1px solid #e5e7eb;
        text-align: center;
        background: #f8fafc;
        border-radius: 0 0 20px 20px;
    }

    .btn-confirm {
        padding: 14px 40px;
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    .btn-confirm:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
    }

    .btn-confirm:active {
        transform: translateY(0);
    }

    /* Copy Success Notification */
    .copy-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        background: #10b981;
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        z-index: 1001;
        animation: slideInRight 0.3s ease;
        display: none;
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(100%);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Dashboard Grid */
    .dashboard-grid {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 24px;
        margin-top: 30px;
    }

    @media (max-width: 968px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
        }
        
        .modal-content {
            width: 95%;
            margin: 10px;
        }
        
        .quick-actions {
            grid-template-columns: 1fr;
        }
        
        .form-input {
            font-size: 14px;
        }
    }

    /* Section Styles */
    .section {
        background-color: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .section-title {
        font-size: 20px;
        font-weight: 600;
        color: #1f2937;
    }

    .see-all {
        color: #3b82f6;
        text-decoration: none;
        font-weight: 500;
    }

    /* Watchlist */
    .watchlist-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 0;
        border-bottom: 1px solid #e5e7eb;
    }

    .watchlist-item:last-child {
        border-bottom: none;
    }

    .crypto-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .crypto-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 14px;
        color: white;
    }

    .btc {
        background-color: #f59e0b;
    }

    .eth {
        background-color: #8b5cf6;
    }

    .usdc {
        background-color: #2775ca;
    }

    .bnb {
        background-color: #f0b90b;
        color: #000;
    }

    .sol {
        background: linear-gradient(135deg, #9945FF, #14F195);
    }

    .crypto-details h4 {
        font-size: 16px;
        font-weight: 600;
        color: #1f2937;
    }

    .crypto-details p {
        font-size: 14px;
        color: #6b7280;
    }

    .crypto-price {
        text-align: right;
    }

    .price {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 4px;
        color: #1f2937;
    }

    .change {
        font-size: 14px;
    }

    .positive {
        color: #10b981;
    }

    .negative {
        color: #ef4444;
    }

    /* Crypto Grid */
    .crypto-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
    }

    .crypto-card {
        background-color: white;
        border-radius: 12px;
        padding: 20px;
        transition: transform 0.2s, box-shadow 0.2s;
        border: 1px solid #e5e7eb;
    }

    .crypto-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }

    .crypto-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }

    .crypto-card-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 14px;
        color: white;
    }

    .crypto-card-change {
        font-size: 14px;
        font-weight: 600;
        padding: 4px 8px;
        border-radius: 6px;
    }

    .crypto-card-price {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 8px;
        color: #1f2937;
    }

    .crypto-card-details {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 4px;
    }

    .crypto-card-value {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 16px;
        color: #1f2937;
    }

    .crypto-card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .trade-btn {
        background-color: #3b82f6;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .trade-btn:hover {
        background-color: #2563eb;
    }

    .last-updated {
        font-size: 12px;
        color: #6b7280;
    }

    .update-time {
        color: #9ca3af;
    }

    .loading {
        opacity: 0.7;
        pointer-events: none;
    }

    .refresh-btn {
        background-color: #374151;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        font-weight: 500;
        cursor: pointer;
        margin-top: 10px;
        transition: background-color 0.2s;
        width: 100%;
    }

    .refresh-btn:hover {
        background-color: #4b5563;
    }

    .api-status {
        font-size: 12px;
        color: #6b7280;
        text-align: center;
        margin: 10px 0;
        font-style: italic;
    }

    .api-fallback {
        background-color: #fef3c7;
        border: 1px solid #f59e0b;
        border-radius: 6px;
        padding: 8px;
        margin: 10px 0;
        font-size: 12px;
        color: #92400e;
        text-align: center;
    }
</style>

<script>
    // Modal functionality
    const depositModal = document.getElementById('deposit-modal');
    const withdrawModal = document.getElementById('withdraw-modal');
    const depositBtn = document.getElementById('deposit-btn');
    const withdrawBtn = document.getElementById('withdraw-btn');
    const depositModalClose = document.getElementById('deposit-modal-close');
    const withdrawModalClose = document.getElementById('withdraw-modal-close');
    const depositConfirmUnderstand = document.getElementById('deposit-confirm-understand');
    const withdrawConfirmUnderstand = document.getElementById('withdraw-confirm-understand');
    
    // Deposit copy buttons
    const copyEmailBtn = document.getElementById('copy-email');
    const copyTelegramBtn = document.getElementById('copy-telegram');
    const copyUserInfoBtn = document.getElementById('copy-user-info');
    
    // Withdraw copy buttons
    const copyWithdrawEmailBtn = document.getElementById('copy-withdraw-email');
    const copyBankTemplateBtn = document.getElementById('copy-bank-template');
    const copyWithdrawInfoBtn = document.getElementById('copy-withdraw-info');
    
    // Bank form fields
    const bankNameInput = document.getElementById('bank-name');
    const accountHolderInput = document.getElementById('account-holder');
    const accountNumberInput = document.getElementById('account-number');
    const withdrawAmountInput = document.getElementById('withdraw-amount');
    
    // Create notification element
    const copyNotification = document.createElement('div');
    copyNotification.className = 'copy-notification';
    copyNotification.textContent = 'Copied to clipboard!';
    document.body.appendChild(copyNotification);
    
    // Show deposit modal
    depositBtn.addEventListener('click', function(e) {
        e.preventDefault();
        depositModal.classList.add('active');
        document.body.style.overflow = 'hidden';
    });
    
    // Show withdraw modal
    withdrawBtn.addEventListener('click', function(e) {
        e.preventDefault();
        withdrawModal.classList.add('active');
        document.body.style.overflow = 'hidden';
        
        // Set max amount for withdrawal input
        const userBalance = {{ auth()->user()->wallet_balance }};
        withdrawAmountInput.max = userBalance;
    });
    
    // Close modal functions
    function closeDepositModal() {
        depositModal.classList.remove('active');
        document.body.style.overflow = 'auto';
    }
    
    function closeWithdrawModal() {
        withdrawModal.classList.remove('active');
        document.body.style.overflow = 'auto';
    }
    
    // Close modals
    depositModalClose.addEventListener('click', closeDepositModal);
    withdrawModalClose.addEventListener('click', closeWithdrawModal);
    depositConfirmUnderstand.addEventListener('click', closeDepositModal);
    withdrawConfirmUnderstand.addEventListener('click', closeWithdrawModal);
    
    // Close modal when clicking outside
    depositModal.addEventListener('click', function(e) {
        if (e.target === depositModal) {
            closeDepositModal();
        }
    });
    
    withdrawModal.addEventListener('click', function(e) {
        if (e.target === withdrawModal) {
            closeWithdrawModal();
        }
    });
    
    // Close modals with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            if (depositModal.classList.contains('active')) {
                closeDepositModal();
            }
            if (withdrawModal.classList.contains('active')) {
                closeWithdrawModal();
            }
        }
    });
    
    // Copy functionality
    function showCopyNotification() {
        copyNotification.style.display = 'block';
        setTimeout(() => {
            copyNotification.style.display = 'none';
        }, 2000);
    }
    
    // Deposit copy functions
    copyEmailBtn.addEventListener('click', function() {
        navigator.clipboard.writeText('support@ethiotrade.com')
            .then(() => {
                showCopyNotification();
                copyEmailBtn.innerHTML = '<span class="btn-icon">✅</span> Copied!';
                setTimeout(() => {
                    copyEmailBtn.innerHTML = '<span class="btn-icon">📋</span> Copy Email';
                }, 2000);
            });
    });
    
    copyTelegramBtn.addEventListener('click', function() {
        navigator.clipboard.writeText('@ethiotrade_support')
            .then(() => {
                showCopyNotification();
                copyTelegramBtn.innerHTML = '<span class="btn-icon">✅</span> Copied!';
                setTimeout(() => {
                    copyTelegramBtn.innerHTML = '<span class="btn-icon">📋</span> Copy Telegram';
                }, 2000);
            });
    });
    
    copyUserInfoBtn.addEventListener('click', function() {
        const userInfo = `Account ID: {{ auth()->user()->id }}\nUsername: {{ auth()->user()->name }}`;
        navigator.clipboard.writeText(userInfo)
            .then(() => {
                showCopyNotification();
                copyUserInfoBtn.innerHTML = '<span class="btn-icon">✅</span> Copied!';
                setTimeout(() => {
                    copyUserInfoBtn.innerHTML = '<span class="btn-icon">👤</span> Copy My Info';
                }, 2000);
            });
    });
    
    // Withdraw copy functions
    copyWithdrawEmailBtn.addEventListener('click', function() {
        navigator.clipboard.writeText('support@ethiotrade.com')
            .then(() => {
                showCopyNotification();
                copyWithdrawEmailBtn.innerHTML = '<span class="btn-icon">✅</span> Copied!';
                setTimeout(() => {
                    copyWithdrawEmailBtn.innerHTML = '<span class="btn-icon">📋</span> Copy Email';
                }, 2000);
            });
    });
    
    copyBankTemplateBtn.addEventListener('click', function() {
        const bankDetails = `Bank Name: ${bankNameInput.value || '[Bank Name]'}\n` +
                          `Account Holder: ${accountHolderInput.value || '[Full Name]'}\n` +
                          `Account Number: ${accountNumberInput.value || '[Account Number]'}\n` +
                          `Withdrawal Amount: ETB ${withdrawAmountInput.value || '[Amount]'}\n\n` +
                          `Account ID: {{ auth()->user()->id }}\n` +
                          `Username: {{ auth()->user()->name }}`;
        
        navigator.clipboard.writeText(bankDetails)
            .then(() => {
                showCopyNotification();
                copyBankTemplateBtn.innerHTML = '<span class="btn-icon">✅</span> Copied!';
                setTimeout(() => {
                    copyBankTemplateBtn.innerHTML = '<span class="btn-icon">🏦</span> Copy Bank Template';
                }, 2000);
            });
    });
    
    copyWithdrawInfoBtn.addEventListener('click', function() {
        const userInfo = `Account ID: {{ auth()->user()->id }}\nUsername: {{ auth()->user()->name }}\nAvailable Balance: ETB {{ number_format(auth()->user()->wallet_balance, 2) }}`;
        navigator.clipboard.writeText(userInfo)
            .then(() => {
                showCopyNotification();
                copyWithdrawInfoBtn.innerHTML = '<span class="btn-icon">✅</span> Copied!';
                setTimeout(() => {
                    copyWithdrawInfoBtn.innerHTML = '<span class="btn-icon">👤</span> Copy My Info';
                }, 2000);
            });
    });
    
    // Withdraw button action - validate and prepare message
    withdrawConfirmUnderstand.addEventListener('click', function() {
        const bankName = bankNameInput.value.trim();
        const accountHolder = accountHolderInput.value.trim();
        const accountNumber = accountNumberInput.value.trim();
        const withdrawAmount = withdrawAmountInput.value.trim();
        const userBalance = {{ auth()->user()->wallet_balance }};
        
        // Validate inputs
        if (!bankName) {
            alert('Please enter your bank name');
            bankNameInput.focus();
            return;
        }
        
        if (!accountHolder) {
            alert('Please enter account holder name');
            accountHolderInput.focus();
            return;
        }
        
        if (!accountNumber) {
            alert('Please enter your account number');
            accountNumberInput.focus();
            return;
        }
        
        if (!withdrawAmount || parseFloat(withdrawAmount) < 100) {
            alert('Minimum withdrawal amount is ETB 100');
            withdrawAmountInput.focus();
            return;
        }
        
        if (parseFloat(withdrawAmount) > userBalance) {
            alert(`Insufficient balance. Available: ETB ${userBalance.toFixed(2)}`);
            withdrawAmountInput.focus();
            return;
        }
        
        // Prepare the complete message for user to send
        const completeMessage = `💳 WITHDRAWAL REQUEST\n\n` +
                               `Account Information:\n` +
                               `Account ID: {{ auth()->user()->id }}\n` +
                               `Username: {{ auth()->user()->name }}\n\n` +
                               `Bank Details:\n` +
                               `Bank Name: ${bankName}\n` +
                               `Account Holder: ${accountHolder}\n` +
                               `Account Number: ${accountNumber}\n` +
                               `Withdrawal Amount: ETB ${parseFloat(withdrawAmount).toFixed(2)}\n\n` +
                               `Available Balance: ETB {{ number_format(auth()->user()->wallet_balance, 2) }}\n\n` +
                               `Please process this withdrawal request.`;
        
        // Copy to clipboard and show instructions
        navigator.clipboard.writeText(completeMessage)
            .then(() => {
                alert('✅ Withdrawal request copied to clipboard!\n\n' +
                      'Please paste this message to admin via:\n' +
                      '📧 Email: support@ethiotrade.com\n' +
                      '📱 Telegram: @ethiotrade_support\n\n' +
                      'Admin will contact you for verification.');
                
                // Reset form
                bankNameInput.value = '';
                accountNumberInput.value = '';
                withdrawAmountInput.value = '';
                
                closeWithdrawModal();
            })
            .catch(() => {
                alert('⚠️ Please manually copy the following text and send to admin:\n\n' + completeMessage);
            });
    });
    
    // Multiple API endpoints for better reliability
    const API_ENDPOINTS = [
        {
            name: 'CoinGecko',
            url: 'https://api.coingecko.com/api/v3/simple/price?ids=bitcoin,ethereum,binancecoin,solana,usd-coin&vs_currencies=usd&include_24hr_change=true'
        },
        {
            name: 'Binance',
            url: 'https://api.binance.com/api/v3/ticker/24hr'
        },
        {
            name: 'CoinCap',
            url: 'https://api.coincap.io/v2/assets?ids=bitcoin,ethereum,binance-coin,solana,usd-coin'
        }
    ];

    const COIN_SYMBOLS = {
        'bitcoin': 'BTC',
        'ethereum': 'ETH', 
        'binancecoin': 'BNB',
        'binance-coin': 'BNB',
        'solana': 'SOL',
        'usd-coin': 'USDC'
    };

    const BINANCE_SYMBOLS = {
        'BTC': 'BTCUSDT',
        'ETH': 'ETHUSDT', 
        'BNB': 'BNBUSDT',
        'SOL': 'SOLUSDT',
        'USDC': 'USDCUSDT'
    };

    // Store current prices and API status
    let currentPrices = {};
    let previousPrices = {};
    let currentApi = 'CoinGecko';
    let apiFallbackUsed = false;

    // DOM elements
    const refreshWatchlistBtn = document.getElementById('refresh-watchlist');
    const refreshCryptoBtn = document.getElementById('refresh-crypto');
    const apiStatusElement = document.getElementById('api-status');

    // Format currency
    function formatCurrency(value, decimals = 2) {
        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
            minimumFractionDigits: decimals,
            maximumFractionDigits: decimals
        }).format(value);
    }

    // Format percentage
    function formatPercentage(value) {
        if (value === null || value === undefined) return '-';
        return `${value >= 0 ? '+' : ''}${value.toFixed(2)}%`;
    }

    // Calculate portfolio value and change
    function updatePortfolio() {
        const holdings = {
            'BTC': 0.01,
            'ETH': 0.25,
            'BNB': 1.5,
            'SOL': 2.5
        };
        
        let totalValue = 0;
        let totalChange = 0;
        
        Object.keys(holdings).forEach(coin => {
            if (currentPrices[coin] && currentPrices[coin].price) {
                totalValue += currentPrices[coin].price * holdings[coin];
                
                // Calculate weighted change
                if (previousPrices[coin]) {
                    const change = ((currentPrices[coin].price - previousPrices[coin]) / previousPrices[coin]) * 100;
                    totalChange += change * (currentPrices[coin].price * holdings[coin]);
                }
            }
        });
        
        if (totalValue > 0) {
            const portfolioChangePercent = (totalChange / totalValue).toFixed(2);
            const portfolioChangeElement = document.getElementById('portfolio-change');
            portfolioChangeElement.textContent = `${parseFloat(portfolioChangePercent) >= 0 ? '↗' : '↘'} ${formatPercentage(parseFloat(portfolioChangePercent))}`;
            portfolioChangeElement.className = `portfolio-change ${parseFloat(portfolioChangePercent) >= 0 ? 'positive' : 'negative'}`;
        }
    }

    // Update watchlist prices
    function updateWatchlistPrices() {
        Object.keys(currentPrices).forEach(symbol => {
            const coinData = currentPrices[symbol];
            
            if (document.getElementById(`${symbol.toLowerCase()}-price`)) {
                document.getElementById(`${symbol.toLowerCase()}-price`).textContent = formatCurrency(coinData.price);
                
                const changeElement = document.getElementById(`${symbol.toLowerCase()}-change`);
                if (coinData.change !== null) {
                    changeElement.textContent = formatPercentage(coinData.change);
                    changeElement.className = `change ${coinData.change >= 0 ? 'positive' : 'negative'}`;
                } else {
                    changeElement.textContent = '-';
                    changeElement.className = 'change';
                }
            }
        });
    }

    // Update crypto card prices
    function updateCryptoCards() {
        Object.keys(currentPrices).forEach(symbol => {
            if (symbol !== 'USDC' && document.getElementById(`your-${symbol.toLowerCase()}-price`)) {
                const coinData = currentPrices[symbol];
                const card = document.querySelector(`.crypto-card[data-coin="${symbol}"]`);
                const amount = parseFloat(card.getAttribute('data-amount'));
                const value = coinData.price * amount;
                
                document.getElementById(`your-${symbol.toLowerCase()}-price`).textContent = formatCurrency(coinData.price);
                
                const changeElement = document.getElementById(`your-${symbol.toLowerCase()}-change`);
                if (coinData.change !== null) {
                    changeElement.textContent = formatPercentage(coinData.change);
                    changeElement.className = `crypto-card-change ${coinData.change >= 0 ? 'positive' : 'negative'}`;
                } else {
                    changeElement.textContent = '-';
                    changeElement.className = 'crypto-card-change';
                }
                
                document.getElementById(`your-${symbol.toLowerCase()}-value`).textContent = `Value: ${formatCurrency(value)}`;
                
                // Update timestamp
                const now = new Date();
                document.querySelectorAll(`#${symbol.toLowerCase()}-updated .update-time`).forEach(el => {
                    el.textContent = now.toLocaleTimeString();
                });
            }
        });
        
        // Update USDC separately (stablecoin)
        if (document.getElementById('usdc-price')) {
            document.getElementById('usdc-price').textContent = formatCurrency(1);
            document.getElementById('usdc-change').textContent = formatPercentage(0);
            document.getElementById('usdc-change').className = 'change positive';
        }
    }

    // Parse CoinGecko API response
    function parseCoinGeckoData(data) {
        const prices = {};
        
        Object.keys(data).forEach(coinId => {
            const symbol = COIN_SYMBOLS[coinId];
            if (symbol) {
                prices[symbol] = {
                    price: data[coinId].usd,
                    change: data[coinId].usd_24h_change
                };
            }
        });
        
        return prices;
    }

    // Parse Binance API response
    function parseBinanceData(data) {
        const prices = {};
        
        data.forEach(ticker => {
            Object.keys(BINANCE_SYMBOLS).forEach(symbol => {
                if (ticker.symbol === BINANCE_SYMBOLS[symbol]) {
                    prices[symbol] = {
                        price: parseFloat(ticker.lastPrice),
                        change: parseFloat(ticker.priceChangePercent)
                    };
                }
            });
        });
        
        return prices;
    }

    // Parse CoinCap API response
    function parseCoinCapData(data) {
        const prices = {};
        
        data.data.forEach(asset => {
            const symbol = COIN_SYMBOLS[asset.id];
            if (symbol) {
                prices[symbol] = {
                    price: parseFloat(asset.priceUsd),
                    change: parseFloat(asset.changePercent24Hr)
                };
            }
        });
        
        return prices;
    }

    // Fallback to realistic mock data if APIs fail
    function getMockPrices() {
        const mockPrices = {
            'BTC': { price: 67500 + (Math.random() * 2000 - 1000), change: -0.5 + (Math.random() * 2 - 1) },
            'ETH': { price: 3500 + (Math.random() * 200 - 100), change: -0.3 + (Math.random() * 2 - 1) },
            'BNB': { price: 580 + (Math.random() * 20 - 10), change: 0.2 + (Math.random() * 2 - 1) },
            'SOL': { price: 170 + (Math.random() * 10 - 5), change: 1.2 + (Math.random() * 2 - 1) },
            'USDC': { price: 1.00, change: 0 }
        };
        
        return mockPrices;
    }

    // Fetch prices with fallback strategy
    async function fetchPrices() {
        let success = false;
        let apiIndex = 0;
        
        // Show loading state
        document.querySelectorAll('.price, .crypto-card-price').forEach(el => {
            el.classList.add('loading');
        });
        
        // Try each API endpoint until one works
        while (!success && apiIndex < API_ENDPOINTS.length) {
            const api = API_ENDPOINTS[apiIndex];
            
            try {
                apiStatusElement.textContent = `Fetching: ${api.name}...`;
                
                const response = await fetch(api.url);
                
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}`);
                }
                
                const data = await response.json();
                let newPrices = {};
                
                // Parse data based on API
                if (api.name === 'CoinGecko') {
                    newPrices = parseCoinGeckoData(data);
                } else if (api.name === 'Binance') {
                    newPrices = parseBinanceData(data);
                } else if (api.name === 'CoinCap') {
                    newPrices = parseCoinCapData(data);
                }
                
                // Store previous prices for change calculation
                Object.keys(newPrices).forEach(symbol => {
                    previousPrices[symbol] = currentPrices[symbol] ? currentPrices[symbol].price : newPrices[symbol].price;
                });
                
                currentPrices = newPrices;
                currentApi = api.name;
                success = true;
                apiFallbackUsed = false;
                
                apiStatusElement.textContent = `Using: ${api.name}`;
                
            } catch (error) {
                console.warn(`${api.name} failed:`, error);
                apiIndex++;
            }
        }
        
        // If all APIs fail, use mock data
        if (!success) {
            currentPrices = getMockPrices();
            currentApi = 'Mock Data';
            apiFallbackUsed = true;
            apiStatusElement.textContent = 'Using: Mock Data (APIs unavailable)';
            
            // Show fallback warning
            if (!document.querySelector('.api-fallback')) {
                const fallbackWarning = document.createElement('div');
                fallbackWarning.className = 'api-fallback';
                fallbackWarning.textContent = 'Using simulated data. Real-time prices temporarily unavailable.';
                document.querySelector('.section').insertBefore(fallbackWarning, refreshWatchlistBtn);
            }
        }
        
        // Update UI with new prices
        updateWatchlistPrices();
        updateCryptoCards();
        updatePortfolio();
        
        // Remove loading state
        document.querySelectorAll('.price, .crypto-card-price').forEach(el => {
            el.classList.remove('loading');
        });
    }

    // Event listeners
    document.addEventListener('DOMContentLoaded', function() {
        // Initial price fetch
        fetchPrices();
        
        // Set up refresh buttons
        refreshWatchlistBtn.addEventListener('click', fetchPrices);
        refreshCryptoBtn.addEventListener('click', fetchPrices);
        
        // Auto-refresh every 20 seconds
        setInterval(fetchPrices, 20000);
    });
</script>

@endsection