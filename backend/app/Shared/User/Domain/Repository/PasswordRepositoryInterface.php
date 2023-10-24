<?php

namespace App\Shared\User\Domain\Repository;

interface PasswordRepositoryInterface
{
    public function encode(string $rawPassword): string;
}
