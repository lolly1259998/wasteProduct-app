<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reset Password - Waste2Product</title>
  <style>
    body {
      background: #f1f8e9;
      font-family: 'Poppins', sans-serif;
      text-align: center;
      padding: 40px;
      color: #333;
    }
    .email-card {
      background: #fff;
      border-radius: 16px;
      padding: 30px;
      max-width: 500px;
      margin: auto;
      box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    }
    .logo {
      width: 80px;
      margin-bottom: 20px;
    }
    h2 {
      color: #2e7d32;
      font-weight: 600;
      margin-bottom: 10px;
    }
    p {
      font-size: 0.95rem;
      line-height: 1.6;
      color: #444;
    }
    a.button {
      display: inline-block;
      background: #43a047;
      color: #fff;
      text-decoration: none;
      padding: 12px 25px;
      border-radius: 8px;
      font-weight: bold;
      margin-top: 20px;
    }
    a.button:hover {
      background: #2e7d32;
    }
    footer {
      font-size: 0.8rem;
      color: #777;
      margin-top: 25px;
    }
  </style>
</head>
<body>
  <div class="email-card">
    <img src="{{ asset('images/logo.png') }}" alt="Waste2Product Logo" class="logo">
    <h2>Reset Your Password</h2>
    <p>Hello {{ $user->name }},</p>
    <p>We received a request to reset your Waste2Product account password.<br>
    Click the button below to choose a new one:</p>

    <a href="{{ $url }}" class="button">Reset Password</a>

    <p>If you didn’t request this, please ignore this email.</p>
    <footer>🌿 Waste2Product — Building a Greener Future</footer>
  </div>
</body>
</html>
