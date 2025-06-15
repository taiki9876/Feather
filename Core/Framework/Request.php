<?php

namespace Core\Framework;

class Request
{
    private array $parameters = [];
    private array $headers = [];
    private string $method;
    private string $uri;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->headers = getallheaders();
        $this->parameters = array_merge($_GET, $_POST);
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getParameter(string $key, $default = null)
    {
        return $this->parameters[$key] ?? $default;
    }

    public function getHeader(string $key, $default = null)
    {
        return $this->headers[$key] ?? $default;
    }

    public function all(): array
    {
        return $this->parameters;
    }
} 