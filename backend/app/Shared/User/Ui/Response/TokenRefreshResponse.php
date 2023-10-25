<?php
declare(strict_types=1);

namespace App\Shared\User\Ui\Response;

class TokenRefreshResponse
{
    public function __construct(
        public readonly string $token
    ) {}
}
