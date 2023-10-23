<?php
declare(strict_types=1);

namespace App\Shared\Application\Query;

use App\Shared\Domain\Repository\UserRepositoryInterface;
use App\Shared\Domain\Repository\UserTokenRepositoryInterface;
use App\Shared\ValueObject\UserToken;
use App\Shared\Domain\Repository\UserTokenRepositoryException;

final class UserTokenRefresh
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UserTokenRepositoryInterface $tokenRepository,
    ) {}

    /**
     * @throws UserTokenRefreshException|UserTokenRepositoryException
     */
    public function produce(UserTokenRefreshQuery $producerQuery): UserToken
    {
        $token = $this->tokenRepository->decodeToken($producerQuery->userToken);

        if (!$this->tokenRepository->checkRefreshToken($token)) {
            throw new UserTokenRefreshException('Refresh token is invalid');
        }

        $user = $this->userRepository->getUserByUid($token->userUid);

        if (is_null($user)) {
            throw new UserTokenRefreshException('User is invalid');
        }

        return $this->tokenRepository->makeToken($user);
    }
}
