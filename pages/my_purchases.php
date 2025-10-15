<?php
if (!isLoggedIn()) {
    echo "<p>Please login to view your purchases.</p>";
    exit;
}

$stmt = $conn->prepare("
    SELECT p.id, pr.name, pr.price, p.created_at
    FROM purchases p
    JOIN products pr ON pr.id = p.product_id
    WHERE p.user_id = ?
    ORDER BY p.id ASC
");
$stmt->execute([$_SESSION['user']['id']]);
$purchases = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>🧾 My Purchases</h1>

<?php if (empty($purchases)): ?>
    <p>No purchases yet.</p>
<?php else: ?>
<table>
    <tr><th>ID</th><th>Product</th><th>Price</th><th>Date</th></tr>
    <?php foreach ($purchases as $p): ?>
        <tr>
            <td><?= $p['id'] ?></td>
            <td><?= htmlspecialchars($p['name']) ?></td>
            <td>₱<?= number_format($p['price'], 2) ?></td>
            <td><?= $p['created_at'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<?php endif; ?>
