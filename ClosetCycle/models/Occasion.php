<?php

require_once __DIR__ . '/Database.php';

class Occasion
{
    // Get all occasions for browse filters.
    public static function getAll()
    {
        $db = Database::getDB();

        $query = '
            SELECT
                occasionID,
                occasionName
            FROM occasions
            ORDER BY occasionName
        ';

        $statement = $db->prepare($query);
        $statement->execute();

        $occasions = $statement->fetchAll();

        $statement->closeCursor();

        return $occasions;
    }
}