<?php

/**
 * Variables supplied by register.php
 *
 * @var array $errors
 * @var string $firstName
 * @var string $lastName
 * @var string $email
 * @var int|null $success
 */

include __DIR__ . '/../shared/header.php';

?>

<main>

    <section class="auth-page">

        <div class="auth-intro">

            <p class="eyebrow">
                JOIN THE COMMUNITY
            </p>

            <h1>
                Give your closet
                more possibilities.
            </h1>

            <p>
                Create a ClosetCycle account to
                list occasion wear, request pieces,
                and keep track of your borrowing.
            </p>

        </div>


        <div class="auth-panel">

            <?php if ($success === 1) : ?>

                <div class="success-message">

                    <h2>
                        Your account has been created.
                    </h2>

                    <p>
                        You can now sign in to
                        ClosetCycle.
                    </p>

                    <a
                        class="button button-dark"
                        href="<?php
                        echo BASE_URL;
                        ?>/login.php">

                        Sign In

                    </a>

                </div>

            <?php else : ?>


                <h2>
                    Create an account
                </h2>


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
                    action="register.php"
                    method="post"
                    class="form-layout">


                    <div class="form-row">

                        <div class="form-group">

                            <label for="firstName">
                                First Name
                            </label>

                            <input
                                type="text"
                                id="firstName"
                                name="firstName"
                                maxlength="50"
                                value="<?php
                                echo htmlspecialchars(
                                    $firstName
                                );
                                ?>">

                        </div>


                        <div class="form-group">

                            <label for="lastName">
                                Last Name
                            </label>

                            <input
                                type="text"
                                id="lastName"
                                name="lastName"
                                maxlength="50"
                                value="<?php
                                echo htmlspecialchars(
                                    $lastName
                                );
                                ?>">

                        </div>

                    </div>


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

                        <small>
                            Minimum 8 characters.
                        </small>

                    </div>


                    <div class="form-group">

                        <label for="confirmPassword">
                            Confirm Password
                        </label>

                        <input
                            type="password"
                            id="confirmPassword"
                            name="confirmPassword">

                    </div>


                    <button
                        class="button button-dark"
                        type="submit">

                        Create Account

                    </button>

                </form>


            <p class="auth-switch">

                Already have an account?

                <a
                    class="text-link"
                    href="<?php
                    echo BASE_URL;
                    ?>/login.php">

                Sign In

                </a>

            </p>

            <?php endif; ?>

        </div>

    </section>

</main>

<?php include __DIR__ . '/../shared/footer.php'; ?>