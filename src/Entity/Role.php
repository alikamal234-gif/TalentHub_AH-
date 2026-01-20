<?php

class Role
{
    private int $id;
    private string $name;
    private ?string $createdAt;
    private ?string $deletedAt;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->createdAt = date('Y-m-d');
        $this->deletedAt = null;
    }

    public function getId(): int{
        return $this->id;
    }

    public function getName(): string{
        return $this->name;
    }

    public function getCreatedAt(): ?string{
        return $this->createdAt;
    }

    public function getDeletedAt(): ?string{
        return $this->deletedAt;
    }

    public function setId(int $id): void{
        $this->id = $id;
    }

    public function setName(string $name): void{
        $this->name = $name;
    }

    public function setCreatedAt(?string $createdAt): void{
        $this->createdAt = $createdAt;
    }

    public function setDeletedAt(?string $deletedAt): void{
        $this->deletedAt = $deletedAt;
    }
}
