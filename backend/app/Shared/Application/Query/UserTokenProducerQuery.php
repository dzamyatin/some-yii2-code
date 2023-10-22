<?php
declare(strict_types=1);

namespace App\Shared\Application\Query;

final class UserTokenProducerQuery
{
    public function __construct(
        public readonly string $login,
        public readonly string $password,
    ) {}
}
