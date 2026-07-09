<?php
declare(strict_types=1);

require_once 'App/Core/BaseModel.php';

class UserModel extends BaseModel
{
    public const ROLES = ['customer', 'baker', 'driver'];

    /**
     * Creates a new user account. Only used for self-registration (role is
     * always 'customer' from RegisterController); staff accounts are seeded
     * directly in the database.
     *
     * @return int|false New user_id, or false if the role is invalid or the username is taken.
     */
    public function register(string $username, string $password, string $role): int|false
    {
        if (!in_array($role, self::ROLES, true)) {
            return false;
        }

        if ($this->findByUsername($username) !== null) {
            return false;
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->db->prepare("INSERT INTO `users` (`username`, `password_hash`, `role`) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $hash, $role);

        if (!$stmt->execute()) {
            return false;
        }

        return $this->db->insert_id;
    }

    public function findByUsername(string $username): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM `users` WHERE `username` = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();

        return $row ?: null;
    }

    /**
     * Checks credentials and returns the user row on success, null otherwise.
     */
    public function verifyLogin(string $username, string $password): ?array
    {
        $user = $this->findByUsername($username);

        if ($user === null || !password_verify($password, $user['password_hash'])) {
            return null;
        }

        return $user;
    }
}
