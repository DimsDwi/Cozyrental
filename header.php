<?php require_once 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cozy Car Rental | Premium Luxury Vehicles</title>
  <meta name="description" content="Rent premium and electric luxury vehicles with instant access, zero paperwork, and world-class service.">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
  <a href="index.php" class="logo">Cozy<span>Rental</span></a>
  <nav>
    <ul>
      <li><a href="fleet.php">Fleet</a></li>
      <li><a href="about.php">About</a></li>
      <li><a href="contact.php">Contact</a></li>
      <?php if (isLoggedIn()): ?>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="logout.php" class="btn btn-ghost" style="padding:0.45rem 1rem;">Log Out</a></li>
      <?php else: ?>
        <li><a href="login.php" class="btn btn-ghost" style="padding:0.45rem 1rem;">Log In</a></li>
        <li><a href="register.php" class="btn btn-primary" style="padding:0.45rem 1rem;">Get Started</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</header>
