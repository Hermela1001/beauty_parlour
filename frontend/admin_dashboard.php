<?php
session_start();

if (!isset($_SESSION['is_admin'])) {
    header("Location: admin_login.php");
    exit;
}

$adminName = $_SESSION['admin_username'] ?? 'Admin';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Dashboard | Glamorous Haven</title>
</head>
<body style="margin: 0; font-family: 'Segoe UI', sans-serif; background: #ffe4f0; color: #5a104d;">

  <div style="background: #fff; padding: 10px 40px; display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #ffc1e3;">
    <div style="font-weight: bold;">
      <a href="admin_dashboard.php" style="text-decoration: none; color: #5a104d;">🌸 Glamour Haven Admin</a>
    </div>
    <div style="display: flex; align-items: center; gap: 15px;">
      <a href="admin_dashboard.php" style="text-decoration: none; color: #5a104d;">Dashboard</a>
      <a href="services.php" style="text-decoration: none; color: #5a104d;">Add Services</a>
      <a href="my_appointments.php" style="text-decoration: none; color: #5a104d;">Appointments</a>
      <a href="view_messages.php" style="text-decoration: none; color: #5a104d;">Messages</a>

      <img src="gallery1.jpg" alt="Admin" style="height: 30px; width: 30px; border-radius: 50%; border: 2px solid #b1005f;" title="<?= htmlspecialchars($adminName) ?>">

      <form action="logout.php" method="POST" style="margin: 0;">
        <button type="submit" style="background: transparent; color: #b1005f; border: 1px solid #b1005f; padding: 6px 12px; border-radius: 20px; cursor: pointer;">Logout</button>
      </form>
    </div>
  </div>

  <div style="padding: 40px; text-align: center;">
    <h2 style="color: #b1005f;">Welcome, <?= htmlspecialchars($adminName) ?> 👩‍💼</h2>
    <p style="font-size: 18px;">Here is your Admin Dashboard to manage appointments, services, and contact messages.</p>
  </div>

  <div style="display: flex; justify-content: center; gap: 30px; flex-wrap: wrap; padding: 20px 40px;">
    <div style="flex: 1; min-width: 280px; background: #fff; padding: 30px; border-radius: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
      <h3 style="color: #b1005f;">📅 Appointments</h3>
      <p>View, manage, or delete upcoming appointments.</p>
      <a href="my_appointments.php">
        <button style="background: #b1005f; color: white; border: none; padding: 10px 20px; border-radius: 20px; margin-top: 10px;">View Appointments</button>
      </a>
    </div>

    <div style="flex: 1; min-width: 280px; background: #fff; padding: 30px; border-radius: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
      <h3 style="color: #b1005f;">💅 Services</h3>
      <p>Add or update beauty services listed on the site.</p>
      <a href="services.php">
        <button style="background: #b1005f; color: white; border: none; padding: 10px 20px; border-radius: 20px; margin-top: 10px;">Manage Services</button>
      </a>
    </div>

    <div style="flex: 1; min-width: 280px; background: #fff; padding: 30px; border-radius: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
      <h3 style="color: #b1005f;">📨 Contact Messages</h3>
      <p>Review messages from clients via the Contact Us form.</p>
      <a href="view_messages.php">
        <button style="background: #b1005f; color: white; border: none; padding: 10px 20px; border-radius: 20px; margin-top: 10px;">View Messages</button>
      </a>
    </div>
  </div>

  <div style="padding: 60px 40px; text-align: center;">
    <h3 style="color: #5a104d;">Need to return to the client view?</h3>
    <a href="home.php">
      <button style="background: #b1005f; color: white; border: none; padding: 10px 25px; border-radius: 25px; margin-top: 15px;">Go to Home Page</button>
    </a>
  </div>

</body>
</html>