<?php

declare(strict_types=1);

require __DIR__ . '/app/bootstrap.php';

$pdo = db();

// Profil (un seul admin)
$user = $pdo->query('SELECT job_title, bio, cv_url FROM user ORDER BY id_user ASC LIMIT 1')->fetch();

// Projets
$projects = $pdo->query('SELECT id_project, title, description, link_url, image_url, skill_list FROM project ORDER BY id_project DESC')->fetchAll();

$notice = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim((string)($_POST['email'] ?? ''));
    $subject = trim((string)($_POST['subject'] ?? ''));
    $message = trim((string)($_POST['message'] ?? ''));

    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email invalide.';
    } elseif ($subject === '') {
        $error = 'Sujet obligatoire.';
    } elseif ($message === '') {
        $error = 'Message obligatoire.';
    } else {
        $stmt = $pdo->prepare('INSERT INTO contact_message (email, subject, message, is_read) VALUES (:email, :subject, :message, 0)');
        $stmt->execute([
            ':email' => $email,
            ':subject' => $subject,
            ':message' => $message,
        ]);
        $notice = 'Message envoyé.';
    }
}
render('home', [
    'pageTitle' => 'Portfolio',
    'brandTitle' => 'Portfolio',
    'navLinks' => [
        ['href' => '#profil', 'label' => 'Profil'],
        ['href' => '#projets', 'label' => 'Projets'],
        ['href' => '#contact', 'label' => 'Contact'],
    ],
    'user' => $user ?: null,
    'projects' => $projects,
    'notice' => $notice,
    'error' => $error,
]);
