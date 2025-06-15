<?php

namespace Core\Framework;

class AutoServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // 特別な設定が必要なクラスのみ手動でbind
        // 他のクラスはContainer::resolve()で自動解決される
        
        // 例: 特定の設定でインスタンス化したい場合
        // $this->container->bind(SomeClass::class, function($container) {
        //     return new SomeClass('special_config');
        // });
        
        // デバッグ用ログ（開発環境のみ）
        if (Config::get('debug', false)) {
            error_log("AutoServiceProvider: Auto-resolution enabled. Classes will be resolved on-demand.");
        }
    }
} 