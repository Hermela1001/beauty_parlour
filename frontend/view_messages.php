<?php
require 'config.php';
session_start();

if (!($_SESSION['is_admin'] ?? false)) {
    header('Location: admin_login.php');
    exit;
}

$stmt = $pdo->query("SELECT * FROM contacts ORDER BY created_at DESC");
$messages = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Client Messages</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #fdf8f9;
      margin: 0;
      padding: 30px 20px;
    }

    .container {
      max-width: 900px;
      margin: 0 auto;
    }

    h2 {
      text-align: center;
      color: #ad1457;
      margin-bottom: 30px;
    }

    .message-list {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .message-item {
      background-color: #fff;
      border-left: 5px solid #ad1457;
      border-radius: 5px;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    .message-item h4 {
      margin: 0 0 5px;
      color: #ad1457;
      font-size: 1.1rem;
    }

    .message-item .email {
      color: #777;
      font-size: 0.9rem;
      margin-bottom: 10px;
    }

    .message-item .content {
      color: #444;
      font-size: 1rem;
      line-height: 1.5;
      margin-bottom: 10px;
      white-space: pre-wrap;
    }

    .message-item .date {
      text-align: right;
      font-size: 0.85rem;
      color: #aaa;
    }

    .no-messages {
      text-align: center;
      color: #888;
      font-size: 1.1rem;
      margin-top: 50px;
    }
  </style>
</head>
<body>

  <div class="container">
    <h2>📬 Client Messages</h2>

    <?php if (empty($messages)): ?>
      <p class="no-messages">No messages found.</p>
    <?php else: ?>
      <ul class="message-list">
        <?php foreach ($messages as $msg): ?>
          <li class="message-item">
            <h4><?= htmlspecialchars($msg['name']) ?></h4>
            <div class="email"><?= htmlspecialchars($msg['email']) ?></div>
            <div class="content"><?= htmlspecialchars($msg['message']) ?></div>
            <div class="date">Sent on <?= date('F j, Y \a\t g:i A', strtotime($msg['created_at'])) ?></div>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </div>

</body>
</html>
