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
        .reset-container {
            background: #fff;
            padding: 3rem 2.5rem;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            transition: transform 0.3s ease;
        }

        .reset-container:hover {
            transform: translateY(-5px);
        }

        /* === HEADER === */
        .reset-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .reset-header h2 {
            color: #2e7d32;
            font-size: 2rem;
            font-weight: 600;
        }

        .reset-header p {
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

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            color: #2e7d32;
            transition: 0.3s;
        }

        .toggle-password:hover {
            color: #1b5e20;
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

        /* === RESPONSIVE === */
        @media (max-width: 480px) {
            .reset-container {
                padding: 2rem 1.5rem;
            }

            .reset-header h2 {
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

<div class="reset-container">
        <div class="reset-header">
            <h2>Reset Password 🔑</h2>
            <p>Enter your new secure password</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="status-message status-success">
                {{ session('status') }}
                <script>
                    setTimeout(function() {
                        window.location.href = '{{ route("login") }}';
                    }, 2000);
                </script>
            </div>
        @endif

        <form wire:submit="resetPassword">
            <div>
                <label for="email">Email Address</label>
                <input 
                    id="email" 
                    type="email" 
                    wire:model="email"
                    placeholder="your@email.com" 
                    required
                    autocomplete="email"
                >
                @error('email')
                    <div class="status-message status-error mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div>
                <label for="password">New Password</label>
                <div class="input-group">
                    <input 
                        id="password" 
                        type="password" 
                        wire:model="password"
                        placeholder="••••••••" 
                        required
                        autocomplete="new-password"
                    >
                    <button type="button" class="toggle-password" onclick="togglePassword('password', this)">👁️</button>
                </div>
                @error('password')
                    <div class="status-message status-error mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div>
                <label for="password_confirmation">Confirm Password</label>
                <div class="input-group">
                    <input 
                        id="password_confirmation" 
                        type="password" 
                        wire:model="password_confirmation"
                        placeholder="••••••••" 
                        required
                        autocomplete="new-password"
                    >
                    <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation', this)">👁️</button>
                </div>
                @error('password_confirmation')
                    <div class="status-message status-error mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit">Reset Password</button>
        </form>
    </div>

<script>
    function togglePassword(id, btn) {
        const input = document.getElementById(id);
        const isPassword = input.type === "password";
        input.type = isPassword ? "text" : "password";
        btn.textContent = isPassword ? "🙈" : "👁️";
    }
</script>
