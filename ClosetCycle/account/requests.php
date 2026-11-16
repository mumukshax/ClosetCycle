<?php

require_once __DIR__ .
    '/../config/app.php';

require_once __DIR__ .
    '/../models/BorrowRequest.php';


Auth::requireLogin();


$pageTitle = 'My Borrow Requests';

$currentUser =
    Auth::user();

$userID =
    (int) $currentUser['userID'];


$requests =
    BorrowRequest::getByBorrower(
        $userID
    );


$success =
    filter_input(
        INPUT_GET,
        'success'
    );


$error =
    filter_input(
        INPUT_GET,
        'error'
    );


include __DIR__ .
    '/../views/account/requests.php';