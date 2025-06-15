<?php

namespace App\Presentation;

use Core\Framework\Router;
use App\Presentation\Controller\Hello\HelloController;
use App\Presentation\Controller\User\UserController;

class RoutingDefinition
{
    public static function define(Router $router): void
    {
        $router->get('/', [HelloController::class, 'index']);
        $router->get('/{id}', [HelloController::class, 'show']);
        $router->get('/users', [UserController::class, 'index']);
        $router->get('/users/{id}', [UserController::class, 'show']);

    }
} 