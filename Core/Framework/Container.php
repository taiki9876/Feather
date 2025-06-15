<?php

namespace Core\Framework;

use ReflectionClass;

class Container
{
    private array $bindings = [];
    private array $instances = [];

    public function bind(string $abstract, $concrete): void
    {
        $this->bindings[$abstract] = $concrete;
    }

    public function resolve(string $abstract)
    {
        // 既にインスタンス化されている場合はそれを返す（シングルトン）
        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }

        // 手動でbindされている場合はそれを優先
        if (isset($this->bindings[$abstract])) {
            $concrete = $this->bindings[$abstract];

            if (is_callable($concrete)) {
                $instance = $concrete($this);
            } else {
                $instance = new $concrete();
            }

            $this->instances[$abstract] = $instance;
            return $instance;
        }

        // 自動解決を試行
        return $this->autoResolve($abstract);
    }

    private function autoResolve(string $className)
    {
        if (!class_exists($className)) {
            throw new \Exception("Class {$className} does not exist and no binding found");
        }

        $reflection = new ReflectionClass($className);

        if (!$reflection->isInstantiable()) {
            throw new \Exception("Class {$className} is not instantiable");
        }

        $constructor = $reflection->getConstructor();

        // コンストラクタがない場合は単純にインスタンス化
        if ($constructor === null) {
            $instance = new $className();
            $this->instances[$className] = $instance;
            return $instance;
        }

        // コンストラクタの依存関係を解決
        $parameters = $constructor->getParameters();
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $type = $parameter->getType();
            
            if ($type === null || $type->isBuiltin()) {
                // プリミティブ型の場合はデフォルト値があるかチェック
                if ($parameter->isDefaultValueAvailable()) {
                    $dependencies[] = $parameter->getDefaultValue();
                } else {
                    throw new \Exception("Cannot resolve primitive parameter {$parameter->getName()} for {$className}");
                }
            } else {
                // クラス型の場合は再帰的に解決
                $dependencies[] = $this->resolve($type->getName());
            }
        }

        $instance = new $className(...$dependencies);
        $this->instances[$className] = $instance;
        return $instance;
    }

    public function singleton(string $abstract, $concrete): void
    {
        $this->bind($abstract, $concrete);
    }

    public function instance(string $abstract, $instance): void
    {
        $this->instances[$abstract] = $instance;
    }
} 