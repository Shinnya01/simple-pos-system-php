<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= APP_NAME ?></title>
  <link rel="icon" type="image/png" href="assets/shop.png">
  <link rel="stylesheet" href="assets/output.css">
</head>
<body class="bg-gray-50 text-gray-800 font-sans">
  <?php include 'header.php'; ?>

  <div class="flex min-h-screen">
    <?php include 'sidebar.php'; ?>
    <main class="flex-1 p-6">
      <?= $content ?>
    </main>
  </div>

  <?php include 'footer.php'; ?>
</body>
</html>
