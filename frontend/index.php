<?php
session_start();

// Redirect if already logged in
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: my_appointments.php"); // or admin dashboard path
        exit();
    } elseif ($_SESSION['role'] === 'user') {
        header("Location: home.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Welcome to Glamorous Haven</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body, html {
      height: 100%;
      font-family: 'Montserrat', sans-serif;
      background: linear-gradient(135deg, #fce4ec, #f8bbd0);
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
      color: #5c4057;
    }

    .container {
      background: #fff;
      max-width: 860px;
      width: 100%;
      padding: 60px 50px;
      border-radius: 20px;
      box-shadow: 0 18px 36px rgba(236, 109, 143, 0.3);
      text-align: center;
    }

    h1 {
      font-weight: 700;
      font-size: 3.2rem;
      margin-bottom: 20px;
      color: #ad1457;
    }

    .tagline {
      font-weight: 400;
      font-size: 1.35rem;
      margin-bottom: 42px;
      color: #7a4f65;
      line-height: 1.6;
    }

    .buttons {
      display: flex;
      justify-content: center;
      gap: 30px;
      margin-bottom: 45px;
      flex-wrap: wrap;
    }

    .btn {
      padding: 16px 52px;
      font-weight: 600;
      font-size: 1.125rem;
      border-radius: 32px;
      cursor: pointer;
      text-decoration: none;
      transition: all 0.3s ease;
      box-shadow: 0 6px 15px rgba(173, 20, 87, 0.3);
      user-select: none;
      border: none;
      color: white;
    }

    .btn-admin {
      background-color: #ad1457;
    }

    .btn-admin:hover {
      background-color: #8e0e47;
      box-shadow: 0 10px 24px rgba(142, 14, 71, 0.5);
    }

    .btn-user {
      background-color: #f48fb1;
      color: white;
    }

    .btn-user:hover {
      background-color: #d81b60;
      box-shadow: 0 10px 24px rgba(216, 27, 96, 0.5);
    }

    .features {
      display: flex;
      justify-content: space-around;
      flex-wrap: wrap;
      gap: 20px;
      margin-bottom: 40px;
    }

    .feature-item {
      display: flex;
      align-items: center;
      font-size: 1.2rem;
      color: #8e577c;
      min-width: 240px;
      justify-content: center;
    }

    .feature-icon {
      font-size: 2.4rem;
      margin-right: 14px;
    }

    footer {
      font-size: 0.9rem;
      color: #b06a8f;
      font-weight: 500;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Welcome to Glamorous Haven</h1>
    <p class="tagline">Step into luxury and beauty. Choose your experience below.</p>

    <div class="buttons">
      <button class="btn btn-admin" onclick="location.href='admin_login.php'">Admin Login</button>
      <button class="btn btn-user" onclick="location.href='user_login.php'">User Login</button>
    </div>

    <div class="buttons">
      <button class="btn btn-admin" onclick="location.href='admin_signup.php'">Admin Sign Up</button>
      <button class="btn btn-user" onclick="location.href='user_signup.php'">User Sign Up</button>
    </div>

    <div class="features">
      <div class="feature-item">
        <div class="feature-icon">💅</div>
        Premium beauty treatments & services
      </div>
      <div class="feature-item">
        <div class="feature-icon">💖</div>
        Personalized skincare & glam tips
      </div>
      <div class="feature-item">
        <div class="feature-icon">🌟</div>
        Book, track & manage appointments
      </div>
    </div>

    <footer>&copy; 2025 Glamorous Beauty Parlour</footer>
  </div>
</body>
</html>
