<?php include __DIR__ . '/../shared/header.php'; ?>

<main>

    <section class="member-page-heading">
        <div>
            <p class="eyebrow">ADMIN</p>
            <h1>Manage listings</h1>
            <p>Review all member listings and remove a listing when necessary.</p>
        </div>

        <a class="text-link" href="<?php echo BASE_URL; ?>/admin/">Admin Dashboard</a>
    </section>

    <?php if ($success === 'deleted') : ?>
        <div class="page-message success-box">Listing deleted.</div>
    <?php endif; ?>

    <?php if ($error === 'active_request') : ?>
        <div class="page-message error-box">A listing with an active borrowing request cannot be deleted.</div>
    <?php elseif ($error === 'invalid') : ?>
        <div class="page-message error-box">That listing could not be deleted.</div>
    <?php endif; ?>

    <div class="admin-table-wrap admin-table-page">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Owner</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['itemName']); ?></td>
                        <td><?php echo htmlspecialchars($item['firstName'] . ' ' . $item['lastName']); ?></td>
                        <td><?php echo htmlspecialchars($item['categoryName']); ?></td>
                        <td><?php echo htmlspecialchars($item['status']); ?></td>
                        <td class="admin-actions-cell">
                            <a
                                class="text-link"
                                href="<?php echo BASE_URL; ?>/item.php?id=<?php echo (int) $item['itemID']; ?>">
                                View
                            </a>

                            <form
                                action="<?php echo BASE_URL; ?>/admin/delete_item.php"
                                method="post"
                                onsubmit="return confirm('Delete this listing?');">
                                <input type="hidden" name="itemID" value="<?php echo (int) $item['itemID']; ?>">
                                <button class="delete-link" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</main>

<?php include __DIR__ . '/../shared/footer.php'; ?>
