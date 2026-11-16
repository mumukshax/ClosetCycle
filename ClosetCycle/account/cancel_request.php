<?php

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../models/BorrowRequest.php';

Auth::requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . '/account/requests.php');
    exit();
}

$currentUser = Auth::user();
$borrowerID = (int) $currentUser['userID'];
$requestID = filter_input(INPUT_POST, 'requestID', FILTER_VALIDATE_INT);

if (!$requestID) {
    header('Location: ' . BASE_URL . '/account/requests.php');
    exit();
}

if (!BorrowRequest::cancel($requestID, $borrowerID)) {
    header('Location: ' . BASE_URL . '/account/requests.php?error=cannot_cancel');
    exit();
}

header('Location: ' . BASE_URL . '/account/requests.php?success=cancelled');
exit();
