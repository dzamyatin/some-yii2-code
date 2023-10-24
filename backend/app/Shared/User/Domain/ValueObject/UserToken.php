<?php
declare(strict_types=1);

namespace App\Shared\User\Domain\ValueObject;

final class UserToken
{
    public function __construct(public readonly string $userUid)
    {}
}
