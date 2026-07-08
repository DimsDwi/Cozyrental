<?php 
require_once 'db.php'; 

$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if (!$name || !$email || !$password) {
        $error = 'Please fill in all fields.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        $stmt = $pdo->prepare("SELECT id FROM User WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = 'This email is already registered.';
        } else {
            $id     = bin2hex(random_bytes(16));
            $hashed = password_hash($password, PASSWORD_BCRYPT);
            $now    = date('Y-m-d H:i:s');
            $stmt   = $pdo->prepare("INSERT INTO User (id, name, email, password, role, createdAt, updatedAt) VALUES (?, ?, ?, ?, 'CUSTOMER', ?, ?)");
            try {
                $stmt->execute([$id, $name, $email, $hashed, $now, $now]);
                
                // Auto login
                $_SESSION['user_id']   = $id;
                $_SESSION['user_name'] = $name;
                $_SESSION['user_role'] = 'CUSTOMER';
                header("Location: dashboard.php");
                exit;
            } catch (Exception $e) {
                $error = 'Failed to create account. Please try again.';
            }
        }
    }
}
require_once 'header.php'; 
?>

<main style="min-height: 80vh; display: flex; align-items: center; justify-content: center; padding: 3rem 2rem;">
  <div class="auth-container" style="margin: 0; max-width: 460px;">
    <!-- Logo -->
    <div style="text-align: center; margin-bottom: 2rem;">
      <a href="index.php" class="logo" style="font-size: 1.6rem;">Cozy<span>Rental</span></a>
    </div>
    <h2>Create Account</h2>
    <p class="auth-subtitle">Join thousands of drivers. It's free.</p>

    <?php if ($error): ?>
      <div class="error-msg">&#10007; <?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
      <div class="success-msg">&#10003; <?php echo htmlspecialchars($success); ?> <a href="login.php" style="color:var(--success);font-weight:600;">Login &#8594;</a></div>
    <?php endif; ?>

    <form method="POST" action="register.php">
      <div class="form-group">
        <label for="name">Full Name</label>
        <input type="text" id="name" name="name" placeholder="John Doe" required autocomplete="name">
      </div>
      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" placeholder="john@example.com" required autocomplete="email">
      </div>
      <div class="form-group">
        <label for="password">Password <span style="color:var(--muted);font-size:0.75rem;font-weight:400;">(min. 6 characters)</span></label>
        <input type="password" id="password" name="password" placeholder="••••••••" required autocomplete="new-password">
      </div>
      <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:0.85rem;margin-top:0.5rem;font-size:0.95rem;">
        Create Free Account &#8594;
      </button>
    </form>

    <hr class="divider">
    <p style="text-align:center;font-size:0.875rem;color:var(--muted);">
      Already have an account? <a href="login.php" style="color:var(--primary-light);font-weight:600;">Sign in</a>
    </p>
  </div>
</main>

<?php require_once 'footer.php'; ?>
