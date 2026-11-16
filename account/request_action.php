<?php

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../models/BorrowRequest.php';

Auth::requireLogin();

$currentUser = Auth::user();
$ownerID = (int) $currentUser['userID'];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . '/account/received_requests.php');
    exit();
}

$requestID = filter_input(INPUT_POST, 'requestID', FILTER_VALIDATE_INT);
$action = filter_input(INPUT_POST, 'action');
$allowedActions = ['approve', 'decline', 'borrowed', 'returned'];

if (!$requestID || !in_array($action, $allowedActions, true)) {
    header('Location: ' . BASE_URL . '/account/received_requests.php');
    exit();
}

$request = BorrowRequest::getForOwnerById($requestID, $ownerID);

if (!$request) {
    header('Location: ' . BASE_URL . '/account/received_requests.php?error=not_allowed');
    exit();
}

$changed = false;
$success = '';

if ($action === 'approve') {
    $changed = BorrowRequest::approve($requestID, $ownerID);
    $success = 'approved';
} elseif ($action === 'decline') {
    $changed = BorrowRequest::decline($requestID, $ownerID);
    $success = 'declined';
} elseif ($action === 'borrowed') {
    $changed = BorrowRequest::markBorrowed($requestID, $ownerID);
    $success = 'borrowed';
} elseif ($action === 'returned') {
    $changed = BorrowRequest::markReturned($requestID, $ownerID);
    $success = 'returned';
}

if (!$changed) {
    header('Location: ' . BASE_URL . '/account/received_requests.php?error=invalid_status');
    exit();
}

header('Location: ' . BASE_URL . '/account/received_requests.php?success=' . $success);
exit();
