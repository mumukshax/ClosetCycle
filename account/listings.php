<?php

require_once __DIR__ .
    '/../config/app.php';

require_once __DIR__ .
    '/../models/Item.php';


// Only logged-in members can access this page.
Auth::requireLogin();


$pageTitle = 'My Listings';

$currentUser = Auth::user();

$userID =
    (int) $currentUser['userID'];


$items =
    Item::getByOwner($userID);


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
    '/../views/account/listings.php';