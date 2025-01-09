<?php
require __DIR__ . '/../repositories/foodrepository.php';

class FoodService {

    private $repository;

    public function __construct() {
        $this->repository = new FoodRepository();
    }

    public function getAllFoods() {
        return $this->repository->getAllFoods();
    }

    public function getFoodById($id) {
        return $this->repository->getFoodById($id);
    }
    
    public function addFood($food) {
        $this->repository->insertFood($food);
    }    
}
