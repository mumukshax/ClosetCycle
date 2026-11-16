<?php

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../models/Item.php';

Auth::requireAdmin();

$pageTitle = 'Manage Listings';
$items = Item::getAllForAdmin();
$success = filter_input(INPUT_GET, 'success');
$error = filter_input(INPUT_GET, 'error');

include __DIR__ . '/../views/admin/listings.php';
