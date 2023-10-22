<?php

namespace App\Shared\Domain\Repository;

interface PasswordRepositoryInterface
{
    public function encode(string $rawPassword): string;
}
