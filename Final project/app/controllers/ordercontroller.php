<?php
require_once __DIR__ . '/controller.php';
require_once __DIR__ . '/../services/foodservice.php';
require_once __DIR__ . '/../services/drinkservice.php';
require_once __DIR__ . '/../services/orderservice.php';
require_once __DIR__ . '/../models/order.php'; // Include the Order class

class OrderController extends Controller {
    private $foodService;
    private $drinkService;
    private $orderService;

    public function __construct() {
        //session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }
    
        if (!isset($_SESSION['table_number'])) {
            header("Location: /login/tablenumber");
            exit();
            //$_SESSION['table_number'] = 5; // Example table number
        }
        $this->foodService = new FoodService();
        $this->drinkService = new DrinkService();
        $this->orderService = new OrderService();
    }

    public function index() {
        $foods = [];
        $drinks = [];
        $totalAmount = 0;

        // Fetch food details
        if (!empty($_SESSION['order']['foods'])) {
            foreach ($_SESSION['order']['foods'] as $foodOrder) {
                $food = $this->foodService->getFoodById($foodOrder['id']);
                if ($food) {
                    $food->quantity = $foodOrder['quantity'];
                    $foods[] = $food;
                    $totalAmount += $food->getPrice() * $food->quantity;
                }
            }
        }

        // Fetch drink details
        if (!empty($_SESSION['order']['drinks'])) {
            foreach ($_SESSION['order']['drinks'] as $drinkOrder) {
                $drink = $this->drinkService->getDrinkById($drinkOrder['id']);
                if ($drink) {
                    $drink->quantity = $drinkOrder['quantity'];
                    $drinks[] = $drink;
                    $totalAmount += $drink->getPrice() * $drink->quantity;
                }
            }
        }

        $_SESSION['order_total'] = $totalAmount;

        // Pass data to the view
        $this->displayView([
            'foods' => $foods,
            'drinks' => $drinks,
            'totalAmount' => $totalAmount,
        ]);
    }

    public function updateFood() {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $foodId = $_POST['food_id'];
        $action = $_POST['action'];
    
        if (isset($_SESSION['order']['foods'])) {
            foreach ($_SESSION['order']['foods'] as &$food) {
                if ($food['id'] == $foodId) {
                    if ($action === 'increment') {
                        $food['quantity']++;
                    } elseif ($action === 'decrement' && $food['quantity'] > 1) {
                        $food['quantity']--;
                    }
                    break;
                }
            }
        }
    
        header("Location: /order");
        exit();
    }

    public function deleteFood() {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $foodId = $_POST['food_id'];

        if (isset($_SESSION['order']['foods'])) {
            foreach ($_SESSION['order']['foods'] as $key => $food) {
                if ($food['id'] == $foodId) {
                    unset($_SESSION['order']['foods'][$key]);
                    break;
                }
            }
        }
        header("Location: /order");
        exit();
    }

    public function updateDrink() {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $foodId = $_POST['drink_id'];
        $action = $_POST['action'];
    
        if (isset($_SESSION['order']['drinks'])) {
            foreach ($_SESSION['order']['drinks'] as &$food) {
                if ($food['id'] == $foodId) {
                    if ($action === 'increment') {
                        $food['quantity']++;
                    } elseif ($action === 'decrement' && $food['quantity'] > 1) {
                        $food['quantity']--;
                    }
                    break;
                }
            }
        }
    
        header("Location: /order");
        exit();
    }

    public function deleteDrink() {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $drinkId = $_POST['drink_id'];

        if (isset($_SESSION['order']['drinks'])) {
            foreach ($_SESSION['order']['drinks'] as $key => $drink) {
                if ($drink['id'] == $drinkId) {
                    unset($_SESSION['order']['drinks'][$key]);
                    break;
                }
            }
        }
        header("Location: /order");
        exit();
    }

    public function checkout() {

        //var_dump($_SESSION['order']['foods']);
        // Build the Order object from the session
        $order = new Order();
        $order->setUserId($_SESSION['user_id']); // Assume user ID is stored in session
        $order->setTableNumber($_SESSION['table_number']);
        $order->setTotalAmount($_SESSION['order_total']);
        $order->setFoods($_SESSION['order']['foods'] ?? []);
        $order->setDrinks($_SESSION['order']['drinks'] ?? []);

        try {
            // Place the order
            $this->orderService->placeOrder($order);

            // Redirect to confirmation page
            $this->confirmation();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function confirmation() {
        $this->displayView([]);
    }
    
}

?>