<?php

namespace App\Blog\Domain\Repository;

use App\Blog\Domain\Entity\Post;
use App\Blog\Domain\Repositories\PostRequest;

interface PostRepositoryInterface
{
    public function getPosts(PostRequest $postRequest): array;

    public function createPost(Post $post): void;

    public function deletePost(string $postUid): void;

    public function getPost(string $postUid): ?Post;
}
