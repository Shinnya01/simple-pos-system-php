<?php
session_start();
require_once 'db.php';
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['username']);
    $pass = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$user]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && password_verify($pass, $row['password'])) {
    $_SESSION['user'] = [
        'id' => $row['id'],            // ✅ add this line
        'username' => $row['username'],
        'role' => $row['role']
    ];
    header('Location: index.php?page=home');
    exit;
    } else {
        $error = "Invalid credentials.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - <?= APP_NAME ?></title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="icon" type="image/png" href="/assets/shop.png">

</head>
<body>
    <div class="login-container">
        <form method="post" class="login-box">
            <h2>Login</h2>
            <?php if (!empty($error)): ?>
                <p class="error"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
