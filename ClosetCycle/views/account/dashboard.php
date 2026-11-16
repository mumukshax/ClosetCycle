<?php

/**
 * Variables supplied by account/index.php
 *
 * @var array $currentUser
 * @var int $listingCount
 * @var int $borrowRequestCount
 * @var int $receivedRequestCount
 */

include __DIR__ . '/../shared/header.php';
?>

<main>

    <section class="dashboard-intro">
        <p class="eyebrow">MY CLOSETCYCLE</p>
        <h1>
            Welcome back,
            <?php echo htmlspecialchars($currentUser['firstName']); ?>.
        </h1>
        <p>
            Manage the pieces you share, keep track of borrowing requests,
            and see what is happening in your closet.
        </p>
    </section>


    <section class="dashboard-stats">
        <div class="stat-card">
            <span>My Listings</span>
            <strong><?php echo $listingCount; ?></strong>
            <p>Pieces you have listed on ClosetCycle.</p>
        </div>

        <div class="stat-card">
            <span>My Borrow Requests</span>
            <strong><?php echo $borrowRequestCount; ?></strong>
            <p>Requests you have sent to other members.</p>
        </div>

        <div class="stat-card">
            <span>Requests for My Items</span>
            <strong><?php echo $receivedRequestCount; ?></strong>
            <p>Requests received for pieces you have listed.</p>
        </div>
    </section>


    <section class="dashboard-section">
        <div>
            <p class="eyebrow">ACCOUNT</p>
            <h2>Your information</h2>
        </div>

        <div class="account-details">
            <div>
                <span>Name</span>
                <strong>
                    <?php echo htmlspecialchars(
                        $currentUser['firstName'] . ' ' . $currentUser['lastName']
                    ); ?>
                </strong>
            </div>

            <div>
                <span>Email</span>
                <strong><?php echo htmlspecialchars($currentUser['email']); ?></strong>
            </div>

            <div>
                <span>Account Type</span>
                <strong><?php echo htmlspecialchars(ucfirst($currentUser['role'])); ?></strong>
            </div>
        </div>
    </section>


    <section class="dashboard-actions">
        <div>
            <p class="eyebrow">YOUR CLOSET</p>
            <h2>Share, borrow, and manage requests.</h2>
            <p>Use the links here to manage the main ClosetCycle activities.</p>
        </div>

        <div class="dashboard-button-group">
            <a class="button button-dark" href="<?php echo BASE_URL; ?>/account/listings.php">My Listings</a>
            <a class="button" href="<?php echo BASE_URL; ?>/account/add_item.php">List an Item</a>
            <a class="button" href="<?php echo BASE_URL; ?>/account/requests.php">My Borrow Requests</a>
            <a class="button" href="<?php echo BASE_URL; ?>/account/received_requests.php">Requests for My Items</a>
        </div>
    </section>

</main>

<?php include __DIR__ . '/../shared/footer.php'; ?>
