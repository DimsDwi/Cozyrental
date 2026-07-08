<?php
require_once __DIR__ . '/../includes/header.php';

// Analytics queries
$totalRevenue = $pdo->query("SELECT SUM(totalPrice) FROM Booking WHERE status = 'COMPLETED' OR status = 'ACTIVE'")->fetchColumn() ?: 0;
$activeBookings = $pdo->query("SELECT COUNT(*) FROM Booking WHERE status = 'ACTIVE' OR status = 'PENDING'")->fetchColumn();
$totalUsers = $pdo->query("SELECT COUNT(*) FROM User WHERE role = 'CUSTOMER'")->fetchColumn();
$fleetSize = $pdo->query("SELECT COUNT(*) FROM Car")->fetchColumn();

// Recent bookings
$recentBookings = $pdo->query("
    SELECT b.id, b.status, b.pickupDate, b.totalPrice, u.name as customerName, c.brand, c.model 
    FROM Booking b
    JOIN User u ON b.userId = u.id
    JOIN Car c ON b.carId = c.id
    ORDER BY b.createdAt DESC LIMIT 5
")->fetchAll();
?>

<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2rem;">
    <div>
        <h1 style="font-size: 2.2rem; font-weight: 800; letter-spacing: -1px; margin-bottom: 0.5rem;">Dashboard Overview</h1>
        <p style="color: var(--muted);">Real-time analytics and system status.</p>
    </div>
</div>

<!-- Stats Grid -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;">
    <div style="background: var(--surface); border: 1px solid var(--border); border-radius: 16px; padding: 2rem;">
        <p style="color: var(--muted); font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.5rem;">Total Revenue</p>
        <p style="font-size: 2.5rem; font-weight: 900; color: #10b981;">$<?php echo number_format($totalRevenue); ?></p>
    </div>
    <div style="background: var(--surface); border: 1px solid var(--border); border-radius: 16px; padding: 2rem;">
        <p style="color: var(--muted); font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.5rem;">Active Bookings</p>
        <p style="font-size: 2.5rem; font-weight: 900; color: #06b6d4;"><?php echo number_format($activeBookings); ?></p>
    </div>
    <div style="background: var(--surface); border: 1px solid var(--border); border-radius: 16px; padding: 2rem;">
        <p style="color: var(--muted); font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.5rem;">Total Customers</p>
        <p style="font-size: 2.5rem; font-weight: 900; color: #818cf8;"><?php echo number_format($totalUsers); ?></p>
    </div>
    <div style="background: var(--surface); border: 1px solid var(--border); border-radius: 16px; padding: 2rem;">
        <p style="color: var(--muted); font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.5rem;">Fleet Size</p>
        <p style="font-size: 2.5rem; font-weight: 900; color: #f59e0b;"><?php echo number_format($fleetSize); ?></p>
    </div>
</div>

<!-- Recent Bookings -->
<h2 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 1rem;">Recent Bookings</h2>
<table class="admin-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Vehicle</th>
            <th>Pickup</th>
            <th>Total</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($recentBookings as $b): 
            $statusColor = match($b['status']) {
                'ACTIVE'    => '#06b6d4',
                'PENDING'   => '#f59e0b',
                'COMPLETED' => '#10b981',
                'CANCELLED' => '#ef4444',
                default     => '#818cf8'
            };
        ?>
        <tr>
            <td style="color: var(--muted); font-family: monospace;"><?php echo substr($b['id'], 0, 8); ?>...</td>
            <td style="font-weight: 600;"><?php echo htmlspecialchars($b['customerName']); ?></td>
            <td><?php echo htmlspecialchars($b['brand'] . ' ' . $b['model']); ?></td>
            <td><?php echo date('M d, Y', strtotime($b['pickupDate'])); ?></td>
            <td style="font-weight: 800; color: white;">$<?php echo number_format($b['totalPrice']); ?></td>
            <td>
                <span style="background: <?php echo $statusColor; ?>22; color: <?php echo $statusColor; ?>; padding: 0.2rem 0.6rem; border-radius: 6px; font-size: 0.75rem; font-weight: 700;">
                    <?php echo htmlspecialchars($b['status']); ?>
                </span>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
