<?php

namespace Core\Framework;

class Config
{
    private static array $config = [];

    public static function load(string $path): void
    {
        if (file_exists($path)) {
            $config = require $path;
            if (is_array($config)) {
                self::$config = array_merge(self::$config, $config);
            }
        }
    }

    public static function get(string $key, $default = null)
    {
        $keys = explode('.', $key);
        $config = self::$config;

        foreach ($keys as $segment) {
            if (!isset($config[$segment])) {
                return $default;
            }
            $config = $config[$segment];
        }

        return $config;
    }

    public static function set(string $key, $value): void
    {
        $keys = explode('.', $key);
        $config = &self::$config;

        foreach ($keys as $i => $segment) {
            if ($i === count($keys) - 1) {
                $config[$segment] = $value;
            } else {
                if (!isset($config[$segment])) {
                    $config[$segment] = [];
                }
                $config = &$config[$segment];
            }
        }
    }
} 