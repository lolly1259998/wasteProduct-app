<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Forgot Password - Waste2Product</title>
  <style>
    body {
      background: url("{{ asset('images/backRegister.png') }}") no-repeat center center/cover;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      font-family: 'Poppins', sans-serif;
    }
    .card {
      background: #fff;
      padding: 2rem;
      border-radius: 16px;
      width: 360px;
      box-shadow: 0 6px 15px rgba(0,0,0,0.1);
      text-align: center;
    }
    input {
      width: 100%;
      padding: 0.8rem;
      border: 2px solid #c8e6c9;
      border-radius: 8px;
      margin-top: 10px;
    }
    button {
      margin-top: 15px;
      background: #43a047;
      color: white;
      border: none;
      border-radius: 8px;
      padding: 0.8rem;
      cursor: pointer;
      width: 100%;
      font-weight: bold;
    }
    button:hover { background: #2e7d32; }
    .text-danger { color: #d32f2f; font-size: 0.85rem; }
  </style>
</head>
<body>
  <div class="card">
    <h2>Forgot Password</h2>
    <p>Enter your email to receive a reset link.</p>

    @if (session('status'))
      <p style="color:#43a047">{{ session('status') }}</p>
    @endif

    <form method="POST" action="{{ route('password.email') }}" novalidate>
      @csrf
      <input type="email" name="email" placeholder="you@example.com" class="@error('email') is-invalid @enderror">
      @error('email') <small class="text-danger">{{ $message }}</small> @enderror

      <button type="submit">Send Reset Link</button>
    </form>
  </div>
</body>
</html>
