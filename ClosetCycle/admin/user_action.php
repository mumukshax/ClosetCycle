<?php

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../models/User.php';

Auth::requireAdmin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . '/admin/users.php');
    exit();
}

$userID = filter_input(INPUT_POST, 'userID', FILTER_VALIDATE_INT);
$action = filter_input(INPUT_POST, 'action');

if (!$userID || !in_array($action, ['activate', 'deactivate'], true)) {
    header('Location: ' . BASE_URL . '/admin/users.php?error=invalid');
    exit();
}

$isActive = $action === 'activate' ? 1 : 0;

if (!User::setActive($userID, $isActive)) {
    header('Location: ' . BASE_URL . '/admin/users.php?error=invalid');
    exit();
}

header('Location: ' . BASE_URL . '/admin/users.php?success=updated');
exit();
