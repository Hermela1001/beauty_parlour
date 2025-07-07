<?php
session_start();

// Allow access if either a user or admin is logged in
if (!isset($_SESSION['user_id']) && !isset($_SESSION['is_admin'])) {
    header("Location: login.html");
    exit;
}

// Show username depending on session
$username = $_SESSION['username'] ?? $_SESSION['admin_username'] ?? 'Guest';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Glamorous Haven</title>
</head>
<body style="margin: 0; font-family: 'Segoe UI', sans-serif; background: #ffe4f0; color: #5a104d;">

  <div style="background: #fff; padding: 10px 40px; display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #ffc1e3;">
    <div style="font-weight: bold;">
      <a href="home.php" style="text-decoration: none; color: #5a104d;">🌸 Glamour Haven</a>
    </div>
    <div style="display: flex; align-items: center; gap: 15px;">
      <a href="user_services.php" style="text-decoration: none; color: #5a104d;">Services</a>
      <a href="about.php" style="text-decoration: none; color: #5a104d;">About Us</a>
      <a href="contact.php" style="text-decoration: none; color: #5a104d;">Contact</a>
      <a href="book_appointment.php">
        <button style="background: #b1005f; color: white; border: none; padding: 8px 16px; border-radius: 20px;">Book Now</button>
      </a>

      <img src="profile.jpg" alt="Profile" style="height: 30px; width: 30px; border-radius: 50%; border: 2px solid #b1005f;" title="<?= htmlspecialchars($username) ?>">

      <form action="logout.php" method="POST" style="margin: 0;">
        <button type="submit" style="background: transparent; color: #b1005f; border: 1px solid #b1005f; padding: 6px 12px; border-radius: 20px; cursor: pointer;">Logout</button>
      </form>
    </div>
  </div>

  <div style="padding: 30px 40px; text-align: center;">
    <h2 style="color: #b1005f;">Welcome to Glamorous Haven 💖</h2>
    <p style="font-size: 18px;">Your beauty, our passion.</p>
  </div>

  <div style="position: relative; height: 450px; overflow: hidden; display: flex; justify-content: center; align-items: center; text-align: center;">
    <img src="interior.jpg" alt="Interior" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: 0;" />
    <div style="position: relative; z-index: 1; background-color: rgba(255, 255, 255, 0.85); padding: 40px 30px; border-radius: 20px; max-width: 600px; width: 90%;">
      <h1 style="font-size: 36px; font-weight: bold; margin-bottom: 20px; color: #b1005f;">Elevate Your Beauty Experience</h1>
      <p style="font-size: 16px; margin-bottom: 25px; color: #5a104d;">Step into elegance and style — where beauty meets comfort.</p>
      <a href="book_appointment.php">
        <button style="background: #b1005f; color: white; border: none; padding: 12px 30px; border-radius: 25px; font-size: 16px;">Book Appointment</button>
      </a>
    </div>
  </div>

  <div style="padding: 60px 40px;">
    <h2 style="color: #b1005f;">Our Services</h2>
    <div style="display: flex; flex-wrap: wrap; justify-content: space-between; gap: 20px; margin-top: 30px;">
      <div style="flex: 1; min-width: 250px; background: #fff; padding: 15px; border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
        <img src="hair.jpg" alt="Hair Styling" style="width: 100%; border-radius: 10px;">
        <h4 style="margin-top: 10px;">Hair Styling</h4>
        <p>Transform your look with our expert hair stylists.</p>
      </div>
      <div style="flex: 1; min-width: 250px; background: #fff; padding: 15px; border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
        <img src="nails.jpg" alt="Nail Care" style="width: 100%; border-radius: 10px;">
        <h4 style="margin-top: 10px;">Nail Care</h4>
        <p>Pamper your hands and feet with our luxurious nail services.</p>
      </div>
      <div style="flex: 1; min-width: 250px; background: #fff; padding: 15px; border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
        <img src="facial.jpg" alt="Facial Treatments" style="width: 100%; border-radius: 10px;">
        <h4 style="margin-top: 10px;">Facial Treatments</h4>
        <p>Rejuvenate your skin with our advanced facial treatments.</p>
      </div>
    </div>
  </div>

  <div style="padding: 40px;">
    <h2 style="color: #b1005f;">Gallery</h2>
    <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 20px;">
      <img src="gallery1.jpg" alt="Gallery" style="width: 150px; height: 150px; object-fit: cover; border-radius: 10px;">
      <img src="gallery2.jpg" alt="Gallery" style="width: 150px; height: 150px; object-fit: cover; border-radius: 10px;">
      <img src="gallery3.jpg" alt="Gallery" style="width: 150px; height: 150px; object-fit: cover; border-radius: 10px;">
      <img src="gallery4.jpg" alt="Gallery" style="width: 150px; height: 150px; object-fit: cover; border-radius: 10px;">
      <img src="gallery5.jpg" alt="Gallery" style="width: 150px; height: 150px; object-fit: cover; border-radius: 10px;">
      <img src="gallery6.jpg" alt="Gallery" style="width: 150px; height: 150px; object-fit: cover; border-radius: 10px;">
    </div>
  </div>

  <div style="padding: 40px; background: #fff; border-radius: 20px; margin: 40px;">
    <h2 style="color: #b1005f;">About Us</h2>
    <p>At Glamour Haven, we believe in the power of beauty to inspire confidence and well-being. Our team of skilled professionals is committed to providing exceptional service and personalized care in a luxurious and relaxing environment. We use only the finest products and techniques to ensure you leave feeling refreshed, rejuvenated, and radiant.</p>
  </div>

  <div style="padding: 40px;">
    <h2 style="color: #b1005f;">Contact</h2>
    <p>Email: Hermela.zerihun@bitscollege.edu.et</p>
    <p>Phone: 0911234566</p>
    <p>Address: Yeka, Addis Ababa City</p>
  </div>

  <div style="background: #ffcce5; text-align: center; padding: 60px 20px;">
    <h2 style="color: #b1005f;">Ready to Experience the Difference?</h2>
    <a href="book_appointment.php">
      <button style="background: #b1005f; color: white; padding: 12px 24px; border: none; border-radius: 25px; margin-top: 20px;">Book Your Appointment Today</button>
    </a>
  </div>

  <script src="main.js"></script>
</body>
</html>
