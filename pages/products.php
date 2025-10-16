<?php
$stmt = $conn->query("SELECT * FROM products ORDER BY id DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle product purchase
if (isLoggedIn() && isset($_GET['buy'])) {
    $product_id = (int) $_GET['buy'];
    $stmt = $conn->prepare("INSERT INTO purchases (user_id, product_id, created_at) VALUES (?, ?, datetime('now'))");
    $stmt->execute([$_SESSION['user']['id'], $product_id]);

    echo "<div class='bg-green-50 border border-green-200 text-green-700 rounded-lg p-4 mb-4'>
            ✅ You bought this product successfully!
          </div>";
}

$products = $conn->query("SELECT * FROM products ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<h1 class="text-3xl font-bold text-gray-800 mb-6">🛍️ Products</h1>

<?php if (empty($products)): ?>
  <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 rounded-lg p-4">
    No products available at the moment.
  </div>
<?php else: ?>
  <div class="overflow-x-auto bg-white rounded-lg shadow border border-gray-200">
    <table class="min-w-full text-left text-sm text-gray-700">
      <thead class="bg-gray-100 border-b">
        <tr>
          <th class="py-3 px-4 font-semibold">ID</th>
          <th class="py-3 px-4 font-semibold">Name</th>
          <th class="py-3 px-4 font-semibold">Price</th>
          <th class="py-3 px-4 font-semibold text-center">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($products as $p): ?>
          <tr class="border-b hover:bg-gray-50 transition">
            <td class="py-3 px-4"><?= $p['id'] ?></td>
            <td class="py-3 px-4"><?= htmlspecialchars($p['name']) ?></td>
            <td class="py-3 px-4 font-medium text-green-600">₱<?= number_format($p['price'], 2) ?></td>
            <td class="py-3 px-4 text-center">
              <?php if (isLoggedIn() && !isAdmin()): ?>
                <a href="?page=products&buy=<?= $p['id'] ?>"
                   onclick="return confirm('Buy this product?')"
                   class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition">
                  🛒 Buy
                </a>
              <?php elseif (!isLoggedIn()): ?>
                <span class="text-gray-500 italic">Please login to buy</span>
              <?php else: ?>
                <span class="text-gray-500 italic">Admin only manages</span>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>
