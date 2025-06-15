<?php

namespace Core\Framework;

abstract class Middleware
{
    abstract public function handle(Request $request, callable $next);
} 