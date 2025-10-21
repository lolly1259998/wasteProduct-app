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
