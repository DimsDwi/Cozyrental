<?php
session_start();

$dbFile = __DIR__ . '/../dev.db';

try {
    $pdo = new PDO("sqlite:$dbFile");
    // Set errormode to exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Set default fetch mode to associative arrays
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Helper functions for Auth
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        // Works from any subfolder
        $base = rtrim(dirname($_SERVER['PHP_SELF']), '/admin');
        header("Location: /auth/login.php");
        exit;
    }
}

// RBAC Middleware
function requireAdmin() {
    if (!isLoggedIn()) {
        header("Location: /auth/login.php");
        exit;
    }
    if ($_SESSION['user_role'] !== 'ADMIN' && $_SESSION['user_role'] !== 'SUPER_ADMIN') {
        http_response_code(403);
        die("<html><body style='background:#0a0a0f;color:white;font-family:sans-serif;display:flex;align-items:center;justify-content:center;height:100vh;margin:0;'><div style='text-align:center'><h1 style='font-size:5rem;margin:0;color:#6366f1;'>403</h1><p style='font-size:1.2rem;color:#999;'>You do not have permission to access this area.</p><a href='/' style='color:#818cf8;'>← Back to Home</a></div></body></html>");
    }
}

// CSRF Protection
function generateCsrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCsrfToken($token) {
    if (empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
        die("CSRF token validation failed.");
    }
}
?>
