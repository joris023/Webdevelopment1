<?php
require_once __DIR__ . '/repository.php';
require __DIR__ . '/../models/drink.php';

class DrinkRepository extends Repository {

    public function getAllDrinks() {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM drinks");
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Drink');
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Database error in getAllDrinks: " . $e->getMessage());
            return [];
        }
    }

    public function getDrinkById($id) {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if ($id === false) {
            throw new Exception("Invalid Drink ID");
        }

        try {
            $stmt = $this->connection->prepare("SELECT * FROM drinks WHERE id = ?");
            $stmt->execute([$id]);
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Drink');
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Database error in getDrinkById: " . $e->getMessage());
            return null;
        }
    }

    public function getStockById($id) {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if ($id === false) {
            throw new Exception("Invalid Stock ID");
        }

        try {
            $stmt = $this->connection->prepare("SELECT stock FROM drinks WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Database error in getStockById: " . $e->getMessage());
            return null;
        }
    }

    public function insertDrink($drink) {
        try {
            $stmt = $this->connection->prepare(
                "INSERT INTO drinks (name, description, price, stock, image) VALUES (?, ?, ?, ?, ?)"
            );
            $stmt->execute([
                htmlspecialchars($drink['name']),
                htmlspecialchars($drink['description']),
                filter_var($drink['price'], FILTER_VALIDATE_FLOAT),
                filter_var($drink['stock'], FILTER_VALIDATE_INT),
                htmlspecialchars($drink['image'])
            ]);
            return $this->connection->lastInsertId();
        } catch (PDOException $e) {
            error_log("Database error in insertDrink: " . $e->getMessage());
            return false;
        }
    }

    public function updateStock($id, $stock) {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $stock = filter_var($stock, FILTER_VALIDATE_INT);

        if ($id === false || $stock === false) {
            throw new Exception("Invalid input for updateStock");
        }

        try {
            $stmt = $this->connection->prepare("UPDATE drinks SET stock = ? WHERE id = ?");
            $stmt->execute([$stock, $id]);
        } catch (PDOException $e) {
            error_log("Database error in updateStock: " . $e->getMessage());
        }
    }

    public function deleteItem($id) {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if ($id === false) {
            throw new Exception("Invalid Item ID");
        }

        try {
            $stmt = $this->connection->prepare("DELETE FROM drinks WHERE id = ?");
            $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Database error in deleteItem: " . $e->getMessage());
        }
    }
}
