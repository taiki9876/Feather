<?php

namespace App\UseCase\GetUserById;

class GetUserByIdInput
{
    public function __construct(
        public readonly int $id
    ) {}
}