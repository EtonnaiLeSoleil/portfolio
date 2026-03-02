<?php

declare(strict_types=1);

require __DIR__ . '/app/bootstrap.php';

$pdo = db();

// Profil (un seul admin)
$user = $pdo->query('SELECT job_title, bio, cv_url FROM user ORDER BY id_user ASC LIMIT 1')->fetch();

// Projets
$sqlProjects = <<<SQL
SELECT
    p.id_project,
    p.title,
    p.description,
    p.link_url,
    p.image_url,
    GROUP_CONCAT(s.name SEPARATOR ',') AS skill_list
FROM project p
LEFT JOIN project_skill ps ON p.id_project = ps.project_id
LEFT JOIN skill s ON ps.skill_id = s.id_skill
GROUP BY p.id_project
ORDER BY p.id_project DESC
SQL;
$projects = $pdo->query($sqlProjects)->fetchAll();

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
