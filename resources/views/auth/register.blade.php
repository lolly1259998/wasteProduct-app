<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte - Waste2Product</title>

    <style>
        /* === RESET & GLOBAL === */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #f1f8e9, #e8f5e9);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* === CONTAINER === */
        .register-container {
            background: #fff;
            padding: 3rem 2.5rem;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 430px;
            transition: transform 0.3s ease;
        }

        .register-container:hover {
            transform: translateY(-5px);
        }

        /* === HEADER === */
        .register-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .register-header h2 {
            color: #2e7d32;
            font-size: 2rem;
            font-weight: 600;
        }

        .register-header p {
            color: #666;
            font-size: 0.9rem;
        }

        /* === FORM === */
        form {
            display: flex;
            flex-direction: column;
            gap: 1.1rem;
        }

        label {
            font-weight: 500;
            color: #2e7d32;
        }

        .input-group {
            position: relative;
        }

        input {
            padding: 0.9rem 1rem;
            border: 2px solid #c8e6c9;
            border-radius: 10px;
            transition: 0.3s;
            width: 100%;
        }

        input:focus {
            border-color: #43a047;
            outline: none;
            box-shadow: 0 0 0 3px rgba(67, 160, 71, 0.2);
        }

        /* === EYE BUTTON === */
        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.1rem;
            color: #43a047;
            transition: 0.3s;
        }

        .toggle-password:hover {
            color: #2e7d32;
        }

        /* === BUTTON === */
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
        .login-link {
            text-align: center;
            margin-top: 1rem;
        }

        .login-link a {
            text-decoration: none;
            color: #2e7d32;
            font-weight: 500;
            transition: 0.3s;
        }

        .login-link a:hover {
            text-decoration: underline;
            color: #1b5e20;
        }

        /* === RESPONSIVE === */
        @media (max-width: 480px) {
            .register-container {
                padding: 2rem 1.5rem;
            }

            .register-header h2 {
                font-size: 1.6rem;
            }
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="register-header">
            <h2>Join Waste2Product 🌍</h2>
            <p>Create your account and help build a greener future</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <label for="name">Full name</label>
                <input id="name" type="text" name="name" placeholder="John Doe" required>
            </div>

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

            <div>
                <label for="password_confirmation">Confirm password</label>
                <div class="input-group">
                    <input id="password_confirmation" type="password" name="password_confirmation" placeholder="••••••••" required>
                    <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation', this)">👁️</button>
                </div>
            </div>

            <button type="submit">Sign Up</button>
        </form>

        <div class="login-link">
            <p>Already have an account? <a href="{{ route('login.form') }}">Sign in</a></p>
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
