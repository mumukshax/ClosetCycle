<?php include __DIR__ . '/../shared/header.php'; ?>

<main>

    <section class="empty-state page-error">

        <p class="eyebrow">
            CLOSETCYCLE
        </p>

        <h1>
            Item not found.
        </h1>

        <p>
            The piece you were looking for
            does not exist or is no longer available.
        </p>

        <a
            class="button button-dark"
            href="<?php
            echo BASE_URL;
            ?>/browse.php">

            Browse the Closet

        </a>

    </section>

</main>

<?php include __DIR__ . '/../shared/footer.php'; ?>