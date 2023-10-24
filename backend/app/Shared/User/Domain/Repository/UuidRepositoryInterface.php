<?php

namespace App\Shared\User\Domain\Repository;

interface UuidRepositoryInterface
{
    public function create(): string;
}
