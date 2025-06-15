<?php

namespace App\UseCase\GetUserById;

use App\Infrastructure\Repository\UserRepository;

class GetUserByIdUseCase
{
    public function __construct(
        private UserRepository $userRepository
    ) {}

    public function execute(GetUserByIdInput $input): GetUserByIdOutput
    {
        $user = $this->userRepository->findById($input->id);
        
        return new GetUserByIdOutput($user);
    }
}