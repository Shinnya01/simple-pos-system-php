<?php
if (!isLoggedIn()) {
    echo '<div class="bg-red-50 text-red-700 border border-red-200 rounded-lg p-4">
            ⚠️ Please login to view your purchases.
          </div>';
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

<h1 class="text-2xl font-bold text-gray-900 mb-4">💰 My Purchases</h1>

<?php if (empty($purchases)): ?>
  <p class="text-gray-600">No purchases yet.</p>
<?php else: ?>
  <div class="overflow-x-auto shadow rounded-lg border border-gray-200">
    <table class="w-full text-sm text-left text-gray-700">
      <thead class="text-xs text-gray-700 uppercase bg-gray-100">
        <tr>
          <th class="px-6 py-3">ID</th>
          <th class="px-6 py-3 bg-gray-50">Product</th>
          <th class="px-6 py-3">Price</th>
          <th class="px-6 py-3 bg-gray-50">Date</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($purchases as $p): ?>
          <tr class="border-b border-gray-200">
            <th class="px-6 py-4 font-medium text-gray-900 bg-gray-50"><?= $p['id'] ?></th>
            <td class="px-6 py-4"><?= htmlspecialchars($p['name']) ?></td>
            <td class="px-6 py-4 bg-gray-50">₱<?= number_format($p['price'], 2) ?></td>
            <td class="px-6 py-4"><?= $p['created_at'] ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>
