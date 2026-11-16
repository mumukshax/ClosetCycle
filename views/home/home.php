<?php

/**
 * Variables supplied by index.php
 *
 * @var array $featuredItems
 */

include __DIR__ . '/../shared/header.php';

?>

<main>

    <!-- Hero Section -->
    <section class="hero">

        <div class="hero-content">

            <p class="eyebrow">
                COMMUNITY OCCASION WEAR
            </p>

            <h1>
                Wear it.
                <br>
                Don't have to own it.
            </h1>

            <p class="hero-text">
                Borrow standout pieces for weddings,
                graduations, nights out, work events,
                and the moments that matter.
            </p>

            <div class="hero-actions">

                <a
                    class="button button-dark"
                    href="<?php echo BASE_URL; ?>/browse.php">

                    Browse the Closet

                </a>

                <a
                    class="text-link"
                    href="<?php echo BASE_URL; ?>/how_it_works.php">

                    How It Works

                </a>

            </div>

        </div>


        <div class="hero-visual">

            <div class="hero-image-placeholder">

                <span>
                    YOUR CLOSET HAS
                    <br>
                    MORE TO GIVE
                </span>

            </div>

        </div>

    </section>


    <!-- Shop by Occasion -->
    <section class="section">

        <div class="section-heading">

            <div>

                <p class="eyebrow">
                    FIND THE RIGHT PIECE
                </p>

                <h2>
                    Shop by occasion
                </h2>

            </div>

            <a
                class="text-link"
                href="<?php echo BASE_URL; ?>/browse.php">

                View All Pieces

            </a>

        </div>


        <div class="occasion-grid">

            <a
                class="occasion-card"
                href="<?php
                echo BASE_URL;
                ?>/browse.php?occasion=1">

                <span>
                    01
                </span>

                <h3>
                    Wedding Guest
                </h3>

            </a>


            <a
                class="occasion-card"
                href="<?php
                echo BASE_URL;
                ?>/browse.php?occasion=2">

                <span>
                    02
                </span>

                <h3>
                    Formal
                </h3>

            </a>


            <a
                class="occasion-card"
                href="<?php
                echo BASE_URL;
                ?>/browse.php?occasion=3">

                <span>
                    03
                </span>

                <h3>
                    Graduation
                </h3>

            </a>


            <a
                class="occasion-card"
                href="<?php
                echo BASE_URL;
                ?>/browse.php?occasion=4">

                <span>
                    04
                </span>

                <h3>
                    Night Out
                </h3>

            </a>

        </div>

    </section>


    <!-- Featured Items -->
    <section class="section">

        <div class="section-heading">

            <div>

                <p class="eyebrow">
                    RECENTLY LISTED
                </p>

                <h2>
                    New to the closet
                </h2>

            </div>

            <a
                class="text-link"
                href="<?php echo BASE_URL; ?>/browse.php">

                Browse Everything

            </a>

        </div>


        <?php if (count($featuredItems) > 0) : ?>

            <div class="item-grid">

                <?php foreach ($featuredItems as $item) : ?>

                    <article class="item-card">

                        <!-- Item image links to item details -->
                        <a
                            class="item-image"
                            href="<?php
                            echo BASE_URL;
                            ?>/item.php?id=<?php
                            echo (int) $item['itemID'];
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


                        <div class="item-card-info">

                            <div class="item-card-top">

                                <h3>

                                    <!-- Item name also links to details -->
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

                                </h3>


                                <span>
                                    <?php
                                    echo htmlspecialchars(
                                        $item['size']
                                    );
                                    ?>
                                </span>

                            </div>


                            <p class="item-brand">
                                <?php
                                echo htmlspecialchars(
                                    $item['brand']
                                );
                                ?>
                            </p>


                            <p class="item-meta">

                                <?php
                                echo htmlspecialchars(
                                    $item['occasionName']
                                );
                                ?>

                                ·

                                <?php
                                echo htmlspecialchars(
                                    $item['categoryName']
                                );
                                ?>

                            </p>

                        </div>

                    </article>

                <?php endforeach; ?>

            </div>

        <?php else : ?>

            <p>
                No available items were found.
            </p>

        <?php endif; ?>

    </section>


    <!-- How It Works Preview -->
    <section class="how-preview">

        <div class="section-heading light-heading">

            <div>

                <p class="eyebrow">
                    SIMPLE COMMUNITY LENDING
                </p>

                <h2>
                    Give your wardrobe
                    another life.
                </h2>

            </div>

        </div>


        <div class="steps-grid">

            <div class="step">

                <span>
                    01
                </span>

                <h3>
                    List a Piece
                </h3>

                <p>
                    Add occasion wear from your closet
                    that you are willing to lend.
                </p>

            </div>


            <div class="step">

                <span>
                    02
                </span>

                <h3>
                    Request to Borrow
                </h3>

                <p>
                    Find an available piece and send
                    the owner a request for your dates.
                </p>

            </div>


            <div class="step">

                <span>
                    03
                </span>

                <h3>
                    Wear & Return
                </h3>

                <p>
                    Enjoy the piece for your event,
                    then return it to the owner.
                </p>

            </div>

        </div>

    </section>

</main>

<?php include __DIR__ . '/../shared/footer.php'; ?>