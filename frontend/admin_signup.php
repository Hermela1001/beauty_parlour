<?php
require_once 'config.php';
session_start();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (!$username || !$password || !$confirm_password) {
        $error = "Please fill in all fields.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Check if username already exists
        $stmt = $pdo->prepare('SELECT * FROM admins WHERE username = ?');
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $error = "Username already taken.";
        } else {
            // Insert new admin
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert = $pdo->prepare('INSERT INTO admins (username, password) VALUES (?, ?)');
            if ($insert->execute([$username, $hashed_password])) {
                $success = "Admin account created successfully. You can now <a href='admin_login.php'>log in</a>.";
            } else {
                $error = "Failed to create admin account. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Signup - Glamorous Studio</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>
  <div class="container">
    <h1>Admin Signup</h1>
    <p class="tagline">Create a new admin account to manage the studio.</p>

    <?php if ($error): ?>
      <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php elseif ($success): ?>
      <p style="color:green;"><?= $success ?></p>
    <?php endif; ?>

    <form method="POST" novalidate>
      <label for="username">Username</label>
      <input type="text" id="username" name="username" placeholder="Choose a username" required value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" />

      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="Enter a password" required />

      <label for="confirm_password">Confirm Password</label>
      <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required />

      <button type="submit">Sign Up</button>
    </form>
  </div>
</body>
</html>