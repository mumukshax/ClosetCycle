<?php

require_once __DIR__ . '/Database.php';

class Item
{
    // Get a small selection of available items for the home page.
    public static function getFeaturedItems($limit = 4)
    {
        $db = Database::getDB();

        $query = '
            SELECT
                i.itemID,
                i.itemName,
                i.brand,
                i.size,
                i.colour,
                i.imageName,
                i.status,
                i.dateAdded,
                c.categoryName,
                o.occasionName
            FROM items i
            JOIN categories c ON i.categoryID = c.categoryID
            JOIN occasions o ON i.occasionID = o.occasionID
            WHERE i.status = :status
            ORDER BY i.dateAdded DESC
            LIMIT :itemLimit
        ';

        $statement = $db->prepare($query);
        $statement->bindValue(':status', 'Available');
        $statement->bindValue(':itemLimit', $limit, PDO::PARAM_INT);
        $statement->execute();

        $items = $statement->fetchAll();
        $statement->closeCursor();

        return $items;
    }


    // Get available items with the filters used on the Browse page.
    public static function getAvailableItems(
        $search = '',
        $categoryID = null,
        $occasionID = null,
        $size = '',
        $sort = 'newest'
    ) {
        $db = Database::getDB();

        $query = '
            SELECT
                i.itemID,
                i.ownerID,
                i.itemName,
                i.brand,
                i.size,
                i.colour,
                i.itemCondition,
                i.description,
                i.imageName,
                i.status,
                i.dateAdded,
                c.categoryName,
                o.occasionName,
                u.firstName,
                u.lastName
            FROM items i
            JOIN categories c ON i.categoryID = c.categoryID
            JOIN occasions o ON i.occasionID = o.occasionID
            JOIN users u ON i.ownerID = u.userID
            WHERE i.status = :status
        ';

        if ($search !== '') {
            $query .= '
                AND (
                    i.itemName LIKE :searchName
                    OR i.brand LIKE :searchBrand
                    OR i.colour LIKE :searchColour
                    OR i.description LIKE :searchDescription
                )
            ';
        }

        if ($categoryID !== null) {
            $query .= ' AND i.categoryID = :categoryID ';
        }

        if ($occasionID !== null) {
            $query .= ' AND i.occasionID = :occasionID ';
        }

        if ($size !== '') {
            $query .= ' AND i.size LIKE :size ';
        }

        // The ORDER BY value comes from this fixed list, not directly from input.
        switch ($sort) {
            case 'oldest':
                $query .= ' ORDER BY i.dateAdded ASC ';
                break;
            case 'name':
                $query .= ' ORDER BY i.itemName ASC ';
                break;
            default:
                $query .= ' ORDER BY i.dateAdded DESC ';
                break;
        }

        $statement = $db->prepare($query);
        $statement->bindValue(':status', 'Available');

        if ($search !== '') {
            $searchValue = '%' . $search . '%';
            $statement->bindValue(':searchName', $searchValue);
            $statement->bindValue(':searchBrand', $searchValue);
            $statement->bindValue(':searchColour', $searchValue);
            $statement->bindValue(':searchDescription', $searchValue);
        }

        if ($categoryID !== null) {
            $statement->bindValue(':categoryID', $categoryID, PDO::PARAM_INT);
        }

        if ($occasionID !== null) {
            $statement->bindValue(':occasionID', $occasionID, PDO::PARAM_INT);
        }

        if ($size !== '') {
            $statement->bindValue(':size', '%' . $size . '%');
        }

        $statement->execute();
        $items = $statement->fetchAll();
        $statement->closeCursor();

        return $items;
    }


