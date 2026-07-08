<?php
require_once 'header.php';

// Handle Update Status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_status') {
    verifyCsrfToken($_POST['csrf_token']);
    $stmt = $pdo->prepare("UPDATE Booking SET status = ?, updatedAt = datetime('now') WHERE id = ?");
    $stmt->execute([$_POST['status'], $_POST['id']]);
    header("Location: bookings.php?success=1");
    exit;
}

// Fetch all bookings
$bookings = $pdo->query("
    SELECT b.*, u.name as customerName, u.email as customerEmail, c.brand, c.model 
    FROM Booking b
    JOIN User u ON b.userId = u.id
    JOIN Car c ON b.carId = c.id
    ORDER BY b.createdAt DESC
")->fetchAll();
?>

<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2rem;">
    <div>
        <h1 style="font-size: 2.2rem; font-weight: 800; letter-spacing: -1px; margin-bottom: 0.5rem;">Booking Management</h1>
        <p style="color: var(--muted);">View and update all customer reservations.</p>
    </div>
</div>

<?php if(isset($_GET['success'])): ?>
    <div style="background: rgba(16,185,129,0.1); border: 1px solid #10b981; color: #10b981; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">Booking status updated successfully.</div>
<?php endif; ?>

<table class="admin-table">
    <thead>
        <tr>
            <th>ID / Date</th>
            <th>Customer</th>
            <th>Vehicle</th>
            <th>Duration</th>
            <th>Total Price</th>
            <th>Status / Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($bookings as $b): ?>
        <tr>
            <td>
                <div style="font-family: monospace; font-size: 0.85rem; color: var(--primary-light);"><?php echo substr($b['id'], 0, 8); ?></div>
                <div style="font-size: 0.75rem; color: var(--muted);"><?php echo date('Y-m-d H:i', strtotime($b['createdAt'])); ?></div>
            </td>
            <td>
                <div style="font-weight: 600; color: white;"><?php echo htmlspecialchars($b['customerName']); ?></div>
                <div style="font-size: 0.75rem; color: var(--muted);"><?php echo htmlspecialchars($b['customerEmail']); ?></div>
            </td>
            <td style="color: white; font-weight: 600;">
                <?php echo htmlspecialchars($b['brand'] . ' ' . $b['model']); ?>
            </td>
            <td style="color: var(--muted); font-size: 0.85rem;">
                <?php echo date('M d', strtotime($b['pickupDate'])); ?> &rarr; <?php echo date('M d', strtotime($b['returnDate'])); ?>
            </td>
            <td style="font-weight: 800; color: white;">
                $<?php echo number_format($b['totalPrice']); ?>
            </td>
            <td>
                <form method="POST" action="bookings.php" style="display:flex; gap:0.5rem; align-items:center;">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
                    <input type="hidden" name="action" value="update_status">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($b['id']); ?>">
                    <select name="status" onchange="this.form.submit()" style="
                        background: var(--bg); border: 1px solid var(--border); color: white; 
                        padding: 0.4rem 0.8rem; border-radius: 6px; font-weight: 700; font-size: 0.75rem;
                        <?php 
                            echo match($b['status']) {
                                'ACTIVE'    => 'border-color: #06b6d4; color: #06b6d4;',
                                'PENDING'   => 'border-color: #f59e0b; color: #f59e0b;',
                                'COMPLETED' => 'border-color: #10b981; color: #10b981;',
                                'CANCELLED' => 'border-color: #ef4444; color: #ef4444;',
                                default     => ''
                            };
                        ?>
                    ">
                        <option value="PENDING" <?php if($b['status']=='PENDING') echo 'selected'; ?>>PENDING</option>
                        <option value="ACTIVE" <?php if($b['status']=='ACTIVE') echo 'selected'; ?>>ACTIVE</option>
                        <option value="COMPLETED" <?php if($b['status']=='COMPLETED') echo 'selected'; ?>>COMPLETED</option>
                        <option value="CANCELLED" <?php if($b['status']=='CANCELLED') echo 'selected'; ?>>CANCELLED</option>
                    </select>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once 'footer.php'; ?>
