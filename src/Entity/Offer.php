<?php

namespace App\Entity;

use DateTimeImmutable;

class Offer
{
    private int $id;
    private Categorie $category;
    private User $owner;
    private string $name;
    private string $description;
    private float $salary;
    private DateTimeImmutable $createdAt;
    private ?DateTimeImmutable $deletedAt = null;

    public function __construct(
        Categorie $category,
        User      $owner,
        string    $name,
        string    $description,
        float     $salary
    )
    {
        $this->category = $category;
        $this->owner = $owner;
        $this->name = $name;
        $this->description = $description;
        $this->salary = $salary;
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getCategory(): Categorie
    {
        return $this->category;
    }

    public function setCategory(Categorie $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function getOwner(): User
    {
        return $this->owner;
    }

    public function setOwner(User $owner): self
    {
        $this->owner = $owner;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getSalary(): float
    {
        return $this->salary;
    }

    public function setSalary(float $salary): self
    {
        $this->salary = $salary;
        return $this;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getDeletedAt(): ?DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?DateTimeImmutable $deletedAt): self
    {
        $this->deletedAt = $deletedAt;
        return $this;
    }
}
