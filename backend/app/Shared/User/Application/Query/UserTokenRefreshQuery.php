<?php
declare(strict_types=1);

namespace App\Shared\User\Application\Query;

final class UserTokenRefreshQuery
{
    public function __construct(
        public readonly string $userToken
    ) {}
}
