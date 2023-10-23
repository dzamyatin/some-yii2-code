<?php
declare(strict_types=1);

namespace App\Blog\Application\Command;

final class PostDeleteCommand
{
    public function __construct(
        private string $userToken,
        private string $postUid,
    ) {}

    /**
     * @return string
     */
    public function getUserToken(): string
    {
        return $this->userToken;
    }

    /**
     * @return string
     */
    public function getPostUid(): string
    {
        return $this->postUid;
    }
}
