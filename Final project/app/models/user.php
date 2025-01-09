<?php

class User implements JsonSerializable {
    private int $id;
    private string $firstname;
    private string $email;
    private string $password;
    private string $role;

    public function jsonSerialize(): array {
        return get_object_vars($this);
    }

    public function getId(): int {
        return $this->id;
    }

    public function getFirstname(): string {
        return $this->firstname;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function getRole(): string {
        return $this->role;
    }
}
