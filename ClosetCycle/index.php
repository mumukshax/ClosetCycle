<?php

require_once __DIR__ . '/models/Item.php';

$pageTitle = 'Community Occasion-Wear Lending';

$featuredItems =
    Item::getFeaturedItems(4);

include __DIR__ . '/views/home/home.php';