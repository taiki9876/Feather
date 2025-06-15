<?php

namespace App\Presentation\Controller\Hello;

use Core\Framework\BaseViewData;

class WelcomeViewData extends BaseViewData
{
    public function __construct(
        public readonly string $message,
        public readonly ?array $users = null,
        public readonly ?int $adult_count = null,
        public readonly ?array $numbers = null
    ) {}
} 