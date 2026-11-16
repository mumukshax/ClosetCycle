<?php

/**
 * Variables supplied by account/listings.php
 *
 * @var array $items
 * @var string|null $success
 * @var string|null $error
 */

include __DIR__ .
    '/../shared/header.php';

?>

<main>

    <section class="member-page-heading">

        <div>

            <p class="eyebrow">
                MY CLOSET
            </p>

            <h1>
                My listings
            </h1>

            <p>
                Manage the pieces you have
                shared with the ClosetCycle
                community.
            </p>

        </div>


        <a
            class="button button-dark"
            href="<?php
            echo BASE_URL;
            ?>/account/add_item.php">

            List an Item

        </a>

    </section>


    <?php if ($success === 'added') : ?>

    <div class="page-message success-box">

        Your new listing was added successfully.

    </div>

<?php elseif ($success === 'updated') : ?>

    <div class="page-message success-box">

        Your listing was updated successfully.

    </div>

<?php elseif ($success === 'deleted') : ?>

    <div class="page-message success-box">

        Your listing was deleted successfully.

    </div>

<?php endif; ?>


<?php if ($error === 'not_allowed') : ?>

    <div class="page-message error-box">

        You are not allowed to change that listing.

    </div>

<?php elseif ($error === 'active_request') : ?>

    <div class="page-message error-box">

        A listing with an active borrowing request cannot be deleted.

    </div>

<?php endif; ?>


    <?php if (count($items) > 0) : ?>

        <section class="member-listings">

            <?php foreach ($items as $item) : ?>

                <article class="member-listing">

                    <a
                        class="member-listing-image"
                        href="<?php
                        echo BASE_URL;
                        ?>/item.php?id=<?php
                        echo (int)
                            $item['itemID'];
                        ?>">

                        <img
                            src="<?php
                            echo htmlspecialchars(
                                itemImageUrl(
                                    $item['imageName']
                                )
                            );
                            ?>"
                            alt="<?php
                            echo htmlspecialchars(
                                $item['itemName']
                            );
                            ?>">

                    </a>


                    <div class="member-listing-info">

                        <p class="eyebrow">
                            <?php
                            echo htmlspecialchars(
                                $item['status']
                            );
                            ?>
                        </p>


                        <h2>

                            <a
                                href="<?php
                                echo BASE_URL;
                                ?>/item.php?id=<?php
                                echo (int)
                                    $item['itemID'];
                                ?>">

                                <?php
                                echo htmlspecialchars(
                                    $item['itemName']
                                );
                                ?>

                            </a>

                        </h2>


                        <p>
                            <?php
                            echo htmlspecialchars(
                                $item['brand']
                            );
                            ?>
                        </p>


                        <div class="listing-meta">

                            <span>
                                Size:
                                <?php
                                echo htmlspecialchars(
                                    $item['size']
                                );
                                ?>
                            </span>

                            <span>
                                <?php
                                echo htmlspecialchars(
                                    $item['categoryName']
                                );
                                ?>
                            </span>

                            <span>
                                <?php
                                echo htmlspecialchars(
                                    $item['occasionName']
                                );
                                ?>
                            </span>

                        </div>

                    </div>


                    <div class="member-listing-actions">

                        <a
                            class="text-link"
                            href="<?php
                            echo BASE_URL;
                            ?>/item.php?id=<?php
                            echo (int)
                                $item['itemID'];
                            ?>">

                            View

                        </a>


                        <a
                            class="text-link"
                            href="<?php
                            echo BASE_URL;
                            ?>/account/edit_item.php?id=<?php
                            echo (int)
                                $item['itemID'];
                            ?>">

                            Edit

                        </a>


                        <form
                            action="<?php
                            echo BASE_URL;
                            ?>/account/delete_item.php"
                            method="post"
                            class="delete-form"
                            onsubmit="
                                return confirm(
                                    'Are you sure you want to delete this listing?'
                                );
                            ">

                            <input
                                type="hidden"
                                name="itemID"
                                value="<?php
                                echo (int)
                                    $item['itemID'];
                                ?>">


                            <button
                                type="submit"
                                class="delete-link">

                                Delete

                            </button>

                        </form>

                    </div>

                </article>

            <?php endforeach; ?>

        </section>

    <?php else : ?>

        <section class="empty-state">

            <p class="eyebrow">
                YOUR CLOSET IS EMPTY
            </p>

            <h2>
                You haven't listed
                anything yet.
            </h2>

            <p>
                Add an occasion piece from your
                wardrobe to get started.
            </p>

            <a
                class="button button-dark"
                href="<?php
                echo BASE_URL;
                ?>/account/add_item.php">

                List Your First Item

            </a>

        </section>

    <?php endif; ?>

</main>

<?php

include __DIR__ .
    '/../shared/footer.php';

?>