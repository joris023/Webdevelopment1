<?php
require_once __DIR__ . '/repository.php';
require __DIR__ . '/../models/order.php';

class OrderRepository extends Repository {

    public function saveOrder(Order $order) {
        try {
            $this->connection->beginTransaction();

            // Insert into orders
            $stmt = $this->connection->prepare(
                "INSERT INTO orders (user_id, table_number, total_amount) VALUES (?, ?, ?)"
            );
            $stmt->execute([
                $order->getUserId(),
                $order->getTableNumber(),
                $order->getTotalAmount(),
            ]);

            $orderId = $this->connection->lastInsertId();

            // Insert foods
            foreach ($order->getFoods() as $food) {
                $stmt = $this->connection->prepare(
                    "INSERT INTO order_foods (order_id, food_id, quantity) VALUES (?, ?, ?)"
                );
                $stmt->execute([
                    $orderId,
                    $food['id'],
                    $food['quantity'],
                ]);
            }

            // Insert drinks
            foreach ($order->getDrinks() as $drink) {
                $stmt = $this->connection->prepare(
                    "INSERT INTO order_drinks (order_id, drink_id, quantity) VALUES (?, ?, ?)"
                );
                $stmt->execute([
                    $orderId,
                    $drink['id'],
                    $drink['quantity'],
                ]);
            }

            $this->connection->commit();
        } catch (PDOException $e) {
            $this->connection->rollBack();
            error_log("Database error in saveOrder: " . $e->getMessage());
            throw $e; // Optional: Handle this in the calling code.
        }
    }

    public function getOrderById($orderId) {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM orders WHERE id = ?");
            $stmt->execute([$orderId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error in getOrderById: " . $e->getMessage());
            return null;
        }
    }

    public function getAllOrders() {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM orders");
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Order");
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Database error in getAllOrders: " . $e->getMessage());
            return [];
        }
    }

    public function deleteItem($id) {
        try {
            $stmt = $this->connection->prepare("DELETE FROM orders WHERE id = ?");
            $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Database error in deleteItem: " . $e->getMessage());
        }
    }

    public function getOrderFoods($orderId) {
        try {
            $stmt = $this->connection->prepare("
                SELECT f.name, of.quantity 
                FROM order_foods of 
                JOIN foods f ON of.food_id = f.id 
                WHERE of.order_id = ?
            ");
            $stmt->execute([$orderId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error in getOrderFoods: " . $e->getMessage());
            return [];
        }
    }

    public function getOrderDrinks($orderId) {
        try {
            $stmt = $this->connection->prepare("
                SELECT d.name, od.quantity 
                FROM order_drinks od 
                JOIN drinks d ON od.drink_id = d.id 
                WHERE od.order_id = ?
            ");
            $stmt->execute([$orderId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error in getOrderDrinks: " . $e->getMessage());
            return [];
        }
    }
}
