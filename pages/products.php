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
  <p class="text-gray-600">No products available.</p>
<?php else: ?>
  <div class="flex-1 overflow-auto"> <!-- Make this container scrollable -->
    <div class="grid grid-cols-3 gap-4">
      <?php foreach ($products as $product): ?>
        <div class="bg-white border border-gray-200 rounded-xl shadow hover:shadow-lg transition p-4 flex flex-col ">
          <?php if($product['image']): ?>
          <img src="pages/<?= htmlspecialchars($product['image']) ?>" class="aspect-square bg-gray-100 rounded-lg mb-3 flex items-center justify-center" alt="Product Image">
          <?php else: ?>
          <div class="aspect-square bg-gray-100 rounded-lg mb-3 flex items-center justify-center">
            <span class="text-gray-400 text-4xl">🛍️</span>
          </div>
          <?php endif; ?>
          <h3 class="font-semibold text-gray-900 text-lg mb-1"><?= htmlspecialchars($product['name']) ?></h3>
          <p class="text-blue-600 font-bold mb-3">₱<?= number_format($product['price'], 2) ?></p>
          <form method="post" action="buy.php" class="mt-auto">
            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
            <button type="submit" 
              class="w-full bg-orange-500 hover:bg-orange-600 text-white font-medium py-2 rounded-lg transition">
              🛒 Buy Now
            </button>
          </form>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
<?php endif; ?>
