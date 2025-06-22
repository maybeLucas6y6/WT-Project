<?php

class UserAlreadyExistsException extends Exception
{
    protected $message = 'User already exists';
}

class UserModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function register($username, $password, $email, $phoneNumber): bool
    {
        if ($this->checkIfUserExists($username)) {
            throw new UserAlreadyExistsException();
        }

        $password = password_hash($password, PASSWORD_BCRYPT);
        $query = 'INSERT INTO users (username, password, email, phone_number) VALUES ($1, $2, $3, $4)';
        $result = pg_query_params($this->db, $query, [$username, $password, $email, $phoneNumber]);

        if ($result && pg_affected_rows($result) > 0) {
            return true;
        } else {
            throw new Exception('Failed to register user: ' . pg_last_error($this->db));
        }
    }

    public function checkIfUserExists($username)
    {
        $query = 'SELECT * FROM users WHERE username = $1';
        $result = pg_query_params($this->db, $query, [$username]);

        if ($result && pg_num_rows($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getUserByUsername($username)
    {
        $query = 'SELECT * FROM users WHERE username = $1';
        $result = pg_query_params($this->db, $query, [$username]);

        if ($result && pg_num_rows($result) > 0) {
            return pg_fetch_assoc($result);
        } else {
            return null;
        }
    }

    public function getUserById($id)
    {
        $query = 'SELECT * FROM users WHERE id = $1';
        $result = pg_query_params($this->db, $query, [$id]);

        if ($result && pg_num_rows($result) > 0) {
            return pg_fetch_assoc($result);
        } else {
            return null;
        }
    }

    public function isUserAdmin($userId)
    {
        $query = 'SELECT is_admin FROM users WHERE id = $1';
        $result = pg_query_params($this->db, $query, [$userId]);

        if ($result && pg_num_rows($result) > 0) {
            $user = pg_fetch_assoc($result);
            return (bool)$user['is_admin'];
        } else {
            return false;
        }
    }
}
