<?php

namespace App\Providers;

use Core\Framework\ServiceProvider;
use App\UseCase\GetWelcomeData\GetWelcomeDataUseCase;
use App\UseCase\GetNumbers\GetNumbersUseCase;

class UseCaseServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // GetWelcomeDataUseCaseの登録
        $this->container->bind(GetWelcomeDataUseCase::class, function() {
            return new GetWelcomeDataUseCase();
        });

        // GetNumbersUseCaseの登録
        $this->container->bind(GetNumbersUseCase::class, function() {
            return new GetNumbersUseCase();
        });
    }
} 