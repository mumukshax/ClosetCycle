<?php

/**
 * Variables supplied by account/add_item.php
 *
 * @var array $errors
 * @var array $categories
 * @var array $occasions
 * @var string $itemName
 * @var string $brand
 * @var string $size
 * @var string $colour
 * @var string $itemCondition
 * @var string $description
 * @var int|null $categoryID
 * @var int|null $occasionID
 */

include __DIR__ .
    '/../shared/header.php';

?>

<main>

    <section class="form-page">

        <div class="form-page-intro">

            <p class="eyebrow">
                SHARE YOUR CLOSET
            </p>

            <h1>
                List a piece.
            </h1>

            <p>
                Add an occasion item that you
                are willing to lend to another
                member of the community.
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
                action="add_item.php"
                method="post"
                enctype="multipart/form-data"
                class="form-layout">


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

                            <option value="">
                                Select a category
                            </option>

                            <?php
                            foreach (
                                $categories as
                                $category
                            ) :
                            ?>

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
                                        $category[
                                            'categoryName'
                                        ]
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

                            <option value="">
                                Select an occasion
                            </option>

                            <?php
                            foreach (
                                $occasions as
                                $occasion
                            ) :
                            ?>

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
                                        $occasion[
                                            'occasionName'
                                        ]
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

                            <option value="">
                                Select condition
                            </option>

                            <?php
                            $conditions = [
                                'New',
                                'Like New',
                                'Excellent',
                                'Good'
                            ];

                            foreach (
                                $conditions as
                                $condition
                            ) :
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

                    <small>
                        Describe the fit, style,
                        and any useful information
                        for a borrower.
                    </small>

                </div>


                <div class="form-group">

                    <label for="itemImage">
                        Item Image
                    </label>

                    <input
                        type="file"
                        id="itemImage"
                        name="itemImage"
                        accept=".jpg,.jpeg,.png,.webp">

                    <small>
                        Optional. JPG, PNG, or WebP.
                        Maximum file size: 5 MB.
                    </small>

                </div>


                <div class="form-actions">

                    <button
                        type="submit"
                        class="button button-dark">

                        Publish Listing

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