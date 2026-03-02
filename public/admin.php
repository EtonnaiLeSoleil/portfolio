<?php

declare(strict_types=1);

require __DIR__ . '/../app/bootstrap.php';

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
            $skillListInput = trim((string)($_POST['skill_list'] ?? ''));

            if ($title === '' || $description === '') {
                $error = 'Titre et description sont obligatoires.';
            } else {
                $pdo->beginTransaction();
                try {
                    // 1. Insert Project
                    $stmt = $pdo->prepare('INSERT INTO project (title, description, link_url, image_url) VALUES (:title, :description, :link_url, :image_url)');
                    $stmt->execute([
                        ':title' => $title,
                        ':description' => $description,
                        ':link_url' => ($linkUrl === '') ? null : $linkUrl,
                        ':image_url' => ($imageUrl === '') ? null : $imageUrl,
                    ]);
                    $projectId = (int)$pdo->lastInsertId();

                    // 2. Handle Skills
                    if ($skillListInput !== '') {
                        $skills = array_filter(array_map('trim', explode(',', $skillListInput)));
                        foreach ($skills as $skillName) {
                            // Find or Create Skill
                            $stmtSkill = $pdo->prepare('SELECT id_skill FROM skill WHERE name = :name LIMIT 1');
                            $stmtSkill->execute([':name' => $skillName]);
                            $existingSkill = $stmtSkill->fetch();

                            if ($existingSkill) {
                                $skillId = (int)$existingSkill['id_skill'];
                            } else {
                                $stmtInsertSkill = $pdo->prepare('INSERT INTO skill (name) VALUES (:name)');
                                $stmtInsertSkill->execute([':name' => $skillName]);
                                $skillId = (int)$pdo->lastInsertId();
                            }

                            // Link to Project
                            $stmtLink = $pdo->prepare('INSERT INTO project_skill (project_id, skill_id) VALUES (:pid, :sid)');
                            $stmtLink->execute([':pid' => $projectId, ':sid' => $skillId]);
                        }
                    }

                    $pdo->commit();
                    $notice = 'Projet ajouté.';
                } catch (Exception $e) {
                    $pdo->rollBack();
                    $error = 'Erreur lors de l\'ajout du projet : ' . $e->getMessage();
                }
            }
        }

        if ($action === 'update_project') {
            $idProject = (int)($_POST['id_project'] ?? 0);
            $title = trim((string)($_POST['title'] ?? ''));
            $description = trim((string)($_POST['description'] ?? ''));
            $linkUrl = trim((string)($_POST['link_url'] ?? ''));
            $imageUrl = trim((string)($_POST['image_url'] ?? ''));
            $skillListInput = trim((string)($_POST['skill_list'] ?? ''));

            if ($idProject <= 0) {
                $error = 'Projet invalide.';
            } elseif ($title === '' || $description === '') {
                $error = 'Titre et description sont obligatoires.';
            } else {
                $pdo->beginTransaction();
                try {
                    // 1. Update Project
                    $stmt = $pdo->prepare('UPDATE project SET title = :title, description = :description, link_url = :link_url, image_url = :image_url WHERE id_project = :id');
                    $stmt->execute([
                        ':title' => $title,
                        ':description' => $description,
                        ':link_url' => ($linkUrl === '') ? null : $linkUrl,
                        ':image_url' => ($imageUrl === '') ? null : $imageUrl,
                        ':id' => $idProject,
                    ]);

                    // 2. Clear existing skills for this project
                    $stmtClear = $pdo->prepare('DELETE FROM project_skill WHERE project_id = :id');
                    $stmtClear->execute([':id' => $idProject]);

                    // 3. Re-add Skills
                    if ($skillListInput !== '') {
                        $skills = array_filter(array_map('trim', explode(',', $skillListInput)));
                        foreach ($skills as $skillName) {
                             // Find or Create Skill
                             $stmtSkill = $pdo->prepare('SELECT id_skill FROM skill WHERE name = :name LIMIT 1');
                             $stmtSkill->execute([':name' => $skillName]);
                             $existingSkill = $stmtSkill->fetch();
 
                             if ($existingSkill) {
                                 $skillId = (int)$existingSkill['id_skill'];
                             } else {
                                 $stmtInsertSkill = $pdo->prepare('INSERT INTO skill (name) VALUES (:name)');
                                 $stmtInsertSkill->execute([':name' => $skillName]);
                                 $skillId = (int)$pdo->lastInsertId();
                             }
 
                             // Link to Project
                             $stmtLink = $pdo->prepare('INSERT INTO project_skill (project_id, skill_id) VALUES (:pid, :sid)');
                             $stmtLink->execute([':pid' => $idProject, ':sid' => $skillId]);
                        }
                    }
                    $pdo->commit();
                    $notice = 'Projet modifié.';
                } catch (Exception $e) {
                    $pdo->rollBack();
                    $error = 'Erreur lors de la modification : ' . $e->getMessage();
                }
            }
        }

        if ($action === 'delete_project') {
            $idProject = (int)($_POST['id_project'] ?? 0);
            if ($idProject <= 0) {
                $error = 'Projet invalide.';
            } else {
                 // Manually delete relations first (since no CASCADE in schema provided)
                 $stmt = $pdo->prepare('DELETE FROM project_skill WHERE project_id = :id');
                 $stmt->execute([':id' => $idProject]);

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

$messages = $pdo->query('SELECT id_message, email, subject, message, is_read FROM contact_message ORDER BY id_message DESC')->fetchAll();

$editId = (int)($_GET['edit_project'] ?? 0);
$projectToEdit = null;
if ($editId > 0) {
    $sqlEdit = <<<SQL
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
WHERE p.id_project = :id
GROUP BY p.id_project
SQL;
    $stmt = $pdo->prepare($sqlEdit);
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
