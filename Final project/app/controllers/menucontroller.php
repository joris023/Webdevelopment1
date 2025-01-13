<?php
require __DIR__ . '/controller.php';
require __DIR__ . '/../services/foodservice.php';
require __DIR__ . '/../services/drinkservice.php';

class MenuController extends Controller {

    private $foodService;
    private $drinkService;

    public function __construct() {
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
        $drinkId = filter_input(INPUT_POST, 'drink_id', FILTER_VALIDATE_INT);
        $quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);

        if ($drinkId === false || $quantity === false || $quantity <= 0) {
            header("Location: /menu/drink?error=Invalid input");
            exit();
        }

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
        $foodId = filter_input(INPUT_POST, 'food_id', FILTER_VALIDATE_INT);
        $quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);

        if ($foodId === false || $quantity === false || $quantity <= 0) {
            header("Location: /menu/food?error=Invalid input");
            exit();
        }

        if (!isset($_SESSION['order']['foods'])) {
            $_SESSION['order']['foods'] = [];
        }

        $found = false;
        foreach ($_SESSION['order']['foods'] as &$food) {
            if ($food['id'] == $foodId) {
                $food['quantity'] += $quantity; // Update quantity
                $found = true;
                break;
            }
        }

        if (!$found) {
            $_SESSION['order']['foods'][] = ['id' => $foodId, 'quantity' => $quantity];
        }

        header("Location: /menu/food");
        exit();
    }
}
