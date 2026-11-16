<?php

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../models/BorrowRequest.php';

Auth::requireLogin();

$pageTitle = 'Requests for My Items';
$currentUser = Auth::user();
$ownerID = (int) $currentUser['userID'];

$requests = BorrowRequest::getForOwner($ownerID);
$success = filter_input(INPUT_GET, 'success');
$error = filter_input(INPUT_GET, 'error');

include __DIR__ . '/../views/account/received_requests.php';
