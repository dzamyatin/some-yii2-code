<?php
declare(strict_types=1);

namespace App\Shared\User\Domain\Repository;

use App\Shared\User\Domain\User;
use App\Shared\User\Domain\ValueObject\UserToken;

interface UserTokenRepositoryInterface
{
    public function makeToken(User $user): UserToken;

    public function checkRefreshToken(UserToken $token): bool;

    /**
     * @param string $token
     * @return UserToken
     *
     * @throws UserTokenRepositoryException
     */
    public function decodeToken(string $token): UserToken;
}
