<?php
declare(strict_types=1);

namespace App\Shared\Infrastructure\Repository;

use App\Shared\Domain\Repository\UserTokenRepositoryInterface;
use App\Shared\Domain\User;
use App\Shared\Domain\ValueObject\UserToken;

class UserTokenRepository implements UserTokenRepositoryInterface
{
    public function makeToken(User $user): UserToken
    {
        return new UserToken('');
    }

    public function checkRefreshToken(UserToken $token): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function decodeToken(string $token): UserToken
    {
        return new UserToken('');
    }
}
