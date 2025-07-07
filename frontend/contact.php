<?php
require_once 'config.php'; 

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (!$name || !$email || !$message) {
        $error = "Please fill in all required fields.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO contacts (name, email, phone, message) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $email, $phone, $message]);
            $success = "Your message has been sent successfully!";
        } catch (PDOException $e) {
            $error = "Something went wrong. Please try again later.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact Us - Glamour Studio</title>
  <link rel="stylesheet" href="contact.css">
</head>
<body class="contact-page">

 
  <div class="contact-navbar">
    <div class="brand">💄 Glamour Studio</div>
    <div class="nav-links">
      <a href="home.php">Home</a>
      <a href="services.php">Services</a>
      <a href="#">Gallery</a>
      <a href="#">About</a>
      <a href="contact.php">Contact</a>
      <button class="book-btn">Book Now</button>
    </div>
  </div>

  
  <div class="contact-container">
    <h1>Contact Us</h1>
    <p>We’re here to help. Reach out to us with any questions or to book an appointment.</p>

    
    <?php if ($error): ?>
      <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php elseif ($success): ?>
      <p style="color: green;"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <form class="contact-form" method="POST" action="contact.php">
      <label>Your Name</label>
      <input type="text" name="name" placeholder="Enter your name" required>

      <label>Email Address</label>
      <input type="email" name="email" placeholder="Enter your email" required>

      <label>Phone Number</label>
      <input type="text" name="phone" placeholder="Enter your phone number">

      <label>Message</label>
      <textarea name="message" placeholder="Type your message..." required></textarea>

      <div class="submit-wrap">
        <button type="submit" class="submit-btn">Send Message</button>
      </div>
    </form>

    
    <h2>Operating Hours</h2>
    <div class="contact-hours contact-hours-grid">
      <div><strong>Monday:</strong><br>01:00 - 6:20</div>
      <div><strong>Tuesday:</strong><br>01:00 - 6:20</div>
      <div><strong>Wednesday:</strong><br>01:00 - 6:20</div>
      <div><strong>Thursday:</strong><br>01:00 - 6:20</div>
      <div><strong>Friday:</strong><br>01:00 - 6:20</div>
      <div><strong>Saturday:</strong><br>01:00 - 6:20</div>
      <div><strong>Sunday:</strong><br>Closed</div>
    </div>

   
    <h2>Contact Information</h2>
    <div class="contact-info">
      <p><strong>Phone:</strong><br>09777737773</p>
      <p><strong>Email:</strong><br>hermi@beautyparlour.com</p>
    </div>
  </div>

  
  <div class="contact-footer">
    <a href="home.php">Home</a>
    <a href="services.php">Services</a>
    <a href="#">About</a>
    <a href="contact.php">Contact</a>
  </div>

</body>
</html>
