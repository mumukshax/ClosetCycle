<?php 

/**
 * Variable supplied by item.php controller
 *
 * @var array $item
 */

include __DIR__ . '/../shared/header.php'; ?>

<main>

    <section class="item-details">

        <div class="details-image">

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

        </div>


        <div class="details-content">

            <p class="eyebrow">
                <?php
                echo htmlspecialchars(
                    $item['occasionName']
                );
                ?>
            </p>


            <h1>
                <?php
                echo htmlspecialchars(
                    $item['itemName']
                );
                ?>
            </h1>


            <p class="details-brand">
                <?php
                echo htmlspecialchars(
                    $item['brand']
                );
                ?>
            </p>


            <div class="details-meta">

                <div>
                    <span>Size</span>

                    <strong>
                        <?php
                        echo htmlspecialchars(
                            $item['size']
                        );
                        ?>
                    </strong>
                </div>


                <div>
                    <span>Category</span>

                    <strong>
                        <?php
                        echo htmlspecialchars(
                            $item['categoryName']
                        );
                        ?>
                    </strong>
                </div>


                <div>
                    <span>Colour</span>

                    <strong>
                        <?php
                        echo htmlspecialchars(
                            $item['colour']
                        );
                        ?>
                    </strong>
                </div>


                <div>
                    <span>Condition</span>

                    <strong>
                        <?php
                        echo htmlspecialchars(
                            $item['itemCondition']
                        );
                        ?>
                    </strong>
                </div>

            </div>


            <div class="details-description">

                <h2>
                    About this piece
                </h2>

                <p>
                    <?php
                    echo nl2br(
                        htmlspecialchars(
                            $item['description']
                        )
                    );
                    ?>
                </p>

            </div>


            <div class="details-owner">

                <span>
                    Listed by
                </span>

                <strong>
                    <?php
                    echo htmlspecialchars(
                        $item['firstName']
                    );
                    ?>
                </strong>

            </div>


            <?php if ($item['status'] === 'Available') : ?>

    <div class="request-preview">

        <?php
        if (
            $currentUser &&
            (int) $currentUser['userID'] ===
                (int) $item['ownerID']
        ) :
        ?>

            <p>
                This is your listing.
            </p>

            <a
                class="button"
                href="<?php
                echo BASE_URL;
                ?>/account/edit_item.php?id=<?php
                echo (int)
                    $item['itemID'];
                ?>">

                Edit Listing

            </a>


        <?php elseif ($currentUser) : ?>


                <p>
                    This piece is currently
                    available to request.
                </p>

                <a
                    class="button button-dark"
                    href="<?php
                    echo BASE_URL;
                    ?>/account/request_item.php?id=<?php
                    echo (int)
                        $item['itemID'];
                    ?>">

                    Request to Borrow

                </a>


            <?php else : ?>


                <p>
                    Sign in to request this piece.
                </p>

                <a
                    class="button button-dark"
                    href="<?php
                    echo BASE_URL;
                    ?>/login.php">

                    Sign In to Request

                </a>

            <?php endif; ?>

        </div>


            <?php else : ?>

                <div class="unavailable-message">

                    This piece is currently unavailable.

                </div>

            <?php endif; ?>


            <a
                class="text-link back-link"
                href="<?php
                echo BASE_URL;
                ?>/browse.php">

                Back to Browse

            </a>

        </div>

    </section>

</main>

<?php include __DIR__ . '/../shared/footer.php'; ?>