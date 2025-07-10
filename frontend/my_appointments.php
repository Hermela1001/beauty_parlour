<?php
session_start();
require_once 'config.php';


$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header("Location: user_login.php");
    exit;
}

try {
    
    $stmt = $pdo->prepare('SELECT * FROM appointments WHERE user_id = ? ORDER BY appointment_date, appointment_time');
    $stmt->execute([$user_id]);
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching appointments: " . htmlspecialchars($e->getMessage());
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>My Appointments</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="my_appointments.css" />
  <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>
  <div class="container">
    <aside class="sidebar">
      <div class="profile">
        <img src="profile.jpg" alt="Profile" class="profile-img" />
        <h3>Isabelle</h3>
        <p>Studio Manager</p>
      </div>
      <nav>
        <ul>
          <li><i data-lucide="layout-dashboard"></i><a href="#">Dashboard</a></li>
          <li class="active"><i data-lucide="calendar-days"></i><a href="#">Appointments</a></li>
          <li><i data-lucide="bar-chart-2"></i><a href="#">Reports</a></li>
          <li><i data-lucide="scissors"></i><a href="#">Services</a></li>
          <li><i data-lucide="settings"></i><a href="#">Settings</a></li>
        </ul>
      </nav>
    </aside>

    <main class="main-content">
      <h1>My Appointments</h1>

      <div class="tabs">
        <button class="tab active">Upcoming</button>
        <button class="tab">Completed</button>
        <button class="tab">Cancelled</button>
      </div>

      <table class="appointments-table">
        <thead>
          <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Service</th>
            <th>Notes</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($appointments)): ?>
            <?php foreach ($appointments as $appointment): ?>
              <tr>
                <td><?= htmlspecialchars(date("F j, Y", strtotime($appointment['appointment_date']))) ?></td>
                <td><?= htmlspecialchars(date("g:i A", strtotime($appointment['appointment_time']))) ?></td>
                <td><?= htmlspecialchars($appointment['service']) ?></td>
                <td><?= htmlspecialchars($appointment['notes']) ?></td>
                <td>
                  <?php
                    $status = $appointment['status'];
                    $badgeClass = match ($status) {
                      'Pending' => 'pending',
                      'Confirmed' => 'confirmed',
                      'Cancelled' => 'cancelled',
                      default => '',
                    };
                  ?>
                  <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($status) ?></span>
                </td>
                <td><button class="view-btn">View</button></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="6">No appointments found for your account.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </main>
  </div>

  <script>
    lucide.createIcons();
  </script>
</body>
</html>
