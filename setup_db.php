<?php
require_once 'db.php';

$conn->exec("CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL,
    role TEXT NOT NULL DEFAULT 'user'
)");

$conn->exec("CREATE TABLE IF NOT EXISTS products (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    price REAL NOT NULL
)");

$conn->exec("CREATE TABLE IF NOT EXISTS purchases (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER,
    product_id INTEGER,
    created_at TEXT
)");

$count = $conn->query("SELECT COUNT(*) FROM users")->fetchColumn();
if ($count == 0) {
    $adminPass = password_hash('admin123', PASSWORD_DEFAULT);
    $userPass = password_hash('user123', PASSWORD_DEFAULT);
    $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)")->execute(['admin', $adminPass, 'admin']);
    $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)")->execute(['john', $userPass, 'user']);
}

$prodCount = $conn->query("SELECT COUNT(*) FROM products")->fetchColumn();
if ($prodCount == 0) {
    $sampleProducts = [
        ['Laptop', 49999.99],
        ['Mouse', 499.99],
        ['Keyboard', 1299.00],
        ['Headset', 899.50],
    ];
    $stmt = $conn->prepare("INSERT INTO products (name, price) VALUES (?, ?)");
    foreach ($sampleProducts as $p) {
        $stmt->execute($p);
    }
}

echo "✅ Database ready. Users: admin/admin123, john/user123";
