<?php include __DIR__ . '/../shared/header.php'; ?>

<main>

    <section class="member-page-heading">
        <div>
            <p class="eyebrow">ADMIN</p>
            <h1>Manage users</h1>
            <p>View account roles and control whether member accounts are active.</p>
        </div>

        <a class="text-link" href="<?php echo BASE_URL; ?>/admin/">Admin Dashboard</a>
    </section>

    <?php if ($success === 'updated') : ?>
        <div class="page-message success-box">User account updated.</div>
    <?php endif; ?>

    <?php if ($error === 'invalid') : ?>
        <div class="page-message error-box">That user account could not be changed.</div>
    <?php endif; ?>

    <div class="admin-table-wrap admin-table-page">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['firstName'] . ' ' . $user['lastName']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars(ucfirst($user['role'])); ?></td>
                        <td><?php echo (int) $user['isActive'] === 1 ? 'Active' : 'Inactive'; ?></td>
                        <td>
                            <?php if ($user['role'] === 'member') : ?>
                                <form action="<?php echo BASE_URL; ?>/admin/user_action.php" method="post">
                                    <input type="hidden" name="userID" value="<?php echo (int) $user['userID']; ?>">
                                    <input
                                        type="hidden"
                                        name="action"
                                        value="<?php echo (int) $user['isActive'] === 1 ? 'deactivate' : 'activate'; ?>">
                                    <button class="text-button" type="submit">
                                        <?php echo (int) $user['isActive'] === 1 ? 'Deactivate' : 'Activate'; ?>
                                    </button>
                                </form>
                            <?php else : ?>
                                <span class="muted-text">Admin account</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</main>

<?php include __DIR__ . '/../shared/footer.php'; ?>
