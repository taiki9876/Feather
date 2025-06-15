<?php

namespace App\UseCase\GetUsers;

use App\Infrastructure\Repository\UserRepository;

class GetUsersUseCase
{
    public function __construct(
        private UserRepository $userRepository
    ) {}

    public function execute(GetUsersInput $input): GetUsersOutput
    {
        $users = $this->userRepository->findAll();
        
        return new GetUsersOutput($users);
    }
}