    // Get one item and its related information.
    public static function getById($itemID)
    {
        $db = Database::getDB();

        $query = '
            SELECT
                i.itemID,
                i.ownerID,
                i.categoryID,
                i.occasionID,
                i.itemName,
                i.brand,
                i.size,
                i.colour,
                i.itemCondition,
                i.description,
                i.imageName,
                i.status,
                i.dateAdded,
                c.categoryName,
                o.occasionName,
                u.firstName,
                u.lastName
            FROM items i
            JOIN categories c ON i.categoryID = c.categoryID
            JOIN occasions o ON i.occasionID = o.occasionID
            JOIN users u ON i.ownerID = u.userID
            WHERE i.itemID = :itemID
        ';

        $statement = $db->prepare($query);
        $statement->bindValue(':itemID', $itemID, PDO::PARAM_INT);
        $statement->execute();

        $item = $statement->fetch();
        $statement->closeCursor();

        return $item;
    }


    // Count all listings owned by one user.
    public static function countByOwner($ownerID)
    {
        $db = Database::getDB();

        $query = '
            SELECT COUNT(*) AS itemCount
            FROM items
            WHERE ownerID = :ownerID
        ';

        $statement = $db->prepare($query);
        $statement->bindValue(':ownerID', $ownerID, PDO::PARAM_INT);
        $statement->execute();

        $result = $statement->fetch();
        $statement->closeCursor();

        return (int) $result['itemCount'];
    }


    // Count all listings for the admin dashboard.
    public static function countAll()
    {
        $db = Database::getDB();
        $statement = $db->prepare('SELECT COUNT(*) AS itemCount FROM items');
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();

        return (int) $result['itemCount'];
    }


    // Get all listings owned by one user.
    public static function getByOwner($ownerID)
    {
        $db = Database::getDB();

        $query = '
            SELECT
                i.itemID,
                i.itemName,
                i.brand,
                i.size,
                i.colour,
                i.itemCondition,
                i.imageName,
                i.status,
                i.dateAdded,
                c.categoryName,
                o.occasionName
            FROM items i
            JOIN categories c ON i.categoryID = c.categoryID
            JOIN occasions o ON i.occasionID = o.occasionID
            WHERE i.ownerID = :ownerID
            ORDER BY i.dateAdded DESC
        ';

        $statement = $db->prepare($query);
        $statement->bindValue(':ownerID', $ownerID, PDO::PARAM_INT);
        $statement->execute();

        $items = $statement->fetchAll();
        $statement->closeCursor();

        return $items;
    }


    // Add a new clothing listing.
    public static function add(
        $ownerID,
        $categoryID,
        $occasionID,
        $itemName,
        $brand,
        $size,
        $colour,
        $itemCondition,
        $description,
        $imageName
    ) {
        $db = Database::getDB();

        $query = '
            INSERT INTO items
            (
                ownerID,
                categoryID,
                occasionID,
                itemName,
                brand,
                size,
                colour,
                itemCondition,
                description,
                imageName,
                status
            )
            VALUES
            (
                :ownerID,
                :categoryID,
                :occasionID,
                :itemName,
                :brand,
                :size,
                :colour,
                :itemCondition,
                :description,
                :imageName,
                :status
            )
        ';

        $statement = $db->prepare($query);
        $statement->bindValue(':ownerID', $ownerID, PDO::PARAM_INT);
        $statement->bindValue(':categoryID', $categoryID, PDO::PARAM_INT);
        $statement->bindValue(':occasionID', $occasionID, PDO::PARAM_INT);
        $statement->bindValue(':itemName', $itemName);
        $statement->bindValue(':brand', $brand);
        $statement->bindValue(':size', $size);
        $statement->bindValue(':colour', $colour);
        $statement->bindValue(':itemCondition', $itemCondition);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':imageName', $imageName);
        $statement->bindValue(':status', 'Available');
        $statement->execute();

        $itemID = (int) $db->lastInsertId();
        $statement->closeCursor();

