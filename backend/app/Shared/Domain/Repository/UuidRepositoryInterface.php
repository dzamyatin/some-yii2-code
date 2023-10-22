<?php

namespace App\Shared\Domain\Repository;

interface UuidRepositoryInterface
{
    public function create(): string;
}
