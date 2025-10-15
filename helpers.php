<?php

function isLoggedIn(): bool {
    return isset($_SESSION['user']);
}

function isAdmin(): bool {
    return isLoggedIn() && ($_SESSION['user']['role'] ?? '') === 'admin';
}

function getUser(): ?array {
    return $_SESSION['user'] ?? null;
}
