<?php
// Automated QA Test Suite for Cozy Car Rental PHP
// This script simulates User and Admin interactions.

function request($url, $method = 'GET', $data = [], $cookieJar = '') {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    
    if ($cookieJar) {
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieJar);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieJar);
    }
    
    if ($method === 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    }
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return ['code' => $httpCode, 'body' => $response];
}

$baseUrl = 'http://localhost:8000';
$cookieFile = __DIR__ . '/qa_cookie.txt';

if (file_exists($cookieFile)) { unlink($cookieFile); }

echo "====================================================\n";
echo " LIVE TESTING MODE — FULL PROJECT QA (AUTOMATED)\n";
echo "====================================================\n\n";

// 1. Register a SUPER_ADMIN (simulate DB insertion for first admin since UI restricts it)
$pdo = new PDO('sqlite:dev.db');
$adminEmail = 'admin' . time() . '@cozy.com';
$adminPass = 'admin123';
$adminId = bin2hex(random_bytes(16));
$hashed = password_hash($adminPass, PASSWORD_BCRYPT);
$pdo->exec("INSERT INTO User (id, name, email, password, role, createdAt, updatedAt) VALUES ('$adminId', 'Super Admin QA', '$adminEmail', '$hashed', 'SUPER_ADMIN', datetime('now'), datetime('now'))");
echo "[x] Initialized SUPER_ADMIN account in DB\n";

// 2. Login as SUPER_ADMIN
$loginRes = request("$baseUrl/login.php", 'POST', ['email' => $adminEmail, 'password' => $adminPass], $cookieFile);
if ($loginRes['code'] == 200 && strpos($loginRes['body'], 'Dashboard') !== false) {
    echo "[x] Login SUPER_ADMIN SUCCESS\n";
} else {
    echo "[!] Login SUPER_ADMIN FAILED. Code: " . $loginRes['code'] . "\n";
    if (preg_match('/class="error-msg">(.*?)<\/div>/s', $loginRes['body'], $errMatch)) {
        echo "    Error: " . trim(strip_tags($errMatch[1])) . "\n";
    }
}

// 3. Test Admin Dashboard Access
$adminDash = request("$baseUrl/admin/index.php", 'GET', [], $cookieFile);
if (strpos($adminDash['body'], 'Dashboard Overview') !== false) {
    echo "[x] Admin Dashboard Access SUCCESS\n";
} else {
    echo "[!] Admin Dashboard Access FAILED\n";
}

// 4. Test Car CRUD (Add)
// Fetch CSRF token
preg_match('/name="csrf_token" value="(.*?)"/', request("$baseUrl/admin/cars.php", 'GET', [], $cookieFile)['body'], $matches);
$csrf = $matches[1] ?? '';

$addCarRes = request("$baseUrl/admin/cars.php", 'POST', [
    'csrf_token' => $csrf,
    'action' => 'add',
    'brand' => 'QA_TEST',
    'model' => 'Model X',
    'year' => '2026',
    'category' => 'SUV',
    'pricePerDay' => '199',
    'seats' => '5',
    'transmission' => 'Automatic',
    'fuel' => 'Electric',
    'imageUrl' => 'https://example.com/qacar.jpg'
], $cookieFile);

if (strpos($addCarRes['body'], 'QA_TEST Model X') !== false) {
    echo "[x] Vehicle CRUD (Create) SUCCESS\n";
} else {
    // Verify directly in DB (HTTP redirect means HTML won't contain the car)
    $dbCar = $pdo->query("SELECT id FROM Car WHERE brand='QA_TEST' LIMIT 1")->fetch();
    if ($dbCar) {
        echo "[x] Vehicle CRUD (Create) SUCCESS (verified in DB)\n";
    } else {
        echo "[!] Vehicle CRUD (Create) FAILED. Code: " . $addCarRes['code'] . "\n";
        if (strpos($addCarRes['body'], 'CSRF') !== false) {
            echo "    CSRF Error detected.\n";
        }
    }
}

