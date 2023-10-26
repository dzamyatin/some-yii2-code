<?php

namespace App\Shared\User\Infrastructure\Repository;

use App\Shared\User\Domain\Repository\PasswordRepositoryInterface;

class PasswordRepository implements PasswordRepositoryInterface
{
    public function encode(string $rawPassword): string
    {
        return password_hash($rawPassword, PASSWORD_BCRYPT);
    }

    public function check(string $rawPassword, string $encodedPassword): bool
    {
        return password_verify($rawPassword, $encodedPassword);
    }
}
