<?php
require_once __DIR__ . '/includes/header.php';

// Handle Add Car
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    verifyCsrfToken($_POST['csrf_token']);
    $id = bin2hex(random_bytes(16));
    $images = json_encode([$_POST['imageUrl']]); // Store as JSON array
    $specs = '{"engine": "V8", "horsepower": "500"}'; // dummy
    $features = '["Bluetooth", "Navigation"]'; // dummy
    
    $stmt = $pdo->prepare("INSERT INTO Car (id, brand, model, category, seats, transmission, fuel, pricePerDay, images, specifications, features, updatedAt) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, datetime('now'))");
    try {
        $stmt->execute([
            $id,
            $_POST['brand'],
            $_POST['model'],
            $_POST['category'],
            (int)$_POST['seats'],
            $_POST['transmission'],
            $_POST['fuel'],
            (float)$_POST['pricePerDay'],
            $images,
            $specs,
            $features
        ]);
        header("Location: cars.php?success=1");
        exit;
    } catch (PDOException $e) {
        die("DB Error: " . $e->getMessage());
    }
}

// Handle Delete Car
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    verifyCsrfToken($_POST['csrf_token']);
    $stmt = $pdo->prepare("DELETE FROM Car WHERE id = ?");
    $stmt->execute([$_POST['id']]);
    header("Location: cars.php?deleted=1");
    exit;
}

$cars = $pdo->query("SELECT * FROM Car ORDER BY brand ASC")->fetchAll();
?>

<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2rem;">
    <div>
        <h1 style="font-size: 2.2rem; font-weight: 800; letter-spacing: -1px; margin-bottom: 0.5rem;">Fleet Management</h1>
        <p style="color: var(--muted);">Add, edit, or remove vehicles from your catalog.</p>
    </div>
    <button onclick="document.getElementById('addModal').style.display='flex'" class="btn btn-primary" style="padding: 0.8rem 1.5rem;">+ Add New Vehicle</button>
</div>

<?php if(isset($_GET['success'])): ?>
    <div style="background: rgba(16,185,129,0.1); border: 1px solid #10b981; color: #10b981; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">Vehicle added successfully.</div>
<?php endif; ?>
<?php if(isset($_GET['deleted'])): ?>
    <div style="background: rgba(239,68,68,0.1); border: 1px solid #ef4444; color: #ef4444; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">Vehicle removed successfully.</div>
<?php endif; ?>

<table class="admin-table">
    <thead>
        <tr>
            <th>Vehicle</th>
            <th>Category</th>
            <th>Specs</th>
            <th>Price/Day</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($cars as $car): 
            $imgs = json_decode($car['images'], true);
            $img = is_array($imgs) && count($imgs) > 0 ? $imgs[0] : '';
        ?>
        <tr>
            <td>
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <?php if($img): ?>
                        <img src="<?php echo htmlspecialchars($img); ?>" style="width: 60px; height: 40px; object-fit: cover; border-radius: 6px;">
                    <?php else: ?>
                        <div style="width: 60px; height: 40px; background: var(--surface2); border-radius: 6px;"></div>
                    <?php endif; ?>
                    <strong style="color: white;"><?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?></strong>
                </div>
            </td>
            <td>
                <span style="background: var(--surface2); padding: 0.3rem 0.6rem; border-radius: 6px; font-size: 0.75rem; font-weight: 700;">
                    <?php echo htmlspecialchars($car['category']); ?>
                </span>
            </td>
            <td style="color: var(--muted); font-size: 0.85rem;">
                <?php echo $car['year']; ?> &bull; <?php echo $car['transmission']; ?> &bull; <?php echo $car['fuel']; ?>
            </td>
            <td style="font-weight: 800; color: var(--primary-light);">$<?php echo htmlspecialchars($car['pricePerDay']); ?></td>
            <td>
                <form method="POST" action="cars.php" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this car?');">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($car['id']); ?>">
                    <button type="submit" style="background:none;border:none;color:#ef4444;cursor:pointer;font-weight:600;">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Add Modal -->
<div id="addModal" style="display:none;position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.8);z-index:999;align-items:center;justify-content:center;backdrop-filter:blur(5px);">
    <div style="background:var(--surface);width:500px;border-radius:16px;padding:2rem;border:1px solid var(--border);">
        <div style="display:flex;justify-content:space-between;margin-bottom:1.5rem;">
            <h3 style="font-size:1.5rem;font-weight:800;margin:0;">Add Vehicle</h3>
            <button onclick="document.getElementById('addModal').style.display='none'" style="background:none;border:none;color:white;font-size:1.5rem;cursor:pointer;">&times;</button>
        </div>
        <form method="POST" action="cars.php">
            <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
            <input type="hidden" name="action" value="add">
            
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="form-group" style="margin-bottom:1rem;">
                    <label>Brand</label><input type="text" name="brand" required>
                </div>
                <div class="form-group" style="margin-bottom:1rem;">
                    <label>Model</label><input type="text" name="model" required>
                </div>
            </div>
            
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:1rem;">
                <div class="form-group" style="margin-bottom:1rem;">
                    <label>Year</label><input type="number" name="year" required>
                </div>
                <div class="form-group" style="margin-bottom:1rem;">
                    <label>Category</label><input type="text" name="category" required>
                </div>
                <div class="form-group" style="margin-bottom:1rem;">
                    <label>Price/Day</label><input type="number" name="pricePerDay" required>
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:1rem;">
                <div class="form-group" style="margin-bottom:1rem;">
                    <label>Seats</label><input type="number" name="seats" required>
                </div>
                <div class="form-group" style="margin-bottom:1rem;">
                    <label>Transmission</label>
                    <select name="transmission" style="width:100%;padding:0.7rem;background:var(--bg);border:1px solid var(--border);color:white;border-radius:8px;">
                        <option value="Automatic">Automatic</option>
                        <option value="Manual">Manual</option>
                    </select>
                </div>
                <div class="form-group" style="margin-bottom:1rem;">
                    <label>Fuel</label>
                    <select name="fuel" style="width:100%;padding:0.7rem;background:var(--bg);border:1px solid var(--border);color:white;border-radius:8px;">
                        <option value="Petrol">Petrol</option>
                        <option value="Diesel">Diesel</option>
                        <option value="Electric">Electric</option>
                        <option value="Hybrid">Hybrid</option>
                    </select>
                </div>
            </div>

            <div class="form-group" style="margin-bottom:1.5rem;">
                <label>Image URL</label><input type="url" name="imageUrl" required>
            </div>
            
            <button type="submit" class="btn btn-primary" style="width:100%;">Save Vehicle</button>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
