<?php
declare(strict_types=1);

namespace App\Blog\Ui\Response;

final class PostsShowResponse
{
    /**
     * @param PostResponse[] $posts
     */
    public function __construct(
        public readonly array $posts
    ) {}
}
