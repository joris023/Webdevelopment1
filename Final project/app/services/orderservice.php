<?php
require_once __DIR__ . '/../repositories/orderrepository.php';
require_once __DIR__ . '/../repositories/foodrepository.php';
require_once __DIR__ . '/../repositories/drinkrepository.php';

class OrderService {

    private $orderRepository;
    private $foodRepository;
    private $drinkRepository;

    public function __construct() {
        $this->orderRepository = new OrderRepository();
        $this->foodRepository = new FoodRepository();
        $this->drinkRepository = new DrinkRepository();
    }

    public function getAllOrders() {
        return $this->orderRepository->getAllOrders();
    }

    public function placeOrder(Order $order) {
        try {
            // Save the order in the database
            $this->orderRepository->saveOrder($order);
    
            // Update stock for foods
            foreach ($order->getFoods() as $food) {
                $currentStock = $this->foodRepository->getStockById($food['id']);
                error_log("Food ID: {$food['id']}, Current Stock: {$currentStock}, Requested Quantity: {$food['quantity']}");
                $newStock = $currentStock - $food['quantity'];
                if ($newStock < 0) {
                    throw new Exception("Not enough stock for food ID: " . $food['id'] . $currentStock);
                }
                $this->foodRepository->updateStock($food['id'], $newStock);
            }
    
            // Update stock for drinks
            foreach ($order->getDrinks() as $drink) {
                $currentStock = $this->drinkRepository->getStockById($drink['id']);
                error_log("Drink ID: {$drink['id']}, Current Stock: {$currentStock}, Requested Quantity: {$drink['quantity']}");
                $newStock = $currentStock - $drink['quantity'];
                if ($newStock < 0) {
                    throw new Exception("Not enough stock for drink ID: " . $drink['id'] . $currentStock);
                }
                $this->drinkRepository->updateStock($drink['id'], $newStock);
            }
    
            // Clear the session after successful order placement
            $_SESSION['order'] = [];
    
        } catch (Exception $e) {
            error_log("Order placement failed: " . $e->getMessage());
            // Log error or rethrow exception
            throw $e;
        }
    }
    

    public function getOrderById($orderId) {
        return $this->orderRepository->getOrderById($orderId);
    }

    public function removeOrder($id) {
        $this->orderRepository->deleteItem($id);
    }

    public function getOrderDetails($orderId) {
        $foods = $this->orderRepository->getOrderFoods($orderId);
        $drinks = $this->orderRepository->getOrderDrinks($orderId);
    
        return [
            'foods' => $foods,
            'drinks' => $drinks
        ];
    }
    
}
