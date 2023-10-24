<?php
declare(strict_types=1);

namespace App\Shared\User\Application\Query;

use App\Shared\User\Domain\Repository\PasswordRepositoryInterface;
use App\Shared\User\Domain\Repository\UserRepositoryInterface;
use App\Shared\User\Domain\Repository\UserTokenRepositoryInterface;
use App\Shared\User\ValueObject\UserToken;

final class UserTokenProduce
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UserTokenRepositoryInterface $tokenRepository,
        private PasswordRepositoryInterface $passwordRepository,
    ) {}

    /**
     * @throws UserTokenProduceException
     */
    public function produce(UserTokenProduceQuery $producerQuery): UserToken
    {
        $user = $this->userRepository->getUserByLogin($producerQuery->login);

        if (
            is_null($user) ||
            $this->passwordRepository->encode($producerQuery->password) !== $user->getPassword()
        ) {
            throw new UserTokenProduceException('There is no such user or the password is incorrect');
        }

        return $this->tokenRepository->makeToken($user);
    }
}
