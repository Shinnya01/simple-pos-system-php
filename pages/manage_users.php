<?php
if (!isAdmin()) {
    echo "<h3>⛔ Access denied.</h3>";
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

$users = $conn->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);
?>
<h1>👤 Manage Users</h1>

<form method="post">
    <input type="hidden" name="new_user" value="1">
    <input type="text" name="username" placeholder="New username" required>
    <input type="password" name="password" placeholder="Password" required>
    <select name="role">
        <option value="user">User</option>
        <option value="admin">Admin</option>
    </select>
    <button type="submit">Add</button>
</form>

<table>
    <tr><th>ID</th><th>Username</th><th>Role</th><th>Action</th></tr>
    <?php foreach ($users as $u): ?>
        <tr>
            <td><?= $u['id'] ?></td>
            <td><?= htmlspecialchars($u['username']) ?></td>
            <td><?= $u['role'] ?></td>
            <td>
                <?php if ($u['username'] !== 'admin'): ?>
                    <a href="?page=manage_users&delete=<?= $u['id'] ?>" onclick="return confirm('Delete user?')">Delete</a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
