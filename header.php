<header class="flex items-center justify-between bg-white text-gray-800 px-6 py-3 shadow border-b border-gray-200">
  <div class="text-xl font-bold tracking-wide text-blue-700">
    <?= APP_NAME ?>
  </div>

  <div class="flex items-center gap-3 text-sm">
    <span class="font-medium"><?= $_SESSION['user']['username'] ?? 'Guest' ?></span>

    <?php if (isset($_SESSION['user'])): ?>
      <a href="logout.php" 
         class="text-blue-600 hover:text-blue-800 underline transition duration-200">
         Logout
      </a>
    <?php endif; ?>
  </div>
</header>
