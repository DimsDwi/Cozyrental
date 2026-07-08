<?php
require_once __DIR__ . '/../includes/header.php';

// Handle Role Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_role') {
    verifyCsrfToken($_POST['csrf_token']);
    
    // Only SUPER_ADMIN can make other admins
    if ($_POST['role'] === 'ADMIN' || $_POST['role'] === 'SUPER_ADMIN') {
        if ($_SESSION['user_role'] !== 'SUPER_ADMIN') {
            die("Only Super Admins can promote users to Admin roles.");
        }
    }
    
    $stmt = $pdo->prepare("UPDATE User SET role = ?, updatedAt = datetime('now') WHERE id = ?");
    $stmt->execute([$_POST['role'], $_POST['id']]);
    header("Location: users.php?success=1");
    exit;
}

// Fetch all users
$users = $pdo->query("SELECT * FROM User ORDER BY createdAt DESC")->fetchAll();
?>

<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2rem;">
    <div>
        <h1 style="font-size: 2.2rem; font-weight: 800; letter-spacing: -1px; margin-bottom: 0.5rem;">User Management</h1>
        <p style="color: var(--muted);">Manage customers and admin roles.</p>
    </div>
</div>

<?php if(isset($_GET['success'])): ?>
    <div style="background: rgba(16,185,129,0.1); border: 1px solid #10b981; color: #10b981; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">User role updated successfully.</div>
<?php endif; ?>

<table class="admin-table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Joined</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $u): ?>
        <tr>
            <td style="font-weight: 600; color: white;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--surface2); display: flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: 800; color: var(--muted);">
                        <?php echo strtoupper(substr($u['name'], 0, 1)); ?>
                    </div>
                    <?php echo htmlspecialchars($u['name']); ?>
                </div>
            </td>
            <td style="color: var(--muted);"><?php echo htmlspecialchars($u['email']); ?></td>
            <td style="color: var(--muted); font-size: 0.85rem;"><?php echo date('M d, Y', strtotime($u['createdAt'])); ?></td>
            <td>
                <?php if ($_SESSION['user_role'] === 'SUPER_ADMIN' && $u['id'] !== $_SESSION['user_id']): ?>
                    <form method="POST" action="users.php" style="display:flex; align-items:center;">
                        <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
                        <input type="hidden" name="action" value="update_role">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($u['id']); ?>">
                        <select name="role" onchange="this.form.submit()" style="
                            background: var(--bg); border: 1px solid var(--border); color: white; 
                            padding: 0.4rem 0.8rem; border-radius: 6px; font-weight: 700; font-size: 0.75rem;
                        ">
                            <option value="CUSTOMER" <?php if($u['role']=='CUSTOMER') echo 'selected'; ?>>CUSTOMER</option>
                            <option value="STAFF" <?php if($u['role']=='STAFF') echo 'selected'; ?>>STAFF</option>
                            <option value="ADMIN" <?php if($u['role']=='ADMIN') echo 'selected'; ?>>ADMIN</option>
                            <option value="SUPER_ADMIN" <?php if($u['role']=='SUPER_ADMIN') echo 'selected'; ?>>SUPER_ADMIN</option>
                        </select>
                    </form>
                <?php else: ?>
                    <span style="
                        background: var(--surface2); color: var(--primary-light); 
                        padding: 0.3rem 0.8rem; border-radius: 6px; font-weight: 700; font-size: 0.75rem; border: 1px solid var(--border);
                    ">
                        <?php echo htmlspecialchars($u['role']); ?>
                    </span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
