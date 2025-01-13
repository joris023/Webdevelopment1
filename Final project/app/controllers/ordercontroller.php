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
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        if (!isset($_SESSION['table_number'])) {
            header("Location: /login/tablenumber");
            exit();
        }

        $this->foodService = new FoodService();
        $this->drinkService = new DrinkService();
        $this->orderService = new OrderService();
    }

    public function index() {
        $foods = [];
        $drinks = [];
        $totalAmount = 0;

        if (!empty($_SESSION['order']['foods'])) {
            foreach ($_SESSION['order']['foods'] as $foodOrder) {
                $food = $this->foodService->getFoodById(filter_var($foodOrder['id'], FILTER_VALIDATE_INT));
                if ($food) {
                    $food->quantity = filter_var($foodOrder['quantity'], FILTER_VALIDATE_INT);
                    $foods[] = $food;
                    $totalAmount += $food->getPrice() * $food->quantity;
                }
            }
        }

        if (!empty($_SESSION['order']['drinks'])) {
            foreach ($_SESSION['order']['drinks'] as $drinkOrder) {
                $drink = $this->drinkService->getDrinkById(filter_var($drinkOrder['id'], FILTER_VALIDATE_INT));
                if ($drink) {
                    $drink->quantity = filter_var($drinkOrder['quantity'], FILTER_VALIDATE_INT);
                    $drinks[] = $drink;
                    $totalAmount += $drink->getPrice() * $drink->quantity;
                }
            }
        }

        $_SESSION['order_total'] = $totalAmount;

        $this->displayView([
            'foods' => $foods,
            'drinks' => $drinks,
            'totalAmount' => $totalAmount,
        ]);
    }

    public function updateFood() {
        $foodId = filter_input(INPUT_POST, 'food_id', FILTER_VALIDATE_INT);
        $action = $_POST['action'];

        if ($foodId && isset($_SESSION['order']['foods'])) {
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
        $foodId = filter_input(INPUT_POST, 'food_id', FILTER_VALIDATE_INT);

        if ($foodId && isset($_SESSION['order']['foods'])) {
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
        $drinkId = filter_input(INPUT_POST, 'drink_id', FILTER_VALIDATE_INT);
        $action = $_POST['action'];

        if ($drinkId && isset($_SESSION['order']['drinks'])) {
            foreach ($_SESSION['order']['drinks'] as &$drink) {
                if ($drink['id'] == $drinkId) {
                    if ($action === 'increment') {
                        $drink['quantity']++;
                    } elseif ($action === 'decrement' && $drink['quantity'] > 1) {
                        $drink['quantity']--;
                    }
                    break;
                }
            }
        }

        header("Location: /order");
        exit();
    }

    public function deleteDrink() {
        $drinkId = filter_input(INPUT_POST, 'drink_id', FILTER_VALIDATE_INT);

        if ($drinkId && isset($_SESSION['order']['drinks'])) {
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
        $order = new Order();
        $order->setUserId($_SESSION['user_id']);
        $order->setTableNumber($_SESSION['table_number']);
        $order->setTotalAmount($_SESSION['order_total']);
        $order->setFoods($_SESSION['order']['foods'] ?? []);
        $order->setDrinks($_SESSION['order']['drinks'] ?? []);

        try {
            $this->orderService->placeOrder($order);
            $this->confirmation();
        } catch (Exception $e) {
            error_log("Checkout error: " . $e->getMessage());
            $errorMessage = urlencode($e->getMessage());
            header("Location: /order?error=Checkout failed: $errorMessage");
            exit();
        }
    }

    public function confirmation() {
        $this->displayView([]);
    }
}
