<?php

namespace App\Shared\User\Infrastructure\Repository;

use App\Shared\User\Domain\Repository\UserRepositoryInterface;
use App\Shared\User\Domain\Entity\User;

class UserRepository implements UserRepositoryInterface
{
    public function getUserByLogin(string $login): ?User
    {
        return null;
    }

    public function getUserByUid(string $uid): ?User
    {
        return null;
    }

    public function createUser(User $user): User
    {
        return new User('', '', '');
    }
}
