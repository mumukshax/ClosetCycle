<?php

/**
 * Variables supplied by account/request_item.php
 *
 * @var array $item
 * @var array $errors
 * @var string $neededFrom
 * @var string $neededUntil
 * @var string $message
 */

include __DIR__ .
    '/../shared/header.php';

?>

<main>

    <section class="request-page">

        <div class="request-item-summary">

            <div class="request-item-image">

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


            <p class="eyebrow">
                REQUEST THIS PIECE
            </p>


            <h1>
                <?php
                echo htmlspecialchars(
                    $item['itemName']
                );
                ?>
            </h1>


            <p class="request-brand">
                <?php
                echo htmlspecialchars(
                    $item['brand']
                );
                ?>
            </p>


            <div class="request-item-meta">

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
                        $item['itemCondition']
                    );
                    ?>
                    condition
                </span>

            </div>

        </div>


        <div class="form-page-panel">

            <h2>
                Choose your dates
            </h2>


            <?php if (count($errors) > 0) : ?>

                <div class="form-errors">

                    <p>
                        Please correct the following:
                    </p>

                    <ul>

                        <?php foreach ($errors as $error) : ?>

                            <li>
                                <?php
                                echo htmlspecialchars(
                                    $error
                                );
                                ?>
                            </li>

                        <?php endforeach; ?>

                    </ul>

                </div>

            <?php endif; ?>


            <form
                action="request_item.php"
                method="post"
                class="form-layout">


                <input
                    type="hidden"
                    name="itemID"
                    value="<?php
                    echo (int) $item['itemID'];
                    ?>">


                <div class="form-row">

                    <div class="form-group">

                        <label for="neededFrom">
                            Needed From
                        </label>

                        <input
                            type="date"
                            id="neededFrom"
                            name="neededFrom"
                            value="<?php
                            echo htmlspecialchars(
                                $neededFrom
                            );
                            ?>">

                    </div>


                    <div class="form-group">

                        <label for="neededUntil">
                            Return By
                        </label>

                        <input
                            type="date"
                            id="neededUntil"
                            name="neededUntil"
                            value="<?php
                            echo htmlspecialchars(
                                $neededUntil
                            );
                            ?>">

                    </div>

                </div>


                <div class="form-group">

                    <label for="message">
                        Message to Owner
                    </label>

                    <textarea
                        id="message"
                        name="message"
                        rows="5"
                        maxlength="500"><?php
                        echo htmlspecialchars(
                            $message
                        );
                        ?></textarea>

                    <small>
                        Optional. You can mention
                        the event or any useful details.
                    </small>

                </div>


                <div class="form-note">

                    <strong>
                        How requests work
                    </strong>

                    <p>
                        The owner will review your
                        request and can approve or
                        decline it.
                    </p>

                </div>


                <div class="form-actions">

                    <button
                        type="submit"
                        class="button button-dark">

                        Send Request

                    </button>


                    <a
                        class="text-link"
                        href="<?php
                        echo BASE_URL;
                        ?>/item.php?id=<?php
                        echo (int)
                            $item['itemID'];
                        ?>">

                        Cancel

                    </a>

                </div>

            </form>

        </div>

    </section>

</main>

<?php

include __DIR__ .
    '/../shared/footer.php';

?>