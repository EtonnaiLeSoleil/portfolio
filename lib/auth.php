<?php

declare(strict_types=1);

function start_session(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        // Paramètres simples (sans sur-configuration).
        session_start();
    }
}

function is_logged_in(): bool
{
    start_session();
    return isset($_SESSION['user_id']) && is_int($_SESSION['user_id']);
}

function require_login(): void
{
    if (!is_logged_in()) {
        header('Location: login.php');
        exit;
    }
}

function login_user(int $userId): void
{
    start_session();
    session_regenerate_id(true);
    $_SESSION['user_id'] = $userId;
}

function logout_user(): void
{
    start_session();
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], (bool) $params['secure'], (bool) $params['httponly']);
    }

    session_destroy();
}
