<?php

require_once __DIR__ . '/Database.php';

class User
{
    // Find a user account by email address.
    public static function getByEmail($email)
    {
        $db = Database::getDB();

        $query = '
            SELECT
                userID,
                firstName,
                lastName,
                email,
                passwordHash,
                role,
                dateCreated,
                isActive
            FROM users
            WHERE email = :email
        ';

        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->execute();
        $user = $statement->fetch();
        $statement->closeCursor();

        return $user;
    }


    // Authenticate a user by email and password.
    public static function authenticate($email, $password)
    {
        $user = self::getByEmail($email);

        if (!$user || (int) $user['isActive'] !== 1) {
            return false;
        }

        if (!password_verify($password, $user['passwordHash'])) {
            return false;
        }

        return $user;
    }


    // Add a new member account.
    public static function add($firstName, $lastName, $email, $passwordHash)
    {
        $db = Database::getDB();

        $query = '
            INSERT INTO users
                (firstName, lastName, email, passwordHash, role)
            VALUES
                (:firstName, :lastName, :email, :passwordHash, :role)
        ';

        $statement = $db->prepare($query);
        $statement->bindValue(':firstName', $firstName);
        $statement->bindValue(':lastName', $lastName);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':passwordHash', $passwordHash);
        $statement->bindValue(':role', 'member');
        $statement->execute();
        $statement->closeCursor();
    }


    // Count all registered users for the admin dashboard.
    public static function countAll()
    {
        $db = Database::getDB();
        $statement = $db->prepare('SELECT COUNT(*) AS userCount FROM users');
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();

        return (int) $result['userCount'];
    }


    // Get all users for the admin area.
    public static function getAll()
    {
        $db = Database::getDB();

        $query = '
            SELECT
                userID,
                firstName,
                lastName,
                email,
                role,
                dateCreated,
                isActive
            FROM users
            ORDER BY dateCreated DESC
        ';

        $statement = $db->prepare($query);
        $statement->execute();
        $users = $statement->fetchAll();
        $statement->closeCursor();

        return $users;
    }


    // Activate or deactivate a member account.
    public static function setActive($userID, $isActive)
    {
        $db = Database::getDB();

        $query = '
            UPDATE users
            SET isActive = :isActive
            WHERE userID = :userID
              AND role = "member"
        ';

        $statement = $db->prepare($query);
        $statement->bindValue(':isActive', $isActive, PDO::PARAM_INT);
        $statement->bindValue(':userID', $userID, PDO::PARAM_INT);
        $statement->execute();
        $changed = $statement->rowCount();
        $statement->closeCursor();

        return $changed > 0;
    }
}
