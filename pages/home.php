<?php
$username = $_SESSION['user']['username'] ?? 'Guest';
$role = $_SESSION['user']['role'] ?? 'guest';
?>

<div class="bg-white rounded-xl shadow p-6 border border-gray-200">
  <h1 class="text-3xl font-bold text-gray-900 mb-2">
    Welcome <?= htmlspecialchars($username) ?>!
  </h1>
  
  <p class="text-gray-700 mb-4">
    You are logged in as 
    <b class="font-semibold text-blue-600"><?= htmlspecialchars($role) ?></b>.
  </p>

  <?php if ($role === 'admin'): ?>
    <p class="text-gray-700">
      As <span class="font-semibold text-blue-600">admin</span>, you can manage users and products from the sidebar.
    </p>
  <?php elseif ($role === 'user'): ?>
    <p class="text-gray-700">
      As <span class="font-semibold text-green-600">user</span>, you can browse available products.
    </p>
  <?php else: ?>
    <p class="text-gray-700">
      You are not logged in. Please 
      <a href="login.php" class="text-blue-600 hover:underline font-medium">login here</a>.
    </p>
  <?php endif; ?>
</div>
