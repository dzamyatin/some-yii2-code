<?php
declare(strict_types=1);

namespace App\Shared\Domain\Repository;

use App\Shared\Domain\User;
use App\Shared\ValueObject\UserToken;

interface UserTokenRepositoryInterface
{
    public function makeToken(User $user): UserToken;
}
