<?php

namespace App\Shared\User\Infrastructure\Repository;

use App\Shared\User\Domain\Repository\UuidRepositoryInterface;
use Ramsey\Uuid\Uuid;

class UuidRepository implements UuidRepositoryInterface
{
    public function create(): string
    {
        return Uuid::uuid4();
    }
}
