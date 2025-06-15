<?php

namespace App\Infrastructure\Repository;

use App\Domain\User\User;
use Illuminate\Support\Collection;

class UserRepository
{
    /**
     * @return User[]
     */
    public function findAll(): Collection
    {
        return collect([
            new User(
                id: 1,
                name: 'Alice Johnson',
                email: 'alice@example.com',
                age: 25,
                createdAt: new \DateTime('2023-01-15')
            ),
            new User(
                id: 2,
                name: 'Bob Smith',
                email: 'bob@example.com',
                age: 17,
                createdAt: new \DateTime('2023-02-20')
            ),
            new User(
                id: 3,
                name: 'Charlie Brown',
                email: 'charlie@example.com',
                age: 30,
                createdAt: new \DateTime('2023-03-10')
            ),
            new User(
                id: 4,
                name: 'Diana Prince',
                email: 'diana@example.com',
                age: 28,
                createdAt: new \DateTime('2023-04-05')
            ),
        ]);
    }

    public function findById(int $id): ?User
    {
        $users = $this->findAll();
        
        foreach ($users as $user) {
            if ($user->id === $id) {
                return $user;
            }
        }
        
        return null;
    }

    /**
     * @return User[]
     */
    public function findAdults(): Collection
    {
        return $this->findAll()->filter(fn(User $user) => $user->isAdult());
    }

    /**
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        return $this->findAll()->firstWhere('email', $email);
    }
} 