        return $itemID;
    }


    // Get one item only when it belongs to the specified owner.
    public static function getOwnedById($itemID, $ownerID)
    {
        $db = Database::getDB();

        $query = '
            SELECT
                itemID,
                ownerID,
                categoryID,
                occasionID,
                itemName,
                brand,
                size,
                colour,
                itemCondition,
                description,
                imageName,
                status,
                dateAdded
            FROM items
            WHERE itemID = :itemID
              AND ownerID = :ownerID
        ';

        $statement = $db->prepare($query);
        $statement->bindValue(':itemID', $itemID, PDO::PARAM_INT);
        $statement->bindValue(':ownerID', $ownerID, PDO::PARAM_INT);
        $statement->execute();

        $item = $statement->fetch();
        $statement->closeCursor();

        return $item;
    }


    // Update a listing only when it belongs to the specified owner.
    public static function updateOwned(
        $itemID,
        $ownerID,
        $categoryID,
        $occasionID,
        $itemName,
        $brand,
        $size,
        $colour,
        $itemCondition,
        $description,
        $imageName
    ) {
        $db = Database::getDB();

        $query = '
            UPDATE items
            SET
                categoryID = :categoryID,
                occasionID = :occasionID,
                itemName = :itemName,
                brand = :brand,
                size = :size,
                colour = :colour,
                itemCondition = :itemCondition,
                description = :description,
                imageName = :imageName
            WHERE itemID = :itemID
              AND ownerID = :ownerID
        ';

        $statement = $db->prepare($query);
        $statement->bindValue(':categoryID', $categoryID, PDO::PARAM_INT);
        $statement->bindValue(':occasionID', $occasionID, PDO::PARAM_INT);
        $statement->bindValue(':itemName', $itemName);
        $statement->bindValue(':brand', $brand);
        $statement->bindValue(':size', $size);
        $statement->bindValue(':colour', $colour);
        $statement->bindValue(':itemCondition', $itemCondition);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':imageName', $imageName);
        $statement->bindValue(':itemID', $itemID, PDO::PARAM_INT);
        $statement->bindValue(':ownerID', $ownerID, PDO::PARAM_INT);
        $statement->execute();
        $statement->closeCursor();
    }


    // Check whether an item has a request that is still active.
    public static function hasActiveRequest($itemID)
    {
        $db = Database::getDB();

        $query = '
            SELECT COUNT(*) AS requestCount
            FROM borrow_requests
            WHERE itemID = :itemID
              AND status IN ("Pending", "Approved", "Borrowed")
        ';

        $statement = $db->prepare($query);
        $statement->bindValue(':itemID', $itemID, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();

        return (int) $result['requestCount'] > 0;
    }


    // Delete a listing only when it belongs to the specified owner.
    public static function deleteOwned($itemID, $ownerID)
    {
        $db = Database::getDB();

        $query = '
            DELETE FROM items
            WHERE itemID = :itemID
              AND ownerID = :ownerID
        ';

        $statement = $db->prepare($query);
        $statement->bindValue(':itemID', $itemID, PDO::PARAM_INT);
        $statement->bindValue(':ownerID', $ownerID, PDO::PARAM_INT);
        $statement->execute();

        $deleted = $statement->rowCount();
        $statement->closeCursor();

        return $deleted > 0;
    }


    // Get all listings for the admin area.
    public static function getAllForAdmin()
    {
        $db = Database::getDB();

        $query = '
            SELECT
                i.itemID,
                i.itemName,
                i.brand,
                i.size,
                i.status,
                i.imageName,
                i.dateAdded,
                c.categoryName,
                o.occasionName,
                u.firstName,
                u.lastName
            FROM items i
            JOIN categories c ON i.categoryID = c.categoryID
            JOIN occasions o ON i.occasionID = o.occasionID
            JOIN users u ON i.ownerID = u.userID
            ORDER BY i.dateAdded DESC
        ';

        $statement = $db->prepare($query);
        $statement->execute();
        $items = $statement->fetchAll();
        $statement->closeCursor();

        return $items;
    }


    // Delete a listing from the admin area.
    public static function deleteByAdmin($itemID)
    {
        $db = Database::getDB();

        $query = 'DELETE FROM items WHERE itemID = :itemID';
        $statement = $db->prepare($query);
        $statement->bindValue(':itemID', $itemID, PDO::PARAM_INT);
        $statement->execute();

        $deleted = $statement->rowCount();
        $statement->closeCursor();

        return $deleted > 0;
    }
}
