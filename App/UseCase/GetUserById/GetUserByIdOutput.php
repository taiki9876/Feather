<?php

namespace App\UseCase\GetUserById;

use App\Domain\User\User;

class GetUserByIdOutput
{
    public function __construct(
        public readonly ?User $user
    ) {}
}