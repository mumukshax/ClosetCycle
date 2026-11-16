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


// Only authenticated users can list items.
Auth::requireLogin();


$pageTitle = 'List an Item';

$currentUser = Auth::user();

$userID =
    (int) $currentUser['userID'];


$categories =
    Category::getAll();

$occasions =
    Occasion::getAll();


$errors = [];

$itemName = '';
$brand = '';
$size = '';
$colour = '';
$itemCondition = '';
$description = '';

$categoryID = null;
$occasionID = null;


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


    // Validate listing information.
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

    $upload =
        ImageUpload::save(
            $_FILES['itemImage'] ?? null
        );


    if ($upload['error']) {

        $errors[] =
            $upload['error'];

    } else {

        $imageName =
            $upload['fileName']
            ?? 'default-item.png';


        Item::add(
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


        header(
            'Location: ' .
            BASE_URL .
            '/account/listings.php?success=added'
        );

        exit();
    }
}
}


include __DIR__ .
    '/../views/account/add_item.php';