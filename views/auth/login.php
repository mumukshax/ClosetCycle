<?php

/**
 * Variables supplied by login.php
 *
 * @var string $email
 * @var string $loginError
 */

include __DIR__ .
    '/../shared/header.php';

?>

<main>

    <section class="auth-page">

        <div class="auth-intro">

            <p class="eyebrow">
                WELCOME BACK
            </p>


            <h1>
                Your closet
                community awaits.
            </h1>


            <p>
                Sign in to manage your listings,
                borrowing requests, and pieces
                shared through ClosetCycle.
            </p>

        </div>


        <div class="auth-panel">

            <h2>
                Sign in
            </h2>


            <?php
            if ($loginError !== '') :
            ?>

                <div class="form-errors">

                    <p>
                        <?php
                        echo htmlspecialchars(
                            $loginError
                        );
                        ?>
                    </p>

                </div>

            <?php endif; ?>


            <form
                action="login.php"
                method="post"
                class="form-layout">


                <div class="form-group">

                    <label for="email">
                        Email Address
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        maxlength="100"
                        value="<?php
                        echo htmlspecialchars(
                            $email
                        );
                        ?>">

                </div>


                <div class="form-group">

                    <label for="password">
                        Password
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password">

                </div>


                <button
                    class="button button-dark"
                    type="submit">

                    Sign In

                </button>

            </form>


            <p class="auth-switch">

                New to ClosetCycle?

                <a
                    class="text-link"
                    href="<?php
                    echo BASE_URL;
                    ?>/register.php">

                    Create an Account

                </a>

            </p>

        </div>

    </section>

</main>

<?php

include __DIR__ .
    '/../shared/footer.php';

?>