<?php

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../models/Item.php';
require_once __DIR__ . '/../models/ImageUpload.php';

Auth::requireAdmin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . '/admin/listings.php');
    exit();
}

$itemID = filter_input(INPUT_POST, 'itemID', FILTER_VALIDATE_INT);

if (!$itemID) {
    header('Location: ' . BASE_URL . '/admin/listings.php?error=invalid');
    exit();
}

$item = Item::getById($itemID);

if (!$item) {
    header('Location: ' . BASE_URL . '/admin/listings.php?error=invalid');
    exit();
}

if (Item::hasActiveRequest($itemID)) {
    header('Location: ' . BASE_URL . '/admin/listings.php?error=active_request');
    exit();
}

if (Item::deleteByAdmin($itemID)) {
    ImageUpload::delete($item['imageName']);
    header('Location: ' . BASE_URL . '/admin/listings.php?success=deleted');
    exit();
}

header('Location: ' . BASE_URL . '/admin/listings.php?error=invalid');
exit();
