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
            echo $e->getMessage();
        }
    }

    public function getDrinkById($id) {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM drinks WHERE id = ?");
            $stmt->execute([$id]);
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Drink');
            return $stmt->fetch();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function getStockById($id) {
        try {
            $stmt = $this->connection->prepare("SELECT stock FROM drinks WHERE id = ?");
            $stmt->execute([$id]);
            //$stmt->setFetchMode(PDO::FETCH_CLASS, 'Food');
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function insertDrink($drink) {
        try {
            $stmt = $this->connection->prepare(
                "INSERT INTO foods (name, description, price, stock, image) VALUES (?, ?, ?, ?, ?)"
            );
            $stmt->execute([
                $drink['name'],
                $drink['description'],
                $drink['price'],
                $drink['stock'],
                $drink['image']
            ]);
            return $this->connection->lastInsertId();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    
    public function updateStock($id, $stock) {
        try {
            $stmt = $this->connection->prepare("UPDATE drinks SET stock = ? WHERE id = ?");
            $stmt->execute([$stock, $id]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function deleteItem($id) {
        try {
            $stmt = $this->connection->prepare("DELETE FROM drinks WHERE id = ?");
            $stmt->execute([$id]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
