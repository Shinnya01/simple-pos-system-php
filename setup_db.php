<?php
require_once 'db.php';

// USERS TABLE
$conn->exec("CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL,
    role TEXT NOT NULL DEFAULT 'user'
)");

// PRODUCTS TABLE (no trailing comma)
$conn->exec("CREATE TABLE IF NOT EXISTS products (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    price REAL NOT NULL,
    image TEXT NULL
)");

// PURCHASES TABLE
$conn->exec("CREATE TABLE IF NOT EXISTS purchases (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER,
    product_id INTEGER,
    created_at TEXT,
    FOREIGN KEY(user_id) REFERENCES users(id),
    FOREIGN KEY(product_id) REFERENCES products(id)
)");

// ✅ Insert default users if not exist
$count = $conn->query("SELECT COUNT(*) FROM users")->fetchColumn();
if ($count == 0) {
    $adminPass = password_hash('admin123', PASSWORD_DEFAULT);
    $userPass = password_hash('user123', PASSWORD_DEFAULT);
    
    $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)")
         ->execute(['admin', $adminPass, 'admin']);
    $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)")
         ->execute(['john', $userPass, 'user']);
}

// ✅ Insert sample products if not exist
$prodCount = $conn->query("SELECT COUNT(*) FROM products")->fetchColumn();
if ($prodCount == 0) {
    $sampleProducts = [
        ['Laptop', 49999.99, null],
        ['Mouse', 499.99, null],
        ['Keyboard', 1299.00, null],
        ['Headset', 899.50, null],
    ];

    $stmt = $conn->prepare("INSERT INTO products (name, price, image) VALUES (?, ?, ?)");
    foreach ($sampleProducts as $p) {
        $stmt->execute($p);
    }
}

echo "✅ Database ready.<br>Users: <b>admin/admin123</b> and <b>john/user123</b>";
