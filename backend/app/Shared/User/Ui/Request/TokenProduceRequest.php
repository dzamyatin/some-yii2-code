<?php
declare(strict_types=1);

namespace App\Shared\User\Ui\Request;

class TokenProduceRequest
{
    public function __construct(
        public readonly string $login,
        public readonly string $password,
    ) {}
}
