<?php
$username = $_SESSION['user']['username'] ?? 'Guest';
$role = $_SESSION['user']['role'] ?? 'guest';
?>

<h1>Welcome <?= htmlspecialchars($username) ?>!</h1>
<p>You are logged in as <b><?= htmlspecialchars($role) ?></b>.</p>

<?php if ($role === 'admin'): ?>
    <p>As admin, you can manage users and products from the sidebar.</p>
<?php elseif ($role === 'user'): ?>
    <p>As user, you can browse available products.</p>
<?php else: ?>
    <p>You are not logged in. Please <a href="login.php">login here</a>.</p>
<?php endif; ?>
