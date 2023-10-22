<?php
declare(strict_types=1);

namespace App\Shared\Application\Command;

final class UserRegisterCommand
{
    public function __construct(
        public readonly string $name,
        public readonly string $password
    ) {}
}
