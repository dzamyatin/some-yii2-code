<?php

namespace App\Shared\Infrastructure\Repository;

use App\Shared\Domain\Repository\PasswordRepositoryInterface;

class PasswordRepository implements PasswordRepositoryInterface
{
    public function encode(string $rawPassword): string
    {
        return '';
    }
}