// 5. Test Customer Flow (Logout & Re-Register as Customer)
if (file_exists($cookieFile)) { unlink($cookieFile); } // clear session

$custEmail = 'cust' . time() . '@example.com';
$regRes = request("$baseUrl/register.php", 'POST', [
    'name' => 'QA Customer',
    'email' => $custEmail,
    'password' => 'cust123'
], $cookieFile);

if (strpos($regRes['body'], 'Dashboard') !== false) {
    echo "[x] Customer Registration SUCCESS (Auto-login verified)\n";
} else {
    echo "[!] Customer Registration FAILED\n";
}

// 6. Test Customer Booking
$fleetRes = request("$baseUrl/fleet.php", 'GET', [], $cookieFile);
preg_match('/car\.php\?id=([a-zA-Z0-9\-]+)/', $fleetRes['body'], $carMatches);
if (isset($carMatches[1])) {
    $carId = $carMatches[1];
    $bookRes = request("$baseUrl/car.php?id=$carId", 'POST', [
        'startDate' => date('Y-m-d', strtotime('+1 day')),
        'endDate' => date('Y-m-d', strtotime('+3 days')),
        'book' => '1'
    ], $cookieFile);
    if (strpos($bookRes['body'], 'Booking submitted successfully') !== false) {
        echo "[x] Customer Booking SUCCESS\n";
    } else {
        echo "[!] Customer Booking FAILED\n";
    }
}

// 7. Admin Booking Management
// Relogin as admin
if (file_exists($cookieFile)) { unlink($cookieFile); }
request("$baseUrl/login.php", 'POST', ['email' => $adminEmail, 'password' => $adminPass], $cookieFile);

// Check bookings page
$bookingsRes = request("$baseUrl/admin/bookings.php", 'GET', [], $cookieFile);
preg_match('/name="id" value="([a-zA-Z0-9\-]+)"/', $bookingsRes['body'], $bMatches);
if (isset($bMatches[1])) {
    preg_match('/name="csrf_token" value="(.*?)"/', $bookingsRes['body'], $csrfMatches);
    $bId = $bMatches[1];
    $bCsrf = $csrfMatches[1] ?? '';
    
    // Update status to ACTIVE
    $updRes = request("$baseUrl/admin/bookings.php", 'POST', [
        'csrf_token' => $bCsrf,
        'action' => 'update_status',
        'id' => $bId,
        'status' => 'ACTIVE'
    ], $cookieFile);
    
    if (strpos($updRes['body'], 'ACTIVE') !== false) {
        echo "[x] Booking CRUD (Update Status) SUCCESS\n";
    } else {
        // Verify directly in DB (redirect page won't have status in HTML)
        $bCheck = $pdo->prepare("SELECT status FROM Booking WHERE id = ?");
        $bCheck->execute([$bId]);
        $bNewStatus = $bCheck->fetchColumn();
        if ($bNewStatus === 'ACTIVE') {
            echo "[x] Booking CRUD (Update Status) SUCCESS (verified in DB)\n";
        } else {
            echo "[!] Booking CRUD (Update Status) FAILED. Code: " . $updRes['code'] . "\n";
        }
    }
} else {
    echo "[!] Booking CRUD (Update Status) FAILED. Could not find booking ID.\n";
}

// 8. Test Security: RBAC
if (file_exists($cookieFile)) { unlink($cookieFile); }
request("$baseUrl/login.php", 'POST', ['email' => $custEmail, 'password' => 'cust123'], $cookieFile);
$forbiddenRes = request("$baseUrl/admin/index.php", 'GET', [], $cookieFile);
if ($forbiddenRes['code'] === 403 || strpos($forbiddenRes['body'], '403') !== false) {
    echo "[x] RBAC Security (Customer blocked from Admin) SUCCESS\n";
} else {
    echo "[!] RBAC Security FAILED (Got HTTP {$forbiddenRes['code']})\n";
}

echo "\n====================================================\n";
echo " FULL PROJECT QA COMPLETE\n";
echo "====================================================\n";
if (file_exists($cookieFile)) { unlink($cookieFile); }
