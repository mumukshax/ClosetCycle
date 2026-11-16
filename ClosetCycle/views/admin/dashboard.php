<?php include __DIR__ . '/../shared/header.php'; ?>

<main>

    <section class="dashboard-intro">
        <p class="eyebrow">ADMIN AREA</p>
        <h1>ClosetCycle administration</h1>
        <p>Manage the main records used by the application.</p>
    </section>

    <section class="dashboard-stats admin-stats">
        <div class="stat-card">
            <span>Users</span>
            <strong><?php echo $userCount; ?></strong>
            <p>Registered ClosetCycle accounts.</p>
        </div>

        <div class="stat-card">
            <span>Listings</span>
            <strong><?php echo $itemCount; ?></strong>
            <p>Items currently stored in the database.</p>
        </div>

        <div class="stat-card">
            <span>Requests</span>
            <strong><?php echo $requestCount; ?></strong>
            <p>Borrowing requests in all statuses.</p>
        </div>

        <div class="stat-card">
            <span>Categories</span>
            <strong><?php echo $categoryCount; ?></strong>
            <p>Categories available for listings.</p>
        </div>
    </section>

    <section class="admin-links">
        <a class="admin-link-card" href="<?php echo BASE_URL; ?>/admin/users.php">
            <span>01</span>
            <h2>Manage Users</h2>
            <p>View member accounts and activate or deactivate them.</p>
        </a>

        <a class="admin-link-card" href="<?php echo BASE_URL; ?>/admin/listings.php">
            <span>02</span>
            <h2>Manage Listings</h2>
            <p>Review listings and remove a listing when needed.</p>
        </a>

        <a class="admin-link-card" href="<?php echo BASE_URL; ?>/admin/categories.php">
            <span>03</span>
            <h2>Manage Categories</h2>
            <p>Add, edit, or remove clothing categories.</p>
        </a>
    </section>

</main>

<?php include __DIR__ . '/../shared/footer.php'; ?>
