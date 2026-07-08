<?php 
require_once __DIR__ . '/../includes/db.php'; 

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if (empty($email) || empty($password)) {
        $error = 'Please fill in all fields.';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM User WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];
            $redirect = $_GET['redirect'] ?? '/user/dashboard.php';
            header("Location: " . $redirect);
            exit;
        } else {
            $error = 'Invalid email or password.';
        }
    }
}
require_once __DIR__ . '/../includes/header.php'; 
?>

<main style="min-height: 80vh; display: flex; align-items: center; justify-content: center; padding: 3rem 2rem;">
  <div class="auth-container" style="margin: 0;">
    <!-- Logo -->
    <div style="text-align: center; margin-bottom: 2rem;">
      <a href="/index.php" class="logo" style="font-size: 1.6rem;">Cozy<span>Rental</span></a>
    </div>
    <h2>Selamat Datang Kembali</h2>
    <p class="auth-subtitle">Masuk untuk mengelola pemesanan Anda</p>

    <?php if ($error): ?>
      <div class="error-msg">&#10007; <?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="/auth/login.php">
      <div class="form-group">
        <label for="email">Alamat Email</label>
        <input type="email" id="email" name="email" placeholder="john@example.com" required autocomplete="email">
      </div>
      <div class="form-group">
        <label for="password">Kata Sandi</label>
        <input type="password" id="password" name="password" placeholder="••••••••" required autocomplete="current-password">
      </div>
      <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:0.85rem;margin-top:0.5rem;font-size:0.95rem;">
        Masuk &#8594;
      </button>
    </form>

    <hr class="divider">

    <p style="text-align:center;font-size:0.875rem;color:var(--muted);">
      Belum punya akun? <a href="/auth/register.php" style="color:var(--primary-light);font-weight:600;">Daftar gratis</a>
    </p>
  </div>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
