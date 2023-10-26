<?php
declare(strict_types=1);

namespace App\Shared\User\Application\Command;

use App\Shared\User\Domain\Repository\PasswordRepositoryInterface;
use App\Shared\User\Domain\Repository\UserRepositoryInterface;
use App\Shared\User\Domain\Repository\UuidRepositoryInterface;
use App\Shared\User\Domain\Entity\User;

final class UserRegister
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UuidRepositoryInterface $uuidRepository,
        private PasswordRepositoryInterface $passwordRepository,
    ) {}

    /**
     * @throws UserRegisterException
     */
    public function __invoke(UserRegisterCommand $userRegisterCommand): void
    {
        if ($userRegisterCommand->login === '' || $userRegisterCommand->password === '') {
            throw new UserRegisterException('Login and password should not be empty');
        }

        $user = new User(
            $this->uuidRepository->create(),
            $userRegisterCommand->login,
            $this->passwordRepository->encode($userRegisterCommand->password)
        );

        if ($this->userRepository->getUserByLogin($user->getLogin()) !== null) {
            throw new UserRegisterException('The user with the same login is already exist');
        }

        $this->userRepository->createUser(
            $user
        );
    }
}
