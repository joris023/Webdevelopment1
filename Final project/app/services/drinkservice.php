<?php
require __DIR__ . '/../repositories/drinkrepository.php';

class DrinkService {

    private $repository;

    public function __construct() {
        $this->repository = new DrinkRepository();
    }

    public function getAllDrinks() {
        return $this->repository->getAllDrinks();
    }

    public function getDrinkById($id) {
        return $this->repository->getDrinkById($id);
    }

    public function addDrink($drink) {
        $this->repository->insertDrink($drink);
    }
}
