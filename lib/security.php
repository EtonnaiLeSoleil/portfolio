<?php

declare(strict_types=1);

function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function csrf_token(): string
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (empty($_SESSION['_csrf'])) {
        $_SESSION['_csrf'] = bin2hex(random_bytes(32));
    }

    return (string) $_SESSION['_csrf'];
}

function csrf_validate(?string $token): bool
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (empty($_SESSION['_csrf']) || !is_string($_SESSION['_csrf'])) {
        return false;
    }

    return is_string($token) && hash_equals($_SESSION['_csrf'], $token);
}
