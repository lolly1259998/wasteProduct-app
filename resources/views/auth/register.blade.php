<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Join Waste2Product 🌍</title>

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }

    html, body {
      height: 100%;
      overflow: hidden;
        background: url("{{ asset('images/backRegister.png') }}") no-repeat center center/cover;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    /* === Animation fade-in === */
    @keyframes fadeUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .register-container {
      background: #fff;
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
      width: 460px;
      padding: 2.3rem 2.5rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      animation: fadeUp 0.8s ease-out;
      transition: all 0.3s ease;
    }

    .register-container:hover {
      transform: translateY(-5px);
      box-shadow: 0 14px 35px rgba(0, 0, 0, 0.15);
    }

    .register-header {
      text-align: center;
      margin-bottom: 1.4rem;
    }

    .register-header h2 {
      color: #2e7d32;
      font-size: 1.9rem;
      font-weight: 700;
      margin-bottom: 0.3rem;
    }

    .register-header p {
      color: #555;
      font-size: 0.9rem;
    }

    form {
      width: 100%;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 0.9rem 1rem;
    }

    form .full {
      grid-column: span 2;
    }

    label {
      display: block;
      font-size: 0.9rem;
      font-weight: 500;
      color: #2e7d32;
      margin-bottom: 4px;
    }

    input {
      width: 100%;
      padding: 0.7rem 0.8rem;
      border: 2px solid #c8e6c9;
      border-radius: 8px;
      font-size: 0.9rem;
      transition: 0.3s ease;
    }

    input:focus {
      border-color: #43a047;
      outline: none;
      box-shadow: 0 0 0 3px rgba(67, 160, 71, 0.2);
    }

    input.is-invalid {
      border-color: #e57373 !important;
      background-color: #ffebee;
    }

    .text-danger {
      color: #d32f2f;
      font-size: 0.75rem;
      margin-top: 2px;
      line-height: 1.1;
    }

    /* === Button === */
    button {
      grid-column: span 2;
      background: #43a047;
      color: #fff;
      border: none;
      border-radius: 10px;
      padding: 0.9rem;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.25s ease;
      margin-top: 0.4rem;
    }

    button:hover {
      background: #2e7d32;
      transform: scale(1.03);
    }

    /* === Login link === */
    .login-link {
      text-align: center;
      font-size: 0.9rem;
      margin-top: 0.9rem;
    }

    .login-link a {
      color: #2e7d32;
      text-decoration: none;
      font-weight: 600;
    }

    .login-link a:hover {
      text-decoration: underline;
    }

    /* === Alignement parfait === */
    form div {
      display: flex;
      flex-direction: column;
    }

    @media (max-height: 750px) {
      html, body {
        align-items: flex-start;
        padding-top: 30px;
      }
    }
  </style>
</head>

<body>
  <div class="register-container">
    <div class="register-header">
      <h2>Join Waste2Product</h2>
      <p>Create your account and help build a greener future</p>
    </div>

    <form method="POST" action="{{ route('register') }}" novalidate>
      @csrf

      <div>
        <label for="name">Full name</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" class="@error('name') is-invalid @enderror">
        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div>
        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" class="@error('email') is-invalid @enderror">
        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div>
        <label for="phone">Phone</label>
        <input id="phone" type="text" name="phone" value="{{ old('phone') }}" class="@error('phone') is-invalid @enderror">
        @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div>
        <label for="city">City</label>
        <input id="city" type="text" name="city" value="{{ old('city') }}" class="@error('city') is-invalid @enderror">
        @error('city') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div class="full">
        <label for="address">Address</label>
        <input id="address" type="text" name="address" value="{{ old('address') }}" class="@error('address') is-invalid @enderror">
        @error('address') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div>
        <label for="password">Password</label>
        <input id="password" type="password" name="password" class="@error('password') is-invalid @enderror">
        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div>
        <label for="password_confirmation">Confirm</label>
        <input id="password_confirmation" type="password" name="password_confirmation">
      </div>

      <button type="submit">Sign Up</button>
    </form>

    <div class="login-link">
      <p>Already have an account? <a href="{{ route('login.form') }}">Sign in</a></p>
    </div>
  </div>
</body>
</html>
