<?php require_once __DIR__ . '/../includes/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cozy Car Rental | Sewa Kendaraan Mewah Premium</title>
  <meta name="description" content="Sewa kendaraan mewah dan elektrik premium dengan akses instan, tanpa dokumen, dan layanan kelas dunia.">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/assets/css/style.css">
  <link rel="stylesheet" href="/dist/main.css">
</head>
<body>

<header>
  <a href="/index.php" class="logo">Cozy<span>Rental</span></a>
  <nav>
    <ul>
      <li><a href="/pages/fleet.php">Armada</a></li>
      <li><a href="/pages/about.php">Tentang</a></li>
      <li><a href="/pages/contact.php">Kontak</a></li>
      <?php if (isLoggedIn()): ?>
        <li><a href="/user/dashboard.php">Dashboard</a></li>
        <li><a href="/auth/logout.php" class="btn btn-ghost" style="padding:0.45rem 1rem;">Keluar</a></li>
      <?php else: ?>
        <li><a href="/auth/login.php" class="btn btn-ghost" style="padding:0.45rem 1rem;">Masuk</a></li>
        <li><a href="/auth/register.php" class="btn btn-primary" style="padding:0.45rem 1rem;">Mulai</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</header>
