<?php
declare(strict_types=1);

namespace App\Shared\Application\Query;

final class UserTokenRefreshQuery
{
    public function __construct(
        public readonly string $userToken
    ) {}
}
