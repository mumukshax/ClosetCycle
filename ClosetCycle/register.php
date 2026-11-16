<?php

require_once __DIR__ . '/models/User.php';

$pageTitle = 'Create an Account';

$errors = [];

$firstName = '';
$lastName = '';
$email = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $firstName = trim(
        filter_input(
            INPUT_POST,
            'firstName'
        ) ?? ''
    );

    $lastName = trim(
        filter_input(
            INPUT_POST,
            'lastName'
        ) ?? ''
    );

    $email = strtolower(
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

    $confirmPassword =
        filter_input(
            INPUT_POST,
            'confirmPassword'
        ) ?? '';


    // Validate first name.
    if ($firstName === '') {
        $errors[] =
            'First name is required.';
    }


    // Validate last name.
    if ($lastName === '') {
        $errors[] =
            'Last name is required.';
    }


    // Validate email.
    if ($email === '') {

        $errors[] =
            'Email address is required.';

    } elseif (
        !filter_var(
            $email,
            FILTER_VALIDATE_EMAIL
        )
    ) {

        $errors[] =
            'Please enter a valid email address.';

    } elseif (User::getByEmail($email)) {

        $errors[] =
            'An account already exists with this email address.';
    }


    // Validate password.
    if (strlen($password) < 8) {

        $errors[] =
            'Password must be at least 8 characters long.';
    }


    // Confirm both passwords match.
    if ($password !== $confirmPassword) {

        $errors[] =
            'Passwords do not match.';
    }


    // Create the account when validation succeeds.
    if (count($errors) === 0) {

        $passwordHash =
            password_hash(
                $password,
                PASSWORD_DEFAULT
            );


        User::add(
            $firstName,
            $lastName,
            $email,
            $passwordHash
        );


        header(
            'Location: register.php?success=1'
        );

        exit();
    }
}


$success =
    filter_input(
        INPUT_GET,
        'success',
        FILTER_VALIDATE_INT
    );


include __DIR__ .
    '/views/auth/register.php';