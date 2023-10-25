<?php
declare(strict_types=1);

namespace App\Shared\User\Ui\Request;

class UserRegisterRequest
{
    public function __construct(
        public readonly string $login,
        public readonly string $password,
    ) {}
}
