<?php

class Drink implements JsonSerializable {

    private int $id;
    private string $name;
    private float $price;
    private string $description;
    private ?string $image;
    private int $stock;
    public int $quantity = 0;

    public function jsonSerialize(): array {
        return get_object_vars($this);
    }

    public function getStock(): int {
        return $this->stock;
    }

    public function setStock(int $stock): self {
        $this->stock = $stock;
        return $this;
    }

    public function getImage(): ?string {
        return $this->image;
    }

    public function setImage(?string $image): self {
        $this->image = $image;
        return $this;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): self {
        $this->id = $id;
        return $this;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): self {
        $this->name = $name;
        return $this;
    }

    public function getPrice(): float {
        return $this->price;
    }

    public function setPrice(float $price): self {
        $this->price = $price;
        return $this;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function setDescription(string $description): self {
        $this->description = $description;
        return $this;
    }
}
