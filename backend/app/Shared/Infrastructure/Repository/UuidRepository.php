<?php

namespace App\Shared\Infrastructure\Repository;

use App\Shared\Domain\Repository\UuidRepositoryInterface;
use Ramsey\Uuid\Uuid;

class UuidRepository implements UuidRepositoryInterface
{
    public function create(): string
    {
        return Uuid::uuid4();
    }
}
