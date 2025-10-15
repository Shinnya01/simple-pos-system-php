<aside>
    <a href="index.php?page=home">🏠 Dashboard</a>
    <a href="index.php?page=products">🛒 Products</a>
    <?php if (isAdmin()): ?>
      <a href="index.php?page=manage_users">👤 Manage Users</a>
      <a href="index.php?page=manage_products">📦 Manage Products</a>
    <?php endif; ?>

    <?php if (isLoggedIn() && !isAdmin()): ?>
      <a href="index.php?page=my_purchases">🧾 My Purchases</a>
    <?php endif; ?>

    <a href="index.php?page=about">ℹ️ About</a>
    <a href="index.php?page=contact">📞 Contact</a>
</aside>
