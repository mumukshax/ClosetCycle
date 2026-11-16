<?php include __DIR__ . '/../shared/header.php'; ?>

<main>

    <section class="member-page-heading">
        <div>
            <p class="eyebrow">ADMIN</p>
            <h1>Manage categories</h1>
            <p>Categories are used when members create and filter listings.</p>
        </div>

        <a class="text-link" href="<?php echo BASE_URL; ?>/admin/">Admin Dashboard</a>
    </section>

    <?php if ($success === 'added') : ?>
        <div class="page-message success-box">Category added.</div>
    <?php elseif ($success === 'updated') : ?>
        <div class="page-message success-box">Category updated.</div>
    <?php elseif ($success === 'deleted') : ?>
        <div class="page-message success-box">Category deleted.</div>
    <?php endif; ?>

    <?php if ($error === 'in_use') : ?>
        <div class="page-message error-box">That category is being used by a listing and cannot be deleted.</div>
    <?php endif; ?>

    <?php if (count($errors) > 0) : ?>
        <div class="page-message error-box">
            <?php foreach ($errors as $formError) : ?>
                <div><?php echo htmlspecialchars($formError); ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <section class="admin-two-column">

        <div class="admin-form-box">
            <p class="eyebrow"><?php echo $editCategory ? 'EDIT CATEGORY' : 'NEW CATEGORY'; ?></p>
            <h2><?php echo $editCategory ? 'Update category' : 'Add category'; ?></h2>

            <form action="categories.php" method="post" class="form-layout">
                <input
                    type="hidden"
                    name="action"
                    value="<?php echo $editCategory ? 'edit' : 'add'; ?>">

                <?php if ($editCategory) : ?>
                    <input
                        type="hidden"
                        name="categoryID"
                        value="<?php echo (int) $editCategory['categoryID']; ?>">
                <?php endif; ?>

                <div class="form-group">
                    <label for="categoryName">Category Name</label>
                    <input
                        type="text"
                        id="categoryName"
                        name="categoryName"
                        maxlength="60"
                        value="<?php echo htmlspecialchars($editCategory['categoryName'] ?? ''); ?>">
                </div>

                <div class="form-actions">
                    <button class="button button-dark" type="submit">
                        <?php echo $editCategory ? 'Save Changes' : 'Add Category'; ?>
                    </button>

                    <?php if ($editCategory) : ?>
                        <a class="text-link" href="<?php echo BASE_URL; ?>/admin/categories.php">Cancel</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($category['categoryName']); ?></td>
                            <td class="admin-actions-cell">
                                <a
                                    class="text-link"
                                    href="<?php echo BASE_URL; ?>/admin/categories.php?edit=<?php echo (int) $category['categoryID']; ?>">
                                    Edit
                                </a>

                                <form
                                    action="categories.php"
                                    method="post"
                                    onsubmit="return confirm('Delete this category?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input
                                        type="hidden"
                                        name="categoryID"
                                        value="<?php echo (int) $category['categoryID']; ?>">
                                    <button class="delete-link" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </section>

</main>

<?php include __DIR__ . '/../shared/footer.php'; ?>
