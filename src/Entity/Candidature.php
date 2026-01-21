<?php

namespace App\Entity;

use DateTimeImmutable;

class Candidature
{
    public const string STATUS_PENDING = 'pending';
    public const string STATUS_ACCEPTED = 'accepted';
    public const string STATUS_REJECTED = 'rejected';

    private int $id;
    private User $user;
    private Offer $offer;
    private ?string $message;
    private string $cv;
    private string $status;
    private DateTimeImmutable $createdAt;

    public function __construct(User $user, Offer $offer, ?string $message = null)
    {
        $this->user = $user;
        $this->offer = $offer;
        $this->message = $message;
        $this->status = self::STATUS_PENDING;
        $this->createdAt = new DateTimeImmutable();
    }

    public function __toString(): string
    {
        return $this->user->getName();
    }

    public function accept(): void
    {
        $this->status = self::STATUS_ACCEPTED;
    }

    public function reject(): void
    {
        $this->status = self::STATUS_REJECTED;
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

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getOffer(): Offer
    {
        return $this->offer;
    }

    public function setOffer(Offer $offer): self
    {
        $this->offer = $offer;
        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function getCv(): string
    {
        return $this->cv;
    }

    public function setCv(string $cv): self
    {
        $this->cv = $cv;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
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
}
