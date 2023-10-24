<?php

namespace App\Blog\Infrastructure\Repository;

use App\Blog\Domain\Dto\PostRequest;
use App\Blog\Domain\Entity\Post;
use App\Blog\Domain\Repository\PostRepositoryInterface;

class PostRepository implements PostRepositoryInterface
{
    public function getPosts(PostRequest $postRequest): array
    {
        return [
            new Post(
                '123',
                'sss',
                'asd',
                'fasdas'
            )
        ];
    }

    public function createPost(Post $post): void
    {

    }

    public function deletePost(string $postUid): void
    {

    }

    public function getPost(string $postUid): ?Post
    {
        return new Post(
            '',
            '',
            '',
            ''
        );
    }
}
