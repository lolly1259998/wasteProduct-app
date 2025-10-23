<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Waste2Product</title>

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
        .login-container {
            background: #fff;
            padding: 3rem 2.5rem;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            transition: transform 0.3s ease;
        }

        .login-container:hover {
            transform: translateY(-5px);
        }

        /* === HEADER === */
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header h2 {
            color: #2e7d32;
            font-size: 2rem;
            font-weight: 600;
        }

        .login-header p {
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

        /* === LINK === */
        .register-link {
            text-align: center;
            margin-top: 1rem;
        }

        .register-link a {
            text-decoration: none;
            color: #2e7d32;
            font-weight: 500;
            transition: 0.3s;
        }

        .register-link a:hover {
            text-decoration: underline;
            color: #1b5e20;
        }

        /* === GOOGLE BUTTON === */
        .google-login {
            margin-top: 1rem;
            text-align: center;
        }

        .google-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            padding: 0.9rem;
            border: 2px solid #db4437;
            border-radius: 10px;
            background-color: #fff;
            color: #db4437;
            font-weight: 600;
            text-decoration: none;
            transition: 0.3s;
            cursor: pointer;
        }

        .google-btn:hover {
            background-color: #db4437;
            color: white;
            transform: scale(1.03);
        }

        .google-icon {
            font-size: 1.2rem;
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        .divider {
            margin: 1.5rem 0;
            text-align: center;
            position: relative;
            color: #666;
            font-size: 0.9rem;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background-color: #c8e6c9;
        }

        .divider span {
            background-color: #fff;
            padding: 0 1rem;
        }

        /* === RESPONSIVE === */
        @media (max-width: 480px) {
            .login-container {
                padding: 2rem 1.5rem;
            }

            .login-header h2 {
                font-size: 1.6rem;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-header">
            <h2>Welcome Back 🌱</h2>
            <p>Sign in to continue to <strong>Waste2Product</strong></p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div>
                <label for="email">Email address</label>
                <input id="email" type="email" name="email" placeholder="you@example.com" required>
            </div>

            <div>
                <label for="password">Password</label>
                <div class="input-group">
                    <input id="password" type="password" name="password" placeholder="••••••••" required>
                    <button type="button" class="toggle-password" onclick="togglePassword('password', this)">👁️</button>
                </div>
            </div>

            <button type="submit">Sign In</button>
        </form>

        <div class="divider">
            <span>or</span>
        </div>

        <div class="google-login">
            <a href="{{ route('auth.google') }}" class="google-btn">
                <svg class="google-icon" width="18" height="18" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                Continue with Google
            </a>
        </div>

        <div class="register-link">
            <p>Don’t have an account? <a href="{{ route('register.form') }}">Create one</a></p>
        </div>
    </div>

    <script>
        function togglePassword(id, btn) {
            const input = document.getElementById(id);
            const isPassword = input.type === "password";
            input.type = isPassword ? "text" : "password";
            btn.textContent = isPassword ? "🙈" : "👁️";
        }
    </script>
</body>
</html>
