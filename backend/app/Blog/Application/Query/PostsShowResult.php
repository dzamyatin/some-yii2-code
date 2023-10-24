<?php
declare(strict_types=1);

namespace App\Blog\Application\Query;

use App\Blog\Domain\Entity\Post;

final class PostsShowResult
{
    /**
     * @param Post[] $posts
     */
    public function __construct(public readonly array $posts)
    {}
}
