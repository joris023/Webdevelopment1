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
            foreach ($order->getFoods() as $food) {
                $currentStock = $this->foodRepository->getStockById($food['id']);
                error_log("Food ID: {$food['id']}, Current Stock: {$currentStock}, Requested Quantity: {$food['quantity']}");
                if ($currentStock < $food['quantity']) {
                    $nameFood = $this->foodRepository->getNameById($food['id']);
                    throw new Exception("Not enough stock for food $nameFood: Available {$currentStock}, Requested {$food['quantity']}");
                }
            }
    
            foreach ($order->getDrinks() as $drink) {
                $currentStock = $this->drinkRepository->getStockById($drink['id']);
                error_log("Drink ID: {$drink['id']}, Current Stock: {$currentStock}, Requested Quantity: {$drink['quantity']}");
                if ($currentStock < $drink['quantity']) {
                    $nameDrink = $this->drinkRepository->getNameById($drink['id']);
                    throw new Exception("Not enough stock for drink $nameDrink: Available {$currentStock}, Requested {$drink['quantity']}");
                }
            }
    
            $this->orderRepository->saveOrder($order);
    
            foreach ($order->getFoods() as $food) {
                $currentStock = $this->foodRepository->getStockById($food['id']);
                $newStock = $currentStock - $food['quantity'];
                $this->foodRepository->updateStock($food['id'], $newStock);
            }
    
            foreach ($order->getDrinks() as $drink) {
                $currentStock = $this->drinkRepository->getStockById($drink['id']);
                $newStock = $currentStock - $drink['quantity'];
                $this->drinkRepository->updateStock($drink['id'], $newStock);
            }
    
            $_SESSION['order'] = [];
    
        } catch (Exception $e) {
            error_log("Order placement failed: " . $e->getMessage());
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
