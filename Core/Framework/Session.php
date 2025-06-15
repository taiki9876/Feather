<?php

namespace Core\Framework;

class Session
{
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public static function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public static function clear(): void
    {
        session_destroy();
    }

    public static function flash(string $key, $value): void
    {
        self::set('_flash_' . $key, $value);
    }

    public static function getFlash(string $key, $default = null)
    {
        $value = self::get('_flash_' . $key, $default);
        self::remove('_flash_' . $key);
        return $value;
    }
} 