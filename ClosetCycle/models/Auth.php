<?php

require_once __DIR__ . '/../config/config.php';

class Auth
{
    // Start the application session.
    public static function startSession()
    {
        if (session_status() === PHP_SESSION_NONE) {

            $isHttps =
                !empty($_SERVER['HTTPS']) &&
                $_SERVER['HTTPS'] !== 'off';

            session_set_cookie_params([
                'lifetime' => 0,
                'path' => '/',
                'secure' => $isHttps,
                'httponly' => true,
                'samesite' => 'Lax'
            ]);

            session_start();
        }
    }


    // Store the authenticated user in the session.
    public static function login($user)
    {
        self::startSession();

        session_regenerate_id(true);

        $_SESSION['user'] = [
            'userID' => $user['userID'],
            'firstName' => $user['firstName'],
            'lastName' => $user['lastName'],
            'email' => $user['email'],
            'role' => $user['role']
        ];
    }


    // Return the currently logged-in user.
    public static function user()
    {
        self::startSession();

        return $_SESSION['user'] ?? null;
    }


    // Check whether a user is logged in.
    public static function isLoggedIn()
    {
        return self::user() !== null;
    }


    // Check whether the current user is an administrator.
    public static function isAdmin()
    {
        $user = self::user();

        return $user !== null &&
               $user['role'] === 'admin';
    }


    // Require a user to be logged in.
    public static function requireLogin()
    {
        if (!self::isLoggedIn()) {

            header(
                'Location: ' .
                BASE_URL .
                '/login.php'
            );

            exit();
        }
    }


    // Require an administrator account.
    public static function requireAdmin()
    {
        if (!self::isAdmin()) {

            header(
                'Location: ' .
                BASE_URL .
                '/login.php'
            );

            exit();
        }
    }


    // Log the current user out.
    public static function logout()
    {
        self::startSession();

        $_SESSION = [];


        if (
            ini_get('session.use_cookies')
        ) {

            $params =
                session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }


        session_destroy();
    }
}