<?php

class Order implements JsonSerializable {

    private int $id;
    private int $user_id;
    private int $table_number;
    private float $total_amount;
    private string $created_at;

    private array $foods = []; // Array of ['food_id' => int, 'quantity' => int]
    private array $drinks = []; // Array of ['drink_id' => int, 'quantity' => int]

    public function jsonSerialize(): array {
        return get_object_vars($this);
    }

    // Getters and Setters for core order properties
    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): self {
        $this->id = $id;
        return $this;
    }

    public function getUserId(): int {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self {
        $this->user_id = $user_id;
        return $this;
    }

    public function getTableNumber(): int {
        return $this->table_number;
    }

    public function setTableNumber(int $table_number): self {
        $this->table_number = $table_number;
        return $this;
    }

    public function getTotalAmount(): float {
        return $this->total_amount;
    }

    public function setTotalAmount(float $total_amount): self {
        $this->total_amount = $total_amount;
        return $this;
    }

    public function getCreatedAt(): string {
        return $this->created_at;
    }

    public function setCreatedAt(string $created_at): self {
        $this->created_at = $created_at;
        return $this;
    }

    // Getters and Setters for Foods and Drinks
    public function getFoods(): array {
        return $this->foods;
    }

    public function setFoods(array $foods): self {
        $this->foods = $foods;
        return $this;
    }

    public function getDrinks(): array {
        return $this->drinks;
    }

    public function setDrinks(array $drinks): self {
        $this->drinks = $drinks;
        return $this;
    }
}
