<?php

require_once __DIR__ . '/Database.php';

class BorrowRequest
{
    // Count requests created by a member.
    public static function countByBorrower($userID)
    {
        $db = Database::getDB();
        $query = 'SELECT COUNT(*) AS requestCount FROM borrow_requests WHERE borrowerID = :userID';
        $statement = $db->prepare($query);
        $statement->bindValue(':userID', $userID, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();

        return (int) $result['requestCount'];
    }


    // Count requests received for items owned by a member.
    public static function countForOwner($ownerID)
    {
        $db = Database::getDB();

        $query = '
            SELECT COUNT(*) AS requestCount
            FROM borrow_requests br
            JOIN items i ON br.itemID = i.itemID
            WHERE i.ownerID = :ownerID
        ';

        $statement = $db->prepare($query);
        $statement->bindValue(':ownerID', $ownerID, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();

        return (int) $result['requestCount'];
    }


    // Count all borrowing requests for the admin dashboard.
    public static function countAll()
    {
        $db = Database::getDB();
        $statement = $db->prepare('SELECT COUNT(*) AS requestCount FROM borrow_requests');
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();

        return (int) $result['requestCount'];
    }


    // Check whether a borrower already has an active request for an item.
    public static function hasActiveRequest($itemID, $borrowerID)
    {
        $db = Database::getDB();

        $query = '
            SELECT COUNT(*) AS requestCount
            FROM borrow_requests
            WHERE itemID = :itemID
              AND borrowerID = :borrowerID
              AND status IN ("Pending", "Approved", "Borrowed")
        ';

        $statement = $db->prepare($query);
        $statement->bindValue(':itemID', $itemID, PDO::PARAM_INT);
        $statement->bindValue(':borrowerID', $borrowerID, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();

        return (int) $result['requestCount'] > 0;
    }


    // Create a new borrowing request.
    public static function add($itemID, $borrowerID, $neededFrom, $neededUntil, $message)
    {
        $db = Database::getDB();

        $query = '
            INSERT INTO borrow_requests
                (itemID, borrowerID, neededFrom, neededUntil, message, status)
            VALUES
                (:itemID, :borrowerID, :neededFrom, :neededUntil, :message, :status)
        ';

        $statement = $db->prepare($query);
        $statement->bindValue(':itemID', $itemID, PDO::PARAM_INT);
        $statement->bindValue(':borrowerID', $borrowerID, PDO::PARAM_INT);
        $statement->bindValue(':neededFrom', $neededFrom);
        $statement->bindValue(':neededUntil', $neededUntil);
        $statement->bindValue(':message', $message);
        $statement->bindValue(':status', 'Pending');
        $statement->execute();

        $requestID = (int) $db->lastInsertId();
        $statement->closeCursor();

        return $requestID;
    }


    // Get all requests created by one borrower.
    public static function getByBorrower($borrowerID)
    {
        $db = Database::getDB();

        $query = '
            SELECT
                br.requestID,
                br.itemID,
                br.neededFrom,
                br.neededUntil,
                br.message,
                br.status,
                br.requestDate,
                i.itemName,
                i.brand,
                i.size,
                i.imageName,
                u.firstName AS ownerFirstName,
                u.lastName AS ownerLastName
            FROM borrow_requests br
            JOIN items i ON br.itemID = i.itemID
            JOIN users u ON i.ownerID = u.userID
            WHERE br.borrowerID = :borrowerID
            ORDER BY br.requestDate DESC
        ';

        $statement = $db->prepare($query);
        $statement->bindValue(':borrowerID', $borrowerID, PDO::PARAM_INT);
        $statement->execute();
        $requests = $statement->fetchAll();
        $statement->closeCursor();

        return $requests;
    }


    // Get all requests for items owned by one member.
    public static function getForOwner($ownerID)
    {
        $db = Database::getDB();

        $query = '
            SELECT
                br.requestID,
                br.itemID,
                br.borrowerID,
                br.neededFrom,
                br.neededUntil,
                br.message,
                br.status,
                br.requestDate,
                i.itemName,
                i.brand,
                i.size,
                i.imageName,
                i.status AS itemStatus,
                u.firstName AS borrowerFirstName,
                u.lastName AS borrowerLastName,
                u.email AS borrowerEmail
            FROM borrow_requests br
            JOIN items i ON br.itemID = i.itemID
            JOIN users u ON br.borrowerID = u.userID
            WHERE i.ownerID = :ownerID
            ORDER BY br.requestDate DESC
        ';

        $statement = $db->prepare($query);
        $statement->bindValue(':ownerID', $ownerID, PDO::PARAM_INT);
        $statement->execute();
        $requests = $statement->fetchAll();
        $statement->closeCursor();

        return $requests;
    }


    // Get one request only when the related item belongs to the owner.
    public static function getForOwnerById($requestID, $ownerID)
    {
        $db = Database::getDB();

        $query = '
            SELECT
                br.requestID,
                br.itemID,
                br.borrowerID,
                br.status,
                i.ownerID,
                i.status AS itemStatus
            FROM borrow_requests br
            JOIN items i ON br.itemID = i.itemID
            WHERE br.requestID = :requestID
              AND i.ownerID = :ownerID
        ';

        $statement = $db->prepare($query);
        $statement->bindValue(':requestID', $requestID, PDO::PARAM_INT);
        $statement->bindValue(':ownerID', $ownerID, PDO::PARAM_INT);
        $statement->execute();
        $request = $statement->fetch();
        $statement->closeCursor();

        return $request;
    }


    // Approve one request and make the item unavailable.
    public static function approve($requestID, $ownerID)
    {
        $db = Database::getDB();
        $request = self::getForOwnerById($requestID, $ownerID);

        if (!$request || $request['status'] !== 'Pending' || $request['itemStatus'] !== 'Available') {
            return false;
        }

        $itemID = (int) $request['itemID'];

        try {
            $db->beginTransaction();

            $query = '
                UPDATE borrow_requests
                SET status = "Approved"
                WHERE requestID = :requestID
                  AND status = "Pending"
            ';

            $statement = $db->prepare($query);
            $statement->bindValue(':requestID', $requestID, PDO::PARAM_INT);
            $statement->execute();

            if ($statement->rowCount() !== 1) {
                $statement->closeCursor();
                $db->rollBack();
                return false;
            }

            $statement->closeCursor();

            // Other pending requests for the same piece are declined.
            $query = '
                UPDATE borrow_requests
                SET status = "Declined"
                WHERE itemID = :itemID
                  AND requestID <> :requestID
                  AND status = "Pending"
            ';

            $statement = $db->prepare($query);
            $statement->bindValue(':itemID', $itemID, PDO::PARAM_INT);
            $statement->bindValue(':requestID', $requestID, PDO::PARAM_INT);
            $statement->execute();
            $statement->closeCursor();

            $query = '
                UPDATE items
                SET status = "Unavailable"
                WHERE itemID = :itemID
                  AND ownerID = :ownerID
            ';

            $statement = $db->prepare($query);
            $statement->bindValue(':itemID', $itemID, PDO::PARAM_INT);
            $statement->bindValue(':ownerID', $ownerID, PDO::PARAM_INT);
            $statement->execute();
            $statement->closeCursor();

            $db->commit();
            return true;

        } catch (PDOException $e) {
            if ($db->inTransaction()) {
                $db->rollBack();
            }
            throw $e;
        }
    }


    // Decline a pending request.
    public static function decline($requestID, $ownerID)
    {
        $db = Database::getDB();
        $request = self::getForOwnerById($requestID, $ownerID);

        if (!$request || $request['status'] !== 'Pending') {
            return false;
        }

        $query = '
            UPDATE borrow_requests
            SET status = "Declined"
            WHERE requestID = :requestID
              AND status = "Pending"
        ';

        $statement = $db->prepare($query);
        $statement->bindValue(':requestID', $requestID, PDO::PARAM_INT);
        $statement->execute();
        $changed = $statement->rowCount();
        $statement->closeCursor();

        return $changed > 0;
    }


    // Cancel a pending request created by the current borrower.
    public static function cancel($requestID, $borrowerID)
    {
        $db = Database::getDB();

        $query = '
            UPDATE borrow_requests
            SET status = "Cancelled"
            WHERE requestID = :requestID
              AND borrowerID = :borrowerID
              AND status = "Pending"
        ';

        $statement = $db->prepare($query);
        $statement->bindValue(':requestID', $requestID, PDO::PARAM_INT);
        $statement->bindValue(':borrowerID', $borrowerID, PDO::PARAM_INT);
        $statement->execute();
        $changed = $statement->rowCount();
        $statement->closeCursor();

        return $changed > 0;
    }


    // Mark an approved request as borrowed and put the item on loan.
    public static function markBorrowed($requestID, $ownerID)
    {
        $db = Database::getDB();
        $request = self::getForOwnerById($requestID, $ownerID);

        if (!$request || $request['status'] !== 'Approved') {
            return false;
        }

        try {
            $db->beginTransaction();

            $query = '
                UPDATE borrow_requests
                SET status = "Borrowed"
                WHERE requestID = :requestID
                  AND status = "Approved"
            ';

            $statement = $db->prepare($query);
            $statement->bindValue(':requestID', $requestID, PDO::PARAM_INT);
            $statement->execute();
            $changed = $statement->rowCount();
            $statement->closeCursor();

            if ($changed !== 1) {
                $db->rollBack();
                return false;
            }

            $query = '
                UPDATE items
                SET status = "On Loan"
                WHERE itemID = :itemID
                  AND ownerID = :ownerID
            ';

            $statement = $db->prepare($query);
            $statement->bindValue(':itemID', $request['itemID'], PDO::PARAM_INT);
            $statement->bindValue(':ownerID', $ownerID, PDO::PARAM_INT);
            $statement->execute();
            $statement->closeCursor();

            $db->commit();
            return true;

        } catch (PDOException $e) {
            if ($db->inTransaction()) {
                $db->rollBack();
            }
            throw $e;
        }
    }


    // Mark a borrowed item as returned and make it available again.
    public static function markReturned($requestID, $ownerID)
    {
        $db = Database::getDB();
        $request = self::getForOwnerById($requestID, $ownerID);

        if (!$request || $request['status'] !== 'Borrowed') {
            return false;
        }

        try {
            $db->beginTransaction();

            $query = '
                UPDATE borrow_requests
                SET status = "Returned"
                WHERE requestID = :requestID
                  AND status = "Borrowed"
            ';

            $statement = $db->prepare($query);
            $statement->bindValue(':requestID', $requestID, PDO::PARAM_INT);
            $statement->execute();
            $changed = $statement->rowCount();
            $statement->closeCursor();

            if ($changed !== 1) {
                $db->rollBack();
                return false;
            }

            $query = '
                UPDATE items
                SET status = "Available"
                WHERE itemID = :itemID
                  AND ownerID = :ownerID
            ';

            $statement = $db->prepare($query);
            $statement->bindValue(':itemID', $request['itemID'], PDO::PARAM_INT);
            $statement->bindValue(':ownerID', $ownerID, PDO::PARAM_INT);
            $statement->execute();
            $statement->closeCursor();

            $db->commit();
            return true;

        } catch (PDOException $e) {
            if ($db->inTransaction()) {
                $db->rollBack();
            }
            throw $e;
        }
    }
}
