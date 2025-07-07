<?php
require 'config.php';
session_start();

if (!($_SESSION['is_admin'] ?? false)) {
    header('Location: admin_login.php');
    exit;
}


$uploadDir = 'uploads/';


if (isset($_POST['add'])) {
    $category = trim($_POST['category'] ?? '');
    $title = trim($_POST['title'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $description = trim($_POST['description'] ?? '');
    
    $image_path = null;
  
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['image']['tmp_name'];
        $filename = basename($_FILES['image']['name']);
        $targetFile = $uploadDir . time() . '_' . $filename;
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        if (move_uploaded_file($tmpName, $targetFile)) {
            $image_path = $targetFile;
        }
    }

    if ($title && $price !== '') {
        $stmt = $pdo->prepare("INSERT INTO services (category, title, price, description, image_path) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$category, $title, $price, $description, $image_path]);
        $_SESSION['message'] = "Service added successfully!";
        header("Location: add_services.php");
        exit;
    } else {
        $_SESSION['message'] = "Title and price are required.";
    }
}


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    
    
    $imgStmt = $pdo->prepare("SELECT image_path FROM services WHERE id = ?");
    $imgStmt->execute([$id]);
    $imgData = $imgStmt->fetch();
    if ($imgData && $imgData['image_path'] && file_exists($imgData['image_path'])) {
        unlink($imgData['image_path']);
    }

    $pdo->prepare("DELETE FROM services WHERE id = ?")->execute([$id]);
    $_SESSION['message'] = "Service deleted successfully!";
    header("Location: add_services.php");
    exit;
}


if (isset($_POST['update'])) {
    $id = $_POST['service_id'] ?? '';
    $category = trim($_POST['category'] ?? '');
    $title = trim($_POST['title'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $description = trim($_POST['description'] ?? '');

    
    $image_path = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['image']['tmp_name'];
        $filename = basename($_FILES['image']['name']);
        $targetFile = $uploadDir . time() . '_' . $filename;
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        if (move_uploaded_file($tmpName, $targetFile)) {
            $image_path = $targetFile;
            
            $oldImgStmt = $pdo->prepare("SELECT image_path FROM services WHERE id = ?");
            $oldImgStmt->execute([$id]);
            $oldImg = $oldImgStmt->fetch();
            if ($oldImg && $oldImg['image_path'] && file_exists($oldImg['image_path'])) {
                unlink($oldImg['image_path']);
            }
        }
    }

    if ($title && $price !== '' && $id) {
        if ($image_path) {
            $stmt = $pdo->prepare("UPDATE services SET category = ?, title = ?, price = ?, description = ?, image_path = ? WHERE id = ?");
            $stmt->execute([$category, $title, $price, $description, $image_path, $id]);
        } else {
            $stmt = $pdo->prepare("UPDATE services SET category = ?, title = ?, price = ?, description = ? WHERE id = ?");
            $stmt->execute([$category, $title, $price, $description, $id]);
        }
        $_SESSION['message'] = "Service updated!";
        header("Location: add_services.php");
        exit;
    } else {
        $_SESSION['message'] = "Title and price are required.";
    }
}


$services = $pdo->query("SELECT * FROM services ORDER BY id DESC")->fetchAll();


$editing = false;
$edit_data = null;
if (isset($_GET['edit'])) {
    $editing = true;
    $edit_id = $_GET['edit'];
    $edit_service = $pdo->prepare("SELECT * FROM services WHERE id = ?");
    $edit_service->execute([$edit_id]);
    $edit_data = $edit_service->fetch();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Manage Services</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #fff8f9;
      padding: 30px;
    }

    h2 {
      color: #ad1457;
      margin-bottom: 20px;
    }

    form {
      background: #fff;
      padding: 20px;
      border: 2px solid #f1d1dc;
      border-radius: 8px;
      margin-bottom: 30px;
      max-width: 500px;
    }

    form input, form textarea {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border-radius: 5px;
      border: 1px solid #ccc;
      box-sizing: border-box;
    }

    form button {
      background-color: #ad1457;
      color: white;
      border: none;
      padding: 10px 16px;
      border-radius: 5px;
      cursor: pointer;
    }

    .message {
      background: #e0ffe0;
      color: #2e7d32;
      padding: 10px;
      margin-bottom: 20px;
      border-radius: 5px;
      max-width: 500px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      padding: 12px;
      border: 1px solid #eee;
      text-align: left;
      vertical-align: middle;
    }

    th {
      background-color: #fce4ec;
      color: #ad1457;
    }

    .actions a {
      margin-right: 10px;
      color: #ad1457;
      text-decoration: none;
    }

    .actions a.delete {
      color: red;
    }

    img.service-img {
      max-width: 100px;
      height: auto;
      border-radius: 5px;
    }
  </style>
</head>
<body>

  <h2><?= $editing ? 'Edit Service' : 'Add New Service' ?></h2>

  <?php if (isset($_SESSION['message'])): ?>
    <div class="message"><?= htmlspecialchars($_SESSION['message']); unset($_SESSION['message']); ?></div>
  <?php endif; ?>

  <form method="post" enctype="multipart/form-data">
    <?php if ($editing): ?>
      <input type="hidden" name="service_id" value="<?= htmlspecialchars($edit_data['id'] ?? '') ?>">
    <?php endif; ?>
    
    <input type="text" name="category" placeholder="Category" value="<?= ($editing && isset($edit_data['category'])) ? htmlspecialchars($edit_data['category']) : '' ?>">
    
    <input type="text" name="title" placeholder="Service Name" required value="<?= ($editing && isset($edit_data['title'])) ? htmlspecialchars($edit_data['title']) : '' ?>">
    
    <input type="number" name="price" placeholder="Service Price" required step="0.01" value="<?= ($editing && isset($edit_data['price'])) ? htmlspecialchars($edit_data['price']) : '' ?>">
    
    <textarea name="description" placeholder="Description"><?= ($editing && isset($edit_data['description'])) ? htmlspecialchars($edit_data['description']) : '' ?></textarea>

    <label>Image (optional):</label><br>
    <input type="file" name="image" accept="image/*"><br>
    <?php if ($editing && !empty($edit_data['image_path'])): ?>
        <img src="<?= htmlspecialchars($edit_data['image_path']) ?>" alt="Service Image" class="service-img">
    <?php endif; ?>

    <button type="submit" name="<?= $editing ? 'update' : 'add' ?>"><?= $editing ? 'Update Service' : 'Add Service' ?></button>
  </form>

  <h2>All Services</h2>
  <table>
    <thead>
      <tr>
        <th>Category</th>
        <th>Name</th>
        <th>Price</th>
        <th>Description</th>
        <th>Image</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($services as $service): ?>
        <tr>
          <td><?= htmlspecialchars($service['category']) ?></td>
          <td><?= htmlspecialchars($service['title']) ?></td>
          <td>$<?= htmlspecialchars(number_format($service['price'], 2)) ?></td>
          <td><?= nl2br(htmlspecialchars($service['description'])) ?></td>
          <td>
            <?php if (!empty($service['image_path']) && file_exists($service['image_path'])): ?>
              <img src="<?= htmlspecialchars($service['image_path']) ?>" alt="Service Image" class="service-img">
            <?php else: ?>
              No image
            <?php endif; ?>
          </td>
          <td class="actions">
            <a href="?edit=<?= $service['id'] ?>">Edit</a>
            <a href="?delete=<?= $service['id'] ?>" class="delete" onclick="return confirm('Delete this service?')">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

</body>
</html>
