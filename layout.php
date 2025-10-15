<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= APP_NAME ?></title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="icon" type="image/png" href="assets/shop.png">
     <link rel="icon" type="image/png" href="/assets/shop.png">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <?php include 'sidebar.php'; ?>
        <main>
            <?= $content ?>
        </main>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
