<?php

class User
{
    private int $id;
    private Role $role;
    private string $name;
    private ?string $speciality = null;
    private string $email;
    private string $password;
    private ?string $phone = null;
    private $image = null;
    private ?string $createdAt;
    private ?string $deletedAt = null;

    public function __construct(
        Role $role,
        string $name,
        string $email,
        string $password
    ) {
        $this->role = $role;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->createdAt = date('Y-m-d');
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function getRole(): Role
    {
        return $this->role;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSpeciality(): ?string
    {
        return $this->speciality;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function getDeletedAt(): ?string
    {
        return $this->deletedAt;
    }


    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setRole(Role $role): self
    {
        $this->role = $role;
        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setSpeciality(?string $speciality): self
    {
        $this->speciality = $speciality;
        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    public function setImage($image): self
    {
        $this->image = $image;
        return $this;
    }

    public function setCreatedAt(?string $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function setDeletedAt(?string $deletedAt): self
    {
        $this->deletedAt = $deletedAt;
        return $this;
    }
}
