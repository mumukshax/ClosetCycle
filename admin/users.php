<?php

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../models/User.php';

Auth::requireAdmin();

$pageTitle = 'Manage Users';
$users = User::getAll();
$success = filter_input(INPUT_GET, 'success');
$error = filter_input(INPUT_GET, 'error');

include __DIR__ . '/../views/admin/users.php';
