<?php

// Database class used to create a PDO connection
// to the ClosetCycle MySQL database.

class Database
{
    private static $db = null;

    public static function getDB()
    {
        if (self::$db === null) {

            require_once __DIR__ . '/../config/config.php';

            $dsn = 'mysql:host=' . DB_HOST .
                   ';dbname=' . DB_NAME .
                   ';charset=utf8mb4';

            $options = [
                PDO::ATTR_ERRMODE =>
                    PDO::ERRMODE_EXCEPTION,

                PDO::ATTR_DEFAULT_FETCH_MODE =>
                    PDO::FETCH_ASSOC,

                PDO::ATTR_EMULATE_PREPARES =>
                    false
            ];

            try {
                self::$db = new PDO(
                    $dsn,
                    DB_USER,
                    DB_PASS,
                    $options
                );
            } catch (PDOException $e) {
                die(
                    'Database connection error: ' .
                    htmlspecialchars(
                        $e->getMessage()
                    )
                );
            }
        }

        return self::$db;
    }
}