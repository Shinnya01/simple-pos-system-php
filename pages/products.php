<?php
$stmt = $conn->query("SELECT * FROM products ORDER BY id DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isLoggedIn() && isset($_GET['buy'])) {
    $product_id = (int) $_GET['buy'];
    $stmt = $conn->prepare("INSERT INTO purchases (user_id, product_id, created_at) VALUES (?, ?, datetime('now'))");
    $stmt->execute([$_SESSION['user']['id'], $product_id]);
    echo "<div class='alert success'>✅ You bought this product successfully!</div>";
}

$products = $conn->query("SELECT * FROM products ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);

?>
<h1>🛍️ Products</h1>
<table>
    <tr><th>ID</th><th>Name</th><th>Price</th><th>Action</th></tr>
    <?php foreach ($products as $p): ?>
        <tr>
            <td><?= $p['id'] ?></td>
            <td><?= htmlspecialchars($p['name']) ?></td>
            <td>₱<?= number_format($p['price'], 2) ?></td>
            <td>
                <?php if (isLoggedIn() && !isAdmin()): ?>
                    <a href="?page=products&buy=<?= $p['id'] ?>" onclick="return confirm('Buy this product?')">🛒 Buy</a>
                <?php elseif (!isLoggedIn()): ?>
                    <em>Please login to buy</em>
                <?php else: ?>
                    <em>Admin only manages</em>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>