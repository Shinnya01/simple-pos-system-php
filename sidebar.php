<aside class="w-60 bg-white border-r border-gray-200 p-4 flex flex-col gap-2">
  <a href="index.php?page=home" class="block px-3 py-2 rounded-lg hover:bg-blue-100 text-gray-700 font-medium">🏠 Dashboard</a>
  <a href="index.php?page=products" class="block px-3 py-2 rounded-lg hover:bg-blue-100 text-gray-700 font-medium">🛒 Products</a>

  <?php if (isAdmin()): ?>
    <a href="index.php?page=manage_users" class="block px-3 py-2 rounded-lg hover:bg-blue-100 text-gray-700 font-medium">👤 Manage Users</a>
    <a href="index.php?page=manage_products" class="block px-3 py-2 rounded-lg hover:bg-blue-100 text-gray-700 font-medium">📦 Manage Products</a>
  <?php endif; ?>

  <?php if (isLoggedIn() && !isAdmin()): ?>
    <a href="index.php?page=my_purchases" class="block px-3 py-2 rounded-lg hover:bg-blue-100 text-gray-700 font-medium">🧾 My Purchases</a>
  <?php endif; ?>

  <a href="index.php?page=about" class="block px-3 py-2 rounded-lg hover:bg-blue-100 text-gray-700 font-medium">ℹ️ About</a>
  <a href="index.php?page=contact" class="block px-3 py-2 rounded-lg hover:bg-blue-100 text-gray-700 font-medium">📞 Contact</a>
</aside>
