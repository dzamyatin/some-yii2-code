<?php
declare(strict_types=1);

namespace App\Blog\Domain\Entity;

class Post
{
    public function __construct(
        private string $uid,
        private string $userUid,
        private string $header,
        private string $text
    ) {}

    /**
     * @return string
     */
    public function getUid(): string
    {
        return $this->uid;
    }

    /**
     * @return string
     */
    public function getUserUid(): string
    {
        return $this->userUid;
    }

    /**
     * @return string
     */
    public function getHeader(): string
    {
        return $this->header;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }
}
