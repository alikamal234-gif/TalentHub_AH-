<?php

class Offer
{
    private int $id;
    private Categorie $category;
    private User $owner;
    private string $name;
    private string $description;
    private float $salary;
    private ?string $createdAt;
    private ?string $deletedAt;

    public function __construct(
        Categorie $category,
        User $owner,
        string $name,
        string $description,
        float $salary
    ) {
        $this->category = $category;
        $this->owner = $owner;
        $this->name = $name;
        $this->description = $description;
        $this->salary = $salary;
        $this->createdAt = date('Y-m-d');
    }


    public function getId(){
        return $this->id;
    }
    public function getCategory(){
        return $this->category;
    }
    public function getOwner(){
        return $this->owner;
    }
    public function getName(){
        return $this->name;
    }
    public function getDescription(){
        return $this->description;
    }
    public function getSalary(){
        return $this->salary;
    }
    public function getCreatedAt(){
        return $this->createdAt;
    }
    public function getDeletedAt(){
        return $this->deletedAt;
    }




    public function setId($id){
        $this->id = $id;
    }
    public function setCategory($category){
        $this->category = $category;
    }
    public function setOwner($owner){
        $this->owner = $owner;
    }
    public function setName($name){
        $this->name = $name;
    }
    public function setDescription($description){
        $this->description = $description;
    }
    public function setSalary($salary){
        $this->salary = $salary;
    }
    public function setCreatedAt($createdAt){
        $this->createdAt = $createdAt;
    }
    public function setDeletedAt($deletedAt){
        $this->deletedAt = $deletedAt;
    }
}
