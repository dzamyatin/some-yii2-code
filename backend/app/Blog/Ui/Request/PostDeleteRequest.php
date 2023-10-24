<?php
declare(strict_types=1);

namespace App\Blog\Ui\Request;

class PostDeleteRequest
{
    public function __construct(
        public readonly string $userToken,
        public readonly string $postUid
    ) {}
}
