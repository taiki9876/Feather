<?php

namespace App\Domain\User;

class User
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $email,
        public readonly int $age,
        public readonly \DateTime $createdAt
    ) {}

    public function isAdult(): bool
    {
        return $this->age >= 18;
    }

    public function getDisplayName(): string
    {
        return $this->name;
    }
} 