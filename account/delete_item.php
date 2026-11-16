<?php

require_once __DIR__ .
    '/../config/app.php';

require_once __DIR__ .
    '/../models/Item.php';

require_once __DIR__ .
    '/../models/ImageUpload.php';


Auth::requireLogin();


$currentUser =
    Auth::user();

$userID =
    (int) $currentUser['userID'];


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    header(
        'Location: ' .
        BASE_URL .
        '/account/listings.php'
    );

    exit();
}


$itemID =
    filter_input(
        INPUT_POST,
        'itemID',
        FILTER_VALIDATE_INT
    );


if (!$itemID) {

    header(
        'Location: ' .
        BASE_URL .
        '/account/listings.php'
    );

    exit();
}


// Get the item first so its image can
// be removed after deletion.
$item =
    Item::getOwnedById(
        $itemID,
        $userID
    );


if (!$item) {

    header(
        'Location: ' .
        BASE_URL .
        '/account/listings.php?error=not_allowed'
    );

    exit();
}


// Do not remove a listing while a borrowing request is active.
if (Item::hasActiveRequest($itemID)) {

    header(
        'Location: ' .
        BASE_URL .
        '/account/listings.php?error=active_request'
    );

    exit();
}


$deleted =
    Item::deleteOwned(
        $itemID,
        $userID
    );


if (!$deleted) {

    header(
        'Location: ' .
        BASE_URL .
        '/account/listings.php?error=not_allowed'
    );

    exit();
}


// Remove an uploaded image file.
// The default placeholder is never deleted.
ImageUpload::delete(
    $item['imageName']
);


header(
    'Location: ' .
    BASE_URL .
    '/account/listings.php?success=deleted'
);

exit();