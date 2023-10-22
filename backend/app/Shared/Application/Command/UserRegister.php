<?php
declare(strict_types=1);

namespace App\Shared\Application\Command;

use App\Shared\Domain\Repository\UserRepositoryInterface;
use App\Shared\Domain\Repository\UuidRepositoryInterface;
use App\Shared\Domain\User;

final class UserRegister
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UuidRepositoryInterface $uuidRepository
    ) {}

    public function __invoke(UserRegisterCommand $userRegisterCommand): void
    {
        $user = new User(
            $this->uuidRepository->create(),
            $userRegisterCommand->name,
            $userRegisterCommand->password
        );

        $this->userRepository->createUser(
            $user
        );
    }
}
