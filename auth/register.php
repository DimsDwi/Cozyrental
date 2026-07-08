<?php 
require_once __DIR__ . '/../includes/db.php'; 

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
                header("Location: /user/dashboard.php");
                exit;
            } catch (Exception $e) {
                $error = 'Failed to create account. Please try again.';
            }
        }
    }
}
require_once __DIR__ . '/../includes/header.php'; 
?>

<main style="min-height: 80vh; display: flex; align-items: center; justify-content: center; padding: 3rem 2rem;">
  <div class="auth-container" style="margin: 0; max-width: 460px;">
    <!-- Logo -->
    <div style="text-align: center; margin-bottom: 2rem;">
      <a href="/index.php" class="logo" style="font-size: 1.6rem;">Cozy<span>Rental</span></a>
    </div>
    <h2>Buat Akun</h2>
    <p class="auth-subtitle">Bergabung dengan ribuan pengemudi. Gratis.</p>

    <?php if ($error): ?>
      <script>
        document.addEventListener('DOMContentLoaded', function() {
          if (window.Swal) {
            Swal.fire({
              icon: 'error',
              title: 'Pendaftaran Gagal',
              text: '<?php echo addslashes($error); ?>',
              background: '#1e1e2d',
              color: '#ffffff',
              confirmButtonColor: '#6366f1'
            });
          }
        });
      </script>
    <?php endif; ?>
    <?php if ($success): ?>
      <script>
        document.addEventListener('DOMContentLoaded', function() {
          if (window.Swal) {
            Swal.fire({
              icon: 'success',
              title: 'Pendaftaran Berhasil!',
              text: '<?php echo addslashes($success); ?>',
              background: '#1e1e2d',
              color: '#ffffff',
              confirmButtonColor: '#6366f1',
              confirmButtonText: 'Login Sekarang'
            }).then((result) => {
              if (result.isConfirmed) {
                window.location.href = '/auth/login.php';
              }
            });
          }
        });
      </script>
    <?php endif; ?>

    <form method="POST" action="/auth/register.php">
      <div class="form-group">
        <label for="name">Nama Lengkap</label>
        <input type="text" id="name" name="name" placeholder="Budi Santoso" required autocomplete="name">
      </div>
      <div class="form-group">
        <label for="email">Alamat Email</label>
        <input type="email" id="email" name="email" placeholder="budi@example.com" required autocomplete="email">
      </div>
      <div class="form-group">
        <label for="password">Kata Sandi <span style="color:var(--muted);font-size:0.75rem;font-weight:400;">(min. 6 karakter)</span></label>
        <input type="password" id="password" name="password" placeholder="••••••••" required autocomplete="new-password">
      </div>
      <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:0.85rem;margin-top:0.5rem;font-size:0.95rem;">
        Buat Akun Gratis &#8594;
      </button>
    </form>

    <hr class="divider">
    <p style="text-align:center;font-size:0.875rem;color:var(--muted);">
      Sudah punya akun? <a href="/auth/login.php" style="color:var(--primary-light);font-weight:600;">Masuk</a>
    </p>
  </div>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
