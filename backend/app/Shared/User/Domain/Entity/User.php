<?php
declare(strict_types=1);

namespace App\Shared\User\Domain;

final class User
{
    public function __construct(
        private string $uid,
        private string $login,
        private string $encodedPassword
    ) {}

    public function getUid(): string
    {
        return $this->uid;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getPassword(): string
    {
        return $this->encodedPassword;
    }
}
