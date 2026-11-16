<?php

$pageTitle = 'How It Works';

include __DIR__ .
    '/views/shared/header.php';

?>

<main>

    <section class="page-intro">

        <p class="eyebrow">
            CLOSETCYCLE
        </p>

        <h1>
            How it works
        </h1>

        <p>
            ClosetCycle helps community members
            give occasion wear more opportunities
            to be worn.
        </p>

    </section>


    <section class="how-page">

        <article class="how-step">

            <span>01</span>

            <div>

                <h2>
                    List what you are
                    ready to share.
                </h2>

                <p>
                    Members can add occasion pieces
                    from their wardrobe, including
                    information about size, condition,
                    category, occasion, and availability.
                </p>

            </div>

        </article>


        <article class="how-step">

            <span>02</span>

            <div>

                <h2>
                    Find something for
                    your next event.
                </h2>

                <p>
                    Browse available pieces and
                    search or filter by category, size,
                    and occasion. Members can view details
                    before requesting an item.
                </p>

            </div>

        </article>


        <article class="how-step">

            <span>03</span>

            <div>

                <h2>
                    Send a borrowing
                    request.
                </h2>

                <p>
                    Choose the dates you need the
                    item and send a request to its
                    owner. The owner can approve
                    or decline the request.
                </p>

            </div>

        </article>


        <article class="how-step">

            <span>04</span>

            <div>

                <h2>
                    Wear it and
                    return it.
                </h2>

                <p>
                    Approved items can move through
                    the borrowing process from
                    approved to borrowed and finally
                    returned.
                </p>

            </div>

        </article>

    </section>


    <section class="how-cta">

        <p class="eyebrow">
            READY TO EXPLORE?
        </p>

        <h2>
            Find something worth
            wearing again.
        </h2>

        <a
            class="button button-dark"
            href="<?php
            echo BASE_URL;
            ?>/browse.php">

            Browse the Closet

        </a>

    </section>

</main>

<?php

include __DIR__ .
    '/views/shared/footer.php';

?>