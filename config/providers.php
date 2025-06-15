<?php

return [
    'providers' => [
        // 手動登録（明示的で分かりやすい）
        // App\Providers\UseCaseServiceProvider::class,
        // App\Providers\ControllerServiceProvider::class,
        
        // 自動登録（開発速度重視）
        Core\Framework\AutoServiceProvider::class,
    ],
]; 