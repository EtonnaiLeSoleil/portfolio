<?php

declare(strict_types=1);

require __DIR__ . '/app/bootstrap.php';

require_login();

$pdo = db();

// Utilisateur connecté (unique admin)
$stmt = $pdo->prepare('SELECT id_user, email, job_title, bio, cv_url FROM user WHERE id_user = :id LIMIT 1');
$stmt->execute([':id' => (int) $_SESSION['user_id']]);
$currentUser = $stmt->fetch();

if (!$currentUser) {
    logout_user();
    header('Location: login.php');
    exit;
}

$notice = null;
$error = null;

$action = (string)($_POST['action'] ?? $_GET['action'] ?? '');

if ($action === 'logout') {
    logout_user();
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_validate($_POST['_csrf'] ?? null)) {
        $error = 'Requête invalide.';
    } else {
        if ($action === 'update_profile') {
            $jobTitle = trim((string)($_POST['job_title'] ?? ''));
            $bio = trim((string)($_POST['bio'] ?? ''));
            $cvUrl = trim((string)($_POST['cv_url'] ?? ''));

            if ($jobTitle === '') {
                $error = 'Le job_title est obligatoire.';
            } else {
                $stmt = $pdo->prepare('UPDATE user SET job_title = :job_title, bio = :bio, cv_url = :cv_url WHERE id_user = :id');
                $stmt->execute([
                    ':job_title' => $jobTitle,
                    ':bio' => $bio,
                    ':cv_url' => ($cvUrl === '') ? null : $cvUrl,
                    ':id' => (int) $currentUser['id_user'],
                ]);
                $notice = 'Profil mis à jour.';

                $stmt = $pdo->prepare('SELECT id_user, email, job_title, bio, cv_url FROM user WHERE id_user = :id LIMIT 1');
                $stmt->execute([':id' => (int) $_SESSION['user_id']]);
                $currentUser = $stmt->fetch();
            }
        }

        if ($action === 'create_project') {
            $title = trim((string)($_POST['title'] ?? ''));
            $description = trim((string)($_POST['description'] ?? ''));
            $linkUrl = trim((string)($_POST['link_url'] ?? ''));
            $imageUrl = trim((string)($_POST['image_url'] ?? ''));
            $skillList = trim((string)($_POST['skill_list'] ?? ''));

            if ($title === '' || $description === '' || $skillList === '') {
                $error = 'Titre, description et skill_list sont obligatoires.';
            } else {
                $stmt = $pdo->prepare('INSERT INTO project (title, description, link_url, image_url, skill_list) VALUES (:title, :description, :link_url, :image_url, :skill_list)');
                $stmt->execute([
                    ':title' => $title,
                    ':description' => $description,
                    ':link_url' => ($linkUrl === '') ? null : $linkUrl,
                    ':image_url' => ($imageUrl === '') ? null : $imageUrl,
                    ':skill_list' => $skillList,
                ]);
                $notice = 'Projet ajouté.';
            }
        }

        if ($action === 'update_project') {
            $idProject = (int)($_POST['id_project'] ?? 0);
            $title = trim((string)($_POST['title'] ?? ''));
            $description = trim((string)($_POST['description'] ?? ''));
            $linkUrl = trim((string)($_POST['link_url'] ?? ''));
            $imageUrl = trim((string)($_POST['image_url'] ?? ''));
            $skillList = trim((string)($_POST['skill_list'] ?? ''));

            if ($idProject <= 0) {
                $error = 'Projet invalide.';
            } elseif ($title === '' || $description === '' || $skillList === '') {
                $error = 'Titre, description et skill_list sont obligatoires.';
            } else {
                $stmt = $pdo->prepare('UPDATE project SET title = :title, description = :description, link_url = :link_url, image_url = :image_url, skill_list = :skill_list WHERE id_project = :id');
                $stmt->execute([
                    ':title' => $title,
                    ':description' => $description,
                    ':link_url' => ($linkUrl === '') ? null : $linkUrl,
                    ':image_url' => ($imageUrl === '') ? null : $imageUrl,
                    ':skill_list' => $skillList,
                    ':id' => $idProject,
                ]);
                $notice = 'Projet modifié.';
            }
        }

        if ($action === 'delete_project') {
            $idProject = (int)($_POST['id_project'] ?? 0);
            if ($idProject <= 0) {
                $error = 'Projet invalide.';
            } else {
                $stmt = $pdo->prepare('DELETE FROM project WHERE id_project = :id');
                $stmt->execute([':id' => $idProject]);
                $notice = 'Projet supprimé.';
            }
        }

        if ($action === 'mark_read') {
            $idMessage = (int)($_POST['id_message'] ?? 0);
            if ($idMessage <= 0) {
                $error = 'Message invalide.';
            } else {
                $stmt = $pdo->prepare('UPDATE contact_message SET is_read = 1 WHERE id_message = :id');
                $stmt->execute([':id' => $idMessage]);
                $notice = 'Message marqué comme lu.';
            }
        }
    }
}

$projects = $pdo->query('SELECT id_project, title, description, link_url, image_url, skill_list FROM project ORDER BY id_project DESC')->fetchAll();
$messages = $pdo->query('SELECT id_message, email, subject, message, is_read FROM contact_message ORDER BY id_message DESC')->fetchAll();

$editId = (int)($_GET['edit_project'] ?? 0);
$projectToEdit = null;
if ($editId > 0) {
    $stmt = $pdo->prepare('SELECT id_project, title, description, link_url, image_url, skill_list FROM project WHERE id_project = :id');
    $stmt->execute([':id' => $editId]);
    $projectToEdit = $stmt->fetch();
}

render('admin', [
    'pageTitle' => 'Admin',
    'brandTitle' => 'Admin',
    'navLinks' => [
        ['href' => 'index.php', 'label' => 'Site'],
        ['href' => 'admin.php?action=logout', 'label' => 'Déconnexion'],
    ],
    'currentUser' => $currentUser,
    'projects' => $projects,
    'messages' => $messages,
    'projectToEdit' => $projectToEdit,
    'notice' => $notice,
    'error' => $error,
]);
