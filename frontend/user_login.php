<?php
require_once 'config.php';
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = "Please enter both email and password.";
    } else {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['role'] = 'user';

                header('Location: home.php');
                exit;
            } else {
                $error = "Incorrect password.";
            }
        } else {
            $error = "User not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>User Login - Glamorous Haven</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>
  <div class="container">
    <h1>Welcome Back</h1>
    <p class="tagline">Log in to continue your beauty journey with Glamorous Haven.</p>

    <?php if ($error): ?>
      <p class="error-message"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" novalidate>
      <label for="email">Email Address</label>
      <input
        type="email"
        id="email"
        name="email"
        placeholder="you@example.com"
        required
        value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
      />

      <label for="password">Password</label>
      <input
        type="password"
        id="password"
        name="password"
        placeholder="Enter your password"
        required
      />

      <button type="submit">Login</button>
    </form>

    <p class="signup-link">
      Don't have an account? <a href="user_signup.php">Sign Up</a>
    </p>
  </div>
</body>
</html>