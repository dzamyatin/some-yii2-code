<?php
declare(strict_types=1);

namespace App\Blog\Application\Query;

use App\Blog\Domain\Dto\PostRequest;
use App\Blog\Domain\Repository\PostRepositoryInterface;

class PostsShow
{
    public function __construct(private PostRepositoryInterface $postRepository)
    {}

    public function __invoke(PostsShowQuery $postsQuery): PostsShowResult
    {
        return new PostsShowResult(
            $this->postRepository->getPosts(
                new PostRequest($postsQuery->offset, $postsQuery->limit)
            )
        );
    }
}
