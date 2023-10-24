<?php
declare(strict_types=1);

namespace App\Blog\Ui\Request;

final class PostsShowRequest
{
    public function __construct(
       public readonly int $offset,
       public readonly int $limit,
    ) {}
}
