<?php
declare(strict_types=1);

namespace App\Shared\Application\Query;

final class UserTokenProduceQuery
{
    public function __construct(
        public readonly string $login,
        public readonly string $password,
    ) {}
}
