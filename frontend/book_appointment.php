<?php
session_start(); // Required to access $_SESSION
require_once 'config.php';

$error = '';
$success = '';

// Get user_id from session
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    // Redirect to login page if not logged in
    header("Location: user_login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service = trim($_POST['service'] ?? '');
    $date = $_POST['date'] ?? '';
    $time = $_POST['time'] ?? '';
    $notes = trim($_POST['notes'] ?? '');
    $status = 'Pending';

    if (!$service || !$date || !$time) {
        $error = "Please fill in all required fields.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO appointments (user_id, service, appointment_date, appointment_time, notes, status) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$user_id, $service, $date, $time, $notes, $status]);
            $success = "Appointment booked successfully!";
        } catch (PDOException $e) {
            $error = "Database error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Book Appointment - Glamour Studio</title>
  <link rel="stylesheet" href="book_appointment.css">
</head>
<body>

  <div class="navbar">
    <div class="logo">💄 Glamour Studio</div>
    <div class="nav-links">
      <a href="#">Home</a>
      <a href="#">Services</a>
      <a href="#">About</a>
      <a href="#">Contact</a>
      <button class="book-now">Book Now</button>
      <img src="profile.jpg" alt="Profile" class="profile-pic">
    </div>
  </div>

  <div class="hero-image"></div>

  <div class="booking-section">
    <h1>Book an Appointment</h1>

    <?php if ($error): ?>
      <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php elseif ($success): ?>
      <p style="color: green;"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <form class="booking-form" method="POST" action="">
      
      <label>Select Service</label>
      <select name="service" required>
        <option value="">-- Choose a service --</option>
        <option>Hair Styling</option>
        <option>Nail Care</option>
        <option>Facial</option>
      </select>

      <label>Select Date</label>
      <input type="date" name="date" required>

      <label>Select Time</label>
      <input type="time" name="time" required>

      <label>Notes (optional)</label>
      <textarea name="notes" placeholder="Any additional notes..."></textarea>

      <div class="submit-button">
        <button type="submit">Book Appointment</button>
      </div>
    </form>
  </div>

</body>
</html>
