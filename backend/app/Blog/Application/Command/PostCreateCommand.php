<?php
declare(strict_types=1);

namespace App\Blog\Application\Command;

final class PostCreateCommand
{
    public function __construct(
        private string $userToken,
        private string $header,
        private string $text
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
