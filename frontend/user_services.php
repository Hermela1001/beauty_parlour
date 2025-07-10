<?php
require 'config.php';
session_start();



$sql = "SELECT * FROM services ORDER BY category, id";
$stmt = $pdo->query($sql);

$servicesByCategory = [];

while ($row = $stmt->fetch()) {
    $category = $row['category'];
    if (!isset($servicesByCategory[$category])) {
        $servicesByCategory[$category] = [];
    }
    $servicesByCategory[$category][] = $row;
}

$categories = array_keys($servicesByCategory);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Our Services - Glamorous Studio</title>
  <link rel="stylesheet" href="services.css" />
  <style>
    .service-card {
      display: flex;
      justify-content: space-between;
      align-items: center;
      border: 1px solid #ddd;
      padding: 15px;
      margin: 10px 0;
      border-radius: 10px;
      background-color: #fff;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    .service-card img {
      max-width: 150px;
      height: auto;
      border-radius: 10px;
    }

    .service-card h4 {
      margin-bottom: 5px;
      color: #ad1457;
    }

    .price-tag {
      color: #333;
      font-weight: bold;
      margin-top: 5px;
    }

    .btn.filter-btn {
      margin: 5px;
      padding: 8px 16px;
      background-color: #ad1457;
      color: #fff;
      border: none;
      border-radius: 20px;
      cursor: pointer;
    }

    .btn.filter-btn.active {
      background-color: #880e4f;
    }

    .header-buttons {
      margin-top: 20px;
      margin-bottom: 20px;
    }

    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #f8f8f8;
      padding: 15px 30px;
      border-bottom: 1px solid #ddd;
    }

    .nav-links a {
      margin: 0 10px;
      text-decoration: none;
      color: #333;
      font-weight: bold;
    }

    .book-btn {
      background-color: #ad1457;
      color: white;
      padding: 8px 15px;
      border-radius: 15px;
      border: none;
      cursor: pointer;
    }

    .profile-pic {
      width: 30px;
      height: 30px;
      border-radius: 50%;
      margin-left: 10px;
    }

    .header {
      padding: 30px;
      text-align: center;
    }

    h1 {
      color: #ad1457;
    }
  </style>
</head>
<body>
  <nav class="navbar">
    <div class="logo">💄 Beauty Parlour Management System</div>
    <div class="nav-links">
      <a href="home.php">Home</a>
      <a href="services.php" aria-current="page">Services</a>
      <a href="about.php">About Us</a>
      <a href="contact.php">Contact</a>
      <button class="book-btn" onclick="window.location.href='appointment.php'">Book Now</button>
      <img src="profile.jpg" alt="Profile picture" class="profile-pic" />
    </div>
  </nav>

  <div class="header">
    <h1>Our Services</h1>
    <p>Explore our range of luxurious services designed to refresh your natural beauty and bring out the confident, radiant you.</p>

    <div class="header-buttons">
      <button class="btn filter-btn active" data-filter="all">All</button>
      <?php foreach ($categories as $cat): ?>
        <button class="btn filter-btn" data-filter="<?= htmlspecialchars($cat) ?>"><?= ucfirst(htmlspecialchars($cat)) ?></button>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="services-group">
    <?php foreach ($servicesByCategory as $category => $services): ?>
      <?php if (!empty($services)): ?>
        <h2><?= ucfirst(htmlspecialchars($category)) ?> Services</h2>
        <?php foreach ($services as $index => $service): ?>
          <div class="service-card <?= ($index === count($services) - 1) ? 'last-service-card' : '' ?>" data-category="<?= htmlspecialchars($category) ?>">
            <div class="service-details">
              <h4><?= htmlspecialchars($service['title']) ?></h4>
              <p><?= htmlspecialchars($service['description']) ?></p>
              <p class="price-tag">Price: birr<?= htmlspecialchars($service['price']) ?></p>
            </div>
            <img src="<?= htmlspecialchars($service['image_path']) ?>" alt="<?= htmlspecialchars($service['title']) ?>" />
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    <?php endforeach; ?>
  </div>

  <script>
    const filterButtons = document.querySelectorAll('.filter-btn');
    const serviceCards = document.querySelectorAll('.service-card');

    filterButtons.forEach(button => {
      button.addEventListener('click', () => {
        filterButtons.forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');

        const filter = button.getAttribute('data-filter');

        serviceCards.forEach(card => {
          if (filter === 'all' || card.getAttribute('data-category') === filter) {
            card.style.display = 'flex';
          } else {
            card.style.display = 'none';
          }
        });
      });
    });
  </script>
</body>
</html>
