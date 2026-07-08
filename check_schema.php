<?php
$pdo = new PDO('sqlite:dev.db');
$stmt = $pdo->query("PRAGMA table_info(Booking)");
echo "=== Booking ===\n";
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $col) {
    echo $col['name'] . "\n";
}
$stmt2 = $pdo->query("PRAGMA table_info(User)");
echo "\n=== User ===\n";
foreach ($stmt2->fetchAll(PDO::FETCH_ASSOC) as $col) {
    echo $col['name'] . "\n";
}
