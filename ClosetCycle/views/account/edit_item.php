<?php

/**
 * Variables supplied by account/edit_item.php
 *
 * @var int $itemID
 * @var array $errors
 * @var array $categories
 * @var array $occasions
 * @var string $itemName
 * @var string $brand
 * @var string $size
 * @var string $colour
 * @var string $itemCondition
 * @var string $description
 * @var int $categoryID
 * @var int $occasionID
 * @var array $item
 */

include __DIR__ .
    '/../shared/header.php';

?>

<main>

    <section class="form-page">

        <div class="form-page-intro">

            <p class="eyebrow">
                MY CLOSET
            </p>

            <h1>
                Edit your listing.
            </h1>

            <p>
                Update the information shown
                to members browsing ClosetCycle.
            </p>

        </div>


        <div class="form-page-panel">

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
            action="edit_item.php"
            method="post"
            enctype="multipart/form-data"
            class="form-layout">


                <input
                    type="hidden"
                    name="itemID"
                    value="<?php
                    echo (int) $itemID;
                    ?>">


                <div class="form-group">

                    <label for="itemName">
                        Item Name
                    </label>

                    <input
                        type="text"
                        id="itemName"
                        name="itemName"
                        maxlength="100"
                        value="<?php
                        echo htmlspecialchars(
                            $itemName
                        );
                        ?>">

                </div>


                <div class="form-row">

                    <div class="form-group">

                        <label for="brand">
                            Brand
                        </label>

                        <input
                            type="text"
                            id="brand"
                            name="brand"
                            maxlength="80"
                            value="<?php
                            echo htmlspecialchars(
                                $brand
                            );
                            ?>">

                    </div>


                    <div class="form-group">

                        <label for="size">
                            Size
                        </label>

                        <input
                            type="text"
                            id="size"
                            name="size"
                            maxlength="20"
                            value="<?php
                            echo htmlspecialchars(
                                $size
                            );
                            ?>">

                    </div>

                </div>


                <div class="form-row">

                    <div class="form-group">

                        <label for="categoryID">
                            Category
                        </label>

                        <select
                            id="categoryID"
                            name="categoryID">

                            <?php foreach ($categories as $category) : ?>

                                <option
                                    value="<?php
                                    echo (int)
                                        $category['categoryID'];
                                    ?>"
                                    <?php
                                    if (
                                        $categoryID ==
                                        $category['categoryID']
                                    ) {
                                        echo 'selected';
                                    }
                                    ?>>

                                    <?php
                                    echo htmlspecialchars(
                                        $category['categoryName']
                                    );
                                    ?>

                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>


                    <div class="form-group">

                        <label for="occasionID">
                            Occasion
                        </label>

                        <select
                            id="occasionID"
                            name="occasionID">

                            <?php foreach ($occasions as $occasion) : ?>

                                <option
                                    value="<?php
                                    echo (int)
                                        $occasion['occasionID'];
                                    ?>"
                                    <?php
                                    if (
                                        $occasionID ==
                                        $occasion['occasionID']
                                    ) {
                                        echo 'selected';
                                    }
                                    ?>>

                                    <?php
                                    echo htmlspecialchars(
                                        $occasion['occasionName']
                                    );
                                    ?>

                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>

                </div>


                <div class="form-row">

                    <div class="form-group">

                        <label for="colour">
                            Colour
                        </label>

                        <input
                            type="text"
                            id="colour"
                            name="colour"
                            maxlength="50"
                            value="<?php
                            echo htmlspecialchars(
                                $colour
                            );
                            ?>">

                    </div>


                    <div class="form-group">

                        <label for="itemCondition">
                            Condition
                        </label>

                        <select
                            id="itemCondition"
                            name="itemCondition">

                            <?php

                            $conditions = [
                                'New',
                                'Like New',
                                'Excellent',
                                'Good'
                            ];

                            foreach ($conditions as $condition) :

                            ?>

                                <option
                                    value="<?php
                                    echo htmlspecialchars(
                                        $condition
                                    );
                                    ?>"
                                    <?php
                                    if (
                                        $itemCondition ===
                                        $condition
                                    ) {
                                        echo 'selected';
                                    }
                                    ?>>

                                    <?php
                                    echo htmlspecialchars(
                                        $condition
                                    );
                                    ?>

                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>

                </div>


                <div class="form-group">

                    <label for="description">
                        Description
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="6"
                        maxlength="1000"><?php
                        echo htmlspecialchars(
                            $description
                        );
                        ?></textarea>

                </div>
                

                <div class="form-group">

                    <label>
                        Current Image
                    </label>

                    <div class="current-image-preview">

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
                                $itemName
                            );
                            ?>">

                    </div>

                </div>


                <div class="form-group">

                    <label for="itemImage">
                        Replace Image
                    </label>

                    <input
                        type="file"
                        id="itemImage"
                        name="itemImage"
                        accept=".jpg,.jpeg,.png,.webp">

                    <small>
                        Leave this blank to keep the
                        current image.
                    </small>

                </div>

                <div class="form-actions">

                    <button
                        class="button button-dark"
                        type="submit">

                        Save Changes

                    </button>


                    <a
                        class="text-link"
                        href="<?php
                        echo BASE_URL;
                        ?>/account/listings.php">

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