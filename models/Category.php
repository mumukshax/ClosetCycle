<?php

require_once __DIR__ . '/Database.php';

class Category
{
    // Get all clothing categories.
    public static function getAll()
    {
        $db = Database::getDB();
        $query = 'SELECT categoryID, categoryName FROM categories ORDER BY categoryName';
        $statement = $db->prepare($query);
        $statement->execute();
        $categories = $statement->fetchAll();
        $statement->closeCursor();

        return $categories;
    }


    public static function getById($categoryID)
    {
        $db = Database::getDB();
        $query = 'SELECT categoryID, categoryName FROM categories WHERE categoryID = :categoryID';
        $statement = $db->prepare($query);
        $statement->bindValue(':categoryID', $categoryID, PDO::PARAM_INT);
        $statement->execute();
        $category = $statement->fetch();
        $statement->closeCursor();

        return $category;
    }


    public static function add($categoryName)
    {
        $db = Database::getDB();
        $query = 'INSERT INTO categories (categoryName) VALUES (:categoryName)';
        $statement = $db->prepare($query);
        $statement->bindValue(':categoryName', $categoryName);
        $statement->execute();
        $statement->closeCursor();
    }


    public static function update($categoryID, $categoryName)
    {
        $db = Database::getDB();
        $query = 'UPDATE categories SET categoryName = :categoryName WHERE categoryID = :categoryID';
        $statement = $db->prepare($query);
        $statement->bindValue(':categoryName', $categoryName);
        $statement->bindValue(':categoryID', $categoryID, PDO::PARAM_INT);
        $statement->execute();
        $statement->closeCursor();
    }


    // A category cannot be removed while listings are using it.
    public static function delete($categoryID)
    {
        $db = Database::getDB();

        $query = 'SELECT COUNT(*) AS itemCount FROM items WHERE categoryID = :categoryID';
        $statement = $db->prepare($query);
        $statement->bindValue(':categoryID', $categoryID, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();

        if ((int) $result['itemCount'] > 0) {
            return false;
        }

        $query = 'DELETE FROM categories WHERE categoryID = :categoryID';
        $statement = $db->prepare($query);
        $statement->bindValue(':categoryID', $categoryID, PDO::PARAM_INT);
        $statement->execute();
        $deleted = $statement->rowCount();
        $statement->closeCursor();

        return $deleted > 0;
    }
}
