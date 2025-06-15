<?php

namespace App\UseCase\GetUsers;

use App\Domain\User\User;
use Illuminate\Support\Collection;

class GetUsersOutput
{
    /**
     * @param User[] $users
     */
    public function __construct(
        public readonly Collection $users
    ) {}
}