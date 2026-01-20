<?php

class Candidature
{
    private int $id;
    private User $user;
    private Offer $offer;
    private ?string $message;
    private $cv; 
    private string $status; 
    private ?string $createdAt;

    public function __construct(User $user, Offer $offer, ?string $message = null)
    {
        $this->user = $user;
        $this->offer = $offer;
        $this->message = $message;
        $this->status = 'pending';
        $this->createdAt = date('Y-m-d');
    }

    public function accept(): void
    {
        $this->status = 'accepted';
    }

    public function reject(): void
    {
        $this->status = 'rejected';
    }

    public function getId(){
        return $this->id;
    }
    public function getUser(){
        return $this->user;
    }
    public function getOffer(){
        return $this->offer;
    }
    public function getMessage(){
        return $this->message;
    }
    public function getCv(){
        return $this->cv;
    }
    public function getStatus(){
        return $this->status;
    }
    public function getCreatedAt(){
        return $this->createdAt;
    }




    public function setId($id){
        $this->id = $id;
    }
    public function setUser($user){
        $this->user = $user;
    }
    public function setOffer($offer){
        $this->offer = $offer;
    }
    public function setMessage($message){
        $this->message = $message;
    }
    public function setCv($cv){
        $this->cv = $cv;
    }
    public function setStatus($status){
        $this->status = $status;
    }
    public function setCreatedAt($createdAt){
        $this->createdAt = $createdAt;
    }
}
