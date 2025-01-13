<?php
require_once __DIR__ . '/repository.php';
require __DIR__ . '/../models/food.php';

class FoodRepository extends Repository {

    public function getAllFoods() {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM foods");
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Food');
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Database error in getAllFoods: " . $e->getMessage());
            return [];
        }
    }

    public function getFoodById($id) {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM foods WHERE id = ?");
            $stmt->execute([$id]);
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Food');
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Database error in getFoodById: " . $e->getMessage());
            return null;
        }
    }

    public function getStockById($id) {
        try {
            $stmt = $this->connection->prepare("SELECT stock FROM foods WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Database error in getStockById: " . $e->getMessage());
            return null;
        }
    }

    public function insertFood($food) {
        try {
            $stmt = $this->connection->prepare(
                "INSERT INTO foods (name, description, price, stock, image) VALUES (?, ?, ?, ?, ?)"
            );
            $stmt->execute([
                $food['name'],
                $food['description'],
                $food['price'],
                $food['stock'],
                $food['image']
            ]);
            return $this->connection->lastInsertId();
        } catch (PDOException $e) {
            error_log("Database error in insertFood: " . $e->getMessage());
            return false;
        }
    }

    public function updateStock($id, $stock) {
        try {
            $stmt = $this->connection->prepare("UPDATE foods SET stock = ? WHERE id = ?");
            $stmt->execute([$stock, $id]);
        } catch (PDOException $e) {
            error_log("Database error in updateStock: " . $e->getMessage());
        }
    }

    public function deleteItem($id) {
        try {
            $stmt = $this->connection->prepare("DELETE FROM foods WHERE id = ?");
            $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Database error in deleteItem: " . $e->getMessage());
        }
    }
}
