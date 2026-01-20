<?php


class Tag
{
    private int $id;
    private string $name;
    private ?string $createdAt;
    private ?string $deletedAt;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->createdAt = date('Y-m-d');
    }



    
    public function getId(){
        return $this->id;
    }
    public function getName(){
        return $this->name;
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
    public function setName($name){
        $this->name = $name;
    }
    public function setCreatedAt($createdAt){
        $this->createdAt = $createdAt;
    }
    public function setDeletedAt($deletedAt){
        $this->deletedAt = $deletedAt;
    }
}
