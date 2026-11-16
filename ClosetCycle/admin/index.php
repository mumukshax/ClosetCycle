<?php

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Item.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/BorrowRequest.php';

Auth::requireAdmin();

$pageTitle = 'Admin Dashboard';
$userCount = User::countAll();
$itemCount = Item::countAll();
$requestCount = BorrowRequest::countAll();
$categoryCount = count(Category::getAll());

include __DIR__ . '/../views/admin/dashboard.php';
