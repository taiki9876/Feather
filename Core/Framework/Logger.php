<?php

namespace Core\Framework;

class Logger
{
    public function info(string $message): void
    {
        $this->log('INFO', $message);
    }

    public function error(string $message): void
    {
        $this->log('ERROR', $message);
    }

    public function debug(string $message): void
    {
        $this->log('DEBUG', $message);
    }

    private function log(string $level, string $message): void
    {
        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[{$timestamp}] {$level}: {$message}" . PHP_EOL;
        echo $logMessage;
    }
} 