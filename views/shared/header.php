<?php

require_once __DIR__ . '/../../config/app.php';

if (!isset($pageTitle)) {
    $pageTitle = 'ClosetCycle';
}

$currentUser = Auth::user();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        <?php echo htmlspecialchars($pageTitle); ?> | ClosetCycle
    </title>

    <link
        rel="stylesheet"
        href="<?php echo BASE_URL; ?>/public/css/main.css">
</head>
<body>

<header class="site-header">

    <div class="header-inner">

        <a class="logo" href="<?php echo BASE_URL; ?>/">
            CLOSETCYCLE
        </a>

        <nav class="main-nav">
            <a href="<?php echo BASE_URL; ?>/">Home</a>
            <a href="<?php echo BASE_URL; ?>/browse.php">Browse</a>
            <a href="<?php echo BASE_URL; ?>/how_it_works.php">How It Works</a>
        </nav>

        <nav class="account-nav">

            <?php if ($currentUser) : ?>

                <span class="account-user">
                    Hi, <?php echo htmlspecialchars($currentUser['firstName']); ?>
                </span>

                <a href="<?php echo BASE_URL; ?>/account/">My Account</a>

                <?php if ($currentUser['role'] === 'admin') : ?>
                    <a href="<?php echo BASE_URL; ?>/admin/">Admin</a>
                <?php endif; ?>

                <a href="<?php echo BASE_URL; ?>/logout.php">Log Out</a>

            <?php else : ?>

                <a href="<?php echo BASE_URL; ?>/register.php">Join</a>
                <a href="<?php echo BASE_URL; ?>/login.php">Sign In</a>

            <?php endif; ?>

        </nav>

    </div>

</header>
