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
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - <?= APP_NAME ?></title>
  <link rel="icon" type="image/png" href="assets/shop.png">
  <link rel="stylesheet" href="assets/output.css">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <div class="w-full max-w-sm bg-white border border-gray-200 rounded-xl shadow p-8">
    <h2 class="text-2xl font-bold text-center text-gray-900 mb-6">Login</h2>

    <?php if (!empty($error)): ?>
      <p class="text-red-600 bg-red-50 border border-red-200 rounded-lg px-4 py-2 mb-4 text-sm text-center">
        <?= htmlspecialchars($error) ?>
      </p>
    <?php endif; ?>

    <form method="post" class="space-y-4">
      <div>
        <label class="block text-gray-700 text-sm font-medium mb-1">Username</label>
        <input type="text" name="username" required
               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-gray-900 focus:ring-2 focus:ring-blue-500 focus:outline-none">
      </div>

      <div>
        <label class="block text-gray-700 text-sm font-medium mb-1">Password</label>
        <input type="password" name="password" required
               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-gray-900 focus:ring-2 focus:ring-blue-500 focus:outline-none">
      </div>

      <button type="submit"
              class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition">
        Sign In
      </button>
    </form>

    <div class="mt-6 text-center text-sm text-gray-600">
      Don’t have an account? 
      <a href="register.php" class="text-blue-600 hover:underline font-medium">
        Register
      </a>
    </div>
  </div>

</body>
</html>
