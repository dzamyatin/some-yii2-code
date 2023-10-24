<?php

namespace App\Shared\User\Infrastructure\Repository;

use App\Shared\User\Domain\Repository\PasswordRepositoryInterface;

class PasswordRepository implements PasswordRepositoryInterface
{
    public function encode(string $rawPassword): string
    {
        return '';
    }
}
