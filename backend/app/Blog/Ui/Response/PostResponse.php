<?php
declare(strict_types=1);

namespace App\Blog\Ui\Response;

use OpenApi\Attributes as OA;

#[
    OA\Schema(
        schema: 'PostResponse',
        required: ['header', 'text'],
        properties: [
            new OA\Property(
                property: 'header',
                type: 'string',
                example: 'Header',
                nullable: false,
            ),
            new OA\Property(
                property: 'text',
                type: 'string',
                example: 'Text',
                nullable: false,
            ),
        ],
        type: 'object',
        nullable: false,
    )
]
final class PostResponse
{
    public function __construct(
        public readonly string $header,
        public readonly string $text
    ) {}
}
