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
use OpenApi\Attributes as OA;

#[OA\Info(version: "0.0.1", title: "Blog")]
#[OA\Server(url: 'https://localhost:8443')]
#[
    OA\SecurityScheme(
        securityScheme: 'user_auth',
        type: 'oauth2',
        flows: [
            new OA\Flow(
                tokenUrl: '/user/token',
                refreshUrl: '/user/refresh',
                flow: 'clientCredentials',
                scopes: [],
            )
        ],
    )
]
class BlogApi
{
    public function __construct(
        private PostCreate $postCreate,
        private PostDelete $postDelete,
        private PostUpdate $postUpdate,
        private PostsShow $postsShow
    ) {}

    #[
        OA\Get(
            path: '/blog',
            description: 'Show all posts',
            tags: ['Blog'],
            parameters: [
                new OA\Parameter(
                    name: 'offset',
                    in: 'query',
                    required: true,
                    schema: new OA\Schema(type: 'number'),
                    example: 0,
                ),
                new OA\Parameter(
                    name: 'limit',
                    in: 'query',
                    required: true,
                    schema: new OA\Schema(type: 'number'),
                    example: 10,
                ),
            ],
            responses: [
                new OA\Response(
                    response: 200,
                    description: 'Success',
                    content: new OA\JsonContent(
                        ref: '#/components/schemas/PostsShowResponse'
                    ),
                ),
            ],
        )
    ]
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

    #[
        OA\Post(
            path: '/blog',
            description: 'Create post',
            security: [
                ['user_auth' => []]
            ],
            requestBody: new OA\RequestBody(
                content: new OA\JsonContent(ref: '#/components/schemas/PostCreateRequest')
            ),
            tags: ['Blog'],
            responses: [
                new OA\Response(
                    response: 201,
                    description: 'Success',
                ),
            ],
        )
    ]
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

    #[
        OA\Put(
            path: '/blog/{postUid}',
            description: 'Update post',
            security: [
                ['user_auth' => []]
            ],
            requestBody: new OA\RequestBody(
                content: new OA\JsonContent(ref: '#/components/schemas/PostUpdateRequest')
            ),
            tags: ['Blog'],
            parameters: [
                new OA\Parameter(name: 'postUid', in: 'path', schema: new OA\Schema(type: 'string')),
            ],
            responses: [
                new OA\Response(
                    response: 200,
                    description: 'Success',
                ),
            ],
        )
    ]
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

    #[
        OA\Delete(
            path: '/blog/{postUid}',
            description: 'Delete post',
            security: [
                ['user_auth' => []]
            ],
            tags: ['Blog'],
            parameters: [
                new OA\Parameter(name: 'postUid', in: 'path', schema: new OA\Schema(type: 'string')),
            ],
            responses: [
                new OA\Response(
                    response: 200,
                    description: 'Success',
                ),
            ],
        )
    ]
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
