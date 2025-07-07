<?php
require_once 'config.php';
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = "Please enter both username and password.";
    } else {
        $stmt = $pdo->prepare('SELECT * FROM admins WHERE username = ?');
        $stmt->execute([$username]);
        $admin = $stmt->fetch();

        if ($admin) {
            if (password_verify($password, $admin['password'])) {
                session_regenerate_id(true);
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_username'] = $admin['username'];
                $_SESSION['is_admin'] = true;

                header('Location: admin_dashboard.php'); // ✅ Redirect to admin dashboard
                exit;
            } else {
                $error = "Incorrect password.";
            }
        } else {
            $error = "Admin not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Login - Glamorous Haven</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>
  <div class="container">
    <h1>Admin Login</h1>
    <p class="tagline">Access your admin panel at Glamorous Haven.</p>

    <?php if ($error): ?>
      <p class="error-message"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" novalidate>
      <label for="username">Username</label>
      <input
        type="text"
        id="username"
        name="username"
        placeholder="admin username"
        required
        value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
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
  </div>
</body>
</html>
