<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Smart Market - Your trusted platform for cryptocurrency trading</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 500px;
            text-align: center;
        }

        .header {
            margin-bottom: 40px;
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 12px;
            letter-spacing: -0.5px;
        }

        .header p {
            color: #a0a0a0;
            font-size: 1rem;
            font-weight: 400;
        }

        .auth-buttons {
            display: flex;
            margin-bottom: 30px;
            border-radius: 8px;
            overflow: hidden;
            background: #2a2a3e;
        }

        .auth-button {
            flex: 1;
            padding: 14px 20px;
            border: none;
            background: #2a2a3e;
            color: #888;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .auth-button.active {
            background: #4ade80;
            color: white;
        }

        .auth-button:hover:not(.active) {
            background: #3a3a4e;
            color: #ccc;
        }

        .form-container {
            background: rgba(42, 42, 62, 0.8);
            border-radius: 12px;
            padding: 30px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .form-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 8px;
            text-align: left;
        }

        .form-subtitle {
            color: #a0a0a0;
            font-size: 0.9rem;
            margin-bottom: 25px;
            text-align: left;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #e0e0e0;
        }

        .form-input {
            width: 100%;
            padding: 14px 16px;
            background: #1a1a2e;
            border: 1px solid #333;
            border-radius: 8px;
            color: white;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-input::placeholder {
            color: #666;
        }

        .form-input:focus {
            outline: none;
            border-color: #4ade80;
            box-shadow: 0 0 0 3px rgba(74, 222, 128, 0.1);
        }

        .phone-input {
            display: flex;
            gap: 12px;
        }

        .country-code {
            background: #1a1a2e;
            border: 1px solid #333;
            border-radius: 8px;
            color: white;
            padding: 14px 16px;
            font-size: 1rem;
            min-width: 80px;
        }

        .phone-number {
            flex: 1;
        }

        .country-select {
            position: relative;
        }

        .country-input {
            padding-left: 40px;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>');
            background-repeat: no-repeat;
            background-position: 12px center;
        }

        .dropdown-arrow {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #666;
        }

        .password-input {
            position: relative;
        }

        .password-dots {
            color: #666;
            letter-spacing: 4px;
            font-size: 1.2rem;
        }

        .submit-btn {
            width: 100%;
            padding: 14px 20px;
            background: #4ade80;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .form-errors {
            background-color: #ffe6e6;
            border: 1px solid #ff6b6b;
            color: #ff6b6b;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .form-errors ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .form-errors li {
            margin-bottom: 10px;
        }

        .submit-btn:hover {
            background: #22c55e;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(74, 222, 128, 0.3);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .signup-only {
            transition: all 0.3s ease;
        }

        /* Responsive design */
        @media (max-width: 600px) {
            .header h1 {
                font-size: 2rem;
            }
            
            .form-container {
                padding: 25px 20px;
            }
        }

        /* Flag icon for Kenya */
        .country-flag {
            display: inline-block;
            width: 20px;
            height: 14px;
            background: linear-gradient(to bottom, #000 0%, #000 33%, #ff0000 33%, #ff0000 66%, #00ff00 66%, #00ff00 100%);
            margin-right: 8px;
            border-radius: 2px;
        }

        /* Animation for smooth transitions */
        .signup-only {
            opacity: 1;
            max-height: 200px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .signup-only.hidden {
            opacity: 0;
            max-height: 0;
            margin-bottom: 0;
            padding-top: 0;
            padding-bottom: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to Digital Smart Market</h1>
            <p>Your trusted platform for cryptocurrency trading</p>
        </div>

        <div class="auth-buttons">
            <button class="auth-button active" id="loginBtn">Login</button>
            <button class="auth-button" id="signupBtn">Sign Up</button>
        </div>

        @if ($errors->any())
            <div class="form-errors" id="form-errors">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-container">
            <h2 class="form-title" id="formTitle">Welcome back</h2>
            <p class="form-subtitle" id="formSubtitle">Enter your credentials to access your account</p>

            <form method="POST" action="{{ route('login') }}" id="authForm">
                @csrf
                <div class="form-group signup-only hidden" id="nameGroup">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-input" placeholder="John Doe" />
                </div>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" required class="form-input" placeholder="your@email.com" />
                </div>

              
                
      
                

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="password-input">
                        <input type="password" name="password" required class="form-input" placeholder="Enter your password" />
                    </div>
                </div>

                <div class="form-group signup-only hidden" id="confirmPasswordGroup">
                    <label class="form-label">Confirm Password</label>
                    <div class="password-input">
                        <input type="password" name="password_confirmation" class="form-input" placeholder="Confirm your password" />
                    </div>
                </div>

                <button type="submit" class="submit-btn" id="submitBtn">
                    <span class="login-text">Login</span>
                    <span class="signup-text" style="display: none;">Create Account</span>
                </button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginBtn = document.getElementById('loginBtn');
            const signupBtn = document.getElementById('signupBtn');
            const formTitle = document.getElementById('formTitle');
            const formSubtitle = document.getElementById('formSubtitle');
            const authForm = document.getElementById('authForm');
            const submitBtn = document.getElementById('submitBtn');
            const signupOnlyFields = document.querySelectorAll('.signup-only');
            const signupText = document.querySelector('.signup-text');
            const loginText = document.querySelector('.login-text');

            // Check URL parameters to determine which tab to show
            const urlParams = new URLSearchParams(window.location.search);
            const tab = urlParams.get('tab');
            
            // If coming from logout or tab=login, show login tab
            if (tab === 'login' || window.location.search.includes('logout')) {
                showLoginForm();
            } else {
                // Default to login form (changed from signup)
                showLoginForm();
            }

            function showLoginForm() {
                // Update button states
                loginBtn.classList.add('active');
                signupBtn.classList.remove('active');
                
                // Hide signup fields
                signupOnlyFields.forEach(field => {
                    field.classList.add('hidden');
                    const inputs = field.querySelectorAll('input, select');
                    inputs.forEach(input => {
                        input.removeAttribute('required');
                        input.disabled = true;
                    });
                });
                
                // Update form content
                formTitle.textContent = 'Welcome back';
                formSubtitle.textContent = 'Enter your credentials to access your account';
                authForm.action = "{{ route('login') }}";
                
                // Update button text
                loginText.style.display = 'block';
                signupText.style.display = 'none';
            }

            function showSignupForm() {
                // Update button states
                signupBtn.classList.add('active');
                loginBtn.classList.remove('active');
                
                // Show signup fields
                signupOnlyFields.forEach(field => {
                    field.classList.remove('hidden');
                    const inputs = field.querySelectorAll('input, select');
                    inputs.forEach(input => {
                        input.disabled = false;
                        // Add required attribute back for signup fields
                        if (input.name === 'name' || input.name === 'country' || input.name === 'password_confirmation') {
                            input.setAttribute('required', 'required');
                        }
                    });
                });
                
                // Update form content
                formTitle.textContent = 'Create an account';
                formSubtitle.textContent = 'Enter your details to create a new account';
                authForm.action = "{{ route('register') }}";
                
                // Update button text
                signupText.style.display = 'block';
                loginText.style.display = 'none';
            }
            
            loginBtn.addEventListener('click', showLoginForm);
            signupBtn.addEventListener('click', showSignupForm);

            // Add focus effects
            const inputs = document.querySelectorAll('.form-input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'translateY(-2px)';
                    this.parentElement.style.transition = 'transform 0.2s ease';
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'translateY(0)';
                });
            });

            // Handle form errors - if there are validation errors, show appropriate form
            const formErrors = document.getElementById('form-errors');
            if (formErrors) {
                // Check if errors are related to signup fields
                const errorText = formErrors.textContent.toLowerCase();
                if (errorText.includes('name') || errorText.includes('phone') || errorText.includes('country') || errorText.includes('confirmation')) {
                    showSignupForm();
                } else {
                    showLoginForm();
                }
            }
        });
    </script>
</body>
</html>