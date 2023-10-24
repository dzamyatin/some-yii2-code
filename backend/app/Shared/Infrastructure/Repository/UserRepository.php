<?php

namespace App\Shared\Infrastructure\Repository;

use App\Shared\Domain\Repository\UserRepositoryInterface;
use App\Shared\Domain\User;

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
