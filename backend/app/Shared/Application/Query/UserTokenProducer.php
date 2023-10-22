<?php
declare(strict_types=1);

namespace App\Shared\Application\Query;

use App\Shared\Domain\Repository\PasswordRepositoryInterface;
use App\Shared\Domain\Repository\UserRepositoryInterface;
use App\Shared\Domain\Repository\UserTokenRepositoryInterface;
use App\Shared\ValueObject\UserToken;

final class UserTokenProducer
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UserTokenRepositoryInterface $tokenRepository,
        private PasswordRepositoryInterface $passwordRepository,
    ) {}

    /**
     * @throws UserTokenProducerException
     */
    public function produce(UserTokenProducerQuery $producerQuery): UserToken
    {
        $user = $this->userRepository->getUserByLogin($producerQuery->login);

        if (
            is_null($user) ||
            $this->passwordRepository->encode($producerQuery->password) !== $user->getPassword()
        ) {
            throw new UserTokenProducerException('There is no such user or the password is incorrect');
        }

        return $this->tokenRepository->makeToken($user);
    }
}
