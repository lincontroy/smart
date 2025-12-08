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
            padding: 3rem 2rem;
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
        }

        .main-title {
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .main-subtitle {
            color: #9ca3af;
            font-size: 1.1rem;
            margin-bottom: 3rem;
        }

        .deposit-form {
            background: #1a2332;
            border-radius: 20px;
            padding: 2.5rem;
            max-width: 600px;
            margin: 0 auto;
        }

        .method-tabs {
            display: flex;
            background: #0f1419;
            border-radius: 12px;
            padding: 0.5rem;
            margin-bottom: 2rem;
        }

        .method-tab {
            flex: 1;
            padding: 1rem 1.5rem;
            border: none;
            background: transparent;
            color: #9ca3af;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            font-weight: 500;
            font-size: 1.1rem;
        }

        .method-tab.active {
            background: #4f46e5;
            color: white;
        }

        .method-tab:not(.active):hover {
            background: #374151;
            color: white;
        }

        .crypto-options {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .crypto-option {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 1.5rem 1rem;
            background: #0f1419;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s;
            border: 2px solid transparent;
        }

        .crypto-option:hover {
            background: #374151;
        }

        .crypto-option.selected {
            border-color: #4f46e5;
            background: #1e1b4b;
        }

        .crypto-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .crypto-icon.bitcoin {
            background: #f7931a;
            color: white;
        }

        .crypto-icon.usdt {
            background: #26a17b;
            color: white;
        }

        .crypto-icon.ethereum {
            background: #627eea;
            color: white;
        }

        .crypto-name {
            font-size: 0.9rem;
            font-weight: 500;
        }

        .amount-section {
            margin-bottom: 2rem;
        }

        .amount-label {
            text-align: left;
            font-size: 0.9rem;
            color: #9ca3af;
            margin-bottom: 0.5rem;
        }

        .amount-input {
            width: 100%;
            padding: 1rem 1.5rem;
            background: #374151;
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 1.1rem;
            outline: none;
        }

        .amount-input:focus {
            background: #4b5563;
        }

        .wallet-section {
            background: linear-gradient(135deg, #1e3a8a, #3730a3);
            border-radius: 16px;
            padding: 2rem;
            margin-top: 2rem;
            text-align: center;
            display: none;
        }

        .wallet-section.show {
            display: block;
        }

        .wallet-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .wallet-address {
            background: #0f1419;
            border-radius: 8px;
            padding: 1rem;
            font-family: monospace;
            font-size: 0.9rem;
            word-break: break-all;
            margin-bottom: 1rem;
        }

        .copy-btn {
            background: #4ade80;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            color: #0a0f1c;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .copy-btn:hover {
            background: #22c55e;
        }

        .card-details {
            margin-bottom: 2rem;
        }

        .card-label {
            text-align: left;
            font-size: 0.9rem;
            color: #9ca3af;
            margin-bottom: 0.5rem;
        }

        .card-input {
            width: 100%;
            padding: 1rem 1.5rem;
            background: #374151;
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 1.1rem;
            outline: none;
            margin-bottom: 1rem;
        }

        .card-input:focus {
            background: #4b5563;
        }

        .mpesa-details {
            margin-bottom: 2rem;
        }

        .mpesa-label {
            text-align: left;
            font-size: 0.9rem;
            color: #9ca3af;
            margin-bottom: 0.5rem;
        }

        .mpesa-input {
            width: 100%;
            padding: 1rem 1.5rem;
            background: #374151;
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 1.1rem;
            outline: none;
        }

        .mpesa-input:focus {
            background: #4b5563;
        }

        .continue-btn {
            width: 100%;
            height: 50px;
            border-radius: 12px;
            background: #4ade80;
            border: none;
            color: #0a0f1c;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.2s;
            font-weight: 600;
        }

        .continue-btn:hover {
            background: #22c55e;
            transform: translateY(-1px);
        }

        .continue-btn:disabled {
            background: #6b7280;
            cursor: not-allowed;
            transform: none;
        }

        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #ffffff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .success-message, .error-message {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            text-align: center;
        }

        .success-message {
            background: #10b981;
            color: white;
        }

        .error-message {
            background: #ef4444;
            color: white;
        }

        @media (max-width: 768px) {
            .crypto-options {
                grid-template-columns: repeat(2, 1fr);
            }

            .method-tab {
                padding: 0.8rem 1rem;
                font-size: 1rem;
            }

            .deposit-form {
                padding: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .crypto-options {
                grid-template-columns: repeat(1, 1fr);
            }

            .method-tab {
                padding: 0.6rem 0.8rem;
                font-size: 0.9rem;
            }
        }
    </style>

<body>
    <main class="main-content">
        <h1 class="main-title">Fund Your Account</h1>
        <p class="main-subtitle">Choose your preferred deposit method below</p>
        
        <div class="method-tabs">
            <button class="method-tab active" id="crypto-tab">💰 Crypto</button>
            <button class="method-tab" id="card-tab">💳 Card</button>
           
        </div>
        
        <script>
        // Alternative JavaScript-based approach if you prefer client-side detection
        document.addEventListener('DOMContentLoaded', function() {
            // Get user's country from backend (assuming it's available in a data attribute or global variable)
            const userCountry = '{{ Auth::check() ? Auth::user()->country : "" }}';
            
            // Or detect by timezone/locale (less reliable)
            // const userTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
            // const isKenya = userTimezone === 'Africa/Nairobi';
            
            const mpesaTab = document.getElementById('mpesa-tab');
            
            if (userCountry === 'Kenya' || userCountry === 'KE') {
                mpesaTab.style.display = 'block';
            } else {
                mpesaTab.style.display = 'none';
            }
        });
        </script>
            
            <!-- Crypto deposit form -->
            <div id="crypto-deposit-form">
                <div class="crypto-options">
                    <div class="crypto-option selected" onclick="selectCrypto(this, 'bitcoin')">
                        <div class="crypto-icon bitcoin">₿</div>
                        <div class="crypto-name">Bitcoin</div>
                    </div>
                    <div class="crypto-option" onclick="selectCrypto(this, 'usdt')">
                        <div class="crypto-icon usdt">₮</div>
                        <div class="crypto-name">USDT</div>
                    </div>
                    <div class="crypto-option" onclick="selectCrypto(this, 'ethereum')">
                        <div class="crypto-icon ethereum">Ξ</div>
                        <div class="crypto-name">Ethereum</div>
                    </div>
                </div>
                
                <div class="amount-section">
                    <div class="amount-label">Amount (USD)</div>
                    <input type="number" class="amount-input" id="crypto-amount" placeholder="49" value="49" min="49">
                </div>
                
                <div class="wallet-section" id="wallet-section">
                    <div class="wallet-title" id="wallet-title">Bitcoin Wallet Address</div>
                    <div class="wallet-address" id="wallet-address">bc1qx3u7vunpfu7qd8kpqljccz4lava2t4fzg0awc7</div>
                    <button class="copy-btn" onclick="copyWalletAddress()">Copy Address</button>
                    <p style="margin-top: 1rem; font-size: 0.9rem; color: #9ca3af;">
                        Send the exact amount to this address and your account will be credited automatically.
                    </p>
                </div>
            </div>
            
            <!-- Card deposit form -->
            <div id="card-deposit-form" style="display: none;">
                <div id="card-messages"></div>
                <div class="amount-section">
                    <div class="amount-label">Amount (USD)</div>
                    <input type="number" class="amount-input" id="card-amount" placeholder="49" value="49" min="49">
                </div>
                <div class="card-details">
                    <div class="card-label">Card Number</div>
                    <input type="text" class="card-input" id="card-number" placeholder="1234 5678 9012 3456" maxlength="19">
                    <div class="card-label">Expiry Date</div>
                    <input type="text" class="card-input" id="card-expiry" placeholder="MM/YY" maxlength="5">
                    <div class="card-label">CVV</div>
                    <input type="text" class="card-input" id="card-cvv" placeholder="123" maxlength="4">
                    <div class="card-label">Cardholder Name</div>
                    <input type="text" class="card-input" id="card-name" placeholder="John Doe">
                </div>
                <button class="continue-btn" id="card-pay-btn" onclick="processCardPayment()">Pay Now</button>
            </div>
            
            <!-- Mpesa deposit form -->
            <div id="mpesa-deposit-form" style="display: none;">
                <div id="mpesa-messages"></div>
                <div class="amount-section">
                    <div class="amount-label">Amount (KES)</div>
                    <input type="number" class="amount-input" id="mpesa-amount" placeholder="6332" value="6332" min="6332">
                </div>
                <div class="mpesa-details">
                    <div class="mpesa-label">Phone Number</div>
                    <input type="text" class="mpesa-input" id="mpesa-phone" placeholder="254712345678" maxlength="12">
                </div>
                <button class="continue-btn" id="mpesa-pay-btn" onclick="processMpesaPayment()">Pay Now</button>
            </div>
        </div>
    </main>

    <script>
        // Wallet addresses for different cryptocurrencies
        const walletAddresses = {
            bitcoin: '14tkfog2PS64skmVoWTUCwh1DbH1EzkVVb',
            usdt: 'TNpXAikgZKF9vAgfSpn7BsaAJDFvfBR7zA'
        };

        function selectCrypto(element, cryptoType) {
            // Remove selected class from all options
            document.querySelectorAll('.crypto-option').forEach(option => {
                option.classList.remove('selected');
            });
            
            // Add selected class to clicked option
            element.classList.add('selected');
            
            // Show/hide wallet section based on crypto type
            const walletSection = document.getElementById('wallet-section');
            const walletTitle = document.getElementById('wallet-title');
            const walletAddress = document.getElementById('wallet-address');
            
            if (cryptoType === 'bitcoin' || cryptoType === 'usdt') {
                walletSection.classList.add('show');
                walletTitle.textContent = `${cryptoType === 'bitcoin' ? 'Bitcoin' : 'USDT (TRC20)'} Wallet Address`;
                walletAddress.textContent = walletAddresses[cryptoType];
            } else {
                walletSection.classList.remove('show');
            }
        }

        function copyWalletAddress() {
            const walletAddress = document.getElementById('wallet-address').textContent;
            navigator.clipboard.writeText(walletAddress).then(() => {
                const copyBtn = document.querySelector('.copy-btn');
                const originalText = copyBtn.textContent;
                copyBtn.textContent = 'Copied!';
                copyBtn.style.background = '#22c55e';
                setTimeout(() => {
                    copyBtn.textContent = originalText;
                    copyBtn.style.background = '#4ade80';
                }, 2000);
            });
        }

        // Card number formatting
        document.getElementById('card-number').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s/g, '').replace(/[^0-9]/gi, '');
            let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
            e.target.value = formattedValue;
        });

        // Expiry date formatting
        document.getElementById('card-expiry').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.substring(0,2) + '/' + value.substring(2,4);
            }
            e.target.value = value;
        });

        // CVV validation
        document.getElementById('card-cvv').addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/[^0-9]/g, '');
        });

        // Phone number formatting for M-Pesa
        document.getElementById('mpesa-phone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^0-9]/g, '');
            if (value.startsWith('0')) {
                value = '254' + value.substring(1);
            }
            e.target.value = value;
        });

        function showMessage(containerId, message, type) {
            const container = document.getElementById(containerId);
            container.innerHTML = `<div class="${type}-message">${message}</div>`;
            setTimeout(() => {
                container.innerHTML = '';
            }, 5000);
        }

        async function processCardPayment() {
            const cardNumber = document.getElementById('card-number').value.replace(/\s/g, '');
            const cardExpiry = document.getElementById('card-expiry').value;
            const cardCvv = document.getElementById('card-cvv').value;
            const cardName = document.getElementById('card-name').value;
            const amount = document.getElementById('card-amount').value;
            const payBtn = document.getElementById('card-pay-btn');

            // Validation
            if (!cardNumber || !cardExpiry || !cardCvv || !cardName || !amount) {
                showMessage('card-messages', 'Please fill in all card details', 'error');
                return;
            }

            if (cardNumber.length < 16) {
                showMessage('card-messages', 'Please enter a valid card number', 'error');
                return;
            }

            if (cardExpiry.length !== 5) {
                showMessage('card-messages', 'Please enter a valid expiry date', 'error');
                return;
            }

            if (cardCvv.length < 3) {
                showMessage('card-messages', 'Please enter a valid CVV', 'error');
                return;
            }

            // Show loading state
            payBtn.disabled = true;
            payBtn.innerHTML = '<span class="loading"></span> Processing...';

            try {
                // Simulate API call to save card details and process payment
                const response = await fetch('/api/process-card-payment', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify({
                        card_number: cardNumber,
                        card_expiry: cardExpiry,
                        card_cvv: cardCvv,
                        card_name: cardName,
                        amount: amount,
                        user_id:{{auth()->user()->id}},
                    })
                });

                const result = await response.json();

                if (response.ok) {
                    showMessage('card-messages', 'Payment processed successfully!', 'success');
                    // Reset form
                    document.querySelectorAll('.card-input').forEach(input => input.value = '');
                } else {
                    showMessage('card-messages', result.message || 'Payment failed. Please try again.', 'error');
                }
            } catch (error) {
                console.error('Payment error:', error);
                showMessage('card-messages', 'Network error. Please try again.', 'error');
            } finally {
                payBtn.disabled = false;
                payBtn.innerHTML = 'Pay Now';
            }
        }

        async function processMpesaPayment() {
            const phone = document.getElementById('mpesa-phone').value;
            const amount = document.getElementById('mpesa-amount').value;
            const user_id = {{auth()->user()->id}};
            const payBtn = document.getElementById('mpesa-pay-btn');

            // Validation
            if (!phone || !amount) {
                showMessage('mpesa-messages', 'Please enter phone number and amount', 'error');
                return;
            }

            if (phone.length !== 12 || !phone.startsWith('254')) {
                showMessage('mpesa-messages', 'Please enter a valid phone number (254XXXXXXXXX)', 'error');
                return;
            }

            if (amount < 100) {
                showMessage('mpesa-messages', 'Minimum amount is KES 100', 'error');
                return;
            }

            // Show loading state
            payBtn.disabled = true;
            payBtn.innerHTML = '<span class="loading"></span> Sending STK Push...';

            try {
                // Simulate API call for STK push
                const response = await fetch('/api/mpesa-stk-push', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify({
                        phone: phone,
                        amount: amount,
                        user_id:user_id
                    })
                });

                const result = await response.json();



                if (response.ok) {
                    showMessage('mpesa-messages', 'STK Push sent! Please check your phone and enter your M-Pesa PIN.', 'success');
                    
                    // Poll for payment status
                    pollMpesaStatus(result.checkout_request_id);
                } else {
                    showMessage('mpesa-messages', 'STK Push sent.', 'success');
                }
            } catch (error) {
                console.error('M-Pesa error:', error);
                showMessage('mpesa-messages', 'Network error. Please try again.', 'error');
            } finally {
                payBtn.disabled = false;
                payBtn.innerHTML = 'Pay Now';
            }
        }

        async function pollMpesaStatus(checkoutRequestId) {
            const maxPolls = 30; // Poll for 30 seconds
            let polls = 0;

            const poll = async () => {
                if (polls >= maxPolls) {
                    showMessage('mpesa-messages', 'Payment verification timed out. Please contact support if money was deducted.', 'error');
                    return;
                }

                try {
                    const response = await fetch(`/api/mpesa-status/${checkoutRequestId}`);
                    const result = await response.json();

                    if (result.status === 'completed') {
                        showMessage('mpesa-messages', 'Payment successful! Your account has been credited.', 'success');
                        // Reset form
                        document.getElementById('mpesa-phone').value = '';
                        document.getElementById('mpesa-amount').value = '6332';
                        return;
                    } else if (result.status === 'failed') {
                        showMessage('mpesa-messages', 'Payment failed or was cancelled.', 'error');
                        return;
                    }

                    // Continue polling
                    polls++;
                    setTimeout(poll, 2000);
                } catch (error) {
                    console.error('Status check error:', error);
                    polls++;
                    setTimeout(poll, 2000);
                }
            };

            setTimeout(poll, 2000); // Start polling after 2 seconds
        }

        // Tab switching functionality
        document.querySelectorAll('.method-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.method-tab').forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                
                if (this.id === 'crypto-tab') {
                    document.getElementById('crypto-deposit-form').style.display = 'block';
                    document.getElementById('card-deposit-form').style.display = 'none';
                    document.getElementById('mpesa-deposit-form').style.display = 'none';
                } else if (this.id === 'card-tab') {
                    document.getElementById('crypto-deposit-form').style.display = 'none';
                    document.getElementById('card-deposit-form').style.display = 'block';
                    document.getElementById('mpesa-deposit-form').style.display = 'none';
                } else if (this.id === 'mpesa-tab') {
                    document.getElementById('crypto-deposit-form').style.display = 'none';
                    document.getElementById('card-deposit-form').style.display = 'none';
                    document.getElementById('mpesa-deposit-form').style.display = 'block';
                }
            });
        });

        // Initialize with Bitcoin selected and wallet shown
        selectCrypto(document.querySelector('.crypto-option.selected'), 'bitcoin');
    </script>
@endsection