<?php

require_once __DIR__ .
    '/../config/app.php';

require_once __DIR__ .
    '/../models/Item.php';

require_once __DIR__ .
    '/../models/Category.php';

require_once __DIR__ .
    '/../models/Occasion.php';

    require_once __DIR__ .
    '/../models/ImageUpload.php';

// Login is required.
Auth::requireLogin();


$currentUser = Auth::user();

$userID =
    (int) $currentUser['userID'];


$itemID =
    filter_input(
        INPUT_GET,
        'id',
        FILTER_VALIDATE_INT
    );


// On POST, get item ID from the form.
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
        '/account/listings.php'
    );

    exit();
}


// This also checks ownership.
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


$pageTitle = 'Edit Listing';

$categories =
    Category::getAll();

$occasions =
    Occasion::getAll();

$errors = [];


// Initial form values come from MySQL.
$itemName =
    $item['itemName'];

$brand =
    $item['brand'];

$size =
    $item['size'];

$colour =
    $item['colour'];

$itemCondition =
    $item['itemCondition'];

$description =
    $item['description'];

$categoryID =
    (int) $item['categoryID'];

$occasionID =
    (int) $item['occasionID'];


// Process the edit form.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $itemName =
        trim(
            filter_input(
                INPUT_POST,
                'itemName'
            ) ?? ''
        );


    $brand =
        trim(
            filter_input(
                INPUT_POST,
                'brand'
            ) ?? ''
        );


    $size =
        trim(
            filter_input(
                INPUT_POST,
                'size'
            ) ?? ''
        );


    $colour =
        trim(
            filter_input(
                INPUT_POST,
                'colour'
            ) ?? ''
        );


    $itemCondition =
        trim(
            filter_input(
                INPUT_POST,
                'itemCondition'
            ) ?? ''
        );


    $description =
        trim(
            filter_input(
                INPUT_POST,
                'description'
            ) ?? ''
        );


    $categoryID =
        filter_input(
            INPUT_POST,
            'categoryID',
            FILTER_VALIDATE_INT
        );


    $occasionID =
        filter_input(
            INPUT_POST,
            'occasionID',
            FILTER_VALIDATE_INT
        );


    // Validate edited values.
    if ($itemName === '') {
        $errors[] =
            'Item name is required.';
    }


    if (!$categoryID) {
        $errors[] =
            'Please select a category.';
    }


    if (!$occasionID) {
        $errors[] =
            'Please select an occasion.';
    }


    if ($size === '') {
        $errors[] =
            'Size is required.';
    }


    $allowedConditions = [
        'New',
        'Like New',
        'Excellent',
        'Good'
    ];


    if (
        !in_array(
            $itemCondition,
            $allowedConditions,
            true
        )
    ) {
        $errors[] =
            'Please select a valid condition.';
    }


    if ($description === '') {
        $errors[] =
            'Description is required.';
    }


    if (strlen($description) > 1000) {
        $errors[] =
            'Description must be 1000 characters or less.';
    }


    if (count($errors) === 0) {

    $oldImageName =
        $item['imageName'];


    $upload =
        ImageUpload::save(
            $_FILES['itemImage'] ?? null
        );


    if ($upload['error']) {

        $errors[] =
            $upload['error'];

    } else {

        // Keep the existing image unless
        // a replacement was uploaded.
        $imageName =
            $upload['fileName']
            ?? $oldImageName;


        Item::updateOwned(
            $itemID,
            $userID,
            $categoryID,
            $occasionID,
            $itemName,
            $brand,
            $size,
            $colour,
            $itemCondition,
            $description,
            $imageName
        );


        // Remove the old uploaded image
        // after a successful replacement.
        if (
            $upload['fileName'] &&
            $upload['fileName'] !==
                $oldImageName
        ) {

            ImageUpload::delete(
                $oldImageName
            );
        }


        header(
            'Location: ' .
            BASE_URL .
            '/account/listings.php?success=updated'
        );

        exit();
    }
}
}


include __DIR__ .
    '/../views/account/edit_item.php';