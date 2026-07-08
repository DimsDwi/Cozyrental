<?php
require_once __DIR__ . '/../../includes/db.php';
requireAdmin();

$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cozy Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        :root {
            --sidebar-width: 280px;
        }
        body {
            background: var(--bg);
            margin: 0;
            display: flex;
            min-height: 100vh;
        }
        /* Sidebar */
        .admin-sidebar {
            width: var(--sidebar-width);
            background: rgba(24,24,31,0.95);
            backdrop-filter: blur(20px);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 100;
        }
        .admin-logo {
            padding: 2rem;
            font-size: 1.5rem;
            font-weight: 900;
            color: white;
            text-decoration: none;
            letter-spacing: -0.5px;
        }
        .admin-logo span {
            color: var(--primary-light);
        }
        .admin-nav {
            flex: 1;
            padding: 0 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        .admin-nav a {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 1.5rem;
            color: var(--muted);
            text-decoration: none;
            font-weight: 600;
            border-radius: 12px;
            transition: all 0.2s;
        }
        .admin-nav a:hover, .admin-nav a.active {
            background: rgba(99,102,241,0.1);
            color: var(--primary-light);
        }
        .admin-nav a.active {
            border-left: 4px solid var(--primary-light);
        }
        /* Main Content */
        .admin-main {
            margin-left: var(--sidebar-width);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0; /* prevent flex blowout */
        }
        .admin-topbar {
            height: 80px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 0 2rem;
            background: rgba(10,10,15,0.8);
            backdrop-filter: blur(10px);
            position: sticky;
            top: 0;
            z-index: 90;
        }
        .admin-content {
            padding: 2rem;
            flex: 1;
        }
        /* Tables */
        .admin-table {
            width: 100%;
            border-collapse: collapse;
            background: var(--surface);
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid var(--border);
        }
        .admin-table th, .admin-table td {
            padding: 1.25rem 1.5rem;
            text-align: left;
            border-bottom: 1px solid var(--border2);
        }
        .admin-table th {
            background: var(--surface2);
            color: var(--muted);
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .admin-table tr:last-child td {
            border-bottom: none;
        }
        .admin-table tbody tr:hover {
            background: rgba(255,255,255,0.02);
        }
    </style>
</head>
<body>

<aside class="admin-sidebar">
    <a href="/index.php" class="admin-logo">Cozy<span>Admin</span></a>
    <nav class="admin-nav">
        <a href="index.php" class="<?php echo $current_page == 'index.php' ? 'active' : ''; ?>">&#128202; Dashboard</a>
        <a href="bookings.php" class="<?php echo $current_page == 'bookings.php' ? 'active' : ''; ?>">&#128197; Bookings</a>
        <a href="cars.php" class="<?php echo $current_page == 'cars.php' ? 'active' : ''; ?>">&#128663; Fleet</a>
        <a href="users.php" class="<?php echo $current_page == 'users.php' ? 'active' : ''; ?>">&#128101; Customers</a>
    </nav>
    <div style="padding: 2rem;">
        <a href="/auth/logout.php" class="btn btn-ghost" style="width: 100%; text-align: center; color: #ef4444;">&#128682; Logout</a>
    </div>
</aside>

<main class="admin-main">
    <div class="admin-topbar">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <span style="color: var(--muted); font-weight: 600;"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
            <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--primary); display: flex; align-items: center; justify-content: center; font-weight: 800;">
                <?php echo strtoupper(substr($_SESSION['user_name'], 0, 1)); ?>
            </div>
        </div>
    </div>
    <div class="admin-content">
