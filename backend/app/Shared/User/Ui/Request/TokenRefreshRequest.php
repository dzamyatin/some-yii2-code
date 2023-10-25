<?php
declare(strict_types=1);

namespace App\Shared\User\Ui\Request;

class TokenRefreshRequest
{
    public function __construct(
        public readonly string $token
    ) {}
}
