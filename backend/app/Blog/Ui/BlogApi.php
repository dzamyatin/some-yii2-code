<?php
declare(strict_types=1);

namespace App\Blog\Ui;

use App\Blog\Application\Command\PostCreate;
use App\Blog\Application\Command\PostCreateCommand;
use App\Blog\Application\Command\PostDelete;
use App\Blog\Application\Command\PostDeleteCommand;
use App\Blog\Application\Command\PostUpdate;
use App\Blog\Application\Command\PostUpdateCommand;
use App\Blog\Application\Query\PostsShow;
use App\Blog\Application\Query\PostsShowQuery;
use App\Blog\Domain\Entity\Post;
use App\Blog\Ui\Request\PostCreateRequest;
use App\Blog\Ui\Request\PostDeleteRequest;
use App\Blog\UI\Request\PostsShowRequest;
use App\Blog\Ui\Request\PostUpdateRequest;
use App\Blog\Ui\Response\PostResponse;
use App\Blog\Ui\Response\PostsShowResponse;

class BlogApi
{
    public function __construct(
        private PostCreate $postCreate,
        private PostDelete $postDelete,
        private PostUpdate $postUpdate,
        private PostsShow $postsShow
    ) {}

    public function postsShow(PostsShowRequest $postsShowRequest): PostsShowResponse
    {
        return new PostsShowResponse(
            array_map(
                fn(Post $post) => new PostResponse($post->getHeader(), $post->getText()),
                $this->postsShow->__invoke(
                    new PostsShowQuery($postsShowRequest->offset, $postsShowRequest->limit)
                )->posts
            )
        );
    }

    public function postCreate(PostCreateRequest $postCreateRequest): void
    {
        $this->postCreate->__invoke(
            new PostCreateCommand(
                $postCreateRequest->userToken,
                $postCreateRequest->header,
                $postCreateRequest->text
            )
        );
    }

    public function postUpdate(PostUpdateRequest $postUpdateRequest): void
    {
        $this->postUpdate->__invoke(
            new PostUpdateCommand(
                $postUpdateRequest->userToken,
                $postUpdateRequest->postUid,
                $postUpdateRequest->header,
                $postUpdateRequest->text
            )
        );
    }

    public function postDelete(PostDeleteRequest $postDeleteRequest): void
    {
        $this->postDelete->__invoke(
            new PostDeleteCommand(
                $postDeleteRequest->userToken,
                $postDeleteRequest->postUid
            )
        );
    }
}
