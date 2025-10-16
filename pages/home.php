<?php
$username = $_SESSION['user']['username'] ?? 'Guest';
$role = $_SESSION['user']['role'] ?? 'guest';

// Fetch products (same table as admin page)
$products = $conn->query("SELECT * FROM products ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);

// Fetch user purchases
$purchases = [];
if (isLoggedIn() && $role === 'user') {
    $stmt = $conn->prepare("
        SELECT p.id, pr.name, pr.price, p.created_at
        FROM purchases p
        JOIN products pr ON pr.id = p.product_id
        WHERE p.user_id = ?
        ORDER BY p.id DESC
    ");
    $stmt->execute([$_SESSION['user']['id']]);
    $purchases = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!-- 🏠 Welcome Section -->
<div class="bg-white rounded-xl shadow p-6 border border-gray-200 mb-6">
  <h1 class="text-3xl font-bold text-gray-900 mb-2">
    Welcome <?= htmlspecialchars($username) ?>!
  </h1>
  <p class="text-gray-700">
    <?php if ($role === 'user'): ?>
      Browse the latest products and view your purchases on the side →
    <?php elseif ($role === 'admin'): ?>
      You’re an <span class="font-semibold text-blue-600">admin</span>. Manage products in your panel.
    <?php else: ?>
      Please <a href="login.php" class="text-blue-600 hover:underline font-medium">login</a> to access your account.
    <?php endif; ?>
  </p>
</div>

<?php if ($role === 'user'): ?>
<div class="grid grid-cols-3 gap-6">
  
  <!-- 🛍️ PRODUCTS SECTION -->
  <div class="col-span-2">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">🛒 Products</h2>
    
    <?php if (empty($products)): ?>
      <p class="text-gray-600">No products available.</p>
    <?php else: ?>
      <div class="grid grid-cols-3 gap-4">
        <?php foreach ($products as $product): ?>
          <div class="bg-white border border-gray-200 rounded-xl shadow hover:shadow-lg transition p-4 flex flex-col">
            <div class="aspect-square bg-gray-100 rounded-lg mb-3 flex items-center justify-center">
              <span class="text-gray-400 text-4xl">🛍️</span>
            </div>
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
    <?php endif; ?>
  </div>

  <!-- 💰 PURCHASES SECTION -->
  <div class="col-span-1 bg-white rounded-xl shadow p-6 border border-gray-200 h-fit">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">💰 My Purchases</h2>

    <?php if (empty($purchases)): ?>
      <p class="text-gray-600">No purchases yet.</p>
    <?php else: ?>
      <div class="overflow-x-auto rounded-lg border border-gray-200">
        <table class="w-full text-sm text-left text-gray-700">
          <thead class="text-xs text-gray-700 uppercase bg-gray-100">
            <tr>
              <th class="px-4 py-2">Product</th>
              <th class="px-4 py-2 bg-gray-50">Price</th>
              <th class="px-4 py-2">Date</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($purchases as $p): ?>
              <tr class="border-b border-gray-200">
                <td class="px-4 py-2 font-medium text-gray-900 bg-gray-50"><?= htmlspecialchars($p['name']) ?></td>
                <td class="px-4 py-2 text-blue-600 font-semibold">₱<?= number_format($p['price'], 2) ?></td>
                <td class="px-4 py-2 text-gray-600"><?= date('M d, Y', strtotime($p['created_at'])) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>
</div>
<?php endif; ?>
