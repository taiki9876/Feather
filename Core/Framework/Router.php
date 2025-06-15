<?php

namespace Core\Framework;

class Router
{
    private array $routes = [];
    private ?Container $container = null;

    public function __construct(?Container $container = null)
    {
        $this->container = $container;
    }

    public function get(string $path, callable|array $handler): void
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, callable|array $handler): void
    {
        $this->routes['POST'][$path] = $handler;
    }

    public function dispatch(string $method, string $uri)
    {
        $method = strtoupper($method);
        
        if (!isset($this->routes[$method][$uri])) {
            // パラメータ付きのルートをチェック
            foreach ($this->routes[$method] as $route => $handler) {
                $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $route);
                $pattern = str_replace('/', '\/', $pattern);
                $pattern = '/^' . $pattern . '$/';

                if (preg_match($pattern, $uri, $matches)) {
                    array_shift($matches); // 最初の要素（完全一致）を削除
                    return $this->executeHandler($handler, $matches);
                }
            }
            
            throw new \Exception("Route not found: {$method} {$uri}");
        }

        return $this->executeHandler($this->routes[$method][$uri]);
    }

    private function executeHandler($handler, array $params = [])
    {
        if (is_callable($handler)) {
            return call_user_func_array($handler, $params);
        }

        if (is_array($handler)) {
            [$class, $method] = $handler;
            
            // DIコンテナがある場合は使用、なければ直接インスタンス化
            if ($this->container !== null) {
                try {
                    $instance = $this->container->resolve($class);
                } catch (\Exception $e) {
                    $instance = new $class();
                }
            } else {
                $instance = new $class();
            }
            
            return call_user_func_array([$instance, $method], $params);
        }

        throw new \Exception('Invalid route handler');
    }
} 