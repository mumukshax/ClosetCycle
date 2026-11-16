<?php

require_once __DIR__ .
    '/config/app.php';

require_once __DIR__ .
    '/models/User.php';


// Already logged-in users do not need
// to see the login form again.
if (Auth::isLoggedIn()) {

    header(
        'Location: ' .
        BASE_URL .
        '/'
    );

    exit();
}


$pageTitle = 'Sign In';

$email = '';

$loginError = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email =
        strtolower(
            trim(
                filter_input(
                    INPUT_POST,
                    'email'
                ) ?? ''
            )
        );


    $password =
        filter_input(
            INPUT_POST,
            'password'
        ) ?? '';


    if (
        $email === '' ||
        $password === ''
    ) {

        $loginError =
            'Please enter your email and password.';

    } else {

        $user =
            User::authenticate(
                $email,
                $password
            );


        if ($user) {

            Auth::login($user);


            header(
                'Location: ' .
                BASE_URL .
                '/'
            );

            exit();

        } else {

            $loginError =
                'Invalid email or password.';
        }
    }
}


include __DIR__ .
    '/views/auth/login.php';