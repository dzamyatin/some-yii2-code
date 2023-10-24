<?php

namespace App\Shared\User\Domain\Repository;

use App\Shared\User\Domain\User;

interface UserRepositoryInterface
{
    public function getUserByLogin(string $login): ?User;

    public function getUserByUid(string $uid): ?User;

    public function createUser(User $user): User;
}
