<?php

require_once __DIR__ . '/models/Item.php';
require_once __DIR__ . '/models/Category.php';
require_once __DIR__ . '/models/Occasion.php';

$pageTitle = 'Browse the Closet';

$search = trim(filter_input(INPUT_GET, 'q') ?? '');
$size = trim(filter_input(INPUT_GET, 'size') ?? '');
$categoryID = filter_input(INPUT_GET, 'category', FILTER_VALIDATE_INT);
$occasionID = filter_input(INPUT_GET, 'occasion', FILTER_VALIDATE_INT);
$sort = filter_input(INPUT_GET, 'sort') ?? 'newest';

if ($categoryID === false) {
    $categoryID = null;
}

if ($occasionID === false) {
    $occasionID = null;
}

$allowedSorts = ['newest', 'oldest', 'name'];
if (!in_array($sort, $allowedSorts, true)) {
    $sort = 'newest';
}

$items = Item::getAvailableItems(
    $search,
    $categoryID,
    $occasionID,
    $size,
    $sort
);

$categories = Category::getAll();
$occasions = Occasion::getAll();

include __DIR__ . '/views/items/browse.php';
