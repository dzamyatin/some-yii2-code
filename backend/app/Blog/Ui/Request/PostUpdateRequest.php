<?php
declare(strict_types=1);

namespace App\Blog\Ui\Request;

class PostUpdateRequest
{
    public function __construct(
        public readonly string $userToken,
        public readonly string $postUid,
        public readonly string $header,
        public readonly string $text
    ) {}
}
