<header>
    <div><?= APP_NAME ?></div>
    <div class="user">
        <?= $_SESSION['user']['username'] ?? 'Guest' ?> |
        <a href="logout.php" style="color:#fff;text-decoration:underline;">Logout</a>
    </div>
</header>
