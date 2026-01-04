<?php

declare(strict_types=1);

require __DIR__ . '/app/bootstrap.php';

start_session();

if (is_logged_in()) {
    header('Location: admin.php');
    exit;
}

$pdo = db();

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_validate($_POST['_csrf'] ?? null)) {
        $error = 'Requête invalide.';
    } else {
        $email = trim((string)($_POST['email'] ?? ''));
        $password = (string)($_POST['password'] ?? '');

        $stmt = $pdo->prepare('SELECT id_user, email, password_hash FROM user WHERE email = :email LIMIT 1');
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, (string) $user['password_hash'])) {
            $error = 'Identifiants invalides.';
        } else {
            login_user((int) $user['id_user']);
            header('Location: admin.php');
            exit;
        }
    }
}

render('login', [
    'pageTitle' => 'Connexion',
    'brandTitle' => 'Admin',
    'navLinks' => [
        ['href' => 'index.php', 'label' => 'Retour'],
    ],
    'error' => $error,
]);
