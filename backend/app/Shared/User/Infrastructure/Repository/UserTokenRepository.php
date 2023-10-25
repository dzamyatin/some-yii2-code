<?php
declare(strict_types=1);

namespace App\Shared\User\Infrastructure\Repository;

use App\Shared\User\Domain\Repository\UserTokenRepositoryInterface;
use App\Shared\User\Domain\User;
use App\Shared\User\Domain\ValueObject\UserToken;

class UserTokenRepository implements UserTokenRepositoryInterface
{
    public function makeToken(User $user): string
    {
        return '';
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
