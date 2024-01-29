<?php

namespace Models;

use PDO;

/**
 * LoginSystem class handles the user-related database operations.
 */
class LoginSystem
{
    /**
     * @var PDO The database connection object.
     */
    private $db;

    /**
     * LoginSystem constructor.
     *
     * @param PDO $dbConnection The database connection object.
     */
    public function __construct(PDO $dbConnection)
    {
        $this->db = $dbConnection;
    }

    /**
     * Fetches a user by username.
     *
     * @param string $username The username to search for.
     * @return array|null The user's data or null if not found.
     *
     * searches the user table to find a specific user
     */
    public function getUserByUsername(string $username)
    {
        $stmt = $this->db->prepare("
            SELECT delivery_users.*, delivery_usertype.usertypename
            FROM delivery_users
            INNER JOIN delivery_usertype ON delivery_users.usertype = delivery_usertype.id
            WHERE delivery_users.username = :username
        ");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Verifies if the provided password matches the stored hash.
     *
     * @param string $hash The hash stored in the database.
     * @param string $password The password to verify.
     * @return bool True if the password is correct, false otherwise.
     */
    public function verifyPassword($hash, $password)
    {
        return password_verify($password, $hash);
    }

    /**
     * @return void
     *
     * logs the user out and clears all session tokens and cookies
     */
    public function logout()
    {
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }
}