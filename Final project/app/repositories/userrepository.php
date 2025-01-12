<?php
require_once __DIR__ . '/repository.php';
require_once __DIR__ . '/../models/user.php';

class UserRepository extends Repository {

    public function getUserByEmail($email) {
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        if ($email === false) {
            throw new Exception("Invalid Email Address");
        }

        try {
            $stmt = $this->connection->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Database error in getUserByEmail: " . $e->getMessage());
            return null;
        }
    }

    public function saveUser($name, $email, $password) {
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        $name = htmlspecialchars($name);
        $password = htmlspecialchars($password);

        if ($email === false) {
            throw new Exception("Invalid Email Address");
        }

        try {
            $stmt = $this->connection->prepare("INSERT INTO users (firstname, email, password, role) VALUES (?, ?, ?, 'customer')");
            $stmt->execute([$name, $email, $password]);
        } catch (PDOException $e) {
            error_log("Database error in saveUser: " . $e->getMessage());
        }
    }
}
