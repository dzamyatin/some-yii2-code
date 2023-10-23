<?php

use App\Blog\Domain\Repositories\PostRequest;

interface PostRepositoryInterface
{
    public function getPosts(PostRequest $postRequest): array;
}
