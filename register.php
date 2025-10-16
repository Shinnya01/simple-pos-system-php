<?php
session_start();
require_once 'db.php';
require_once 'config.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    // Check password match
    if ($password !== $confirm) {
        $error = "Passwords do not match.";
    } else {
        // Check if username already exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $error = "Username already taken.";
        } else {
            // Hash password and insert
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $insert = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'user')");
            if ($insert->execute([$username, $hashed])) {
                $success = "Account created successfully! You can now log in.";
            } else {
                $error = "Error creating account. Try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register - <?= APP_NAME ?></title>
  <link rel="icon" type="image/png" href="assets/shop.png">
  <link rel="stylesheet" href="assets/output.css">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <div class="w-full max-w-sm bg-white border border-gray-200 rounded-xl shadow p-8">
    <h2 class="text-2xl font-bold text-center text-gray-900 mb-6">Create Account</h2>

    <?php if (!empty($error)): ?>
      <p class="text-red-600 bg-red-50 border border-red-200 rounded-lg px-4 py-2 mb-4 text-sm text-center">
        <?= htmlspecialchars($error) ?>
      </p>
    <?php elseif (!empty($success)): ?>
      <p class="text-green-600 bg-green-50 border border-green-200 rounded-lg px-4 py-2 mb-4 text-sm text-center">
        <?= htmlspecialchars($success) ?>
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

      <div>
        <label class="block text-gray-700 text-sm font-medium mb-1">Confirm Password</label>
        <input type="password" name="confirm_password" required
               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-gray-900 focus:ring-2 focus:ring-blue-500 focus:outline-none">
      </div>

      <button type="submit"
              class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition">
        Register
      </button>
    </form>

    <div class="mt-6 text-center text-sm text-gray-600">
      Already have an account?
      <a href="login.php" class="text-blue-600 hover:underline font-medium">
        Login
      </a>
    </div>
  </div>

</body>
</html>
