<?php

require_once __DIR__ .
    '/../config/app.php';

require_once __DIR__ .
    '/../models/Item.php';

require_once __DIR__ .
    '/../models/BorrowRequest.php';


// Only authenticated users can access
// the member dashboard.
Auth::requireLogin();


$pageTitle = 'My Account';

$currentUser = Auth::user();

$userID =
    (int) $currentUser['userID'];


// Load dashboard information from MySQL.
$listingCount =
    Item::countByOwner($userID);

$borrowRequestCount =
    BorrowRequest::countByBorrower(
        $userID
    );

$receivedRequestCount =
    BorrowRequest::countForOwner(
        $userID
    );


include __DIR__ .
    '/../views/account/dashboard.php';