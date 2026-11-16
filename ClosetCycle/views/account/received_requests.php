<?php

/**
 * Variables supplied by account/received_requests.php
 *
 * @var array $requests
 * @var string|null $success
 * @var string|null $error
 */

include __DIR__ . '/../shared/header.php';
?>

<main>

    <section class="member-page-heading">
        <div>
            <p class="eyebrow">LENDING</p>
            <h1>Requests for my items</h1>
            <p>Review requests and update each item as it moves through the lending process.</p>
        </div>

        <a class="button button-dark" href="<?php echo BASE_URL; ?>/account/listings.php">My Listings</a>
    </section>


    <?php if ($success === 'approved') : ?>
        <div class="page-message success-box">The borrowing request was approved.</div>
    <?php elseif ($success === 'declined') : ?>
        <div class="page-message success-box">The borrowing request was declined.</div>
    <?php elseif ($success === 'borrowed') : ?>
        <div class="page-message success-box">The item was marked as borrowed.</div>
    <?php elseif ($success === 'returned') : ?>
        <div class="page-message success-box">The item was returned and is available again.</div>
    <?php endif; ?>

    <?php if ($error === 'not_allowed') : ?>
        <div class="page-message error-box">You are not allowed to manage that request.</div>
    <?php elseif ($error === 'invalid_status') : ?>
        <div class="page-message error-box">That request can no longer be changed with that action.</div>
    <?php endif; ?>


    <?php if (count($requests) > 0) : ?>

        <section class="request-list">

            <?php foreach ($requests as $request) : ?>

                <article class="request-card">

                    <a
                        class="request-card-image"
                        href="<?php echo BASE_URL; ?>/item.php?id=<?php echo (int) $request['itemID']; ?>">
                        <img
                            src="<?php echo htmlspecialchars(itemImageUrl($request['imageName'])); ?>"
                            alt="<?php echo htmlspecialchars($request['itemName']); ?>">
                    </a>

                    <div class="request-card-info">

                        <span class="status-badge status-<?php echo strtolower(htmlspecialchars($request['status'])); ?>">
                            <?php echo htmlspecialchars($request['status']); ?>
                        </span>

                        <h2><?php echo htmlspecialchars($request['itemName']); ?></h2>

                        <p>
                            <?php echo htmlspecialchars($request['brand']); ?>
                            · Size <?php echo htmlspecialchars($request['size']); ?>
                        </p>

                        <p class="request-owner">
                            Requested by
                            <strong>
                                <?php echo htmlspecialchars(
                                    $request['borrowerFirstName'] . ' ' . $request['borrowerLastName']
                                ); ?>
                            </strong>
                        </p>

                        <div class="request-dates">
                            <div>
                                <span>Needed From</span>
                                <strong><?php echo date('M j, Y', strtotime($request['neededFrom'])); ?></strong>
                            </div>

                            <div>
                                <span>Return By</span>
                                <strong><?php echo date('M j, Y', strtotime($request['neededUntil'])); ?></strong>
                            </div>
                        </div>

                        <?php if (!empty($request['message'])) : ?>
                            <p class="request-message">
                                “<?php echo htmlspecialchars($request['message']); ?>”
                            </p>
                        <?php endif; ?>

                        <div class="request-actions">

                            <?php if ($request['status'] === 'Pending') : ?>

                                <form action="<?php echo BASE_URL; ?>/account/request_action.php" method="post">
                                    <input type="hidden" name="requestID" value="<?php echo (int) $request['requestID']; ?>">
                                    <input type="hidden" name="action" value="approve">
                                    <button class="button button-dark" type="submit">Approve</button>
                                </form>

                                <form action="<?php echo BASE_URL; ?>/account/request_action.php" method="post">
                                    <input type="hidden" name="requestID" value="<?php echo (int) $request['requestID']; ?>">
                                    <input type="hidden" name="action" value="decline">
                                    <button class="button" type="submit">Decline</button>
                                </form>

                            <?php elseif ($request['status'] === 'Approved') : ?>

                                <form action="<?php echo BASE_URL; ?>/account/request_action.php" method="post">
                                    <input type="hidden" name="requestID" value="<?php echo (int) $request['requestID']; ?>">
                                    <input type="hidden" name="action" value="borrowed">
                                    <button class="button button-dark" type="submit">Mark Borrowed</button>
                                </form>

                            <?php elseif ($request['status'] === 'Borrowed') : ?>

                                <form action="<?php echo BASE_URL; ?>/account/request_action.php" method="post">
                                    <input type="hidden" name="requestID" value="<?php echo (int) $request['requestID']; ?>">
                                    <input type="hidden" name="action" value="returned">
                                    <button class="button button-dark" type="submit">Mark Returned</button>
                                </form>

                            <?php endif; ?>

                        </div>

                    </div>

                </article>

            <?php endforeach; ?>

        </section>

    <?php else : ?>

        <section class="empty-state">
            <p class="eyebrow">NO REQUESTS YET</p>
            <h2>No one has requested your pieces yet.</h2>
            <p>New borrowing requests will appear here.</p>
        </section>

    <?php endif; ?>

</main>

<?php include __DIR__ . '/../shared/footer.php'; ?>
