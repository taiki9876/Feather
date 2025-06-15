<?php

namespace App\Providers;

use Core\Framework\ServiceProvider;
use App\Presentation\Controller\Hello\HelloController;
use App\UseCase\GetWelcomeData\GetWelcomeDataUseCase;
use App\UseCase\GetNumbers\GetNumbersUseCase;

class ControllerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // HelloControllerの登録
        $this->container->bind(HelloController::class, function($container) {
            return new HelloController(
                $container->resolve(GetWelcomeDataUseCase::class),
                $container->resolve(GetNumbersUseCase::class)
            );
        });
    }
} 