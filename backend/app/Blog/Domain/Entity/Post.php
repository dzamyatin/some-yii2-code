<?php
declare(strict_types=1);

namespace App\Blog\Domain\Entity;

final class Post
{
    public function __construct(
        private string $uid,
        private string $userUid,
        private string $header,
        private string $text,
        private int $createdAt,
    ) {}

    public function getUid(): string
    {
        return $this->uid;
    }

    public function getUserUid(): string
    {
        return $this->userUid;
    }

    public function getHeader(): string
    {
        return $this->header;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }
}
