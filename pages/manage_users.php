<?php
if (!isAdmin()) {
    echo "<h3 class='text-red-600 text-lg font-semibold'>⛔ Access denied.</h3>";
    exit;
}

// Add new user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_user'])) {
    $uname = trim($_POST['username']);
    $upass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];
    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->execute([$uname, $upass, $role]);
}

// Delete user
if (isset($_GET['delete'])) {
    $conn->prepare("DELETE FROM users WHERE id = ?")->execute([$_GET['delete']]);
}

$users = $conn->query("SELECT * FROM users ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="bg-white border border-gray-200 rounded-xl shadow p-6">
<h1 class="text-2xl font-bold text-gray-900 mb-4">👤 Manage Users</h1>

<!-- Add User -->
<form method="post" class="flex flex-wrap gap-3 mb-6">
  <input type="hidden" name="new_user" value="1">
  <input type="text" name="username" placeholder="Username" required
         class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
  <input type="password" name="password" placeholder="Password" required
         class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
  <select name="role" class="border border-gray-300 rounded-lg px-3 py-2">
    <option value="user">User</option>
    <option value="admin">Admin</option>
  </select>
  <button type="submit"
          class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
    ➕ Add
  </button>
</form>

<!-- Users Table -->
<div class="overflow-x-auto shadow rounded-lg border border-gray-200">
  <table class="w-full text-sm text-left text-gray-700">
    <thead class="text-xs text-gray-700 uppercase bg-gray-100">
      <tr>
        <th class="px-6 py-3">ID</th>
        <th class="px-6 py-3 bg-gray-50">Username</th>
        <th class="px-6 py-3">Role</th>
        <th class="px-6 py-3 bg-gray-50">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($users as $u): ?>
        <tr class="border-b border-gray-200">
          <th class="px-6 py-4 font-medium text-gray-900 bg-gray-50"><?= $u['id'] ?></th>
          <td class="px-6 py-4"><?= htmlspecialchars($u['username']) ?></td>
          <td class="px-6 py-4 bg-gray-50"><?= htmlspecialchars($u['role']) ?></td>
          <td class="px-6 py-4">
            <?php if ($u['username'] !== 'admin'): ?>
              <a href="?page=manage_users&delete=<?= $u['id'] ?>" 
                 onclick="return confirm('Delete this user?')" 
                 class="text-red-500 hover:underline">Delete</a>
            <?php else: ?>
              <span class="text-gray-400 italic">Protected</span>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

</div>
