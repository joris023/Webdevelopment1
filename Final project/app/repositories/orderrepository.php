<?php
require_once __DIR__ . '/repository.php';
require __DIR__ . '/../models/order.php';

class OrderRepository extends Repository {

    public function saveOrder(Order $order) {
        try {
            // Begin transaction
            $this->connection->beginTransaction();

            // Insert order into `orders` table
            $stmt = $this->connection->prepare(
                "INSERT INTO orders (user_id, table_number, total_amount) VALUES (?, ?, ?)"
            );
            $stmt->execute([
                $order->getUserId(),
                $order->getTableNumber(),
                $order->getTotalAmount(),
            ]);

            // Get the inserted order ID
            $orderId = $this->connection->lastInsertId();

            // Insert foods into `order_foods`
            foreach ($order->getFoods() as $food) {
                $stmt = $this->connection->prepare(
                    "INSERT INTO order_foods (order_id, food_id, quantity) VALUES (?, ?, ?)"
                );
                $stmt->execute([$orderId, $food['id'], $food['quantity']]);
            }

            // Insert drinks into `order_drinks`
            foreach ($order->getDrinks() as $drink) {
                $stmt = $this->connection->prepare(
                    "INSERT INTO order_drinks (order_id, drink_id, quantity) VALUES (?, ?, ?)"
                );
                $stmt->execute([$orderId, $drink['id'], $drink['quantity']]);
            }

            // Commit transaction
            $this->connection->commit();
        } catch (PDOException $e) {
            // Rollback transaction on error
            $this->connection->rollBack();
            throw $e;
        }
    }

    public function getOrderById($orderId) {
        try {
            // Fetch order details
            $stmt = $this->connection->prepare(
                "SELECT * FROM orders WHERE id = ?"
            );
            $stmt->execute([$orderId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e->getMessage();
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
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }
    
    public function deleteItem($id) {
        try {
            $stmt = $this->connection->prepare("DELETE FROM orders WHERE id = ?");
            $stmt->execute([$id]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getOrderFoods($orderId) {
        $stmt = $this->connection->prepare("
            SELECT f.name, of.quantity 
            FROM order_foods of 
            JOIN foods f ON of.food_id = f.id 
            WHERE of.order_id = ?");
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getOrderDrinks($orderId) {
        $stmt = $this->connection->prepare("
            SELECT d.name, od.quantity 
            FROM order_drinks od 
            JOIN drinks d ON od.drink_id = d.id 
            WHERE od.order_id = ?");
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
