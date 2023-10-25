<?php
declare(strict_types=1);

namespace App\Blog\Ui\Response;

use OpenApi\Attributes as OA;

#[
    OA\Schema(
        schema: 'PostsShowResponse',
        required: ['posts'],
        properties: [
            new OA\Property(
                property: 'posts',
                type: 'array',
                items: new OA\Items(ref: '#/components/schemas/PostResponse')
            ),
        ],
        type: 'object',
    )
]
final class PostsShowResponse
{
    /**
     * @param PostResponse[] $posts
     */
    public function __construct(
        public readonly array $posts
    ) {}
}
