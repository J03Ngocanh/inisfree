<?php
/**
 * One-time migration: update payment_method from Vietnamese to English.
 * Run: php migrate_payment_method.php
 */
require_once __DIR__ . '/config.php';

$con = new mysqli(
    $_ENV['DATABASE_HOST'],
    $_ENV['DATABASE_USER'],
    $_ENV['DATABASE_PASS'],
    $_ENV['DATABASE_NAME'],
    $_ENV['DATABASE_PORT'] ?? 3306
);
$con->set_charset("utf8mb4");

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$updates = [
    "UPDATE cart SET payment_method = 'cash' WHERE payment_method = 'tien_mat'" => 'cart: tien_mat → cash',
    "UPDATE cart SET payment_method = 'bank_transfer' WHERE payment_method = 'chuyen_khoan'" => 'cart: chuyen_khoan → bank_transfer',
    "UPDATE orders SET payment_method = 'cash' WHERE payment_method = 'tien_mat'" => 'orders: tien_mat → cash',
    "UPDATE orders SET payment_method = 'bank_transfer' WHERE payment_method = 'chuyen_khoan'" => 'orders: chuyen_khoan → bank_transfer',
];

foreach ($updates as $sql => $label) {
    try {
        $ok = $con->query($sql);
        if ($ok) {
            $affected = $con->affected_rows;
            echo "[OK] $label — $affected row(s) affected\n";
        } else {
            echo "[SKIP] $label — " . $con->error . "\n";
        }
    } catch (mysqli_sql_exception $e) {
        if (strpos($e->getMessage(), "doesn't exist") !== false) {
            echo "[SKIP] $label — table not present\n";
        } else {
            echo "[SKIP] $label — " . $e->getMessage() . "\n";
        }
    }
}

$con->close();
echo "Done.\n";
