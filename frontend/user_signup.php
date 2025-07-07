<?php
session_start();
require_once 'config.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name = trim($_POST['name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';

  if (!$name || !$email || !$password) {
    $error = "⚠️ All fields are required.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "❌ Invalid email format.";
  } else {
   
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");

    try {
      $stmt->execute([$name, $email, $hashedPassword]);

      
      $_SESSION['user_email'] = $email;
      $_SESSION['user_name'] = $name;

      
      header("Location: home.php");
      exit;
    } catch (PDOException $e) {
      if ($e->getCode() == 23000) {
       
        $error = "⚠️ Email already exists.";
      } else {
        $error = "❌ Database error: " . $e->getMessage();
      }
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sign Up - Glamorous Haven</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>
  <div class="container">
    <h1>Create Account</h1>
    <p class="tagline">Join Glamorous and unlock your personalized beauty experience.</p>

    <?php if ($error): ?>
      <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="user_signup.php" novalidate>
      <label for="name">Full Name</label>
      <input type="text" id="name" name="name" placeholder="Your full name" required value="<?= htmlspecialchars($name ?? '') ?>" />

      <label for="email">Email Address</label>
      <input type="email" id="email" name="email" placeholder="you@example.com" required value="<?= htmlspecialchars($email ?? '') ?>" />

      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="Create a password" required />

      <button type="submit">Sign Up</button>
    </form>

    <p class="login-link">Already have an account? <a href="user_login.php">Login</a></p>
  </div>
</body>
</html>
