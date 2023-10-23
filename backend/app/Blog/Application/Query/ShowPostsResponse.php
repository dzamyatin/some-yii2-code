<?php
declare(strict_types=1);

namespace App\Blog\Application\Query;

use App\Blog\Domain\Entity\Post;

final class ShowPostsResponse
{
    /**
     * @param Post[] $posts
     */
    public function __construct(public readonly array $posts)
    {}
}
