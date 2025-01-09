<?php
require_once __DIR__ . '/../repositories/foodrepository.php';
require_once __DIR__ . '/../repositories/drinkrepository.php';

class MenuService {
    private $foodRepository;
    private $drinkRepository;

    public function __construct() {
        $this->foodRepository = new FoodRepository();
        $this->drinkRepository = new DrinkRepository();
    }

    public function getAllMenuItems() {
        $foods = $this->foodRepository->getAllFoods();
        $drinks = $this->drinkRepository->getAllDrinks();

        // Combine foods en drinks in één array
        return ['foods' => $foods, 'drinks' => $drinks];
    }

    public function addMenuItem($type, $item) {
        if ($type === 'food') {
            return $this->foodRepository->insertFood($item);
        } elseif ($type === 'drink') {
            return $this->drinkRepository->insertDrink($item);
        } else {
            throw new Exception("Invalid menu type.");
        }
    }

    public function updateStock($type, $id, $newStock) {
        if ($type === 'food') {
            return $this->foodRepository->updateStock($id, $newStock);
        } elseif ($type === 'drink') {
            return $this->drinkRepository->updateStock($id, $newStock);
        } else {
            throw new Exception("Invalid menu type.");
        }
    }

    public function getMenuItemById($id) {
        $food = $this->foodRepository->getFoodById($id);
        if ($food) {
            return ['type' => 'food', 'item' => $food];
        }
    
        $drink = $this->drinkRepository->getDrinkById($id);
        if ($drink) {
            return ['type' => 'drink', 'item' => $drink];
        }
    
        throw new Exception("Item not found.");
    }
    
    public function deleteMenuItem($type, $id) {
        if ($type === 'food') {
            $this->foodRepository->deleteItem($id);
        } elseif ($type === 'drink') {
            $this->drinkRepository->deleteItem($id);
        } else {
            throw new Exception("Invalid menu type.");
        }
    }    
}
?>
