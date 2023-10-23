<?php
declare(strict_types=1);

namespace App\Blog\Application\Query;

use App\Blog\Domain\Repositories\PostRequest;
use App\Blog\Domain\Repository\PostRepositoryInterface;

class ShowPosts
{
    public function __construct(private PostRepositoryInterface $postRepository)
    {}

    public function __invoke(ShowPostsQuery $postsQuery): ShowPostsResponse
    {
        return new ShowPostsResponse(
            $this->postRepository->getPosts(
                new PostRequest($postsQuery->offset, $postsQuery->limit)
            )
        );
    }
}
