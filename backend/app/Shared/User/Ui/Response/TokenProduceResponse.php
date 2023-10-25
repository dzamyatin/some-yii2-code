<?php
declare(strict_types=1);

namespace App\Shared\User\Ui\Response;

class TokenProduceResponse
{
    public function __construct(
        public readonly string $token
    ) {}
}
