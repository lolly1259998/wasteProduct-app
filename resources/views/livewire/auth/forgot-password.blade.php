<style>
        /* === GLOBAL RESET === */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #e8f5e9, #f1f8e9);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* === CARD === */
        .forgot-container {
            background: #fff;
            padding: 3rem 2.5rem;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            transition: transform 0.3s ease;
        }

        .forgot-container:hover {
            transform: translateY(-5px);
        }

        /* === HEADER === */
        .forgot-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .forgot-header h2 {
            color: #2e7d32;
            font-size: 2rem;
            font-weight: 600;
        }

        .forgot-header p {
            color: #666;
            font-size: 0.9rem;
        }

        /* === FORM === */
        form {
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
        }

        label {
            font-weight: 500;
            color: #2e7d32;
        }

        .input-group {
            position: relative;
        }

        input {
            width: 100%;
            padding: 0.9rem 1rem;
            border: 2px solid #c8e6c9;
            border-radius: 10px;
            transition: 0.3s;
            font-size: 0.95rem;
        }

        input:focus {
            border-color: #43a047;
            outline: none;
            box-shadow: 0 0 0 3px rgba(67, 160, 71, 0.2);
        }

        button[type="submit"] {
            padding: 0.9rem;
            border: none;
            border-radius: 10px;
            background-color: #43a047;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #2e7d32;
            transform: scale(1.03);
        }

        /* === LINK === */
        .back-link {
            text-align: center;
            margin-top: 1rem;
        }

        .back-link a {
            text-decoration: none;
            color: #2e7d32;
            font-weight: 500;
            transition: 0.3s;
        }

        .back-link a:hover {
            text-decoration: underline;
            color: #1b5e20;
        }

        /* === RESPONSIVE === */
        @media (max-width: 480px) {
            .forgot-container {
                padding: 2rem 1.5rem;
            }

            .forgot-header h2 {
                font-size: 1.6rem;
            }
        }

        /* Status messages */
        .status-message {
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            text-align: center;
            font-size: 0.95rem;
            font-weight: 500;
            animation: slideInDown 0.5s ease-out;
        }

        .status-success {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            color: #155724;
            border: 2px solid #28a745;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.2);
        }

        .status-error {
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            color: #721c24;
            border: 2px solid #dc3545;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.2);
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

<div class="forgot-container">
        <div class="forgot-header">
            <h2>Forgot Password 🔐</h2>
            <p>Enter your email to receive a password reset link</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="status-message status-success">
                {{ session('status') }}
            </div>
        @endif

        <form wire:submit="sendPasswordResetLink">
            <div>
                <label for="email">Email Address</label>
                <input 
                    id="email" 
                    type="email" 
                    wire:model="email"
                    placeholder="your@email.com" 
                    required
                    autofocus
                >
                @error('email')
                    <div class="status-message status-error mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit">Send Reset Link</button>
        </form>

        <div class="back-link">
            <p>Remember your password? <a href="{{ route('login') }}" wire:navigate>Sign In</a></p>
        </div>
    </div>
