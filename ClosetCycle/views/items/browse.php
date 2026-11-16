<?php

/**
 * Variables supplied by browse.php
 *
 * @var array $items
 * @var array $categories
 * @var array $occasions
 * @var string $search
 * @var string $size
 * @var int|null $categoryID
 * @var int|null $occasionID
 * @var string $sort
 */

include __DIR__ . '/../shared/header.php';
?>

<main>

    <section class="page-intro">
        <p class="eyebrow">COMMUNITY CLOSET</p>
        <h1>Browse the closet</h1>
        <p>
            Search and filter occasion pieces shared by members of the
            ClosetCycle community.
        </p>
    </section>


    <section class="browse-filters">

        <form action="browse.php" method="get" class="browse-filter-form">

            <div class="form-group browse-search-field">
                <label for="q">Search</label>
                <input
                    type="text"
                    id="q"
                    name="q"
                    maxlength="100"
                    placeholder="Dress, blazer, black..."
                    value="<?php echo htmlspecialchars($search); ?>">
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <select id="category" name="category">
                    <option value="">All categories</option>
                    <?php foreach ($categories as $category) : ?>
                        <option
                            value="<?php echo (int) $category['categoryID']; ?>"
                            <?php echo $categoryID == $category['categoryID'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($category['categoryName']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="occasion">Occasion</label>
                <select id="occasion" name="occasion">
                    <option value="">All occasions</option>
                    <?php foreach ($occasions as $occasion) : ?>
                        <option
                            value="<?php echo (int) $occasion['occasionID']; ?>"
                            <?php echo $occasionID == $occasion['occasionID'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($occasion['occasionName']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="size">Size</label>
                <input
                    type="text"
                    id="size"
                    name="size"
                    maxlength="20"
                    placeholder="M, 8, One Size"
                    value="<?php echo htmlspecialchars($size); ?>">
            </div>

            <div class="form-group">
                <label for="sort">Sort</label>
                <select id="sort" name="sort">
                    <option value="newest" <?php echo $sort === 'newest' ? 'selected' : ''; ?>>Newest</option>
                    <option value="oldest" <?php echo $sort === 'oldest' ? 'selected' : ''; ?>>Oldest</option>
                    <option value="name" <?php echo $sort === 'name' ? 'selected' : ''; ?>>Name A-Z</option>
                </select>
            </div>

            <div class="browse-filter-actions">
                <button class="button button-dark" type="submit">Apply</button>
                <a class="text-link" href="<?php echo BASE_URL; ?>/browse.php">Clear</a>
            </div>

        </form>

    </section>


    <section class="browse-toolbar">
        <div>
            <strong><?php echo count($items); ?></strong>
            available <?php echo count($items) === 1 ? 'piece' : 'pieces'; ?>
        </div>
    </section>


    <?php if (count($items) > 0) : ?>

        <section class="item-grid browse-grid">

            <?php foreach ($items as $item) : ?>

                <article class="item-card">

                    <a
                        class="item-image"
                        href="<?php echo BASE_URL; ?>/item.php?id=<?php echo (int) $item['itemID']; ?>">

                        <img
                            src="<?php echo htmlspecialchars(itemImageUrl($item['imageName'])); ?>"
                            alt="<?php echo htmlspecialchars($item['itemName']); ?>">
                    </a>

                    <div class="item-card-info">

                        <div class="item-card-top">
                            <h2>
                                <a href="<?php echo BASE_URL; ?>/item.php?id=<?php echo (int) $item['itemID']; ?>">
                                    <?php echo htmlspecialchars($item['itemName']); ?>
                                </a>
                            </h2>

                            <span><?php echo htmlspecialchars($item['size']); ?></span>
                        </div>

                        <p class="item-brand"><?php echo htmlspecialchars($item['brand']); ?></p>

                        <p class="item-meta">
                            <?php echo htmlspecialchars($item['categoryName']); ?>
                            ·
                            <?php echo htmlspecialchars($item['occasionName']); ?>
                        </p>

                        <p class="item-condition">
                            <?php echo htmlspecialchars($item['itemCondition']); ?> condition
                        </p>

                        <p class="listed-by">
                            Listed by <?php echo htmlspecialchars($item['firstName']); ?>
                        </p>

                    </div>

                </article>

            <?php endforeach; ?>

        </section>

    <?php else : ?>

        <section class="empty-state">
            <h2>No matching pieces found.</h2>
            <p>Try changing your search or filters.</p>
            <a class="button button-dark" href="<?php echo BASE_URL; ?>/browse.php">View All Pieces</a>
        </section>

    <?php endif; ?>

</main>

<?php include __DIR__ . '/../shared/footer.php'; ?>
