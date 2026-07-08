<?php
try {
    $p = new PDO('sqlite::memory:');
    echo 'PDO SQLite OK';
} catch (Exception $e) {
    echo 'FAIL: ' . $e->getMessage();
}
