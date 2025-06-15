<?php

namespace App\Presentation\Controller\Hello;

use Core\Framework\ReactView;
use Core\Framework\View;

class HelloController
{

    public function index()
    {
        return View::make("welcome")->render();
    }

    public function show(string $id)
    {
        return ReactView::render(
            component: "Welcome",
            props: ["title" => "Hello, World!", "description" => "こんにちは世界さん{$id}"]
        );
    }
} 