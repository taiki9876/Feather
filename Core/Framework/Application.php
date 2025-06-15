<?php

namespace Core\Framework;

class Application
{
    private Container $container;
    private array $serviceProviders = [];

    public function __construct()
    {
        $this->container = new Container();
    }

    public function getContainer(): Container
    {
        return $this->container;
    }

    public function registerServiceProvider(string $serviceProviderClass): void
    {
        $provider = new $serviceProviderClass($this->container);
        $provider->register();
        $this->serviceProviders[] = $provider;
    }

    public function registerServiceProviders(array $serviceProviderClasses): void
    {
        foreach ($serviceProviderClasses as $serviceProviderClass) {
            $this->registerServiceProvider($serviceProviderClass);
        }
    }

    public function boot(): void
    {
        // 必要に応じてbootstrap処理を追加
    }
} 