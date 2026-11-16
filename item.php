<?php

require_once __DIR__ . '/models/Item.php';

$itemID = filter_input(
    INPUT_GET,
    'id',
    FILTER_VALIDATE_INT
);

if (!$itemID) {
    header(
        'Location: browse.php'
    );
    exit();
}

$item = Item::getById($itemID);

if (!$item) {
    http_response_code(404);

    $pageTitle = 'Item Not Found';

    include __DIR__ .
        '/views/items/not_found.php';

    exit();
}

$pageTitle = $item['itemName'];

include __DIR__ .
    '/views/items/details.php';