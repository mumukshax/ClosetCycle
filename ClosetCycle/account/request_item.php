<?php

require_once __DIR__ .
    '/../config/app.php';

require_once __DIR__ .
    '/../models/Item.php';

require_once __DIR__ .
    '/../models/BorrowRequest.php';


Auth::requireLogin();


$currentUser =
    Auth::user();

$borrowerID =
    (int) $currentUser['userID'];


$itemID =
    filter_input(
        INPUT_GET,
        'id',
        FILTER_VALIDATE_INT
    );


// Get the item ID from POST
// after the form is submitted.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $itemID =
        filter_input(
            INPUT_POST,
            'itemID',
            FILTER_VALIDATE_INT
        );
}


if (!$itemID) {

    header(
        'Location: ' .
        BASE_URL .
        '/browse.php'
    );

    exit();
}


$item =
    Item::getById($itemID);


if (!$item) {

    header(
        'Location: ' .
        BASE_URL .
        '/browse.php'
    );

    exit();
}


// Members cannot request their own listing.
if (
    (int) $item['ownerID'] ===
    $borrowerID
) {

    header(
        'Location: ' .
        BASE_URL .
        '/item.php?id=' .
        $itemID
    );

    exit();
}


// Only available pieces can be requested.
if ($item['status'] !== 'Available') {

    header(
        'Location: ' .
        BASE_URL .
        '/item.php?id=' .
        $itemID
    );

    exit();
}


// Prevent duplicate active requests.
if (
    BorrowRequest::hasActiveRequest(
        $itemID,
        $borrowerID
    )
) {

    header(
        'Location: ' .
        BASE_URL .
        '/account/requests.php?error=duplicate'
    );

    exit();
}


$pageTitle = 'Request to Borrow';

$errors = [];

$neededFrom = '';
$neededUntil = '';
$message = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $neededFrom =
        trim(
            filter_input(
                INPUT_POST,
                'neededFrom'
            ) ?? ''
        );


    $neededUntil =
        trim(
            filter_input(
                INPUT_POST,
                'neededUntil'
            ) ?? ''
        );


    $message =
        trim(
            filter_input(
                INPUT_POST,
                'message'
            ) ?? ''
        );


    $today =
        date('Y-m-d');


    if ($neededFrom === '') {

        $errors[] =
            'Please select the date you need the item.';

    } elseif ($neededFrom < $today) {

        $errors[] =
            'The start date cannot be in the past.';
    }


    if ($neededUntil === '') {

        $errors[] =
            'Please select a return date.';

    } elseif (
        $neededFrom !== '' &&
        $neededUntil < $neededFrom
    ) {

        $errors[] =
            'The return date must be on or after the start date.';
    }


    if (strlen($message) > 500) {

        $errors[] =
            'Your message must be 500 characters or less.';
    }


    if (count($errors) === 0) {

        BorrowRequest::add(
            $itemID,
            $borrowerID,
            $neededFrom,
            $neededUntil,
            $message
        );


        header(
            'Location: ' .
            BASE_URL .
            '/account/requests.php?success=sent'
        );

        exit();
    }
}


include __DIR__ .
    '/../views/account/request_item.php';