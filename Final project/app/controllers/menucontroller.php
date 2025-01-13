<?php
require __DIR__ . '/controller.php';
require __DIR__ . '/../services/foodservice.php';
require __DIR__ . '/../services/drinkservice.php';

class MenuController extends Controller {

    private $foodService;
    private $drinkService;

    public function __construct() {
        //session_start();
        $this->foodService = new FoodService();
        $this->drinkService = new DrinkService();
    }

    public function index() {
        $this->displayView([]);
    }

    public function food() {
        $foods = $this->foodService->getAllFoods();
        $this->displayView(['foods' => $foods]);
    }

    public function drink() {
        $drinks = $this->drinkService->getAllDrinks();
        $this->displayView(['drinks' => $drinks]);
    }

    public function addDrinkToOrder() {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $drinkId = $_POST['drink_id'];
        $quantity = $_POST['quantity'];
    
        if (!isset($_SESSION['order']['drinks'])) {
            $_SESSION['order']['drinks'] = [];
        }
    
        $found = false;
        foreach ($_SESSION['order']['drinks'] as &$drink) {
            if ($drink['id'] == $drinkId) {
                $drink['quantity'] += $quantity; // Update quantity
                $found = true;
                break;
            }
        }
    
        if (!$found) {
            $_SESSION['order']['drinks'][] = ['id' => $drinkId, 'quantity' => $quantity];
        }
    
        header("Location: /menu/drink");
        exit();
    }
    
    public function addFoodToOrder() {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $foodId = $_POST['food_id'];
        $quantity = $_POST['quantity'];
    
        if (!isset($_SESSION['order']['foods'])) {
            $_SESSION['order']['foods'] = [];
        }
    
        $found = false;
        foreach ($_SESSION['order']['foods'] as &$food) {
            if ($food['id'] == $foodId) {
                $food['quantity'] += $quantity;
                $found = true;
                break;
            }
        }
    
        if (!$found) {
            $_SESSION['order']['foods'][] = ['id' => $foodId, 'quantity' => $quantity];
        }
    
        header("Location: /menu/food"); // Terug naar de etenpagina
    }
    
}
