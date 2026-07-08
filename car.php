<?php 
require_once 'header.php'; 

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "<main class='container'><h2>Car not found</h2></main>";
    require_once 'footer.php';
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM Car WHERE id = ?");
$stmt->execute([$id]);
$car = $stmt->fetch();

if (!$car) {
    echo "<main class='container'><h2>Car not found</h2></main>";
    require_once 'footer.php';
    exit;
}

$images = json_decode($car['images'], true);
$imgUrl = is_array($images) && count($images) > 0 ? $images[0] : '';
$features = json_decode($car['features'], true);

// Booking form handling
$bookingSuccess = false;
$bookingError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book'])) {
    if (!isLoggedIn()) {
        $bookingError = 'You must be logged in to book a vehicle.';
    } else {
        $startDate = $_POST['startDate'] ?? '';
        $endDate = $_POST['endDate'] ?? '';
        if ($startDate && $endDate) {
            // Calculate days
            $start = new DateTime($startDate);
            $end = new DateTime($endDate);
            $days = max(1, $end->diff($start)->days);
            $totalAmount = $days * $car['pricePerDay'];

            $bookingId = bin2hex(random_bytes(16));
            $bStmt = $pdo->prepare(
                "INSERT INTO Booking (id, userId, carId, pickupLocation, returnLocation, pickupDate, returnDate, status, insuranceOption, extras, totalPrice, paymentStatus, createdAt, updatedAt) 
                 VALUES (?, ?, ?, 'HQ', 'HQ', ?, ?, 'PENDING', 'Basic', '[]', ?, 'PENDING', datetime('now'), datetime('now'))"
            );
            try {
                $bStmt->execute([$bookingId, $_SESSION['user_id'], $car['id'], $startDate, $endDate, $totalAmount]);
                $bookingSuccess = true;
            } catch (Exception $e) {
                $bookingError = 'Booking failed: ' . $e->getMessage();
            }
        } else {
            $bookingError = 'Please select start and end dates.';
        }
    }
}
?>

<main class="container">
  <?php if ($bookingSuccess): ?>
    <div class="success-msg" style="margin-bottom: 2rem;">✓ Booking submitted successfully! <a href="dashboard.php" style="color:var(--primary)">View in Dashboard</a></div>
  <?php endif; ?>
  <?php if ($bookingError): ?>
    <div class="error-msg" style="margin-bottom: 2rem;"><?php echo htmlspecialchars($bookingError); ?></div>
  <?php endif; ?>

  <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; margin-top: 2rem; align-items: start;">
    <div>
      <?php if($imgUrl): ?>
        <img src="<?php echo htmlspecialchars($imgUrl); ?>" alt="Car Image" style="width: 100%; border-radius: 16px; border: 1px solid var(--surface-border);">
      <?php else: ?>
        <div style="width:100%;height:280px;background:var(--surface);border-radius:16px;border:1px solid var(--surface-border);display:flex;align-items:center;justify-content:center;color:var(--text-muted);">No Image</div>
      <?php endif; ?>
      
      <?php if(is_array($features) && count($features) > 0): ?>
      <h3 style="margin-top: 2rem; margin-bottom: 1rem;">Features</h3>
      <ul style="list-style: inside; color: var(--text-muted); line-height: 2;">
        <?php foreach($features as $feature): ?>
          <li><?php echo htmlspecialchars($feature); ?></li>
        <?php endforeach; ?>
      </ul>
      <?php endif; ?>
    </div>
    
    <div>
      <h1 style="font-size: 2.5rem; margin-bottom: 0.5rem;"><?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?></h1>
      <p style="color: var(--text-muted); font-size: 1.1rem; margin-bottom: 1rem;">
        <?php echo htmlspecialchars($car['category'] . ' • ' . ucfirst(strtolower($car['transmission'])) . ' • ' . $car['seats'] . ' Seats • ' . $car['fuel']); ?>
      </p>
      
      <div style="font-size: 2rem; color: var(--primary); font-weight: bold; margin-bottom: 2rem;">
        $<?php echo htmlspecialchars($car['pricePerDay']); ?> <span style="font-size: 1rem; color: var(--text-muted); font-weight: normal;">/ day</span>
      </div>

      <div class="auth-container" style="margin: 0; max-width: 100%;">
        <h3>Book This Vehicle</h3>
        <?php if (isLoggedIn()): ?>
          <form method="POST" style="margin-top: 1rem;">
            <div class="form-group">
              <label>Start Date</label>
              <input type="date" name="startDate" min="<?php echo date('Y-m-d'); ?>" required>
            </div>
            <div class="form-group">
              <label>End Date</label>
              <input type="date" name="endDate" min="<?php echo date('Y-m-d'); ?>" required>
            </div>
            <button type="submit" name="book" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 1.25rem; font-size: 1.15rem; font-weight: 800; letter-spacing: 0.05em; text-transform: uppercase; margin-top: 1rem; box-shadow: 0 10px 30px rgba(99,102,241,0.4); border-radius: 14px;">
              &#10024; Confirm Booking
            </button>
          </form>
        <?php else: ?>
          <p style="margin-top: 1rem; color: var(--text-muted);">Please log in to book this vehicle.</p>
          <a href="login.php" class="btn-primary" style="margin-top: 1rem; display: inline-block;">Log In to Book</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</main>

<?php require_once 'footer.php'; ?>
