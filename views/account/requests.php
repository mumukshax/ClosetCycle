<?php

/**
 * Variables supplied by account/requests.php
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
            <p class="eyebrow">BORROWING</p>
            <h1>My borrow requests</h1>
            <p>Track the pieces you have requested from other members.</p>
        </div>

        <a class="button button-dark" href="<?php echo BASE_URL; ?>/browse.php">Browse the Closet</a>
    </section>


    <?php if ($success === 'sent') : ?>
        <div class="page-message success-box">Your borrowing request was sent successfully.</div>
    <?php elseif ($success === 'cancelled') : ?>
        <div class="page-message success-box">Your borrowing request was cancelled.</div>
    <?php endif; ?>

    <?php if ($error === 'duplicate') : ?>
        <div class="page-message error-box">You already have an active request for that item.</div>
    <?php elseif ($error === 'cannot_cancel') : ?>
        <div class="page-message error-box">That request can no longer be cancelled.</div>
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
                            Listed by <?php echo htmlspecialchars($request['ownerFirstName']); ?>
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

                        <?php if ($request['status'] === 'Pending') : ?>
                            <div class="request-actions">
                                <form
                                    action="<?php echo BASE_URL; ?>/account/cancel_request.php"
                                    method="post"
                                    onsubmit="return confirm('Cancel this borrowing request?');">
                                    <input
                                        type="hidden"
                                        name="requestID"
                                        value="<?php echo (int) $request['requestID']; ?>">
                                    <button class="button" type="submit">Cancel Request</button>
                                </form>
                            </div>
                        <?php endif; ?>

                    </div>

                </article>

            <?php endforeach; ?>

        </section>

    <?php else : ?>

        <section class="empty-state">
            <p class="eyebrow">NO REQUESTS YET</p>
            <h2>Find something for your next occasion.</h2>
            <p>When you request a piece, you will be able to track its status here.</p>
            <a class="button button-dark" href="<?php echo BASE_URL; ?>/browse.php">Browse the Closet</a>
        </section>

    <?php endif; ?>

</main>

<?php include __DIR__ . '/../shared/footer.php'; ?>
