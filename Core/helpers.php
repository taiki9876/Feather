<?php

use Core\Framework\Debug;
use Illuminate\Support\Collection;

if (!function_exists('dd')) {
    /**
     * Dump and die - 変数の内容を出力して処理を停止
     */
    function dd(...$vars): void
    {
        Debug::dd(...$vars);
    }
}

if (!function_exists('dump')) {
    /**
     * Dump - 変数の内容を出力（処理は継続）
     */
    function dump(...$vars): void
    {
        Debug::dump(...$vars);
    }
} 

if (!function_exists('collect')) {
    /**
     * Create a collection from the given value.
     */
    function collect($value = null): Collection
    {
        return new Collection($value);
    }
}