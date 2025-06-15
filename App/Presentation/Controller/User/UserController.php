<?php

namespace App\Presentation\Controller\User;

use Core\Framework\ReactView;
use App\UseCase\GetUsers\GetUsersInput;
use App\UseCase\GetUsers\GetUsersUseCase;
use App\UseCase\GetUserById\GetUserByIdInput;
use App\UseCase\GetUserById\GetUserByIdUseCase;

class UserController
{
    public function __construct(
        private GetUsersUseCase $getUsersUseCase,
        private GetUserByIdUseCase $getUserByIdUseCase
    ) {}

    public function index(): string
    {
        $input = new GetUsersInput();
        $output = $this->getUsersUseCase->execute($input);
        
        // Convert users to array format for SSR
        $users = $output->users->map(function($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'age' => $user->age,
                'isAdult' => $user->isAdult(),
                'createdAt' => $user->createdAt->format('Y-m-d'),
                'formattedCreatedAt' => $user->createdAt->format('Y年m月d日'),
                'displayName' => $user->getDisplayName(),
                'ageCategory' => $user->isAdult() ? '成人' : '未成年'
            ];
        });
        
        $meta = [
            'total' => $output->users->count(),
            'adultCount' => $output->users->filter(fn($user) => $user->isAdult())->count(),
            'minorCount' => $output->users->filter(fn($user) => !$user->isAdult())->count()
        ];
        
        return ReactView::render('Users/Index', [
            'users' => $users,
            'meta' => $meta
        ]);
    }

    public function show(string $id): string
    {
        $input = new GetUserByIdInput((int)$id);
        $output = $this->getUserByIdUseCase->execute($input);
        
        if ($output->user === null) {
            // 404 Not Found
            http_response_code(404);
            return ReactView::render('Users/NotFound', [
                'requestedId' => (int)$id
            ]);
        }
        
        // Convert user to array format for React
        $user = [
            'id' => $output->user->id,
            'name' => $output->user->name,
            'email' => $output->user->email,
            'age' => $output->user->age,
            'isAdult' => $output->user->isAdult(),
            'createdAt' => $output->user->createdAt->format('Y-m-d'),
            'formattedCreatedAt' => $output->user->createdAt->format('Y年m月d日'),
            'displayName' => $output->user->getDisplayName(),
            'ageCategory' => $output->user->isAdult() ? '成人' : '未成年'
        ];
        
        return ReactView::render('Users/Show', [
            'user' => $user
        ]);
    }
} 